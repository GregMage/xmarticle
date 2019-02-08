CREATE TABLE `xmarticle_category` (
  `category_id`             smallint(5) unsigned    NOT NULL AUTO_INCREMENT,
  `category_name`           varchar(255)            NOT NULL DEFAULT '',
  `category_description`    text,
  `category_logo`           varchar(50)             NOT NULL DEFAULT '',
  `category_weight`         smallint(5) unsigned    NOT NULL DEFAULT '0',
  `category_status`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_fields`    		text,
  
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `xmarticle_field` (
  `field_id`            smallint(5) unsigned    NOT NULL auto_increment,
  `field_type`          varchar(20)             NOT NULL default '',
  `field_name`          varchar(255)            NOT NULL default '',
  `field_description`   text,
  `field_required`      tinyint(1)  unsigned    NOT NULL default '0',
  `field_weight`        smallint(5) unsigned    NOT NULL default '0',
  `field_default`       text,
  `field_search`        tinyint(1)  unsigned    NOT NULL default '0',
  `field_status`        tinyint(1)  unsigned    NOT NULL default '0',
  `field_sort`      	varchar(3)              NOT NULL default '',
  `field_options`       text,
  
  PRIMARY KEY  (`field_id`)
) ENGINE=MyISAM;

CREATE TABLE `xmarticle_fielddata` (
  `fielddata_id`            mediumint(8) unsigned    NOT NULL auto_increment,
  `fielddata_fid`           smallint(5)  unsigned    NOT NULL default '0',
  `fielddata_aid`           mediumint(8) unsigned    NOT NULL default '0',
  `fielddata_value1`        varchar(255)             NOT NULL default '',
  `fielddata_value2`        text,
  `fielddata_value3`        varchar(255)             NOT NULL default '',
  `fielddata_value4`        double(9,3)              NOT NULL default '0.000',
  
  PRIMARY KEY  (`fielddata_id`),
  KEY `fielddata_fid` (`fielddata_fid`),
  KEY `fielddata_aid` (`fielddata_aid`)
) ENGINE=MyISAM;

CREATE TABLE `xmarticle_article` (
  `article_id`             mediumint(8) unsigned   NOT NULL auto_increment,
  `article_cid`            smallint(5)  unsigned   NOT NULL DEFAULT '0',
  `article_reference`      varchar(50)             NOT NULL default '',
  `article_name`           varchar(255)            NOT NULL default '',
  `article_description`    text,
  `article_logo`           varchar(50)             NOT NULL DEFAULT '',
  `article_userid`         smallint(5)  unsigned   NOT NULL default '0',
  `article_date`           int(10)      unsigned   NOT NULL DEFAULT '0',
  `article_mdate`          int(10)      unsigned   NOT NULL DEFAULT '0',
  `article_rating`         double(6,4)             NOT NULL default '0.0000',
  `article_votes`          smallint(5)  unsigned   NOT NULL default '0',
  `article_counter`        smallint(5)  unsigned   NOT NULL DEFAULT '0',
  `article_status`         tinyint(1)   unsigned   NOT NULL default '0',
  
  PRIMARY KEY  (`article_id`),
  KEY `article_cid` (`article_cid`)
) ENGINE=MyISAM;