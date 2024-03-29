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
class_exists('\Xmf\Module\Admin') or die('XMF is required.');

use Xmf\Module\Helper;

$helper = Helper::getHelper(basename(dirname(__DIR__)));

$url_logo_category  = XOOPS_UPLOAD_URL . '/xmarticle/images/category/';
$path_logo_category = XOOPS_UPLOAD_PATH . '/xmarticle/images/category/';
$url_logo_article   = XOOPS_UPLOAD_URL . '/xmarticle/images/article/';
$path_logo_article  = XOOPS_UPLOAD_PATH . '/xmarticle/images/article/';

$upload_size = $helper->getConfig('general_maxuploadsize', 104858);

// Get handler
$categoryHandler  = $helper->getHandler('xmarticle_category');
$fieldHandler     = $helper->getHandler('xmarticle_field');
$fielddataHandler = $helper->getHandler('xmarticle_fielddata');
$articleHandler   = $helper->getHandler('xmarticle_article');