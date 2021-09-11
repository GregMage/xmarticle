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

require __DIR__ . '/admin_header.php';

$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('index.php');

$iniPostMaxSize = XmarticleUtility::returnBytes(ini_get('post_max_size'));
$iniUploadMaxFileSize = XmarticleUtility::returnBytes(ini_get('upload_max_filesize'));
if (min($iniPostMaxSize, $iniUploadMaxFileSize) < $helper->getConfig('general_maxuploadsize', 104858)) {
	echo '<div class="errorMsg" style="text-align: left;">' . _MA_XMARTICLE_ERROR_SIZE . '</div>';	
}


$moduleAdmin->addConfigModuleVersion('system', 212);
// xmstock
if (xoops_isActiveModule('xmstock')){
	if ($helper->getConfig('general_xmstock', 0) == 1) {
		$moduleAdmin->addConfigModuleVersion('xmstock', 10);
	} else {
		$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMSTOCK_WARNINGNOTACTIVATE);
	}
} else {
	$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMSTOCK_WARNINGNOTINSTALLED);
}
// xmdoc
if (xoops_isActiveModule('xmdoc')){
	if ($helper->getConfig('general_xmdoc', 0) == 1) {
		$moduleAdmin->addConfigModuleVersion('xmdoc', 50);
	} else {
		$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMDOC_WARNINGNOTACTIVATE);
	}
} else {
	$moduleAdmin->addConfigWarning(_MA_XMARTICLE_INDEXCONFIG_XMDOC_WARNINGNOTINSTALLED);
}

$folder[] = $path_logo_category;
$folder[] = $path_logo_article;
foreach (array_keys( $folder) as $i) {
    $moduleAdmin->addConfigBoxLine($folder[$i], 'folder');
    $moduleAdmin->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}
$moduleAdmin->displayIndex();
echo XmarticleUtility::getServerStats();
require __DIR__ . '/admin_footer.php';
