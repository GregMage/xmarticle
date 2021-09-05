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
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

use Xmf\Module\Admin;
use Xmf\Request;
use Xmf\Module\Helper;

require __DIR__ . '/admin_header.php';
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
                $category['description']     = XmarticleUtility::generateDescriptionTagSafe($category_arr[$i]->getVar('category_description', 'show'), 50);
				$color					     = $category_arr[$i]->getVar('category_color');
				if ($color == '#ffffff'){
					$category['color']	     = false;
				} else {
					$category['color']	     = $color;
				}
				$category['weight']          = $category_arr[$i]->getVar('category_weight');
                $category['status']          = $category_arr[$i]->getVar('category_status');
                $category_img                = $category_arr[$i]->getVar('category_logo');
				if ($category_img == ''){
					$category['logo']        = '';
				} else {
					$category['logo']        = $url_logo_category . $category_img;
				}
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
    
    // Add
    case 'add':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_CATEGORY_LIST, 'category.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Form
        $obj  = $categoryHandler->create();
        $form = $obj->getForm();
        $xoopsTpl->assign('form', $form->render());
        break;
        
    // Edit
    case 'edit':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_CATEGORY_LIST, 'category.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Form
        $category_id = Request::getInt('category_id', 0);
        if ($category_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOCATEGORY);
        } else {
            $obj = $categoryHandler->get($category_id);
            $form = $obj->getForm();
            $xoopsTpl->assign('form', $form->render()); 
        }

        break;
    // Save
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('category.php', 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $category_id = Request::getInt('category_id', 0);
        if ($category_id == 0) {
            $obj = $categoryHandler->create();            
        } else {
            $obj = $categoryHandler->get($category_id);
        }
        $error_message = $obj->saveCategory($categoryHandler, 'category.php');
        if ($error_message != ''){
            $xoopsTpl->assign('error_message', $error_message);
            $form = $obj->getForm();
            $xoopsTpl->assign('form', $form->render());
        }
        
        break;
        
    // del
    case 'del':    
        $category_id = Request::getInt('category_id', 0);
        if ($category_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOCATEGORY);
        } else {
            $surdel = Request::getBool('surdel', false);
            $obj  = $categoryHandler->get($category_id);
            if ($surdel === true) {
                if (!$GLOBALS['xoopsSecurity']->check()) {
                    redirect_header('category.php', 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
                }
                if ($categoryHandler->delete($obj)) {
                    //Del logo
                    if ($obj->getVar('category_logo') != 'blank.gif') {
                        // Test if the image is used
                        $criteria = new CriteriaCompo();
                        $criteria->add(new Criteria('category_logo', $obj->getVar('category_logo')));
                        $category_count = $categoryHandler->getCount($criteria);
                        if ($category_count == 0){
							$urlfile = $path_logo_category . $obj->getVar('category_logo');
							if (is_file($urlfile)) {
								chmod($urlfile, 0777);
								unlink($urlfile);
							}
                        }
                    }
                    // Del permissions
                    $permHelper = new \Xmf\Module\Helper\Permission();
                    $permHelper->deletePermissionForItem('xmarticle_view', $category_id);
                    $permHelper->deletePermissionForItem('xmarticle_submit', $category_id);
                    // Del article and fielddata
                    $criteria = new CriteriaCompo();
                    $criteria->add(new Criteria('article_cid', $category_id));
                    $article_arr = $articleHandler->getall($criteria);
                    if (count($article_arr) > 0){
                        foreach (array_keys($article_arr) as $i) {
                            // Del fielddata
                             XmarticleUtility::delFilddataArticle($article_arr[$i]->getVar('article_id'));                            
                            // Del article
                            $objarticle = $articleHandler->get($article_arr[$i]->getVar('article_id'));
                            $articleHandler->delete($objarticle) or $objarticle->getHtmlErrors();
							
							//Del Notification and comment
							$helper = \Xmf\Module\Helper::getHelper('xmarticle');
							$moduleid = $helper->getModule()->getVar('mid');
							xoops_notification_deletebyitem($moduleid, 'article', $i);
							xoops_comment_delete($moduleid, $i);
                        }
                    }
					
					//Del Notification
					xoops_notification_deletebyitem($moduleid, 'category', $category_id);
                    
                    redirect_header('category.php', 2, _MA_XMARTICLE_REDIRECT_SAVE);
                } else {
                    $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
                }
            } else {
                $category_img = $obj->getVar('category_logo') ?: 'blank.gif';
                xoops_confirm(['surdel' => true, 'category_id' => $category_id, 'op' => 'del'], $_SERVER['REQUEST_URI'], sprintf(_MA_XMARTICLE_CATEGORY_SUREDEL, $obj->getVar('category_name')) . '<br>
                                    <img src="' . $url_logo_category . $category_img . '" title="' . $obj->getVar('category_name') . '"><br>' . XmarticleUtility::articleNamePerCat($category_id));
            }
        }
        
        break;
        
    // Update status
    case 'category_update_status':
        $category_id = Request::getInt('category_id', 0);
        if ($category_id > 0) {
            $obj = $categoryHandler->get($category_id);
            $old = $obj->getVar('category_status');
            $obj->setVar('category_status', !$old);
            if ($categoryHandler->insert($obj)) {
                exit;
            }
            $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
        }
        break;
}

$xoopsTpl->display("db:xmarticle_admin_category.tpl");

require __DIR__ . '/admin_footer.php';
