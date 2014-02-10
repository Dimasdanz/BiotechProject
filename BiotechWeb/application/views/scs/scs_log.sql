-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2014 at 04:41 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `scs_log`
--

CREATE TABLE IF NOT EXISTS `scs_log` (
  `scs_id` int(11) NOT NULL AUTO_INCREMENT,
  `temperature` decimal(10,0) NOT NULL,
  `smoke` decimal(10,0) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`scs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `scs_log`
--

INSERT INTO `scs_log` (`scs_id`, `temperature`, `smoke`, `time`) VALUES
(1, 30, 100, '2014-02-10 02:36:49'),
(2, 31, 111, '2014-02-10 02:36:49'),
(3, 29, 300, '2014-02-10 02:36:49'),
(4, 32, 278, '2014-02-10 02:36:49'),
(5, 28, 170, '2014-02-10 02:36:49');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
