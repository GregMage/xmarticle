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
$GLOBALS['xoopsOption']['template_main'] = 'xmarticle_search.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null);

$xoopsTpl->assign('index_module', $helper->getModule()->getVar('name'));
// Get Action type
$op = Request::getCmd('op', 'form');
switch ($op) {
    case 'form':
        // Form
        $obj  = $articleHandler->create();
        $form = $obj->getFormSearch(XOOPS_URL . '/modules/xmarticle/search.php');
        $xoopsTpl->assign('form', $form->render());
        break;

    case 'search':
        // Form
        $article_name = Request::getString('name', '');
        $article_reference = Request::getString('ref', '');
        $article_description = Request::getString('desc', '');
        $article_cid = Request::getInt('cid', 0);
        $n_field = Request::getInt('n_field', 0);
        $start  = Request::getInt('start', 0);
        $xoopsTpl->assign('start', $start);
        $arguments = 'cid=' . $article_cid;
        /*echo 'article_name: ' . $article_name . '<br>';
        echo 'article_reference: ' . $article_reference . '<br>';
        echo 'article_description: ' . $article_description . '<br>';
        echo 'article_cid: ' . $article_cid . '<br>';
        echo 'n_field: ' . $n_field . '<br>';*/

        //filters
        $order = Request::getInt('order', 1);
        $xoopsTpl->assign('order', $order);
        $sort = Request::getInt('sort', 0);
        $xoopsTpl->assign('sort', $sort);
        $filter = Request::getInt('filter', 2); // par défaut à 10 ne pas oublier de changer!
        $xoopsTpl->assign('filter', $filter);
        $display = Request::getInt('display', 0);
        $xoopsTpl->assign('display', $display);

        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('article_status', 1));

        if ($article_name != '') {
            $criteria->add(new Criteria('article_name', '%' . $article_name . '%', 'LIKE'));
            $arguments .= '&amp;name=' . $article_name;
        }
        if ($article_reference != '') {
            $criteria->add(new Criteria('article_reference', '%' . $article_reference . '%', 'LIKE'));
            $arguments .= '&amp;ref=' . $article_reference;
        }
        if ($article_description != '') {
            $criteria->add(new Criteria('article_description', '%' . $article_description . '%', 'LIKE'));
            $arguments .= '&amp;desc=' . $article_description;
        }
        switch ($order) {
            default:
            case 1:
                $criteria->setSort('article_name');
                if ($sort == 0){
                    $criteria->setOrder('ASC');
                } else {
                    $criteria->setOrder('DESC');
                }
                break;
            case 2:
                $criteria->setSort('article_date');
                if ($sort == 0){
                    $criteria->setOrder('DESC');
                } else {
                    $criteria->setOrder('ASC');
                }
                break;
            case 3:
                $criteria->setSort('article_counter');
                if ($sort == 0){
                    $criteria->setOrder('DESC');
                } else {
                    $criteria->setOrder('ASC');
                }
                break;
            case 4:
                $criteria->setSort('article_reference');
                if ($sort == 0){
                    $criteria->setOrder('DESC');
                } else {
                    $criteria->setOrder('ASC');
                }
                break;
        }

        if ($article_cid != 0) {
            $criteria->add(new Criteria('article_cid', $article_cid));
        } else {
            $viewPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_view');
            $criteria->add(new Criteria('article_cid', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
        }
        // recherche sur les champs sup.
        if ($n_field != 0){
            $useFieldSearch = false;
            for ($i = 1; $i <= $n_field; $i++) {
                if (isset($_POST['f_' . $i])) {
                    $value = $_POST['f_' . $i];
                    if ($value != '' && $value != 999) {
                        echo 'f_' . $i  . ': ' . $value . '<br>';
                        $useFieldSearch = true;
                    }
                }
                if (isset($_POST['fnex_' . $i])) {
                    $value_fnex = $_POST['fnex_' . $i];
                    if ($value_fnex != '') {
                        $useFieldSearch = true;
                    }
                }
                if (isset($_POST['fnmi_' . $i]) && $value_fnex == '') {
                    $value_fnmi = $_POST['fnmi_' . $i];
                    if ($value_fnmi != '') {
                        $useFieldSearch = true;
                    }
                }
                if (isset($_POST['fnma_' . $i]) && $value_fnex == '') {
                    $value_fnma = $_POST['fnma_' . $i];
                    if ($value_fnma != '') {
                        $useFieldSearch = true;
                    }
                }
                if (isset($_POST['t_' . $i])) {
                    $type = $_POST['t_' . $i];
                    echo 't_' . $i  . ': ' . $type . '<br>';
                }
            }
        }
        $criteria->setStart($start);
        $criteria->setLimit($filter);
        $articleHandler->table_link   = $articleHandler->db->prefix("xmarticle_category");
        $articleHandler->field_link   = "category_id";
        $articleHandler->field_object = "article_cid";
        $article_arr                  = $articleHandler->getByLink($criteria);
        $article_count                = $articleHandler->getCount($criteria);
        //xmsocial
        if (xoops_isActiveModule('xmsocial') && $helper->getConfig('general_xmsocial', 0) == 1) {
            $xmsocial = true;
            xoops_load('utility', 'xmsocial');
        } else {
            $xmsocial = false;
        }
        $xoopsTpl->assign('arguments', $arguments);
        $xoopsTpl->assign('xmsocial', $xmsocial);
        $xoopsTpl->assign('article_count', $article_count);
        if ($article_count > 0) {
            foreach (array_keys($article_arr) as $i) {
                $article_id             = $article_arr[$i]->getVar('article_id');
                $article['id']          = $article_id;
                $article['cid']         = $article_arr[$i]->getVar('article_cid');
                $article['name']        = $article_arr[$i]->getVar('article_name');
                $article['reference']   = $article_arr[$i]->getVar('article_reference');
                $article['description'] = XmarticleUtility::TagSafe($article_arr[$i]->getVar('article_description', 'show'));
                $article['date']        = formatTimestamp($article_arr[$i]->getVar('article_date'), 's');
                if ($article_arr[$i]->getVar('article_mdate') != 0) {
                    $article['mdate'] 		 = formatTimestamp($article_arr[$i]->getVar('article_mdate'), 's');
                }
                $article['author']      = XoopsUser::getUnameFromId($article_arr[$i]->getVar('article_userid'));
                $article_img            = $article_arr[$i]->getVar('article_logo');
                if ($article_img == ''){
                    $article['logo']    = '';
                } else {
                    $article['logo']    = $url_logo_article . $article_arr[$i]->getVar('article_cid') . '/' . $article_img;
                }
                $color					= $article_arr[$i]->getVar('category_color');
                if ($color == '#ffffff'){
                    $article['color']	= false;
                } else {
                    $article['color']   = $color;
                }
                if ($xmsocial == true){
                    $article['rating'] = XmsocialUtility::renderVotes($article_arr[$i]->getVar('article_rating'), $article_arr[$i]->getVar('article_votes'));
                }
                $article['counter']     = $article_arr[$i]->getVar('article_counter');
                $article['douser']      = $article_arr[$i]->getVar('article_douser');
                $article['dodate']      = $article_arr[$i]->getVar('article_dodate');
                $article['domdate']     = $article_arr[$i]->getVar('article_domdate');
                $article['dohits']      = $article_arr[$i]->getVar('article_dohits');
                $article['dorating']    = $article_arr[$i]->getVar('article_dorating');
                $xoopsTpl->append('articles', $article);
                unset($article);
            }
            // Display Page Navigation
            if ($article_count > $filter) {
                $nav = new XoopsPageNav($article_count, $filter, $start, 'start', 'op=search&amp;' . $arguments . '&amp;order=' . $order . '&amp;' . 'sort=' . $sort . '&amp;' . 'filter=' . $filter . '&amp;' . 'display=' . $display);
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('no_article', true);
        }
        // form
        $obj = $articleHandler->create();
        $obj->setVar('article_name', $article_name);
        $obj->setVar('article_reference', $article_reference);
        $obj->setVar('article_description', $article_description);
        $obj->setVar('article_cid', $article_cid);
        $form = $obj->getFormSearch(XOOPS_URL . '/modules/xmarticle/search.php');
        $xoopsTpl->assign('form', $form->render());
        break;
}


/*

$search = Request::getString('search', '');
if ($search != '') {
    $start = 0;
}
$s_name = Request::getString('s_name', '');
$s_ref  = Request::getString('s_ref', '');
$s_desc = Request::getString('s_desc', '');
$s_aid  = Request::getString('s_aid', '');
$s_cat  = Request::getInt('s_cat', 0);
$start  = Request::getInt('start', 0);

// Form
$obj  = $articleHandler->create();
$fielddata_aid_arr = $obj->getFormSearch($s_name, $s_ref, $s_desc, $s_cat, XOOPS_URL . '/modules/xmarticle/search.php');
if (count($fielddata_aid_arr) > 0) {
	$s_aid = serialize($fielddata_aid_arr);
}
if ($search != '') {
    //filters
    $order = Request::getInt('order', 1);
    $xoopsTpl->assign('order', $order);
    $sort = Request::getInt('sort', 0);
    $xoopsTpl->assign('sort', $sort);
    $filter = Request::getInt('filter', 10);
    $xoopsTpl->assign('filter', $filter);
    $display = Request::getInt('display', 0);
    $xoopsTpl->assign('display', $display);
    //$xoopsTpl->assign('s_cat', $s_cat);

    $arguments = 's_cat=' . $s_cat . '&amp;';
    // Criteria
    $criteria = new CriteriaCompo();

    if ($s_name != '') {
        $criteria->add(new Criteria('article_name', '%' . $s_name . '%', 'LIKE'));
        $arguments .= 's_name=' . $s_name . '&amp;';
    }
    if ($s_ref != '') {
        $criteria->add(new Criteria('article_reference', '%' . $s_ref . '%', 'LIKE'));
        $arguments .= 's_ref=' . $s_ref . '&amp;';
    }
	if ($s_desc != '') {
        $criteria->add(new Criteria('article_description', '%' . $s_desc . '%', 'LIKE'));
        $arguments .= 's_desc=' . $s_desc . '&amp;';
    }
	if ($s_aid != '') {
        $criteria->add(new Criteria('article_id', '(' . implode(',', unserialize($s_aid)) . ')', 'IN'));
        $arguments .= 's_aid=' . $s_aid . '&amp;';
    }
    if (count($fielddata_aid_arr) > 0) {
        $criteria->add(new Criteria('article_id', '(' . implode(',', $fielddata_aid_arr) . ')', 'IN'));
    }
    $xoopsTpl->assign('arguments', $arguments);
    switch ($order) {
        default:
        case 1:
            $criteria->setSort('article_name');
            if ($sort == 0){
                $criteria->setOrder('ASC');
            } else {
                $criteria->setOrder('DESC');
            }
            break;
        case 2:
            $criteria->setSort('article_date');
            if ($sort == 0){
                $criteria->setOrder('DESC');
            } else {
                $criteria->setOrder('ASC');
            }
            break;
        case 3:
            $criteria->setSort('article_counter');
            if ($sort == 0){
                $criteria->setOrder('DESC');
            } else {
                $criteria->setOrder('ASC');
            }
            break;
        case 4:
            $criteria->setSort('article_reference');
            if ($sort == 0){
                $criteria->setOrder('DESC');
            } else {
                $criteria->setOrder('ASC');
            }
            break;
    }
    $criteria->setStart($start);
    $criteria->setLimit($filter);
    if ($s_cat != 0) {
        $criteria->add(new Criteria('article_cid', $s_cat));
    } else {
		$viewPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_view');
		$criteria->add(new Criteria('article_cid', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
	}
    $criteria->add(new Criteria('article_status', 1));
    $articleHandler->table_link   = $articleHandler->db->prefix("xmarticle_category");
    $articleHandler->field_link   = "category_id";
    $articleHandler->field_object = "article_cid";
    $article_arr                  = $articleHandler->getByLink($criteria);
    $article_count                = $articleHandler->getCount($criteria);
	//xmsocial
	if (xoops_isActiveModule('xmsocial') && $helper->getConfig('general_xmsocial', 0) == 1) {
		$xmsocial = true;
		xoops_load('utility', 'xmsocial');
	} else {
		$xmsocial = false;
	}
	$xoopsTpl->assign('xmsocial', $xmsocial);
	$xoopsTpl->assign('article_count', $article_count);
    if ($article_count > 0) {
        foreach (array_keys($article_arr) as $i) {
            $article_id             = $article_arr[$i]->getVar('article_id');
            $article['id']          = $article_id;
            $article['cid']         = $article_arr[$i]->getVar('article_cid');
            $article['name']        = $article_arr[$i]->getVar('article_name');
            $article['reference']   = $article_arr[$i]->getVar('article_reference');
            $article['description'] = XmarticleUtility::TagSafe($article_arr[$i]->getVar('article_description', 'show'));
            $article['date']        = formatTimestamp($article_arr[$i]->getVar('article_date'), 's');
			if ($article_arr[$i]->getVar('article_mdate') != 0) {
				$article['mdate'] 		 = formatTimestamp($article_arr[$i]->getVar('article_mdate'), 's');
			}
			$article['author']      = XoopsUser::getUnameFromId($article_arr[$i]->getVar('article_userid'));
			$article_img            = $article_arr[$i]->getVar('article_logo');
			if ($article_img == ''){
				$article['logo']    = '';
			} else {
				$article['logo']    = $url_logo_article . $article_arr[$i]->getVar('article_cid') . '/' . $article_img;
			}
			$color					= $article_arr[$i]->getVar('category_color');
			if ($color == '#ffffff'){
				$article['color']	= false;
			} else {
				$article['color']   = $color;
			}
			if ($xmsocial == true){
				$article['rating'] = XmsocialUtility::renderVotes($article_arr[$i]->getVar('article_rating'), $article_arr[$i]->getVar('article_votes'));
			}
			$article['counter']     = $article_arr[$i]->getVar('article_counter');
			$article['douser']      = $article_arr[$i]->getVar('article_douser');
			$article['dodate']      = $article_arr[$i]->getVar('article_dodate');
			$article['domdate']     = $article_arr[$i]->getVar('article_domdate');
			$article['dohits']      = $article_arr[$i]->getVar('article_dohits');
			$article['dorating']    = $article_arr[$i]->getVar('article_dorating');
            $xoopsTpl->append('articles', $article);
            unset($article);
        }
        // Display Page Navigation
        if ($article_count > $filter) {
            $nav = new XoopsPageNav($article_count, $filter, $start, 'start', 'search=Y&amp;' . $arguments . 'order=' . $order . '&amp;' . 'sort=' . $sort . '&amp;' . 'filter=' . $filter . '&amp;' . 'display=' . $display);
            $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
        }
    } else {
        $xoopsTpl->assign('no_article', true);
    }
}*/

//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', _MA_XMARTICLE_SEARCH . '-' . $xoopsModule->name());
include XOOPS_ROOT_PATH . '/footer.php';
