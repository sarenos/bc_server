-- phpMyAdmin SQL Dump
-- version 4.2.3deb1.precise~ppa.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 23, 2015 at 05:07 PM
-- Server version: 5.5.29-0ubuntu0.12.04.2
-- PHP Version: 5.5.27-1+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bc`
--

-- --------------------------------------------------------

--
-- Table structure for table `bc_connections`
--

CREATE TABLE IF NOT EXISTS `bc_connections` (
`id` bigint(45) unsigned NOT NULL,
  `user1` bigint(30) unsigned NOT NULL,
  `user2` bigint(30) unsigned NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bc_friends`
--

CREATE TABLE IF NOT EXISTS `bc_friends` (
  `user_from` varchar(50) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `dt_create` datetime NOT NULL,
  `dt_status` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bc_locations`
--

CREATE TABLE IF NOT EXISTS `bc_locations` (
`id` int(10) unsigned NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `date_crt` datetime NOT NULL,
  `user_account` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bc_messages`
--

CREATE TABLE IF NOT EXISTS `bc_messages` (
`id` bigint(50) unsigned NOT NULL,
  `connection_id` bigint(45) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `message` text NOT NULL,
  `dt_create` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bc_users_info`
--

CREATE TABLE IF NOT EXISTS `bc_users_info` (
`user_id` bigint(30) unsigned NOT NULL,
  `user_account` varchar(50) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `age` tinyint(1) unsigned NOT NULL,
  `sex` char(1) NOT NULL,
  `android_account` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `vk_id` varchar(255) NOT NULL,
  `dt_create` datetime NOT NULL,
  `birth_date` date NOT NULL,
  `city` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `new_friends` tinyint(1) unsigned DEFAULT '0',
  `new_messages` smallint(2) unsigned DEFAULT '0',
  `radius` double unsigned NOT NULL DEFAULT '1',
  `filter` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bc_user_loc_archive`
--

CREATE TABLE IF NOT EXISTS `bc_user_loc_archive` (
`id` int(11) NOT NULL,
  `user_account` varchar(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `date_crt` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_connections`
--
ALTER TABLE `bc_connections`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user1` (`user1`,`user2`);

--
-- Indexes for table `bc_friends`
--
ALTER TABLE `bc_friends`
 ADD PRIMARY KEY (`user_from`,`user_to`);

--
-- Indexes for table `bc_locations`
--
ALTER TABLE `bc_locations`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `date_crt` (`date_crt`,`user_account`);

--
-- Indexes for table `bc_messages`
--
ALTER TABLE `bc_messages`
 ADD PRIMARY KEY (`id`), ADD KEY `connection_id` (`connection_id`);

--
-- Indexes for table `bc_users_info`
--
ALTER TABLE `bc_users_info`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_account` (`user_account`), ADD UNIQUE KEY `name` (`nick`);

--
-- Indexes for table `bc_user_loc_archive`
--
ALTER TABLE `bc_user_loc_archive`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_account`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_connections`
--
ALTER TABLE `bc_connections`
MODIFY `id` bigint(45) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bc_locations`
--
ALTER TABLE `bc_locations`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bc_messages`
--
ALTER TABLE `bc_messages`
MODIFY `id` bigint(50) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bc_users_info`
--
ALTER TABLE `bc_users_info`
MODIFY `user_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bc_user_loc_archive`
--
ALTER TABLE `bc_user_loc_archive`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
