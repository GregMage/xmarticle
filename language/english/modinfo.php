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
// The name of this module
define('_MI_XMARTICLE_NAME', 'Article');
define('_MI_XMARTICLE_DESC', 'Management articles');

// Menu
define('_MI_XMARTICLE_MENU_HOME', 'Index');
define('_MI_XMARTICLE_MENU_CATEGORY', 'Category');
define('_MI_XMARTICLE_MENU_FIELD', 'Field');
define('_MI_XMARTICLE_MENU_ARTICLE', 'Article');
define('_MI_XMARTICLE_MENU_PERMISSION', 'Permission');
define('_MI_XMARTICLE_MENU_ABOUT', 'About');

// Sub menu
define('_MI_XMARTICLE_SUB_ADD', 'Submit an article');
define('_MI_XMARTICLE_SUB_SEARCH', 'Search');

// Block
define('_MI_XMARTICLE_BLOCK_DATE', 'Recent Articles');
define('_MI_XMARTICLE_BLOCK_DATE_DESC', 'Display Recent Articles');
define('_MI_XMARTICLE_BLOCK_HITS', 'Top Articles (hits)');
define('_MI_XMARTICLE_BLOCK_HITS_DESC', 'Display Top Articles (hits)');
define('_MI_XMARTICLE_BLOCK_RATING', 'Top Rated Articles');
define('_MI_XMARTICLE_BLOCK_RATING_DESC', 'Display Top Rated Articles');
define('_MI_XMARTICLE_BLOCK_RANDOM', 'Random Articles');
define('_MI_XMARTICLE_BLOCK_RANDOM_DESC', 'Display articles randomly');
define('_MI_XMARTICLE_BLOCK_WAITING', 'Waitting Articles');
define('_MI_XMARTICLE_BLOCK_WAITING_DESC', 'Display waitting articles');


// Pref
define('_MI_XMARTICLE_PREF_HEAD_GENERAL', '<span style="font-size: large;  font-weight: bold;">--- General ---</span>');
define('_MI_XMARTICLE_PREF_GENERALITEMPERPAGE', 'Number of items per page in the general view');
define('_MI_XMARTICLE_PREF_GENERALSEPARATOR', 'Separation characters for multiple data display');
define('_MI_XMARTICLE_PREF_GENERALXMSTOCK', 'Use xmstock module to view stock');
define('_MI_XMARTICLE_PREF_GENERALXMDOC', 'Use xmdoc module to add document');
define('_MI_XMARTICLE_PREF_CAPTCHA', 'Use Captcha?');
define('_MI_XMARTICLE_PREF_CAPTCHA_DESC', 'Select Yes to use Captcha in the submit form');
define('_MI_XMARTICLE_PREF_COUNTERTIME', 'Select the time before the article reading counter can be incremented by the same person. [min]');
define('_MI_XMARTICLE_PREF_COUNTERTIME_DESC', 'Put "0" if you do not want to put any limitation');
define('_MI_XMARTICLE_PREF_HEAD_ADMIN', '<span style="font-size: large;  font-weight: bold;">--- Administration ---</span>');
define('_MI_XMARTICLE_PREF_EDITOR', 'Text Editor');
define('_MI_XMARTICLE_PREF_ITEMPERPAGE', 'Number of items per page in the administration view');
define('_MI_XMARTICLE_PREF_HEAD_COMNOTI', '<span style="font-size: large;  font-weight: bold;">--- Comments and notifications ---</span>');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL', 'Global');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_DESC', 'Global notification options for articles.');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_NEWARTICLE', 'New article');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_NEWARTICLE_CAP', 'Notify me when a new article is posted.');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_NEWARTICLE_DESC', 'Receive notification when a new article is posted.');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_NEWARTICLE_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify: New article');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_SUBMITARTICLE', 'Article submitted');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_SUBMITARTICLE_CAP', 'Notify me when a new article is submitted (awaiting approval).');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_SUBMITARTICLE_DESC', 'Receive notification when a new article is submitted (awaiting approval).');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_SUBMITARTICLE_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify: New articleis submitted (awaiting approval)');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY', 'Category');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_DESC', 'Notification options that apply to the current article category.');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_NEWARTICLE', 'New article');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_NEWARTICLE_CAP', 'Notify me when a new article is posted to the current category.');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_NEWARTICLE_DESC', 'Receive notification when a new article is posted to the current category.');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_NEWARTICLE_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify: New article in category');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE', 'Article');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_DESC', 'Notification options that apply to the current article.');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_MODIFIEDARTICLE', 'Modified article');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_MODIFIEDARTICLE_CAP', 'Notify me when this article is modified');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_MODIFIEDARTICLE_DESC', 'Receive notification when this article is modified.');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_MODIFIEDARTICLE_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify: Modified article');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_APPROVE', 'Article approved');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_APPROVE_CAP', 'Notify me when this article is approved');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_APPROVE_DESC', 'Receive notification when this article is approved.');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_APPROVE_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify: Article approved');
