-- phpMyAdmin SQL Dump
-- version 3.0.1.1
-- http://www.phpmyadmin.net
--
-- Host: 10.0.1.1
-- Generation Time: Sep 30, 2009 at 07:43 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `polygame_polygame`
--

-- --------------------------------------------------------

--
-- Table structure for table `Game`
--

CREATE TABLE IF NOT EXISTS `Game` (
  `Game ID` int(11) NOT NULL AUTO_INCREMENT,
  `Starting time` datetime NOT NULL,
  `Extra minutes` int(11) NOT NULL DEFAULT '0',
  `Owner` varchar(40) NOT NULL,
  `Length 1a` int(11) NOT NULL,
  `Length 1b` int(11) NOT NULL,
  `Length 1c` int(11) NOT NULL,
  `Length 2` int(11) NOT NULL,
  PRIMARY KEY (`Game ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `Game Players`
--

CREATE TABLE IF NOT EXISTS `Game Players` (
  `Game ID` int(11) NOT NULL,
  `Player ID` varchar(40) NOT NULL,
  PRIMARY KEY (`Game ID`,`Player ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Game Wedges`
--

CREATE TABLE IF NOT EXISTS `Game Wedges` (
  `Game ID` int(11) NOT NULL,
  `Wedge ID` int(11) NOT NULL,
  PRIMARY KEY (`Game ID`,`Wedge ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE IF NOT EXISTS `Groups` (
  `User ID` int(11) NOT NULL,
  `Group ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Posters`
--

CREATE TABLE IF NOT EXISTS `Posters` (
  `Player` varchar(40) NOT NULL,
  `Game ID` int(11) NOT NULL,
  `Wedge ID` int(11) NOT NULL,
  `Pros` text NOT NULL,
  `Cons` text NOT NULL,
  `Notes` text NOT NULL,
  PRIMARY KEY (`Player`,`Game ID`,`Wedge ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `username` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('administrator','player','voter','organizer') CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Wedge Players`
--

CREATE TABLE IF NOT EXISTS `Wedge Players` (
  `User ID` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Wedge ID` int(11) NOT NULL,
  `Game ID` int(11) NOT NULL,
  PRIMARY KEY (`User ID`,`Wedge ID`,`Game ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Wedges`
--

CREATE TABLE IF NOT EXISTS `Wedges` (
  `Wedge ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Owner` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `Introduction` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `History` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Present use` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `National situation` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Emission reduction` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Pros` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Cons` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `References` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Wedge ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
