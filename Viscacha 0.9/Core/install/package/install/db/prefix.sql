CREATE TABLE `{:=DBPREFIX=:}prefix` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `bid` smallint(5) unsigned NOT NULL default '0',
  `value` varchar(128) NOT NULL default '',
  `standard` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
