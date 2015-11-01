# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 10.1.8-MariaDB)
# Database: cabinlife
# Generation Time: 2015-11-01 21:39:01 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table feedsource
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feedsource`;

CREATE TABLE `feedsource` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `feedsource` WRITE;
/*!40000 ALTER TABLE `feedsource` DISABLE KEYS */;

INSERT INTO `feedsource` (`id`, `name`, `url`)
VALUES
	(1,'Tiny House Blog','http://tinyhouseblog.com/tag/log-cabin/feed/');

/*!40000 ALTER TABLE `feedsource` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `feedsource_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `publishedAt` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `totalViews` int(11) DEFAULT NULL,
  `favorites` int(11) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `summary` text,
  `body` longtext,
  PRIMARY KEY (`id`),
  KEY `feedsource_id` (`feedsource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;

INSERT INTO `post` (`id`, `feedsource_id`, `title`, `publishedAt`, `image`, `totalViews`, `favorites`, `latitude`, `longitude`, `summary`, `body`)
VALUES
	(1,1,'Test',NULL,NULL,1,1,-1.111000,2.222000,'asdfasdfasdfsdfsdf','asdfasdfasdfadfasdfasdf');

/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
