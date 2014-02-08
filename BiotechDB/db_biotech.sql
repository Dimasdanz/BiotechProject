-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2014 at 03:14 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_biotech`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(10, 'dimas', '$2a$08$fc65mYcIfPG6OZoKlphyN.ZiTMPahkk1hFM2x9G4WElHCfy1c.r6W'),
(12, 'admin', '$2a$08$AgtLVfj.8V3EFmKumk9Zg.PZuFmSghGXK0XpDWmlIrnT6haOnnVY6');

-- --------------------------------------------------------

--
-- Table structure for table `dcs_log`
--

CREATE TABLE IF NOT EXISTS `dcs_log` (
  `dcs_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dcs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dcs_log`
--

INSERT INTO `dcs_log` (`dcs_id`, `name`, `time`) VALUES
(1, 'test', '2014-02-06 13:54:14');

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

--
-- Dumping data for table `dcs_user`
--

INSERT INTO `dcs_user` (`user_id`, `name`, `password`) VALUES
('001', 'Dimas', '1234'),
('002', 'admin', '123');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `gcs_log`
--

INSERT INTO `gcs_log` (`gcs_id`, `temperature`, `lux`, `time`) VALUES
(1, '35', '6500', '2014-02-07 05:26:56'),
(2, '30', '8000', '2014-02-07 08:48:43'),
(3, '28', '4500', '2014-02-07 08:48:53'),
(5, '35', '8000', '2014-02-07 09:47:25'),
(6, '32', '65000', '2014-02-07 09:55:10'),
(7, '36', '14000', '2014-02-07 09:58:20'),
(8, '28', '1500', '2014-02-07 09:58:30');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gcs_plants`
--

INSERT INTO `gcs_plants` (`plant_id`, `name`, `humidity`, `lux`) VALUES
(1, 'Durian', 'dry', '6500'),
(3, 'Rambutan', 'humid', '12500');

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
-- Table structure for table `scs_log`
--

CREATE TABLE IF NOT EXISTS `scs_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temperature` decimal(10,0) NOT NULL,
  `smoke` decimal(10,0) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
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
