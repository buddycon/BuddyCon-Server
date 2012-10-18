-- Adminer 3.6.0 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `bot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `gold` int(11) DEFAULT NULL,
  `xp` int(11) DEFAULT NULL,
  `xp_needed` int(11) DEFAULT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `latestupdate` int(11) DEFAULT NULL,
  `wantscreen` tinyint(1) NOT NULL,
  `do` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nodes` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `running` varchar(60) DEFAULT NULL,
  `lastvisit` int(11) DEFAULT NULL,
  `filter` varchar(255) NOT NULL,
  `xph` int(11) NOT NULL,
  `timetolevel` int(11) NOT NULL,
  `kills` int(11) NOT NULL,
  `killsh` int(11) NOT NULL,
  `honor` int(11) NOT NULL,
  `honorh` int(11) NOT NULL,
  `death` int(11) NOT NULL,
  `deathh` int(11) NOT NULL,
  `bgwin` int(11) NOT NULL,
  `bglost` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bot_user_idx` (`user_id`),
  CONSTRAINT `bot_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bot_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `type` varchar(45) DEFAULT NULL,
  `from` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sended` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chat_bot1_idx` (`bot_id`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`bot_id`) REFERENCES `bot` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `to` varchar(45) DEFAULT NULL,
  `bot_id` int(11) NOT NULL,
  `sended` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reply_bot1_idx` (`bot_id`),
  CONSTRAINT `fk_reply_bot1` FOREIGN KEY (`bot_id`) REFERENCES `bot` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `screen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) DEFAULT NULL,
  `delete` varchar(255) DEFAULT NULL,
  `thumb` tinyint(1) DEFAULT '0',
  `bot_id` int(11) NOT NULL,
  `uploadedtime` int(11) DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_screen_bot1_idx` (`bot_id`),
  CONSTRAINT `fk_screen_bot1` FOREIGN KEY (`bot_id`) REFERENCES `bot` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `latestupdate` int(11) DEFAULT NULL,
  `bot_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_status_bot1_idx` (`bot_id`),
  CONSTRAINT `fk_status_bot1` FOREIGN KEY (`bot_id`) REFERENCES `bot` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `apikey` varchar(255) DEFAULT NULL,
  `lastcheck` int(11) NOT NULL,
  `lastvisit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apikey_UNIQUE` (`apikey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2012-10-18 22:17:39
