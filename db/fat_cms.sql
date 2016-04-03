-- MySQL dump 10.16  Distrib 10.1.9-MariaDB, for osx10.6 (i386)
--
-- Host: localhost    Database: fat_cms
-- ------------------------------------------------------
-- Server version	10.1.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fat_article`
--

DROP TABLE IF EXISTS `fat_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_article` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `id_article_category` int(11) NOT NULL,
  `publish_date` date NOT NULL,
  `expire_date` date DEFAULT NULL,
  `primary_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_status` int(11) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_article`),
  KEY `uri_path` (`uri_path`),
  KEY `id_status` (`id_status`),
  KEY `is_delete` (`is_delete`),
  KEY `publish_date` (`publish_date`),
  KEY `end_date` (`expire_date`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_article`
--

LOCK TABLES `fat_article` WRITE;
/*!40000 ALTER TABLE `fat_article` DISABLE KEYS */;
INSERT INTO `fat_article` VALUES (1,1,'2016-04-02',NULL,'this_is_just_another_article.jpg','this_is_just_another_article-thumb.jpg','this-is-just-another-article',1,0,0,'2016-04-02 12:02:54','2016-04-01 17:24:56');
/*!40000 ALTER TABLE `fat_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_article_category`
--

DROP TABLE IF EXISTS `fat_article_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_article_category` (
  `id_article_category` int(11) NOT NULL AUTO_INCREMENT,
  `uri_path` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_article_category`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_article_category`
--

LOCK TABLES `fat_article_category` WRITE;
/*!40000 ALTER TABLE `fat_article_category` DISABLE KEYS */;
INSERT INTO `fat_article_category` VALUES (1,'whats-new');
/*!40000 ALTER TABLE `fat_article_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_article_category_detail`
--

DROP TABLE IF EXISTS `fat_article_category_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_article_category_detail` (
  `id_article_category_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_article_category` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_article_category_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_article_category_detail`
--

LOCK TABLES `fat_article_category_detail` WRITE;
/*!40000 ALTER TABLE `fat_article_category_detail` DISABLE KEYS */;
INSERT INTO `fat_article_category_detail` VALUES (1,1,1,'Whats New'),(2,1,2,'Terbaru');
/*!40000 ALTER TABLE `fat_article_category_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_article_detail`
--

DROP TABLE IF EXISTS `fat_article_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_article_detail` (
  `id_article_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `teaser` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_article_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_article_detail`
--

LOCK TABLES `fat_article_detail` WRITE;
/*!40000 ALTER TABLE `fat_article_detail` DISABLE KEYS */;
INSERT INTO `fat_article_detail` VALUES (7,1,1,'This is just another article','ENG Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ENG</p>\r\n'),(8,1,2,'Ini adalah sebuah artikel','IDN Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. IDN</p>\r\n');
/*!40000 ALTER TABLE `fat_article_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_auth_group`
--

DROP TABLE IF EXISTS `fat_auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_auth_group` (
  `id_auth_group` int(11) NOT NULL AUTO_INCREMENT,
  `auth_group` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_auth_group`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_group`
--

LOCK TABLES `fat_auth_group` WRITE;
/*!40000 ALTER TABLE `fat_auth_group` DISABLE KEYS */;
INSERT INTO `fat_auth_group` VALUES (1,'Super Administrator',1);
/*!40000 ALTER TABLE `fat_auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_auth_menu`
--

DROP TABLE IF EXISTS `fat_auth_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_auth_menu` (
  `id_auth_menu` int(11) NOT NULL AUTO_INCREMENT,
  `parent_auth_menu` int(11) NOT NULL DEFAULT '0',
  `menu` varchar(255) COLLATE utf8_bin NOT NULL,
  `file` varchar(255) COLLATE utf8_bin NOT NULL,
  `position` tinyint(4) DEFAULT '1',
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_auth_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_menu`
--

LOCK TABLES `fat_auth_menu` WRITE;
/*!40000 ALTER TABLE `fat_auth_menu` DISABLE KEYS */;
INSERT INTO `fat_auth_menu` VALUES (1,0,'Settings','#',2,0),(2,1,'Admin User','admin',21,0),(3,83,'Back End Menu (Module)','menu',12,1),(4,1,'Admin User Group & Authorization','group',22,0),(5,83,'Front End Menu','pages',11,0),(24,1,'Site Management','site',23,1),(36,1,'Logs Record (Admin)','logs',24,0),(50,0,'Slideshow','slideshow',3,0),(68,1,'Localization','localization',55,1),(70,0,'Article','#',4,0),(71,70,'Article Category','article_category',41,0),(72,70,'Article','article',42,0),(83,0,'Menu','#',1,0),(84,0,'Event','event',5,0);
/*!40000 ALTER TABLE `fat_auth_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_auth_menu_group`
--

DROP TABLE IF EXISTS `fat_auth_menu_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_auth_menu_group` (
  `id_auth_menu_group` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_auth_group` int(11) NOT NULL DEFAULT '0',
  `id_auth_menu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_auth_menu_group`)
) ENGINE=MyISAM AUTO_INCREMENT=860 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_menu_group`
--

LOCK TABLES `fat_auth_menu_group` WRITE;
/*!40000 ALTER TABLE `fat_auth_menu_group` DISABLE KEYS */;
INSERT INTO `fat_auth_menu_group` VALUES (855,1,68),(856,1,84),(854,1,36),(853,1,24),(852,1,4),(851,1,2),(850,1,1),(771,3,50),(849,1,72),(797,2,50),(848,1,71),(847,1,70),(846,1,50),(845,1,5),(789,2,36),(787,2,2),(786,2,1),(763,3,36),(762,3,24),(761,3,5),(760,3,3),(758,3,2),(757,3,1),(844,1,3),(843,1,83);
/*!40000 ALTER TABLE `fat_auth_menu_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_auth_user`
--

DROP TABLE IF EXISTS `fat_auth_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_auth_user` (
  `id_auth_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_auth_group` int(11) NOT NULL,
  `id_site` int(11) NOT NULL DEFAULT '1',
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `userpass` text COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `address` text COLLATE utf8_bin,
  `phone` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `activation` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  `themes` varchar(100) COLLATE utf8_bin DEFAULT 'sbadmin2',
  PRIMARY KEY (`id_auth_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_user`
--

LOCK TABLES `fat_auth_user` WRITE;
/*!40000 ALTER TABLE `fat_auth_user` DISABLE KEYS */;
INSERT INTO `fat_auth_user` VALUES (1,1,1,'admin','$2y$10$keTaq9.qfb0ca/Xo33UeKuOXdH9Q77MBWbm4CtGgoRM7mcAvDqFfi','Ivan Lubis','ivan.z.lubis@gmail.com','adm_ivan_lubis_c4ca4238a0b923820dcc509a6f75849b.jpg','','','2016-04-02 08:39:21','2014-01-02 10:58:55','2014-01-02 17:58:55',NULL,1,1,'sbadmin2');
/*!40000 ALTER TABLE `fat_auth_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_auth_user_group`
--

DROP TABLE IF EXISTS `fat_auth_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_auth_user_group` (
  `id_auth_user_group` int(11) NOT NULL AUTO_INCREMENT,
  `auth_user_group` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_auth_user_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_user_group`
--

LOCK TABLES `fat_auth_user_group` WRITE;
/*!40000 ALTER TABLE `fat_auth_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `fat_auth_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_event`
--

DROP TABLE IF EXISTS `fat_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_event` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish_date` date NOT NULL,
  `expire_date` date DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `primary_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_status` int(11) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_event`),
  KEY `uri_path` (`uri_path`),
  KEY `id_status` (`id_status`),
  KEY `is_delete` (`is_delete`),
  KEY `publish_date` (`publish_date`),
  KEY `expire_date` (`expire_date`),
  KEY `start_date` (`start_date`),
  KEY `end_date` (`end_date`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_event`
--

LOCK TABLES `fat_event` WRITE;
/*!40000 ALTER TABLE `fat_event` DISABLE KEYS */;
INSERT INTO `fat_event` VALUES (1,'Jakarta','2016-04-02',NULL,'2016-04-02 11:49:00',NULL,'genuino_day_2016.jpg','genuino_day_2016-thumb.jpg','genuino-day-2016',1,0,0,'2016-04-03 09:39:21','2016-04-02 04:56:46');
/*!40000 ALTER TABLE `fat_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_event_detail`
--

DROP TABLE IF EXISTS `fat_event_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_event_detail` (
  `id_event_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `teaser` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_event_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_event_detail`
--

LOCK TABLES `fat_event_detail` WRITE;
/*!40000 ALTER TABLE `fat_event_detail` DISABLE KEYS */;
INSERT INTO `fat_event_detail` VALUES (23,1,1,'GENUINO DAY 2016','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG</p>\r\n'),(24,1,2,'GENUINO DAY 2016','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n');
/*!40000 ALTER TABLE `fat_event_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_front_sessions`
--

DROP TABLE IF EXISTS `fat_front_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_front_sessions` (
  `id` varchar(40) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_front_sessions`
--

LOCK TABLES `fat_front_sessions` WRITE;
/*!40000 ALTER TABLE `fat_front_sessions` DISABLE KEYS */;
INSERT INTO `fat_front_sessions` VALUES ('dee7373203e6f455da284eecf5a1d2d44ca9d990','127.0.0.1',1445427857,'__ci_last_regenerate|i:1445427750;'),('2bde0e3d793ed79273b411f4322cca446fcbc591','127.0.0.1',1445512071,'__ci_last_regenerate|i:1445512010;'),('122cce41aea5f5184b60d009f84f866324f6f728','127.0.0.1',1445583167,'__ci_last_regenerate|i:1445582873;'),('1118bf82df256d89e39f716a345e305a824e066b','::1',1459651354,'__ci_last_regenerate|i:1459651344;');
/*!40000 ALTER TABLE `fat_front_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_localization`
--

DROP TABLE IF EXISTS `fat_localization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_localization` (
  `id_localization` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(150) COLLATE utf8_bin NOT NULL,
  `iso_1` varchar(50) COLLATE utf8_bin NOT NULL,
  `iso_2` varchar(50) COLLATE utf8_bin NOT NULL,
  `locale_path` varchar(200) COLLATE utf8_bin NOT NULL,
  `locale_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_localization`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_localization`
--

LOCK TABLES `fat_localization` WRITE;
/*!40000 ALTER TABLE `fat_localization` DISABLE KEYS */;
INSERT INTO `fat_localization` VALUES (1,'english','en','eng','english',1),(2,'indonesia','id','idn','indonesia',0);
/*!40000 ALTER TABLE `fat_localization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_logs`
--

DROP TABLE IF EXISTS `fat_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_logs` (
  `id_logs` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` bigint(15) NOT NULL DEFAULT '0',
  `id_group` bigint(15) NOT NULL DEFAULT '0',
  `ip_address` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_bin NOT NULL,
  `desc` text CHARACTER SET utf8,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_logs`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_logs`
--

LOCK TABLES `fat_logs` WRITE;
/*!40000 ALTER TABLE `fat_logs` DISABLE KEYS */;
INSERT INTO `fat_logs` VALUES (1,1,1,NULL,'Localization','Set Default Localization; ID: 2;','2016-03-29 14:17:14'),(2,1,1,NULL,'Localization','Set Default Localization; ID: 1;','2016-03-29 14:17:46'),(3,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-03-29 17:32:28'),(4,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-03-30 12:04:00'),(5,0,0,NULL,'Login','Login:failed; IP:::1; username:admin;','2016-03-31 12:13:47'),(6,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-03-31 12:13:55'),(7,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-03-31 12:14:51'),(8,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-03-31 12:20:01'),(9,1,1,NULL,'Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"themes\":\"sbadmin2\"}','2016-03-31 12:20:11'),(10,0,0,NULL,'Login','Login:failed; IP:::1; username:admin;','2016-03-31 12:20:36'),(11,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-03-31 12:20:39'),(12,1,1,NULL,'Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubisa\",\"email\":\"aivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"themes\":\"sbadmin2\"}','2016-03-31 12:22:10'),(13,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-03-31 12:24:12'),(14,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-03-31 12:25:54'),(15,1,1,NULL,'Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"themes\":\"sbadmin2\"}','2016-03-31 12:25:59'),(16,1,1,NULL,'Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.coma\",\"address\":\"\",\"phone\":\"\",\"themes\":\"sbadmin2\"}','2016-03-31 12:26:04'),(17,1,1,NULL,'Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"themes\":\"sbadmin2\"}','2016-03-31 12:26:07'),(18,1,1,NULL,'Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubisa\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"themes\":\"sbadmin2\"}','2016-03-31 12:28:41'),(19,1,1,NULL,'Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"themes\":\"sbadmin2\"}','2016-03-31 12:28:45'),(20,1,1,NULL,'Article Category','Add Article Category; ID: 1; Data: {\"uri_path\":\"whats-new\",\"locales\":[{\"id_article_category\":1,\"title\":\"Whats New\",\"id_localization\":1},{\"id_article_category\":1,\"title\":\"Terbaru\",\"id_localization\":2}]}','2016-03-31 12:51:24'),(21,0,0,NULL,'Login','Login:failed; IP:::1; username: admin;','2016-04-01 04:11:40'),(22,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-04-01 04:11:44'),(23,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-04-01 17:18:48'),(24,1,1,NULL,'Article','Add Article; ID: 1; Data: {\"id_article_category\":\"1\",\"uri_path\":\"this-is-just-another-article\",\"id_status\":\"1\",\"is_featured\":\"1\",\"publish_date\":\"2016-04-02\",\"expire_date\":null,\"locales\":[{\"id_article\":1,\"title\":\"This is just another article\",\"teaser\":\"ENG Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_article\":1,\"title\":\"Ini adalah sebuah artikel\",\"teaser\":\"IDN Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. IDN<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-01 17:24:56'),(25,1,1,NULL,'Article','Edit Article; ID: 1; Data: {\"id_article_category\":\"1\",\"uri_path\":\"this-is-just-another-article\",\"id_status\":\"1\",\"is_featured\":\"1\",\"publish_date\":\"2016-04-02\",\"modify_date\":\"2016-04-02 00:33:11\",\"expire_date\":null,\"locales\":[{\"id_article\":\"1\",\"title\":\"This is just another article\",\"teaser\":\"ENG Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_article\":\"1\",\"title\":\"Ini adalah sebuah artikel\",\"teaser\":\"IDN Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. IDN<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-01 17:33:11'),(26,1,1,NULL,'Article','Edit Article; ID: 1; Data: {\"id_article_category\":\"1\",\"uri_path\":\"this-is-just-another-article\",\"id_status\":\"1\",\"is_featured\":\"1\",\"publish_date\":\"2016-04-02\",\"modify_date\":\"2016-04-02 00:34:32\",\"expire_date\":null,\"locales\":[{\"id_article\":\"1\",\"title\":\"This is just another article\",\"teaser\":\"ENG Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_article\":\"1\",\"title\":\"Ini adalah sebuah artikel\",\"teaser\":\"IDN Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. IDN<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-01 17:34:32'),(27,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-04-02 01:38:59'),(28,1,1,NULL,'User Admin','Edit User Admin; ID: 1; Data: {\"username\":\"admin\",\"id_auth_group\":\"1\",\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"status\":true,\"is_superadmin\":true,\"themes\":\"sbadmin2\",\"modify_date\":\"2016-04-02 08:39:21\"}','2016-04-02 01:39:21'),(29,1,1,NULL,'Event','Add Event; ID: 1; Data: {\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"end_date\":null,\"locales\":[{\"id_event\":1,\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":1,\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-02 04:56:46'),(30,1,1,NULL,'Event','Edit Event; ID: 1; Data: {\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-02 12:00:49\",\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-02 05:00:49'),(31,1,1,NULL,'Article','Edit Article; ID: 1; Data: {\"id_article_category\":\"1\",\"uri_path\":\"this-is-just-another-article\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"modify_date\":\"2016-04-02 12:02:54\",\"is_featured\":0,\"expire_date\":null,\"locales\":[{\"id_article\":\"1\",\"title\":\"This is just another article\",\"teaser\":\"ENG Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_article\":\"1\",\"title\":\"Ini adalah sebuah artikel\",\"teaser\":\"IDN Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. IDN<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-02 05:02:54'),(32,1,1,NULL,'Event','Edit Event; ID: 1; Data: {\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-02 12:03:08\",\"is_featured\":0,\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-02 05:03:08'),(33,1,1,NULL,'Event','Edit Event; ID: 1; Data: {\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-02 12:03:25\",\"is_featured\":0,\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-02 05:03:25'),(34,1,1,NULL,'Event','Edit Event; ID: 1; Data: {\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"is_featured\":true,\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-02 12:03:46\",\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-02 05:03:46'),(35,1,1,NULL,'Event','Edit Event; ID: 1; Data: {\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-02 12:03:51\",\"is_featured\":0,\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-02 05:03:51'),(36,1,1,NULL,'Login','Login:succeed; IP:::1; username:admin;','2016-04-02 09:39:33'),(37,1,1,NULL,'Event','Edit Event; ID: 1; Data: {\"location\":\"Jakarta\",\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-03 09:37:17\",\"is_featured\":0,\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-03 02:37:17'),(38,1,1,NULL,'Event','Edit Event; ID: 1; Data: {\"location\":\"Jakarta\",\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-03 09:37:23\",\"is_featured\":0,\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-03 02:37:23'),(39,1,1,'::1','Event','Edit Event; ID: 1; Data: {\"location\":\"Jakarta\",\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-03 09:39:16\",\"is_featured\":0,\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-03 02:39:16'),(40,1,1,'::1','Event','Edit Event; ID: 1; Data: {\"location\":\"Jakarta\",\"uri_path\":\"genuino-day-2016\",\"id_status\":\"1\",\"publish_date\":\"2016-04-02\",\"start_date\":\"2016-04-02 11:49\",\"modify_date\":\"2016-04-03 09:39:21\",\"is_featured\":0,\"end_date\":null,\"locales\":[{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ENG<\\/p>\\r\\n\",\"id_localization\":1},{\"id_event\":\"1\",\"title\":\"GENUINO DAY 2016\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2016-04-03 02:39:21');
/*!40000 ALTER TABLE `fat_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_pages`
--

DROP TABLE IF EXISTS `fat_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_pages` (
  `id_page` int(11) NOT NULL AUTO_INCREMENT,
  `parent_page` int(11) NOT NULL,
  `page_name` varchar(200) COLLATE utf8_bin NOT NULL,
  `page_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=static pages; 2=module; 3=external link',
  `uri_path` varchar(200) COLLATE utf8_bin NOT NULL,
  `module` varchar(150) COLLATE utf8_bin NOT NULL,
  `ext_link` varchar(220) COLLATE utf8_bin DEFAULT NULL,
  `primary_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `thumbnail_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `background_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `position` smallint(6) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_header` tinyint(1) NOT NULL DEFAULT '0',
  `is_footer` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_page`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_pages`
--

LOCK TABLES `fat_pages` WRITE;
/*!40000 ALTER TABLE `fat_pages` DISABLE KEYS */;
INSERT INTO `fat_pages` VALUES (1,0,'Home',2,'','home',NULL,NULL,NULL,NULL,1,1,0,1,0,0,NULL,'2015-10-21 11:05:58'),(2,0,'Article',2,'','article',NULL,NULL,NULL,NULL,2,1,0,1,0,0,'2015-10-22 13:58:19','2015-10-21 11:06:26'),(3,0,'About Us',1,'about-us','',NULL,NULL,NULL,NULL,3,1,0,1,0,0,'2015-10-22 15:51:22','2015-10-22 08:31:11'),(4,0,'Privacy',1,'privacy','',NULL,NULL,NULL,NULL,4,1,0,0,1,0,NULL,'2015-10-23 06:29:12'),(5,0,'Terms',1,'terms','',NULL,NULL,NULL,NULL,5,1,0,0,1,0,NULL,'2015-10-23 06:29:44');
/*!40000 ALTER TABLE `fat_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_pages_detail`
--

DROP TABLE IF EXISTS `fat_pages_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_pages_detail` (
  `id_page_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_page` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `teaser` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_page_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_pages_detail`
--

LOCK TABLES `fat_pages_detail` WRITE;
/*!40000 ALTER TABLE `fat_pages_detail` DISABLE KEYS */;
INSERT INTO `fat_pages_detail` VALUES (1,1,1,'Home','',''),(2,1,2,'Beranda','',''),(7,2,1,'Article','',''),(8,2,2,'Artikel','',''),(11,3,1,'About Us','','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),(12,3,2,'Tentang Kami','','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),(13,4,1,'Privacy','','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),(14,4,2,'Privacy','',''),(15,5,1,'Terms','','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),(16,5,2,'Terms','','');
/*!40000 ALTER TABLE `fat_pages_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_pages_image`
--

DROP TABLE IF EXISTS `fat_pages_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_pages_image` (
  `id_page_image` int(11) NOT NULL AUTO_INCREMENT,
  `id_page` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8_bin NOT NULL,
  `position` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_page_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_pages_image`
--

LOCK TABLES `fat_pages_image` WRITE;
/*!40000 ALTER TABLE `fat_pages_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `fat_pages_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_pages_image_caption`
--

DROP TABLE IF EXISTS `fat_pages_image_caption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_pages_image_caption` (
  `id_page_image_caption` int(11) NOT NULL AUTO_INCREMENT,
  `id_page` int(11) NOT NULL,
  `id_page_image` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `caption` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_page_image_caption`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_pages_image_caption`
--

LOCK TABLES `fat_pages_image_caption` WRITE;
/*!40000 ALTER TABLE `fat_pages_image_caption` DISABLE KEYS */;
/*!40000 ALTER TABLE `fat_pages_image_caption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_setting`
--

DROP TABLE IF EXISTS `fat_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_setting` (
  `id_setting` int(11) NOT NULL AUTO_INCREMENT,
  `id_site` int(11) NOT NULL DEFAULT '0',
  `type` varchar(150) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_setting`),
  KEY `is_site` (`id_site`)
) ENGINE=InnoDB AUTO_INCREMENT=493 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_setting`
--

LOCK TABLES `fat_setting` WRITE;
/*!40000 ALTER TABLE `fat_setting` DISABLE KEYS */;
INSERT INTO `fat_setting` VALUES (476,1,'app_footer','© Copyright Ivan Lubis 2016'),(477,1,'app_title','FAT CMS'),(478,1,'email_contact','ivan.z.lubis@gmail.com'),(479,1,'email_contact_name','FAT CMS Admin'),(480,1,'facebook_url','#'),(481,1,'ip_approved','::1;127.0.0.1'),(482,1,'mail_host','mail.test.com'),(483,1,'mail_pass','mail27'),(484,1,'mail_port','25'),(485,1,'mail_protocol','smtp'),(486,1,'mail_user','smtp@test.com'),(487,1,'maintenance_message','<p>This site currently on maintenance, please check again later.</p>\r\n'),(488,1,'maintenance_mode','0'),(489,1,'twitter_url','#'),(490,1,'web_description','This is website description'),(491,1,'web_keywords',''),(492,1,'welcome_message','');
/*!40000 ALTER TABLE `fat_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_sites`
--

DROP TABLE IF EXISTS `fat_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_sites` (
  `id_site` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_path` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_logo` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_ref_publish` tinyint(4) NOT NULL,
  `site_address` text COLLATE utf8_bin NOT NULL,
  `site_longitude` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_latitude` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_urut` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `is_delete` tinyint(4) NOT NULL,
  `modify_date` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id_site`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_sites`
--

LOCK TABLES `fat_sites` WRITE;
/*!40000 ALTER TABLE `fat_sites` DISABLE KEYS */;
INSERT INTO `fat_sites` VALUES (1,'FAT CMS','/','/','xms.png',1,'','','',1,1,0,'2016-03-27 19:01:58','2012-07-11 00:00:00');
/*!40000 ALTER TABLE `fat_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_slideshow`
--

DROP TABLE IF EXISTS `fat_slideshow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_slideshow` (
  `id_slideshow` int(11) NOT NULL AUTO_INCREMENT,
  `primary_image` varchar(100) COLLATE utf8_bin NOT NULL,
  `mobile_image` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `position` int(11) NOT NULL,
  `url_link` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `id_status` int(11) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_slideshow`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_slideshow`
--

LOCK TABLES `fat_slideshow` WRITE;
/*!40000 ALTER TABLE `fat_slideshow` DISABLE KEYS */;
INSERT INTO `fat_slideshow` VALUES (1,'slideshow_1.jpg','',1,'',1,0,NULL,'2015-10-22 07:40:07'),(2,'slideshow_2.jpg','',2,'',1,0,NULL,'2015-10-22 07:40:37'),(3,'slideshow_3.jpg','',3,'',1,0,NULL,'2015-10-22 07:41:02');
/*!40000 ALTER TABLE `fat_slideshow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_slideshow_detail`
--

DROP TABLE IF EXISTS `fat_slideshow_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_slideshow_detail` (
  `id_slideshow_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_slideshow` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin NOT NULL,
  `caption` text COLLATE utf8_bin,
  PRIMARY KEY (`id_slideshow_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_slideshow_detail`
--

LOCK TABLES `fat_slideshow_detail` WRITE;
/*!40000 ALTER TABLE `fat_slideshow_detail` DISABLE KEYS */;
INSERT INTO `fat_slideshow_detail` VALUES (1,1,1,'Slideshow 1',''),(2,1,2,'Slideshow 1',''),(3,2,1,'Slideshow 2',''),(4,2,2,'Slideshow 2',''),(5,3,1,'Slideshow 3',''),(6,3,2,'Slideshow 3','');
/*!40000 ALTER TABLE `fat_slideshow_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_status`
--

DROP TABLE IF EXISTS `fat_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status_text` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_status`
--

LOCK TABLES `fat_status` WRITE;
/*!40000 ALTER TABLE `fat_status` DISABLE KEYS */;
INSERT INTO `fat_status` VALUES (1,'Publish'),(2,'Draft');
/*!40000 ALTER TABLE `fat_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_xms_sessions`
--

DROP TABLE IF EXISTS `fat_xms_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_xms_sessions` (
  `id` varchar(40) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_xms_sessions`
--

LOCK TABLES `fat_xms_sessions` WRITE;
/*!40000 ALTER TABLE `fat_xms_sessions` DISABLE KEYS */;
INSERT INTO `fat_xms_sessions` VALUES ('e51eaaeea89e471dfba4e9129fcd2e2ecefb4ed5','::1',1459258568,'__ci_last_regenerate|i:1459258568;tmp_login_redirect|s:0:\"\";'),('4b35f4f376ea5f59841c5680e1e1f162cdbc0e9f','::1',1459339449,'__ci_last_regenerate|i:1459339436;ADM_SESS|a:8:{s:10:\"admin_name\";s:10:\"Ivan Lubis\";s:19:\"admin_id_auth_group\";s:1:\"1\";s:18:\"admin_id_auth_user\";s:33:\"_c4ca4238a0b923820dcc509a6f75849b\";s:11:\"admin_email\";s:22:\"ivan.z.lubis@gmail.com\";s:8:\"admin_ip\";s:3:\"::1\";s:9:\"admin_url\";s:25:\"http://[::1]/fat-cms/xms/\";s:11:\"admin_token\";s:32:\"63b10574c2547a767d19d5cdfc9c8708\";s:16:\"admin_last_login\";s:19:\"2014-01-02 17:58:55\";}'),('7d3cb8f83e679f9e7e0b56d484cccd27a6967ad1','::1',1459531124,'__ci_last_regenerate|i:1459531124;tmp_login_redirect|s:0:\"\";'),('dbe5efb3583fffc61fb84d6dc83c8cc12e8951e1','::1',1459651336,'__ci_last_regenerate|i:1459651336;ADM_SESS|a:8:{s:10:\"admin_name\";s:10:\"Ivan Lubis\";s:19:\"admin_id_auth_group\";s:1:\"1\";s:18:\"admin_id_auth_user\";s:33:\"_c4ca4238a0b923820dcc509a6f75849b\";s:11:\"admin_email\";s:22:\"ivan.z.lubis@gmail.com\";s:8:\"admin_ip\";s:3:\"::1\";s:9:\"admin_url\";s:25:\"http://[::1]/fat-cms/xms/\";s:11:\"admin_token\";s:32:\"544b5e9bc569e93ae364c5fd1dd79e6c\";s:16:\"admin_last_login\";s:19:\"2014-01-02 17:58:55\";}');
/*!40000 ALTER TABLE `fat_xms_sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-03  9:43:22
