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
 * Class xmarticle_field
 */
class xmarticle_field extends XoopsObject
{
    public $fieldtypes;
    
    
    // constructor
    /**
     * xmarticle_field constructor.
     */
    public function __construct()
    {
        $this->initVar('field_id', XOBJ_DTYPE_INT, null);
        $this->initVar('field_type', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_name', XOBJ_DTYPE_TXTBOX, null);
        $this->initVar('field_description', XOBJ_DTYPE_TXTAREA);
        $this->initVar('field_required', XOBJ_DTYPE_INT, 0); //0 = no, 1 = yes
        $this->initVar('field_weight', XOBJ_DTYPE_INT, 0);
        $this->initVar('field_default', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('field_search', XOBJ_DTYPE_INT, 0);
        $this->initVar('field_status', XOBJ_DTYPE_INT, 0);
        $this->initVar('field_sort', XOBJ_DTYPE_TXTBOX, null);
        $this->initVar('field_options', XOBJ_DTYPE_ARRAY, array());
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
        $field_type = new XoopsFormSelect(_MA_XMARTICLE_FIELD_TYPE, 'field_type', $this->getVar('field_type'));
        $field_arr = XmarticleUtility::fieldTypes();
        foreach ($field_arr as $key => $value) {
            $field_type->addOption($key, $value);
        }
        $form->addElement($field_type, true);   
        $form->addElement(new XoopsFormHidden('op', 'loadtype'));        
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        return $form;
    }
    
    /**
    * @param bool $action
    * @return XoopsThemeForm
    */
    public function getForm($field_type = '', $action = false)
    {
        $helper = \Xmf\Module\Helper::getHelper('xmarticle');
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $field_arr = XmarticleUtility::fieldTypes();
        //form title
        $title = $this->isNew() ? sprintf(_MA_XMARTICLE_ADD) : sprintf(_MA_XMARTICLE_EDIT);
        
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('field_id', $this->getVar('field_id')));
            $field_name = $field_arr[$this->getVar('field_type')];
            $field_type = $this->getVar('field_type');
            $weight = $this->getVar('field_weight');
            $search = $this->getVar('field_search');
            $required = $this->getVar('field_required');
            $status = $this->getVar('field_status');
            if ($field_type == 'select_multi' || $field_type == 'checkbox'){
                $default = unserialize($this->getVar('field_default', 'n'));
            }
        } else {
            $field_name = $field_arr[$field_type];
            $weight = $this->getVar('field_weight') ? $this->getVar('field_weight') : 0;
            $search = $this->getVar('field_search') ? $this->getVar('field_search') : 1;
            $required = $this->getVar('field_required') ? $this->getVar('field_required') : 1;
            $status = $this->getVar('field_status') ? $this->getVar('field_status') : 1;
            $default = array();
        }
        // type
        $form->addElement(new xoopsFormLabel (_MA_XMARTICLE_FIELD_TYPE, $field_name));

        // name
        $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_NAME, 'field_name', 50, 255, $this->getVar('field_name')), true);
        
        // description
        $editor_configs           =array();
        $editor_configs['name']   = 'field_description';
        $editor_configs['value']  = $this->getVar('field_description', 'e');
        $editor_configs['rows']   = 2;
        $editor_configs['editor'] = 'Plain Text';
        $form->addElement(new XoopsFormEditor(_MA_XMARTICLE_FIELD_DESC, 'field_description', $editor_configs), false);
        
        // options
        switch ($field_type) {
            case 'select':
            case 'select_multi':
            case 'radio':
            case 'checkbox':
                $options = $this->getVar('field_options');
                $count_options = count($options);
                if ($count_options > 0){
                    $i = 0;
                    foreach (array_keys($options) as $key) {
                        $addOption[$i]['value'] = $options[$key];
                        $addOption[$i]['key'] = $key;
                        $i++;
                    }
                }
                $option_text = "<table  cellspacing='1'><tr><td class='width20'>" . _MA_XMARTICLE_FIELD_KEY . "</td><td class='width40'>" . _MA_XMARTICLE_FIELD_VALUE . "</td><td>" . _MA_XMARTICLE_FIELD_DEFAULT . "</td>";
                if (!$this->isNew()) {
                    $option_text .= "<td>" . _MA_XMARTICLE_FIELD_REMOVE . "</td>";
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
                    if ($field_type == 'select_multi' || $field_type == 'checkbox'){
                        $checked = '';
                        if (!empty($default)){
                            if (in_array($value, $default)){
                                $checked = 'checked';
                            }
                        }
                        $option_text .= "<td><INPUT type= 'checkbox' name='field_default[]' value='{$i}' " . $checked . "></td>";
                    } else{
                        $checked = '';
                        if ($this->getVar('field_default') == $value && $this->getVar('field_default') != ''){
                            $checked = 'checked';
                        }
                        $option_text .= "<td><INPUT type= 'radio' name='field_default' value='{$i}' " . $checked . "></td>";
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
                $option_text .= "<label><input type='checkbox' name='addmoreoptions' value='True'>" . _MA_XMARTICLE_FIELD_ADDMOREOPTIONS . "</label>";
                $form->addElement(new XoopsFormLabel(_MA_XMARTICLE_FIELD_ADDOPTION, $option_text), true);
                // sort
                $sort = new XoopsFormSelect(_MA_XMARTICLE_FIELD_SORT, 'field_sort', $this->getVar('field_sort'));
                $sort_arr = array('DEF' => _MA_XMARTICLE_FIELD_SORTDEF,'VLH' => _MA_XMARTICLE_FIELD_SORTVLH, 'VHL' => _MA_XMARTICLE_FIELD_SORTVHL, 'KLH' => _MA_XMARTICLE_FIELD_SORTKLH, 'KHL' => _MA_XMARTICLE_FIELD_SORTKHL);
                $sort->addOptionArray($sort_arr);
                $form->addElement($sort, true);
                break;
        }
        // default
        switch ($field_type) {
            case 'label':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_DEFAULT, 'field_default', 50, 255, $this->getVar('field_default')), true);
                break;
            case 'vs_text':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_DEFAULT, 'field_default', 50, 25, $this->getVar('field_default')));
                break;
            case 's_text':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_DEFAULT, 'field_default', 50, 50, $this->getVar('field_default')));
                break;
            case 'm_text':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_DEFAULT, 'field_default', 50, 100, $this->getVar('field_default')));
                break;
            case 'l_text':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_DEFAULT, 'field_default', 50, 255, $this->getVar('field_default')));
                break;
            case 'text':
                $editor_configs           =array();
                $editor_configs['name']   = 'field_default';
                $editor_configs['value']  = $this->getVar('field_default', 'e');
                $editor_configs['rows']   = 2;
                $editor_configs['editor'] = 'Plain Text';
                $form->addElement(new XoopsFormEditor(_MA_XMARTICLE_FIELD_DEFAULT, 'field_default', $editor_configs), false);
                break;
            case 'radio_yn':
                $form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_FIELD_DEFAULT, 'field_default', $this->getVar('field_default')));
                break;
            case 'number':
                $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_DEFAULT, 'field_default', 15, 50, $this->getVar('field_default')));
                break;
        }  

        // weight        
        $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_WEIGHT, 'field_weight', 5, 5, $weight), true);
        
        // search
        $form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_FIELD_SEARCH, 'field_search', $search));
        
        // required
        $form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_FIELD_REQUIRED, 'field_required', $required));

        // status        
        $form_status = new XoopsFormRadio(_MA_XMARTICLE_STATUS, 'field_status', $status);
        $options = array(1 => _MA_XMARTICLE_STATUS_A, 0 =>_MA_XMARTICLE_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);

        $form->addElement(new XoopsFormHidden('field_type', $field_type));
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
    public function saveField($fieldHandler, $action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $error_message = '';        
        // test error
        if ((int)$_REQUEST['field_weight'] == 0 && $_REQUEST['field_weight'] != '0') {
            $error_message .= _MA_XMARTICLE_ERROR_WEIGHT . '<br>';
            $this->setVar('field_weight', 0);
        }
        $field_type = Xmf\Request::getString('field_type', '');
        if ($field_type == ''){
            redirect_header($action, 2, _MA_XMARTICLE_ERROR_FIELDNOTCONFIGURABLE);
        }        
        $this->setVar('field_type', $field_type);
        $this->setVar('field_name', Xmf\Request::getString('field_name', ''));
        $this->setVar('field_description',  Xmf\Request::getText('field_description', ''));
        $this->setVar('field_required', Xmf\Request::getInt('field_required', 1));
        $this->setVar('field_search', Xmf\Request::getInt('field_search', 1));
        $this->setVar('field_status', Xmf\Request::getInt('field_status', 1));
        
        switch ($field_type) {
            case 'label':
            case 'vs_text':
            case 's_text':
            case 'm_text':
            case 'l_text':
            case 'text':
            case 'radio_yn':
            case 'number':
                $this->setVar('field_default', Xmf\Request::getString('field_default', ''));
                break;            
            case 'text':
                $this->setVar('field_default', Xmf\Request::getText('field_default', ''));
                break;
            case 'select':
            case 'select_multi':
            case 'radio':
            case 'checkbox':
                $options = $this->getVar('field_options');
                $default = array();
                // add options and default
                if (!empty($_REQUEST['addOption'])) {
                    $i = 0;
                    if ($field_type == 'select_multi' || $field_type == 'checkbox'){
                        $field_default = Xmf\Request::getArray('field_default', array());
                    } else {
                        $field_default = Xmf\Request::getInt('field_default', -1);
                    }
                    foreach ($_REQUEST['addOption'] as $option) {
                        if (empty($option['value'])) {
                            continue;
                        }
                        $options[$option['key']] = $option['value'];
                        if ($field_type == 'select_multi' || $field_type == 'checkbox'){
                            if (in_array($i, $field_default)){
                                $default[$option['key']] = $option['value'];
                            }
                        }else{
                            if ($field_default == $i){
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
                $field_sort = Xmf\Request::getString('field_sort', 'DEF');
                switch ($field_sort) {
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
                $this->setVar('field_sort', $field_sort);
                // save field_options
                $this->setVar('field_options', $options);
                // save field_default
                if ($field_type == 'select_multi' || $field_type == 'checkbox'){
                    if (!empty($default)){
                        $this->setVar('field_default', serialize($default));
                    } else{
                        $this->setVar('field_default', '');
                    }
                }else{
                    if (!empty($default)){
                        $this->setVar('field_default', $default[$save_key]);
                    } else{
                        $this->setVar('field_default', '');
                    }
                }
                break;
        }
        if ($error_message == '') {
            $this->setVar('field_weight', Xmf\Request::getInt('field_weight', 0));
            if ($fieldHandler->insert($this)) {
                if ((Xmf\Request::getBool('addmoreoptions', false)) === true){
                    redirect_header($action . '?op=edit&amp;field_id=' . $this->getVar('field_id'), 2, _MA_XMARTICLE_REDIRECT_SAVE);
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
 * Class xmarticlexmarticle_fieldHandler
 */
class xmarticlexmarticle_fieldHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmarticlexmarticle_fieldHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct(&$db)
    {
        parent::__construct($db, 'xmarticle_field', 'xmarticle_field', 'field_id', 'field_name');
    }
}
