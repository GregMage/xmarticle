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
	
	public static function saveFielddata($field_type = '', $fielddata_fid = 0, $fielddata_aid = 0, $fielddata_value = '', $action = false)
    {
		if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
		if ($fielddata_fid == 0 || $fielddata_aid == 0 || $field_type == ''){
			redirect_header($action, 2, _MA_XMARTICLE_ERROR);
		}
		$fielddataHandler = xoops_getModuleHandler('xmarticle_fielddata', 'xmarticle');
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
			$fielddataHandler = xoops_getModuleHandler('xmarticle_fielddata', 'xmarticle');
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
}
