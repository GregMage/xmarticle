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
$modversion['dirname']     = basename(__DIR__);
$modversion['name']        = ucfirst(basename(__DIR__));
$modversion['version']     = '0.1';
$modversion['description'] = _MI_XMARTICLE_DESC;
$modversion['author']      = 'Grégory Mage (Mage)';
$modversion['url']         = 'https://github.com/GregMage';
$modversion['credits']     = 'Mage';

$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2 or later';
$modversion['license_url'] = 'http://www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']    = 0;
$modversion['image']       = 'assets/images/xmarticle_logo.png';

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][] = array(
    'name' => _MI_XMARTICLE_SUB_ADD,
    'url'  => 'action.php?op=add'
);
$modversion['sub'][] = array(
    'name' => _MI_XMARTICLE_SUB_SEARCH,
    'url'  => 'search.php'
);

// Admin things
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// Install and update
$modversion['onInstall']        = 'include/install.php';
//$modversion['onUpdate']         = 'include/update.php';

// Tables
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

$modversion['tables'][1] = 'xmarticle_category';
$modversion['tables'][2] = 'xmarticle_field';
$modversion['tables'][3] = 'xmarticle_article';
$modversion['tables'][4] = 'xmarticle_fielddata';

// Admin Templates
$modversion['templates'][] = array('file' => 'xmarticle_admin_category.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'xmarticle_admin_field.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'xmarticle_admin_article.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'xmarticle_admin_permission.tpl', 'description' => '', 'type' => 'admin');

// User Templates
$modversion['templates'][] = array('file' => 'xmarticle_index.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'xmarticle_viewcat.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'xmarticle_article.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'xmarticle_viewarticle.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'xmarticle_action.tpl', 'description' => '');

// Configs
$modversion['config'] = array();

$modversion['config'][] = array(
    'name'        => 'break',
    'title'       => '_MI_XMARTICLE_PREF_HEAD_GENERAL',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'text',
    'default'     => 'head',
);

$modversion['config'][] = array(
    'name'        => 'general_perpage',
    'title'       => '_MI_XMARTICLE_PREF_GENERALITEMPERPAGE',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 15
);

xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = array(
    'name'        => 'admin_editor',
    'title'       => '_MI_XMARTICLE_PREF_EDITOR',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => array_flip($editorHandler->getList())
);

$modversion['config'][] = array(
    'name'        => 'break',
    'title'       => '_MI_XMARTICLE_PREF_HEAD_ADMIN',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'text',
    'default'     => 'head',
);

$modversion['config'][] = array(
    'name'        => 'admin_perpage',
    'title'       => '_MI_XMARTICLE_PREF_ITEMPERPAGE',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 15
);

// About stuff
$modversion['module_status'] = 'Alpha 1';
$modversion['release_date']  = '2017/03/04';

$modversion['developer_lead']      = 'Mage';
$modversion['module_website_url']  = 'github.com/GregMage';
$modversion['module_website_name'] = 'github.com/GregMage';

$modversion['min_xoops'] = '2.5.9';
$modversion['min_php']   = '5.3.7';
