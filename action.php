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

use \Xmf\Request;

include_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'xmarticle_action.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null);

$op = Request::getCmd('op', '');
// Get start pager
$start = Request::getInt('start', 0);

if ($op == 'clone' || $op == 'edit' || $op == 'del' || $op == 'add' || $op == 'loadarticle' || $op == 'save') {
    switch ($op) {
        // Add
        case 'add':           
            // permission to submitt
			$permHelper->checkPermissionRedirect('xmarticle_other', 4, 'index.php', 2, _NOPERM);
			// Get Permission to submit
			$submitPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_submit');
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('category_status', 1));
			$criteria->setSort('category_weight ASC, category_name');
			$criteria->setStart($start);
			$criteria->setLimit($nb_limit);
			$criteria->setOrder('ASC');
			if (!empty($submitPermissionCat)){
				$criteria->add(new Criteria('category_id', '(' . implode(',', $submitPermissionCat) . ')','IN'));
			}
			$category_arr   = $categoryHandler->getall($criteria);
			$category_count = $categoryHandler->getCount($criteria);
			$xoopsTpl->assign('category_count', $category_count);
			if ($category_count > 0 && !empty($submitPermissionCat)) {
				foreach (array_keys($category_arr) as $i) {
					$category_id              = $category_arr[$i]->getVar('category_id');
					$category['id']           = $category_id;
					$category['name']         = $category_arr[$i]->getVar('category_name');
					$category['description']  = $category_arr[$i]->getVar('category_description', 'show');
					$category_img             = $category_arr[$i]->getVar('category_logo') ?: 'blank.gif';
					$category['logo']         = $url_logo_category . $category_img;
					$xoopsTpl->append_by_ref('categories', $category);
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

        // Loadtype
        case 'loadarticle':            
            // permission to submitt
			$permHelper->checkPermissionRedirect('xmarticle_other', 4, 'index.php', 2, _NOPERM);
			// Get Permission to submit in category
			$submitPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_submit');
			$category_id = Request::getInt('category_id', 0);
			if (!in_array($category_id, $submitPermissionCat)) {
				redirect_header('action.php?op=add', 2, _NOPERM);
			}
			if ($category_id == 0) {
				$xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOCATEGORY);
			} else {
                $obj  = $articleHandler->create();
                $form = $obj->getForm($category_id);
                $xoopsTpl->assign('form', $form->render());;
			}
            break;

        // Edit
        case 'edit':
			// permission to submitt
            $permHelper->checkPermissionRedirect('xmarticle_other', 4, 'index.php', 2, _NOPERM);
            // Form
            $article_id = Request::getInt('article_id', 0);
            if ($article_id == 0) {
                $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
            } else {
                $obj  = $articleHandler->get($article_id);
				if (empty($obj)) {
					$xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
				} else {
					$form = $obj->getForm();
					$xoopsTpl->assign('form', $form->render());
				}
            }

            break;

        // Clone
        case 'clone':
			// permission to submitt
            $permHelper->checkPermissionRedirect('xmarticle_other', 4, 'index.php', 2, _NOPERM);
            $article_id = Request::getInt('article_id', 0);
            if ($article_id == 0) {
                $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
            } else {
                $cloneobj = XmarticleUtility::cloneArticle($article_id);
                $form     = $cloneobj->getForm($cloneobj->getVar('article_cid'), $article_id, 'action.php');
                $xoopsTpl->assign('form', $form->render());
            }
            break;

        // Save
        case 'save':
            // permission to submitt
            $permHelper->checkPermissionRedirect('xmarticle_other', 4, 'index.php', 2, _NOPERM);
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('index.php', 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $article_id = Request::getInt('article_id', 0);
            if ($article_id == 0) {
                $obj = $articleHandler->create();
            } else {
                $obj = $articleHandler->get($article_id);
            }
            $error_message = $obj->savearticle($articleHandler, 'viewarticle.php');
            if ($error_message != '') {
                $xoopsTpl->assign('error_message', $error_message);
				$article_cid = Request::getInt('article_cid', 0);
				$form = $obj->getForm($article_cid);
                $xoopsTpl->assign('form', $form->render());
            }
            break;

        // del
        case 'del':
            // permission to del
            $permHelper->checkPermissionRedirect('xmarticle_other', 16, 'index.php', 2, _NOPERM);
            $article_id = Request::getInt('article_id', 0);
            if ($article_id == 0) {
                $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
            } else {
                $surdel = Request::getBool('surdel', false);
                $obj    = $articleHandler->get($article_id);
                if ($surdel === true) {
                    if (!$GLOBALS['xoopsSecurity']->check()) {
                        redirect_header('index.php', 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
                    }
                    if ($articleHandler->delete($obj)) {
                        //Del logo
                        if ($obj->getVar('article_logo') != 'blank.gif') {
                            $urlfile = $path_logo_article . $obj->getVar('article_logo');
                            if (is_file($urlfile)) {
                                chmod($urlfile, 0777);
                                unlink($urlfile);
                            }
                        }
                        //Del fielddata
                        XmarticleUtility::delFilddataArticle($article_id);
						//xmdoc
						if (xoops_isActiveModule('xmdoc') && $helper->getConfig('general_xmdoc', 0) == 1) {
							xoops_load('utility', 'xmdoc');
							XmdocUtility::delDocdata('xmarticle', $article_id);
						}                        
						//Del Notification and comment
						$helper = \Xmf\Module\Helper::getHelper('xmarticle');
						$moduleid = $helper->getModule()->getVar('mid');
						xoops_notification_deletebyitem($moduleid, 'article', $article_id);
						xoops_comment_delete($moduleid, $article_id);
						
						redirect_header('index.php', 2, _MA_XMARTICLE_REDIRECT_SAVE);
                    } else {
                        $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
                    }
                } else {
                    $article_img = $obj->getVar('article_logo') ?: 'blank.gif';
                    xoops_confirm(['surdel' => true, 'article_id' => $article_id, 'op' => 'del'], $_SERVER['REQUEST_URI'], sprintf(_MA_XMARTICLE_ARTICLE_SUREDEL, $obj->getVar('article_name')) . '<br \>
                                        <img src="' . $url_logo_article . $article_img . '" title="' . $obj->getVar('article_name') . '"><br \>');
                }
            }
            break;
    }
} else {
    redirect_header('index.php', 2, _NOPERM);
}
include XOOPS_ROOT_PATH . '/footer.php';
