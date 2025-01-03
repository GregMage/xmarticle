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
define('_MA_XMARTICLE_INDEXCONFIG_XMSOCIAL_WARNINGNOTINSTALLED', 'You have not installed the xmsocial module, this module is required if you want to rate article');
define('_MA_XMARTICLE_INDEXCONFIG_XMSOCIAL_WARNINGNOTACTIVATE', 'You must enable in xmarticle preferences the use of xmsocial (if you want to rate article)');
define('_MA_XMARTICLE_INDEX_ARTICLE', 'Articles');
define('_MA_XMARTICLE_INDEX_ARTICLE_ACTIVE', 'Active articles');
define('_MA_XMARTICLE_INDEX_ARTICLE_NOTACTIVE', 'Disabled articles');
define('_MA_XMARTICLE_INDEX_EXPORT', 'Exporting articles');
define('_MA_XMARTICLE_INDEX_IMAGEINFO', 'Server status');
define('_MA_XMARTICLE_INDEX_SPHPINI', "<span style='font-weight: bold;'>Information taken from PHP ini file:</span>");
define('_MA_XMARTICLE_INDEX_ON', "<span style='font-weight: bold;'>ON</span>");
define('_MA_XMARTICLE_INDEX_OFF', "<span style='font-weight: bold;'>OFF</span>");
define('_MA_XMARTICLE_INDEX_SERVERUPLOADSTATUS', 'Server uploads status: ');
define('_MA_XMARTICLE_INDEX_MAXPOSTSIZE', 'Max post size permitted (post_max_size directive in php.ini): ');
define('_MA_XMARTICLE_INDEX_MAXUPLOADSIZE', 'Max upload size permitted (upload_max_filesize directive in php.ini): ');
define('_MA_XMARTICLE_INDEX_MEMORYLIMIT', 'Memory limit (memory_limit directive in php.ini): ');

// Error message
define('_MA_XMARTICLE_ERROR', 'Error');
define('_MA_XMARTICLE_ERROR_FIELDNOTCONFIGURABLE', 'Error: field not configurable (no field type)');
define('_MA_XMARTICLE_ERROR_NACTIVE', 'Error: Disable content!');
define('_MA_XMARTICLE_ERROR_NOACESSCATEGORY', 'You don\'t have access to any categories');
define('_MA_XMARTICLE_ERROR_NOARTICLE', 'There are no articles in the database');
define('_MA_XMARTICLE_ERROR_NOCATEGORY', 'There are no categories in the database');
define('_MA_XMARTICLE_ERROR_NOFIELD', 'There are no fields in the database');
define('_MA_XMARTICLE_ERROR_NOFIELDTYPE', 'There are no field type');
define('_MA_XMARTICLE_ERROR_SIZE', "The size in preference (Max uploaded files size) exceeds the maximum values defined in 'post_max_size' or 'upload_max_filesize' in your configuration in php.ini");
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
define('_MA_XMARTICLE_FILTER_PERPAGE', 'per page');
define('_MA_XMARTICLE_FILTER_TYPE', 'Order');
define('_MA_XMARTICLE_ORDER', 'Order');
define('_MA_XMARTICLE_ORDER_NAME', 'Name');
define('_MA_XMARTICLE_ORDER_DATE', 'Date');
define('_MA_XMARTICLE_ORDER_VIEW', 'Hits');
define('_MA_XMARTICLE_ORDER_REF', 'Reference');
define('_MA_XMARTICLE_STATUS', 'Status');
define('_MA_XMARTICLE_STATUS_A', 'Active');
define('_MA_XMARTICLE_STATUS_NA', 'Disabled');
define('_MA_XMARTICLE_VIEW', 'View');

// Field type
define('_MA_XMARTICLE_FIELDTYPE_CHECKBOX', 'Checkbox');
define('_MA_XMARTICLE_FIELDTYPE_LABEL', 'Label');
define('_MA_XMARTICLE_FIELDTYPE_LTEXT', 'Text with 255 characters');
define('_MA_XMARTICLE_FIELDTYPE_MTEXT', 'Text with 100 characters');
define('_MA_XMARTICLE_FIELDTYPE_NUMBER', 'Number');
define('_MA_XMARTICLE_FIELDTYPE_RADIO', 'Radio buttons');
define('_MA_XMARTICLE_FIELDTYPE_RADIOYN', 'Radio Yes/No');
define('_MA_XMARTICLE_FIELDTYPE_SELECT', 'Select');
define('_MA_XMARTICLE_FIELDTYPE_SELECTMULTI', 'Multi select');
define('_MA_XMARTICLE_FIELDTYPE_STEXT', 'Text with 50 characters');
define('_MA_XMARTICLE_FIELDTYPE_TEXT', 'Long text');
define('_MA_XMARTICLE_FIELDTYPE_VSTEXT', 'Text with 25 characters');

// Category
define('_MA_XMARTICLE_CATEGORY_COLOR', 'Color');
define('_MA_XMARTICLE_CATEGORY_DESC', 'Description');
define('_MA_XMARTICLE_CATEGORY_DOCOMMENT', 'View comments');
define('_MA_XMARTICLE_CATEGORY_DODSC', 'Default value for new article in this category');
define('_MA_XMARTICLE_CATEGORY_DODATE', 'View date');
define('_MA_XMARTICLE_CATEGORY_DOHITS', 'View hits');
define('_MA_XMARTICLE_CATEGORY_DOMDATE', 'View modified date');
define('_MA_XMARTICLE_CATEGORY_DORATING', 'View rating');
define('_MA_XMARTICLE_CATEGORY_DOUSER', 'View user');
define('_MA_XMARTICLE_CATEGORY_FIELD', 'Fields');
define('_MA_XMARTICLE_CATEGORY_FORMPATH', 'Files are in: %s');
define('_MA_XMARTICLE_CATEGORY_LOGO', 'Logo');
define('_MA_XMARTICLE_CATEGORY_LOGOFILE', 'Logo file');
define('_MA_XMARTICLE_CATEGORY_NAME', 'Name');
define('_MA_XMARTICLE_CATEGORY_REFERENCE', 'Reference');
define('_MA_XMARTICLE_CATEGORY_REFERENCE_DSC', 'This reference is used to generate the article references');
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
define('_MA_XMARTICLE_ARTICLE_MDATE_BT', 'Update');
define('_MA_XMARTICLE_ARTICLE_NAME', 'Name');
define('_MA_XMARTICLE_ARTICLE_PUBLISHED_BT', 'Publication');
define('_MA_XMARTICLE_ARTICLE_UPLOAD', 'Upload');
define('_MA_XMARTICLE_ARTICLE_UPLOADSIZE', 'Maximum size: %s kB');
define('_MA_XMARTICLE_ARTICLE_REFERENCE', 'Reference');
define('_MA_XMARTICLE_ARTICLE_SUREDEL', 'Sure to delete this article? %s');
define('_MA_XMARTICLE_AUTHOR', 'Author');
define('_MA_XMARTICLE_BLOCKS_NOWAITING', 'There are no articles awaiting validation');
define('_MA_XMARTICLE_CLONE_NAME', 'CLONE');
define('_MA_XMARTICLE_COMPINFORMATION', 'Complementary informations');
define('_MA_XMARTICLE_DATE', 'Creation date');
define('_MA_XMARTICLE_DATEUPDATE', 'Update the creation date');
define('_MA_XMARTICLE_GENINFORMATION', 'General informations');
define('_MA_XMARTICLE_MDATE', 'Modification date');
define('_MA_XMARTICLE_MDATEUPDATE', 'Update the modification date');
define('_MA_XMARTICLE_NOTIFY', 'Notify me of the publication?');
define('_MA_XMARTICLE_RATING', 'Rating');
define('_MA_XMARTICLE_READING', 'Reading');
define('_MA_XMARTICLE_RESETMDATE', 'Reset (empty date)');
define('_MA_XMARTICLE_USERID', 'Author');
define('_MA_XMARTICLE_VOTES', '(%s Votes)');
define('_MA_XMARTICLE_WFV', 'Waiting for validation');
define('_MA_XMARTICLE_WAITING', 'There are <strong>%s</strong> articles waiting for validation!');
define('_MA_XMARTICLE_XMDOC', 'Documents');
define('_MA_XMARTICLE_XMSTOCK', 'Stocks');

// permission
define('_MA_XMARTICLE_PERMISSION_VIEW', 'View Permissions');
define('_MA_XMARTICLE_PERMISSION_VIEW_DSC', 'Select groups that can view an article in categories');
define('_MA_XMARTICLE_PERMISSION_VIEW_THIS', 'Select groups that can view in this category');
define('_MA_XMARTICLE_PERMISSION_SUBMIT', 'Submit permission');
define('_MA_XMARTICLE_PERMISSION_SUBMIT_DSC', 'Select groups that can submit an article in categories');
define('_MA_XMARTICLE_PERMISSION_SUBMIT_THIS', 'Select groups that can submit in this category');
define('_MA_XMARTICLE_PERMISSION_EDITAPPROVE', 'Edit and approve permission');
define('_MA_XMARTICLE_PERMISSION_EDITAPPROVE_DSC', 'Select groups that can edit and approve a news in categories');
define('_MA_XMARTICLE_PERMISSION_EDITAPPROVE_THIS', 'Select groups that can edit and approve in this category');
define('_MA_XMARTICLE_PERMISSION_DELETE', 'Delete permission');
define('_MA_XMARTICLE_PERMISSION_DELETE_DSC', 'Select groups that can delete a news in categories');
define('_MA_XMARTICLE_PERMISSION_DELETE_THIS', 'Select groups that can delete in this category');

// Field
define('_MA_XMARTICLE_FIELD_ADDFIELD', 'Add fields');
define('_MA_XMARTICLE_FIELD_ADDMOREFIELDS', 'Add more fields');
define('_MA_XMARTICLE_FIELD_ADDMOREOPTIONS', 'Add more options');
define('_MA_XMARTICLE_FIELD_ADDOPTION', 'Add options');
define('_MA_XMARTICLE_FIELD_ADDOPTION_DESC', 'Add a field with the value "%s" in "Text to be displayed" for a value that should not be displayed.');
define('_MA_XMARTICLE_FIELD_DEFAULT', 'Default');
define('_MA_XMARTICLE_FIELD_DESC', 'Field description');
define('_MA_XMARTICLE_FIELD_EMPTY', '[Empty field]');
define('_MA_XMARTICLE_FIELD_NAME', 'Field name');
define('_MA_XMARTICLE_FIELD_REMOVE', 'Remove');
define('_MA_XMARTICLE_FIELD_REQUIRED', 'Field required');
define('_MA_XMARTICLE_FIELD_SEARCH', 'Field display in search page');
define('_MA_XMARTICLE_FIELD_SELSEARCH', 'Addition of a drop-down menu in the search with saved values');
define('_MA_XMARTICLE_FIELD_KEY', 'Value to be stored');
define('_MA_XMARTICLE_FIELD_SORT', 'Sort');
define('_MA_XMARTICLE_FIELD_VALUE', 'Text to be displayed');
define('_MA_XMARTICLE_FIELD_SORTDEF', 'Sort according to record');
define('_MA_XMARTICLE_FIELD_SORTVLH', 'Sort by "' . _MA_XMARTICLE_FIELD_VALUE . '" low to high');
define('_MA_XMARTICLE_FIELD_SORTVHL', 'Sort by "' . _MA_XMARTICLE_FIELD_VALUE . '" high to low');
define('_MA_XMARTICLE_FIELD_SORTKLH', 'Sort by "' . _MA_XMARTICLE_FIELD_KEY . '" low to high');
define('_MA_XMARTICLE_FIELD_SORTKHL', 'Sort by "' . _MA_XMARTICLE_FIELD_KEY . '" high to low');
define('_MA_XMARTICLE_FIELD_SUREDEL', 'Are you sure to delete this field? %s<br><span style="font-size: large; font-weight: bold;">Warning</span> by deleting this field, you will delete the data from this field for all the articles that use it ');
define('_MA_XMARTICLE_FIELD_TITLEREQUIRED', 'Required?');
define('_MA_XMARTICLE_FIELD_TITLESEARCH', 'Searchable?');
define('_MA_XMARTICLE_FIELD_TITLEWEIGHT', 'Weight');
define('_MA_XMARTICLE_FIELD_TYPE', 'Field type');
define('_MA_XMARTICLE_FIELD_WEIGHT', 'Field weight');

// user
define('_MA_XMARTICLE_HOME', 'Home page');
define('_MA_XMARTICLE_LISTARTICLE', 'List of articles');
define('_MA_XMARTICLE_MOREDETAILS', 'More details');
define('_MA_XMARTICLE_SEARCH', 'Search');
define('_MA_XMARTICLE_SEARCHFORM', 'Search form');
define('_MA_XMARTICLE_SEARCH_EXACTLY', 'Exactly value');
define('_MA_XMARTICLE_SEARCH_MIN', 'Lower as:');
define('_MA_XMARTICLE_SEARCH_MAX', 'Upper as:');
define('_MA_XMARTICLE_SELECTCATEGORY', 'Select a category to add an item to');

// formArticle
define('_MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD', 'Add article');
define('_MA_XMARTICLE_FORMARTICLE_LISTARTICLE', 'List of articles');
define('_MA_XMARTICLE_FORMARTICLE_NOARTICLESELECTED', 'No article selected ...');
define('_MA_XMARTICLE_FORMARTICLE_SELECT', 'Select');
define('_MA_XMARTICLE_FORMARTICLE_RESETSELECTED', 'Reset article selected');;
define('_MA_XMARTICLE_FORMARTICLE_SELECTED', 'Selected article');
define('_MA_XMARTICLE_FORMARTICLE_VALIDATE', 'validate');
