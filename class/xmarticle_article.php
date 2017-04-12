<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmarticle module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Class xmarticle_article
 */
class xmarticle_article extends XoopsObject
{   
    
    // constructor
    /**
     * xmarticle_article constructor.
     */
    public function __construct()
    {
        $this->initVar('article_id', XOBJ_DTYPE_INT, null);
        $this->initVar('article_cid', XOBJ_DTYPE_INT, null);
        $this->initVar('article_reference', XOBJ_DTYPE_TXTBOX, null);
        $this->initVar('article_name', XOBJ_DTYPE_TXTBOX, null);        
        $this->initVar('article_description', XOBJ_DTYPE_TXTAREA);
        $this->initVar('article_logo', XOBJ_DTYPE_TXTBOX, null);
        $this->initVar('article_status', XOBJ_DTYPE_INT, 0);
    }

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getFormTypes($action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';   
        
        $form = new XoopsThemeForm(_MA_XMARTICLE_ADD, 'form', $action, 'post', true);
        // type        
        $article_type = new XoopsFormSelect(_MA_XMARTICLE_article_TYPE, 'article_type', $this->getVar('article_type'));
        $article_arr = $this->get_articletypes();
        foreach ($article_arr as $key => $value) {
            $article_type->addOption($key, $value);
        }
        $form->addElement($article_type, true);   
        $form->addElement(new XoopsFormHidden('op', 'loadtype'));        
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        return $form;
    }
    
    /**
    * @param bool $action
    * @return XoopsThemeForm
    */
    public function getForm($article_type = '', $action = false)
    {
        $helper = \Xmf\Module\Helper::getHelper('xmarticle');
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $article_arr = $this->get_articletypes();
        //form title
        $title = $this->isNew() ? sprintf(_MA_XMARTICLE_ADD) : sprintf(_MA_XMARTICLE_EDIT);
        
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('article_id', $this->getVar('article_id')));
            $article_name = $article_arr[$this->getVar('article_type')];
            $article_type = $this->getVar('article_type');
            $weight = $this->getVar('article_weight');
            $search = $this->getVar('article_search');
            $required = $this->getVar('article_required');
            $status = $this->getVar('article_status');
            if ($article_type == 'select_multi' || $article_type == 'checkbox'){
                $default = unserialize($this->getVar('article_default', 'n'));
            }
        } else {
            $article_name = $article_arr[$article_type];
            $weight = $this->getVar('article_weight') ? $this->getVar('article_weight') : 0;
            $search = $this->getVar('article_search') ? $this->getVar('article_search') : 1;
            $required = $this->getVar('article_required') ? $this->getVar('article_required') : 1;
            $status = $this->getVar('article_status') ? $this->getVar('article_status') : 1;
            $default = array();
        }
        // type
        $form->addElement(new xoopsFormLabel (_MA_XMARTICLE_article_TYPE, $article_name));

        // name
        $form->addElement(new XoopsFormText(_MA_XMARTICLE_article_NAME, 'article_name', 50, 255, $this->getVar('article_name')), true);
        
        // description
        $editor_configs           =array();
        $editor_configs['name']   = 'article_description';
        $editor_configs['value']  = $this->getVar('article_description', 'e');
        $editor_configs['rows']   = 2;
        $editor_configs['editor'] = 'Plain Text';
        $form->addElement(new XoopsFormEditor(_MA_XMARTICLE_article_DESC, 'article_description', $editor_configs), false);
        
        // options
        switch ($article_type) {
            case 'select':
            case 'select_multi':
            case 'radio':
            case 'checkbox':
                $options = $this->getVar('article_options');
                $count_options = count($options);
                if ($count_options > 0){
                    $i = 0;
                    foreach (array_keys($options) as $key) {
                        $addOption[$i]['value'] = $options[$key];
                        $addOption[$i]['key'] = $key;
                        $i++;
                    }
                }
                $option_text = "<table  cellspacing='1'><tr><td class='width20'>" . _MA_XMARTICLE_article_KEY . "</td><td class='width40'>" . _MA_XMARTICLE_article_VALUE . "</td><td>" . _MA_XMARTICLE_article_DEFAULT . "</td>";
                if (!$this->isNew()) {
                    $option_text .= "<td>" . _MA_XMARTICLE_article_REMOVE . "</td>";
                }
                $option_text .= "</tr>";
                for ($i = 0; $i < ($count_options + 10); ++$i) {
                    if ($i >= $count_options){
                        $key = '';
                        $value = '';
                    } else {
                        $key = $addOption[$i]['key'];
                        $value = $addOption[$i]['value'];
                    }                   
                    $option_text .= "<tr><td><input type='text' name='addOption[{$i}][key]' id='addOption[{$i}][key]' value='" . $key . "' size='15' /></td>";
                    $option_text .= "<td><input type='text' name='addOption[{$i}][value]' id='addOption[{$i}][value]' value='" . $value . "' size='35' /></td>";
                    if ($article_type == 'select_multi' || $article_type == 'checkbox'){
                        $checked = '';
                        if (!empty($default)){
                            if (in_array($value, $default)){
                                $checked = 'checked';
                            }
                        }
                        $option_text .= "<td><INPUT type= 'checkbox' name='article_default[]' value='{$i}' " . $checked . "></td>";
                    } else{
                        $checked = '';
                        if ($this->getVar('article_default') == $value && $this->getVar('article_default') != ''){
                            $checked = 'checked';
                        }
                        $option_text .= "<td><INPUT type= 'radio' name='article_default' value='{$i}' " . $checked . "></td>";
                    }
                    if (!$this->isNew()) {
                        if ($key == ''){
                            $option_text .= "<td>&nbsp;</td>";
                        }else{
                            $option_text .= "<td><INPUT type= 'checkbox' name='removeOptions[]' value='{$key}'></td>";
                        }                        
                        $option_text .= "</tr><tr height='3px'><td colspan='4'> </td></tr>";
                    }else{
                        $option_text .= "</tr><tr height='3px'><td colspan='3'> </td></tr>";
                    }
                }
                $option_text .= "</table>";
                $option_text .= "<label><input type='checkbox' name='addmoreoptions' value='True'>" . _MA_XMARTICLE_article_ADDMOREOPTIONS . "</label>";
                $form->addElement(new XoopsFormLabel(_MA_XMARTICLE_article_ADDOPTION, $option_text), true);
                // sort
                $sort = new XoopsFormSelect(_MA_XMARTICLE_article_SORT, 'article_sort', $this->getVar('article_sort'));
                $sort_arr = array('DEF' => _MA_XMARTICLE_article_SORTDEF,'VLH' => _MA_XMARTICLE_article_SORTVLH, 'VHL' => _MA_XMARTICLE_article_SORTVHL, 'KLH' => _MA_XMARTICLE_article_SORTKLH, 'KHL' => _MA_XMARTICLE_article_SORTKHL);
                $sort->addOptionArray($sort_arr);
                $form->addElement($sort, true);
                break;
        }
        // default
        switch ($article_type) {
            case 'label':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_article_DEFAULT, 'article_default', 50, 255, $this->getVar('article_default')), true);
                break;
            case 'vs_text':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_article_DEFAULT, 'article_default', 50, 25, $this->getVar('article_default')));
                break;
            case 's_text':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_article_DEFAULT, 'article_default', 50, 50, $this->getVar('article_default')));
                break;
            case 'm_text':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_article_DEFAULT, 'article_default', 50, 100, $this->getVar('article_default')));
                break;
            case 'l_text':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_article_DEFAULT, 'article_default', 50, 255, $this->getVar('article_default')));
                break;
            case 'text':
                $editor_configs           =array();
                $editor_configs['name']   = 'article_default';
                $editor_configs['value']  = $this->getVar('article_default', 'e');
                $editor_configs['rows']   = 2;
                $editor_configs['editor'] = 'Plain Text';
                $form->addElement(new XoopsFormEditor(_MA_XMARTICLE_article_DEFAULT, 'article_default', $editor_configs), false);
                break;
            case 'radio_yn':
                $form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_article_DEFAULT, 'article_default', $this->getVar('article_default')));
                break;
            case 'number':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_article_DEFAULT, 'article_default', 15, 50, $this->getVar('article_default')));
                break;
        }  

        // weight        
        $form->addElement(new XoopsFormText(_MA_XMARTICLE_article_WEIGHT, 'article_weight', 5, 5, $weight), true);
        
        // search
        $form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_article_SEARCH, 'article_search', $search));
        
        // required
        $form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_article_REQUIRED, 'article_required', $required));

        // status        
        $form_status = new XoopsFormRadio(_MA_XMARTICLE_STATUS, 'article_status', $status);
        $options = array(1 => _MA_XMARTICLE_STATUS_A, 0 =>_MA_XMARTICLE_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);

        $form->addElement(new XoopsFormHidden('article_type', $article_type));
        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }

    /**
     * @return mixed
     */
    public function get_new_enreg()
    {
        global $xoopsDB;
        $new_enreg = $xoopsDB->getInsertId();
        return $new_enreg;
    }
    
    /**
     * @return mixed
     */
    public function savearticle($articleHandler, $action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $error_message = '';        
        // test error
        if ((int)$_REQUEST['article_weight'] == 0 && $_REQUEST['article_weight'] != '0') {
            $error_message .= _MA_XMARTICLE_ERROR_WEIGHT . '<br>';
            $this->setVar('article_weight', 0);
        }
        $article_type = Xmf\Request::getString('article_type', '');
        if ($article_type == ''){
            redirect_header($action, 2, _MA_XMARTICLE_ERROR_articleNOTCONFIGURABLE);
        }        
        $this->setVar('article_type', $article_type);
        $this->setVar('article_name', Xmf\Request::getString('article_name', ''));
        $this->setVar('article_description',  Xmf\Request::getText('article_description', ''));
        $this->setVar('article_required', Xmf\Request::getInt('article_required', 1));
        $this->setVar('article_search', Xmf\Request::getInt('article_search', 1));
        $this->setVar('article_status', Xmf\Request::getInt('article_status', 1));
        
        switch ($article_type) {
            case 'label':
            case 'vs_text':
            case 's_text':
            case 'm_text':
            case 'l_text':
            case 'text':
            case 'radio_yn':
            case 'number':
                $this->setVar('article_default', Xmf\Request::getString('article_default', ''));
                break;            
            case 'text':
                $this->setVar('article_default', Xmf\Request::getText('article_default', ''));
                break;
            case 'select':
            case 'select_multi':
            case 'radio':
            case 'checkbox':
                $options = $this->getVar('article_options');
                $default = array();
                // add options and default
                if (!empty($_REQUEST['addOption'])) {
                    $i = 0;
                    if ($article_type == 'select_multi' || $article_type == 'checkbox'){
                        $article_default = Xmf\Request::getArray('article_default', array());
                    } else {
                        $article_default = Xmf\Request::getInt('article_default', -1);
                    }
                    foreach ($_REQUEST['addOption'] as $option) {
                        if (empty($option['value'])) {
                            continue;
                        }
                        $options[$option['key']] = $option['value'];
                        if ($article_type == 'select_multi' || $article_type == 'checkbox'){
                            if (in_array($i, $article_default)){
                                $default[$option['key']] = $option['value'];
                            }
                        }else{
                            if ($article_default == $i){
                                $default[$option['key']] = $option['value'];
                                $save_key = $option['key'];
                            }
                        }
                        $i++;
                        
                    }
                }
                // remove
                if (isset($_REQUEST['removeOptions']) && is_array($_REQUEST['removeOptions'])) {
                    foreach ($_REQUEST['removeOptions'] as $index) {
                        unset($options[$index]);
                        unset($default[$index]);
                    }
                }
                // save sort
                $article_sort = Xmf\Request::getString('article_sort', 'DEF');
                switch ($article_sort) {
                    case 'VLH':
                        asort($options);
                        break;
                    case 'VHL':
                        arsort($options);
                        break;
                    case 'KLH':
                        ksort($options);
                        break;
                    case 'KHL':
                        krsort($options);
                        break;                    
                }
                $this->setVar('article_sort', $article_sort);
                // save article_options
                $this->setVar('article_options', $options);
                // save article_default
                if ($article_type == 'select_multi' || $article_type == 'checkbox'){
                    if (!empty($default)){
                        $this->setVar('article_default', serialize($default));
                    } else{
                        $this->setVar('article_default', '');
                    }
                }else{
                    if (!empty($default)){
                        $this->setVar('article_default', $default[$save_key]);
                    } else{
                        $this->setVar('article_default', '');
                    }
                }
                break;
        }
        if ($error_message == '') {
            $this->setVar('article_weight', Xmf\Request::getInt('article_weight', 0));
            if ($articleHandler->insert($this)) {
                if ((Xmf\Request::getBool('addmoreoptions', false)) === true){
                    redirect_header($action . '?op=edit&amp;article_id=' . $this->getVar('article_id'), 2, _MA_XMARTICLE_REDIRECT_SAVE);
                } else {
                    redirect_header($action, 2, _MA_XMARTICLE_REDIRECT_SAVE);
                }
                
            } else {
                $error_message =  $this->getHtmlErrors();
            }
        }
        return $error_message;
    }


}

/**
 * Class xmarticlexmarticle_articleHandler
 */
class xmarticlexmarticle_articleHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmarticlexmarticle_articleHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct(&$db)
    {
        parent::__construct($db, 'xmarticle_article', 'xmarticle_article', 'article_id', 'article_name');
    }
}
