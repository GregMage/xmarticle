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
use Xmf\Module\Helper;

function xmarticle_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    if (xoops_isActiveModule('xmstock')){
        $helper_xmstock = Helper::getHelper('xmstock');
        $helper_xmstock->loadLanguage('main');
        $sql  = "SELECT a.*,";
        $sql .= " GROUP_CONCAT(CASE
                        WHEN s.stock_type = 4 THEN CONCAT(t.area_name, ': ', '" . _MA_XMSTOCK_STOCK_FREE . "')
                        ELSE CONCAT(t.area_name, ': ', s.stock_amount, ' ', CASE s.stock_type
                            WHEN 5 THEN '" . _MA_XMSTOCK_CHECKOUT_UNITS . "'
                            WHEN 2 THEN '" . _MA_XMSTOCK_CHECKOUT_UNIT . "'
                            ELSE ''
                        END)
                    END SEPARATOR ', ') AS stock_details";
        $sql .= " FROM " . $xoopsDB->prefix('xmarticle_article') . " AS a";
        $sql .= " LEFT JOIN " . $xoopsDB->prefix('xmstock_stock') . " AS s ON a.article_id = s.stock_articleid";
        $sql .= " LEFT JOIN " . $xoopsDB->prefix('xmstock_area') . " AS t ON s.stock_areaid = t.area_id";
        $sql .= " WHERE a.article_status = 1";
    } else{
        $sql = "SELECT article_id, article_cid, article_name, article_reference, article_description, article_date, article_userid FROM " . $xoopsDB->prefix("xmarticle_article") . " WHERE article_status = 1";
    }

	if ( $userid != 0 ) {
        $sql .= " AND article_userid=" . intval($userid) . " ";
    }

    if ( is_array($queryarray) && $count = count($queryarray) )
    {
        $sql .= " AND ((article_name LIKE '%$queryarray[0]%' OR article_reference LIKE '%$queryarray[0]%' OR article_description LIKE '%$queryarray[0]%')";

        for($i=1;$i<$count;$i++)
        {
            $sql .= " $andor ";
            $sql .= "(article_name LIKE '%$queryarray[$i]%' OR article_reference LIKE '%$queryarray[$i]%' OR article_description LIKE '%$queryarray[$i]%')";
        }
        $sql .= ")";
    }
    if (xoops_isActiveModule('xmstock')){
        $sql .= " GROUP BY a.article_id";
    }

    $sql .= " ORDER BY article_name ASC";
    $result = $xoopsDB->query($sql,$limit,$offset);
    $ret = array();
    $i = 0;
    while($myrow = $xoopsDB->fetchArray($result))
    {
        $title = $myrow["article_name"] . '(' . $myrow["article_reference"] . ')';
        if (xoops_isActiveModule('xmstock')){
            $title .= isset($myrow["stock_details"]) ? " |" . $myrow["stock_details"] : ''; // Détails des stocks
        }
        $ret[$i]["image"] = "assets/images/xmarticle_search.png";
        $ret[$i]["link"] = "viewarticle.php?article_id=" . $myrow["article_id"];
        $ret[$i]["title"] = $title;
        $ret[$i]["time"] = $myrow["article_date"];
        $ret[$i]["uid"] = $myrow["article_userid"];
        $i++;
    }

    return $ret;
}