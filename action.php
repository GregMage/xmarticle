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
$xoopsTpl->assign('index_module', $helper->getModule()->getVar('name'));

if ($op == 'clone' || $op == 'edit' || $op == 'del' || $op == 'add' || $op == 'loadarticle' || $op == 'save') {
    switch ($op) {
        // Add
        case 'add':
			// Get Permission to submit
			$submitPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_submit');
			if (empty($submitPermissionCat)){
				redirect_header('index.php', 2, _NOPERM);
			}
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
					$category_img             = $category_arr[$i]->getVar('category_logo');
					if ($category_img == ''){
						$category['logo']     = '';
					} else {
						$category['logo']     = $url_logo_category . $category_img;
					}
					$color					  = $category_arr[$i]->getVar('category_color');
					if ($color == '#ffffff'){
						$category['color']	  = false;
					} else {
						$category['color']	  = $color;
					}
					$xoopsTpl->appendByRef('categories', $category);
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
			$category_id = Request::getInt('category_id', 0);
			if ($category_id == 0) {
				$xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOCATEGORY);
			} else {
				// Get Permission to submit in category
				$permHelper->checkPermissionRedirect('xmarticle_submit', $category_id, 'action.php?op=add', 2, _NOPERM);
                $obj  = $articleHandler->create();
                $form = $obj->getForm($category_id);
                $xoopsTpl->assign('form', $form->render());
			}
            break;

        // Edit
        case 'edit':
            $article_id = Request::getInt('article_id', 0);
            if ($article_id == 0) {
                $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
            } else {
                $obj  = $articleHandler->get($article_id);
				if (empty($obj)) {
					$xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
				} else {
					// Get Permission to edit in category
					$permHelper->checkPermissionRedirect('xmarticle_editapprove', $obj->getVar('article_cid'), 'index.php', 2, _NOPERM);
					$form = $obj->getForm();
					$xoopsTpl->assign('form', $form->render());
				}
            }

            break;

        // Clone
        case 'clone':
            $article_id = Request::getInt('article_id', 0);
            if ($article_id == 0) {
                $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
            } else {
                $cloneobj = XmarticleUtility::cloneArticle($article_id);
				// Get Permission to edit in category
				$permHelper->checkPermissionRedirect('xmarticle_editapprove', $cloneobj->getVar('article_cid'), 'index.php', 2, _NOPERM);
				$form     = $cloneobj->getForm($cloneobj->getVar('article_cid'), $article_id, 'action.php', true);
                $xoopsTpl->assign('form', $form->render());
            }
            break;

        // Save
        case 'save':
			$article_cid = Request::getInt('article_cid', 0);
            // permission to submitt
			$permHelper->checkPermissionRedirect('xmarticle_submit', $article_cid, 'index.php', 2, _NOPERM);
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
            $article_id = Request::getInt('article_id', 0);
			if ($article_id == 0) {
                $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
            } else {
                $surdel = Request::getBool('surdel', false);
                $obj    = $articleHandler->get($article_id);
				// Get Permission to delete in category
				$permHelper->checkPermissionRedirect('xmarticle_delete', $obj->getVar('article_cid'), 'index.php', 2, _NOPERM);
                if ($surdel === true) {
                    if (!$GLOBALS['xoopsSecurity']->check()) {
                        redirect_header('index.php', 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
                    }
					$error_message = $obj->delArticle($articleHandler, $article_id, 'index.php');
					if ($error_message != ''){
						$xoopsTpl->assign('error_message', $error_message);
					}
                } else {
                    $article_img = $obj->getVar('article_logo') ?: 'no-image.png';
                    xoops_confirm(['surdel' => true, 'article_id' => $article_id, 'op' => 'del'], $_SERVER['REQUEST_URI'], sprintf(_MA_XMARTICLE_ARTICLE_SUREDEL, $obj->getVar('article_name')) . '<br \>
                                        <img src="' . $url_logo_article . $article_img . '" title="' . $obj->getVar('article_name') . '" style="max-width:100px"s><br \>');
                }
            }
            break;
    }
} else {
    redirect_header('index.php', 2, _NOPERM);
}
include XOOPS_ROOT_PATH . '/footer.php';
