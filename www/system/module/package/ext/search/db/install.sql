 CREATE TABLE IF NOT EXISTS `eps_search_index` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `params` text NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `status` char(30) NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`),
  UNIQUE KEY `object` (`objectType`,`objectID`),
  KEY `addedDate` (`addedDate`),
  FULLTEXT KEY `content` (`title`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `eps_search_dict` (
  `key` smallint(5) unsigned NOT NULL,
  `value` char(3) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
