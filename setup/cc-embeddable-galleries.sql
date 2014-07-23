# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: ccomr-common-user.ccrd.clearchannel.com (MySQL 5.6.16-log)
# Database: phoenix_projects
# Generation Time: 2014-07-23 18:25:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cc_embeddable_galleries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cc_embeddable_galleries`;

CREATE TABLE `cc_embeddable_galleries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_entered` datetime DEFAULT NULL,
  `title` text,
  `description` text,
  `url_code` varchar(255) DEFAULT NULL,
  `thumb_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `url_code` (`url_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table cc_embeddable_galleries_slides
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cc_embeddable_galleries_slides`;

CREATE TABLE `cc_embeddable_galleries_slides` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `code` text,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table cc_embeddable_galleries_users_admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cc_embeddable_galleries_users_admin`;

CREATE TABLE `cc_embeddable_galleries_users_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `pword` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `password` (`pword`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
