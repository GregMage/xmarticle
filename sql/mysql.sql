CREATE TABLE `xmarticle_category` (
  `category_id`             int(11) unsigned    NOT NULL AUTO_INCREMENT,
  `category_name`           varchar(255)        NOT NULL DEFAULT '',
  `category_reference`      varchar(50)         NOT NULL DEFAULT '',
  `category_description`    text,
  `category_logo`           varchar(50)         NOT NULL DEFAULT '',
  `category_weight`         int(11)             NOT NULL DEFAULT '0',
  `category_status`         tinyint(1)          NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`category_id`),
  KEY `category_name` (`category_name`),
  KEY `category_reference` (`category_reference`)
) ENGINE=MyISAM;

CREATE TABLE `xmarticle_field` (
  `field_id`            int(12) unsigned        NOT NULL auto_increment,
  `field_type`          varchar(20)             NOT NULL default '',
  `field_name`          varchar(255)            NOT NULL default '',
  `field_description`   text,
  `field_required`      tinyint(1) unsigned     NOT NULL default '0',
  `field_weight`        smallint(6) unsigned    NOT NULL default '0',
  `field_default`       text,
  `field_search`        tinyint(1) unsigned     NOT NULL default '0',
  `field_status`        tinyint(1) unsigned     NOT NULL default '0',
  `field_options`       text,
  
  PRIMARY KEY  (`field_id`),
  KEY `field_type` (`field_type`)
) ENGINE=MyISAM;