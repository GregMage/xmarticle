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
use Xmf\Module\Helper;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once $GLOBALS['xoops']->path('class/template.php');
$xoopsTpl = new XoopsTpl();

include __DIR__ . '/include/common.php';
xoops_load('utility', basename(__DIR__));
include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');

// Get Permission to view
$viewPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_view');

// Get values
$search = Request::getString('search', '');
$reset = Request::getString('reset', '');
$select = Request::getString('select', '');

$sessionHelper = new Helper\Session();

$bootstrap = XOOPS_THEME_PATH . '/' . $GLOBALS['xoopsConfig']['theme_set'] . '/css/bootstrap.css';
$bootstrap_min = XOOPS_THEME_PATH . '/' . $GLOBALS['xoopsConfig']['theme_set'] . '/css/bootstrap.min.css';

if (file_exists($bootstrap) || file_exists($bootstrap_min)){
	if (file_exists($bootstrap_min)){
		$xoopsTpl->assign('bootstrap_css', XOOPS_THEME_URL . '/' . $GLOBALS['xoopsConfig']['theme_set'] . '/css/bootstrap.min.css');
	} else {
		$xoopsTpl->assign('bootstrap_css', XOOPS_THEME_URL . '/' . $GLOBALS['xoopsConfig']['theme_set'] . '/css/bootstrap.css');
	}
	include_once XOOPS_ROOT_PATH . '/class/xoopsform/renderer/XoopsFormRendererBootstrap4.php';
	XoopsFormRenderer::getInstance()->set(new XoopsFormRendererBootstrap4());
} else{
	$xoopsTpl->assign('bootstrap_css', '');
}

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
	if (!empty($selarticle)) {
		$selarticle_arr['name']        = $selarticle->getVar('article_name');
		$selarticle_img            	   = $selarticle->getVar('article_logo');
		if ($selarticle_img == ''){
			$selarticle_arr['logo']    = $url_logo_article . 'no-image.png';
		} else {
			$selarticle_arr['logo']    = $url_logo_article . $selarticle->getVar('article_cid') . '/' . $selarticle_img;
		}
		$xoopsTpl->assign('selarticle_arr', $selarticle_arr);
	} else {
		$xoopsTpl->assign('error_message', _MA_XMARTICLE_ERROR_NOARTICLE);
	}
	$reset = '';
}

$op = Request::getCmd('op', 'form');
switch ($op) {
    case 'form':
        // Form
        $obj  = $articleHandler->create();
		$obj->setVar('order', 1);
        $obj->setVar('sort', 0);
        $obj->setVar('filter', 10);
        $obj->setVar('display', 0);
        $form = $obj->getFormSearch(XOOPS_URL . '/modules/xmarticle/articlemanager.php');
        $xoopsTpl->assign('form', $form->render());
        break;

    case 'search':
        XmarticleUtility::search($xoopsTpl, XOOPS_URL . '/modules/xmarticle/articlemanager.php');
        break;
}

$xoopsTpl->display('db:xmarticle_articlemanager.tpl');
