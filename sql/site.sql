CREATE TABLE IF NOT EXISTS `itinerary` (
  `datetime` datetime NOT NULL,
  `city_id` smallint(5) unsigned NOT NULL,
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  KEY `datetime` (`datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `blog` (
  `entry_id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `entry` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `destination_id` int(10) NOT NULL,
  `review` text COLLATE utf8_unicode_ci NOT NULL,
  `score` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`review_id`),
  KEY `userid` (`userid`),
  KEY `destination_id` (`destination_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `config` (
  `param_crc` int(10) unsigned NOT NULL,
  `param` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `param_crc` (`param_crc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
