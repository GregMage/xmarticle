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

use Xmf\Module\Admin;
use Xmf\Request;

require __DIR__ . '/admin_header.php';

$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('index.php');
$op = Request::getCmd('op', '');

$iniPostMaxSize = XmarticleUtility::returnBytes(ini_get('post_max_size'));
$iniUploadMaxFileSize = XmarticleUtility::returnBytes(ini_get('upload_max_filesize'));
if (min($iniPostMaxSize, $iniUploadMaxFileSize) < $helper->getConfig('general_maxuploadsize', 104858)) {
	echo '<div class="errorMsg" style="text-align: left;">' . _MA_XMARTICLE_ERROR_SIZE . '</div>';
}
$moduleAdmin->addItemButton(_MA_XMARTICLE_INDEX_EXPORT, 'index.php?op=export', 'list');
echo $moduleAdmin->renderButton();

// article
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('article_status', 1));
$article_active = $articleHandler->getCount($criteria);
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('article_status', 0));
$article_notactive = $articleHandler->getCount($criteria);
$moduleAdmin->addInfoBox(_MA_XMARTICLE_INDEX_ARTICLE);
$ret = '<span style=\'font-weight: bold; color: green;\'>' . $article_active . '</span>';
$moduleAdmin->addInfoBoxLine(sprintf( $ret . ' ' . _MA_XMARTICLE_INDEX_ARTICLE_ACTIVE));
$ret = '<span style=\'font-weight: bold; color: red;\'>' . $article_notactive . '</span>';
$moduleAdmin->addInfoBoxLine(sprintf( $ret . ' ' . _MA_XMARTICLE_INDEX_ARTICLE_NOTACTIVE));

$moduleAdmin->addConfigModuleVersion('system', '2.1.2');
// xmstock
if (xoops_isActiveModule('xmstock')){
	if ($helper->getConfig('general_xmstock', 0) == 1) {
		$moduleAdmin->addConfigModuleVersion('xmstock', '1.0.0');
	} else {
		$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMSTOCK_WARNINGNOTACTIVATE);
	}
} else {
	$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMSTOCK_WARNINGNOTINSTALLED);
}
// xmdoc
if (xoops_isActiveModule('xmdoc')){
	if ($helper->getConfig('general_xmdoc', 0) == 1) {
		$moduleAdmin->addConfigModuleVersion('xmdoc', '1.4.0');
	} else {
		$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMDOC_WARNINGNOTACTIVATE);
	}
} else {
	$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMDOC_WARNINGNOTINSTALLED);
}
// xmsocial
if (xoops_isActiveModule('xmsocial')){
	if ($helper->getConfig('general_xmsocial', 0) == 1){
		$moduleAdmin->addConfigModuleVersion('xmsocial', '2.1.0');
	} else {
		$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMSOCIAL_WARNINGNOTACTIVATE);
	}
} else {
	$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMSOCIAL_WARNINGNOTINSTALLED);
}

$folder[] = $path_logo_category;
$folder[] = $path_logo_article;
foreach (array_keys( $folder) as $i) {
    $moduleAdmin->addConfigBoxLine($folder[$i], 'folder');
    $moduleAdmin->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}
$moduleAdmin->displayIndex();
echo XmarticleUtility::getServerStats();

// export en csv
if ($op == 'export'){
	$name_csv 	= 'Export_' . time() . '.csv';
	$path_csv 	= XOOPS_UPLOAD_PATH . '/xmarticle/' . $name_csv;
	$url_csv 	= XOOPS_UPLOAD_URL . '/xmarticle/' . $name_csv;
	$separator 	= ';';

	//supression des anciens fichiers
	$csv_list = XoopsLists::getFileListByExtension(XOOPS_UPLOAD_PATH . '/xmarticle/', array('csv'));
	foreach ($csv_list as $file) {
		unlink(XOOPS_UPLOAD_PATH . '/xmarticle/' . $file);
	}

	// Création du fichier d'export
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('article_status', 1));
	$articleHandler->table_link = $articleHandler->db->prefix("xmarticle_category");
	$articleHandler->field_link = "category_id";
	$articleHandler->field_object = "article_cid";
	$article_arr = $articleHandler->getByLink($criteria);
	if (count($article_arr) > 0) {
		$csv = fopen($path_csv, 'w+');
		//add BOM to fix UTF-8 in Excel
		fputs($csv, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		foreach (array_keys($article_arr) as $i) {
			fputcsv($csv, array($article_arr[$i]->getVar('article_reference'), $article_arr[$i]->getVar('article_name'), $article_arr[$i]->getVar('category_name'), '', '', 'Standard'), $separator);
		}
		fclose($csv);
		header("Location: $url_csv");
	}
}
require __DIR__ . '/admin_footer.php';