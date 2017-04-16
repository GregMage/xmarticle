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
$GLOBALS['xoopsOption']['template_main'] = 'xmarticle_viewcat.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';

$xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null );

$category_id = Request::getInt('category_id', 0);

if ($category_id == 0) {
    redirect_header('index.php', 2, _MA_XMARTICLE_ERROR_NOCATEGORY);
    exit();
}

$category = $categoryHandler->get($category_id);

if (count($category) == 0) {
    redirect_header('index.php', 2, _MA_XMARTICLE_ERROR_NOCATEGORY);
    exit();
}

if ($category->getVar('category_status') == 0) {
    redirect_header('index.php', 2, _MA_XMARTICLE_ERROR_NACTIVE);
    exit();
}
// Get start pager
$start = Request::getInt('start', 0);

// Category
$xoopsTpl->assign('name', $category->getVar('category_name'));
$xoopsTpl->assign('description' , $category->getVar('category_description', 'show'));
$xoopsTpl->assign('reference', $category->getVar('category_reference'));
$category_img = $category->getVar('category_logo') ?: 'blank.gif';
$xoopsTpl->assign('logo', $url_logo_category .  $category_img);

// Get article
$criteria = new CriteriaCompo();
$criteria->setSort('article_name');
$criteria->setOrder('ASC');
$criteria->setStart($start);
$criteria->setLimit($nb_limit);
$criteria->add(new Criteria('article_status', 1));
$criteria->add(new Criteria('article_cid', $category_id));
$article_count = $articleHandler->getCount($criteria);
$article_arr = $articleHandler->getall($criteria);
if ($article_count > 0) {
    foreach (array_keys($article_arr) as $i) {
        $article_id                 = $article_arr[$i]->getVar('article_id');
        $article['id']              = $article_id;
        $article['cid']             = $article_arr[$i]->getVar('article_cid');
        $article['name']            = $article_arr[$i]->getVar('article_name');
        $article['reference']       = $article_arr[$i]->getVar('article_reference');
        $article['description']     = $article_arr[$i]->getVar('article_description', 'show');
        $article['date']            = 'a faire';
        $article_img                = $article_arr[$i]->getVar('article_logo') ?: 'blank.gif';
        $article['logo']            = $url_logo_article .  $article_img;
        $xoopsTpl->append('article', $article);
        unset($article);
    }
    // Display Page Navigation
    if ($article_count > $nb_limit) {
        $nav = new XoopsPageNav($article_count, $nb_limit, $start, 'start', 'category_id=' . $category_id);
        $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
    }
}

//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', \Xmf\Metagen::generateSeoTitle($category->getVar('category_name') . '-' . $xoopsModule->name()));
//description   
$xoTheme->addMeta('meta', 'description', \Xmf\Metagen::generateDescription($category->getVar('category_description'), 30));
//keywords
$keywords = \Xmf\Metagen::generateKeywords($category->getVar('category_description'), 10);    
$xoTheme->addMeta('meta', 'keywords', implode(', ', $keywords));

include XOOPS_ROOT_PATH.'/footer.php';
