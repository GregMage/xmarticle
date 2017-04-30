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
$path =dirname(dirname(__DIR__));
require_once $path . '/mainfile.php';
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include_once __DIR__ . '/include/common.php';


xoops_load('utility', basename(__DIR__));
use Xmf\Module\Helper;
$helper = Helper::getHelper('xmarticle');
$permHelper = new \Xmf\Module\Helper\Permission();

// Load language files
$helper->loadLanguage('main');

// Config
$nb_limit = $helper->getConfig('general_perpage', 15);
$url_logo_category = XOOPS_UPLOAD_URL . '/xmarticle/images/category/';
$path_logo_category = XOOPS_UPLOAD_PATH . '/xmarticle/images/category/';
$url_logo_article = XOOPS_UPLOAD_URL . '/xmarticle/images/article/';
$path_logo_article = XOOPS_UPLOAD_PATH . '/xmarticle/images/article/';