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
use \Xmf\Request;

include_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'xmarticle_search.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

$xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null );

// Get Permission to search
$permHelper->checkPermissionRedirect('xmarticle_other', 32, 'index.php', 2, _NOPERM);

// Get values
$search = Request::getString('search', '');
$reset = Request::getString('reset', '');
if ($reset == ''){
	$s_name = Request::getString('s_name', '');
	$s_reference = Request::getString('s_reference', '');
	$s_cat = Request::getInt('s_cat', 0);
} else {
	$s_name = '';
	$s_reference = '';
	$s_cat = 0;
}

// Get start pager
$start = Request::getInt('start', 0);

// Get Permission to view cat
$viewPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_view');
$criteria = new CriteriaCompo();
$criteria->setSort('category_weight ASC, category_name');
$criteria->setOrder('ASC');
$criteria->add(new Criteria('category_status', 1));
if (!empty($viewPermissionCat)){
    $criteria->add(new Criteria('category_id', '(' . implode(',', $viewPermissionCat) . ')','IN'));
} else {
	redirect_header('index.php', 3, _MA_XMARTICLE_ERROR_NOACESSCATEGORY);
}
$category_arr = $categoryHandler->getall($criteria);

$form = new XoopsThemeForm(_MA_XMARTICLE_SEARCHFORM, 'form', 'search.php', 'post', true);
// title
$form->addElement(new XoopsFormText(_MA_XMARTICLE_ARTICLE_NAME, 's_name', 50, 255, $s_name));
//reference
$form->addElement(new XoopsFormText(_MA_XMARTICLE_ARTICLE_REFERENCE, 's_reference', 50, 255, $s_reference));
//cat
$field_cat = new XoopsFormSelect(_MA_XMARTICLE_ARTICLE_CATEGORY, 's_cat', $s_cat);
$field_cat->addOption(0, _ALL);
foreach (array_keys($category_arr) as $i) {
	$field_cat->addOption($category_arr[$i]->getVar('category_id'), $category_arr[$i]->getVar('category_name'));
}
$field_cat->setExtra("onchange=\"location='search.php?s_name=" . $s_name . "&s_reference=" . $s_reference . "&s_cat='+this.options[this.selectedIndex].value\"");
$form->addElement($field_cat);

//fields
$fielddata_aid_arr = array();
if ($s_cat != 0){
    $category = $categoryHandler->get($s_cat);
    // field		
    $criteria = new CriteriaCompo();
    $criteria->setSort('field_weight ASC, field_name');
    $criteria->setOrder('ASC');
    $criteria->add(new Criteria('field_id', '(' . implode(',', $category->getVar('category_fields')) . ')', 'IN'));
    $criteria->add(new Criteria('field_status', 0, '!='));
    $criteria->add(new Criteria('field_search', 0, '!='));
    $field_arr = $fieldHandler->getall($criteria);
    $result = true;
    foreach (array_keys($field_arr) as $i) {
        $caption = $field_arr[$i]->getVar('field_name') . '<br><span style="font-weight:normal;">' . $field_arr[$i]->getVar('field_description', 'show') . '</span>';
        $required = false;			
        $name = 'f_' . $i;
        if (isset($_POST['f_' . $i])){
            $value = $_POST['f_' . $i];
            if ($value != '' && $value != 999) {
                $criteria = new CriteriaCompo();
                switch ($field_arr[$i]->getVar('field_type')) {
                    case 'vs_text':
                    case 's_text':
                    case 'm_text':
                    case 'l_text':
                    case 'select':
                    case 'radio_yn':
                    case 'radio':
                        $criteria->add(new Criteria('fielddata_fid', $i));
                        $criteria->add(new Criteria('fielddata_value1', $value));;
                        break;
                        
                    case 'label':
                    case 'text':
                        $criteria->add(new Criteria('fielddata_fid', $i));
                        $criteria->add(new Criteria('fielddata_value2', $value));
                        break;
                        
                    case 'select_multi':
                    case 'checkbox':
                        $criteria->add(new Criteria('fielddata_fid', $i));
                        $criteria->add(new Criteria('fielddata_value3', $value));
                        break;
                        
                    case 'number':
                        $criteria->add(new Criteria('fielddata_fid', $i));
                        $criteria->add(new Criteria('fielddata_value4', $value));
                        break;
                }
                if ($result == true){
                    if (count($fielddata_aid_arr) > 0) {
                        $criteria->add(new Criteria('fielddata_aid', '(' . implode(',', $fielddata_aid_arr) . ')', 'IN'));
                        $fielddata_aid_arr = array();
                    }
                    $fielddata_arr = $fielddataHandler->getall($criteria);
                    if (count($fielddata_arr) > 0){
                        foreach (array_keys($fielddata_arr) as $j) {
                            if ($value != '') {
                                $fielddata_aid_arr[] = $fielddata_arr[$j]->getVar('fielddata_aid');
                            }                    
                        }
                    } else {
                        $fielddata_aid_arr[] = 0;
                        $result = false;
                    }
                }
            }
        } else {
            $value = '';
        }
        switch ($field_arr[$i]->getVar('field_type')) {
            case 'label':
                $form->addElement(new XoopsFormLabel($caption, $value, $name), $required);
                $form->addElement(new XoopsFormHidden($name, $value));
                break;
            case 'vs_text':
                $form->addElement(new XoopsFormText($caption, $name, 50, 25, $value), $required);
                break;
            case 's_text':
                $form->addElement(new XoopsFormText($caption, $name, 50, 50, $value), $required);
                break;
            case 'm_text':
                $form->addElement(new XoopsFormText($caption, $name, 50, 100, $value), $required);
                break;
            case 'l_text':
                $form->addElement(new XoopsFormText($caption, $name, 50, 255, $value), $required);
                break;
            case 'text':
                $editor_configs           =array();
                $editor_configs['name']   = $name;
                $editor_configs['value']  = $value;
                $editor_configs['rows']   = 2;
                $editor_configs['editor'] = 'Plain Text';
                $form->addElement(new XoopsFormEditor($caption, $name, $editor_configs), $required);
                break;
            case 'select':
                $select_field = new XoopsFormSelect($caption, $name, $value);
                $select_field ->addOption('', '');
                $select_field ->addOptionArray($field_arr[$i]->getVar('field_options'));
                $form->addElement($select_field, $required);
                break;
            case 'select_multi':
                $select_multi_field = new XoopsFormSelect($caption, $name, $value, 5, true);
                $select_multi_field ->addOptionArray($field_arr[$i]->getVar('field_options'));
                $form->addElement($select_multi_field, $required);
                break;
            case 'radio_yn':
                if ($value == ''){
                    $value = 999;
                }
                $radio_yn_field = new XoopsFormSelect($caption, $name, $value);
                $radio_yn_field ->addOption(999, '&nbsp;');
                $radio_yn_field ->addOption(1, _YES);
                $radio_yn_field ->addOption(0, _NO);
                $form->addElement($radio_yn_field, $required);
                break;
            case 'radio':                    
                $radio_field = new XoopsFormRadio($caption, $name, $value);
                $radio_field ->addOptionArray($field_arr[$i]->getVar('field_options'));
                $form->addElement($radio_field, $required);
                break;
            case 'checkbox':
                $checkbox_field = new XoopsFormCheckBox($caption, $name, $value);
                $checkbox_field ->addOptionArray($field_arr[$i]->getVar('field_options'));
                $form->addElement($checkbox_field, $required);
                break;
            case 'number':
                $form->addElement(new XoopsFormText($caption, $name, 15, 50, $value), $required);
                break;
        }
        unset($value);
    }
}
// search
$button = new XoopsFormElementTray('');
$button->addElement(new XoopsFormButton('', 'search', _SEARCH, 'submit'));
$button->addElement(new XoopsFormButton('', 'reset', _RESET, 'submit'));
//$form->addElement(new XoopsFormButtonTray('', _SEARCH, 'submit', 'search.php', true));
$form->addElement($button);

$xoopsTpl->assign('form', $form->render());

if ($search != ''){
	$arguments = 's_cat=' . $s_cat . '&amp;';
	// Criteria
	$criteria = new CriteriaCompo();
	if ($s_name != '') {
		$criteria->add(new Criteria('article_name', '%' . $s_name . '%', 'LIKE'));
		$arguments .= 's_name=' . $s_name . '&amp;';
	}
	if ($s_reference != '') {
		$criteria->add(new Criteria('article_reference', '%' . $s_reference . '%', 'LIKE'));
		$arguments .= 's_reference=' . $s_reference . '&amp;';
	}
    if (count($fielddata_aid_arr) > 0) {
        $criteria->add(new Criteria('article_id', '(' . implode(',', $fielddata_aid_arr) . ')', 'IN'));
    }
	$criteria->setSort('article_name');
	$criteria->setOrder('ASC');
	$criteria->setStart($start);
	$criteria->setLimit($nb_limit);
	if ($s_cat != 0){
		$criteria->add(new Criteria('article_cid', $s_cat));
	}
	$criteria->add(new Criteria('article_status', 1));   
	$articleHandler->table_link = $articleHandler->db->prefix("xmarticle_category");
	$articleHandler->field_link = "category_id";
	$articleHandler->field_object = "article_cid";
	$article_arr = $articleHandler->getByLink($criteria);
	$article_count = $articleHandler->getCount($criteria);
	if ($article_count > 0) {
		foreach (array_keys($article_arr) as $i) {
			$article_id                 = $article_arr[$i]->getVar('article_id');
			$article['id']              = $article_id;
			$article['cid']             = $article_arr[$i]->getVar('article_cid');
			$article['name']            = $article_arr[$i]->getVar('article_name');
			$article['reference']       = $article_arr[$i]->getVar('article_reference');
			$article['description']     = $article_arr[$i]->getVar('article_description', 'show');
			$article['date']            = formatTimestamp($article_arr[$i]->getVar('article_date'), 's');
			$article['author']          = XoopsUser::getUnameFromId($article_arr[$i]->getVar('article_userid'));
			$article_img                = $article_arr[$i]->getVar('article_logo') ?: 'blank.gif';
			$article['logo']            = $url_logo_article .  $article_img;
			$xoopsTpl->append('article', $article);
			unset($article);
		}
		// Display Page Navigation
		if ($article_count > $nb_limit) {
			$nav = new XoopsPageNav($article_count, $nb_limit, $start, 'start', 'search=Y&amp;' . $arguments);
			$xoopsTpl->assign('nav_menu', $nav->renderNav(4));
		}
	} else {
        $xoopsTpl->assign('no_article', true);
    }
}

//SEO
// pagetitle
//$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->name());
//keywords  
//$xoTheme->addMeta('meta', 'keywords', $keywords);
include XOOPS_ROOT_PATH.'/footer.php';
