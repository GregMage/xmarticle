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
use \Xmf\Request;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once $GLOBALS['xoops']->path('class/template.php');
$xoopsTpl = new XoopsTpl();

include __DIR__ . '/include/common.php';
xoops_load('utility', basename(__DIR__));

$sessionHelper = new \Xmf\Module\Helper\Session();

if (isset($_REQUEST['selectreset'])){
    $sessionHelper->del('selectionarticle');
}
$selectionarticle = Request::getInt('selArticle', 0);		
if (isset($_REQUEST['selArticle'])){	
	$sessionHelper->set('selectionarticle', $selectionarticle);
}

if ($sessionHelper->get('selectionarticle') != False){
	$xoopsTpl->assign('selected', true);
	$selarticle  = $articleHandler->get($sessionHelper->get('selectionarticle'));	
	if (count($selarticle) > 0) {
		$selarticle_arr['name']        = $selarticle->getVar('article_name');
		$selarticle_img            	   = $selarticle->getVar('article_logo') ?: 'blank.gif';
		$selarticle_arr['logo']        = '<img src="' . $url_logo_article .  $selarticle_img . '" alt="' . $selarticle_img . '" />';	
		$xoopsTpl->assign('selarticle_arr', $selarticle_arr);
	} else {
		$xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
	}
	$reset = '';
}

// Get values
$search = Request::getString('search', '');
$reset  = Request::getString('reset', '');
if ($reset == '') {
    $s_name = Request::getString('s_name', '');
    $s_ref  = Request::getString('s_ref', '');
    $s_desc = Request::getString('s_desc', '');
    $s_cat  = Request::getInt('s_cat', 0);
} else {
    $s_name = '';
    $s_ref  = '';
    $s_desc  = '';
    $s_cat  = 0;
}
// Get start pager
$start = Request::getInt('start', 0);
// Form
$obj  = $articleHandler->create();
$fielddata_aid_arr = $obj->getFormSearch($s_name, $s_ref, $s_desc, $s_cat);

if ($search != '') {
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
    if (count($fielddata_aid_arr) > 0) {
        $criteria->add(new Criteria('article_id', '(' . implode(',', $fielddata_aid_arr) . ')', 'IN'));
    }
    $criteria->setSort('article_name');
    $criteria->setOrder('ASC');
    //$criteria->setStart($start);
    //$criteria->setLimit($nb_limit);
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
    if ($article_count > 0) {
        foreach (array_keys($article_arr) as $i) {
            $article_id             = $article_arr[$i]->getVar('article_id');
            $article['id']          = $article_id;
            $article['cid']         = $article_arr[$i]->getVar('article_cid');
            $article['name']        = $article_arr[$i]->getVar('article_name');
            $article['description'] = $article_arr[$i]->getVar('article_description', 'show');
            $article_img            = $article_arr[$i]->getVar('article_logo') ?: 'blank.gif';
            $article['logo']        = '<img src="' . $url_logo_article .  $article_img . '" alt="' . $article_img . '" />';			
			$xoopsTpl->append_by_ref('article', $article);
			unset($article);
        }
        // Display Page Navigation
        /*if ($article_count > $nb_limit) {
            $nav = new XoopsPageNav($article_count, $nb_limit, $start, 'start', 'search=Y&amp;' . $arguments);
            $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
        }*/
    } else {
        $xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
    }
}

$xoopsTpl->display('db:xmarticle_articlemanager.tpl');
