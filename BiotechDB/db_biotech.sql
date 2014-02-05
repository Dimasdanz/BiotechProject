-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2014 at 05:59 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_biotech`
--
CREATE DATABASE IF NOT EXISTS `db_biotech` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_biotech`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(2, 'dimas', '$2a$08$mZd9.SCr5UBfswJCuTn55OXcjd7v3nEucSZ406TI0DT1ClioTwbVm');

-- --------------------------------------------------------

--
-- Table structure for table `dcs_log`
--

CREATE TABLE IF NOT EXISTS `dcs_log` (
  `dcs_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dcs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dcs_user`
--

CREATE TABLE IF NOT EXISTS `dcs_user` (
  `user_id` varchar(3) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `password` varchar(5) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gcs_log`
--

CREATE TABLE IF NOT EXISTS `gcs_log` (
  `gcs_id` int(11) NOT NULL AUTO_INCREMENT,
  `temperature` decimal(10,0) NOT NULL,
  `lux` decimal(10,0) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gcs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gcs_plants`
--

CREATE TABLE IF NOT EXISTS `gcs_plants` (
  `plant_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `humidity` varchar(255) NOT NULL,
  `lux` decimal(10,0) NOT NULL,
  PRIMARY KEY (`plant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hcs_log`
--

CREATE TABLE IF NOT EXISTS `hcs_log` (
  `hcs_id` int(11) NOT NULL AUTO_INCREMENT,
  `lamp` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`hcs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wms_log`
--

CREATE TABLE IF NOT EXISTS `wms_log` (
  `wms_id` int(11) NOT NULL AUTO_INCREMENT,
  `water_level` decimal(10,0) NOT NULL,
  `turbidity` decimal(10,0) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
