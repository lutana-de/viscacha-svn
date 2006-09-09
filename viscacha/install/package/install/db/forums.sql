CREATE TABLE `{:=DBPREFIX=:}forums` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(200) NOT NULL default '',
  `description` text NOT NULL,
  `topics` int(10) unsigned NOT NULL default '0',
  `replies` int(10) unsigned NOT NULL default '0',
  `parent` smallint(5) unsigned NOT NULL default '0',
  `position` smallint(4) NOT NULL default '0',
  `last_topic` int(10) unsigned NOT NULL default '0',
  `opt` enum('','re','pw') NOT NULL default '',
  `optvalue` varchar(255) NOT NULL default '',
  `forumzahl` tinyint(3) unsigned NOT NULL default '0',
  `topiczahl` tinyint(3) unsigned NOT NULL default '0',
  `prefix` enum('0','1') NOT NULL default '0',
  `invisible` enum('0','1','2') NOT NULL default '0',
  `readonly` enum('0','1') NOT NULL default '0',
  `auto_status` enum('','a','n') NOT NULL,
  `reply_notification` text NOT NULL,
  `topic_notification` text NOT NULL,
  `active_topic` enum('0','1') NOT NULL default '1',
  `message_active` enum('0','1','2') NOT NULL default '0',
  `message_title` varchar(255) NOT NULL,
  `message_text` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;