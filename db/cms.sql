-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2015 at 07:36 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `fat_auth_group`
--

DROP TABLE IF EXISTS `fat_auth_group`;
CREATE TABLE IF NOT EXISTS `fat_auth_group` (
`id_auth_group` int(11) NOT NULL,
  `auth_group` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_auth_group`
--

TRUNCATE TABLE `fat_auth_group`;
--
-- Dumping data for table `fat_auth_group`
--

INSERT INTO `fat_auth_group` (`id_auth_group`, `auth_group`, `is_superadmin`) VALUES
(1, 'Administrator', 1),
(2, 'Editorial', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fat_auth_menu`
--

DROP TABLE IF EXISTS `fat_auth_menu`;
CREATE TABLE IF NOT EXISTS `fat_auth_menu` (
`id_auth_menu` int(11) NOT NULL,
  `parent_auth_menu` int(11) NOT NULL DEFAULT '0',
  `menu` varchar(255) COLLATE utf8_bin NOT NULL,
  `file` varchar(255) COLLATE utf8_bin NOT NULL,
  `position` tinyint(4) DEFAULT '1',
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_auth_menu`
--

TRUNCATE TABLE `fat_auth_menu`;
--
-- Dumping data for table `fat_auth_menu`
--

INSERT INTO `fat_auth_menu` (`id_auth_menu`, `parent_auth_menu`, `menu`, `file`, `position`, `is_superadmin`) VALUES
(1, 0, 'Settings', '#', 1, 0),
(2, 1, 'Admin User', 'admin', 1, 0),
(3, 6, 'Back End Menu', 'menu', 1, 0),
(4, 1, 'Admin User Group &amp; Authorization', 'group', 1, 0),
(5, 6, 'Front End Menu', 'pages', 1, 0),
(6, 1, 'Menu', '#', 1, 0),
(24, 1, 'Site Management', 'site', 7, 1),
(36, 1, 'Logs', 'logs', 13, 0),
(41, 0, 'Slideshow', 'slideshow', 14, 0),
(42, 0, 'Product', '#', 15, 0),
(43, 42, 'Product Category', 'category', 16, 0),
(44, 42, 'Product', 'product', 17, 0),
(45, 0, 'Transaction', 'transaction', 18, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fat_auth_menu_group`
--

DROP TABLE IF EXISTS `fat_auth_menu_group`;
CREATE TABLE IF NOT EXISTS `fat_auth_menu_group` (
`id_auth_menu_group` bigint(11) NOT NULL,
  `id_auth_group` int(11) NOT NULL DEFAULT '0',
  `id_auth_menu` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=514 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_auth_menu_group`
--

TRUNCATE TABLE `fat_auth_menu_group`;
--
-- Dumping data for table `fat_auth_menu_group`
--

INSERT INTO `fat_auth_menu_group` (`id_auth_menu_group`, `id_auth_group`, `id_auth_menu`) VALUES
(512, 1, 44),
(511, 1, 43),
(510, 1, 42),
(509, 1, 41),
(508, 1, 36),
(507, 1, 24),
(506, 1, 5),
(302, 2, 11),
(505, 1, 3),
(504, 1, 6),
(503, 1, 4),
(502, 1, 2),
(501, 1, 1),
(513, 1, 45);

-- --------------------------------------------------------

--
-- Table structure for table `fat_auth_user`
--

DROP TABLE IF EXISTS `fat_auth_user`;
CREATE TABLE IF NOT EXISTS `fat_auth_user` (
`id_auth_user` int(11) NOT NULL,
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
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_auth_user`
--

TRUNCATE TABLE `fat_auth_user`;
--
-- Dumping data for table `fat_auth_user`
--

INSERT INTO `fat_auth_user` (`id_auth_user`, `id_auth_group`, `id_site`, `username`, `userpass`, `name`, `email`, `image`, `alamat`, `organisasi`, `phone`, `modify_date`, `create_date`, `last_login`, `aktivasi`, `status`, `is_superadmin`) VALUES
(1, 1, 1, 'admin', '$2y$10$Up4UOQ74OB2iIk7CtBMaPuw34/0mz0IluoVEATdbOhwmq3bMUfUCy', 'Administrator', 'ivan.z.lubis@gmail.com', 'adm_administrator_c4ca4238a0b923820dcc509a6f75849b.jpg', '', NULL, '', '2015-04-24 10:51:23', '2014-01-02 10:58:55', '2014-01-02 17:58:55', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fat_auth_user_group`
--

DROP TABLE IF EXISTS `fat_auth_user_group`;
CREATE TABLE IF NOT EXISTS `fat_auth_user_group` (
`id_auth_user_group` int(11) NOT NULL,
  `auth_user_group` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_auth_user_group`
--

TRUNCATE TABLE `fat_auth_user_group`;
-- --------------------------------------------------------

--
-- Table structure for table `fat_localization`
--

DROP TABLE IF EXISTS `fat_localization`;
CREATE TABLE IF NOT EXISTS `fat_localization` (
`id_localization` int(11) NOT NULL,
  `locale` varchar(150) COLLATE utf8_bin NOT NULL,
  `iso_1` varchar(50) COLLATE utf8_bin NOT NULL,
  `iso_2` varchar(50) COLLATE utf8_bin NOT NULL,
  `locale_path` varchar(200) COLLATE utf8_bin NOT NULL,
  `locale_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_localization`
--

TRUNCATE TABLE `fat_localization`;
--
-- Dumping data for table `fat_localization`
--

INSERT INTO `fat_localization` (`id_localization`, `locale`, `iso_1`, `iso_2`, `locale_path`, `locale_status`) VALUES
(1, 'english', 'en', 'eng', 'english', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fat_logs`
--

DROP TABLE IF EXISTS `fat_logs`;
CREATE TABLE IF NOT EXISTS `fat_logs` (
`id_logs` bigint(20) NOT NULL,
  `id_user` bigint(15) NOT NULL DEFAULT '0',
  `id_group` bigint(15) NOT NULL DEFAULT '0',
  `action` varchar(255) COLLATE utf8_bin NOT NULL,
  `desc` text CHARACTER SET utf8,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_logs`
--

TRUNCATE TABLE `fat_logs`;
--
-- Dumping data for table `fat_logs`
--

INSERT INTO `fat_logs` (`id_logs`, `id_user`, `id_group`, `action`, `desc`, `create_date`) VALUES
(1, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-12 05:23:36'),
(2, 1, 1, 'Pages', 'Add New Pages; ID: 1; Data: {"page_name":"About Us","parent_page":"0","page_type":"1","content_locale":{"1":{"title":"Tentang Rencanakan Segera","teaser":"Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.","description":"<p>Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.<\\/p>\\r\\n"}},"ext_link":"Sint sit nihil ut ut sed nesciunt excepturi non","module":"Libero voluptas rem debitis maxime","uri_path":"about-us","publish_date":"2015-01-12","id_status":"1","is_footer":1,"position":"1","is_featured":0,"is_header":0}', '2015-01-12 05:57:58'),
(3, 1, 1, 'Pages', 'Add New Pages; ID: 2; Data: {"page_name":"Privacy","parent_page":"0","page_type":"1","content_locale":{"1":{"title":"Privacy","teaser":"Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.","description":"<p>Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.<\\/p>\\r\\n"}},"ext_link":"","module":"Labore placeat at quibusdam voluptates exercitationem nisi cupiditate sit","uri_path":"privacy","publish_date":"2015-01-12","id_status":"1","is_footer":1,"position":"2","is_featured":0,"is_header":0}', '2015-01-12 05:59:13'),
(4, 1, 1, 'Pages', 'Edit Pages; ID: 1; Data: {"page_name":"About Us","parent_page":"0","page_type":"1","content_locale":{"1":{"title":"Tentang Rencanakan Segera","teaser":"Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.","description":"<p>Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.<\\/p>\\r\\n"}},"ext_link":"","module":"","uri_path":"about-us","publish_date":"2015-01-12","id_status":"1","is_footer":"1","position":"1","is_featured":0}', '2015-01-12 06:00:15'),
(5, 1, 1, 'Pages', 'Add New Pages; ID: 3; Data: {"page_name":"Axa-Mandiri","parent_page":"0","page_type":"3","content_locale":{"1":{"title":"","teaser":"","description":""}},"ext_link":"http:\\/\\/axa-mandiri.com","module":"","uri_path":"axa-mandiri","publish_date":"2015-01-12","id_status":"1","is_footer":1,"position":"3","is_featured":0,"is_header":0}', '2015-01-12 06:01:33'),
(6, 1, 1, 'Pages', 'Edit Pages; ID: 3; Data: {"page_name":"Axa Mandiri","parent_page":"0","page_type":"3","content_locale":{"1":{"title":"","teaser":"","description":""}},"ext_link":"http:\\/\\/axa-mandiri.com","module":"","uri_path":"axa-mandiri","publish_date":"2015-01-12","id_status":"1","is_footer":"1","position":"3","is_featured":0}', '2015-01-12 06:01:45'),
(7, 1, 1, 'Pages', 'Edit Pages; ID: 1; Data: {"page_name":"Tentang Rencanakan Segera","parent_page":"0","page_type":"1","content_locale":{"1":{"title":"Tentang Rencanakan Segera","teaser":"Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.","description":"<p>Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.<\\/p>\\r\\n"}},"ext_link":"","module":"","uri_path":"about-us","publish_date":"2015-01-12","id_status":"1","is_footer":"1","position":"1","is_featured":0}', '2015-01-12 06:12:23'),
(8, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-12 09:41:49'),
(9, 1, 1, 'Pages', 'Add New Pages; ID: 4; Data: {"page_name":"Article","parent_page":"0","page_type":"2","content_locale":{"1":{"title":"","teaser":"","description":""}},"ext_link":"","module":"article","uri_path":"article","publish_date":"2015-01-12","id_status":"1","position":"4","is_featured":0,"is_header":0,"is_footer":0}', '2015-01-12 09:42:21'),
(10, 1, 1, 'Article', 'Add New Article; ID: 2; Data: {"id_category":["4","3","2"],"id_topic":"1","content_locale":{"1":{"title":"Velit cillum nulla facilis voluptas sunt tempora dolorem alias nihil facerea","teaser":"Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.","description":"<p>Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.<\\/p>\\r\\n"}},"uri_path":"velit-cillum-nulla-facilis-voluptas-sunt-tempora-dolorem-alias-nihil-facerea","publish_date":"2015-01-12","id_status":"2","is_slideshow":"1","id_auth_user":"1"}', '2015-01-12 10:27:04'),
(11, 1, 1, 'Article', 'Edit Article; ID: 2; Data: {"id_category":["4","3","2"],"id_topic":"1","content_locale":{"1":{"title":"Velit cillum nulla facilis voluptas sunt tempora dolorem alias nihil facerea","teaser":"Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.","description":"<p>Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.Aut eos aliquam atque libero qui quae autem est dolore rem autem porro pariatur? Ipsum, voluptatibus.<\\/p>\\r\\n"}},"uri_path":"velit-cillum-nulla-facilis-voluptas-sunt-tempora-dolorem-alias-nihil-facerea","publish_date":"2015-01-12","id_status":"1","is_slideshow":"1","modify_date":"2015-01-12 17:27:33"}', '2015-01-12 10:27:33'),
(12, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-13 04:31:08'),
(13, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 36; Data: {"menu":"Logs","parent_auth_menu":"1","file":"log","position":"13","is_superadmin":0}', '2015-01-13 04:31:39'),
(14, 1, 1, 'Admin Group', 'Edit Admin Group Authentication; ID: 1; Data: {"auth_menu_group":["1","2","4","6","3","5","24","36","34","33","35","30","11","31","32"]}', '2015-01-13 04:31:57'),
(15, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 37; Data: {"menu":"Discussion","parent_auth_menu":"0","file":"#","position":"14","is_superadmin":0}', '2015-01-13 05:31:16'),
(16, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 38; Data: {"menu":"Advisor","parent_auth_menu":"37","file":"advisor","position":"15","is_superadmin":0}', '2015-01-13 05:31:49'),
(17, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 39; Data: {"menu":"Discussion","parent_auth_menu":"37","file":"discussion","position":"16","is_superadmin":0}', '2015-01-13 05:32:07'),
(18, 1, 1, 'Admin Group', 'Edit Admin Group Authentication; ID: 1; Data: {"auth_menu_group":["1","2","4","6","3","5","24","36","34","33","35","30","11","31","32","37","38","39"]}', '2015-01-13 05:32:24'),
(19, 1, 1, 'Advisor', 'Add New Advisor; ID: 1; Data: {"name":"Lisa Soemarto","email":"lisa@rencanakansegera.com","profile":"Konsultan Keuangan Independen"}', '2015-01-13 05:36:44'),
(20, 1, 1, 'Advisor', 'Edit Advisor; ID: 1; Data: {"name":"Lisa Soemarto","email":"lisa@rencanakansegera.com","profile":"Konsultan Keuangan Independen","modify_date":"2015-01-13 12:36:53"}', '2015-01-13 05:36:53'),
(21, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-13 07:15:11'),
(22, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-14 05:14:46'),
(23, 1, 1, 'Pages', 'Add New Pages; ID: 5; Data: {"page_name":"Discussion","parent_page":"0","page_type":"2","content_locale":{"1":{"title":"","teaser":"","description":""}},"ext_link":"","module":"discussion","uri_path":"discussion","publish_date":"2015-01-14","id_status":"1","position":"5","is_featured":0,"is_header":0,"is_footer":0}', '2015-01-14 05:15:10'),
(24, 1, 1, 'Discussion', 'Add New Discussion; ID: 1; Data: {"id_advisor":"1","id_topic":"1","content_locale":{"1":{"title":"Voluptas iusto eu eos veniam molestiae aliquip hic sunt nisi quia eaque sit animi debitis possimus eta","teaser":"Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.","description":"<p>Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.Et dolores eaque fuga. Inventore reprehenderit sint, ab fuga. Iure ut ducimus, nisi vero eu.<\\/p>\\r\\n"}},"uri_path":"voluptas-iusto-eu-eos-veniam-molestiae-aliquip-hic-sunt-nisi-quia-eaque-sit-animi-debitis-possimus-eta","publish_date":"2015-01-14","id_status":"1"}', '2015-01-14 07:38:34'),
(25, 1, 1, 'Discussion', 'Add New Discussion; ID: 2; Data: {"id_advisor":"1","id_topic":"3","content_locale":{"1":{"title":"Natus repellendus Qui ut voluptatem dolor dolorem explicabo Dolor pariatur Mollitia auta","teaser":"Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.","description":"<p>Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.<\\/p>\\r\\n\\r\\n<p>Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.Rerum illum, ipsum, in fuga. Dolor id aute eum totam velit anim quos totam corrupti.<\\/p>\\r\\n"}},"uri_path":"natus-repellendus-qui-ut-voluptatem-dolor-dolorem-explicabo-dolor-pariatur-mollitia-auta","publish_date":"2015-01-14","id_status":"1"}', '2015-01-14 08:34:39'),
(26, 1, 1, 'Discussion', 'Add New Discussion; ID: 3; Data: {"id_advisor":"1","id_topic":"4","content_locale":{"1":{"title":"Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod","teaser":"Numquam dolorem corporis est ut est, ut velit sit vero.","description":"<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n\\r\\n<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n"}},"uri_path":"ullamco-adipisci-architecto-culpa-quibusdam-id-non-labore-odio-recusandae-omnis-magna-est-deleniti-ut-eligendi-quod","publish_date":"2015-01-14","id_status":"1"}', '2015-01-14 08:46:29'),
(27, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-14 11:35:43'),
(28, 1, 1, 'Pages', 'Add New Pages; ID: 6; Data: {"page_name":"News","parent_page":"0","page_type":"2","content_locale":{"1":{"title":"","teaser":"","description":""}},"ext_link":"","module":"news","uri_path":"news","publish_date":"2015-01-14","id_status":"1","position":"6","is_featured":0,"is_header":0,"is_footer":0}', '2015-01-14 11:36:17'),
(29, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-15 03:23:23'),
(30, 1, 1, 'News', 'Edit News; ID: 2; Data: {"id_topic":"4","content_locale":{"1":{"title":"Bromo Tengger Semeru Ultratrail Run 2013","teaser":"The Mount Bromo Tengger Semeru Ultra Run race is a unique event that aims to challenge your inner spirit and physical state, as well as to provide race participants with magnificent natural beauty and environment of Bromo Tengger Semeru National Park in East Java - Indonesia at various altitude level. \\r\\nRunning at the high altitude region of Bromo Tengger Semeru National Park, you will experience tracks filled with various scenery, such as sea of volcanic sand (2.200 masl) with low temperature and strong wind. \\r\\nThen you will be running through rural back roads, forest path and prairie with a distant magnificent view of the highest mountain in Java, Mount Semeru (3.676 masl) and the tranquility of Lake Ranu Kumbolo (2.400 masl). \\r\\nAt last, this Bromo Tengger Semeru Ultra Run race will challenged you through 3 different distances, 160 km, 100 km and 50 km, in comfortable weather conditions and a very scenic route.\\r\\nMore information : http:\\/\\/bromotenggersemeru100ultra.com\\r\\n","description":"<p>The Mount Bromo Tengger Semeru Ultra Run race is a unique event that aims to challenge your inner spirit and physical state, as well as to provide race participants with magnificent natural beauty and environment of Bromo Tengger Semeru National Park in East Java - Indonesia at various altitude level.<br \\/>\\r\\nRunning at the high altitude region of Bromo Tengger Semeru National Park, you will experience tracks filled with various scenery, such as sea of volcanic sand (2.200 masl) with low temperature and strong wind.<br \\/>\\r\\nThen you will be running through rural back roads, forest path and prairie with a distant magnificent view of the highest mountain in Java, Mount Semeru (3.676 masl) and the tranquility of Lake Ranu Kumbolo (2.400 masl).<br \\/>\\r\\nAt last, this Bromo Tengger Semeru Ultra Run race will challenged you through 3 different distances, 160 km, 100 km and 50 km, in comfortable weather conditions and a very scenic route.<br \\/>\\r\\nMore information : http:\\/\\/bromotenggersemeru100ultra.com<\\/p>\\r\\n\\r\\n<p>&nbsp;<\\/p>\\r\\n"}},"uri_path":"bromo-tengger-semeru-ultratrail-run-2013","publish_date":"2014-01-29","id_status":"1","is_featured":"1","modify_date":"2015-01-15 10:35:39"}', '2015-01-15 03:35:39'),
(31, 1, 1, 'News', 'Edit News; ID: 1; Data: {"id_topic":"3","content_locale":{"1":{"title":"BRILLIANT RESULT AT END OF THE SEASON","teaser":"Erit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est Lorem ipsum dolor sit amet?","description":"<p>Erit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est Lorem ipsum dolor sit amet?<\\/p>\\r\\n\\r\\n<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hend<\\/p>\\r\\n\\r\\n<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hend<\\/p>\\r\\n\\r\\n<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hend<\\/p>\\r\\n"}},"uri_path":"brilliant-result-at-end-of-the-season","publish_date":"2014-01-22","id_status":"1","is_featured":"1","modify_date":"2015-01-15 10:35:55"}', '2015-01-15 03:35:56'),
(32, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-16 03:12:47'),
(33, 1, 1, 'Pages', 'Add New Pages; ID: 7; Data: {"page_name":"News & Event","parent_page":"0","page_type":"2","content_locale":{"1":{"title":"","teaser":"","description":""}},"ext_link":"","module":"news_event","uri_path":"news-event","publish_date":"2015-01-16","id_status":"1","position":"7","is_featured":0,"is_header":0,"is_footer":0}', '2015-01-16 03:13:44'),
(34, 1, 1, 'Pages', 'Add New Pages; ID: 8; Data: {"page_name":"Event","parent_page":"0","page_type":"2","content_locale":{"1":{"title":"","teaser":"","description":""}},"ext_link":"","module":"event","uri_path":"event","publish_date":"2015-01-16","id_status":"1","position":"8","is_featured":0,"is_header":0,"is_footer":0}', '2015-01-16 03:14:01'),
(35, 1, 1, 'Article', 'Edit Article; ID: 1; Data: {"id_category":["1","3"],"id_topic":"4","content_locale":{"1":{"title":"Kapan Sebaiknya Mulai Siapkan Biaya Pendidikan Anak?","teaser":"Biaya pendidkan akhir-akhir ini selalu ada di pikiran Anda. Putri tunggal Anda baru saja masuk preschool, tapi Anda ingin merencanakan jauh-jauh hari agar bisa","description":"<p>Tempora neque dolores itaque possimus, eveniet, omnis explicabo. Nihil architecto velit qui deserunt laborum quibusdam ipsam optio, Nam proident.Tempora neque dolores itaque possimus, eveniet, omnis explicabo. Nihil architecto velit qui deserunt laborum quibusdam ipsam optio, Nam proident.Tempora neque dolores itaque possimus, eveniet, omnis explicabo. Nihil architecto velit qui deserunt laborum quibusdam ipsam optio, Nam proident.Tempora neque dolores itaque possimus, eveniet, omnis explicabo. Nihil architecto velit qui deserunt laborum quibusdam ipsam optio, Nam proident.Tempora neque dolores itaque possimus, eveniet, omnis explicabo. Nihil architecto velit qui deserunt laborum quibusdam ipsam optio, Nam proident.Tempora neque dolores itaque possimus, eveniet, omnis explicabo. Nihil architecto velit qui deserunt laborum quibusdam ipsam optio, Nam proident.Tempora neque dolores itaque possimus, eveniet, omnis explicabo. Nihil architecto velit qui deserunt laborum quibusdam ipsam optio, Nam proident.<\\/p>\\r\\n"}},"uri_path":"kapan-sebaiknya-mulai-siapkan-biaya-pendidikan-anak","publish_date":"2015-01-09","id_status":"1","is_featured":"1","is_slideshow":"1","modify_date":"2015-01-16 13:21:50"}', '2015-01-16 06:21:51'),
(36, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-20 03:34:33'),
(37, 1, 1, 'Site Management', 'Edit Site Management; ID: 1; Data: {"site_name":"RENCANAKAN SEGERA!","site_url":"\\/","site_path":"\\/","site_address":"RENCANAKAN SEGERA!","setting":{"app_footer":"Disclaimer &amp; Ownership. Copyright \\u00a9 2015 AXA Mandiri Financial Services","app_title":"RENCANAKAN SEGERA!","email_contact":"smtp@submail.flipbox.co.id","email_contact_name":"Rencanakan Segera Admin","facebook_url":"#","ip_approved":"::1;127.0.0.1","mail_host":"mail.submail.flipbox.co.id","mail_pass":"mail27","mail_port":"25","mail_protocol":"smtp","mail_user":"smtp@submail.flipbox.co.id","maintenance_message":"<p>This site currently on maintenance, please check again later.<\\/p>\\r\\n","maintenance_mode":"0","twitter_url":"#","web_description":"This is website description","web_keywords":"","welcome_message":""},"is_default":1,"modify_date":"2015-01-20 10:36:16"}', '2015-01-20 03:36:17'),
(38, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 40; Data: {"menu":"Newsletter","parent_auth_menu":"0","file":"newsletter","position":"17","is_superadmin":0}', '2015-01-20 05:16:44'),
(39, 1, 1, 'Admin Group', 'Edit Admin Group Authentication; ID: 1; Data: {"auth_menu_group":["1","2","4","6","3","5","24","36","34","33","35","30","11","31","32","37","38","39","40"]}', '2015-01-20 05:17:16'),
(40, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-21 03:46:06'),
(41, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-21 10:21:50'),
(42, 1, 1, 'Discussion', 'Edit Discussion; ID: 3; Data: {"id_advisor":"1","id_topic":"4","questioner_name":"Ivan Lubis","questioner_email":"ihate.haters@yahoo.com","content_locale":{"1":{"title":"Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod","teaser":"Numquam dolorem corporis est ut est, ut velit sit vero.","description":"<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n\\r\\n<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n"}},"uri_path":"ullamco-adipisci-architecto-culpa-quibusdam-id-non-labore-odio-recusandae-omnis-magna-est-deleniti-ut-eligendi-quod","publish_date":"2015-01-14","id_status":"1","modify_date":"2015-01-21 17:22:22"}', '2015-01-21 10:22:22'),
(43, 1, 1, 'Discussion', 'Edit Discussion; ID: 3; Data: {"id_advisor":"1","id_topic":"4","questioner_name":"Ivan Lubis","questioner_email":"ihate.haters@yahoo.com","content_locale":{"1":{"title":"Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod","teaser":"Numquam dolorem corporis est ut est, ut velit sit vero.","description":"<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n\\r\\n<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n"}},"uri_path":"ullamco-adipisci-architecto-culpa-quibusdam-id-non-labore-odio-recusandae-omnis-magna-est-deleniti-ut-eligendi-quod","publish_date":"2015-01-14","id_status":"1","modify_date":"2015-01-21 17:29:51"}', '2015-01-21 10:29:52'),
(44, 1, 1, 'Discussion', 'Delete Questioner Image Discussion; ID: ;', '2015-01-21 10:33:23'),
(45, 1, 1, 'Discussion', 'Edit Discussion; ID: 3; Data: {"id_advisor":"1","id_topic":"4","questioner_name":"Ivan Lubis","questioner_email":"ihate.haters@yahoo.com","content_locale":{"1":{"title":"Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod","teaser":"Numquam dolorem corporis est ut est, ut velit sit vero.","description":"<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n\\r\\n<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n"}},"uri_path":"ullamco-adipisci-architecto-culpa-quibusdam-id-non-labore-odio-recusandae-omnis-magna-est-deleniti-ut-eligendi-quod","publish_date":"2015-01-14","id_status":"1","modify_date":"2015-01-21 17:34:30"}', '2015-01-21 10:34:31'),
(46, 1, 1, 'Discussion', 'Delete Questioner Image Discussion; ID: ;', '2015-01-21 10:34:39'),
(47, 1, 1, 'Discussion', 'Edit Discussion; ID: 3; Data: {"id_advisor":"1","id_topic":"4","questioner_name":"Ivan Lubis","questioner_email":"ihate.haters@yahoo.com","content_locale":{"1":{"title":"Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod","teaser":"Numquam dolorem corporis est ut est, ut velit sit vero.","description":"<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n\\r\\n<p>Ullamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quodUllamco adipisci architecto culpa quibusdam id non labore odio recusandae Omnis magna est deleniti ut eligendi quod<\\/p>\\r\\n"}},"uri_path":"ullamco-adipisci-architecto-culpa-quibusdam-id-non-labore-odio-recusandae-omnis-magna-est-deleniti-ut-eligendi-quod","publish_date":"2015-01-14","id_status":"1","modify_date":"2015-01-21 17:37:14"}', '2015-01-21 10:37:15'),
(48, 1, 1, 'Discussion', 'Delete Questioner Image Discussion; ID: 3;', '2015-01-21 10:37:23'),
(49, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-01-22 05:34:46'),
(50, 0, 0, 'Login', 'Login:failed; IP:::1; username:super_admin;', '2015-03-18 07:40:01'),
(51, 0, 0, 'Login', 'Login:failed; IP:::1; username:super_admin;', '2015-03-18 07:40:16'),
(52, 0, 0, 'Login', 'Login:failed; IP:::1; username:admin;', '2015-03-18 07:40:24'),
(53, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-03-18 07:40:33'),
(54, 1, 1, 'User Admin', 'Add User Admin; ID: ; Data: {"username":"admin","id_auth_group":"1","name":"Administrator","email":"ivan.z.lubis@gmail.com","alamat":"","phone":"","status":1,"is_superadmin":1,"modify_date":"2015-03-18 14:41:48"}', '2015-03-18 07:41:52'),
(55, 1, 1, 'Admin Group', 'Edit Admin Group Authentication; ID: 1; Data: {"auth_menu_group":["1","2","4","6","3","5","24","36"]}', '2015-03-18 07:44:03'),
(56, 1, 1, 'Site Management', 'Edit Site Management; ID: 1; Data: {"site_name":"BIGTV HD PREPAID","site_url":"\\/","site_path":"\\/","site_address":"BIGTV HD PREPAID","setting":{"app_footer":"\\u00a9 2014 PT. Indonesia Media Televisi. All Right Reserved.","app_title":"BIGTV HD PREPAID","email_contact":"smtp@test.com","email_contact_name":"BIGTV HD Admin","facebook_url":"#","ip_approved":"::1;127.0.0.1","mail_host":"mail.test.com","mail_pass":"mail27","mail_port":"25","mail_protocol":"smtp","mail_user":"smtp@test.com","maintenance_message":"<p>This site currently on maintenance, please check again later.<\\/p>\\r\\n","maintenance_mode":"0","twitter_url":"#","web_description":"This is website description","web_keywords":"","welcome_message":""},"is_default":1,"modify_date":"2015-03-18 14:46:08"}', '2015-03-18 07:46:09'),
(57, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 41; Data: {"menu":"Slideshow","parent_auth_menu":"0","file":"slideshow","position":"14","is_superadmin":0}', '2015-03-18 08:07:28'),
(58, 1, 1, 'Admin Group', 'Edit Admin Group Authentication; ID: 1; Data: {"auth_menu_group":["1","2","4","6","3","5","24","36","41"]}', '2015-03-18 08:07:49'),
(59, 1, 1, 'Slideshow', 'Add New Slideshow; ID: 1; Data: {"title":"Qui provident cupidatat soluta voluptas maiores eaque totam optio","caption":"Elit, doloremque eum unde consequuntur dolores quae sint consequat. Pariatur? Eos est, optio, eu rem quod consequatur? Asperiores neque.","position":"Veniam aliquip eos ad perferendis"}', '2015-03-18 08:17:30'),
(60, 1, 1, 'Slideshow', 'Edit Slideshow; ID: 1; Data: {"title":"Qui provident cupidatat soluta voluptas maiores eaque totam optio","caption":"Elit, doloremque eum unde consequuntur dolores quae sint consequat. Pariatur? Eos est, optio, eu rem quod consequatur? Asperiores neque.","position":"0","modify_date":"2015-03-18 15:18:25"}', '2015-03-18 08:18:25'),
(61, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 42; Data: {"menu":"Product","parent_auth_menu":"0","file":"#","position":"15","is_superadmin":0}', '2015-03-18 09:48:51'),
(62, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 43; Data: {"menu":"Product Category","parent_auth_menu":"42","file":"category","position":"16","is_superadmin":0}', '2015-03-18 09:49:17'),
(63, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 44; Data: {"menu":"Product","parent_auth_menu":"42","file":"product","position":"17","is_superadmin":0}', '2015-03-18 09:49:34'),
(64, 1, 1, 'Admin Group', 'Edit Admin Group Authentication; ID: 1; Data: {"auth_menu_group":["1","2","4","6","3","5","24","36","41","42","43","44"]}', '2015-03-18 09:50:14'),
(65, 1, 1, 'Category', 'Add New Category; ID: 1; Data: {"category":"Paket Hemat","uri_path":"paket-hemat"}', '2015-03-18 09:54:06'),
(66, 1, 1, 'Category', 'Add New Category; ID: 2; Data: {"category":"Aksesoris","uri_path":"aksesoris"}', '2015-03-18 09:54:23'),
(67, 1, 1, 'Category', 'Add New Category; ID: 3; Data: {"category":"Service","uri_path":"service"}', '2015-03-18 09:56:46'),
(68, 1, 1, 'Product', 'Add New Product; ID: 1; Data: {"id_category":"1","name":"Harriet Hornea","sku":"Hic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborum","price":"100000","discount_price":"","weight":"1.22","teaser":"Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.","description":"<p>Hic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborum<\\/p>\\r\\n","spesification":"<p>Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.<\\/p>\\r\\n","uri_path":"harriet-hornea","publish_date":"2015-03-18","id_status":"1","is_featured":"1"}', '2015-03-18 10:48:18'),
(69, 1, 1, 'Product', 'Edit Product; ID: 1; Data: {"id_category":"1","name":"Harriet Hornea","sku":"HH","price":"100000.00","discount_price":"0.00","weight":"1.22","teaser":"Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.","description":"<p>Hic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborum<\\/p>\\r\\n","spesification":"<p>Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.<\\/p>\\r\\n","uri_path":"harriet-hornea","publish_date":"2015-03-18","id_status":"1","is_featured":"1","modify_date":"2015-03-18 17:50:52"}', '2015-03-18 10:50:53'),
(70, 1, 1, 'Product', 'Edit Product; ID: 1; Data: {"id_category":"1","name":"Harriet Hornea","sku":"HH","price":"100000.00","discount_price":"0.00","weight":"1.22","teaser":"Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.","description":"<p>Hic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborumHic ipsum consequat Enim sint totam minima et maiores perspiciatis repudiandae quo eum rem laborum<\\/p>\\r\\n","spesification":"<p>Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.Delectus, dicta molestiae eos doloribus commodo nihil sint laboris aliquam eveniet, quaerat itaque irure.<\\/p>\\r\\n","uri_path":"harriet-hornea","publish_date":"2015-03-18","id_status":"1","is_featured":"1","modify_date":"2015-03-18 17:51:27"}', '2015-03-18 10:51:27'),
(71, 1, 1, 'Login', 'Login:succeed; IP:172.20.6.98; username:admin;', '2015-03-19 04:01:16'),
(72, 1, 1, 'Login', 'Login:succeed; IP:172.20.6.98; username:admin;', '2015-03-19 13:55:35'),
(73, 1, 1, 'Login', 'Login:succeed; IP:172.20.6.98; username:admin;', '2015-03-20 03:10:20'),
(74, 1, 1, 'Login', 'Login:succeed; IP:172.20.6.98; username:admin;', '2015-03-20 06:47:14'),
(75, 0, 0, 'Login', 'Login:failed; IP:172.20.6.98; username:admin;', '2015-03-23 07:54:21'),
(76, 0, 0, 'Login', 'Login:failed; IP:172.20.6.98; username:admin;', '2015-03-23 07:54:32'),
(77, 1, 1, 'Login', 'Login:succeed; IP:172.20.6.98; username:admin;', '2015-03-23 07:54:52'),
(78, 1, 1, 'Login', 'Login:succeed; IP:172.20.6.98; username:admin;', '2015-03-25 06:46:06'),
(79, 1, 1, 'Login', 'Login:succeed; IP:172.20.6.98; username:admin;', '2015-03-25 07:00:00'),
(80, 1, 1, 'Back End Menu', 'Add Back End Menu; ID: 45; Data: {"menu":"Transaction","parent_auth_menu":"0","file":"transaction","position":"18","is_superadmin":0}', '2015-03-25 07:00:26'),
(81, 1, 1, 'Admin Group', 'Edit Admin Group Authentication; ID: 1; Data: {"auth_menu_group":["1","2","4","6","3","5","24","36","41","42","43","44","45"]}', '2015-03-25 07:00:42'),
(82, 1, 1, 'Product', 'Delete Primary Image Product; ID: 1;', '2015-03-25 08:43:36'),
(83, 1, 1, 'Product', 'Edit Product; ID: 1; Data: {"id_category":"1","name":"Promo dekoder Samsung Prepaid HD","sku":"BHD100","price":"1100000","discount_price":"0.00","weight":"1.2200","teaser":"2 bulan all channels, \\n10 bulan paket Big EZ Action, \\n10 bulan paket Big Ultimate Sports","description":"<ul>\\n\\t<li>\\n\\t<p>2 bulan all channels<\\/p>\\n\\t<\\/li>\\n\\t<li>\\n\\t<p>10 bulan paket Big EZ Action<\\/p>\\n\\t<\\/li>\\n\\t<li>\\n\\t<p>10 bulan paket Big Ultimate Sports<\\/p>\\n\\t<\\/li>\\n<\\/ul>\\n","spesification":"","uri_path":"bhd100","publish_date":"2015-03-18","id_status":"1","is_featured":"1","modify_date":"2015-03-25 15:44:50"}', '2015-03-25 08:44:50'),
(84, 1, 1, 'Product', 'Add New Product; ID: 2; Data: {"id_category":"1","name":"Promo dekoder Samsung Prepaid HD","sku":"BHD150","price":"770000","discount_price":"","weight":"1","teaser":"1 bulan all channels di bulan ke-1, \\nPaket Big HBO di bulan ke-2, \\n1 bulan all channels di bulan ke-2, \\nPaket Big Kids di bulan ke-4","description":"<ul>\\n\\t<li>\\n\\t<p>1 bulan all channels di bulan ke-1<\\/p>\\n\\t<\\/li>\\n\\t<li>\\n\\t<p>Paket Big HBO di bulan ke-2<\\/p>\\n\\t<\\/li>\\n\\t<li>\\n\\t<p>1 bulan all channels di bulan ke-2<\\/p>\\n\\t<\\/li>\\n\\t<li>\\n\\t<p>Paket Big Kids di bulan ke-4<\\/p>\\n\\t<\\/li>\\n<\\/ul>\\n","spesification":"","uri_path":"promo-dekoder-samsung-prepaid-hd","publish_date":"2015-03-25","id_status":"1"}', '2015-03-25 08:47:11'),
(85, 1, 1, 'Product', 'Add New Product; ID: 3; Data: {"id_category":"1","name":"Promo ISL","sku":"BHD152","price":"1031800","discount_price":"","weight":"1","teaser":"2 bulan all channels, \\n1 season ISL","description":"<ul>\\n\\t<li>\\n\\t<p>2 bulan all channels<\\/p>\\n\\t<\\/li>\\n\\t<li>\\n\\t<p>1 season ISL<\\/p>\\n\\t<\\/li>\\n<\\/ul>\\n","spesification":"","uri_path":"promo-isl","publish_date":"2015-03-25","id_status":"1"}', '2015-03-25 08:48:11'),
(86, 1, 1, 'Product', 'Add New Product; ID: 4; Data: {"id_category":"2","name":"ODU Set","sku":"ODU","price":"275000","discount_price":"","weight":"1","teaser":"ODU Set","description":"<p>ODU Set<\\/p>\\n","spesification":"","uri_path":"odu-set","publish_date":"2015-03-25","id_status":"1"}', '2015-03-25 08:49:07'),
(87, 1, 1, 'Product', 'Add New Product; ID: 5; Data: {"id_category":"3","name":"Jasa instalasi","sku":"JI","price":"100000","discount_price":"","weight":"0","teaser":"maksimum 25 km dari kantor cabang BIGTV terdekat","description":"<p>Jasa instalasi (maksimum 25 km dari kantor cabang BIGTV terdekat<\\/p>\\n","spesification":"","uri_path":"jasa-instalasi","publish_date":"2015-03-25","id_status":"1"}', '2015-03-25 08:51:31'),
(88, 1, 1, 'Product', 'Add New Product; ID: 6; Data: {"id_category":"3","name":"Jasa Repointing","sku":"JR","price":"60000","discount_price":"","weight":"0","teaser":"maksimum 25 km dari kantor cabang BIGTV terdekat","description":"<p>Jasa <em>repointing <\\/em>(maksimum 25 km dari kantor cabang BIGTV terdekat)<\\/p>\\n","spesification":"","uri_path":"jasa-repointing","publish_date":"2015-03-25","id_status":"1"}', '2015-03-25 08:52:26'),
(89, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-03-30 05:12:04'),
(90, 1, 1, 'Slideshow', 'Add New Slideshow; ID: 4; Data: {"title":"Facere sint accusamus quaerat minima incididunt esse ut do consequuntur reiciendis rerum iste laboriosam eos omnis ea voluptas","caption":"Qui reprehenderit at voluptatem in voluptas maxime alias elit, anim hic aut dolore quod neque proident.","position":"6"}', '2015-03-30 05:15:22'),
(91, 1, 1, 'Slideshow', 'Add New Slideshow; ID: 6; Data: {"title":"Molestiae autem corrupti ut amet in occaecat deserunt eum a qui","caption":"Dolore assumenda pariatur. Quod sed ut mollitia dolore eos, commodo aliquip deserunt suscipit veniam.","position":"Dolore proident aute quis vel deserunt id ut qui consectetur id pariatur Saepe porro facere doloremque duis optio"}', '2015-03-30 05:16:50'),
(92, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-03-30 10:20:12'),
(93, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-03-31 03:21:35'),
(94, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-03-31 11:05:32'),
(95, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 16:40:25'),
(96, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 16:41:35'),
(97, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 16:44:31'),
(98, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 16:46:57'),
(99, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 16:47:44'),
(100, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 17:08:19'),
(101, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 17:17:27'),
(102, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 17:18:05'),
(103, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-04 17:26:03'),
(104, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-07 04:34:49'),
(106, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-07 06:49:56'),
(107, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-07 13:03:26'),
(108, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-14 07:50:17'),
(109, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-14 07:57:34');
INSERT INTO `fat_logs` (`id_logs`, `id_user`, `id_group`, `action`, `desc`, `create_date`) VALUES
(110, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-23 04:57:51'),
(111, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-23 04:58:04'),
(112, 1, 1, 'Profile', 'Change Password Profile; ID: 1;', '2015-04-23 07:41:46'),
(113, 1, 1, 'Profile', 'Edit Profile; ID: 1; Data: {"name":"Administrator","email":"ivan.z.lubis@gmail.com","address":"","phone":""}', '2015-04-23 07:54:59'),
(114, 1, 1, 'Profile', 'Edit Profile; ID: 1; Data: {"name":"Administrator","email":"ivan.z.lubis@gmail.com","address":"","phone":""}', '2015-04-23 08:08:31'),
(115, 1, 1, 'Profile', 'Edit Profile; ID: 1; Data: {"name":"Administrator","email":"ivan.z.lubis@gmail.com","address":"","phone":""}', '2015-04-23 08:09:02'),
(116, 1, 1, 'Profile', 'Edit Profile; ID: 1; Data: {"name":"Administratora","email":"ivan.z.lubis@gmail.com","address":"","phone":""}', '2015-04-23 08:10:03'),
(117, 1, 1, 'Profile', 'Edit Profile; ID: 1; Data: {"name":"Administrator","email":"ivan.z.lubis@gmail.com","address":"","phone":""}', '2015-04-23 08:10:07'),
(118, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-24 04:38:38'),
(119, 0, 0, 'Login', 'Login:failed; IP:::1; username:asdad;', '2015-04-24 04:39:46'),
(120, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-24 04:44:16'),
(121, 1, 1, 'Login', 'Login:succeed; IP:::1; username:admin;', '2015-04-24 07:02:22'),
(122, 1, 1, 'User Admin', 'Edit User Admin; ID: 1; Data: {"username":"admin","id_auth_group":"1","name":"Administrator","email":"ivan.z.lubis@gmail.com","alamat":"","phone":"","status":1,"is_superadmin":1,"modify_date":"2015-04-24 10:48:48"}', '2015-04-24 08:48:49'),
(123, 1, 1, 'User Admin', 'Edit User Admin; ID: 1; Data: {"username":"admina","id_auth_group":"1","name":"Administrator","email":"ivan.z.lubis@gmail.com","alamat":"","phone":"","status":1,"is_superadmin":1,"modify_date":"2015-04-24 10:48:58"}', '2015-04-24 08:48:58'),
(124, 1, 1, 'User Admin', 'Edit User Admin; ID: 1; Data: {"username":"admin","id_auth_group":"1","name":"Administrator","email":"ivan.z.lubis@gmail.com","alamat":"","phone":"","status":1,"is_superadmin":1,"modify_date":"2015-04-24 10:49:54"}', '2015-04-24 08:49:54'),
(125, 1, 1, 'User Admin', 'Edit User Admin; ID: 1; Data: {"username":"admin","id_auth_group":"1","name":"Administrator","email":"ivan.z.lubis@gmail.com","alamat":"","phone":"","status":1,"is_superadmin":1,"modify_date":"2015-04-24 10:50:13"}', '2015-04-24 08:50:13'),
(126, 1, 1, 'User Admin', 'Edit User Admin; ID: 1; Data: {"username":"admin","id_auth_group":"1","name":"Administrator","email":"ivan.z.lubis@gmail.com","alamat":"","phone":"","status":1,"is_superadmin":1,"modify_date":"2015-04-24 10:50:49"}', '2015-04-24 08:50:50'),
(127, 1, 1, 'User Admin', 'Edit User Admin; ID: 1; Data: {"username":"admin","id_auth_group":"1","name":"Administrator","email":"ivan.z.lubis@gmail.com","alamat":"","phone":"","status":1,"is_superadmin":1,"modify_date":"2015-04-24 10:51:23"}', '2015-04-24 08:51:24'),
(128, 1, 1, 'User Admin', 'Add User Admin; ID: 2; Data: {"username":"ivanlubis","id_auth_group":"1","name":"Ivan Lubis","email":"ihate.haters@yahoo.com","alamat":"","phone":"","status":1,"is_superadmin":1}', '2015-04-24 09:10:00'),
(129, 1, 1, 'User Admin', 'Add User Admin; ID: 3; Data: {"username":"losapucepa","id_auth_group":"2","name":"Rama Key","email":"lymuzak@yahoo.com","alamat":"In optio, suscipit Nam omnis quia excepturi dicta aliqua. Consequuntur iure fugit, at veniam, voluptas enim ea soluta officia.","phone":"081311124565","status":1,"is_superadmin":0}', '2015-04-24 10:47:37'),
(130, 1, 1, 'User Admin', 'Add User Admin; ID: 4; Data: {"username":"zorog","id_auth_group":"2","name":"Judah Shaffer","email":"hapo@hotmail.com","alamat":"Incididunt suscipit consequatur, tempora nihil ullam qui dolor fugiat consequatur, qui.","phone":"081311124565","status":1,"is_superadmin":1}', '2015-04-24 10:49:52'),
(131, 1, 1, 'Delete User Admin', 'Delete User Admin; ID: 3;', '2015-04-24 10:51:15'),
(132, 1, 1, 'Admin Group', 'Edit Admin Group; ID: 1; Data: {"auth_group":"Administratora","is_superadmin":1}', '2015-04-24 11:46:28'),
(133, 1, 1, 'Admin Group', 'Edit Admin Group; ID: 1; Data: {"auth_group":"Administrator","is_superadmin":1}', '2015-04-24 11:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `fat_pages`
--

DROP TABLE IF EXISTS `fat_pages`;
CREATE TABLE IF NOT EXISTS `fat_pages` (
`id_page` int(11) NOT NULL,
  `parent_page` int(11) NOT NULL,
  `page_name` varchar(200) COLLATE utf8_bin NOT NULL,
  `page_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=static pages; 2=module; 3=external link',
  `uri_path` varchar(200) COLLATE utf8_bin NOT NULL,
  `alias` varchar(200) COLLATE utf8_bin NOT NULL,
  `module` varchar(150) COLLATE utf8_bin NOT NULL,
  `ext_link` varchar(220) COLLATE utf8_bin DEFAULT NULL,
  `primary_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `thumbnail_image` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `more_link` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `position` smallint(6) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_header` tinyint(1) NOT NULL,
  `is_footer` tinyint(1) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `id_auth_user` int(11) NOT NULL,
  `modify_date` datetime DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_pages`
--

TRUNCATE TABLE `fat_pages`;
--
-- Dumping data for table `fat_pages`
--

INSERT INTO `fat_pages` (`id_page`, `parent_page`, `page_name`, `page_type`, `uri_path`, `alias`, `module`, `ext_link`, `primary_image`, `thumbnail_image`, `publish_date`, `more_link`, `position`, `id_status`, `is_featured`, `is_header`, `is_footer`, `is_delete`, `id_auth_user`, `modify_date`, `create_date`) VALUES
(1, 0, 'Tentang Rencanakan Segera', 1, 'about-us', '', '', NULL, NULL, NULL, '2015-01-12', NULL, 1, 1, 0, 0, 1, 0, 0, '2015-01-12 07:12:23', '2015-01-12 05:57:58'),
(2, 0, 'Privacy', 1, 'privacy', '', '', NULL, NULL, NULL, '2015-01-12', NULL, 2, 1, 0, 0, 1, 0, 0, NULL, '2015-01-12 05:59:12'),
(3, 0, 'Axa Mandiri', 3, '', '', '', 'http://axa-mandiri.com', NULL, NULL, '2015-01-12', NULL, 3, 1, 0, 0, 1, 0, 0, '2015-01-12 07:01:44', '2015-01-12 06:01:32'),
(4, 0, 'Article', 2, '', '', 'article', NULL, NULL, NULL, '2015-01-12', NULL, 4, 1, 0, 0, 0, 0, 0, NULL, '2015-01-12 09:42:21'),
(5, 0, 'Discussion', 2, '', '', 'discussion', NULL, NULL, NULL, '2015-01-14', NULL, 5, 1, 0, 0, 0, 0, 0, NULL, '2015-01-14 05:15:10'),
(6, 0, 'News', 2, '', '', 'news', NULL, NULL, NULL, '2015-01-14', NULL, 6, 1, 0, 0, 0, 0, 0, NULL, '2015-01-14 11:36:17'),
(7, 0, 'News & Event', 2, '', '', 'news_event', NULL, NULL, NULL, '2015-01-16', NULL, 7, 1, 0, 0, 0, 0, 0, NULL, '2015-01-16 03:13:44'),
(8, 0, 'Event', 2, '', '', 'event', NULL, NULL, NULL, '2015-01-16', NULL, 8, 1, 0, 0, 0, 0, 0, NULL, '2015-01-16 03:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `fat_pages_detail`
--

DROP TABLE IF EXISTS `fat_pages_detail`;
CREATE TABLE IF NOT EXISTS `fat_pages_detail` (
`id_page_detail` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `teaser` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_pages_detail`
--

TRUNCATE TABLE `fat_pages_detail`;
--
-- Dumping data for table `fat_pages_detail`
--

INSERT INTO `fat_pages_detail` (`id_page_detail`, `id_page`, `id_localization`, `title`, `teaser`, `description`) VALUES
(2, 2, 1, 'Privacy', 'Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.', '<p>Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.Officiis aliquam quis enim corrupti, assumenda est nisi animi, velit et aliquid et.</p>\r\n'),
(4, 1, 1, 'Tentang Rencanakan Segera', 'Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.', '<p>Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.Quidem cillum est eveniet, enim et dolore consequatur amet, distinctio. In pariatur. Officia occaecat consequatur.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `fat_pages_image`
--

DROP TABLE IF EXISTS `fat_pages_image`;
CREATE TABLE IF NOT EXISTS `fat_pages_image` (
`id_page_image` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8_bin NOT NULL,
  `position` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_pages_image`
--

TRUNCATE TABLE `fat_pages_image`;
-- --------------------------------------------------------

--
-- Table structure for table `fat_pages_image_caption`
--

DROP TABLE IF EXISTS `fat_pages_image_caption`;
CREATE TABLE IF NOT EXISTS `fat_pages_image_caption` (
`id_page_image_caption` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `id_page_image` int(11) NOT NULL,
  `id_localization` int(11) NOT NULL,
  `caption` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_pages_image_caption`
--

TRUNCATE TABLE `fat_pages_image_caption`;
-- --------------------------------------------------------

--
-- Table structure for table `fat_sessions`
--

DROP TABLE IF EXISTS `fat_sessions`;
CREATE TABLE IF NOT EXISTS `fat_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `fat_sessions`
--

TRUNCATE TABLE `fat_sessions`;
--
-- Dumping data for table `fat_sessions`
--

INSERT INTO `fat_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0178996e032a02526632ea73485ccbd29b352acf', '::1', 1429769084, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736393038343b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('038b67686e9a1f4de0c76e606b1047ed49429d50', '::1', 1428987136, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938373133353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('05175d805e67ee8f6a8d5730c7e62e3d03b929f5', '::1', 1428987446, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938373434363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('07b7a31affdb084bbae9c41029aefa49c0dcc186', '::1', 1429776647, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393737363530363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('08ca41c68d3dff025c6e6ce2e7fa9b5d1097c698', '::1', 1429872681, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837323432383b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('0940135ea996565ef321aa990888c40a96b92faf', '::1', 1429784632, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738343633323b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('0fd8693da8f8ba9e2deba0415cc9620b99e7b073', '::1', 1429872072, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837323037323b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('178f2776e92ac057c694a797a24ecb9e57491f62', '::1', 1429850386, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393835303331393b746d705f6c6f67696e5f72656469726563747c733a32313a22687474703a2f2f6c6f63616c686f73742f636d732f223b666c6173685f6d6573736167657c733a3234313a223c64697620636c6173733d22616c65727420616c6572742d64616e67657220616c6572742d6469736d69737369626c652220726f6c653d22616c657274223e3c627574746f6e20747970653d22627574746f6e2220636c6173733d22636c6f73652220646174612d6469736d6973733d22616c6572742220617269612d6c6162656c3d22436c6f7365223e3c7370616e20617269612d68696464656e3d2274727565223e2674696d65733b3c2f7370616e3e3c2f627574746f6e3e557365726e616d652f50617373776f72642069736e27742076616c69642e20506c656173652074727920616761696e2e3c2f6469763e223b5f5f63695f766172737c613a313a7b733a31333a22666c6173685f6d657373616765223b733a333a226f6c64223b7d),
('19687a8f98d703e652c0f288c2508d4ccc7c9ae2', '::1', 1428989774, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938393737333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('19a55179f4ca038624fc34bbfa97259418c906dd', '::1', 1429788347, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738383334373b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('1bb4c60382dee0b0030204ba8ff81736dd8987b5', '::1', 1429774906, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393737343539383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d737563636573735f6d73677c733a33363a22596f75722050617373776f726420686173206265656e206368616e6765642e3c62722f3e223b5f5f63695f766172737c613a313a7b733a31313a22737563636573735f6d7367223b733a333a226e6577223b7d),
('1bcaa6f5683e797cede1de6aa9c7408de3a1e272', '::1', 1428405996, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430353939363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('1c54e677060b6ca24a12eeb0915c8b837101c005', '::1', 1429860244, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836303234343b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('20357f4da42d7428ff8fe19c2c6ecd26c1d01850', '::1', 1429860646, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836303634353b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('203c9ee3e2d1df0b7c40d5aa112989b0a7d9605d', '::1', 1429767030, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736373033303b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('209e424eecee6ff40b484b17ed4fc90c6f5db1b2', '::1', 1428406558, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430363535383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('218e04cceb154452c50abd33da1995816b5c289a', '::1', 1429777113, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393737373131333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('266f818ed395b3ff2089024cdfc20d57e1298b80', '::1', 1428405688, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430353638383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('26a51a844ea507a2d409ba1de25abe2adadae7ac', '::1', 1428404885, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430343838353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('26bb323ab4dd028123c79efe2eefcc748d43b352', '::1', 1429865771, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836353737313b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('286a6f0e49482c8130cbbf5eb1f5ede5285ad8de', '::1', 1428403086, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430333038353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('2878a3b5c283f4afc8ef96f6da95bd8fd242b9d3', '::1', 1429871623, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837313632323b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('32a3e1401ea3197c34a729256f0c4515802d5e9d', '::1', 1429782652, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738323635313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('37bc7c0c1fa8ca90949369c1d811b8ab6815ba86', '::1', 1429010067, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393031303036373b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('3bbc0d447b2f1240180c7f8289fd51db269c6d50', '::1', 1429787646, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738373634363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('3bda818df2da3edbf07238c2e3bf0d17144f93de', '::1', 1428409740, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430393734303b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('3c8596ee1729721e516748ec9be710a4b748a9d6', '::1', 1428985651, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938353635313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('3d4d68faddfbc7b1bbe53b29e1e184f2e58dffe8', '::1', 1429009743, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393030393734333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('406f105ea29e8404415a441dd373667ad89de955', '::1', 1428404515, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430343531343b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('4078c40d66034f180c37d28f2fd77d3522ba63ac', '::1', 1428983598, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938333539383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('423a2b184038eba025e543c38b643e1d9c8a3a52', '::1', 1428986305, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938363330353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('43356541c836beee52217a6fcbf6a1d5d747803a', '::1', 1429861921, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836313932313b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('4344aaeb8decfb5945acd548833a219e2640533f', '::1', 1429782171, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738323137313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('4656e5545d39064699b3a4444ae3d9d6d7a98a67', '::1', 1428991203, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383939313230333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('46c996f1d6ac4f82cba96fd75186cbcd7c7b6e4b', '::1', 1429863500, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836333530303b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('4888fd784606790c5336a972871ebabbea24f986', '::1', 1429781077, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738313037363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('4ce47bbc2641d5ad6e8c2dcf02018fa7aad3cdaa', '::1', 1428998254, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383939383233333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('4eb5f0e42479510ab94d729793ad72ed187b51a2', '::1', 1429009301, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393030393330303b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('50f3e3f36aee84a6056b604b3895f2b20b380a3b', '::1', 1429867217, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836373231373b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('51b0b3ab55d959521cd0048f58511630d9574bbe', '::1', 1429781858, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738313835383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('58bfcf99a382064f3c5aaeb0cf6b929f58b2cf0b', '::1', 1428984415, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938343431353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('59c66e4d141c18c144627706f2a2a42476ec9aac', '::1', 1428411806, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383431313739393b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b733a33323a223662646332303934396336353230363565353136393032633938353462373965223b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('5ac24b7cf9adf04fa10f7390f5839d2217a13f1d', '::1', 1429866072, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836363037323b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('5cc40af7cae0f74e79b58b4e6c4bcedb05ba3c4e', '::1', 1428989397, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938393339373b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('5ec3f64f7f92966017eb4685c1fefc10ebd5b186', '::1', 1429768022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736383032313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('619acf3bfc02367cb147210ef6e361465498b1ad', '::1', 1429000827, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393030303832363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('6736785f39a46df180ade56a6ba5f17bb62c15e8', '::1', 1428410285, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383431303238353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('6e8c265cbce11de31d6def7ca85b0a612ebb4098', '::1', 1429784979, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738343937393b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('71fd580002503b56c4d3aa65df922158cdd9892c', '::1', 1429858942, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393835383933353b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('72441db7a3372609be59da6cd7c567fef50a22cf', '::1', 1428983899, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938333839393b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('74723bd2ba248b336ab54d1000b29d90c7c2936d', '::1', 1428983154, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938333135343b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('7f697bb2adac8a9d23f62e3f94b71fa92cd9f637', '::1', 1429788832, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738383833323b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('82a72834ace60806ba669b96eaab3c4a06024548', '::1', 1429007223, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393030373232333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('82a98563543d23cdbabeda18a6426b398a3a02fe', '::1', 1429766681, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736363638313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d);
INSERT INTO `fat_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('84b30c95a9dc45cfbf36ee181d9c4f413a9203fe', '::1', 1429787155, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738373135353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('87bd6e34d1dd50d414f8b84e2d292e450547017d', '::1', 1429777649, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393737373634393b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('8bff465c60a6555db6f009fac5a9ee6cee60be80', '::1', 1429850310, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393835303331303b746d705f6c6f67696e5f72656469726563747c733a32313a22687474703a2f2f6c6f63616c686f73742f636d732f223b),
('8c6f7d7594afd1eeda7565ec3929d2479eeb1aa7', '::1', 1429781381, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738313338313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('8d08fa308f61b8c5558ec855085fd1d5f6c175c1', '::1', 1428411468, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383431313436383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('8d1b2561d4b19de30276ab676220bceeb573fa80', '::1', 1429850656, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393835303634393b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('8d87f5a34b61f2ce6176e1e37cc57a4e210fb4ec', '::1', 1429865485, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836353430363b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('8fb4031636b81dfb177f79cb56841c8b7c8d45e8', '::1', 1429873655, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837333635353b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('9119a51611847b8ba43dce07192f38fe92ffd77e', '::1', 1429859328, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393835393332383b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('93bc2cc507b87eb85f26755a6b9c3e7b647ae6a0', '::1', 1429782999, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738323939393b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('9739c35045a5a34986986b2b03abaa3d6368e425', '::1', 1428410939, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383431303933393b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('974209ad8fafebeb749151a5ef130662b4227834', '::1', 1429785538, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738353533383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('a33dc3bcad0385195915cd59fba813384f51efaa', '::1', 1429786583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738363538333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('a6534659f0c53bc985b21a4f22f9fe5529d11f88', '::1', 1429767619, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736373631393b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('a75f66cb4cbeddb383930f1efb6bb11d4546b9a7', '::1', 1428982469, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938323435333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b733a33323a223939343039376363313362666634653530353239663062326135643736373565223b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('a914448472d97fa579704054199ca12a957b00ee', '::1', 1429773646, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393737333634363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('a9ac826794028033540c299874e953dbc231b1c6', '::1', 1429851108, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393835313130383b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('ab7084f48d3be30161476cd15bc7827876e00d6b', '::1', 1429866602, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836363338373b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('b09385200ead8365d83cb072875b20580720f943', '::1', 1428982830, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938323832333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('b2e1f89eed6a591a71d57379eb857fed2001b470', '::1', 1429765427, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736353432363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('b40b6ee38786c2b14673ffc569d6dbf1d0eb1f0a', '::1', 1429786005, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738363030353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('bafde452651f8f78326184392d71a60f203cf75d', '::1', 1428404207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430343230373b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('c46d8521aa941397325ecc1242c5198ba11c25a6', '::1', 1429775872, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393737353539333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('c4a55de76f9f84a600148b1064fded5c815e0a21', '::1', 1429873108, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837333130383b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('c4e54cb824965d7b44b49e9275975539428cb031', '::1', 1429875998, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837353932303b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('c5758bed620703adc11133cad585491f0d907989', '::1', 1429788033, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738383033333b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('c980cd06c853ee338ab250ad475b3465094758e8', '::1', 1428998715, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383939383731353b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('cf420ed9288bb3b2654879e6601d770e8c20fe19', '::1', 1429784204, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738343230343b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('cf6755f40d0fae5848bf0e708afc5d3a18de33ed', '::1', 1429874292, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837343239323b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('dabe60e3f5afe9e01ff5e82bad42057ac22b8065', '::1', 1428407407, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383430373430363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('dce58686c1709caa943426e764896463325a1dc0', '::1', 1429768678, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736383637383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('dd94353b0e0436c64180984e0e82cd401b1db8df', '::1', 1429008501, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393030383530313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('e158252ea692300213b0fbb70e52d5e941b8ed24', '::1', 1429874594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837343539343b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('e53684d63d32e599ee82d826a6aa096e105d6386', '::1', 1429765084, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736353037313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('e547f809a63f4c64032932a523fd6cb826749355', '::1', 1429875222, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393837353232323b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('ee5d72093fee39a3123f151a073ecb1086d02b48', '::1', 1429766257, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393736363235373b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('f527991b099990dba245288086bcacd74e696ebf', '::1', 1428984821, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938343832313b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('f60b7b439d610518016c9e7d8129e1caada21cf5', '::1', 1429859671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393835393637313b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('f76d0662f940b409fb3d49be8097de94c4cfe379', '::1', 1429865395, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393836353039383b746d705f6c6f67696e5f72656469726563747c733a32363a22687474703a2f2f6c6f63616c686f73742f434d532f61646d696e223b41444d5f534553537c613a383a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('f788f8fd5a0382d0e89f47d74745c8222973bee8', '::1', 1429003154, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393030333135343b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('f9740fde3893115a106a2f667516bf873ecfa3f6', '::1', 1428997817, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383939373830323b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('fa8381db50948d7e62171ff16122cde73bb1ecfb', '::1', 1429783324, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393738333332343b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('fc64a572237cd9da47d9143f9a1b4295878f84aa', '::1', 1429774906, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393737343930363b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d737563636573735f6d73677c733a33363a22596f75722050617373776f726420686173206265656e206368616e6765642e3c62722f3e223b5f5f63695f766172737c613a313a7b733a31313a22737563636573735f6d7367223b733a333a226f6c64223b7d),
('fd3b0fbb4dcece7c633ea2091aa1cc07959db669', '::1', 1428985268, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432383938353236383b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d),
('ff133c1b979d29b0d9452a96539df5b88f9760a1', '::1', 1429777974, 0x5f5f63695f6c6173745f726567656e65726174657c693a313432393737373937343b41444d5f534553537c613a393a7b733a31303a2261646d696e5f6e616d65223b733a31333a2241646d696e6973747261746f72223b733a31393a2261646d696e5f69645f617574685f67726f7570223b733a313a2231223b733a31383a2261646d696e5f69645f617574685f75736572223b733a33333a225f6334636134323338613062393233383230646363353039613666373538343962223b733a31313a2261646d696e5f656d61696c223b733a32323a226976616e2e7a2e6c7562697340676d61696c2e636f6d223b733a31303a2261646d696e5f74797065223b733a31303a22737570657261646d696e223b733a383a2261646d696e5f6970223b733a333a223a3a31223b733a393a2261646d696e5f75726c223b733a32313a22687474703a2f2f6c6f63616c686f73742f434d532f223b733a31313a2261646d696e5f746f6b656e223b4e3b733a31363a2261646d696e5f6c6173745f6c6f67696e223b733a31393a22323031342d30312d30322031373a35383a3535223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `fat_setting`
--

DROP TABLE IF EXISTS `fat_setting`;
CREATE TABLE IF NOT EXISTS `fat_setting` (
`id_setting` int(11) NOT NULL,
  `id_site` int(11) NOT NULL DEFAULT '0',
  `type` varchar(150) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=425 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_setting`
--

TRUNCATE TABLE `fat_setting`;
--
-- Dumping data for table `fat_setting`
--

INSERT INTO `fat_setting` (`id_setting`, `id_site`, `type`, `value`) VALUES
(408, 1, 'app_footer', '© 2014 PT. Indonesia Media Televisi. All Right Reserved.'),
(409, 1, 'app_title', 'BIGTV HD PREPAID'),
(410, 1, 'email_contact', 'smtp@test.com'),
(411, 1, 'email_contact_name', 'BIGTV HD Admin'),
(412, 1, 'facebook_url', '#'),
(413, 1, 'ip_approved', '::1;127.0.0.1'),
(414, 1, 'mail_host', 'mail.test.com'),
(415, 1, 'mail_pass', 'mail27'),
(416, 1, 'mail_port', '25'),
(417, 1, 'mail_protocol', 'smtp'),
(418, 1, 'mail_user', 'smtp@test.com'),
(419, 1, 'maintenance_message', '<p>This site currently on maintenance, please check again later.</p>\n'),
(420, 1, 'maintenance_mode', '0'),
(421, 1, 'twitter_url', '#'),
(422, 1, 'web_description', 'This is website description'),
(423, 1, 'web_keywords', ''),
(424, 1, 'welcome_message', '');

-- --------------------------------------------------------

--
-- Table structure for table `fat_sites`
--

DROP TABLE IF EXISTS `fat_sites`;
CREATE TABLE IF NOT EXISTS `fat_sites` (
`id_site` int(11) NOT NULL,
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
  `create_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_sites`
--

TRUNCATE TABLE `fat_sites`;
--
-- Dumping data for table `fat_sites`
--

INSERT INTO `fat_sites` (`id_site`, `site_name`, `site_url`, `site_path`, `site_logo`, `id_ref_publish`, `site_address`, `site_longitude`, `site_latitude`, `site_urut`, `is_default`, `is_delete`, `modify_date`, `create_date`) VALUES
(1, 'BIGTV HD PREPAID', '/', '/', 'site_bigtv_hd_prepaid_3272145b8b4ac5da163837bc428164dc.png', 1, 'BIGTV HD PREPAID', '', '', 1, 1, 0, '2015-03-19 11:05:42', '2012-07-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fat_status`
--

DROP TABLE IF EXISTS `fat_status`;
CREATE TABLE IF NOT EXISTS `fat_status` (
`id_status` int(11) NOT NULL,
  `status_text` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncate table before insert `fat_status`
--

TRUNCATE TABLE `fat_status`;
--
-- Dumping data for table `fat_status`
--

INSERT INTO `fat_status` (`id_status`, `status_text`) VALUES
(1, 'Publish'),
(2, 'Draft');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fat_auth_group`
--
ALTER TABLE `fat_auth_group`
 ADD PRIMARY KEY (`id_auth_group`);

--
-- Indexes for table `fat_auth_menu`
--
ALTER TABLE `fat_auth_menu`
 ADD PRIMARY KEY (`id_auth_menu`);

--
-- Indexes for table `fat_auth_menu_group`
--
ALTER TABLE `fat_auth_menu_group`
 ADD PRIMARY KEY (`id_auth_menu_group`);

--
-- Indexes for table `fat_auth_user`
--
ALTER TABLE `fat_auth_user`
 ADD PRIMARY KEY (`id_auth_user`);

--
-- Indexes for table `fat_auth_user_group`
--
ALTER TABLE `fat_auth_user_group`
 ADD PRIMARY KEY (`id_auth_user_group`);

--
-- Indexes for table `fat_localization`
--
ALTER TABLE `fat_localization`
 ADD PRIMARY KEY (`id_localization`);

--
-- Indexes for table `fat_logs`
--
ALTER TABLE `fat_logs`
 ADD PRIMARY KEY (`id_logs`);

--
-- Indexes for table `fat_pages`
--
ALTER TABLE `fat_pages`
 ADD PRIMARY KEY (`id_page`);

--
-- Indexes for table `fat_pages_detail`
--
ALTER TABLE `fat_pages_detail`
 ADD PRIMARY KEY (`id_page_detail`);

--
-- Indexes for table `fat_pages_image`
--
ALTER TABLE `fat_pages_image`
 ADD PRIMARY KEY (`id_page_image`);

--
-- Indexes for table `fat_pages_image_caption`
--
ALTER TABLE `fat_pages_image_caption`
 ADD PRIMARY KEY (`id_page_image_caption`);

--
-- Indexes for table `fat_sessions`
--
ALTER TABLE `fat_sessions`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `fat_sessions_id_ip` (`id`,`ip_address`), ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `fat_setting`
--
ALTER TABLE `fat_setting`
 ADD PRIMARY KEY (`id_setting`), ADD KEY `is_site` (`id_site`);

--
-- Indexes for table `fat_sites`
--
ALTER TABLE `fat_sites`
 ADD PRIMARY KEY (`id_site`);

--
-- Indexes for table `fat_status`
--
ALTER TABLE `fat_status`
 ADD PRIMARY KEY (`id_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fat_auth_group`
--
ALTER TABLE `fat_auth_group`
MODIFY `id_auth_group` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fat_auth_menu`
--
ALTER TABLE `fat_auth_menu`
MODIFY `id_auth_menu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `fat_auth_menu_group`
--
ALTER TABLE `fat_auth_menu_group`
MODIFY `id_auth_menu_group` bigint(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=514;
--
-- AUTO_INCREMENT for table `fat_auth_user`
--
ALTER TABLE `fat_auth_user`
MODIFY `id_auth_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fat_auth_user_group`
--
ALTER TABLE `fat_auth_user_group`
MODIFY `id_auth_user_group` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fat_localization`
--
ALTER TABLE `fat_localization`
MODIFY `id_localization` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fat_logs`
--
ALTER TABLE `fat_logs`
MODIFY `id_logs` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT for table `fat_pages`
--
ALTER TABLE `fat_pages`
MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `fat_pages_detail`
--
ALTER TABLE `fat_pages_detail`
MODIFY `id_page_detail` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fat_pages_image`
--
ALTER TABLE `fat_pages_image`
MODIFY `id_page_image` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fat_pages_image_caption`
--
ALTER TABLE `fat_pages_image_caption`
MODIFY `id_page_image_caption` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fat_setting`
--
ALTER TABLE `fat_setting`
MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=425;
--
-- AUTO_INCREMENT for table `fat_sites`
--
ALTER TABLE `fat_sites`
MODIFY `id_site` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fat_status`
--
ALTER TABLE `fat_status`
MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
