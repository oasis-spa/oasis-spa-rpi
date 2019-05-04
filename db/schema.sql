-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2019 at 02:01 PM
-- Server version: 10.1.38-MariaDB-0+deb9u1
-- PHP Version: 7.0.33-0+deb9u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `controller`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(1) NOT NULL,
  `version` varchar(4) NOT NULL,
  `raspberry_type` varchar(10) NOT NULL,
  `token` varchar(255) NOT NULL,
  `api` int(1) NOT NULL,
  `set_temp` varchar(4) NOT NULL,
  `set_temp_dev` varchar(4) NOT NULL,
  `save_temp` int(1) NOT NULL,
  `degree_type` int(1) NOT NULL DEFAULT '1',
  `heater_control` int(1) NOT NULL,
  `heater_relay` int(2) NOT NULL,
  `heater_sensor` int(6) NOT NULL,
  `overheat_control` int(1) NOT NULL,
  `overheat_sensor` int(4) NOT NULL,
  `overheat_temp` varchar(4) NOT NULL,
  `pump_control` int(1) NOT NULL,
  `pump_relay` int(2) NOT NULL,
  `frost_protection` int(1) NOT NULL,
  `frost_temp` varchar(4) NOT NULL,
  `frost_sensor` int(6) NOT NULL,
  `cleaning_mode` smallint(1) NOT NULL,
  `left_column` int(6) NOT NULL,
  `mid_column` varchar(52) NOT NULL,
  `right_column` int(6) NOT NULL,
  `used_power_date` date NOT NULL,
  `tablet_view` smallint(1) NOT NULL,
  `ip_check` smallint(1) NOT NULL,
  `ip_range` varchar(32) NOT NULL,
  `push_token` varchar(48) NOT NULL,
  `push_key` varchar(48) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `device_control`
--

CREATE TABLE IF NOT EXISTS `device_control` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `relay_pin` int(6) NOT NULL,
  `relay_state` int(1) NOT NULL,
  `other_relay_pin` int(6) NOT NULL,
  `other_relay_state` int(1) NOT NULL,
  `remarks` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `iplist`
--

CREATE TABLE IF NOT EXISTS `iplist` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `time` bigint(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `log` mediumtext NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `relays`
--

CREATE TABLE IF NOT EXISTS `relays` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `pin` int(3) NOT NULL,
  `name` varchar(52) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `state` int(3) NOT NULL,
  `visible` varchar(3) NOT NULL,
  `shower` varchar(3) NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `apikey` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tank` varchar(3) NOT NULL,
  `time_on` datetime NOT NULL,
  `power` int(4) NOT NULL,
  `minutes_power` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `pin` int(2) NOT NULL,
  `state` int(1) NOT NULL,
  `time` time NOT NULL,
  `active` int(1) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--

CREATE TABLE IF NOT EXISTS `sensors` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `address` varchar(125) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `name` varchar(52) NOT NULL,
  `type` varchar(4) NOT NULL,
  `pin` int(2) NOT NULL,
  `calibration_value` varchar(5) NOT NULL,
  `visible` varchar(3) NOT NULL,
  `temperature` varchar(6) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_control`
--

CREATE TABLE IF NOT EXISTS `temp_control` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `sensor_id` int(8) NOT NULL,
  `mark` varchar(1) NOT NULL,
  `value` varchar(5) NOT NULL,
  `switch` int(2) NOT NULL,
  `state` int(1) NOT NULL,
  `remarks` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_logger`
--

CREATE TABLE IF NOT EXISTS `temp_logger` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `address` varchar(52) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `value` varchar(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(52) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `rank` smallint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
