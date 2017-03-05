CREATE TABLE `xmarticle_category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL DEFAULT '',
  `category_reference` varchar(255) NOT NULL DEFAULT '',
  `category_description` text NOT NULL,
  `category_logo` varchar(255) NOT NULL DEFAULT '',
  `category_weight` int(11) NOT NULL DEFAULT '0',
  `category_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`),
  KEY `category_name` (`category_name`),
  KEY `category_reference` (`category_reference`)
) ENGINE=MyISAM;