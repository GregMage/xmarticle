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

include_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'xmarticle_index.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';

$xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null );


// Get article
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('article_status', 1));
$article_arr = $articleHandler->getall($criteria);


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
        $category['description']     = $category_arr[$i]->getVar('category_description', 'show');
        $category['totalarticle']    = sprintf(_MA_XMARTICLE_CATEGORY_THEREAREARTICLE, XmarticleUtility::articlePerCat($category_id, $article_arr));
        $category_img                = $category_arr[$i]->getVar('category_logo') ?: 'blank.gif';
        $category['logo']            = $url_logo_category .  $category_img;
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

include XOOPS_ROOT_PATH.'/footer.php';
