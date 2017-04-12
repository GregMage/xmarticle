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
use Xmf\Module\Admin;
use Xmf\Request;


require dirname(__FILE__) . '/admin_header.php';
$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('field.php');

// Get Action type
$op = Request::getCmd('op', 'list');
switch ($op) {
    case 'list':
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        $xoTheme->addScript('modules/system/js/admin.js');
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_FIELD_ADD, 'field.php?op=add', 'add');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Get start pager
        $start = Request::getInt('start', 0);
        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->setSort('field_weight ASC, field_name');
        $criteria->setOrder('ASC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
        $field_arr = $fieldHandler->getall($criteria);
        $field_count = $fieldHandler->getCount($criteria);
        $xoopsTpl->assign('field_count', $field_count);
        $field_type_arr = XmarticleUtility::fieldTypes();
        if ($field_count > 0) {
            foreach (array_keys($field_arr) as $i) {
                $field_id                 = $field_arr[$i]->getVar('field_id');
                $field['id']              = $field_id;
                $field['type']            = $field_type_arr[$field_arr[$i]->getVar('field_type')];
                $field['name']            = $field_arr[$i]->getVar('field_name');
                $field['description']     = $field_arr[$i]->getVar('field_description');
                $field['weight']          = $field_arr[$i]->getVar('field_weight');
                $field['required']        = $field_arr[$i]->getVar('field_required');
                $field['search']          = $field_arr[$i]->getVar('field_search');                
                $field['status']          = $field_arr[$i]->getVar('field_status');
                $xoopsTpl->append_by_ref('field', $field);
                unset($field);
            }
            // Display Page Navigation
            if ($field_count > $nb_limit) {
                $nav = new XoopsPageNav($field_count, $nb_limit, $start, 'start');
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOFIELD);
        }
        break;
    
    // Add
    case 'add':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_FIELD_LIST, 'field.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Form
        $obj  = $fieldHandler->create();
        $form = $obj->getFormTypes();
        $xoopsTpl->assign('form', $form->render());
        break;
        
    // Loadtype
    case 'loadtype':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_FIELD_LIST, 'field.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());  
        $field_type = Request::getString('field_type', '');
        if ($field_type == '') {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOFIELDTYPE);
        } else {
            $obj  = $fieldHandler->create();
            $form = $obj->getForm($field_type);
            $xoopsTpl->assign('form', $form->render());
        }
        break;
        
    // Edit
    case 'edit':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_FIELD_LIST, 'field.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Form
        $field_id = Request::getInt('field_id', 0);
        if ($field_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOFIELD);
        } else {
            $obj = $fieldHandler->get($field_id);
            $form = $obj->getForm();
            $xoopsTpl->assign('form', $form->render()); 
        }

        break;
    // Save
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('field.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $field_id = Request::getInt('field_id', 0);
        if ($field_id == 0) {
            $obj = $fieldHandler->create();            
        } else {
            $obj = $fieldHandler->get($field_id);
        }
        $error_message = $obj->saveField($fieldHandler, 'field.php');
        if ($error_message != ''){
            $xoopsTpl->assign('error_message', $error_message);
            $form = $obj->getForm();
            $xoopsTpl->assign('form', $form->render());
        }
        
        break;
        
    // del
    case 'del':    
        $field_id = Request::getInt('field_id', 0);
        if ($field_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOFIELD);
        } else {
            $surdel = Request::getBool('surdel', false);
            $obj  = $fieldHandler->get($field_id);
            if ($surdel === true) {
                if (!$GLOBALS['xoopsSecurity']->check()) {
                    redirect_header('field.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
                }
                if ($fieldHandler->delete($obj)) {
                    redirect_header('field.php', 2, _MA_XMARTICLE_REDIRECT_SAVE);
                } else {
                    $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
                }
            } else {
                xoops_confirm(array('surdel' => true, 'field_id' => $field_id, 'op' => 'del'), $_SERVER['REQUEST_URI'], 
                                    sprintf(_MA_XMARTICLE_FIELD_SUREDEL, $obj->getVar('field_name')));
            }
        }
        
        break;
        
    // Update status
    case 'field_update_status':
        $field_id = Request::getInt('field_id', 0);
        if ($field_id > 0) {
            $obj = $fieldHandler->get($field_id);
            $old = $obj->getVar('field_status');
            $obj->setVar('field_status', !$old);
            if ($fieldHandler->insert($obj)) {
                exit;
            }
            $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
        }
        break;
}

$xoopsTpl->display("db:xmarticle_admin_field.tpl");

require dirname(__FILE__) . '/admin_footer.php';