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
define('_MA_XMARTICLE_ARTICLE_ADD', 'Ajout d\'un article');
define('_MA_XMARTICLE_ARTICLE_LIST', 'Liste des articles');
define('_MA_XMARTICLE_CATEGORY_ADD', 'Ajout d\'une catégorie');
define('_MA_XMARTICLE_CATEGORY_LIST', 'Liste des catégories');
define('_MA_XMARTICLE_FIELD_ADD', 'Ajout d\'un champ');
define('_MA_XMARTICLE_FIELD_LIST', 'Liste des champs');
define('_MA_XMARTICLE_REDIRECT_SAVE', 'Enregistré avec succès');

// Admin
define('_MA_XMARTICLE_INDEXCONFIG_XMDOC_WARNINGNOTINSTALLED', 'Vous n\'avez pas installé le module xmdoc, ce module est requis si vous souhaitez ajouter des documents aux articles');
define('_MA_XMARTICLE_INDEXCONFIG_XMDOC_WARNINGNOTACTIVATE', 'Vous devez activer dans les préférences du module xmarticle l\'utilisation de xmdoc (si vous souhaitez ajouter des documents)');
define('_MA_XMARTICLE_INDEXCONFIG_XMSTOCK_WARNINGNOTINSTALLED', 'Vous n\'avez pas installé le module xmstock, ce module est nécessaire si vous souhaitez visualiser les stocks aux articles');
define('_MA_XMARTICLE_INDEXCONFIG_XMSTOCK_WARNINGNOTACTIVATE', 'Vous devez activer dans les préférences du module xmarticle l\'utilisation de xmstock (si vous voulez voir les stocks)');
define('_MA_XMARTICLE_INDEXCONFIG_XMSOCIAL_WARNINGNOTINSTALLED', 'Vous n\'avez pas installé le module xmsocial, ce module est nécessaire si vous souhaitez noter l\'article');
define('_MA_XMARTICLE_INDEXCONFIG_XMSOCIAL_WARNINGNOTACTIVATE', 'Vous devez activer dans les préférences du module xmarticle l\'utilisation de xmsocial (si vous souhaitez noter l\'article)');
define('_MA_XMARTICLE_INDEX_IMAGEINFO', 'Statut du serveur');
define('_MA_XMARTICLE_INDEX_SPHPINI', "<span style='font-weight: bold;'>Informations extraites du fichier php.ini :</span>");
define('_MA_XMARTICLE_INDEX_ON', "<span style='font-weight: bold;'>ON</span>");
define('_MA_XMARTICLE_INDEX_OFF', "<span style='font-weight: bold;'>OFF</span>");
define('_MA_XMARTICLE_INDEX_SERVERUPLOADSTATUS', 'Statut d\'envoi du serveur : ');
define('_MA_XMARTICLE_INDEX_MAXPOSTSIZE', 'Taille d\'envoi maximal autorisé (directive post_max_size dans php.ini) : ');
define('_MA_XMARTICLE_INDEX_MAXUPLOADSIZE', 'Taille d\'envoi maximal autorisé (directive upload_max_filesize dans le fichier php.ini) : ');
define('_MA_XMARTICLE_INDEX_MEMORYLIMIT', 'Limite de mémoire (directive memory_limit dans php.ini) : ');

// Error message
define('_MA_XMARTICLE_ERROR', 'Erreur');
define('_MA_XMARTICLE_ERROR_FIELDNOTCONFIGURABLE', 'Erreur : champ non configurable (pas de type de champ)');
define('_MA_XMARTICLE_ERROR_NACTIVE', 'Erreur : Contenu désactivé!');
define('_MA_XMARTICLE_ERROR_NOACESSCATEGORY', 'Vous n\'avez accès à aucune catégorie');
define('_MA_XMARTICLE_ERROR_NOARTICLE', 'Il n\'y a pas d\'articles dans la base de données');
define('_MA_XMARTICLE_ERROR_NOCATEGORY', 'Il n\'y a pas de catégories dans la base de données');
define('_MA_XMARTICLE_ERROR_NOFIELD', 'Il n\'y a pas de champs dans la base de données');
define('_MA_XMARTICLE_ERROR_NOFIELDTYPE', 'Il n\'y a pas de type de champ');
define('_MA_XMARTICLE_ERROR_REFERENCE', 'La référence existe déjà ! La référence doit être unique.');
define('_MA_XMARTICLE_ERROR_SIZE', "La taille dans les préférences du module (taille maximale des fichiers téléchargés) dépasse les valeurs maximales définies dans 'post_max_size' ou 'upload_max_filesize' dans la configuration du fichier php.ini.");
define('_MA_XMARTICLE_ERROR_WEIGHT', 'Le poids doit être un nombre');

// Info message
define('_MA_XMARTICLE_INFO_ARTICLEDISABLE', 'L\'article est désactivé, vous le voyez car vous êtes autorisé à modifier son statut');
define('_MA_XMARTICLE_INFO_ARTICLEWAITING', 'L\'article est en attente de validation, vous le voyez car vous êtes autorisé à modifier son statut');

// Shared
define('_MA_XMARTICLE_ACTION', 'Action');
define('_MA_XMARTICLE_ADD', 'Ajouter');
define('_MA_XMARTICLE_CLONE', 'Cloner');
define('_MA_XMARTICLE_DEL', 'Effacer');
define('_MA_XMARTICLE_EDIT', 'Modifier');
define('_MA_XMARTICLE_STATUS', 'Statut');
define('_MA_XMARTICLE_STATUS_A', 'Activé');
define('_MA_XMARTICLE_STATUS_NA', 'Désactivé');
define('_MA_XMARTICLE_VIEW', 'Voir');

// Field type
define('_MA_XMARTICLE_FIELDTYPE_CHECKBOX', 'Case à cocher');
define('_MA_XMARTICLE_FIELDTYPE_LABEL', 'Étiquette');
define('_MA_XMARTICLE_FIELDTYPE_LTEXT', 'Texte de 255 caractères');
define('_MA_XMARTICLE_FIELDTYPE_MTEXT', 'Texte de 100 caractères');
define('_MA_XMARTICLE_FIELDTYPE_NUMBER', 'Nombre');
define('_MA_XMARTICLE_FIELDTYPE_RADIO', 'Boutons radio');
define('_MA_XMARTICLE_FIELDTYPE_RADIOYN', 'Bouton radio Oui/Non');
define('_MA_XMARTICLE_FIELDTYPE_SELECT', 'Sélection');
define('_MA_XMARTICLE_FIELDTYPE_SELECTMULTI', 'Sélection multiple');
define('_MA_XMARTICLE_FIELDTYPE_STEXT', 'Texte de 50 caractères');
define('_MA_XMARTICLE_FIELDTYPE_TEXT', 'Texte long');
define('_MA_XMARTICLE_FIELDTYPE_VSTEXT', 'Texte de 25 caractères');

// Category
define('_MA_XMARTICLE_CATEGORY_COLOR', 'Couleur');
define('_MA_XMARTICLE_CATEGORY_DESC', 'Description');
define('_MA_XMARTICLE_CATEGORY_DOCOMMENT', 'Voir les commentaires');
define('_MA_XMARTICLE_CATEGORY_DODSC', 'Valeur par défaut pour un nouvel article dans cette catégorie');
define('_MA_XMARTICLE_CATEGORY_DODATE', 'Afficher la date');
define('_MA_XMARTICLE_CATEGORY_DOHITS', 'Afficher les lectures');
define('_MA_XMARTICLE_CATEGORY_DOMDATE', 'Afficher la date de modification');
define('_MA_XMARTICLE_CATEGORY_DORATING', 'Afficher la note');
define('_MA_XMARTICLE_CATEGORY_DOUSER', 'Afficher l\'auteur');
define('_MA_XMARTICLE_CATEGORY_FIELD', 'Champs');
define('_MA_XMARTICLE_CATEGORY_FORMPATH', 'Les fichiers sont dans : %s');
define('_MA_XMARTICLE_CATEGORY_LOGO', 'Logo de la catégorie');
define('_MA_XMARTICLE_CATEGORY_LOGOFILE', 'Fichier de logo');
define('_MA_XMARTICLE_CATEGORY_NAME', 'Nom');
define('_MA_XMARTICLE_CATEGORY_REFERENCE', 'Référence');
define('_MA_XMARTICLE_CATEGORY_REFERENCE_DSC', 'Cette référence permet de générer les références article');
define('_MA_XMARTICLE_CATEGORY_REMOVEFIELDS', 'Supprimer des champs');
define('_MA_XMARTICLE_CATEGORY_SUREDEL', 'Voulez-vous vraiment supprimer cette catégorie? %s');
define('_MA_XMARTICLE_CATEGORY_THEREAREARTICLE', 'Il y a <strong>%s</strong> articles dans cette catégorie!');
define('_MA_XMARTICLE_CATEGORY_UPLOAD', 'Upload');
define('_MA_XMARTICLE_CATEGORY_UPLOADSIZE', 'Taille maximum : %s Ko');
define('_MA_XMARTICLE_CATEGORY_WARNINGDELARTICLE', '<strong>Attention, les éléments suivants seront également supprimés!</strong>');
define('_MA_XMARTICLE_CATEGORY_WEIGHT', 'Poids');

// Article
define('_MA_XMARTICLE_ARTICLE_CATEGORY', 'Catégorie');
define('_MA_XMARTICLE_ARTICLE_DESC', 'Description');
define('_MA_XMARTICLE_ARTICLE_FORMPATH', 'Les fichiers sont dans : %s');
define('_MA_XMARTICLE_ARTICLE_LOGO', 'Logo de l\'article');
define('_MA_XMARTICLE_ARTICLE_LOGOFILE', 'Fichier de logo');
define('_MA_XMARTICLE_ARTICLE_MDATE_BT', 'Modification');
define('_MA_XMARTICLE_ARTICLE_NAME', 'Nom');
define('_MA_XMARTICLE_ARTICLE_PUBLISHED_BT', 'Publication');
define('_MA_XMARTICLE_ARTICLE_UPLOAD', 'Upload');
define('_MA_XMARTICLE_ARTICLE_UPLOADSIZE', 'Taille maximum : %s Ko');
define('_MA_XMARTICLE_ARTICLE_REFERENCE', 'Référence');
define('_MA_XMARTICLE_ARTICLE_SUREDEL', 'Voulez-vous vraiment supprimer cet article? %s');
define('_MA_XMARTICLE_AUTHOR', 'Auteur');
define('_MA_XMARTICLE_BLOCKS_NOWAITING', 'Il n\'y a pas d\'articles en attente de validation');
define('_MA_XMARTICLE_CLONE_NAME', 'CLONER');
define('_MA_XMARTICLE_COMPINFORMATION', 'Informations complémentaires');
define('_MA_XMARTICLE_DATE', 'Date de création');
define('_MA_XMARTICLE_DATEUPDATE', 'Mettre à jour la date de création');
define('_MA_XMARTICLE_GENINFORMATION', 'Informations générales');
define('_MA_XMARTICLE_MDATE', 'Date de modification');
define('_MA_XMARTICLE_MDATEUPDATE', 'Mettre à jour la date de modification');
define('_MA_XMARTICLE_NOTIFY', 'M\'avertir de la publication ?');
define('_MA_XMARTICLE_RATING', 'Note');
define('_MA_XMARTICLE_READING', 'Lecture');
define('_MA_XMARTICLE_RESETMDATE', 'Réinitialiser (date vide)');
define('_MA_XMARTICLE_USERID', 'Author');
define('_MA_XMARTICLE_VOTES', '(%s Votes)');
define('_MA_XMARTICLE_WFV', 'En attente de validation');
define('_MA_XMARTICLE_WAITING', 'Il y a <strong>%s</strong> articles en attente de validation!');
define('_MA_XMARTICLE_XMDOC', 'Documents');
define('_MA_XMARTICLE_XMSTOCK', 'Stocks');

// permission
define('_MA_XMARTICLE_PERMISSION_VIEW', 'Autorisation de voir un article');
define('_MA_XMARTICLE_PERMISSION_VIEW_DSC', 'Choisissez les groupes qui peuvent voir un article dans ces catégories');
define('_MA_XMARTICLE_PERMISSION_VIEW_THIS', 'Sélectionnez les groupes pouvant voir un article dans ces catégories');
define('_MA_XMARTICLE_PERMISSION_SUBMIT', 'Autorisation de soumettre');
define('_MA_XMARTICLE_PERMISSION_SUBMIT_DSC', 'Sélectionnez les groupes pouvant soumettre des articles dans ces catégories');
define('_MA_XMARTICLE_PERMISSION_SUBMIT_THIS', 'Sélectionnez les groupes pouvant soumettre dans ces catégories');
define('_MA_XMARTICLE_PERMISSION_EDITAPPROVE', 'Autorisation de modifier et d\'approuver');
define('_MA_XMARTICLE_PERMISSION_EDITAPPROVE_DSC', 'Sélectionnez les groupes pouvant éditer et approuver des articles dans ces catégories');
define('_MA_XMARTICLE_PERMISSION_EDITAPPROVE_THIS', 'Sélectionnez les groupes pouvant éditer et approuver dans ces catégories');
define('_MA_XMARTICLE_PERMISSION_DELETE', 'Autorisation de supprimer');
define('_MA_XMARTICLE_PERMISSION_DELETE_DSC', 'Sélectionnez les groupes pouvant supprimer des articles dans ces catégories');
define('_MA_XMARTICLE_PERMISSION_DELETE_THIS', 'Sélectionner les groupes pouvant supprimer dans ces catégories');

// Field
define('_MA_XMARTICLE_FIELD_ADDFIELD', 'Ajouter des champs');
define('_MA_XMARTICLE_FIELD_ADDMOREFIELDS', 'Ajouter plus de champs');
define('_MA_XMARTICLE_FIELD_ADDMOREOPTIONS', 'Ajouter plus d\'options');
define('_MA_XMARTICLE_FIELD_ADDOPTION', 'Ajouter des options');
define('_MA_XMARTICLE_FIELD_DEFAULT', 'Défaut');
define('_MA_XMARTICLE_FIELD_DESC', 'Description du champ');
define('_MA_XMARTICLE_FIELD_KEY', 'Valeur à stocker');
define('_MA_XMARTICLE_FIELD_NAME', 'Nom du champ');
define('_MA_XMARTICLE_FIELD_REMOVE', 'Supprimer');
define('_MA_XMARTICLE_FIELD_REQUIRED', 'Champ obligatoire');
define('_MA_XMARTICLE_FIELD_SEARCH', 'Affichage du champ dans la page de recherche');
define('_MA_XMARTICLE_FIELD_SORT', 'Trier');
define('_MA_XMARTICLE_FIELD_SORTDEF', 'Trier selon l\'enregistrement');
define('_MA_XMARTICLE_FIELD_SORTVLH', 'Trier la valeur de bas en haut');
define('_MA_XMARTICLE_FIELD_SORTVHL', 'Trier la valeur de haut en bas');
define('_MA_XMARTICLE_FIELD_SORTKLH', 'Trier la clé de bas en haut');
define('_MA_XMARTICLE_FIELD_SORTKHL', 'Trier la clé de haut en bas');
define('_MA_XMARTICLE_FIELD_SUREDEL', 'Voulez-vous vraiment supprimer ce champ ? %s<br><span style="font-size: large;  font-weight: bold;">Warning</span> en supprimant ce champ, vous supprimerez les données de ce champ pour tous les articles qui l\'utilisent. ');
define('_MA_XMARTICLE_FIELD_TITLEREQUIRED', 'Obligatoire?');
define('_MA_XMARTICLE_FIELD_TITLESEARCH', 'Recherche?');
define('_MA_XMARTICLE_FIELD_TITLEWEIGHT', 'Poids');
define('_MA_XMARTICLE_FIELD_TYPE', 'Type de champ');
define('_MA_XMARTICLE_FIELD_VALUE', 'Texte à afficher');
define('_MA_XMARTICLE_FIELD_WEIGHT', 'Poids du champ');

// user
define('_MA_XMARTICLE_HOME', 'Page d\'accueil');
define('_MA_XMARTICLE_LISTARTICLE', 'Liste des articles');
define('_MA_XMARTICLE_MOREDETAILS', 'Plus de détails');
define('_MA_XMARTICLE_SEARCH', 'Recherche');
define('_MA_XMARTICLE_SEARCHFORM', 'Formulaire de recherche');
define('_MA_XMARTICLE_SELECTCATEGORY', 'Sélectionnez une catégorie à laquelle ajouter un élément');

// formArticle
define('_MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD', 'Ajouter un article');
define('_MA_XMARTICLE_FORMARTICLE_LISTARTICLE', 'Liste des articles');
define('_MA_XMARTICLE_FORMARTICLE_NOARTICLESELECTED', 'Aucun article sélectionné...');
define('_MA_XMARTICLE_FORMARTICLE_SELECT', 'Sélectionner');
define('_MA_XMARTICLE_FORMARTICLE_RESETSELECTED', 'Réinitialiser l\'article sélectionné');;
define('_MA_XMARTICLE_FORMARTICLE_SELECTED', 'Article sélectionné');
define('_MA_XMARTICLE_FORMARTICLE_VALIDATE', 'valider');
