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

// Button
define('_MA_XMARTICLE_ARTICLE_ADD', 'Add article');
define('_MA_XMARTICLE_ARTICLE_LIST', 'Article list');
define('_MA_XMARTICLE_CATEGORY_ADD', 'Add category');
define('_MA_XMARTICLE_CATEGORY_LIST', 'Category list');
define('_MA_XMARTICLE_FIELD_ADD', 'Add field');
define('_MA_XMARTICLE_FIELD_LIST', 'Field list');
define('_MA_XMARTICLE_REDIRECT_SAVE', 'Successfully saved');
 
// Admin
define('_MA_XMARTICLE_INDEXCONFIG_XMDOC_WARNINGNOTINSTALLED', 'You have not installed the xmdoc module, this module is required if you want to add documents to the articles');
define('_MA_XMARTICLE_INDEXCONFIG_XMDOC_WARNINGNOTACTIVATE', 'You must enable in xmarticle preferences the use of xmdoc (if you want to add documents)');
define('_MA_XMARTICLE_INDEXCONFIG_XMSTOCK_WARNINGNOTINSTALLED', 'You have not installed the xmstock module, this module is required if you want to view stocks to the articles');
define('_MA_XMARTICLE_INDEXCONFIG_XMSTOCK_WARNINGNOTACTIVATE', 'You must enable in xmarticle preferences the use of xmstock (if you want to view stocks)');
 
// Error message
define('_MA_XMARTICLE_ERROR', 'Error');
define('_MA_XMARTICLE_ERROR_NACTIVE', 'Error: Disable content!');
define('_MA_XMARTICLE_ERROR_NOACESSCATEGORY', 'You don\'t have access to any categories');
define('_MA_XMARTICLE_ERROR_NOARTICLE', 'There are no articles in the database');
define('_MA_XMARTICLE_ERROR_NOCATEGORY', 'There are no categories in the database');
define('_MA_XMARTICLE_ERROR_NOFIELD', 'There are no fields in the database');
define('_MA_XMARTICLE_ERROR_FIELDNOTCONFIGURABLE', 'Error: field not configurable (no field type)');
define('_MA_XMARTICLE_ERROR_NOFIELDTYPE', 'There are no field type');
define('_MA_XMARTICLE_ERROR_REFERENCE', 'The reference already exists! The reference must be unique.');
define('_MA_XMARTICLE_ERROR_WEIGHT', 'Weight must be a number');

// Info message
define('_MA_XMARTICLE_INFO_ARTICLEDISABLE', 'The article is disabled, you see it because you are allowed to change its status');
define('_MA_XMARTICLE_INFO_ARTICLEWAITING', 'The article is pending validation, you see it because you are allowed to change its status');

// Shared
define('_MA_XMARTICLE_ACTION', 'Action');
define('_MA_XMARTICLE_ADD', 'Add');
define('_MA_XMARTICLE_CLONE', 'Clone');
define('_MA_XMARTICLE_DEL', 'Delete');
define('_MA_XMARTICLE_EDIT', 'Edit');
define('_MA_XMARTICLE_STATUS', 'Status');
define('_MA_XMARTICLE_STATUS_A', 'Active');
define('_MA_XMARTICLE_STATUS_NA', 'Disabled');
define('_MA_XMARTICLE_VIEW', 'View');

// Field type
define('_MA_XMARTICLE_FIELDTYPE_LABEL', 'Label');
define('_MA_XMARTICLE_FIELDTYPE_VSTEXT', 'Text with 25 characters');
define('_MA_XMARTICLE_FIELDTYPE_STEXT', 'Text with 50 characters');
define('_MA_XMARTICLE_FIELDTYPE_MTEXT', 'Text with 100 characters');
define('_MA_XMARTICLE_FIELDTYPE_LTEXT', 'Text with 255 characters');
define('_MA_XMARTICLE_FIELDTYPE_TEXT', 'Long text');
define('_MA_XMARTICLE_FIELDTYPE_SELECT', 'Select');
define('_MA_XMARTICLE_FIELDTYPE_SELECTMULTI', 'Multi select');
define('_MA_XMARTICLE_FIELDTYPE_RADIOYN', 'Radio Yes/No');
define('_MA_XMARTICLE_FIELDTYPE_RADIO', 'Radio buttons');
define('_MA_XMARTICLE_FIELDTYPE_CHECKBOX', 'Checkbox');
define('_MA_XMARTICLE_FIELDTYPE_NUMBER', 'Number');

// Category
define('_MA_XMARTICLE_CATEGORY_DESC', 'Description');
define('_MA_XMARTICLE_CATEGORY_FIELD', 'Fields');
define('_MA_XMARTICLE_CATEGORY_FORMPATH', 'Files are in: %s');
define('_MA_XMARTICLE_CATEGORY_LOGO', 'Logo');
define('_MA_XMARTICLE_CATEGORY_LOGOFILE', 'Logo file');
define('_MA_XMARTICLE_CATEGORY_NAME', 'Name');
define('_MA_XMARTICLE_CATEGORY_REFERENCE', 'Reference');
define('_MA_XMARTICLE_CATEGORY_REMOVEFIELDS', 'Remove fields');
define('_MA_XMARTICLE_CATEGORY_SUREDEL', 'Sure to delete this category? %s');
define('_MA_XMARTICLE_CATEGORY_THEREAREARTICLE', 'There are <strong>%s</strong> articles in this category!');
define('_MA_XMARTICLE_CATEGORY_UPLOAD', 'Upload');
define('_MA_XMARTICLE_CATEGORY_UPLOADSIZE', 'Maximum size: %s kB');
define('_MA_XMARTICLE_CATEGORY_WARNINGDELARTICLE', '<strong>Warning, the following items will also be removed!</strong>');
define('_MA_XMARTICLE_CATEGORY_WEIGHT', 'Weight');

// Article
define('_MA_XMARTICLE_ARTICLE_CATEGORY', 'Category');
define('_MA_XMARTICLE_ARTICLE_DESC', 'Description');
define('_MA_XMARTICLE_ARTICLE_FORMPATH', 'Files are in: %s');
define('_MA_XMARTICLE_ARTICLE_LOGO', 'Logo');
define('_MA_XMARTICLE_ARTICLE_LOGOFILE', 'Logo file');
define('_MA_XMARTICLE_ARTICLE_NAME', 'Name');
define('_MA_XMARTICLE_ARTICLE_UPLOAD', 'Upload');
define('_MA_XMARTICLE_ARTICLE_UPLOADSIZE', 'Maximum size: %s kB');
define('_MA_XMARTICLE_ARTICLE_REFERENCE', 'Reference');
define('_MA_XMARTICLE_ARTICLE_SUREDEL', 'Sure to delete this article? %s');
define('_MA_XMARTICLE_AUTHOR', 'Author');
define('_MA_XMARTICLE_CLONE_NAME', 'CLONE');
define('_MA_XMARTICLE_COMPINFORMATION', 'Complementary informations');
define('_MA_XMARTICLE_DATE', 'Creation date');
define('_MA_XMARTICLE_DATEUPDATE', 'Update the creation date');
define('_MA_XMARTICLE_GENINFORMATION', 'General informations');
define('_MA_XMARTICLE_MDATE', 'Modification date');
define('_MA_XMARTICLE_MDATEUPDATE', 'Update the modification date');
define('_MA_XMARTICLE_NOTIFY', 'Notify me of the publication?');
define('_MA_XMARTICLE_RESETMDATE', 'Reset (empty date)');
define('_MA_XMARTICLE_USERID', 'Author');
define('_MA_XMARTICLE_WFV', 'Waiting for validation');
define('_MA_XMARTICLE_WAITING', 'There are <strong>%s</strong> articles waiting for validation!');
define('_MA_XMARTICLE_XMDOC', 'Documents');
define('_MA_XMARTICLE_XMSTOCK', 'Stocks');
define('_MA_XMARTICLE_READING', 'Reading');
define('_MA_XMARTICLE_RATING', 'Rating');
define('_MA_XMARTICLE_VOTES', '(%s Votes)');

// permission
define('_MA_XMARTICLE_PERMISSION_VIEW', 'View Permissions');
define('_MA_XMARTICLE_PERMISSION_VIEW_DSC', 'Select groups that can view an article in categories');
define('_MA_XMARTICLE_PERMISSION_VIEW_THIS', 'Select groups that can view in this category');
define('_MA_XMARTICLE_PERMISSION_SUBMIT', 'Submit permission');
define('_MA_XMARTICLE_PERMISSION_SUBMIT_DSC', 'Select groups that can submit an article in categories');
define('_MA_XMARTICLE_PERMISSION_SUBMIT_THIS', 'Select groups that can submit in this category');
define('_MA_XMARTICLE_PERMISSION_OTHER', 'Other permissions');
define('_MA_XMARTICLE_PERMISSION_OTHER_DSC', 'Select groups that can:');
define('_MA_XMARTICLE_PERMISSION_OTHER_4', 'Submit an article');
define('_MA_XMARTICLE_PERMISSION_OTHER_8', 'Auto approve submitted articles');
define('_MA_XMARTICLE_PERMISSION_OTHER_16', 'Delete an article');
define('_MA_XMARTICLE_PERMISSION_OTHER_32', 'To do a search');

// Field
define('_MA_XMARTICLE_FIELD_ADDFIELD', 'Add fields');
define('_MA_XMARTICLE_FIELD_ADDMOREFIELDS', 'Add more fields');
define('_MA_XMARTICLE_FIELD_ADDMOREOPTIONS', 'Add more options');
define('_MA_XMARTICLE_FIELD_ADDOPTION', 'Add options');
define('_MA_XMARTICLE_FIELD_DEFAULT', 'Default');
define('_MA_XMARTICLE_FIELD_DESC', 'Field description');
define('_MA_XMARTICLE_FIELD_KEY', 'Value to be stored');
define('_MA_XMARTICLE_FIELD_NAME', 'Field name');
define('_MA_XMARTICLE_FIELD_REMOVE', 'Remove');
define('_MA_XMARTICLE_FIELD_REQUIRED', 'Field required');
define('_MA_XMARTICLE_FIELD_SEARCH', 'Field display in search page');
define('_MA_XMARTICLE_FIELD_SORT', 'Sort');
define('_MA_XMARTICLE_FIELD_SORTDEF', 'Sort according to record');
define('_MA_XMARTICLE_FIELD_SORTVLH', 'Sort value low to high');
define('_MA_XMARTICLE_FIELD_SORTVHL', 'Sort value high to low');
define('_MA_XMARTICLE_FIELD_SORTKLH', 'Sort key low to high');
define('_MA_XMARTICLE_FIELD_SORTKHL', 'Sort key high to low');
define('_MA_XMARTICLE_FIELD_SUREDEL', 'Sure to delete this field? %s');
define('_MA_XMARTICLE_FIELD_TITLEREQUIRED', 'Required?');
define('_MA_XMARTICLE_FIELD_TITLESEARCH', 'Searchable?');
define('_MA_XMARTICLE_FIELD_TITLEWEIGHT', 'Weight');
define('_MA_XMARTICLE_FIELD_TYPE', 'Field type');
define('_MA_XMARTICLE_FIELD_VALUE', 'Text to be displayed');
define('_MA_XMARTICLE_FIELD_WEIGHT', 'Field weight');

// user
define('_MA_XMARTICLE_HOME', 'Home page');
define('_MA_XMARTICLE_LISTARTICLE', 'List of articles');
define('_MA_XMARTICLE_MOREDETAILS', 'More details');
define('_MA_XMARTICLE_SEARCH', 'Search');
define('_MA_XMARTICLE_SEARCHFORM', 'Search form');
define('_MA_XMARTICLE_SELECTCATEGORY', 'Select a category to add an item to');

// formArticle
define('_MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD', 'Add article');
define('_MA_XMARTICLE_FORMARTICLE_LISTARTICLE', 'List of articles');
define('_MA_XMARTICLE_FORMARTICLE_SELECT', 'Select');
define('_MA_XMARTICLE_FORMARTICLE_SELECTED', 'Article selected');
define('_MA_XMARTICLE_FORMARTICLE_RESETSELECTED', 'Reset article selected');

