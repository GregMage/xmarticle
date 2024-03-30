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

function xoops_module_update_xmarticle(XoopsModule $module, $previousVersion = null) {
	// Passage de la version 1.3.0 à 1.4.0
    if ($previousVersion < '1.4.0') {
        $db = XoopsDatabaseFactory::getDatabaseConnection();
		$sql = "ALTER TABLE `" . $db->prefix('xmarticle_field') . "` ADD `field_selsearch` tinyint(1) unsigned NOT NULL DEFAULT '0' AFTER `field_search`;";
        $db->query($sql);
    }
    return true;
}