-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2014 at 10:20 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `printapps`
--

-- --------------------------------------------------------

--
-- Table structure for table `printapps_commentmeta`
--

CREATE TABLE IF NOT EXISTS `printapps_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `printapps_comments`
--

CREATE TABLE IF NOT EXISTS `printapps_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL,
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL,
  `comment_author_url` varchar(200) NOT NULL,
  `comment_author_IP` varchar(100) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_date_gmt` datetime NOT NULL,
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL,
  `comment_approved` varchar(20) NOT NULL,
  `comment_agent` varchar(255) NOT NULL,
  `comment_type` varchar(20) NOT NULL,
  `comment_parent` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`comment_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `printapps_links`
--

CREATE TABLE IF NOT EXISTS `printapps_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL,
  `link_name` varchar(255) NOT NULL,
  `link_image` varchar(255) NOT NULL,
  `link_target` varchar(25) NOT NULL,
  `link_description` varchar(255) NOT NULL,
  `link_visible` varchar(20) NOT NULL,
  `link_owner` bigint(20) unsigned NOT NULL,
  `link_rating` int(11) NOT NULL,
  `link_updated` datetime NOT NULL,
  `link_rel` varchar(255) NOT NULL,
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `printapps_options`
--

CREATE TABLE IF NOT EXISTS `printapps_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL,
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `printapps_options`
--

INSERT INTO `printapps_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'site_url', 'http://localhost/silikon/', ''),
(2, 'site_title', 'PrintApps', '');

-- --------------------------------------------------------

--
-- Table structure for table `printapps_postmeta`
--

CREATE TABLE IF NOT EXISTS `printapps_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=224 ;

--
-- Dumping data for table `printapps_postmeta`
--

INSERT INTO `printapps_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(50, 15, 'qty', '400'),
(48, 14, 'shipping_cost', '15'),
(47, 14, 'price', '14'),
(46, 14, 'qty', '1'),
(43, 13, 'price', '20'),
(44, 13, 'shipping_cost', '5'),
(45, 14, 'post_image_url', 'http://localhost/silikon/theme/uploads/b2.png'),
(49, 15, 'post_image_url', 'http://localhost/silikon/theme/uploads/10455234_539739999463536_2423695569467854069_n.jpg'),
(42, 13, 'qty', '1'),
(41, 13, 'post_image_url', 'http://localhost/silikon/theme/uploads/l1.png'),
(39, 12, 'price', '10'),
(40, 12, 'shipping_cost', '23'),
(38, 12, 'qty', '1'),
(37, 12, 'post_image_url', 'http://localhost/silikon/theme/uploads/b1.png'),
(54, 16, 'qty', '30'),
(51, 15, 'price', '10'),
(52, 15, 'shipping_cost', '1'),
(53, 16, 'post_image_url', 'http://localhost/silikon/theme/uploads/10455234_539739999463536_2423695569467854069_n.jpg'),
(87, 24, 'price', '20'),
(88, 24, 'shipping_cost', '5'),
(56, 16, 'shipping_cost', ''),
(55, 16, 'price', ''),
(86, 24, 'qty', '100'),
(85, 24, 'post_image_url', 'http://localhost/silikon/theme/uploads/26112013727-4240693948.jpg'),
(80, 22, 'shipping_cost', '15'),
(79, 22, 'price', '14'),
(78, 22, 'qty', '1'),
(77, 22, 'post_image_url', 'http://localhost/silikon/theme/uploads/b-488853845.jpeg'),
(76, 21, 'shipping_cost', '15'),
(75, 21, 'price', '14'),
(74, 21, 'qty', '1'),
(73, 21, 'post_image_url', 'http://localhost/silikon/theme/uploads/b-1464228956.jpeg'),
(89, 25, 'post_image_url', 'http://localhost/silikon/theme/uploads/26112013727-5100992280.jpg'),
(90, 25, 'qty', '1'),
(91, 25, 'price', '14'),
(92, 25, 'shipping_cost', '15'),
(93, 26, 'post_image_url', 'http://localhost/silikon/theme/uploads/10455234_539739999463536_2423695569467854069_n-5332046765.jpg'),
(94, 26, 'qty', '200'),
(95, 26, 'price', '20'),
(96, 26, 'shipping_cost', '5'),
(97, 27, 'post_image_url', 'http://localhost/silikon/theme/uploads/penguins-2920030010.jpg'),
(98, 27, 'qty', '1'),
(99, 27, 'price', '14'),
(100, 27, 'shipping_cost', '15'),
(101, 28, 'post_image_url', 'http://localhost/silikon/theme/uploads/6762acban1024[1]-3126933439.jpg'),
(102, 28, 'qty', '100'),
(103, 28, 'price', '14'),
(104, 28, 'shipping_cost', '15'),
(105, 29, 'post_image_url', 'http://localhost/silikon/theme/uploads/10455234_539739999463536_2423695569467854069_n-2859401786.jpg'),
(106, 29, 'qty', '1'),
(107, 29, 'price', '14'),
(108, 29, 'shipping_cost', '15'),
(109, 30, 'post_image_url', 'http://localhost/silikon/theme/uploads/WP_20131127_16_39_19_Pro.jpg'),
(110, 30, 'qty', '2'),
(111, 30, 'price', '10'),
(112, 30, 'shipping_cost', '1'),
(222, 55, 'price', 'Resource id #8'),
(223, 55, 'shipping_cost', 'Resource id #9'),
(221, 55, 'qty', '3'),
(219, 55, 'post_image_url_0', 'http://localhost/silikon/theme/upload/desert-345545203.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `printapps_posts`
--

CREATE TABLE IF NOT EXISTS `printapps_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL,
  `post_date` datetime NOT NULL,
  `post_date_gmt` datetime NOT NULL,
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL,
  `comment_status` varchar(20) NOT NULL,
  `ping_status` varchar(20) NOT NULL,
  `post_password` varchar(20) NOT NULL,
  `post_name` varchar(200) NOT NULL,
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL,
  `post_modified_gmt` datetime NOT NULL,
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL,
  `guid` varchar(255) NOT NULL,
  `menu_order` int(11) NOT NULL,
  `post_type` varchar(20) NOT NULL,
  `post_mime_type` varchar(100) NOT NULL,
  `comment_count` bigint(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `printapps_posts`
--

INSERT INTO `printapps_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(25, 21, '2014-08-26 19:30:15', '2014-08-26 19:30:15', 'nb nb', 'Inventory Test Product 1', 'nb nb...', 'publish', '', '', '', 'inventory-test-product-12', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 14, '', 0, 'inventory-product', '', 0),
(24, 21, '2014-08-26 19:29:18', '2014-08-26 19:29:18', 'abcdef', '1234', 'abcdef...', 'publish', '', '', '', '1234', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 13, '', 0, 'inventory-product', '', 0),
(12, 1, '2014-08-05 08:08:27', '2014-08-05 08:08:27', 'Business Product 1', 'Business Cards', '', 'publish', '', '', '', 'business-cards', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '', 0, 'product', '', 0),
(13, 1, '2014-08-05 08:38:06', '2014-08-05 08:38:06', 'Test Lenticular', 'Lenticular Printing Product', '', 'publish', '', '', '', 'lenticular-printing-product', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '', 0, 'product', '', 0),
(14, 1, '2014-08-05 08:39:52', '2014-08-05 08:39:52', 'Letter Heads Product', 'Letter Heads', '', 'publish', '', '', '', 'letter-heads', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '', 0, 'product', '', 0),
(15, 13, '2014-08-21 23:15:32', '2014-08-21 23:15:32', 'abcd', 'Business Card  400 qty', '', 'publish', '', '', '', 'business-card--400-qty', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '', 0, 'inventory-product', '', 0),
(16, 13, '2014-08-21 23:15:32', '2014-08-21 23:15:32', 'abcd', 'Business Card  30 qty', '', 'publish', '', '', '', 'business-card--30-qty', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '', 0, 'inventory-product', '', 0),
(22, 24, '2014-08-24 20:16:59', '2014-08-24 20:16:59', 'dfgd', 'sdgfs', 'dfgd...', 'publish', '', '', '', 'sdgfs', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 14, '', 0, 'inventory-product', '', 0),
(21, 24, '2014-08-24 19:35:17', '2014-08-24 19:35:17', 'nb nb', 'Inventory Test Product 1', 'nb nb...', 'publish', '', '', '', 'inventory-test-product-1', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 14, '', 0, 'inventory-product', '', 0),
(26, 21, '2014-08-26 19:34:51', '2014-08-26 19:34:51', 'abcde', 'fleyrs', 'abcde...', 'publish', '', '', '', 'fleyrs', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 13, '', 0, 'inventory-product', '', 0),
(27, 21, '2014-08-27 17:15:29', '2014-08-27 17:15:29', 'dfgd', 'sdgfs', 'dfgd...', 'publish', '', '', '', 'sdgfs2', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 14, '', 0, 'inventory-product', '', 0),
(28, 21, '2014-08-28 12:54:23', '2014-08-28 12:54:23', 'abcdefgh', 'Assassin\\''s Creed', 'abcdefgh...', 'publish', '', '', '', 'assassin\\''s-creed', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 14, '', 0, 'inventory-product', '', 0),
(29, 21, '2014-08-28 12:56:22', '2014-08-28 12:56:22', 'nb nb', 'Inventory Test Product 1', 'nb nb...', 'publish', '', '', '', 'inventory-test-product-13', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 14, '', 0, 'inventory-product', '', 0),
(30, 21, '2014-08-28 13:02:47', '2014-08-28 13:02:47', 'afghti', 'acbd 2 qty', '', 'publish', '', '', '', 'acbd-2-qty', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, '', 0, 'inventory-product', '', 0),
(55, 21, '2014-09-02 08:32:11', '2014-09-02 08:32:11', 'ss', 'Test', 'ss...', 'publish', '', '', '', 'test', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 12, '', 0, 'inventory-product', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `printapps_terms`
--

CREATE TABLE IF NOT EXISTS `printapps_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `term_group` bigint(10) NOT NULL,
  PRIMARY KEY (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `printapps_terms`
--

INSERT INTO `printapps_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(14, 'Bookslets and Catalogs', 'bookslets-and-catalogs', 0),
(13, 'Promotional Flyers', 'promotional-flyers', 0),
(12, 'Business Stationary', 'business-stationary', 0),
(20, 'Posters and Point of Sale Promotions', 'posters-and-point-of-sale-promotions', 0),
(18, 'Stickers and Decals', 'stickers-and-decals', 0),
(19, 'Lenticular Printing', 'lenticular-printing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `printapps_term_relationships`
--

CREATE TABLE IF NOT EXISTS `printapps_term_relationships` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL,
  `term_taxonomy_id` bigint(20) unsigned NOT NULL,
  `term_order` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `printapps_term_relationships`
--

INSERT INTO `printapps_term_relationships` (`ID`, `object_id`, `term_taxonomy_id`, `term_order`) VALUES
(8, 14, 12, 0),
(7, 13, 19, 0),
(6, 12, 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `printapps_term_taxonomy`
--

CREATE TABLE IF NOT EXISTS `printapps_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL,
  `taxonomy` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `parent` bigint(20) NOT NULL,
  `count` bigint(20) NOT NULL,
  PRIMARY KEY (`term_taxonomy_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `printapps_term_taxonomy`
--

INSERT INTO `printapps_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(19, 19, 'lenticular-printing', '', 0, 1),
(18, 18, 'stickers-and-decals', '', 0, 0),
(20, 20, 'posters-and-point-of-sale-promotions', '', 0, 0),
(14, 14, 'bookslets-and-catalogs', '', 0, 0),
(13, 13, 'promotional-flyers', '', 0, 0),
(12, 12, 'business-stationary', '', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `printapps_usermeta`
--

CREATE TABLE IF NOT EXISTS `printapps_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

--
-- Dumping data for table `printapps_usermeta`
--

INSERT INTO `printapps_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'role', 'administrator'),
(58, 13, 'customer_user_password', 'groofye'),
(57, 13, 'customer_user_phone', '551225125'),
(56, 13, 'customer_user_mobile', '445652232'),
(55, 13, 'customer_business_name', 'Freelancer'),
(54, 13, 'role', 'customer'),
(88, 19, 'customer_user_password', 'groofy'),
(87, 19, 'customer_user_phone', '123456'),
(86, 19, 'customer_user_mobile', '789456'),
(84, 19, 'role', 'customer'),
(85, 19, 'customer_business_name', 'Freelancing'),
(59, 14, 'role', 'customer'),
(60, 14, 'customer_business_name', 'Freelancing'),
(61, 14, 'customer_user_mobile', '845211'),
(62, 14, 'customer_user_phone', '54512'),
(63, 14, 'customer_user_password', 'groofi'),
(64, 14, 'role', 'customer'),
(65, 14, 'customer_business_name', 'Freelancing'),
(66, 14, 'customer_user_mobile', '845211'),
(67, 14, 'customer_user_phone', '54512'),
(68, 14, 'customer_user_password', 'groofi'),
(94, 21, 'role', 'customer'),
(95, 21, 'customer_business_name', 'ISCS Firm'),
(96, 21, 'customer_user_mobile', '919903093700'),
(97, 21, 'customer_user_phone', '919903093700'),
(98, 21, 'customer_user_password', 'ranadip011'),
(113, 24, 'customer_user_password', 'pass'),
(111, 24, 'customer_user_mobile', '7278818769'),
(112, 24, 'customer_user_phone', '7278818769'),
(110, 24, 'customer_business_name', 'Freelancing'),
(109, 24, 'role', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `printapps_users`
--

CREATE TABLE IF NOT EXISTS `printapps_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL,
  `user_pass` varchar(64) NOT NULL,
  `user_nicename` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_url` varchar(100) NOT NULL,
  `user_registered` datetime NOT NULL,
  `user_activation_key` varchar(60) NOT NULL,
  `user_status` int(11) NOT NULL,
  `display_name` varchar(250) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `printapps_users`
--

INSERT INTO `printapps_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin', '1a1dc91c907325c69271ddf0c944bc72', 'Amal Test Customer Check', 'amitks.cn@gmail.com', '', '2014-07-14 21:51:32', '', 0, 'admin'),
(13, 'customer_2', '6e6754ac053a5492e916277090d726b4', 'Customer 2', 'customer@gmail.com', '', '2014-07-27 19:00:26', '', 0, 'Customer 2'),
(14, 'customer_3', 'b3d8b0891ef9d84a530fcc26f3160758', 'Customer 3', 'customer3@gmail.in', '', '2014-07-27 19:01:32', '', 0, 'Customer 3'),
(19, 'amal-chowdhury', 'f947a5c10272f197166a78d0dbe09bd8', 'Amal Chowdhury', 'amal@gmail.in', '', '2014-08-05 19:41:31', '', 0, 'Amal Chowdhury'),
(15, 'customer_3', '5e386444c9ff5e87acaa1fafab9399a0', 'Customer 3', 'customer3@gmail.in', '', '2014-07-27 19:01:17', '', 0, 'Customer 3'),
(21, 'ranadip-das', '46781c1386b6ecbf810dca6d7c77908a', 'Ranadip Das', 'rana.ece23@gmail.com', '', '2014-08-12 03:20:16', '', 0, 'Ranadip Das'),
(24, 'rick-ray', '1a1dc91c907325c69271ddf0c944bc72', 'Rick Ray', 'rickray.cn@gmail.com', '', '2014-08-16 22:45:43', '', 0, 'Rick Ray');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
