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

function xmarticle_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $sql = "SELECT article_id, article_cid, article_name, article_reference, article_description FROM " . $xoopsDB->prefix("xmarticle_article") . " WHERE article_status = 1";

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

    $sql .= " ORDER BY article_date DESC";
    $result = $xoopsDB->query($sql,$limit,$offset);
    $ret = array();
    $i = 0;
    while($myrow = $xoopsDB->fetchArray($result))
    {
        $ret[$i]["image"] = "assets/images/xmarticle_search.png";
        $ret[$i]["link"] = "viewarticle.php?article_id=" . $myrow["article_id"] . '&category_id=' . $myrow["article_cid"];
        $ret[$i]["title"] = $myrow["article_name"] . '(' . $myrow["article_reference"] . ')';
        $i++;
    }

    return $ret;
}