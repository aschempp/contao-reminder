-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_reminder`
-- 

CREATE TABLE `tl_reminder` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `recipients` varchar(255) NOT NULL default '',
  `data` blob NULL,
  `start` int(10) unsigned NOT NULL default '0',
  `stop` int(10) unsigned NOT NULL default '0',
  `language` varchar(2) NOT NULL default '',
  `mail_template` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table `tl_form`
-- 

CREATE TABLE `tl_form` (
  `reminder` char(1) NOT NULL default '',
  `reminderDelay` varchar(255) NOT NULL default '',
  `reminderTemplate` int(10) unsigned NOT NULL default '0',
  `reminderRecipient` varchar(255) NOT NULL default '',
  `reminderCheck` int(10) unsigned NOT NULL default '0',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

