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

function xoops_module_install_xmarticle()
{
    $namemodule = 'xmarticle';
    
    //Creation ".$namemodule."/
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    chmod($dir, 0777);

    //Creation ".$namemodule."/images/
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    chmod($dir, 0777);
    
    //Creation ".$namemodule."/images/category
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/category';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    chmod($dir, 0777);
    
    //Creation ".$namemodule."/images/article
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/article';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    chmod($dir, 0777);

    //Copy index.html
    $indexFile = XOOPS_ROOT_PATH . '/modules/' . $namemodule . '/include/index.html';
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/index.html');
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/index.html');
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/category/index.html');
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/article/index.html');

    //Copy blank.gif
    $blankFile = XOOPS_ROOT_PATH . '/modules/' . $namemodule . '/assets/images/blank.gif';
    copy($blankFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/category/blank.gif');
    copy($blankFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/article/blank.gif');
	
	// insert field for test
	$fieldHandler = xoops_getModuleHandler('xmarticle_field', 'xmarticle');
    $field_arr[] = array('field_type' => 'label', 'field_name'=> 'name label', 'field_description'=> 'dsc label', 'field_required'=> 0, 'field_weight'=> 1, 'field_default'=> 'def label', 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> '');
    $field_arr[] = array('field_type' => 'vs_text', 'field_name'=> 'name vs_text', 'field_description'=> 'dsc vs_text', 'field_required'=> 1, 'field_weight'=> 2, 'field_default'=> 'def vs_text', 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> '');
	$field_arr[] = array('field_type' => 's_text', 'field_name'=> 'name s_text', 'field_description'=> 'dsc s_text', 'field_required'=> 1, 'field_weight'=> 3, 'field_default'=> 'def s_text', 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> '');
	$field_arr[] = array('field_type' => 'm_text', 'field_name'=> 'name m_text', 'field_description'=> 'dsc m_text', 'field_required'=> 1, 'field_weight'=> 4, 'field_default'=> 'def m_text', 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> '');
	$field_arr[] = array('field_type' => 'l_text', 'field_name'=> 'name l_text', 'field_description'=> 'dsc l_text', 'field_required'=> 1, 'field_weight'=> 5, 'field_default'=> 'def l_text', 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> '');
	$field_arr[] = array('field_type' => 'text', 'field_name'=> 'name text', 'field_description'=> 'dsc text', 'field_required'=> 1, 'field_weight'=> 6, 'field_default'=> 'def text', 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> '');
	$field_arr[] = array('field_type' => 'select', 'field_name'=> 'name select', 'field_description'=> 'dsc select', 'field_required'=> 1, 'field_weight'=> 7, 'field_default'=> 'b', 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> array('a' => 'aa', 'b' => 'bb', 'c' => 'cc', 'd' => 'dd'));
	$field_arr[] = array('field_type' => 'select_multi', 'field_name'=> 'name select_multi', 'field_description'=> 'dsc select_multi', 'field_required'=> 1, 'field_weight'=> 8, 'field_default'=> serialize(array('c' => 'cc', 'd' => 'dd')), 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> array('a' => 'aa', 'b' => 'bb', 'c' => 'cc', 'd' => 'dd'));
	$field_arr[] = array('field_type' => 'radio_yn', 'field_name'=> 'name radio_yn', 'field_description'=> 'dsc radio_yn', 'field_required'=> 1, 'field_weight'=> 9, 'field_default'=> 0, 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> '');
	$field_arr[] = array('field_type' => 'radio', 'field_name'=> 'name radio', 'field_description'=> 'dsc radio', 'field_required'=> 1, 'field_weight'=> 10, 'field_default'=> 'd', 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> array('a' => 'aa', 'b' => 'bb', 'c' => 'cc', 'd' => 'dd'));
	$field_arr[] = array('field_type' => 'checkbox', 'field_name'=> 'name checkbox', 'field_description'=> 'dsc checkbox', 'field_required'=> 1, 'field_weight'=> 11, 'field_default'=> serialize(array('a' => 'aa', 'b' => 'bb')), 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> array('a' => 'aa', 'b' => 'bb', 'c' => 'cc', 'd' => 'dd'));
	$field_arr[] = array('field_type' => 'number', 'field_name'=> 'name number', 'field_description'=> 'dsc number', 'field_required'=> 1, 'field_weight'=> 12, 'field_default'=> 1.20, 'field_search'=> 1, 'field_status'=> 1, 'field_options'=> '');
	
    foreach (array_keys($field_arr) as $i) {
        $obj = $fieldHandler->create();
        $obj->setVar('field_type', $field_arr[$i]['field_type']);
		$obj->setVar('field_name', $field_arr[$i]['field_name']);
		$obj->setVar('field_description', $field_arr[$i]['field_description']);
		$obj->setVar('field_required', $field_arr[$i]['field_required']);
		$obj->setVar('field_weight', $field_arr[$i]['field_weight']);
		$obj->setVar('field_default', $field_arr[$i]['field_default']);
		$obj->setVar('field_search', $field_arr[$i]['field_search']);
		$obj->setVar('field_status', $field_arr[$i]['field_status']);
		$obj->setVar('field_options', $field_arr[$i]['field_options']);
        $fieldHandler->insert($obj);
        unset($obj);
    }
    return true;
}
