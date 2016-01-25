-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: xms
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu1

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
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_category`
--

DROP TABLE IF EXISTS `article_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_category` (
  `id_article_category` int(11) NOT NULL AUTO_INCREMENT,
  `uri_path` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_article_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_category`
--

LOCK TABLES `article_category` WRITE;
/*!40000 ALTER TABLE `article_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_category_detail`
--

DROP TABLE IF EXISTS `article_category_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_category_detail` (
  `id_article_category_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_article_category` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_article_category_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_category_detail`
--

LOCK TABLES `article_category_detail` WRITE;
/*!40000 ALTER TABLE `article_category_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_category_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_detail`
--

DROP TABLE IF EXISTS `article_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_detail` (
  `id_article_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `teaser` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_article_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_detail`
--

LOCK TABLES `article_detail` WRITE;
/*!40000 ALTER TABLE `article_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_group`
--

DROP TABLE IF EXISTS `auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group` (
  `id_auth_group` int(11) NOT NULL AUTO_INCREMENT,
  `auth_group` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_auth_group`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group`
--

LOCK TABLES `auth_group` WRITE;
/*!40000 ALTER TABLE `auth_group` DISABLE KEYS */;
INSERT INTO `auth_group` VALUES (1,'Super Administrator',1);
/*!40000 ALTER TABLE `auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_menu`
--

DROP TABLE IF EXISTS `auth_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_menu` (
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
-- Dumping data for table `auth_menu`
--

LOCK TABLES `auth_menu` WRITE;
/*!40000 ALTER TABLE `auth_menu` DISABLE KEYS */;
INSERT INTO `auth_menu` VALUES (1,0,'Settings','#',5,0),(2,1,'Admin User','admin',51,0),(3,83,'Back End Menu (Module)','menu',12,1),(4,1,'Admin User Group & Authorization','group',52,0),(5,83,'Front End Menu','pages',11,0),(24,1,'Site Management','site',53,1),(36,1,'Logs Record (Admin)','logs',54,0),(50,0,'Slideshow','slideshow',2,0),(68,1,'Localization','localization',55,1),(70,0,'Article','#',3,0),(71,70,'Article Category','article_category',31,0),(72,70,'Article','article',32,0),(83,0,'Menu','#',1,0),(84,0,'Event','event',4,0);
/*!40000 ALTER TABLE `auth_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_menu_group`
--

DROP TABLE IF EXISTS `auth_menu_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_menu_group` (
  `id_auth_menu_group` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_auth_group` int(11) NOT NULL DEFAULT '0',
  `id_auth_menu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_auth_menu_group`)
) ENGINE=MyISAM AUTO_INCREMENT=857 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_menu_group`
--

LOCK TABLES `auth_menu_group` WRITE;
/*!40000 ALTER TABLE `auth_menu_group` DISABLE KEYS */;
INSERT INTO `auth_menu_group` VALUES (855,1,68),(856,1,84),(854,1,36),(853,1,24),(852,1,4),(851,1,2),(850,1,1),(771,3,50),(849,1,72),(797,2,50),(848,1,71),(847,1,70),(846,1,50),(845,1,5),(789,2,36),(787,2,2),(786,2,1),(763,3,36),(762,3,24),(761,3,5),(760,3,3),(758,3,2),(757,3,1),(844,1,3),(843,1,83);
/*!40000 ALTER TABLE `auth_menu_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user`
--

DROP TABLE IF EXISTS `auth_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user` (
  `id_auth_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_auth_group` int(11) NOT NULL,
  `id_site` int(11) NOT NULL DEFAULT '1',
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `userpass` text COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `alamat` text COLLATE utf8_bin,
  `organisasi` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `aktivasi` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  `themes` varchar(100) COLLATE utf8_bin DEFAULT 'sbadmin2',
  PRIMARY KEY (`id_auth_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user`
--

LOCK TABLES `auth_user` WRITE;
/*!40000 ALTER TABLE `auth_user` DISABLE KEYS */;
INSERT INTO `auth_user` VALUES (1,1,1,'admin','$2y$10$keTaq9.qfb0ca/Xo33UeKuOXdH9Q77MBWbm4CtGgoRM7mcAvDqFfi','Ivan Lubis','ivan.z.lubis@gmail.com','adm_ivan_lubis_c4ca4238a0b923820dcc509a6f75849b.jpg','',NULL,'','2015-10-15 15:01:35','2014-01-02 10:58:55','2014-01-02 17:58:55',NULL,1,1,'sbadmin2');
/*!40000 ALTER TABLE `auth_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user_group`
--

DROP TABLE IF EXISTS `auth_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user_group` (
  `id_auth_user_group` int(11) NOT NULL AUTO_INCREMENT,
  `auth_user_group` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_auth_user_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user_group`
--

LOCK TABLES `auth_user_group` WRITE;
/*!40000 ALTER TABLE `auth_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_sessions`
--

DROP TABLE IF EXISTS `cms_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_sessions` (
  `id` varchar(40) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_sessions`
--

LOCK TABLES `cms_sessions` WRITE;
/*!40000 ALTER TABLE `cms_sessions` DISABLE KEYS */;
INSERT INTO `cms_sessions` VALUES ('5a2daf924324b7974d1b9cfb4f62e7eaa8fd76b8','127.0.0.1',1444734702,'__ci_last_regenerate|i:1444734702;'),('daf74def4f8af7bcb3f6d21eab0f56a3b7af421f','127.0.0.1',1444908692,'__ci_last_regenerate|i:1444908505;tmp_login_redirect|s:25:\"http://localhost/CMS/xms/\";ADM_SESS|a:8:{s:10:\"admin_name\";s:10:\"Ivan Lubis\";s:19:\"admin_id_auth_group\";s:1:\"1\";s:18:\"admin_id_auth_user\";s:33:\"_c4ca4238a0b923820dcc509a6f75849b\";s:11:\"admin_email\";s:22:\"ivan.z.lubis@gmail.com\";s:8:\"admin_ip\";s:9:\"127.0.0.1\";s:9:\"admin_url\";s:25:\"http://localhost/CMS/xms/\";s:11:\"admin_token\";s:32:\"2ab8d4de12607b57467c48b94021e3a8\";s:16:\"admin_last_login\";s:19:\"2014-01-02 17:58:55\";}'),('c81f6c6c0614f9521deba3f6e626b0decfc4cb47','127.0.0.1',1445230036,'__ci_last_regenerate|i:1445229909;tmp_login_redirect|s:25:\"http://localhost/CMS/xms/\";ADM_SESS|a:8:{s:10:\"admin_name\";s:10:\"Ivan Lubis\";s:19:\"admin_id_auth_group\";s:1:\"1\";s:18:\"admin_id_auth_user\";s:33:\"_c4ca4238a0b923820dcc509a6f75849b\";s:11:\"admin_email\";s:22:\"ivan.z.lubis@gmail.com\";s:8:\"admin_ip\";s:9:\"127.0.0.1\";s:9:\"admin_url\";s:25:\"http://localhost/CMS/xms/\";s:11:\"admin_token\";s:32:\"326119f8c9ae7f32c45ca9a192ae1452\";s:16:\"admin_last_login\";s:19:\"2014-01-02 17:58:55\";}'),('a4740ff4ab2d3ab0156d7534883908d8d4926c71','127.0.0.1',1445582043,'__ci_last_regenerate|i:1445582041;ADM_SESS|a:8:{s:10:\"admin_name\";s:10:\"Ivan Lubis\";s:19:\"admin_id_auth_group\";s:1:\"1\";s:18:\"admin_id_auth_user\";s:33:\"_c4ca4238a0b923820dcc509a6f75849b\";s:11:\"admin_email\";s:22:\"ivan.z.lubis@gmail.com\";s:8:\"admin_ip\";s:9:\"127.0.0.1\";s:9:\"admin_url\";s:25:\"http://localhost/CMS/xms/\";s:11:\"admin_token\";s:32:\"a1caa15d1bbfe5a6081a6190e9d2bceb\";s:16:\"admin_last_login\";s:19:\"2014-01-02 17:58:55\";}');
/*!40000 ALTER TABLE `cms_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `id_event_category` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_detail`
--

DROP TABLE IF EXISTS `event_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_detail` (
  `id_event_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `teaser` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_event_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_detail`
--

LOCK TABLES `event_detail` WRITE;
/*!40000 ALTER TABLE `event_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_sessions`
--

DROP TABLE IF EXISTS `front_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_sessions` (
  `id` varchar(40) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_sessions`
--

LOCK TABLES `front_sessions` WRITE;
/*!40000 ALTER TABLE `front_sessions` DISABLE KEYS */;
INSERT INTO `front_sessions` VALUES ('dee7373203e6f455da284eecf5a1d2d44ca9d990','127.0.0.1',1445427857,'__ci_last_regenerate|i:1445427750;'),('2bde0e3d793ed79273b411f4322cca446fcbc591','127.0.0.1',1445512071,'__ci_last_regenerate|i:1445512010;'),('122cce41aea5f5184b60d009f84f866324f6f728','127.0.0.1',1445583167,'__ci_last_regenerate|i:1445582873;');
/*!40000 ALTER TABLE `front_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localization`
--

DROP TABLE IF EXISTS `localization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localization` (
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
-- Dumping data for table `localization`
--

LOCK TABLES `localization` WRITE;
/*!40000 ALTER TABLE `localization` DISABLE KEYS */;
INSERT INTO `localization` VALUES (1,'english','en','eng','english',1),(2,'indonesia','id','idn','indonesia',0);
/*!40000 ALTER TABLE `localization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id_logs` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` bigint(15) NOT NULL DEFAULT '0',
  `id_group` bigint(15) NOT NULL DEFAULT '0',
  `action` varchar(255) COLLATE utf8_bin NOT NULL,
  `desc` text CHARACTER SET utf8,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_logs`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-13 09:29:41'),(2,1,1,'Menu Admin','Add Menu Admin; ID: 83; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Menu\",\"file\":\"#\",\"position\":\"1\",\"is_superadmin\":0}','2015-10-13 09:36:36'),(3,1,1,'Menu Admin','Edit Menu Admin; ID: 3; Data: {\"parent_auth_menu\":\"83\",\"menu\":\"Back End Menu (Module)\",\"file\":\"menu\",\"position\":\"1\",\"is_superadmin\":1}','2015-10-13 09:37:36'),(4,1,1,'Menu Admin','Add Menu Admin; ID: 84; Data: {\"parent_auth_menu\":\"83\",\"menu\":\"Front End Menu \\/ Static Pages\",\"file\":\"pages1\",\"position\":\"3\",\"is_superadmin\":0}','2015-10-13 09:38:20'),(5,1,1,'Menu Admin','Edit Menu Admin; ID: 3; Data: {\"parent_auth_menu\":\"83\",\"menu\":\"Back End Menu (Module)\",\"file\":\"menu\",\"position\":\"2\",\"is_superadmin\":1}','2015-10-13 09:38:48'),(6,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 84;','2015-10-13 09:39:59'),(7,1,1,'Menu Admin','Edit Menu Admin; ID: 5; Data: {\"parent_auth_menu\":\"83\",\"menu\":\"Front End Menu\",\"file\":\"pages\",\"position\":\"3\",\"is_superadmin\":0}','2015-10-13 09:40:42'),(8,1,1,'Menu Admin','Edit Menu Admin; ID: 50; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Slideshow \\/ Banner\",\"file\":\"slideshow\",\"position\":\"4\",\"is_superadmin\":0}','2015-10-13 10:25:30'),(9,1,1,'Menu Admin','Edit Menu Admin; ID: 70; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Article\",\"file\":\"#\",\"position\":\"5\",\"is_superadmin\":0}','2015-10-13 10:26:09'),(10,1,1,'Menu Admin','Edit Menu Admin; ID: 71; Data: {\"parent_auth_menu\":\"70\",\"menu\":\"Article Category\",\"file\":\"article_category\",\"position\":\"51\",\"is_superadmin\":0}','2015-10-13 10:26:21'),(11,1,1,'Menu Admin','Edit Menu Admin; ID: 72; Data: {\"parent_auth_menu\":\"70\",\"menu\":\"Article\",\"file\":\"article\",\"position\":\"52\",\"is_superadmin\":0}','2015-10-13 10:26:29'),(12,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 82;','2015-10-13 10:27:11'),(13,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 81;','2015-10-13 10:27:11'),(14,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 80;','2015-10-13 10:27:11'),(15,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 79;','2015-10-13 10:27:12'),(16,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 78;','2015-10-13 10:27:12'),(17,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 77;','2015-10-13 10:27:12'),(18,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 76;','2015-10-13 10:27:12'),(19,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 75;','2015-10-13 10:27:12'),(20,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 73;','2015-10-13 10:27:12'),(21,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 74;','2015-10-13 10:27:12'),(22,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 69;','2015-10-13 10:27:12'),(23,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 65;','2015-10-13 10:27:12'),(24,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 64;','2015-10-13 10:27:12'),(25,1,1,'Delete Admin Menu','Delete Admin Menu; ID: 62;','2015-10-13 10:27:13'),(26,1,1,'Admin Group','Edit Admin Group Authentication; ID: 1; Data: {\"auth_menu_group\":[\"83\",\"3\",\"5\",\"50\",\"70\",\"71\",\"72\",\"1\",\"2\",\"4\",\"24\",\"36\",\"68\"]}','2015-10-13 10:27:28'),(27,1,1,'Menu Admin','Edit Menu Admin; ID: 3; Data: {\"parent_auth_menu\":\"83\",\"menu\":\"Back End Menu (Module)\",\"file\":\"menu\",\"position\":\"12\",\"is_superadmin\":1}','2015-10-13 10:31:53'),(28,1,1,'Menu Admin','Edit Menu Admin; ID: 5; Data: {\"parent_auth_menu\":\"83\",\"menu\":\"Front End Menu\",\"file\":\"pages\",\"position\":\"11\",\"is_superadmin\":0}','2015-10-13 10:31:55'),(29,1,1,'Menu Admin','Edit Menu Admin; ID: 50; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Slideshow \\/ Banner\",\"file\":\"slideshow\",\"position\":\"2\",\"is_superadmin\":0}','2015-10-13 10:32:06'),(30,1,1,'Menu Admin','Edit Menu Admin; ID: 72; Data: {\"parent_auth_menu\":\"70\",\"menu\":\"Article\",\"file\":\"article\",\"position\":\"32\",\"is_superadmin\":0}','2015-10-13 10:32:28'),(31,1,1,'Menu Admin','Edit Menu Admin; ID: 71; Data: {\"parent_auth_menu\":\"70\",\"menu\":\"Article Category\",\"file\":\"article_category\",\"position\":\"31\",\"is_superadmin\":0}','2015-10-13 10:32:30'),(32,1,1,'Menu Admin','Edit Menu Admin; ID: 70; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Article\",\"file\":\"#\",\"position\":\"3\",\"is_superadmin\":0}','2015-10-13 10:32:32'),(33,1,1,'Menu Admin','Edit Menu Admin; ID: 1; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Settings\",\"file\":\"#\",\"position\":\"4\",\"is_superadmin\":0}','2015-10-13 10:33:18'),(34,1,1,'Menu Admin','Edit Menu Admin; ID: 4; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Admin User Group & Authorization\",\"file\":\"group\",\"position\":\"42\",\"is_superadmin\":0}','2015-10-13 10:33:48'),(35,1,1,'Menu Admin','Edit Menu Admin; ID: 2; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Admin User\",\"file\":\"admin\",\"position\":\"41\",\"is_superadmin\":0}','2015-10-13 10:33:53'),(36,1,1,'Menu Admin','Edit Menu Admin; ID: 36; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Logs Record (Admin)\",\"file\":\"logs\",\"position\":\"44\",\"is_superadmin\":0}','2015-10-13 10:34:07'),(37,1,1,'Menu Admin','Edit Menu Admin; ID: 24; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Site Management\",\"file\":\"site\",\"position\":\"43\",\"is_superadmin\":1}','2015-10-13 10:34:35'),(38,1,1,'Menu Admin','Edit Menu Admin; ID: 68; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Localization\",\"file\":\"localization\",\"position\":\"45\",\"is_superadmin\":1}','2015-10-13 10:34:41'),(39,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-15 08:00:49'),(40,1,1,'User Admin','Edit User Admin; ID: 1; Data: {\"username\":\"admin\",\"id_auth_group\":\"1\",\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"alamat\":\"\",\"phone\":\"\",\"status\":1,\"is_superadmin\":1,\"themes\":\"sbadmin2\",\"modify_date\":\"2015-10-15 15:01:35\"}','2015-10-15 08:01:35'),(41,1,1,'Site Setting','Edit Site Setting; ID: 1; Data: {\"site_name\":\"XMS\",\"site_url\":\"\\/\",\"site_path\":\"\\/\",\"site_address\":\"\",\"is_default\":1,\"modify_date\":\"2015-10-15 15:04:10\"}','2015-10-15 08:04:10'),(42,1,1,'Menu Admin','Edit Menu Admin; ID: 50; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Slideshow\",\"file\":\"slideshow\",\"position\":\"2\",\"is_superadmin\":0}','2015-10-15 10:41:50'),(43,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-19 03:57:45'),(44,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-19 04:52:53'),(45,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-20 03:39:39'),(46,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-20 07:27:10'),(47,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-21 07:34:03'),(48,1,1,'Menu Admin','Edit Menu Admin; ID: 1; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Settings\",\"file\":\"#\",\"position\":\"5\",\"is_superadmin\":0}','2015-10-21 07:35:02'),(49,1,1,'Menu Admin','Edit Menu Admin; ID: 2; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Admin User\",\"file\":\"admin\",\"position\":\"51\",\"is_superadmin\":0}','2015-10-21 07:36:26'),(50,1,1,'Menu Admin','Edit Menu Admin; ID: 4; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Admin User Group & Authorization\",\"file\":\"group\",\"position\":\"52\",\"is_superadmin\":0}','2015-10-21 07:36:32'),(51,1,1,'Menu Admin','Edit Menu Admin; ID: 24; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Site Management\",\"file\":\"site\",\"position\":\"53\",\"is_superadmin\":1}','2015-10-21 07:36:36'),(52,1,1,'Menu Admin','Edit Menu Admin; ID: 36; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Logs Record (Admin)\",\"file\":\"logs\",\"position\":\"54\",\"is_superadmin\":0}','2015-10-21 07:36:40'),(53,1,1,'Menu Admin','Edit Menu Admin; ID: 68; Data: {\"parent_auth_menu\":\"1\",\"menu\":\"Localization\",\"file\":\"localization\",\"position\":\"55\",\"is_superadmin\":1}','2015-10-21 07:36:48'),(54,1,1,'Menu Admin','Add Menu Admin; ID: 84; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Event\",\"file\":\"event\",\"position\":\"4\",\"is_superadmin\":0}','2015-10-21 07:37:18'),(55,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-21 10:14:13'),(56,1,1,'Pages','Add Pages; ID: 1; Data: {\"parent_page\":\"0\",\"page_name\":\"Home\",\"page_type\":\"2\",\"module\":\"home\",\"position\":\"1\",\"id_status\":\"1\",\"is_header\":\"1\",\"locales\":[{\"id_page\":1,\"title\":\"Home\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":1},{\"id_page\":1,\"title\":\"Beranda\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":2}]}','2015-10-21 11:05:58'),(57,1,1,'Pages','Add Pages; ID: 2; Data: {\"parent_page\":\"0\",\"page_name\":\"Article\",\"page_type\":\"2\",\"module\":\"article\",\"position\":\"2\",\"id_status\":\"1\",\"is_header\":\"1\",\"locales\":[{\"id_page\":2,\"title\":\"Article\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":1},{\"id_page\":2,\"title\":\"Artikel\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":2}]}','2015-10-21 11:06:26'),(58,1,1,'Pages','Edit Pages; ID: 2; Data: {\"parent_page\":\"1\",\"page_name\":\"Article\",\"page_type\":\"2\",\"module\":\"article\",\"position\":\"2\",\"id_status\":\"1\",\"is_header\":\"1\",\"modify_date\":\"2015-10-21 18:43:26\",\"locales\":[{\"id_page\":\"2\",\"title\":\"Article\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":1},{\"id_page\":\"2\",\"title\":\"Artikel\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":2}]}','2015-10-21 11:43:27'),(59,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-22 06:47:57'),(60,1,1,'Pages','Edit Pages; ID: 2; Data: {\"parent_page\":\"0\",\"page_name\":\"Article\",\"page_type\":\"2\",\"module\":\"article\",\"position\":\"2\",\"id_status\":\"1\",\"is_header\":\"1\",\"modify_date\":\"2015-10-22 13:58:19\",\"locales\":[{\"id_page\":\"2\",\"title\":\"Article\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":1},{\"id_page\":\"2\",\"title\":\"Artikel\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":2}]}','2015-10-22 06:58:19'),(61,1,1,'Slideshow','Add Slideshow; ID: 1; Data: {\"url_link\":\"\",\"position\":\"1\",\"id_status\":\"1\",\"locales\":[{\"id_slideshow\":1,\"title\":\"Slideshow 1\",\"caption\":\"\",\"id_localization\":1},{\"id_slideshow\":1,\"title\":\"Slideshow 1\",\"caption\":\"\",\"id_localization\":2}]}','2015-10-22 07:37:31'),(62,1,1,'Slideshow','Add Slideshow; ID: 1; Data: {\"url_link\":\"\",\"position\":\"1\",\"id_status\":\"1\",\"locales\":[{\"id_slideshow\":1,\"title\":\"Slideshow 1\",\"caption\":\"\",\"id_localization\":1},{\"id_slideshow\":1,\"title\":\"Slideshow 1\",\"caption\":\"\",\"id_localization\":2}]}','2015-10-22 07:40:08'),(63,1,1,'Slideshow','Add Slideshow; ID: 2; Data: {\"url_link\":\"\",\"position\":\"2\",\"id_status\":\"1\",\"locales\":[{\"id_slideshow\":2,\"title\":\"Slideshow 2\",\"caption\":\"\",\"id_localization\":1},{\"id_slideshow\":2,\"title\":\"Slideshow 2\",\"caption\":\"\",\"id_localization\":2}]}','2015-10-22 07:40:37'),(64,1,1,'Slideshow','Add Slideshow; ID: 3; Data: {\"url_link\":\"\",\"position\":\"3\",\"id_status\":\"1\",\"locales\":[{\"id_slideshow\":3,\"title\":\"Slideshow 3\",\"caption\":\"\",\"id_localization\":1},{\"id_slideshow\":3,\"title\":\"Slideshow 3\",\"caption\":\"\",\"id_localization\":2}]}','2015-10-22 07:41:03'),(65,1,1,'Pages','Add Pages; ID: 3; Data: {\"parent_page\":\"0\",\"page_name\":\"About Us\",\"page_type\":\"1\",\"uri_path\":\"about-us\",\"position\":\"3\",\"id_status\":\"1\",\"locales\":[{\"id_page\":3,\"title\":\"About Us\",\"teaser\":\"\",\"description\":\"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/p>\\r\\n\",\"id_localization\":1},{\"id_page\":3,\"title\":\"Tentang Kami\",\"teaser\":\"\",\"description\":\"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2015-10-22 08:31:11'),(66,1,1,'Pages','Edit Pages; ID: 3; Data: {\"parent_page\":\"0\",\"page_name\":\"About Us\",\"page_type\":\"1\",\"uri_path\":\"about-us\",\"position\":\"3\",\"id_status\":\"1\",\"is_header\":\"1\",\"modify_date\":\"2015-10-22 15:51:22\",\"locales\":[{\"id_page\":\"3\",\"title\":\"About Us\",\"teaser\":\"\",\"description\":\"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/p>\\r\\n\",\"id_localization\":1},{\"id_page\":\"3\",\"title\":\"Tentang Kami\",\"teaser\":\"\",\"description\":\"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/p>\\r\\n\",\"id_localization\":2}]}','2015-10-22 08:51:22'),(67,1,1,'Login','Login:succeed; IP:127.0.0.1; username:admin;','2015-10-23 06:28:13'),(68,1,1,'Pages','Add Pages; ID: 4; Data: {\"parent_page\":\"0\",\"page_name\":\"Privacy\",\"page_type\":\"1\",\"uri_path\":\"privacy\",\"position\":\"4\",\"id_status\":\"1\",\"is_footer\":\"1\",\"locales\":[{\"id_page\":4,\"title\":\"Privacy\",\"teaser\":\"\",\"description\":\"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/p>\\r\\n\",\"id_localization\":1},{\"id_page\":4,\"title\":\"Privacy\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":2}]}','2015-10-23 06:29:12'),(69,1,1,'Pages','Add Pages; ID: 5; Data: {\"parent_page\":\"0\",\"page_name\":\"Terms\",\"page_type\":\"1\",\"uri_path\":\"terms\",\"position\":\"5\",\"id_status\":\"1\",\"is_footer\":\"1\",\"locales\":[{\"id_page\":5,\"title\":\"Terms\",\"teaser\":\"\",\"description\":\"<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/p>\\r\\n\",\"id_localization\":1},{\"id_page\":5,\"title\":\"Terms\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":2}]}','2015-10-23 06:29:44');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
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
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,0,'Home',2,'','home',NULL,NULL,NULL,NULL,1,1,0,1,0,0,NULL,'2015-10-21 11:05:58'),(2,0,'Article',2,'','article',NULL,NULL,NULL,NULL,2,1,0,1,0,0,'2015-10-22 13:58:19','2015-10-21 11:06:26'),(3,0,'About Us',1,'about-us','',NULL,NULL,NULL,NULL,3,1,0,1,0,0,'2015-10-22 15:51:22','2015-10-22 08:31:11'),(4,0,'Privacy',1,'privacy','',NULL,NULL,NULL,NULL,4,1,0,0,1,0,NULL,'2015-10-23 06:29:12'),(5,0,'Terms',1,'terms','',NULL,NULL,NULL,NULL,5,1,0,0,1,0,NULL,'2015-10-23 06:29:44');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_detail`
--

DROP TABLE IF EXISTS `pages_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_detail` (
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
-- Dumping data for table `pages_detail`
--

LOCK TABLES `pages_detail` WRITE;
/*!40000 ALTER TABLE `pages_detail` DISABLE KEYS */;
INSERT INTO `pages_detail` VALUES (1,1,1,'Home','',''),(2,1,2,'Beranda','',''),(7,2,1,'Article','',''),(8,2,2,'Artikel','',''),(11,3,1,'About Us','','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),(12,3,2,'Tentang Kami','','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),(13,4,1,'Privacy','','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),(14,4,2,'Privacy','',''),(15,5,1,'Terms','','<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),(16,5,2,'Terms','','');
/*!40000 ALTER TABLE `pages_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_image`
--

DROP TABLE IF EXISTS `pages_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_image` (
  `id_page_image` int(11) NOT NULL AUTO_INCREMENT,
  `id_page` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8_bin NOT NULL,
  `position` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_page_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages_image`
--

LOCK TABLES `pages_image` WRITE;
/*!40000 ALTER TABLE `pages_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_image_caption`
--

DROP TABLE IF EXISTS `pages_image_caption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_image_caption` (
  `id_page_image_caption` int(11) NOT NULL AUTO_INCREMENT,
  `id_page` int(11) NOT NULL,
  `id_page_image` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `caption` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_page_image_caption`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages_image_caption`
--

LOCK TABLES `pages_image_caption` WRITE;
/*!40000 ALTER TABLE `pages_image_caption` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages_image_caption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `publish_date` date NOT NULL,
  `expire_date` date DEFAULT NULL,
  `primary_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock` tinyint(1) NOT NULL DEFAULT '0',
  `id_status` int(11) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_product`),
  KEY `uri_path` (`uri_path`),
  KEY `id_status` (`id_status`),
  KEY `is_featured` (`is_featured`),
  KEY `is_delete` (`is_delete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_detail`
--

DROP TABLE IF EXISTS `product_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_detail` (
  `id_product_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_product_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_detail`
--

LOCK TABLES `product_detail` WRITE;
/*!40000 ALTER TABLE `product_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id_setting` int(11) NOT NULL AUTO_INCREMENT,
  `id_site` int(11) NOT NULL DEFAULT '0',
  `type` varchar(150) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_setting`),
  KEY `is_site` (`id_site`)
) ENGINE=InnoDB AUTO_INCREMENT=459 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (442,1,'app_footer','© Copyright Ivan Lubis. fork it on Github https://github.com/isumiring/codeigniter3-custom-cms'),(443,1,'app_title','XMS'),(444,1,'email_contact','ivan.z.lubis@gmail.com'),(445,1,'email_contact_name','XMS Admin'),(446,1,'facebook_url','#'),(447,1,'ip_approved','::1;127.0.0.1'),(448,1,'mail_host','mail.test.com'),(449,1,'mail_pass','mail27'),(450,1,'mail_port','25'),(451,1,'mail_protocol','smtp'),(452,1,'mail_user','smtp@test.com'),(453,1,'maintenance_message','<p>This site currently on maintenance, please check again later.</p>\r\n'),(454,1,'maintenance_mode','0'),(455,1,'twitter_url','#'),(456,1,'web_description','This is website description'),(457,1,'web_keywords',''),(458,1,'welcome_message','');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites` (
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
-- Dumping data for table `sites`
--

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;
INSERT INTO `sites` VALUES (1,'XMS','/','/','xms.png',1,'','','',1,1,0,'2015-10-15 15:04:10','2012-07-11 00:00:00');
/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slideshow`
--

DROP TABLE IF EXISTS `slideshow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slideshow` (
  `id_slideshow` int(11) NOT NULL AUTO_INCREMENT,
  `primary_image` varchar(100) COLLATE utf8_bin NOT NULL,
  `video` varchar(200) COLLATE utf8_bin NOT NULL,
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
-- Dumping data for table `slideshow`
--

LOCK TABLES `slideshow` WRITE;
/*!40000 ALTER TABLE `slideshow` DISABLE KEYS */;
INSERT INTO `slideshow` VALUES (1,'slideshow_1.jpg','',1,'',1,0,NULL,'2015-10-22 07:40:07'),(2,'slideshow_2.jpg','',2,'',1,0,NULL,'2015-10-22 07:40:37'),(3,'slideshow_3.jpg','',3,'',1,0,NULL,'2015-10-22 07:41:02');
/*!40000 ALTER TABLE `slideshow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slideshow_detail`
--

DROP TABLE IF EXISTS `slideshow_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slideshow_detail` (
  `id_slideshow_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_slideshow` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin NOT NULL,
  `caption` text COLLATE utf8_bin,
  PRIMARY KEY (`id_slideshow_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slideshow_detail`
--

LOCK TABLES `slideshow_detail` WRITE;
/*!40000 ALTER TABLE `slideshow_detail` DISABLE KEYS */;
INSERT INTO `slideshow_detail` VALUES (1,1,1,'Slideshow 1',''),(2,1,2,'Slideshow 1',''),(3,2,1,'Slideshow 2',''),(4,2,2,'Slideshow 2',''),(5,3,1,'Slideshow 3',''),(6,3,2,'Slideshow 3','');
/*!40000 ALTER TABLE `slideshow_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status_text` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Publish'),(2,'Draft');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-12 15:38:47
