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
  `field_sort`        varchar(3)              NOT NULL default '',
  `field_options`       text,
  
  PRIMARY KEY  (`field_id`),
  KEY `field_type` (`field_type`)
) ENGINE=MyISAM;

CREATE TABLE `xmarticle_fielddata` (
  `fielddata_id`            int(12) unsigned        NOT NULL auto_increment,
  `fielddata_fid`           int(12) unsigned        NOT NULL default '0',
  `fielddata_aid`           int(12) unsigned        NOT NULL default '0',
  `fielddata_value1`        varchar(255)            NOT NULL default '',
  `fielddata_value2`        text,
  `fielddata_value3`        text,
  `fielddata_value4`        double(9,3)            NOT NULL default '0.000',
  
  PRIMARY KEY  (`fielddata_id`)
) ENGINE=MyISAM;

CREATE TABLE `xmarticle_article` (
  `article_id`          int(12) unsigned        NOT NULL auto_increment,
  `article_cid`         int(11)                 NOT NULL DEFAULT '0',
  `article_reference`   varchar(50)             NOT NULL default '',
  `article_name`        varchar(255)            NOT NULL default '',
  `article_description` text,
  `article_logo`        varchar(50)             NOT NULL DEFAULT '',
  `article_status`      tinyint(1) unsigned     NOT NULL default '0',
  
  PRIMARY KEY  (`article_id`),
  KEY `article_name` (`article_name`),
  KEY `article_reference` (`article_reference`)
) ENGINE=MyISAM;