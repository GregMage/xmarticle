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
function block_xmarticle_show($options) {
	include __DIR__ . '/../include/common.php';
	include_once __DIR__ . '/../class/utility.php';
	
	$helper = Helper::getHelper('xmarticle');
	$helper->loadLanguage('main');
	
	// Get Permission to view
	$viewPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_view');
	
	$block = array();
	
	$criteria = new CriteriaCompo();
	switch ($options[2]) {
        case "date":
			$criteria->add(new Criteria('article_status', 1));
			$criteria->setSort('article_date DESC, article_name');
			$criteria->setOrder('ASC');
        break;

        case "hits":
			$criteria->add(new Criteria('article_status', 1));
			$criteria->setSort('article_counter DESC, article_name');
			$criteria->setOrder('ASC');
        break;

        case "rating":
			$criteria->add(new Criteria('article_status', 1));
			$criteria->setSort('article_rating DESC, article_name');
			$criteria->setOrder('ASC');
        break;

        case "random":
			$criteria->add(new Criteria('article_status', 1));
            $criteria->setSort('RAND()');
        break;
		
		case "waiting":
			$criteria->add(new Criteria('article_status', 2));
            $criteria->setSort('article_date DESC, article_name');
        break;
    }
	$category_ids = explode(',', $options[0]);
	if (!in_array(0, $category_ids)) {
        $criteria->add(new Criteria('category_id', '(' . $options[0] . ')', 'IN'));
    }
	$criteria->setLimit($options[1]);
	if (!empty($viewPermissionCat)) {
		$criteria->add(new Criteria('article_cid', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
	}
	$articleHandler->table_link = $articleHandler->db->prefix("xmarticle_category");
	$articleHandler->field_link = "category_id";
	$articleHandler->field_object = "article_cid";
	$article_arr = $articleHandler->getByLink($criteria);
	if (count($article_arr) > 0 && !empty($viewPermissionCat)) {
		foreach (array_keys($article_arr) as $i) {
			$article_id                 = $article_arr[$i]->getVar('article_id');
			$article['id']              = $article_id;
			$article['cid']             = $article_arr[$i]->getVar('article_cid');
			$article['name']            = $article_arr[$i]->getVar('article_name');
			$article['reference']       = $article_arr[$i]->getVar('article_reference');
			$article['description']     = $article_arr[$i]->getVar('article_description', 'n');
			$article['date']            = formatTimestamp($article_arr[$i]->getVar('article_date'), 's');
			$article['author']          = XoopsUser::getUnameFromId($article_arr[$i]->getVar('article_userid'));
			$article_img                = $article_arr[$i]->getVar('article_logo') ?: 'blank.gif';
			$article['logo']            = $url_logo_article .  $article_img;
			$article['hits']            = $article_arr[$i]->getVar('article_counter');
			$article['rating']          = $article_arr[$i]->getVar('article_rating');
			$article['votes']           = $article_arr[$i]->getVar('article_votes');
			$article['type']            = $options[2];
			$block['article'][] = $article;
			unset($article);
		}
	}
	$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/xmarticle/assets/css/styles.css');
	return $block;
}

function block_xmarticle_edit($options) {
	include __DIR__ . '/../include/common.php';

	// Criteria
	$criteria = new CriteriaCompo();
	$criteria->setSort('category_weight ASC, category_name');
	$criteria->setOrder('ASC');
	$criteria->add(new Criteria('category_status', 1));
	$category_arr = $categoryHandler->getall($criteria);
	
	include_once XOOPS_ROOT_PATH . '/modules/xmarticle/class/blockform.php';
    xoops_load('XoopsFormLoader');

    $form = new XmarticleBlockForm();
	$category = new XoopsFormSelect(_MB_XMARTICLE_CATEGORY, 'options[0]', $options[0], 5, true);
	$category->addOption(0, _MB_XMARTICLE_ALLCATEGORY);
	foreach (array_keys($category_arr) as $i) {
		$category->addOption($category_arr[$i]->getVar('category_id'), $category_arr[$i]->getVar('category_name'));
	}
	
	$form->addElement($category);
	$form->addElement(new XoopsFormText(_MB_XMARTICLE_NBARTICLE, 'options[1]', 5, 5, $options[1]), true);
	$form->addElement(new XoopsFormHidden('options[2]', $options[2]));

	return $form->render();
}