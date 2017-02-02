-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: fat_cms
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
  `id_article_category` int(4) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_article`
--

LOCK TABLES `fat_article` WRITE;
/*!40000 ALTER TABLE `fat_article` DISABLE KEYS */;
INSERT INTO `fat_article` VALUES (1,3,'2017-02-02',NULL,'et-eaque-non-deserunt-fuga-lorem-molestiasa.jpg','et-eaque-non-deserunt-fuga-lorem-molestiasa-thumb.jpg','et-eaque-non-deserunt-fuga-lorem-molestiasa',1,1,0,'2017-02-02 02:50:25','2017-02-01 19:48:11'),(2,2,'2017-02-02',NULL,'alias-aut-anim-aut-laudantium-eius-autea.jpg','alias-aut-anim-aut-laudantium-eius-autea-thumb.jpg','alias-aut-anim-aut-laudantium-eius-autea',1,1,0,'2017-02-02 20:01:39','2017-02-02 12:59:30');
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
  `primary_image` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `uri_path` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_article_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_article_category`
--

LOCK TABLES `fat_article_category` WRITE;
/*!40000 ALTER TABLE `fat_article_category` DISABLE KEYS */;
INSERT INTO `fat_article_category` VALUES (1,NULL,'sport'),(2,NULL,'travelling'),(3,NULL,'foods');
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
  `description` text COLLATE utf8_bin,
  PRIMARY KEY (`id_article_category_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_article_category_detail`
--

LOCK TABLES `fat_article_category_detail` WRITE;
/*!40000 ALTER TABLE `fat_article_category_detail` DISABLE KEYS */;
INSERT INTO `fat_article_category_detail` VALUES (15,3,1,'Foods','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),(16,3,2,'Makanan','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),(17,2,1,'Travelling','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),(18,2,2,'Jalan Jalan','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),(19,1,1,'Sport','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),(20,1,2,'Olahraga','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_article_detail`
--

LOCK TABLES `fat_article_detail` WRITE;
/*!40000 ALTER TABLE `fat_article_detail` DISABLE KEYS */;
INSERT INTO `fat_article_detail` VALUES (3,1,1,'Et eaque non deserunt fuga Lorem molestiasa','Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.','<p>Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.</p>'),(8,2,1,'Alias aut anim aut laudantium eius autea','Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.','<p>Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.</p>\r\n<p>Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.</p>'),(9,2,2,'Quia a magni voluptas','Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.','<p>Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.</p>\r\n<p>Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.</p>');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_group`
--

LOCK TABLES `fat_auth_group` WRITE;
/*!40000 ALTER TABLE `fat_auth_group` DISABLE KEYS */;
INSERT INTO `fat_auth_group` VALUES (1,'Super Administrator',1),(4,'Administrator',1);
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
  `icon_tags` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `position` tinyint(4) DEFAULT '1',
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_auth_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_menu`
--

LOCK TABLES `fat_auth_menu` WRITE;
/*!40000 ALTER TABLE `fat_auth_menu` DISABLE KEYS */;
INSERT INTO `fat_auth_menu` VALUES (1,0,'Settings','#','fa fa-gears',2,0),(2,1,'Admin User','admin','fa fa-user',21,0),(3,83,'Back End Menu (Module)','menu','fa fa-align-left',12,1),(4,1,'Admin User Group & Authorization','group','fa fa-users',22,0),(5,83,'Front End Menu (Static Page)','pages','fa fa-align-left',11,0),(24,1,'Site Management','site','fa fa-ban',23,1),(36,1,'Logs Record (Admin)','logs','fa fa-archive',24,0),(68,1,'Localization','localization','fa fa-flag-checkered',55,1),(83,0,'Menu','#','fa fa-bars',1,0),(110,0,'Slideshow','slideshow','fa fa-picture-o',3,0),(111,0,'Articles','#','fa fa-newspaper-o',4,0),(112,111,'Article Category','category','fa fa-newspaper-o',41,0),(113,111,'Articles','article','fa fa-newspaper-o',42,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=976 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_menu_group`
--

LOCK TABLES `fat_auth_menu_group` WRITE;
/*!40000 ALTER TABLE `fat_auth_menu_group` DISABLE KEYS */;
INSERT INTO `fat_auth_menu_group` VALUES (757,3,1),(758,3,2),(760,3,3),(761,3,5),(762,3,24),(763,3,36),(786,2,1),(787,2,2),(789,2,36),(933,1,83),(934,1,5),(935,1,3),(936,1,1),(937,1,2),(938,1,4),(939,1,24),(940,1,36),(941,1,68),(952,1,110),(953,3,83),(954,3,5),(955,3,3),(956,3,1),(957,3,2),(958,3,4),(959,3,24),(960,3,36),(961,3,68),(962,3,110),(963,4,83),(964,4,5),(965,4,3),(966,4,1),(967,4,2),(968,4,4),(969,4,24),(970,4,36),(971,4,68),(972,4,110),(973,1,111),(974,1,112),(975,1,113);
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
  `remember_token` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `activation` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  `themes` enum('adminlte2','sbadmin2') COLLATE utf8_bin DEFAULT 'adminlte2',
  PRIMARY KEY (`id_auth_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_auth_user`
--

LOCK TABLES `fat_auth_user` WRITE;
/*!40000 ALTER TABLE `fat_auth_user` DISABLE KEYS */;
INSERT INTO `fat_auth_user` VALUES (1,1,1,'admin','$2a$12$K3lcuQSGceMztnMSrsL/Wey1dDt6Q.sAUN32eMFZ8N9xnDBwFRuNa','Ivan Lubis','ivan.z.lubis@gmail.com','adm_ivan_lubis_c4ca4238a0b923820dcc509a6f75849b.jpg','','','2017-02-01 18:40:48','2014-01-02 03:58:55','2017-02-02 14:59:10','',NULL,1,1,''),(2,1,1,'super_admin','$2a$12$1NGZogETgKmEp0/f1rDRoOU./8MqsUS/23re5jY2M/aTTNvSsDgzK','Super Admin','ihate.haters@yahoo.com','adm_super_admin_c81e728d9d4c2f636f067f89cc14862c.jpg','','081311124565','2017-01-31 15:06:07','2017-01-31 07:32:22',NULL,NULL,NULL,1,1,'adminlte2');
/*!40000 ALTER TABLE `fat_auth_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_front_session`
--

DROP TABLE IF EXISTS `fat_front_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_front_session` (
  `id` varchar(128) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_front_session`
--

LOCK TABLES `fat_front_session` WRITE;
/*!40000 ALTER TABLE `fat_front_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `fat_front_session` ENABLE KEYS */;
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
INSERT INTO `fat_localization` VALUES (1,'English','en','eng','english',1),(2,'Indonesia','id','ina','indonesia',0);
/*!40000 ALTER TABLE `fat_localization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_page`
--

DROP TABLE IF EXISTS `fat_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_page` (
  `id_page` int(11) NOT NULL AUTO_INCREMENT,
  `parent_page` int(11) NOT NULL,
  `page_name` varchar(200) COLLATE utf8_bin NOT NULL,
  `page_type` enum('static_page','module','external_link') COLLATE utf8_bin NOT NULL DEFAULT 'static_page',
  `uri_path` varchar(200) COLLATE utf8_bin NOT NULL,
  `module` varchar(150) COLLATE utf8_bin NOT NULL,
  `ext_link` varchar(220) COLLATE utf8_bin DEFAULT NULL,
  `primary_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `thumbnail_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `background_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `icon_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `position` smallint(6) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_header` tinyint(1) NOT NULL DEFAULT '0',
  `is_footer` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_page`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_page`
--

LOCK TABLES `fat_page` WRITE;
/*!40000 ALTER TABLE `fat_page` DISABLE KEYS */;
INSERT INTO `fat_page` VALUES (1,0,'Home','module','','home','',NULL,NULL,NULL,NULL,1,1,0,0,0,0,'2017-02-02 16:21:22','2017-02-02 07:21:42'),(2,0,'About','static_page','about','','',NULL,NULL,NULL,NULL,2,1,1,1,1,0,NULL,'2017-02-02 09:23:26'),(3,0,'Article','module','article','article','',NULL,NULL,NULL,NULL,3,1,1,1,1,0,NULL,'2017-02-02 11:47:54');
/*!40000 ALTER TABLE `fat_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_page_detail`
--

DROP TABLE IF EXISTS `fat_page_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_page_detail` (
  `id_page_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_page` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `teaser` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_page_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_page_detail`
--

LOCK TABLES `fat_page_detail` WRITE;
/*!40000 ALTER TABLE `fat_page_detail` DISABLE KEYS */;
INSERT INTO `fat_page_detail` VALUES (2,1,1,'Home','',''),(3,1,2,'Beranda','',''),(4,2,1,'About','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),(5,2,2,'Tentang Kami','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),(6,3,1,'Article','',''),(7,3,2,'Artikel','','');
/*!40000 ALTER TABLE `fat_page_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_page_image`
--

DROP TABLE IF EXISTS `fat_page_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_page_image` (
  `id_page_image` int(11) NOT NULL AUTO_INCREMENT,
  `id_page` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8_bin NOT NULL,
  `position` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_page_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_page_image`
--

LOCK TABLES `fat_page_image` WRITE;
/*!40000 ALTER TABLE `fat_page_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `fat_page_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_site`
--

DROP TABLE IF EXISTS `fat_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_site` (
  `id_site` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_path` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_logo` varchar(255) COLLATE utf8_bin NOT NULL,
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
-- Dumping data for table `fat_site`
--

LOCK TABLES `fat_site` WRITE;
/*!40000 ALTER TABLE `fat_site` DISABLE KEYS */;
INSERT INTO `fat_site` VALUES (1,'FAT XMS','/','/','','','','',1,1,0,'2017-02-02 15:03:03','2012-07-11 00:00:00');
/*!40000 ALTER TABLE `fat_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_site_setting`
--

DROP TABLE IF EXISTS `fat_site_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_site_setting` (
  `id_site_setting` int(11) NOT NULL AUTO_INCREMENT,
  `id_site` int(11) NOT NULL DEFAULT '0',
  `type` varchar(150) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_site_setting`),
  KEY `id_site` (`id_site`)
) ENGINE=InnoDB AUTO_INCREMENT=731 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_site_setting`
--

LOCK TABLES `fat_site_setting` WRITE;
/*!40000 ALTER TABLE `fat_site_setting` DISABLE KEYS */;
INSERT INTO `fat_site_setting` VALUES (714,1,'app_footer','© 2017 All rights reserved.'),(715,1,'app_title','FAT CMS'),(716,1,'email_contact','ivan.z.lubis@gmail.com'),(717,1,'email_contact_name','FAT Admin'),(718,1,'facebook_url','#'),(719,1,'ip_approved','::1;127.0.0.1'),(720,1,'mail_host','mail.test.com'),(721,1,'mail_pass','mail27'),(722,1,'mail_port','25'),(723,1,'mail_protocol','smtp'),(724,1,'mail_user','smtp@test.com'),(725,1,'maintenance_message','<p>This site currently on maintenance, please check again later.</p>\r\n'),(726,1,'maintenance_mode','0'),(727,1,'twitter_url','#'),(728,1,'web_description',''),(729,1,'web_keywords',''),(730,1,'welcome_message','You can go to https://github.com/isumiring/codeigniter3-custom-cms for detail info');
/*!40000 ALTER TABLE `fat_site_setting` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_slideshow`
--

LOCK TABLES `fat_slideshow` WRITE;
/*!40000 ALTER TABLE `fat_slideshow` DISABLE KEYS */;
INSERT INTO `fat_slideshow` VALUES (1,'ipsum_mollitia_nulla_est_amet_sunt_nostrud_c4ca4238a0b923820dcc509a6f75849b.jpg',NULL,1,'http://google.com',1,0,NULL,'2017-02-02 06:31:45');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_slideshow_detail`
--

LOCK TABLES `fat_slideshow_detail` WRITE;
/*!40000 ALTER TABLE `fat_slideshow_detail` DISABLE KEYS */;
INSERT INTO `fat_slideshow_detail` VALUES (1,1,1,'Ipsum mollitia nulla est amet sunt nostrud','<p>Ipsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrud</p>\r\n<p>Ipsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrud</p>');
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
-- Table structure for table `fat_xms_log`
--

DROP TABLE IF EXISTS `fat_xms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_xms_log` (
  `id_log` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_auth_user` bigint(15) NOT NULL DEFAULT '0',
  `id_auth_group` bigint(15) NOT NULL DEFAULT '0',
  `ip_address` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_bin NOT NULL,
  `desc` text CHARACTER SET utf8,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_xms_log`
--

LOCK TABLES `fat_xms_log` WRITE;
/*!40000 ALTER TABLE `fat_xms_log` DISABLE KEYS */;
INSERT INTO `fat_xms_log` VALUES (1,0,0,'192.168.33.1','Login','Login:failed; IP:192.168.33.1; username:asfasf;','2017-01-30 08:24:28'),(2,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 08:25:25'),(3,1,1,'192.168.33.1','Delete Admin Menu','Delete Admin Menu; ID: 104;','2017-01-30 08:26:49'),(4,1,1,'192.168.33.1','Delete Admin Menu','Delete Admin Menu; ID: 102;','2017-01-30 08:26:49'),(5,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 09:47:40'),(6,1,1,'192.168.33.1','Delete Admin Menu','Delete Admin Menu; ID: 101;','2017-01-30 09:47:57'),(7,1,1,'192.168.33.1','Delete Admin Menu','Delete Admin Menu; ID: 107;','2017-01-30 09:50:51'),(8,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 09:53:01'),(9,1,1,'192.168.33.1','Delete Admin Menu','Delete Admin Menu; ID: 108;','2017-01-30 09:53:12'),(10,1,1,'192.168.33.1','Delete Admin Menu','Delete Admin Menu; ID: 100;','2017-01-30 09:54:38'),(11,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 10:05:28'),(12,1,1,'192.168.33.1','Delete Admin Menu','Delete Admin Menu; ID: 109;','2017-01-30 10:09:25'),(13,0,0,'192.168.33.1','Login','Login:failed; IP:192.168.33.1; username:admin;','2017-01-30 15:38:04'),(14,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 15:38:08'),(15,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 15:48:23'),(16,1,1,'192.168.33.1','Menu Admin','Add Menu Admin; ID: 110; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Slideshow\",\"file\":\"slideshow\",\"icon_tags\":\"fa fa-image-o\",\"position\":\"3\",\"is_superadmin\":0}','2017-01-30 15:48:41'),(17,1,1,'192.168.33.1','Menu Admin','Edit Menu Admin; ID: 110; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Slideshow\",\"file\":\"slideshow\",\"icon_tags\":\"fa fa-picture-o\",\"position\":\"3\",\"is_superadmin\":0}','2017-01-30 15:49:37'),(18,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 15:56:45'),(19,1,1,'192.168.33.1','Menu Admin','Edit Menu Admin; ID: 110; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Slideshow\",\"file\":\"slideshow\",\"icon_tags\":\"ion-images\",\"position\":\"3\",\"is_superadmin\":0}','2017-01-30 15:56:50'),(20,1,1,'192.168.33.1','Menu Admin','Edit Menu Admin; ID: 110; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Slideshow\",\"file\":\"slideshow\",\"icon_tags\":\"fa fa-picture-o\",\"position\":\"3\",\"is_superadmin\":0}','2017-01-30 15:57:15'),(21,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 16:51:08'),(22,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-30 17:34:49'),(23,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 07:18:58'),(24,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 07:19:44'),(25,1,1,'192.168.33.1','User Admin','Edit User Admin; ID: 1; Data: {\"id_auth_group\":\"1\",\"username\":\"admina\",\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"status\":true,\"is_superadmin\":true,\"themes\":\"adminlte2\",\"modify_date\":\"2017-01-31 14:21:51\"}','2017-01-31 07:21:51'),(26,1,1,'192.168.33.1','User Admin','Edit User Admin; ID: 1; Data: {\"id_auth_group\":\"1\",\"username\":\"admin\",\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"status\":true,\"is_superadmin\":true,\"themes\":\"adminlte2\",\"modify_date\":\"2017-01-31 14:22:01\"}','2017-01-31 07:22:01'),(27,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 07:22:11'),(28,0,0,'192.168.33.1','Login','Login:failed; IP:192.168.33.1; username:admin;','2017-01-31 07:31:23'),(29,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 07:31:27'),(30,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 08:03:00'),(31,1,1,'192.168.33.1','User Admin','Edit User Admin; ID: 1; Data: {\"id_auth_group\":\"1\",\"username\":\"admin\",\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"status\":true,\"is_superadmin\":true,\"themes\":\"adminlte2\",\"modify_date\":\"2017-01-31 15:05:29\"}','2017-01-31 08:05:29'),(32,1,1,'192.168.33.1','User Admin','Delete Picture User Admin; ID: 1;','2017-01-31 08:05:44'),(33,1,1,'192.168.33.1','User Admin','Edit User Admin; ID: 1; Data: {\"id_auth_group\":\"1\",\"username\":\"admin\",\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"address\":\"\",\"phone\":\"\",\"status\":true,\"is_superadmin\":true,\"themes\":\"adminlte2\",\"modify_date\":\"2017-01-31 15:05:57\"}','2017-01-31 08:05:57'),(34,1,1,'192.168.33.1','User Admin','Edit User Admin; ID: 2; Data: {\"id_auth_group\":\"1\",\"username\":\"super_admin\",\"name\":\"Super Admin\",\"email\":\"ihate.haters@yahoo.com\",\"address\":\"\",\"phone\":\"081311124565\",\"status\":true,\"is_superadmin\":true,\"themes\":\"adminlte2\",\"modify_date\":\"2017-01-31 15:06:07\"}','2017-01-31 08:06:07'),(35,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 08:12:38'),(36,0,0,'192.168.33.1','Login','Login:failed; IP:192.168.33.1; username:admin;','2017-01-31 08:53:28'),(37,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 08:53:30'),(38,1,1,'192.168.33.1','Admin Group','Edit Admin Group; ID: 1; Data: {\"auth_group\":\"Super Administratora\",\"is_superadmin\":true}','2017-01-31 08:53:37'),(39,1,1,'192.168.33.1','Admin Group','Edit Admin Group; ID: 1; Data: {\"auth_group\":\"Super Administrator\",\"is_superadmin\":true}','2017-01-31 08:53:42'),(40,1,1,'192.168.33.1','Group Admin','Add Group Admin; ID: 2; Data: {\"auth_group\":\"Administrator\",\"is_superadmin\":true}','2017-01-31 08:53:59'),(41,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 08:59:49'),(42,1,1,'192.168.33.1','Group Admin','Add Group Admin; ID: 3; Data: {\"auth_group\":\"Administrator\",\"is_superadmin\":true}','2017-01-31 09:00:02'),(43,1,1,'192.168.33.1','Admin Group','Edit Admin Group Authentication; ID: 3; Data: {\"auth_menu_group\":[\"83\",\"5\",\"3\",\"1\",\"2\",\"4\",\"24\",\"36\",\"68\",\"110\"]}','2017-01-31 09:00:10'),(44,1,1,'192.168.33.1','Group Admin','Add Group Admin; ID: 4; Data: {\"auth_group\":\"Administrator\",\"is_superadmin\":true}','2017-01-31 09:00:26'),(45,1,1,'192.168.33.1','Admin Group','Edit Admin Group Authentication; ID: 4; Data: {\"auth_menu_group\":[\"83\",\"5\",\"3\",\"1\",\"2\",\"4\",\"24\",\"36\",\"68\",\"110\"]}','2017-01-31 09:00:31'),(46,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 09:20:16'),(47,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 09:30:00'),(48,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 09:50:34'),(49,1,1,'192.168.33.1','Site Setting','Edit Site Setting; ID: 1; Data: {\"site_name\":\"FAT XMSA\",\"site_url\":\"\\/\",\"site_path\":\"\\/\",\"site_address\":\"\",\"is_default\":true,\"modify_date\":\"2017-01-31 16:50:39\"}','2017-01-31 09:50:39'),(50,1,1,'192.168.33.1','Site Setting','Edit Site Setting; ID: 1; Data: {\"site_name\":\"FAT XMS\",\"site_url\":\"\\/\",\"site_path\":\"\\/\",\"site_address\":\"\",\"is_default\":true,\"modify_date\":\"2017-01-31 16:51:01\"}','2017-01-31 09:51:01'),(51,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 11:05:09'),(52,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-01-31 12:00:17'),(53,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 05:41:53'),(54,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 05:58:42'),(55,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 10:46:41'),(56,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 11:21:40'),(57,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 11:39:03'),(58,1,1,'192.168.33.1','Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"phone\":\"\",\"address\":\"\",\"themes\":\"\",\"modify_date\":\"2017-02-01 18:40:40\"}','2017-02-01 11:40:40'),(59,1,1,'192.168.33.1','Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubisa\",\"email\":\"ivan.z.lubis@gmail.com\",\"phone\":\"\",\"address\":\"\",\"themes\":\"\",\"modify_date\":\"2017-02-01 18:40:45\"}','2017-02-01 11:40:45'),(60,1,1,'192.168.33.1','Profile','Edit Profile; ID: 1; Data: {\"name\":\"Ivan Lubis\",\"email\":\"ivan.z.lubis@gmail.com\",\"phone\":\"\",\"address\":\"\",\"themes\":\"\",\"modify_date\":\"2017-02-01 18:40:48\"}','2017-02-01 11:40:48'),(61,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 17:53:00'),(62,1,1,'192.168.33.1','Menu Admin','Add Menu Admin; ID: 111; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Articles\",\"file\":\"#\",\"icon_tags\":\"\",\"position\":\"4\",\"is_superadmin\":0}','2017-02-01 17:53:24'),(63,1,1,'192.168.33.1','Menu Admin','Edit Menu Admin; ID: 111; Data: {\"parent_auth_menu\":\"0\",\"menu\":\"Articles\",\"file\":\"#\",\"icon_tags\":\"fa fa-newspaper-o\",\"position\":\"4\",\"is_superadmin\":0}','2017-02-01 17:54:58'),(64,1,1,'192.168.33.1','Menu Admin','Add Menu Admin; ID: 112; Data: {\"parent_auth_menu\":\"111\",\"menu\":\"Article Category\",\"file\":\"category\",\"icon_tags\":\"fa fa-newspaper-o\",\"position\":\"41\",\"is_superadmin\":0}','2017-02-01 17:55:27'),(65,1,1,'192.168.33.1','Menu Admin','Add Menu Admin; ID: 113; Data: {\"parent_auth_menu\":\"111\",\"menu\":\"Articles\",\"file\":\"article\",\"icon_tags\":\"fa fa-newspaper-o\",\"position\":\"42\",\"is_superadmin\":0}','2017-02-01 17:55:43'),(66,1,1,'192.168.33.1','Category','Add Category; ID: 1; Data: {\"uri_path\":\"sport\",\"locales\":[{\"id_article_category\":1,\"title\":\"Sport\",\"id_localization\":1}]}','2017-02-01 17:57:28'),(67,1,1,'192.168.33.1','Category','Edit Category; ID: 1; Data: {\"uri_path\":\"sporta\",\"locales\":[{\"id_article_category\":\"1\",\"title\":\"Sporta\",\"id_localization\":1}]}','2017-02-01 17:57:37'),(68,1,1,'192.168.33.1','Category','Edit Category; ID: 1; Data: {\"uri_path\":\"sport\",\"locales\":[{\"id_article_category\":\"1\",\"title\":\"Sport\",\"id_localization\":1}]}','2017-02-01 17:57:43'),(69,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 18:03:32'),(70,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 18:18:06'),(71,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 18:28:22'),(72,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-01 18:34:51'),(73,1,1,'192.168.33.1','Article','Add Article; ID: 1; Data: {\"id_article_category\":\"3\",\"publish_date\":\"2017-02-02\",\"expire_date\":null,\"uri_path\":\"et-eaque-non-deserunt-fuga-lorem-molestiasa\",\"id_status\":\"1\",\"is_featured\":true,\"locales\":[{\"id_article\":1,\"title\":\"Et eaque non deserunt fuga Lorem molestiasa\",\"teaser\":\"Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.\",\"description\":\"<p>Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.<\\/p>\",\"id_localization\":1}]}','2017-02-01 19:48:11'),(74,1,1,'192.168.33.1','Article','Delete Thumbnail Picture Article; ID: 1;','2017-02-01 19:48:21'),(75,1,1,'192.168.33.1','Article','Delete Primary Picture Article; ID: 1;','2017-02-01 19:48:22'),(76,1,1,'192.168.33.1','Article','Edit Article; ID: 1; Data: {\"id_article_category\":\"3\",\"publish_date\":\"2017-02-02\",\"expire_date\":null,\"uri_path\":\"et-eaque-non-deserunt-fuga-lorem-molestiasa\",\"id_status\":\"1\",\"is_featured\":true,\"modify_date\":\"2017-02-02 02:48:57\",\"locales\":[{\"id_article\":\"1\",\"title\":\"Et eaque non deserunt fuga Lorem molestiasa\",\"teaser\":\"Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.\",\"description\":\"<p>Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.<\\/p>\",\"id_localization\":1}]}','2017-02-01 19:48:57'),(77,1,1,'192.168.33.1','Article','Delete Thumbnail Picture Article; ID: 1;','2017-02-01 19:49:25'),(78,1,1,'192.168.33.1','Article','Delete Primary Picture Article; ID: 1;','2017-02-01 19:49:26'),(79,1,1,'192.168.33.1','Article','Edit Article; ID: 1; Data: {\"id_article_category\":\"3\",\"publish_date\":\"2017-02-02\",\"expire_date\":null,\"uri_path\":\"et-eaque-non-deserunt-fuga-lorem-molestiasa\",\"id_status\":\"1\",\"is_featured\":true,\"modify_date\":\"2017-02-02 02:50:25\",\"locales\":[{\"id_article\":\"1\",\"title\":\"Et eaque non deserunt fuga Lorem molestiasa\",\"teaser\":\"Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.\",\"description\":\"<p>Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.Deleniti autem esse ea sunt, non quidem rerum quaerat animi, sunt nobis corporis nulla cillum commodo.<\\/p>\",\"id_localization\":1}]}','2017-02-01 19:50:25'),(80,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-02 06:30:34'),(81,1,1,'192.168.33.1','Slideshow','Add Slideshow; ID: 1; Data: {\"position\":\"1\",\"url_link\":\"http:\\/\\/google.com\",\"id_status\":\"1\",\"locales\":[{\"id_slideshow\":1,\"title\":\"Ipsum mollitia nulla est amet sunt nostrud\",\"caption\":\"<p>Ipsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrud<\\/p>\\r\\n<p>Ipsum mollitia nulla est amet sunt nostrudIpsum mollitia nulla est amet sunt nostrud<\\/p>\",\"id_localization\":1}]}','2017-02-02 06:31:45'),(82,1,1,'192.168.33.1','Pages','Add Pages; ID: 1; Data: {\"parent_page\":\"0\",\"page_name\":\"Home\",\"page_type\":\"2\",\"module\":\"home\",\"position\":\"1\",\"id_status\":\"1\",\"is_featured\":true,\"is_header\":true,\"is_footer\":true,\"locales\":[{\"id_page\":1,\"title\":\"Home\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":1}]}','2017-02-02 07:21:42'),(83,0,0,'192.168.33.1','Login','Login:succeed; IP:192.168.33.1; username:admin;','2017-02-02 07:59:10'),(84,1,1,'192.168.33.1','Site Setting','Edit Site Setting; ID: 1; Data: {\"site_name\":\"FAT XMS\",\"site_url\":\"\\/\",\"site_path\":\"\\/\",\"site_address\":\"\",\"is_default\":true,\"modify_date\":\"2017-02-02 15:03:03\"}','2017-02-02 08:03:03'),(85,1,1,'192.168.33.1','Category','Edit Category; ID: 1; Data: {\"uri_path\":\"sport\",\"locales\":[{\"id_article_category\":\"1\",\"title\":\"Sport\",\"id_localization\":1}]}','2017-02-02 08:06:34'),(86,1,1,'192.168.33.1','Localization','Add Localization; ID: 2; Data: {\"locale\":\"Indonesia\",\"iso_1\":\"id\",\"iso_2\":\"ina\",\"locale_path\":\"id\",\"locale_status\":true}','2017-02-02 08:07:10'),(87,1,1,'192.168.33.1','Pages','Edit Pages; ID: 1; Data: {\"parent_page\":\"0\",\"page_name\":\"Home\",\"page_type\":\"module\",\"uri_path\":\"\",\"module\":\"home\",\"ext_link\":\"\",\"position\":\"1\",\"id_status\":\"1\",\"is_featured\":0,\"is_header\":0,\"is_footer\":0,\"modify_date\":\"2017-02-02 16:21:22\",\"locales\":[{\"id_page\":\"1\",\"title\":\"Home\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":1},{\"id_page\":\"1\",\"title\":\"Beranda\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":2}]}','2017-02-02 09:21:22'),(88,1,1,'192.168.33.1','Pages','Add Pages; ID: 2; Data: {\"parent_page\":\"0\",\"page_name\":\"About\",\"page_type\":\"static_page\",\"uri_path\":\"about\",\"module\":\"\",\"ext_link\":\"\",\"position\":\"2\",\"id_status\":\"1\",\"is_featured\":true,\"is_header\":true,\"is_footer\":true,\"locales\":[{\"id_page\":2,\"title\":\"About\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":1},{\"id_page\":2,\"title\":\"Tentang Kami\",\"teaser\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":2}]}','2017-02-02 09:23:26'),(89,1,1,'192.168.33.1','Category','Edit Category; ID: 1; Data: {\"uri_path\":\"sport\",\"locales\":[{\"id_article_category\":\"1\",\"title\":\"Sport\",\"id_localization\":1},{\"id_article_category\":\"1\",\"title\":\"Olahraga\",\"id_localization\":2}]}','2017-02-02 09:42:14'),(90,1,1,'192.168.33.1','Category','Add Category; ID: 2; Data: {\"uri_path\":\"travelling\",\"locales\":[{\"id_article_category\":2,\"title\":\"Travelling\",\"id_localization\":1},{\"id_article_category\":2,\"title\":\"Jalan Jalan\",\"id_localization\":2}]}','2017-02-02 09:42:44'),(91,1,1,'192.168.33.1','Category','Add Category; ID: 3; Data: {\"uri_path\":\"foods\",\"locales\":[{\"id_article_category\":3,\"title\":\"Foods\",\"id_localization\":1},{\"id_article_category\":3,\"title\":\"Makanan\",\"id_localization\":2}]}','2017-02-02 09:43:02'),(92,1,1,'192.168.33.1','Category','Edit Category; ID: 3; Data: {\"uri_path\":\"foods\",\"locales\":[{\"id_article_category\":\"3\",\"title\":\"Foods\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":1},{\"id_article_category\":\"3\",\"title\":\"Makanan\",\"description\":\"\",\"id_localization\":2}]}','2017-02-02 11:02:33'),(93,1,1,'192.168.33.1','Category','Edit Category; ID: 3; Data: {\"uri_path\":\"foods\",\"locales\":[{\"id_article_category\":\"3\",\"title\":\"Foods\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":1},{\"id_article_category\":\"3\",\"title\":\"Makanan\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":2}]}','2017-02-02 11:02:43'),(94,1,1,'192.168.33.1','Category','Edit Category; ID: 3; Data: {\"uri_path\":\"foods\",\"locales\":[{\"id_article_category\":\"3\",\"title\":\"Foods\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":1},{\"id_article_category\":\"3\",\"title\":\"Makanan\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":2}]}','2017-02-02 11:03:35'),(95,1,1,'192.168.33.1','Category','Edit Category; ID: 2; Data: {\"uri_path\":\"travelling\",\"locales\":[{\"id_article_category\":\"2\",\"title\":\"Travelling\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":1},{\"id_article_category\":\"2\",\"title\":\"Jalan Jalan\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":2}]}','2017-02-02 11:04:09'),(96,1,1,'192.168.33.1','Category','Edit Category; ID: 1; Data: {\"uri_path\":\"sport\",\"locales\":[{\"id_article_category\":\"1\",\"title\":\"Sport\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":1},{\"id_article_category\":\"1\",\"title\":\"Olahraga\",\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\",\"id_localization\":2}]}','2017-02-02 11:04:18'),(97,1,1,'192.168.33.1','Pages','Add Pages; ID: 3; Data: {\"parent_page\":\"0\",\"page_name\":\"Article\",\"page_type\":\"module\",\"uri_path\":\"article\",\"module\":\"article\",\"ext_link\":\"\",\"position\":\"3\",\"id_status\":\"1\",\"is_featured\":true,\"is_header\":true,\"is_footer\":true,\"locales\":[{\"id_page\":3,\"title\":\"Article\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":1},{\"id_page\":3,\"title\":\"Artikel\",\"teaser\":\"\",\"description\":\"\",\"id_localization\":2}]}','2017-02-02 11:47:54'),(98,1,1,'192.168.33.1','Article','Add Article; ID: 2; Data: {\"id_article_category\":\"17\",\"publish_date\":\"2017-02-02\",\"expire_date\":null,\"uri_path\":\"alias-aut-anim-aut-laudantium-eius-autea\",\"id_status\":\"1\",\"is_featured\":true,\"locales\":[{\"id_article\":2,\"title\":\"Alias aut anim aut laudantium eius autea\",\"teaser\":\"Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.\",\"description\":\"<p>Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.<\\/p>\\r\\n<p>Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.<\\/p>\",\"id_localization\":1},{\"id_article\":2,\"title\":\"Quia a magni voluptas\",\"teaser\":\"Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.\",\"description\":\"<p>Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.<\\/p>\\r\\n<p>Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.<\\/p>\",\"id_localization\":2}]}','2017-02-02 12:59:30'),(99,1,1,'192.168.33.1','Article','Edit Article; ID: 2; Data: {\"id_article_category\":\"15\",\"publish_date\":\"2017-02-02\",\"expire_date\":null,\"uri_path\":\"alias-aut-anim-aut-laudantium-eius-autea\",\"id_status\":\"1\",\"is_featured\":true,\"modify_date\":\"2017-02-02 19:59:40\",\"locales\":[{\"id_article\":\"2\",\"title\":\"Alias aut anim aut laudantium eius autea\",\"teaser\":\"Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.\",\"description\":\"<p>Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.<\\/p>\\r\\n<p>Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.<\\/p>\",\"id_localization\":1},{\"id_article\":\"2\",\"title\":\"Quia a magni voluptas\",\"teaser\":\"Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.\",\"description\":\"<p>Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.<\\/p>\\r\\n<p>Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.<\\/p>\",\"id_localization\":2}]}','2017-02-02 12:59:40'),(100,1,1,'192.168.33.1','Article','Edit Article; ID: 2; Data: {\"id_article_category\":\"2\",\"publish_date\":\"2017-02-02\",\"expire_date\":null,\"uri_path\":\"alias-aut-anim-aut-laudantium-eius-autea\",\"id_status\":\"1\",\"is_featured\":true,\"modify_date\":\"2017-02-02 20:01:39\",\"locales\":[{\"id_article\":\"2\",\"title\":\"Alias aut anim aut laudantium eius autea\",\"teaser\":\"Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.\",\"description\":\"<p>Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.<\\/p>\\r\\n<p>Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.Dolore consequatur? Omnis voluptatibus unde provident, odio sequi sint reiciendis nisi eum ea velit itaque aute maxime placeat, sequi.<\\/p>\",\"id_localization\":1},{\"id_article\":\"2\",\"title\":\"Quia a magni voluptas\",\"teaser\":\"Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.\",\"description\":\"<p>Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.<\\/p>\\r\\n<p>Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.Incidunt, culpa ad a ullam nisi quis rerum mollitia in ad dolore in reiciendis porro quasi est ullamco in fugit.<\\/p>\",\"id_localization\":2}]}','2017-02-02 13:01:39');
/*!40000 ALTER TABLE `fat_xms_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_xms_session`
--

DROP TABLE IF EXISTS `fat_xms_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_xms_session` (
  `id` varchar(128) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_xms_session`
--

LOCK TABLES `fat_xms_session` WRITE;
/*!40000 ALTER TABLE `fat_xms_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `fat_xms_session` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-02 20:10:02
