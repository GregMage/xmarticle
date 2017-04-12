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
        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->setSort('article_name');
        $criteria->setOrder('ASC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
        $article_arr = $articleHandler->getall($criteria);
        $article_count = $articleHandler->getCount($criteria);
        $xoopsTpl->assign('article_count', $article_count);
        if ($article_count > 0) {
            foreach (array_keys($article_arr) as $i) {
                $article_id                 = $article_arr[$i]->getVar('article_id');
                $article['id']              = $article_id;
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
                $nav = new XoopsPageNav($article_count, $nb_limit, $start, 'start');
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
        $form = $obj->getForm();
        $xoopsTpl->assign('form', $form->render());
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
            $obj = $articleHandler->get($article_id);
            $old = $obj->getVar('article_status');
            $obj->setVar('article_status', !$old);
            if ($articleHandler->insert($obj)) {
                exit;
            }
            $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
        }
        break;
}

$xoopsTpl->display("db:xmarticle_admin_article.tpl");

require dirname(__FILE__) . '/admin_footer.php';