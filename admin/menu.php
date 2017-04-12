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

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

// get path to icons
$pathIcon32='';
if (class_exists('Xmf\Module\Admin', true)) {
    $pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
}

$adminmenu=array();
// Index
$adminmenu[] = array(
    'title' => _MI_XMARTICLE_MENU_HOME ,
    'link'  => 'admin/index.php' ,
    'icon'  => $pathIcon32 . 'home.png'
) ;
// Category
$adminmenu[] = array(
    'title' => _MI_XMARTICLE_MENU_CATEGORY ,
    'link'  => 'admin/category.php' ,
    'icon'  => $pathIcon32 . 'category.png'
) ;
// Field
$adminmenu[] = array(
    'title' => _MI_XMARTICLE_MENU_FIELD ,
    'link'  => 'admin/field.php' ,
    'icon'  => $pathIcon32 . 'folder_txt.png'
) ;
// Article
$adminmenu[] = array(
    'title' => _MI_XMARTICLE_MENU_ARTICLE ,
    'link'  => 'admin/article.php' ,
    'icon'  => $pathIcon32 . 'view_detailed.png'
) ;
// About
$adminmenu[] = array(
    'title' => _MI_XMARTICLE_MENU_ABOUT ,
    'link'  => 'admin/about.php' ,
    'icon'  => $pathIcon32 . 'about.png'
) ;