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
$path = dirname(dirname(dirname(__DIR__)));
require_once $path . '/mainfile.php';
require_once $path . '/include/cp_functions.php';
require_once $path . '/include/cp_header.php';

xoops_load('utility', basename(dirname(__DIR__)));

class_exists('\Xmf\Module\Admin') or die('XMF is required.');
use Xmf\Module\Helper;
$helper = Helper::getHelper('xmarticle');

// Load language files
$helper->loadLanguage('main');

// Config
$nb_limit = $helper->getConfig('admin_perpage', 15);
$url_logo_category = XOOPS_UPLOAD_URL . '/xmarticle/images/category/';
$path_logo_category = XOOPS_UPLOAD_PATH . '/xmarticle/images/category/';
$url_logo_article = XOOPS_UPLOAD_URL . '/xmarticle/images/article/';
$path_logo_article = XOOPS_UPLOAD_PATH . '/xmarticle/images/article/';
// Get handler
$categoryHandler = xoops_getModuleHandler('xmarticle_category', 'xmarticle');
$fieldHandler = xoops_getModuleHandler('xmarticle_field', 'xmarticle');
$articleHandler = xoops_getModuleHandler('xmarticle_article', 'xmarticle');

xoops_cp_header();