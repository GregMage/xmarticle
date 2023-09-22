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
$GLOBALS['xoopsOption']['template_main'] = 'xmarticle_viewarticle.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null);

$category_id = Request::getInt('category_id', 0);
$article_id  = Request::getInt('article_id', 0);

if ($category_id == 0) {
    redirect_header('index.php', 2, _MA_XMARTICLE_ERROR_NOCATEGORY);
}
// permission to view
$permHelper->checkPermissionRedirect('xmarticle_view', $category_id, 'index.php', 2, _NOPERM);

if ($article_id == 0) {
    redirect_header('index.php', 2, _MA_XMARTICLE_ERROR_NOARTICLE);
}

$category = $categoryHandler->get($category_id);
$article  = $articleHandler->get($article_id);

if (empty($category)) {
    redirect_header('index.php', 2, _MA_XMARTICLE_ERROR_NOCATEGORY);
}

if (empty($article)) {
    redirect_header('index.php', 2, _MA_XMARTICLE_ERROR_NOARTICLE);
}

if ($helper->isUserAdmin() != true){
	if ($category->getVar('category_status') == 0 || $article->getVar('article_status') != 1) {
		redirect_header('index.php', 2, _MA_XMARTICLE_ERROR_NACTIVE);
	}
}
//permission
$xoopsTpl->assign('perm_clone', true);
$xoopsTpl->assign('perm_edit', true);
$xoopsTpl->assign('perm_del', true);

// Category
$xoopsTpl->assign('category_name', $category->getVar('category_name'));
$xoopsTpl->assign('category_id', $category_id);
$color = $category->getVar('category_color');
if ($color == '#ffffff'){
	$xoopsTpl->assign('category_color', false);
} else {
	$xoopsTpl->assign('category_color', $color);
}

// Article
$xoopsTpl->assign('index_module', $helper->getModule()->getVar('name'));
$xoopsTpl->assign('article_id', $article_id);
$xoopsTpl->assign('name', $article->getVar('article_name'));
$xoopsTpl->assign('description', $article->getVar('article_description'));
$xoopsTpl->assign('reference', $article->getVar('article_reference'));
$xoopsTpl->assign('counter', $article->getVar('article_counter'));
$xoopsTpl->assign('rating', number_format($article->getVar('article_rating'), 1));
$xoopsTpl->assign('votes', sprintf(_MA_XMARTICLE_VOTES, $article->getVar('article_votes')));
$xoopsTpl->assign('date', formatTimestamp($article->getVar('article_date'), 's'));
if ($article->getVar('article_mdate') != 0) {
    $xoopsTpl->assign('mdate', formatTimestamp($article->getVar('article_mdate'), 's'));
}
$xoopsTpl->assign('author', XoopsUser::getUnameFromId($article->getVar('article_userid')));
$article_img = $article->getVar('article_logo');
if ($article_img == ''){
	$xoopsTpl->assign('logo', '');
} else {
	$xoopsTpl->assign('logo', $url_logo_article . $article_img);
}
$xoopsTpl->assign('douser', $article->getVar('article_douser'));
$xoopsTpl->assign('dodate', $article->getVar('article_dodate'));
$xoopsTpl->assign('domdate', $article->getVar('article_domdate'));
$xoopsTpl->assign('dohits', $article->getVar('article_dohits'));
$xoopsTpl->assign('docomment', $article->getVar('article_docomment'));
$xoopsTpl->assign('status', $article->getVar('article_status'));

// Field
$field_arr   = XmarticleUtility::getArticleFields($category->getVar('category_fields'), $article_id);
$field_count = count($field_arr);

if ($field_count > 0) {
    foreach (array_keys($field_arr) as $i) {
		if (empty($field_arr[$i][2]) && $helper->getConfig('general_displayEmptyField', 1) == 0) {
			$field_count--;
		} else {
			$field['name']        = $field_arr[$i][0];
			$field['description'] = $field_arr[$i][1];
			$field['value']       = $field_arr[$i][2];
			$xoopsTpl->appendByRef('fields', $field);
		}
        unset($field);
    }
}
$xoopsTpl->assign('field_count', $field_count);

//counter
$counterUpdate = false;
$options = array(
	'expires' => (time() + $helper->getConfig('general_countertime', 10) * 60),
	'path'     => '/',
	'domain'   => null,
	'secure'   => false,
	'httponly' => true,
	'samesite' => 'strict',
);
if (isset($_COOKIE['xmarticleCounterId'])) {
	$counterIds = unserialize($_COOKIE['xmarticleCounterId']);
	if (!in_array($article_id, $counterIds)){
		array_push($counterIds, $article_id);
		setcookie("xmarticleCounterId", serialize($counterIds), $options);
		$counterUpdate = true;
	}
} else {
	$counterId[] = $article_id;
	setcookie("xmarticleCounterId", serialize($counterId), $options);
	$counterUpdate = true;
}
if ($counterUpdate == true){
	$sql = 'UPDATE ' . $xoopsDB->prefix('xmarticle_article') . ' SET article_counter=article_counter+1 WHERE article_id = ' . $article_id;
	$xoopsDB->queryF($sql);
}

//xmstock
if (xoops_isActiveModule('xmstock') && $helper->getConfig('general_xmstock', 0) == 1) {
    xoops_load('utility', 'xmstock');
    XmstockUtility::renderStocks($article_id);
} else {
    $xoopsTpl->assign('xmstock_viewstocks', false);
}

//xmsocial
if (xoops_isActiveModule('xmsocial')){
	xoops_load('utility', 'xmsocial');
	if ($helper->getConfig('general_xmsocial', 0) == 1){
		$options['cat'] = $category_id;
		$xmsocial_arr = XmsocialUtility::renderRating('xmarticle', $article_id, 5, $article->getVar('article_rating'), $article->getVar('article_votes'), $options);
		$xoopsTpl->assign('xmsocial_arr', $xmsocial_arr);
		$xoopsTpl->assign('dorating', $article->getVar('article_dorating'));
	} else {
		 $xoopsTpl->assign('dorating', 0);
	}
} else {
	$xoopsTpl->assign('dorating', 0);
}

//xmdoc
if (xoops_isActiveModule('xmdoc') && $helper->getConfig('general_xmdoc', 0) == 1) {
    xoops_load('utility', 'xmdoc');
    XmdocUtility::renderDocuments($xoopsTpl, $xoTheme, 'xmarticle', $article_id);
} else {
    $xoopsTpl->assign('xmdoc_viewdocs', false);
}
//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', strip_tags($article->getVar('article_name')) . '-' . $xoopsModule->name());
//description
$xoTheme->addMeta('meta', 'description', XmarticleUtility::generateDescriptionTagSafe($article->getVar('article_description'), 80));
//keywords
$keywords = \Xmf\Metagen::generateKeywords(XmarticleUtility::TagSafe($article->getVar('article_description')), 10);
$xoTheme->addMeta('meta', 'keywords', implode(', ', $keywords));

include XOOPS_ROOT_PATH.'/include/comment_view.php';
include XOOPS_ROOT_PATH . '/footer.php';
