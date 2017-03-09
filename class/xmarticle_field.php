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
        $this->initVar('field_maxlength', XOBJ_DTYPE_INT, 0);
        $this->initVar('field_default', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('field_search', XOBJ_DTYPE_INT, 0);
        $this->initVar('field_status', XOBJ_DTYPE_INT, 0);
        $this->initVar('field_options', XOBJ_DTYPE_ARRAY, array());
    }
    /**
     * @return mixed
     */
    public function get_fieldtypes()
    {
        $this->fieldtypes = array(
            'label'        => _MA_XMARTICLE_FIELDTYPE_LABEL,
            'vstext'       => _MA_XMARTICLE_FIELDTYPE_VSTEXT);
        return $this->fieldtypes;
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
        $form = new XoopsThemeForm(_MA_XMARTICLE_ADD, 'form', $action, 'post', true);
        // type        
        $field_type = new XoopsFormSelect(_MA_XMARTICLE_FIELD_TYPE, 'field_type', $this->getVar('field_type'));
        $field_arr = $this->get_fieldtypes();
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
        //logo
        $uploadirectory = '/xmarticle/images/field';
        if ($_FILES['field_logo']['error'] != UPLOAD_ERR_NO_FILE) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploader_field_img = new XoopsMediaUploader(XOOPS_UPLOAD_PATH . $uploadirectory, array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'), $upload_size, null, null);
            if ($uploader_field_img->fetchMedia('field_logo')) {
                $uploader_field_img->setPrefix('field_');
                if (!$uploader_field_img->upload()) {
                    $error_message .= $uploader_field_img->getErrors() . '<br />';
                } else {
                    $this->setVar('field_logo', $uploader_field_img->getSavedFileName());
                }
            } else {
                $error_message .= $uploader_field_img->getErrors();
            }
        } else {
            $this->setVar('field_logo', Xmf\Request::getString('field_logo', ''));
        }
        $this->setVar('field_name', Xmf\Request::getString('field_name', ''));
        $this->setVar('field_reference',  Xmf\Request::getString('field_reference', ''));
        $this->setVar('field_description',  Xmf\Request::getText('field_description', ''));        
        $this->setVar('field_status', Xmf\Request::getInt('field_status', 1));
        if ($error_message == '') {
            $this->setVar('field_weight', Xmf\Request::getInt('field_weight', 0));
            if ($fieldHandler->insert($this)) {
                redirect_header($action, 2, _MA_XMARTICLE);
            } else {
                $error_message =  $this->getHtmlErrors();
            }
        }
        return $error_message;
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
        
        //form title
        $title = $this->isNew() ? sprintf(_MA_XMARTICLE_ADD) : sprintf(_MA_XMARTICLE_EDIT);
        
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('field_id', $this->getVar('field_id')));
            $status = $this->getVar('field_status');
            $weight = $this->getVar('field_weight');
            $field_type = $this->getVar('field_type');
        } else {
            $status = 1;
            $weight = 0;
        }
        // type
        $form->addElement(new xoopsFormLabel (_MA_XMARTICLE_FIELD_TYPE, $field_type));

        // name
        $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_NAME, 'field_name', 50, 255, $this->getVar('field_name')), true);
        
        // description
        $editor_configs           =array();
        $editor_configs['name']   = 'field_description';
        $editor_configs['value']  = $this->getVar('field_description', 'e');
        $editor_configs['rows']   = 10;
        $editor_configs['cols']   = 160;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = 'Plain Text';
        $form->addElement(new XoopsFormEditor(_MA_XMARTICLE_FIELD_DESC, 'field_description', $editor_configs), false);

        // weight
        $form->addElement(new XoopsFormText(_MA_XMARTICLE_FIELD_WEIGHT, 'field_weight', 5, 5, $weight), true);

        // status
        $form_status = new XoopsFormRadio(_MA_XMARTICLE_STATUS, 'field_status', $status);
        $options = array(1 => _MA_XMARTICLE_STATUS_A, 0 =>_MA_XMARTICLE_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);

        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submitt
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
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
