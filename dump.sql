SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` mediumtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `done` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tasks` (`id`, `username`, `email`, `text`, `image`, `done`, `created_at`, `updated_at`) VALUES
(1,	'Denver',	'denver@mail.com',	'Hello world! :)',	NULL,	1,	'2012-01-01 00:00:00',	'2012-01-01 00:00:00'),
(2,	'Pioner',	'pioner@mail.com',	'Ho-ho!',	'/assets/images/image_1542995114.jpg',	1,	'2012-01-01 00:00:00',	'2012-01-01 00:00:00'),
(3,	'Salut',	'salut@mail.com',	'',	NULL,	0,	'2012-01-01 00:00:00',	'2012-01-01 00:00:00'),
(4,	'Monica',	'monica@mail.com',	'All Set!',	NULL,	0,	'2012-01-01 00:00:00',	'2012-01-01 00:00:00');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `login`, `password`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'miTF5KM/1uCw2',	NULL,	NULL);
