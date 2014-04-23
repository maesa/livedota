-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2014 at 08:07 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dota2db`
--

-- --------------------------------------------------------

--
-- Table structure for table `steam`
--

CREATE TABLE IF NOT EXISTS `steam` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SteamURL` varchar(60) NOT NULL,
  `SteamID64` char(17) NOT NULL,
  `known_as` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `twitch`
--

CREATE TABLE IF NOT EXISTS `twitch` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TwitchURL` varchar(60) NOT NULL,
  `channel` varchar(20) NOT NULL,
  `known_as` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
