﻿<?php
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
use Xmf\Request;
use Xmf\Module\Helper;

defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

/**
 * Class xmarticle_article
 */
class xmarticle_article extends XoopsObject
{

    // constructor
    /**
     * xmarticle_article constructor.
     */
    public function __construct()
    {
        $this->initVar('article_id', XOBJ_DTYPE_INT, null);
        $this->initVar('article_cid', XOBJ_DTYPE_INT, null);
        $this->initVar('article_reference', XOBJ_DTYPE_TXTBOX, null);
        $this->initVar('article_name', XOBJ_DTYPE_TXTBOX, null);
        $this->initVar('article_description', XOBJ_DTYPE_TXTAREA);
		// use html
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('article_logo', XOBJ_DTYPE_TXTBOX, null);
		$this->initVar('article_userid', XOBJ_DTYPE_INT, 0);
		$this->initVar('article_date', XOBJ_DTYPE_INT, 0);
		$this->initVar('article_mdate', XOBJ_DTYPE_INT, 0);
		$this->initVar('article_rating', XOBJ_DTYPE_OTHER, null, false, 10);
        $this->initVar('article_votes', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('article_counter', XOBJ_DTYPE_INT, null, false, 8);
		$this->initVar('article_douser', XOBJ_DTYPE_INT, 1, false, 1);
		$this->initVar('article_dodate', XOBJ_DTYPE_INT, 1, false, 1);
		$this->initVar('article_domdate', XOBJ_DTYPE_INT, 1, false, 1);
		$this->initVar('article_dohits', XOBJ_DTYPE_INT, 1, false, 1);
		$this->initVar('article_dorating', XOBJ_DTYPE_INT, 1, false, 1);
		$this->initVar('article_docomment', XOBJ_DTYPE_INT, 1, false, 1);
        $this->initVar('article_status', XOBJ_DTYPE_INT, 1);
        $this->initVar('category_name',XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('category_fields', XOBJ_DTYPE_ARRAY, []);
		$this->initVar('category_color', XOBJ_DTYPE_TXTBOX, '#ffffff', false);
		// pour la recherche
		$this->initVar('order', XOBJ_DTYPE_INT, null, false, 4);
		$this->initVar('sort', XOBJ_DTYPE_INT, null, false, 1);
		$this->initVar('filter', XOBJ_DTYPE_INT, null, false, 4);
		$this->initVar('display', XOBJ_DTYPE_INT, null, false, 1);
    }

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getFormCategory($action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        include __DIR__ . '/../include/common.php';

        // Get Permission to submit
        $submitPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_submit');

        $form = new XoopsThemeForm(_MA_XMARTICLE_ADD, 'form', $action, 'post', true);
        // type
        $field_cat = new XoopsFormSelect(_MA_XMARTICLE_ARTICLE_CATEGORY, 'article_cid', $this->getVar('article_cid'));
        $criteria = new CriteriaCompo();
		$criteria->add(new Criteria('category_status', 1));
        $criteria->setSort('category_weight ASC, category_name');
        $criteria->setOrder('ASC');
        if (!empty($submitPermissionCat)){
            $criteria->add(new Criteria('category_id', '(' . implode(',', $submitPermissionCat) . ')','IN'));
        }
        $category_arr = $categoryHandler->getall($criteria);
        if (count($category_arr) == 0 || empty($submitPermissionCat)){
            redirect_header($action, 3, _MA_XMARTICLE_ERROR_NOACESSCATEGORY);
        }
        foreach (array_keys($category_arr) as $i) {
            $field_cat->addOption($category_arr[$i]->getVar('category_id'), $category_arr[$i]->getVar('category_name'));
        }
        $form->addElement($field_cat, true);
        $form->addElement(new XoopsFormHidden('op', 'loadarticle'));
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }

    /**
    * @param bool $action
    * @return XoopsThemeForm
    */
    public function getForm($article_cid = 0, $old_article_cid = 0, $action = false, $clone = false)
    {
        global $xoopsUser;

        $helper = Helper::getHelper('xmarticle');
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        include __DIR__ . '/../include/common.php';

        //form title
        $title = $this->isNew() ? sprintf(_MA_XMARTICLE_ADD) : sprintf(_MA_XMARTICLE_EDIT);

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        if (!$this->isNew() || $clone == true) {
            $form->addElement(new XoopsFormHidden('article_id', $this->getVar('article_id')));
            $article_cid = $this->getVar('article_cid');
			if ($clone == true) {
				$article_cid_fielddata = $old_article_cid;
			} else {
				$article_cid_fielddata = $this->getVar('article_id');
			}
        } else {
			if ($old_article_cid != 0){
                $article_cid_fielddata = $old_article_cid;
			} else {
				$article_cid_fielddata = 0;
			}
        }
        // category
        $category = $categoryHandler->get($article_cid);
		$category_img = $category->getVar('category_logo');
		if ($category_img == ''){
			$category_logo = '';
		} else {
			$category_logo = '<img src="' . $url_logo_category .  $category_img . '" alt="' . $category_img . '" style="max-width:100px" /> ';
		}

        $form->addElement(new xoopsFormLabel (_MA_XMARTICLE_ARTICLE_CATEGORY, $category_logo . '<strong>' . $category->getVar('category_name') . '</strong>'));
        $form->addElement(new XoopsFormHidden('article_cid', $article_cid));

        // title
        $form->addElement(new XoopsFormText(_MA_XMARTICLE_ARTICLE_NAME, 'article_name', 50, 255, $this->getVar('article_name')), true);

        // reference
		if (!$this->isNew()) {
        	$form->addElement(new XoopsFormLabel(_MA_XMARTICLE_ARTICLE_REFERENCE, $this->getVar('article_reference')));
		}

        // description
        $editor_configs           = [];
        $editor_configs['name']   = 'article_description';
        $editor_configs['value']  = $this->getVar('article_description', 'e');
        $editor_configs['rows']   = 20;
        $editor_configs['cols']   = 160;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $helper->getConfig('admin_editor', 'Plain Text');
        $form->addElement(new XoopsFormEditor(_MA_XMARTICLE_ARTICLE_DESC, 'article_description', $editor_configs), false);
        // logo
        $blank_img 		 = $this->getVar('article_logo') ?: 'no-image.png';
		$uploadirectory  = str_replace(XOOPS_URL, '', $url_logo_article) . $article_cid . '/';
        $imgtray_img     = new XoopsFormElementTray(_MA_XMARTICLE_ARTICLE_LOGOFILE . '<br><br>' . sprintf(_MA_XMARTICLE_ARTICLE_UPLOADSIZE, $upload_size / 1024), '<br>');
        $imgpath_img     = sprintf(_MA_XMARTICLE_ARTICLE_FORMPATH, $uploadirectory);
        $imageselect_img = new XoopsFormSelect($imgpath_img, 'article_logo', $blank_img);
        $image_array_img = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $uploadirectory);
        $imageselect_img->addOption("no-image.png", $blank_img);
        foreach ($image_array_img as $image_img) {
            $imageselect_img->addOption("$image_img", $image_img);
        }
        $imageselect_img->setExtra("onchange='showImgSelected(\"image_img2\", \"article_logo\", \"" . $uploadirectory . "\", \"\", \"" . XOOPS_URL . "\")'");
        $imgtray_img->addElement($imageselect_img, false);
        $imgtray_img->addElement(new XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $uploadirectory . '/' . $blank_img . "' name='image_img2' id='image_img2' alt='' style='max-width:100px'>"));
        $fileseltray_img = new XoopsFormElementTray('<br>', '<br><br>');
        $fileseltray_img->addElement(new XoopsFormFile(_MA_XMARTICLE_ARTICLE_UPLOAD, 'article_logo', $upload_size), false);
        $fileseltray_img->addElement(new XoopsFormLabel(''), false);
        $imgtray_img->addElement($fileseltray_img);
        $form->addElement($imgtray_img);

        //xmdoc
        if (xoops_isActiveModule('xmdoc') && $helper->getConfig('general_xmdoc', 0) == 1) {
            xoops_load('utility', 'xmdoc');
            XmdocUtility::renderDocForm($form, 'xmarticle', $this->getVar('article_id'));
        }

		// field
		if (!empty($category->getVar('category_fields'))) {
			$criteria = new CriteriaCompo();
			$criteria->setSort('field_weight ASC, field_name');
			$criteria->setOrder('ASC');
        	$criteria->add(new Criteria('field_id', '(' . implode(',', $category->getVar('category_fields')) . ')', 'IN'));
			$criteria->add(new Criteria('field_status', 0, '!='));
			$field_arr = $fieldHandler->getall($criteria);
			foreach (array_keys($field_arr) as $i) {
				$caption = $field_arr[$i]->getVar('field_name') . '<br><span style="font-weight:normal;">' . $field_arr[$i]->getVar('field_description', 'show') . '</span>';
				if ($field_arr[$i]->getVar('field_required') == 1){
					$required = true;
				} else {
					$required = false;
				}
				$value = XmarticleUtility::getFielddata($article_cid_fielddata, $field_arr[$i]->getVar('field_id'));
				if ($value == ''){
					if ($field_arr[$i]->getVar('field_type') == 'text'){
						$value = $field_arr[$i]->getVar('field_default', 'e');
					} elseif ($field_arr[$i]->getVar('field_type') == 'select_multi' || $field_arr[$i]->getVar('field_type') == 'checkbox'){
						if ($field_arr[$i]->getVar('field_default', 'n') != ''){
							$value =  implode(',', array_flip(unserialize($field_arr[$i]->getVar('field_default', 'n'))));
						}
					} else {
						if ($field_arr[$i]->getVar('field_type') == 'label'){
							$value = $field_arr[$i]->getVar('field_default', 'n');
						} else {
							$value = $field_arr[$i]->getVar('field_default');
						}
					}
				}
				$name = 'field_' . $i;
				switch ($field_arr[$i]->getVar('field_type')) {
					case 'label':
						$form->addElement(new XoopsFormLabel($caption, $value, $name), $required);
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
						$editor_configs           = [];
						$editor_configs['name']   = $name;
						$editor_configs['value']  = $value;
						$editor_configs['rows']   = 2;
						$editor_configs['editor'] = 'Plain Text';
						$form->addElement(new XoopsFormEditor($caption, $name, $editor_configs), $required);
						break;
					case 'select':
						$select_field = new XoopsFormSelect($caption, $name, $value);
						$select_field ->addOptionArray($field_arr[$i]->getVar('field_options'));
						$form->addElement($select_field, $required);
						break;
					case 'select_multi':
						$select_multi_field = new XoopsFormSelect($caption, $name, explode(',', $value), 5, true);
						$select_multi_field ->addOptionArray($field_arr[$i]->getVar('field_options'));
						$form->addElement($select_multi_field, $required);
						break;
					case 'radio_yn':
						$form->addElement(new XoopsFormRadioYN($caption, $name, $value), $required);
						break;
					case 'radio':
						$radio_field = new XoopsFormRadio($caption, $name, $value);
						$radio_field ->addOptionArray($field_arr[$i]->getVar('field_options'));
						$form->addElement($radio_field, $required);
						break;
					case 'checkbox':
						$checkbox_field = new XoopsFormCheckBox($caption, $name, explode(',', $value));
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
		if (!$this->isNew() || $clone == true) {
			// douser
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DOUSER, 'article_douser', $this->getVar('article_douser')));
			// dodate
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DODATE, 'article_dodate', $this->getVar('article_dodate')));
			// domdate
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DOMDATE, 'article_domdate', $this->getVar('article_domdate')));
			// dohits
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DOHITS, 'article_dohits', $this->getVar('article_dohits')));
			// dorating
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DORATING, 'article_dorating', $this->getVar('article_dorating')));
			// docomment
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DOCOMMENT, 'article_docomment', $this->getVar('article_docomment')));
		} else {
			// douser
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DOUSER, 'article_douser', $category->getVar('category_douser')));
			// dodate
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DODATE, 'article_dodate', $category->getVar('category_dodate')));
			// domdate
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DOMDATE, 'article_domdate', $category->getVar('category_domdate')));
			// dohits
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DOHITS, 'article_dohits', $category->getVar('category_dohits')));
			// dorating
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DORATING, 'article_dorating', $category->getVar('category_dorating')));
			// docomment
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_CATEGORY_DOCOMMENT, 'article_docomment', $category->getVar('category_docomment')));
		}
		if ($helper->isUserAdmin() == true){
			if ($this->isNew()) {
				$userid = !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
			} else {
				$userid = $this->getVar('article_userid');
			}
			// userid
			$form->addElement(new XoopsFormSelectUser(_MA_XMARTICLE_USERID, 'article_userid', true, $userid, 1, false), true);

			// date and mdate
			if (!$this->isNew()) {
				$selection_date = new XoopsFormElementTray(_MA_XMARTICLE_DATEUPDATE);
				$date = new XoopsFormRadio('', 'date_update', 'N');
                $options        = ['N' => _NO . ' (' . formatTimestamp($this->getVar('article_date'), 's') . ')', 'Y' => _YES];
				$date->addOptionArray($options);
				$selection_date->addElement($date);
				$selection_date->addElement(new XoopsFormTextDateSelect('', 'article_date', '', time()));
				$form->addElement($selection_date);
				if ($this->getVar('article_mdate') != 0){
					$selection_mdate = new XoopsFormElementTray(_MA_XMARTICLE_MDATEUPDATE);
					$mdate = new XoopsFormRadio('', 'mdate_update', 'N');
                    $options         = ['N' => _NO . ' (' . formatTimestamp($this->getVar('article_mdate'), 's') . ')', 'R' => _MA_XMARTICLE_RESETMDATE, 'Y' => _YES];
					$mdate->addOptionArray($options);
					$selection_mdate->addElement($mdate);
					$selection_mdate->addElement(new XoopsFormTextDateSelect('', 'article_mdate', '', time()));
					$form->addElement($selection_mdate);
				}
			}
		}
        // permission Auto approve submitted article
        $permHelper = new \Xmf\Module\Helper\Permission();
        $permission = $permHelper->checkPermission('xmarticle_editapprove', $article_cid);
        if ($permission == true || $helper->isUserAdmin() == true){
            // status
            $form_status = new XoopsFormRadio(_MA_XMARTICLE_STATUS, 'article_status', $this->getVar('article_status'));
            $options     = [1 => _MA_XMARTICLE_STATUS_A, 0 => _MA_XMARTICLE_STATUS_NA, 2 => _MA_XMARTICLE_WFV];
            $form_status->addOptionArray($options);
            $form->addElement($form_status);
        } else {
			// Notification article:approve_article
			$form->addElement(new XoopsFormRadioYN(_MA_XMARTICLE_NOTIFY, 'article_notify', true));
		}
		//captcha
		if ($helper->getConfig('general_captcha', 0) == 1) {
			$form->addElement(new XoopsFormCaptcha(), true);
		}

        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }

    /**
     * @return mixed
     */
    public function saveArticle($articleHandler, $action = false)
    {
        global $xoopsUser;
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include __DIR__ . '/../include/common.php';
        $helper = Helper::getHelper('xmarticle');
        $error_message = '';

		$article_cid = Request::getInt('article_cid', 0);
        //logo
        if ($_FILES['article_logo']['error'] != UPLOAD_ERR_NO_FILE) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploader_article_img = new XoopsMediaUploader($path_logo_article . $article_cid . '/', ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'], $upload_size, null, null, false);
            if ($uploader_article_img->fetchMedia('article_logo')) {
                if (!$uploader_article_img->upload()) {
                    $error_message .= $uploader_article_img->getErrors() . '<br>';
                } else {
                    $this->setVar('article_logo', $uploader_article_img->getSavedFileName());
                }
            } else {
                $error_message .= $uploader_article_img->getErrors();
            }
        } else {
			$article_logo = Request::getString('article_logo', '');
			if ($article_logo == 'no-image.png'){
				$article_logo = '';
			}
            $this->setVar('article_logo', $article_logo);
        }
        $this->setVar('article_name', Request::getString('article_name', ''));
        $this->setVar('article_description',  Request::getText('article_description', ''));
		$this->setVar('article_douser', Request::getInt('article_douser', 1));
        $this->setVar('article_dodate', Request::getInt('article_dodate', 1));
        $this->setVar('article_domdate', Request::getInt('article_domdate', 1));
        $this->setVar('article_dohits', Request::getInt('article_dohits', 1));
        $this->setVar('article_dorating', Request::getInt('article_dorating', 1));
        $this->setVar('article_docomment', Request::getInt('article_docomment', 1));
        $this->setVar('article_cid', $article_cid);
		if (isset($_POST['article_userid'])) {
            $this->setVar('article_userid', Request::getInt('article_userid', 0));
        } else {
            $this->setVar('article_userid', !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0);
        }
		if (isset($_POST['article_date'])) {
			if ($_POST['date_update'] == 'Y'){
				$this->setVar('article_date', strtotime(Request::getString('article_date', '')));
			}
			$this->setVar('article_mdate', time());
        } else {
			$this->setVar('article_date', time());
        }
		if (isset($_POST['article_mdate'])) {
			if ($_POST['mdate_update'] == 'Y'){
				$this->setVar('article_mdate', strtotime(Request::getString('article_mdate', '')));
			}
			if ($_POST['mdate_update'] == 'R'){
				$this->setVar('article_mdate', 0);
			}
        }
        // permission Auto approve submitted article
        $permHelper = new \Xmf\Module\Helper\Permission();
        $permission = $permHelper->checkPermission('xmarticle_editapprove', $article_cid);
        if ($permission == false){
            $this->setVar('article_status', 2);
        } else {
            $this->setVar('article_status', Request::getInt('article_status', 1));
        }
		// Captcha
        if ($helper->getConfig('general_captcha', 0) == 1) {
            xoops_load('xoopscaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (! $xoopsCaptcha->verify() ) {
                $error_message .= $xoopsCaptcha->getMessage();
            }
        }
        if ($error_message == '') {
			$category = $categoryHandler->get($article_cid);
			//reference edit article
			if (!empty($this->getVar('article_id'))){
				$this->setVar('article_reference',  $category->getVar('category_reference') . '-' . $this->getVar('article_id'));
			}
            if ($articleHandler->insert($this)) {
				if ($this->get_new_enreg() == 0){
					$fielddata_aid = $this->getVar('article_id');
				} else {
					$fielddata_aid = $this->get_new_enreg();
					//reference new article
					$obj = $articleHandler->get($fielddata_aid);
					$obj->setVar('article_reference',  $category->getVar('category_reference') . '-' . $obj->getVar('article_id'));
					if (!$articleHandler->insert($obj)) {
						$error_message .=  $this->getHtmlErrors();
					}
				}

				// fields and fielddata
				if (!empty($category->getVar('category_fields'))) {
					$criteria = new CriteriaCompo();
					$criteria->setSort('field_weight ASC, field_name');
					$criteria->setOrder('ASC');
					$criteria->add(new Criteria('field_id', '(' . implode(',', $category->getVar('category_fields')) . ')', 'IN'));
					$criteria->add(new Criteria('field_status', 0, '!='));
					$field_arr = $fieldHandler->getall($criteria);
					foreach (array_keys($field_arr) as $i) {
						if ($field_arr[$i]->getVar('field_type') != 'label'){
							$error_message .= XmarticleUtility::saveFielddata($field_arr[$i]->getVar('field_type'), $field_arr[$i]->getVar('field_id'), $fielddata_aid, $_POST['field_' . $i]);
						}
					}
				}
                //xmdoc
                if (xoops_isActiveModule('xmdoc') && $helper->getConfig('general_xmdoc', 0) == 1) {
                    xoops_load('utility', 'xmdoc');
                    $error_message .= XmdocUtility::saveDocuments('xmarticle', $fielddata_aid);
                }
				//Notification global: new_article, category: new_article, article: approve_article
				$tags = [];
				$tags['ARTICLE_NAME'] = Request::getString('article_name', '');
				$tags['ARTICLE_URL'] = XOOPS_URL . '/modules/xmarticle/viewarticle.php?article_id=' . $fielddata_aid;
				$tags['CATEGORY_NAME'] = $category->getVar('category_name');
				$tags['CATEGORY_URL'] =  XOOPS_URL . '/modules/xmarticle/viewcat.php?category_id=' . $article_cid;
				$notificationHandler = xoops_getHandler('notification');
				$notificationHandler->triggerEvent('global', 0, 'new_article', $tags);
				$notificationHandler->triggerEvent('category', $article_cid, 'new_article', $tags);
				$notificationHandler->triggerEvent('article', $fielddata_aid, 'approve_article', $tags);
				//Notification global: submit_article
				if ($this->getVar('article_status') == 2){
					$tags['WAITINGARTICLE_URL'] = XOOPS_URL . '/modules/xmarticle/admin/article.php?article_status=2';
					$notificationHandler->triggerEvent('global', 0, 'submit_article', $tags);
				}
				//Notification article: modified_article
				if ($this->get_new_enreg() == 0){
					$notificationHandler->triggerEvent('article', $fielddata_aid, 'modified_article', $tags);
				}
				// Notification article: approve_article
				if (Request::getInt('article_notify', 0) == 1){
					$notificationHandler->subscribe('article', $fielddata_aid, 'approve_article', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
				}

				if ($error_message == ''){
					if ($this->getVar('article_status') == 2 && $action != 'article.php'){
						redirect_header('index.php', 2, _MA_XMARTICLE_REDIRECT_SAVE);
					}
                    if ($action == 'viewarticle.php'){
                        redirect_header('viewarticle.php?article_id=' . $fielddata_aid, 2, _MA_XMARTICLE_REDIRECT_SAVE);
                    } else {
                        redirect_header($action, 2, _MA_XMARTICLE_REDIRECT_SAVE);
                    }
				}
            } else {
                $error_message .=  $this->getHtmlErrors();
            }
        }

        return $error_message;
    }
    /**
    * @param bool $action
    * @return XoopsThemeForm
    */
    public function getFormSearch($action = false, $values = array())
    {
		global $xoopsTpl;
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        include __DIR__ . '/../include/common.php';
		// Get Permission to view cat
		$viewPermissionCat = XmarticleUtility::getPermissionCat('xmarticle_view');
		$criteria          = new CriteriaCompo();
		$criteria->setSort('category_weight ASC, category_name');
		$criteria->setOrder('ASC');
		$criteria->add(new Criteria('category_status', 1));
		if (!empty($viewPermissionCat)) {
			$criteria->add(new Criteria('category_id', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
		} else {
			redirect_header('index.php', 3, _MA_XMARTICLE_ERROR_NOACESSCATEGORY);
		}
		$category_arr = $categoryHandler->getall($criteria);

		$form = new XoopsThemeForm(_MA_XMARTICLE_SEARCHFORM, 'form', $action, 'post', true);
		// title
		$form->addElement(new XoopsFormText(_MA_XMARTICLE_ARTICLE_NAME, 'name', 50, 255, $this->getVar('article_name')));
		//reference
		$form->addElement(new XoopsFormText(_MA_XMARTICLE_ARTICLE_REFERENCE, 'ref', 50, 255, $this->getVar('article_reference')));
		//description
		$form->addElement(new XoopsFormText(_MA_XMARTICLE_ARTICLE_DESC, 'desc', 50, 255, $this->getVar('article_description')));
		//cat
		$field_cat = new XoopsFormSelect(_MA_XMARTICLE_ARTICLE_CATEGORY, 'cid', $this->getVar('article_cid'));
		$field_cat->addOption(0, _ALL);
		foreach (array_keys($category_arr) as $i) {
			$field_cat->addOption($category_arr[$i]->getVar('category_id'), $category_arr[$i]->getVar('category_name'));
		}
		$field_cat->setExtra("onchange=\"var formulaire = document.getElementById('form');formulaire.submit()\"");
		$form->addElement($field_cat);
		$cpt = 0;
		if ($this->getVar('article_cid')) {
			$category = $categoryHandler->get($this->getVar('article_cid'));
			if (!empty($category->getVar('category_fields'))) {
				// liste des articles concernés par la catégorie
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('article_cid', $this->getVar('article_cid')));
				$criteria->add(new Criteria('article_status', 1));
				$article_arr = $articleHandler->getall($criteria);
				$article_ids = array();
				foreach (array_keys($article_arr) as $i) {
					$article_ids[] = $i;
				}

				$criteria = new CriteriaCompo();
				$criteria->setSort('field_weight ASC, field_name');
				$criteria->setOrder('ASC');
				$criteria->add(new Criteria('field_id', '(' . implode(',', $category->getVar('category_fields')) . ')', 'IN'));
				$criteria->add(new Criteria('field_status', 0, '!='));
				$criteria->add(new Criteria('field_search', 0, '!='));
				$field_arr = $fieldHandler->getall($criteria);
				$cpt = 0;
				foreach (array_keys($field_arr) as $i) {
					$value = '';
					$value_fnex = '';
					$value_fnma = '';
					$value_fnmi = '';
					if(isset($values[$i])) {
						if(isset($values[$i]['value'])) {
							$value = $values[$i]['value'];
						}
						if(isset($values[$i]['fnex'])) {
							$value_fnex = $values[$i]['fnex'];
						}
						if(isset($values[$i]['fnmi'])) {
							$value_fnmi = $values[$i]['fnmi'];
						}
						if(isset($values[$i]['fnma'])) {
							$value_fnma = $values[$i]['fnma'];
						}
					}
					$cpt++;
					$caption = $field_arr[$i]->getVar('field_name') . '<br><span style="font-weight:normal;">' . $field_arr[$i]->getVar('field_description', 'show') . '</span>';
					$name = 'f_' . $cpt;
					$form->addElement(new XoopsFormHidden('t_' . $cpt, $field_arr[$i]->getVar('field_type')));
					$form->addElement(new XoopsFormHidden('fid_' . $cpt, $i));
					$form->addElement(new XoopsFormHidden('sels_' . $cpt, $field_arr[$i]->getVar('field_selsearch')));
					switch ($field_arr[$i]->getVar('field_type')) {
						case 'vs_text':
							if ($field_arr[$i]->getVar('field_selsearch') == 1){
								$criteria_field = new CriteriaCompo();
								$criteria_field->add(new Criteria('fielddata_fid', $i));
								if (!empty($article_ids)){
									$criteria_field->add(new Criteria('fielddata_aid', '(' . implode(',', $article_ids) . ')', 'IN'));
								}
								$criteria_field->setSort('fielddata_value1');
								$criteria_field->setOrder('ASC');
								$fielddata_arr = $fielddataHandler->getall($criteria_field);
								if (count($fielddata_arr) > 0) {
									$select_field = new XoopsFormSelect($caption, $name, $value, 4, true);
									$select_field->addOptionArray($field_arr[$i]->getVar('field_options'));
									foreach (array_keys($fielddata_arr) as $j) {
										if ($fielddata_arr[$j]->getVar('fielddata_value1') != ''){
											$select_field->addOption($fielddata_arr[$j]->getVar('fielddata_value1'), $fielddata_arr[$j]->getVar('fielddata_value1'));
										}
									}
									$select_field->addOption('[empty]', _MA_XMARTICLE_FIELD_EMPTY);
									$form->addElement($select_field);
								}
							} else {
								$form->addElement(new XoopsFormText($caption, $name, 50, 25, $value));
							}
							break;
						case 's_text':
							if ($field_arr[$i]->getVar('field_selsearch') == 1){
								$criteria_field = new CriteriaCompo();
								$criteria_field->add(new Criteria('fielddata_fid', $i));
								if (!empty($article_ids)){
									$criteria_field->add(new Criteria('fielddata_aid', '(' . implode(',', $article_ids) . ')', 'IN'));
								}
								$criteria_field->setSort('fielddata_value1');
								$criteria_field->setOrder('ASC');
								$fielddata_arr = $fielddataHandler->getall($criteria_field);
								if (count($fielddata_arr) > 0) {
									$select_field = new XoopsFormSelect($caption, $name, $value, 4, true);
									$select_field->addOptionArray($field_arr[$i]->getVar('field_options'));
									foreach (array_keys($fielddata_arr) as $j) {
										if ($fielddata_arr[$j]->getVar('fielddata_value1') != ''){
											$select_field->addOption($fielddata_arr[$j]->getVar('fielddata_value1'), $fielddata_arr[$j]->getVar('fielddata_value1'));
										}
									}
									$select_field->addOption('[empty]', _MA_XMARTICLE_FIELD_EMPTY);
									$form->addElement($select_field);
								}
							} else {
								$form->addElement(new XoopsFormText($caption, $name, 50, 50, $value));
							}
							break;
						case 'm_text':
							if ($field_arr[$i]->getVar('field_selsearch') == 1){
								$criteria_field = new CriteriaCompo();
								$criteria_field->add(new Criteria('fielddata_fid', $i));
								if (!empty($article_ids)){
									$criteria_field->add(new Criteria('fielddata_aid', '(' . implode(',', $article_ids) . ')', 'IN'));
								}
								$criteria_field->setSort('fielddata_value1');
								$criteria_field->setOrder('ASC');
								$fielddata_arr = $fielddataHandler->getall($criteria_field);
								if (count($fielddata_arr) > 0) {
									$select_field = new XoopsFormSelect($caption, $name, $value, 4, true);
									$select_field->addOptionArray($field_arr[$i]->getVar('field_options'));
									foreach (array_keys($fielddata_arr) as $j) {
										if ($fielddata_arr[$j]->getVar('fielddata_value1') != ''){
											$select_field->addOption($fielddata_arr[$j]->getVar('fielddata_value1'), $fielddata_arr[$j]->getVar('fielddata_value1'));
										}
									}
									$select_field->addOption('[empty]', _MA_XMARTICLE_FIELD_EMPTY);
									$form->addElement($select_field);
								}
							} else {
								$form->addElement(new XoopsFormText($caption, $name, 50, 100, $value));
							}
							break;
						case 'l_text':
							if ($field_arr[$i]->getVar('field_selsearch') == 1){
								$criteria_field = new CriteriaCompo();
								$criteria_field->add(new Criteria('fielddata_fid', $i));
								if (!empty($article_ids)){
									$criteria_field->add(new Criteria('fielddata_aid', '(' . implode(',', $article_ids) . ')', 'IN'));
								}
								$criteria_field->setSort('fielddata_value1');
								$criteria_field->setOrder('ASC');
								$fielddata_arr = $fielddataHandler->getall($criteria_field);
								if (count($fielddata_arr) > 0) {
									$select_field = new XoopsFormSelect($caption, $name, $value, 4, true);
									$select_field->addOptionArray($field_arr[$i]->getVar('field_options'));
									foreach (array_keys($fielddata_arr) as $j) {
										if ($fielddata_arr[$j]->getVar('fielddata_value1') != ''){
											$select_field->addOption($fielddata_arr[$j]->getVar('fielddata_value1'), $fielddata_arr[$j]->getVar('fielddata_value1'));
										}
									}
									$select_field->addOption('[empty]', _MA_XMARTICLE_FIELD_EMPTY);
									$form->addElement($select_field);
								}
							} else {
								$form->addElement(new XoopsFormText($caption, $name, 50, 255, $value));
							}
							break;
						case 'text':
							$editor_configs           = [];
							$editor_configs['name']   = $name;
							$editor_configs['value']  = $value;
							$editor_configs['rows']   = 2;
							$editor_configs['editor'] = 'Plain Text';
							$form->addElement(new XoopsFormEditor($caption, $name, $editor_configs));
							break;
						case 'select':
						case 'select_multi':
							$select_multi_field = new XoopsFormSelect($caption, $name, $value, 4, true);
							$select_multi_field->addOptionArray($field_arr[$i]->getVar('field_options'));
							$form->addElement($select_multi_field);
							break;
						case 'radio_yn':
							if ($value == '') {
								$value = 999;
							}
							$radio_yn_field = new XoopsFormSelect($caption, $name, $value);
							$radio_yn_field->addOption(999, '&nbsp;');
							$radio_yn_field->addOption(1, _YES);
							$radio_yn_field->addOption(0, _NO);
							$form->addElement($radio_yn_field);
							break;
						case 'radio':
							if ($value == '') {
								$value = 999;
							}
							$radio_field = new XoopsFormSelect($caption, $name, $value);
							$radio_field->addOption(999, '&nbsp;');
							$radio_field->addOptionArray($field_arr[$i]->getVar('field_options'));
							$form->addElement($radio_field);
							break;
						case 'checkbox':
							$checkbox_field = new XoopsFormCheckBox($caption, $name, $value);
							$checkbox_field->addOptionArray($field_arr[$i]->getVar('field_options'));
							$form->addElement($checkbox_field);
							break;
						case 'number':
							$number  = new XoopsFormElementTray($caption);
							$exactly = new XoopsFormText("<div class='row'><div class='col'><p class='text-left'>" . _MA_XMARTICLE_SEARCH_EXACTLY, 'fnex_' . $cpt, 10, 255, $value_fnex);
							$number->addElement($exactly);
							$max = new XoopsFormText("</p></div><div class='col'><p class='text-left'>" . _MA_XMARTICLE_SEARCH_MAX, 'fnma_' . $cpt, 10, 255, $value_fnma);
							$number->addElement($max);
							$min = new XoopsFormText("</p></div><div class='col'><p class='text-left'>" . _MA_XMARTICLE_SEARCH_MIN, 'fnmi_' . $cpt, 10, 255, $value_fnmi);
							$number->addElement($min);
							$number->addElement(new XoopsFormLabel("</p></div></div>"));
							$form->addElement($number);
							break;
					}
				}
			}
			$form->addElement(new XoopsFormHidden('n_field', $cpt));
		}
		$form->addElement(new XoopsFormHidden('order', $this->getVar('order')));
		$form->addElement(new XoopsFormHidden('sort', $this->getVar('sort')));
		$form->addElement(new XoopsFormHidden('filter', $this->getVar('filter')));
		$form->addElement(new XoopsFormHidden('display', $this->getVar('display')));
		$form->addElement(new XoopsFormHidden('op', 'search'));
		// search
		$button = new XoopsFormElementTray('');
		$button->addElement(new XoopsFormButton('', 'search', _SEARCH, 'submit'));
		$button_reset = new XoopsFormButton('', 'reset', _RESET, 'button');
		$button_reset->setExtra("onclick='window.location.href = \"" . $action . "\";'");
		$button->addElement($button_reset);
		$form->addElement($button);
		return $form;
	}

		/**
     * @return mixed
     */
    public function delArticle($articleHandler, $article_id, $action = false)
    {
		if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
		$error_message = '';
		include __DIR__ . '/../include/common.php';
		if ($articleHandler->delete($this)) {
			//Del logo
			if ($this->getVar('article_logo') != 'no-image.png') {
				// Test if the image is used
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('article_logo', $this->getVar('article_logo')));
				$article_count = $articleHandler->getCount($criteria);
				if ($article_count == 0){
					$urlfile = $path_logo_article . $this->getVar('article_cid') . '/' . $this->getVar('article_logo');
					if (is_file($urlfile)) {
						chmod($urlfile, 0777);
						unlink($urlfile);
					}
				}
			}
			//Del fielddata
			XmarticleUtility::delFilddataArticle($article_id);
			//xmdoc
			if (xoops_isActiveModule('xmdoc') && $helper->getConfig('general_xmdoc', 0) == 1) {
				xoops_load('utility', 'xmdoc');
				XmdocUtility::delDocdata('xmarticle', $article_id);
			}
			//xmsocial
			if (xoops_isActiveModule('xmsocial')) {
				xoops_load('utility', 'xmsocial');
				echo XmsocialUtility::delRatingdata('xmarticle', $article_id);
			}
			//Del Notification and comment
			$helper = \Xmf\Module\Helper::getHelper('xmarticle');
			$moduleid = $helper->getModule()->getVar('mid');
			xoops_notification_deletebyitem($moduleid, 'article', $article_id);
			xoops_comment_delete($moduleid, $article_id);

			redirect_header($action, 2, _MA_XMARTICLE_REDIRECT_SAVE);
		} else {
			$error_message .= $obj->getHtmlErrors();
		}
		return $error_message;
	}

    /**
     * @return mixed
     */
    public function get_new_enreg()
    {
        global $xoopsDB;
        $new_enreg = $xoopsDB->getInsertId();

        return $new_enreg;
    }
}

/**
 * Class xmarticlexmarticle_articleHandler
 */
class xmarticlexmarticle_articleHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmarticlexmarticle_articleHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'xmarticle_article', 'xmarticle_article', 'article_id', 'article_name');
    }
}
