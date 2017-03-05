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
$moduleAdmin->displayNavigation('category.php');



// Get Action type
$op = Request::getCmd('op', 'list');
switch ($op) {
    case 'list':
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        $xoTheme->addScript('modules/system/js/admin.js');
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_CATEGORY_ADD, 'category.php?op=add', 'add');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Get start pager
        $start = Request::getInt('start', 0);
        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->setSort('category_weight ASC, category_name');
        $criteria->setOrder('ASC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
        $category_arr = $categoryHandler->getall($criteria);
        $category_count = $categoryHandler->getCount($criteria);
        $xoopsTpl->assign('category_count', $category_count);
        if ($category_count > 0) {
            foreach (array_keys($category_arr) as $i) {
                $category_id                 = $category_arr[$i]->getVar('category_id');
                $category['id']              = $category_id;
                $category['name']            = $category_arr[$i]->getVar('category_name');
                $category['reference']       = $category_arr[$i]->getVar('category_reference');
                $category['description']     = $category_arr[$i]->getVar('category_description');
                $category['weight']          = $category_arr[$i]->getVar('category_weight');
                $category['status']          = $category_arr[$i]->getVar('category_status');
                $category_img                = $category_arr[$i]->getVar('category_logo') ?: 'blank.gif';
                $category['logo']            = '<img src="' . $path_logo_category .  $category_img . '" alt="' . $category_img . '" />';
                $xoopsTpl->append_by_ref('category', $category);
                unset($category);
            }
            // Display Page Navigation
            if ($category_count > $nb_limit) {
                $nav = new XoopsPageNav($category_count, $nb_limit, $start, 'start');
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOCATEGORY);
        }
        break;
    
    // add
    case 'add':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_CATEGORY_LIST, 'category.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Form
        $obj  = $categoryHandler->create();
        $form = $obj->getForm();
        $xoopsTpl->assign('form', $form->render());
        break;
}

$xoopsTpl->display("db:xmarticle_admin_category.tpl");

require dirname(__FILE__) . '/admin_footer.php';