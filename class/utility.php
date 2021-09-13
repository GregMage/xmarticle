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

                        case 'label':
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
        $rand_id = rand(1, 10000);
        $newobj->setVar('article_name', _MA_XMARTICLE_CLONE_NAME . $rand_id . '- ' . $article->getVar('article_name'));
        $newobj->setVar('article_reference', $article->getVar('article_reference') . '-' . $rand_id);
        $newobj->setVar('article_description', $article->getVar('article_description', 'e'));
        $newobj->setVar('article_cid', $article->getVar('article_cid'));
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
				$ref = ' (' . $article->getVar('article_reference') . ')';
			} else {
				$ref = '';
			}
			if ($ulink == true){
				$link = '<a href="' . XOOPS_URL . '/modules/xmarticle/viewarticle.php?category_id=' . $article->getVar('article_cid') . '&article_id=' . $article->getVar('article_id') . '" title="' . $article->getVar('article_name') . '" target="_blank">' . $article->getVar('article_name') . '</a>';
			} else {
				$link = $article->getVar('article_name');
			}		
			return $link . $ref;
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
	
	public static function checkReference($reference = '', $article_id = 0)
    {
		include __DIR__ . '/../include/common.php';
		if ($reference == ''){
			return false;
		} else {
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('article_reference', $reference));
			$criteria->add(new Criteria('article_id', $article_id, '!='));
			$article_count = $articleHandler->getCount($criteria);
			if ($article_count == 0) {
				return true;
			} else {
				return false;
			}
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
}
