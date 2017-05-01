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

/**
 * Class XmarticleUtility
 */
class XmarticleUtility
{    
    public static function fieldTypes()
    {
        $types = array(
            'label'         => _MA_XMARTICLE_FIELDTYPE_LABEL,
            'vs_text'       => _MA_XMARTICLE_FIELDTYPE_VSTEXT,
            's_text'        => _MA_XMARTICLE_FIELDTYPE_STEXT,
            'm_text'        => _MA_XMARTICLE_FIELDTYPE_MTEXT,
            'l_text'        => _MA_XMARTICLE_FIELDTYPE_LTEXT,
            'text'          => _MA_XMARTICLE_FIELDTYPE_TEXT,
            'select'        => _MA_XMARTICLE_FIELDTYPE_SELECT,
            'select_multi'  => _MA_XMARTICLE_FIELDTYPE_SELECTMULTI,
            'radio_yn'      => _MA_XMARTICLE_FIELDTYPE_RADIOYN,
            'radio'         => _MA_XMARTICLE_FIELDTYPE_RADIO,
            'checkbox'      => _MA_XMARTICLE_FIELDTYPE_CHECKBOX,
            'number'        => _MA_XMARTICLE_FIELDTYPE_NUMBER);
        return $types;
    }
    
    public static function delFilddataArticle($article_id = 0)
    {
        include __DIR__ . '/../include/common.php';
        if ($article_id == 0){
            return false;
            exit();
        }
        $criteria = new CriteriaCompo();
		$criteria->add(new Criteria('fielddata_aid', $article_id));
        $fielddata_count = $fielddataHandler->getCount($criteria);
		if ($fielddata_count > 0){
            $fielddataHandler->deleteAll($criteria);
        }
        return true;
    }
    
    public static function getPermissionCat($permtype = 'xmarticle_view')
    {
        global $xoopsUser;
        $categories = array();
        $helper = Xmf\Module\Helper::getHelper('xmarticle');
        $moduleHandler = $helper->getModule();
        $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $gpermHandler = xoops_gethandler('groupperm');
        $categories = $gpermHandler->getItemIds($permtype, $groups, $moduleHandler->getVar('mid'));

        return $categories;
    }
	
	public static function saveFielddata($field_type = '', $fielddata_fid = 0, $fielddata_aid = 0, $fielddata_value = '', $action = false)
    {
		if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
		if ($fielddata_fid == 0 || $fielddata_aid == 0 || $field_type == ''){
			redirect_header($action, 2, _MA_XMARTICLE_ERROR);
		}
		include __DIR__ . '/../include/common.php';
		$criteria = new CriteriaCompo();
        $criteria->add(new Criteria('fielddata_fid', $fielddata_fid));
		$criteria->add(new Criteria('fielddata_aid', $fielddata_aid));
		$fielddata_arr = $fielddataHandler->getall($criteria);
		
		if (count($fielddata_arr) == 0) {
			$obj = $fielddataHandler->create();            
		} else {
			foreach (array_keys($fielddata_arr) as $i) {
				$obj = $fielddataHandler->get($fielddata_arr[$i]->getVar('fielddata_id'));
			}
		}		
		
		$error_message = '';
		$obj->setVar('fielddata_fid', $fielddata_fid);
        $obj->setVar('fielddata_aid',  $fielddata_aid);
		switch ($field_type) {
			case 'vs_text':
			case 's_text':
			case 'm_text':
			case 'l_text':
			case 'select':
			case 'radio_yn':
			case 'radio':
				$obj->setVar('fielddata_value1',  $fielddata_value);
				break;
			
			case 'label':
			case 'text':
				$obj->setVar('fielddata_value2',  $fielddata_value);
				break;

			case 'select_multi':
			case 'checkbox':
				$obj->setVar('fielddata_value3',  serialize($fielddata_value));
				break;
				
			case 'number':
				$obj->setVar('fielddata_value4',  $fielddata_value);
				break;
			
		}
		if ($error_message == '') {
            if (!$fielddataHandler->insert($obj)) {
                $error_message =  $obj->getHtmlErrors();
            }
        }
        return $error_message;
    }
	
	public static function getFielddata($fielddata_aid = 0)
    {
		if ($fielddata_aid == 0){
			$values = array();
		} else {
			include __DIR__ . '/../include/common.php';
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('fielddata_aid', $fielddata_aid));
			$fielddata_arr = $fielddataHandler->getall($criteria);
			$values = array();
			foreach (array_keys($fielddata_arr) as $i) {
				if ($fielddata_arr[$i]->getVar('fielddata_value1') != ''){
					$values[$fielddata_arr[$i]->getVar('fielddata_fid')] = $fielddata_arr[$i]->getVar('fielddata_value1');
				}
				if ($fielddata_arr[$i]->getVar('fielddata_value2') != ''){
					$values[$fielddata_arr[$i]->getVar('fielddata_fid')] = $fielddata_arr[$i]->getVar('fielddata_value2', 'e');
				}
				if ($fielddata_arr[$i]->getVar('fielddata_value3') != ''){
					$values[$fielddata_arr[$i]->getVar('fielddata_fid')] = unserialize($fielddata_arr[$i]->getVar('fielddata_value3', 'n'));
				}
				if ($fielddata_arr[$i]->getVar('fielddata_value4') != ''){
					$values[$fielddata_arr[$i]->getVar('fielddata_fid')] = $fielddata_arr[$i]->getVar('fielddata_value4');
				}
			}
		}
        return $values;
    }
	
	public static function getArticleFields($fields = array(), $fielddata_aid = 0)
    {
		$values = array();
		if (count($fields) != 0){
            include __DIR__ . '/../include/common.php';
			// fielddata
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('fielddata_fid', '(' . implode(',', $fields) . ')', 'IN'));
			$criteria->add(new Criteria('fielddata_aid', $fielddata_aid));
			$fielddata_arr = $fielddataHandler->getall($criteria);
			// field
			$criteria = new CriteriaCompo();
			$criteria->setSort('field_weight ASC, field_name');
			$criteria->setOrder('ASC');
			$criteria->add(new Criteria('field_id', '(' . implode(',', $fields) . ')', 'IN'));
			$field_arr = $fieldHandler->getall($criteria);
			foreach (array_keys($field_arr) as $i) {
				$fielddata_value = '';
				foreach (array_keys($fielddata_arr) as $j) {					
					if( $field_arr[$i]->getVar('field_id') == $fielddata_arr[$j]->getVar('fielddata_fid')){
						if ($fielddata_arr[$j]->getVar('fielddata_value1') != ''){
							if ($field_arr[$i]->getVar('field_type') == 'radio_yn'){ 
								if ($fielddata_arr[$j]->getVar('fielddata_value1') == 0){
									$fielddata_value = _NO;
								} else {
									$fielddata_value = _YES;
								}
							} else {
								$fielddata_value = $fielddata_arr[$j]->getVar('fielddata_value1');
							}
						}
						if ($fielddata_arr[$j]->getVar('fielddata_value2') != ''){
							$fielddata_value = $fielddata_arr[$j]->getVar('fielddata_value2', 'e');
						}
						if ($fielddata_arr[$j]->getVar('fielddata_value3') != ''){
							$fielddata_value = implode(', ', unserialize($fielddata_arr[$j]->getVar('fielddata_value3', 'n')));
						}
						if ($fielddata_arr[$j]->getVar('fielddata_value4') != ''){
							$fielddata_value = $fielddata_arr[$j]->getVar('fielddata_value4');
						}						
					}
				}
				$values[] = array($field_arr[$i]->getVar('field_name'), $field_arr[$i]->getVar('field_description'), $fielddata_value);
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
        $criteria = new CriteriaCompo();
        $criteria->setSort('article_name');
        $criteria->setOrder('ASC');
        $criteria->add(new Criteria('article_cid', $category_id));
        $article_arr = $articleHandler->getall($criteria);
        if (count($article_arr) > 0){
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
		if (count($article) == 0){
			redirect_header($action, 2, _MA_XMARTICLE_ERROR_NOARTICLE);
		}
		$newobj = $articleHandler->create();
		$rand_id = rand (1, 10000);			
		$newobj->setVar('article_name', _MA_XMARTICLE_CLONE_NAME . $rand_id . '- ' . $article->getVar('article_name'));
		$newobj->setVar('article_reference', $article->getVar('article_reference') . '-' .$rand_id);
		$newobj->setVar('article_description', $article->getVar('article_description', 'e'));
		$newobj->setVar('article_cid', $article->getVar('article_cid'));
		$newobj->setVar('article_userid', !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0);
		$newobj->setVar('article_date', time());
		$newobj->setVar('article_status', 1);
        return $newobj;
    }
}
