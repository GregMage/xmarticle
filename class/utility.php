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
use \Xmf\Request;

/**
 * Class XmarticleUtility
 */
class XmarticleUtility
{
    public static function fieldTypes()
    {
        $types = [
            'label'        => _MA_XMARTICLE_FIELDTYPE_LABEL,
            'vs_text'      => _MA_XMARTICLE_FIELDTYPE_VSTEXT,
            's_text'       => _MA_XMARTICLE_FIELDTYPE_STEXT,
            'm_text'       => _MA_XMARTICLE_FIELDTYPE_MTEXT,
            'l_text'       => _MA_XMARTICLE_FIELDTYPE_LTEXT,
            'text'         => _MA_XMARTICLE_FIELDTYPE_TEXT,
            'select'       => _MA_XMARTICLE_FIELDTYPE_SELECT,
            'select_multi' => _MA_XMARTICLE_FIELDTYPE_SELECTMULTI,
            'radio_yn'     => _MA_XMARTICLE_FIELDTYPE_RADIOYN,
            'radio'        => _MA_XMARTICLE_FIELDTYPE_RADIO,
            'checkbox'     => _MA_XMARTICLE_FIELDTYPE_CHECKBOX,
            'number'       => _MA_XMARTICLE_FIELDTYPE_NUMBER
        ];

        return $types;
    }

    public static function delFilddataArticle($article_id = 0)
    {
        include __DIR__ . '/../include/common.php';
        if ($article_id == 0) {
            return false;
            exit();
        }
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('fielddata_aid', $article_id));
        $fielddata_count = $fielddataHandler->getCount($criteria);
        if ($fielddata_count > 0) {
            $fielddataHandler->deleteAll($criteria);
        }

        return true;
    }

    public static function getPermissionCat($permtype = 'xmarticle_view')
    {
        global $xoopsUser;
        $categories    = [];
        $helper        = Xmf\Module\Helper::getHelper('xmarticle');
        $moduleHandler = $helper->getModule();
        $groups        = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $gpermHandler  = xoops_getHandler('groupperm');
        $categories    = $gpermHandler->getItemIds($permtype, $groups, $moduleHandler->getVar('mid'));

        return $categories;
    }

    public static function saveFielddata($field_type = '', $fielddata_fid = 0, $fielddata_aid = 0, $fielddata_value = '', $action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        if ($fielddata_fid == 0 || $fielddata_aid == 0 || $field_type == '') {
            redirect_header($action, 2, _MA_XMARTICLE_ERROR);
        }
        include __DIR__ . '/../include/common.php';
        switch ($field_type) {
            case 'vs_text':
            case 's_text':
            case 'm_text':
            case 'l_text':
            case 'select':
            case 'radio_yn':
            case 'radio':
                $fieldname_bdd = 'fielddata_value1';
                break;

            case 'label':
            case 'text':
                $fieldname_bdd = 'fielddata_value2';
                break;

            case 'select_multi':
            case 'checkbox':
                $fieldname_bdd = 'fielddata_value3';
                break;

            case 'number':
                $fieldname_bdd = 'fielddata_value4';
                break;
        }
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('fielddata_fid', $fielddata_fid));
        $criteria->add(new Criteria('fielddata_aid', $fielddata_aid));
        $error_message = '';
        if ($field_type == 'select_multi' || $field_type == 'checkbox') {
            $fielddataHandler->deleteAll($criteria);
            if (!empty($fielddata_value)){
                foreach (array_keys($fielddata_value) as $i) {
                    $obj = $fielddataHandler->create();
                    $obj->setVar('fielddata_fid', $fielddata_fid);
                    $obj->setVar('fielddata_aid', $fielddata_aid);
                    $obj->setVar($fieldname_bdd, $fielddata_value[$i]);
                    if ($error_message == '') {
                        if (!$fielddataHandler->insert($obj)) {
                            $error_message = $obj->getHtmlErrors();
                        }
                    }
                }
            }
        } else {
            $fielddata_arr = $fielddataHandler->getall($criteria);
            if (count($fielddata_arr) == 0) {
                $obj = $fielddataHandler->create();
            } else {
                foreach (array_keys($fielddata_arr) as $i) {
                    $obj = $fielddataHandler->get($fielddata_arr[$i]->getVar('fielddata_id'));
                }
            }
            $obj->setVar('fielddata_fid', $fielddata_fid);
            $obj->setVar('fielddata_aid', $fielddata_aid);
            $obj->setVar($fieldname_bdd, $fielddata_value);
            if ($error_message == '') {
                if (!$fielddataHandler->insert($obj)) {
                    $error_message = $obj->getHtmlErrors();
                }
            }
        }

        return $error_message;
    }

    public static function getFielddata($fielddata_aid = 0, $fielddata_fid = 0)
    {
        include __DIR__ . '/../include/common.php';
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('fielddata_aid', $fielddata_aid));
        $criteria->add(new Criteria('fielddata_fid', $fielddata_fid));
        $fielddata_arr = $fielddataHandler->getall($criteria);
        $value         = '';
        foreach (array_keys($fielddata_arr) as $i) {
            if ($fielddata_arr[$i]->getVar('fielddata_value1') != '') {
                $value = $fielddata_arr[$i]->getVar('fielddata_value1');
            }
            if ($fielddata_arr[$i]->getVar('fielddata_value2') != '') {
                $value = $fielddata_arr[$i]->getVar('fielddata_value2', 'e');
            }
            if ($fielddata_arr[$i]->getVar('fielddata_value3') != '') {
                if ($value == '') {
                    $seperator = '';
                } else {
                    $seperator = ',';
                }
                $value .= $seperator . $fielddata_arr[$i]->getVar('fielddata_value3');
            }
            if ($fielddata_arr[$i]->getVar('fielddata_value4') != '') {
                $value = $fielddata_arr[$i]->getVar('fielddata_value4');
            }
        }

        return $value;
    }

    public static function getArticleFields($fields = [], $fielddata_aid = 0)
    {
        $values = [];
        if (count($fields) != 0) {
            include __DIR__ . '/../include/common.php';
            // field
            $criteria = new CriteriaCompo();
            $criteria->setSort('field_weight ASC, field_name');
            $criteria->setOrder('ASC');
            $criteria->add(new Criteria('field_id', '(' . implode(',', $fields) . ')', 'IN'));
            $field_arr = $fieldHandler->getall($criteria);
            foreach (array_keys($field_arr) as $i) {
                $fielddata_value = '';
                // fielddata
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('fielddata_fid', $field_arr[$i]->getVar('field_id')));
                $criteria->add(new Criteria('fielddata_aid', $fielddata_aid));
                $fielddata_arr = $fielddataHandler->getall($criteria);
                if ($field_arr[$i]->getVar('field_type') == 'label') {
                    $fielddata_value = $field_arr[$i]->getVar('field_default', 'n');
                }
                foreach (array_keys($fielddata_arr) as $j) {
                    switch ($field_arr[$i]->getVar('field_type')) {
                        case 'vs_text':
                        case 's_text':
                        case 'm_text':
                        case 'l_text':
                            $fielddata_value = $fielddata_arr[$j]->getVar('fielddata_value1');
                            break;

                        case 'radio_yn':
                            if ($fielddata_arr[$j]->getVar('fielddata_value1') == 0) {
                                $fielddata_value = _NO;
                            } else {
                                $fielddata_value = _YES;
                            }
                            break;

                        case 'select':
                        case 'radio':
                            $fielddata_value = $field_arr[$i]->getVar('field_options')[$fielddata_arr[$j]->getVar('fielddata_value1')];
                            break;

                        case 'text':
                            $fielddata_value = $fielddata_arr[$j]->getVar('fielddata_value2', 'e');
                            break;

                        case 'select_multi':
                        case 'checkbox':
                            if ($fielddata_value == '') {
                                $seperator = '';
                            } else {
                                $seperator = $helper->getConfig('general_separator', '-');
                            }
                            $fielddata_value .= $seperator . $field_arr[$i]->getVar('field_options')[$fielddata_arr[$j]->getVar('fielddata_value3')];
                            break;

                        case 'number':
                            $fielddata_value = $fielddata_arr[$j]->getVar('fielddata_value4');
                            break;
                    }
                }
                $values[] = [$field_arr[$i]->getVar('field_name'), $field_arr[$i]->getVar('field_description'), $fielddata_value];
            }
        }

        return $values;
    }

    public static function articlePerCat($category_id, $article_arr)
    {
        $count = 0;
        foreach (array_keys($article_arr) as $i) {
            if ($article_arr[$i]->getVar('article_cid') == $category_id) {
                $count++;
            }
        }

        return $count;
    }

    public static function articleNamePerCat($category_id)
    {
        include __DIR__ . '/../include/common.php';
        $article_name = '';
        $criteria     = new CriteriaCompo();
        $criteria->setSort('article_name');
        $criteria->setOrder('ASC');
        $criteria->add(new Criteria('article_cid', $category_id));
        $article_arr = $articleHandler->getall($criteria);
        if (count($article_arr) > 0) {
            $article_name .= _MA_XMARTICLE_CATEGORY_WARNINGDELARTICLE . '<br>';
            foreach (array_keys($article_arr) as $i) {
                $article_name .= $article_arr[$i]->getVar('article_name') . '<br>';
            }
        }

        return $article_name;
    }

    public static function cloneArticle($article_id, $action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include __DIR__ . '/../include/common.php';
        $article = $articleHandler->get($article_id);
        if (empty($article)) {
            redirect_header($action, 2, _MA_XMARTICLE_ERROR_NOARTICLE);
        }
        $newobj  = $articleHandler->create();

        if ($helper->getConfig('general_clone', 0) == 1){
            $rand_id = rand(1, 10000);
            $newobj->setVar('article_name', _MA_XMARTICLE_CLONE_NAME . $rand_id . '- ' . $article->getVar('article_name'));
        } else {
            $newobj->setVar('article_name', $article->getVar('article_name'));
        }
        $newobj->setVar('article_description', $article->getVar('article_description', 'e'));
        $newobj->setVar('article_cid', $article->getVar('article_cid'));
		$newobj->setVar('article_logo', $article->getVar('article_logo'));
        $newobj->setVar('article_douser', $article->getVar('article_douser'));
        $newobj->setVar('article_dodate', $article->getVar('article_dodate'));
        $newobj->setVar('article_domdate', $article->getVar('article_domdate'));
        $newobj->setVar('article_dohits', $article->getVar('article_dohits'));
        $newobj->setVar('article_dorating', $article->getVar('article_dorating'));
        $newobj->setVar('article_docomment', $article->getVar('article_docomment'));
        $newobj->setVar('article_userid', !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0);
        $newobj->setVar('article_date', time());
        $newobj->setVar('article_status', 1);

        return $newobj;
    }

	public static function getArticleList($efl = false)
    {
        include __DIR__ . '/../include/common.php';
		$articlelist = array();

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('article_status', 1));
		$criteria->setSort('article_name');
        $criteria->setOrder('ASC');
		$articleHandler->table_link = $articleHandler->db->prefix("xmarticle_category");
        $articleHandler->field_link = "category_id";
        $articleHandler->field_object = "article_cid";
        $article_arr = $articleHandler->getByLink($criteria);
		if ($efl == true){
			$articlelist[0] = "-";
		}
		if (count($article_arr) > 0) {
			foreach (array_keys($article_arr) as $i) {
				$articlelist[$i] = $article_arr[$i]->getVar('article_name') . ' (' . $article_arr[$i]->getVar('article_reference') .')';
			}
		}
        return $articlelist;
    }

	/**
     * Fonction qui permet d'afficher le nom d'un article
	 * @param int      $articleid	Id de l'article
     * @param boolean  $uref		Afficher la référence
     * @param boolean  $ulink		Nom sous forme de lien
	 * @return string   			Nom selon les options ou message d'erreur
     */

	public static function getArticleName($articleid, $uref = true, $ulink = true)
    {
        include __DIR__ . '/../include/common.php';

		$article = $articleHandler->get($articleid);
		if (isset($article)){
			if ($uref == true){
				$ref = $article->getVar('article_reference') . " ";
			} else {
				$ref = '';
			}
			if ($ulink == true){
				$link = '<a href="' . XOOPS_URL . '/modules/xmarticle/viewarticle.php?category_id=' . $article->getVar('article_cid') . '&article_id=' . $article->getVar('article_id') . '" title="' . $article->getVar('article_name') . '" target="_blank">' . $article->getVar('article_name') . '</a>';
			} else {
				$link = $article->getVar('article_name');
			}
			return $ref . $link;
		} else {
			return 'Error: The requested item does not exist! (ID-' . $articleid . ')';
		}
    }

	public static function renderArticleForm($form, $caption, $itemid = 0)
    {
        xoops_load('formarticle', 'xmarticle');
		$form->addElement(new XmarticleFormArticle($caption, $itemid), false);
        return $form;
    }

	public static function renderArticleIdSave()
    {
		$sessionHelper = new \Xmf\Module\Helper\Session('xmarticle');
		if ($sessionHelper->get('selectionarticle') != false){
			$selectionarticle = $sessionHelper->get('selectionarticle');
			$sessionHelper->del('selectionarticle');
			return $selectionarticle;
		} else {
			return 0;
		}
    }

	public static function returnBytes($val)
	{
		switch (mb_substr($val, -1)) {
			case 'K':
			case 'k':
				return (int)$val * 1024;
			case 'M':
			case 'm':
				return (int)$val * 1048576;
			case 'G':
			case 'g':
				return (int)$val * 1073741824;
			default:
				return $val;
		}
	}

	public static function getServerStats()
    {
        $moduleDirName      = basename(dirname(dirname(__DIR__)));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);
        xoops_loadLanguage('common', $moduleDirName);
        $html = '';
        $html .= "<fieldset><legend style='font-weight: bold; color: #900;'>" . _MA_XMARTICLE_INDEX_IMAGEINFO . "</legend>\n";
        $html .= "<div style='padding: 8px;'>\n";
        $html .= '<div>' . _MA_XMARTICLE_INDEX_SPHPINI . "</div>\n";
        $html .= "<ul>\n";
        $downloads = ini_get('file_uploads') ? '<span style="color: #008000;">' . _MA_XMARTICLE_INDEX_ON . '</span>' : '<span style="color: #ff0000;">' . _MA_XMARTICLE_INDEX_OFF . '</span>';
        $html      .= '<li>' . _MA_XMARTICLE_INDEX_SERVERUPLOADSTATUS . $downloads;
        $html .= '<li>' . _MA_XMARTICLE_INDEX_MAXUPLOADSIZE . ' <b><span style="color: #0000ff;">' . ini_get('upload_max_filesize') . "</span></b>\n";
        $html .= '<li>' . _MA_XMARTICLE_INDEX_MAXPOSTSIZE . ' <b><span style="color: #0000ff;">' . ini_get('post_max_size') . "</span></b>\n";
        $html .= '<li>' . _MA_XMARTICLE_INDEX_MEMORYLIMIT . ' <b><span style="color: #0000ff;">' . ini_get('memory_limit') . "</span></b>\n";
        $html .= "</ul>\n";
        $html .= '</div>';
        $html .= '</fieldset><br>';

        return $html;
    }

	public static function generateDescriptionTagSafe($text, $wordCount = 100)
    {
		if (xoops_isActiveModule('xlanguage')){
			$text = XoopsModules\Xlanguage\Utility::cleanMultiLang($text);
		}
		$text = \Xmf\Metagen::generateDescription($text, $wordCount);
		return $text;
	}

	public static function TagSafe($text)
    {
		if (xoops_isActiveModule('xlanguage')){
			$text = XoopsModules\Xlanguage\Utility::cleanMultiLang($text);
		}
		return $text;
	}

    public static function CheckArticleUse($article_id)
    {
		$text = '';
        if (xoops_isActiveModule('xmprod')){
            $helper_xmprod = Helper::getHelper('xmprod');

            $nomenclatureHandler = $helper_xmprod->getHandler('xmprod_nomenclature');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('nomenclature_articleid', $article_id));
            if($nomenclatureHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans une nomenclature';
            }

            $ofsHandler = $helper_xmprod->getHandler('xmprod_ofs');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('ofs_articleid', $article_id));
            if($ofsHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans un OF';
            }

            $oasHandler = $helper_xmprod->getHandler('xmprod_oas');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('oas_articleid', $article_id));
            if($oasHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans un OA';
            }

            $needsHandler = $helper_xmprod->getHandler('xmprod_needs');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('needs_articleid', $article_id));
            if($needsHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans un besoin';
            }
		}
        if (xoops_isActiveModule('xmstock')){
            $helper_stock = Helper::getHelper('xmstock');
            $stockHandler = $helper_stock->getHandler('xmstock_stock');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('stock_articleid', $article_id));
            if($stockHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans un stock';
            }

            $transferHandler = $helper_stock->getHandler('xmstock_transfer');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('transfer_articleid', $article_id));
            if($transferHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans un transfert';
            }

            $itemorderHandler = $helper_stock->getHandler('xmstock_itemorder');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('itemorder_articleid', $article_id));
            if($itemorderHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans une commande';
            }

            $loanHandler = $helper_stock->getHandler('xmstock_loan');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('loan_articleid', $article_id));
            if($loanHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans un prêt';
            }

            $priceHandler = $helper_stock->getHandler('xmstock_price');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('price_articleid', $article_id));
            if($priceHandler->getCount($criteria) > 0) {
                $text .= '<br>' . 'L\'article est utilisé dans la table de prix';
            }
		}
		return $text;
	}

    public static function creatFolder($path = '', $id = 0)
    {
        $dir = $path . $id;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        //Copy index.php
        $indexFile = XOOPS_ROOT_PATH . '/modules/xmarticle/include/index.php';
        copy($indexFile, $dir . '/index.php');
        return true;
    }

    public static function search($xoopsTpl, $action)
    {
        include __DIR__ . '/../include/common.php';
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $values = array();
        // Form
        $article_name = Request::getString('name', '');
        $article_reference = Request::getString('ref', '');
        $article_description = Request::getString('desc', '');
        $article_cid = Request::getInt('cid', 0);
        $n_field = Request::getInt('n_field', 0);
        $start  = Request::getInt('start', 0);
        $xoopsTpl->assign('start', $start);
        $arguments['cid'] = $article_cid;
        $arguments['n_field'] = $n_field;
        //filters
        $order = Request::getInt('order', 1);
        $xoopsTpl->assign('order', $order);
        $sort = Request::getInt('sort', 0);
        $xoopsTpl->assign('sort', $sort);
        $filter = Request::getInt('filter', 10);
        $xoopsTpl->assign('filter', $filter);
        $display = Request::getInt('display', 0);
        $xoopsTpl->assign('display', $display);

        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('article_status', 1));

        if ($article_name != '') {
            $criteria->add(new Criteria('article_name', '%' . $article_name . '%', 'LIKE'));
            $arguments['name'] = $article_name;
        }
        if ($article_reference != '') {
            $criteria->add(new Criteria('article_reference', '%' . $article_reference . '%', 'LIKE'));
            $arguments['ref'] = $article_reference;
        }
        if ($article_description != '') {
            $criteria->add(new Criteria('article_description', '%' . $article_description . '%', 'LIKE'));
            $arguments['desc'] = $article_description;
        }
        switch ($order) {
            default:
            case 1:
                $criteria->setSort('article_name');
                if ($sort == 0){
                    $criteria->setOrder('ASC');
                } else {
                    $criteria->setOrder('DESC');
                }
                break;
            case 2:
                $criteria->setSort('article_date');
                if ($sort == 0){
                    $criteria->setOrder('DESC');
                } else {
                    $criteria->setOrder('ASC');
                }
                break;
            case 3:
                $criteria->setSort('article_counter');
                if ($sort == 0){
                    $criteria->setOrder('DESC');
                } else {
                    $criteria->setOrder('ASC');
                }
                break;
            case 4:
                $criteria->setSort('article_reference');
                if ($sort == 0){
                    $criteria->setOrder('DESC');
                } else {
                    $criteria->setOrder('ASC');
                }
                break;
        }

        if ($article_cid != 0) {
            $criteria->add(new Criteria('article_cid', $article_cid));
        } else {
            $viewPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_view');
            $criteria->add(new Criteria('article_cid', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
        }
        // recherche sur les champs sup.
        if ($n_field != 0){
            $fielddata_aid_arr = [];
            include_once XOOPS_ROOT_PATH . '/modules/xmarticle/class/criteriaempty.php';
            for ($i = 1; $i <= $n_field; $i++) {
                $criteria_field = new CriteriaCompo();
                $value_fnex = '';
                $value_fnma = '';
                $value_fnmi = '';
                $useFieldSearch = false;
                if (isset($_REQUEST ['fid_' . $i])) {
                    $fid = $_REQUEST ['fid_' . $i];
                    $arguments['fid_' . $i] = $fid;
                }

                if (isset($_REQUEST ['f_' . $i])) {
                    $value = $_REQUEST ['f_' . $i];
                    if ($value != '' && $value != 999) {
                        $values[$fid]['value'] = $value;
                        $useFieldSearch = true;
                        $arguments['f_' . $i] = $value;
                    }
                }
                if (isset($_REQUEST ['fnex_' . $i])) {
                    $value_fnex = $_REQUEST ['fnex_' . $i];
                    if ($value_fnex != '') {
                        $arguments['fnex_' . $i] = $value_fnex;
                        $values[$fid]['fnex'] = $value_fnex;
                        $useFieldSearch = true;
                    }
                }
                if (isset($_REQUEST ['fnmi_' . $i]) && $value_fnex == '') {
                    $value_fnmi = $_REQUEST ['fnmi_' . $i];
                    if ($value_fnmi != '') {
                        $arguments['fnmi_' . $i] = $value_fnmi;
                        $values[$fid]['fnmi'] = $value_fnmi;
                        $useFieldSearch = true;
                    }
                }
                if (isset($_REQUEST ['fnma_' . $i]) && $value_fnex == '') {
                    $value_fnma = $_REQUEST ['fnma_' . $i];
                    if ($value_fnma != '') {
                        $arguments['fnma_' . $i] = $value_fnma;
                        $values[$fid]['fnma'] = $value_fnma;
                        $useFieldSearch = true;
                    }
                }
                if (isset($_REQUEST ['t_' . $i])) {
                    $type = $_REQUEST ['t_' . $i];
                    $selsearch = $_REQUEST ['sels_' . $i];
                    $arguments['sels_' . $i] = $selsearch;
					if ($useFieldSearch == true) {
                        if (isset($_REQUEST ['fid_' . $i])) {
                            $criteria_field->add(new Criteria('fielddata_fid', $_REQUEST ['fid_' . $i]));
                        }
                        $arguments['t_' . $i] = $type;
						switch ($type) {
							case 'vs_text':
							case 's_text':
							case 'm_text':
							case 'l_text':
                                if ($selsearch == 1) {
                                    $empty = false;
                                    if ($value != '') {
                                        $value_bdd = '';
                                        foreach (array_keys($value) as $k) {
                                            if ($value_bdd == '') {
                                                $seperator = '';
                                            } else {
                                                $seperator = ', ';
                                            }
                                            if ($value[$k] == '[empty]'){
                                                $empty = true;
                                            } else {
                                                $value_bdd .= $seperator . '"' . $value[$k] . '"';
                                            }
                                        }
                                        if ($empty == true && $value_bdd == ''){
                                            $criteria_field->add(new CriteriaAllowEmpty('fielddata_value1', ''));
                                        }
                                        if ($value_bdd != ''){
                                            $value_bdd = '(' . $value_bdd . ')';
                                            $criteria_field->add(new Criteria('fielddata_value1', $value_bdd, 'IN'));
                                        }

                                    }
                                } else {
                                    if ($value == '[empty]'){
                                        $criteria_field->add(new CriteriaAllowEmpty('fielddata_value1', ''));
                                    } else {
                                        $criteria_field->add(new Criteria('fielddata_value1', '%' . $value . '%', 'LIKE'));
                                    }
                                }
								break;

							case 'select':
                                $value_bdd = '';
								if ($value != '') {
									foreach (array_keys($value) as $k) {
										if ($value_bdd == '') {
											$seperator = '';
										} else {
											$seperator = ', ';
										}
										$value_bdd .= $seperator . '"' . $value[$k] . '"';
									}
									$value_bdd = '(' . $value_bdd . ')';
								}
								$criteria_field->add(new Criteria('fielddata_value1', $value_bdd, 'IN'));
								break;

							case 'radio_yn':
							case 'radio':
								$criteria_field->add(new Criteria('fielddata_value1', $value));
								break;

							case 'text':
                                $criteria_field->add(new Criteria('fielddata_value2', '%' . $value . '%', 'LIKE'));
								break;

							case 'select_multi':
							case 'checkbox':
								if ($value != '') {
									$value_bdd = '';
									foreach (array_keys($value) as $k) {
										if ($value_bdd == '') {
											$seperator = '';
										} else {
											$seperator = ', ';
										}
										$value_bdd .= $seperator . '"' . $value[$k] . '"';
									}
									$value_bdd = '(' . $value_bdd . ')';
								}
								$criteria_field->add(new Criteria('fielddata_value3', $value_bdd, 'IN'));
								break;

							case 'number':
								if (isset($_REQUEST ['fnex_' . $i])) {
									$value_fnex = $_REQUEST ['fnex_' . $i];
									if ($value_fnex != '') {
										$criteria_field->add(new Criteria('fielddata_value4', $value_fnex));
									}
								}
								if ($value_fnmi != '') {
									$criteria_field->add(new Criteria('fielddata_value4', $value_fnmi, '<='));
								}
								if ($value_fnma != '') {
									$criteria_field->add(new Criteria('fielddata_value4', $value_fnma, '>='));
								}
								break;
						}
						if (count($fielddata_aid_arr) > 0) {
							$criteria_field->add(new Criteria('fielddata_aid', '(' . implode(',', $fielddata_aid_arr) . ')', 'IN'));
							$fielddata_aid_arr = [];
						}
						$fielddata_arr = $fielddataHandler->getall($criteria_field);
						if (count($fielddata_arr) == 0) {
							$fielddata_aid_arr[] = 0;
						} else {
							foreach (array_keys($fielddata_arr) as $j) {
								$fielddata_aid_arr[] = $fielddata_arr[$j]->getVar('fielddata_aid');
							}
						}
                    }
                }
                unset($value);
            }
            if (count($fielddata_aid_arr) > 0) {
                $criteria->add(new Criteria('article_id', '(' . implode(',', $fielddata_aid_arr) . ')', 'IN'));
            }
        }
        $criteria->setStart($start);
        $criteria->setLimit($filter);
        $articleHandler->table_link   = $articleHandler->db->prefix("xmarticle_category");
        $articleHandler->field_link   = "category_id";
        $articleHandler->field_object = "article_cid";
        $article_arr                  = $articleHandler->getByLink($criteria);
        $article_count                = $articleHandler->getCount($criteria);
        //xmsocial
        if (xoops_isActiveModule('xmsocial') && $helper->getConfig('general_xmsocial', 0) == 1) {
            $xmsocial = true;
            xoops_load('utility', 'xmsocial');
        } else {
            $xmsocial = false;
        }
		// Encode arguments en url
        $arguments_url = http_build_query($arguments);
        $xoopsTpl->assign('arguments', $arguments_url);
        $xoopsTpl->assign('xmsocial', $xmsocial);
        $xoopsTpl->assign('article_count', $article_count);
        if ($article_count > 0) {
            foreach (array_keys($article_arr) as $i) {
                $article_id             = $article_arr[$i]->getVar('article_id');
                $article['id']          = $article_id;
                $article['cid']         = $article_arr[$i]->getVar('article_cid');
                $article['name']        = $article_arr[$i]->getVar('article_name');
                $article['reference']   = $article_arr[$i]->getVar('article_reference');
                $article['description'] = XmarticleUtility::TagSafe($article_arr[$i]->getVar('article_description', 'show'));
                $article['date']        = formatTimestamp($article_arr[$i]->getVar('article_date'), 's');
                if ($article_arr[$i]->getVar('article_mdate') != 0) {
                    $article['mdate'] 		 = formatTimestamp($article_arr[$i]->getVar('article_mdate'), 's');
                }
                $article['author']      = XoopsUser::getUnameFromId($article_arr[$i]->getVar('article_userid'));
                $article_img            = $article_arr[$i]->getVar('article_logo');
                if ($article_img == ''){
                    $article['logo']    = '';
                } else {
                    $article['logo']    = $url_logo_article . $article_arr[$i]->getVar('article_cid') . '/' . $article_img;
                }
                $color					= $article_arr[$i]->getVar('category_color');
                if ($color == '#ffffff'){
                    $article['color']	= false;
                } else {
                    $article['color']   = $color;
                }
                if ($xmsocial == true){
                    $article['rating'] = XmsocialUtility::renderVotes($article_arr[$i]->getVar('article_rating'), $article_arr[$i]->getVar('article_votes'));
                }
                $article['counter']     = $article_arr[$i]->getVar('article_counter');
                $article['douser']      = $article_arr[$i]->getVar('article_douser');
                $article['dodate']      = $article_arr[$i]->getVar('article_dodate');
                $article['domdate']     = $article_arr[$i]->getVar('article_domdate');
                $article['dohits']      = $article_arr[$i]->getVar('article_dohits');
                $article['dorating']    = $article_arr[$i]->getVar('article_dorating');
                $xoopsTpl->append('articles', $article);
                unset($article);
            }
            // Display Page Navigation
            if ($article_count > $filter) {
                $nav = new XoopsPageNav($article_count, $filter, $start, 'start', 'op=search&amp;' . $arguments_url . '&amp;order=' . $order . '&amp;' . 'sort=' . $sort . '&amp;' . 'filter=' . $filter . '&amp;' . 'display=' . $display);
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('no_article', true);
        }
        // form
        $obj = $articleHandler->create();
        $obj->setVar('article_name', $article_name);
        $obj->setVar('article_reference', $article_reference);
        $obj->setVar('article_description', $article_description);
        $obj->setVar('article_cid', $article_cid);
        $obj->setVar('order', $order);
        $obj->setVar('sort', $sort);
        $obj->setVar('filter', $filter);
        $obj->setVar('display', $display);
        $form = $obj->getFormSearch($action, $values);
        $xoopsTpl->assign('form', $form->render());

        return true;
    }
}
