SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+00:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ResetTickets`;
CREATE TABLE `ResetTickets` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `userid` int(255) NOT NULL,
  `expires` int(255) NOT NULL,
  `code` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Sessions`;
CREATE TABLE `Sessions` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(255) NOT NULL,
  `code1` text NOT NULL,
  `code2` text NOT NULL,
  `expires` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `lower` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` text NOT NULL,
  `joinDate` text NOT NULL,
  `legacypassword` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `lower` (`lower`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
