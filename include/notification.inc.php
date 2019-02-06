<?php
/**
 * TDMDownload
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   Gregory Mage (Aka Mage)
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Gregory Mage (Aka Mage)
 */

/**
 * @param $category
 * @param $item_id
 * @return mixed
 */
function xmarticle_notify_iteminfo($category, $item_id)
{
    global $xoopsDB;
	switch ($category) {
		case 'global':
			$item['name'] = '';
			$item['url']  = '';
			return $item;
			break;
			
		case 'category':
			// Assume we have a valid album id
			$sql          = 'SELECT category_name FROM ' . $xoopsDB->prefix('xmarticle_category') . ' WHERE category_id = ' . $item_id;
			$result       = $xoopsDB->query($sql);
			$result_array = $xoopsDB->fetchArray($result);
			$item['name'] = $result_array['category_name'];
			$item['url']  = XOOPS_URL . '/modules/xmarticle/viewcat.php?category_id=' . $item_id;
			return $item;
			break;

		case 'article':
			// Assume we have a valid image id
			$sql          = 'SELECT article_name,article_cid FROM ' . $xoopsDB->prefix('xmarticle_article') . ' WHERE article_id = ' . $item_id;
			$result       = $xoopsDB->query($sql);
			$result_array = $xoopsDB->fetchArray($result);
			$item['name'] = $result_array['article_name'];
			$item['url']  = XOOPS_URL . '/modules/xmarticle/viewcat.php?category_id=' . $result_array['article_cid'] . '&amp;article_id=' . $item_id;			
			return $item;
			break;
	}
    return null;
}
