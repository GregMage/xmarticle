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
define('_MI_XMARTICLE_DESC', 'Gestionnaire d\'articles');

// Menu
define('_MI_XMARTICLE_MENU_HOME', 'Index');
define('_MI_XMARTICLE_MENU_CATEGORY', 'Categories');
define('_MI_XMARTICLE_MENU_FIELD', 'Champs');
define('_MI_XMARTICLE_MENU_ARTICLE', 'Articles');
define('_MI_XMARTICLE_MENU_PERMISSION', 'Autorisations');
define('_MI_XMARTICLE_MENU_ABOUT', 'À propos de');

// Sub menu
define('_MI_XMARTICLE_SUB_ADD', 'Soumettre un article');
define('_MI_XMARTICLE_SUB_SEARCH', 'Recherche');

// Block
define('_MI_XMARTICLE_BLOCK_DATE', 'Articles récents');
define('_MI_XMARTICLE_BLOCK_DATE_DESC', 'Afficher les articles récents');
define('_MI_XMARTICLE_BLOCK_HITS', 'Articles les plus lus');
define('_MI_XMARTICLE_BLOCK_HITS_DESC', 'Afficher les articles les plus lus');
define('_MI_XMARTICLE_BLOCK_RATING', 'Articles les mieux notés');
define('_MI_XMARTICLE_BLOCK_RATING_DESC', 'Afficher les articles les mieux notés');
define('_MI_XMARTICLE_BLOCK_RANDOM', 'Articles aléatoires');
define('_MI_XMARTICLE_BLOCK_RANDOM_DESC', 'Afficher les articles aléatoirement');
define('_MI_XMARTICLE_BLOCK_WAITING', 'Articles en attente de validation');
define('_MI_XMARTICLE_BLOCK_WAITING_DESC', 'Afficher les articles en attente de validation');

// Pref
define('_MI_XMARTICLE_PREF_HEAD_GENERAL', '<span style="font-size: large;  font-weight: bold;">Général</span>');
define('_MI_XMARTICLE_PREF_GENERALITEMPERPAGE', 'Nombre d\'éléments par page dans la vue générale');
define('_MI_XMARTICLE_PREF_GENERALSEPARATOR', 'Caractères de séparation pour l\'affichage de plusieurs données');
define('_MI_XMARTICLE_PREF_GENERALXMSTOCK', 'Utiliser le module xmstock pour ajouter une gestion de stock');
define('_MI_XMARTICLE_PREF_GENERALXMDOC', 'Utiliser le module xmdoc pour ajouter une gestion documentaire');
define('_MI_XMARTICLE_PREF_GENERALXMSOCIAL', 'Utiliser le module xmsocial pour noter un article');
define('_MI_XMARTICLE_PREF_CAPTCHA', 'Utiliser Captcha?');
define('_MI_XMARTICLE_PREF_CAPTCHA_DESC', 'Sélectionnez Oui pour utiliser Captcha dans le formulaire de soumission.');
define('_MI_XMARTICLE_PREF_COUNTERTIME', 'Sélectionnez le temps avant que le compteur de lecture d\'articles puisse être incrémenté par la même personne. [min]');
define('_MI_XMARTICLE_PREF_COUNTERTIME_DESC', 'Mettez "0" si vous ne voulez pas mettre de limitation');
define('_MI_XMARTICLE_PREF_MAXUPLOADSIZE', 'Taille maximale des fichiers uploadés');
define('_MI_XMARTICLE_PREF_MAXUPLOADSIZE_DESC', 'Cela concerne les logos uploadés pour les catégories et les actualités');
define('_MI_XMARTICLE_PREF_MAXUPLOADSIZE_MBYTES', 'Mb');
define('_MI_XMARTICLE_PREF_GENERALCLONE', 'Ajout d\'un préfixe');
define('_MI_XMARTICLE_PREF_GENERALCLONE_DESC', 'Lors du clone d\'un article, ajouter un préfixe');
define('_MI_XMARTICLE_PREF_GENERALDISPLAYEMPTYFIELD', 'Afficher les champs vides?');
define('_MI_XMARTICLE_PREF_GENERALDISPLAYEMPTYFIELD_DESC', 'Les champs vident peuvent être cachées dans la vue article');
define('_MI_XMARTICLE_PREF_HEAD_ADMIN', '<span style="font-size: large;  font-weight: bold;">Administration</span>');
define('_MI_XMARTICLE_PREF_EDITOR', 'Éditeur de texte');
define('_MI_XMARTICLE_PREF_ITEMPERPAGE', 'Nombre d\'éléments par page dans la vue d\'administration');
define('_MI_XMARTICLE_PREF_HEAD_COMNOTI', '<span style="font-size: large;  font-weight: bold;">Commentaires et notifications</span>');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL', 'Globale');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_DESC', 'Options de notification globales pour les articles.');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_NEWARTICLE', 'Nouvel article');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_NEWARTICLE_CAP', 'Prévenez-moi quand un nouvel article est publié.');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_NEWARTICLE_DESC', 'Recevoir une notification lorsqu\'un nouvel article est publié.');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_NEWARTICLE_SBJ', '[{X_SITENAME}] {X_MODULE} notification automatique: Nouveaux articles');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_SUBMITARTICLE', 'Article soumis');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_SUBMITARTICLE_CAP', 'Prévenez-moi quand un nouvel article est soumis (en attente d\'approbation).');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_SUBMITARTICLE_DESC', 'Recevoir une notification lorsqu\'un nouvel article est soumis (en attente d\'approbation).');
define('_MI_XMARTICLE_NOTIFICATION_GLOBAL_SUBMITARTICLE_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notifier: nouvel article soumis (en attente d\'approbation');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY', 'Categorie');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_DESC', 'Options de notification qui s\'appliquent à la catégorie d\'article actuel.');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_NEWARTICLE', 'Nouvel article');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_NEWARTICLE_CAP', 'Prévenez-moi quand un nouvel article est publié dans la catégorie actuelle.');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_NEWARTICLE_DESC', 'Recevoir une notification lorsqu\'un nouvel article est publié dans la catégorie actuelle.');
define('_MI_XMARTICLE_NOTIFICATION_CATEGORY_NEWARTICLE_SBJ', '[{X_SITENAME}] {X_MODULE} notification automatique: nouvel article dans la catégorie');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE', 'Articles');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_DESC', 'Options de notification qui s\'appliquent aux nouveaux articles.');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_MODIFIEDARTICLE', 'Article modifié');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_MODIFIEDARTICLE_CAP', 'M\'avertir lorsque cet article est modifié');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_MODIFIEDARTICLE_DESC', 'Recevoir une notification lorsque cet article est modifié.');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_MODIFIEDARTICLE_SBJ', '[{X_SITENAME}] {X_MODULE} notification automatique: article modifié');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_APPROVE', 'Article approuvé');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_APPROVE_CAP', 'Me prévenir lorsque cet article est approuvé');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_APPROVE_DESC', 'Recevoir une notification lorsque cet article est approuvé.');
define('_MI_XMARTICLE_NOTIFICATION_ARTICLE_APPROVE_SBJ', '[{X_SITENAME}] {X_MODULE} notification automatique: Article approuvé');
