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
$GLOBALS['xoopsOption']['template_main'] = 'xmarticle_index.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null);

// Get Permission to view
$viewPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_view');
// Get article
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('article_status', 1));
$article_arr = $articleHandler->getall($criteria);

$xoopsTpl->assign('export', xoops_isActiveModule('xmstats'));
// Get start pager
$start = Request::getInt('start', 0);

$xoopsTpl->assign('index_module', $helper->getModule()->getVar('name'));
// Criteria
$criteria = new CriteriaCompo();
$criteria->setSort('category_weight ASC, category_name');
$criteria->setOrder('ASC');
$criteria->setStart($start);
$criteria->setLimit($nb_limit);
$criteria->add(new Criteria('category_status', 1));
if (!empty($viewPermissionCat)) {
    $criteria->add(new Criteria('category_id', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
}
$category_arr   = $categoryHandler->getall($criteria);
$category_count = $categoryHandler->getCount($criteria);
$xoopsTpl->assign('category_count', $category_count);
$keywords = '';
if ($category_count > 0 && !empty($viewPermissionCat)) {
    foreach (array_keys($category_arr) as $i) {
        $category_id              = $category_arr[$i]->getVar('category_id');
        $category['id']           = $category_id;
        $category['name']         = $category_arr[$i]->getVar('category_name');
        $category['description']  = XmarticleUtility::TagSafe($category_arr[$i]->getVar('category_description', 'show'));
        $category['totalarticle'] = sprintf(_MA_XMARTICLE_CATEGORY_THEREAREARTICLE, XmarticleUtility::articlePerCat($category_id, $article_arr));
        $category_img             = $category_arr[$i]->getVar('category_logo');
		if ($category_img == ''){
			$category['logo']        = '';
		} else {
			$category['logo']         = $url_logo_category . $category_img;
		}
		$color					  = $category_arr[$i]->getVar('category_color');
		if ($color == '#ffffff'){
			$category['color']	  = false;
		} else {
			$category['color']	  = $color;
		}
        $xoopsTpl->appendByRef('categories', $category);
        if ($keywords == '') {
            $keywords = XmarticleUtility::TagSafe($category_arr[$i]->getVar('category_name'));
        } else {
            $keywords = $keywords . ',' . XmarticleUtility::TagSafe($category_arr[$i]->getVar('category_name'));
        }
        unset($category);
    }
    // Display Page Navigation
    if ($category_count > $nb_limit) {
        $nav = new XoopsPageNav($category_count, $nb_limit, $start, 'start');
        $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
    }
}
//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->name());
//keywords
$xoTheme->addMeta('meta', 'keywords', $keywords);
include XOOPS_ROOT_PATH . '/footer.php';
