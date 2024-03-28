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
        XmarticleUtility::search($xoopsTpl);
        break;
}

//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', _MA_XMARTICLE_SEARCH . '-' . $xoopsModule->name());
include XOOPS_ROOT_PATH . '/footer.php';
