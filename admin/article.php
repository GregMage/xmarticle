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
$moduleAdmin->displayNavigation('article.php');

// Get Action type
$op = Request::getCmd('op', 'list');
switch ($op) {
    case 'list':
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        $xoTheme->addScript('modules/system/js/admin.js');
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_ARTICLE_ADD, 'article.php?op=add', 'add');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());   
		// Get start pager
        $start = Request::getInt('start', 0);
		$xoopsTpl->assign('start', $start);
		// Category
		$article_cid = Request::getInt('article_cid', 0);
        $xoopsTpl->assign('article_cid', $article_cid);
		$criteria = new CriteriaCompo();
		$criteria->setSort('category_weight ASC, category_name');
		$criteria->setOrder('ASC');
		$category_arr = $categoryHandler->getall($criteria);		
		if (count($category_arr) > 0) {
			$article_cid_options = '<option value="0"' . ($article_cid == 0 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
			foreach (array_keys($category_arr) as $i) {
				$article_cid_options .= '<option value="' . $i . '"' . ($article_cid == $i ? ' selected="selected"' : '') . '>' . $category_arr[$i]->getVar('category_name') . '</option>';
			}
			$xoopsTpl->assign('article_cid_options', $article_cid_options);
		}
        // Status
        $article_status = Request::getInt('article_status', 10);
        $xoopsTpl->assign('article_status', $article_status);
        $status_options = array(1 => _MA_XMARTICLE_STATUS_A, 0 =>_MA_XMARTICLE_STATUS_NA, 2 =>_MA_XMARTICLE_WFV);
		$article_status_options = '<option value="10"' . ($article_status == 0 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
        foreach (array_keys($status_options) as $i) {
            $article_status_options .= '<option value="' . $i . '"' . ($article_status == $i ? ' selected="selected"' : '') . '>' . $status_options[$i] . '</option>';
        }
        $xoopsTpl->assign('article_status_options', $article_status_options);
        
        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->setSort('article_name');
        $criteria->setOrder('ASC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
		if ($article_cid != 0){
			$criteria->add(new Criteria('article_cid', $article_cid));
		}
        if ($article_status != 10){
			$criteria->add(new Criteria('article_status', $article_status));
		}    
        $articleHandler->table_link = $articleHandler->db->prefix("xmarticle_category");
        $articleHandler->field_link = "category_id";
        $articleHandler->field_object = "article_cid";
        $article_arr = $articleHandler->getByLink($criteria);
        $article_count = $articleHandler->getCount($criteria);
        $xoopsTpl->assign('article_count', $article_count);
        if ($article_count > 0) {
            foreach (array_keys($article_arr) as $i) {
                $article_id                 = $article_arr[$i]->getVar('article_id');
                $article['id']              = $article_id;
                $article['category']        = $article_arr[$i]->getVar('category_name');
                $article['cat_reference']   = $article_arr[$i]->getVar('category_reference');
				$article['cid']             = $article_arr[$i]->getVar('article_cid');
                $article['name']            = $article_arr[$i]->getVar('article_name');
                $article['reference']       = $article_arr[$i]->getVar('article_reference');
                $article['description']     = $article_arr[$i]->getVar('article_description', 'show');
                $article['status']          = $article_arr[$i]->getVar('article_status');
                $article_img                = $article_arr[$i]->getVar('article_logo') ?: 'blank.gif';
                $article['logo']            = '<img src="' . $url_logo_article .  $article_img . '" alt="' . $article_img . '" />';
                $xoopsTpl->append_by_ref('article', $article);
                unset($article);
            }
            // Display Page Navigation
            if ($article_count > $nb_limit) {
                $nav = new XoopsPageNav($article_count, $nb_limit, $start, 'start', 'article_cid=' . $article_cid . '&article_status=' . $article_status);
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
        }
        break;
    
    // Add
    case 'add':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_ARTICLE_LIST, 'article.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Form
        $obj  = $articleHandler->create();
        $form = $obj->getFormCategory();
        $xoopsTpl->assign('form', $form->render());
        break;

    // Loadtype
    case 'loadarticle':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_ARTICLE_LIST, 'article.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());  
        $article_cid = Request::getInt('article_cid', 0);
        if ($article_cid == 0) {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOCATEGORY);
        } else {
            $obj  = $articleHandler->create();
            $form = $obj->getForm($article_cid);
            $xoopsTpl->assign('form', $form->render());
        }
        break;
        
    // Edit
    case 'edit':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMARTICLE_ARTICLE_LIST, 'article.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Form
        $article_id = Request::getInt('article_id', 0);
        if ($article_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
        } else {
            $obj = $articleHandler->get($article_id);
            $form = $obj->getForm();
            $xoopsTpl->assign('form', $form->render()); 
        }

        break;
	
	// Clone
    case 'clone':
        $article_id = Request::getInt('article_id', 0);
        if ($article_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
        } else {
            $cloneobj = XmarticleUtility::cloneArticle($article_id);
            $form = $cloneobj->getForm($cloneobj->getVar('article_cid'), $article_id, 'article.php');
            $xoopsTpl->assign('form', $form->render());
        }
        break;
		
    // Save
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('article.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $article_id = Request::getInt('article_id', 0);
        if ($article_id == 0) {
            $obj = $articleHandler->create();
        } else {
            $obj = $articleHandler->get($article_id);
        }
        $error_message = $obj->savearticle($articleHandler, 'article.php');
        if ($error_message != ''){
            $xoopsTpl->assign('error_message', $error_message);
            $form = $obj->getForm();
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
            $obj  = $articleHandler->get($article_id);
            if ($surdel === true) {
                if (!$GLOBALS['xoopsSecurity']->check()) {
                    redirect_header('article.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
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
                    redirect_header('article.php', 2, _MA_XMARTICLE_REDIRECT_SAVE);
                } else {
                    $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
                }
            } else {
                $article_img = $obj->getVar('article_logo') ?: 'blank.gif';
                xoops_confirm(array('surdel' => true, 'article_id' => $article_id, 'op' => 'del'), $_SERVER['REQUEST_URI'], 
                                    sprintf(_MA_XMARTICLE_ARTICLE_SUREDEL, $obj->getVar('article_name')) . '<br \>
                                    <img src="' . $url_logo_article . $article_img . '" title="' . 
                                    $obj->getVar('article_name') . '" /><br \>');
            }
        }
        
        break;
        
    // Update status
    case 'article_update_status':
        $article_id = Request::getInt('article_id', 0);
        if ($article_id > 0) {
            $article_status = Request::getInt('article_status', 10);
            $obj = $articleHandler->get($article_id);
            if ($article_status == 0 || $article_status == 2){
                $obj->setVar('article_status', 1);
            } else {
                $obj->setVar('article_status', 0);
            }
            if ($articleHandler->insert($obj)) {
                exit;
            }
            $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
        }
        break;
}

$xoopsTpl->display("db:xmarticle_admin_article.tpl");

require dirname(__FILE__) . '/admin_footer.php';