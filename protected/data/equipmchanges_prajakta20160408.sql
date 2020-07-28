-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2016 at 09:59 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rims_1903`
--

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipments`
--

CREATE TABLE IF NOT EXISTS `rims_equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `equipment_type_id` int(11) NOT NULL,
  `equipment_sub_type_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`),
  KEY `equipment_type_id` (`equipment_type_id`),
  KEY `equipment_sub_type_id` (`equipment_sub_type_id`),
  KEY `equipment_sub_type_id_2` (`equipment_sub_type_id`),
  KEY `equipment_type_id_2` (`equipment_type_id`),
  KEY `branch_id` (`branch_id`),
  KEY `branch_id_2` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Truncate table before insert `rims_equipments`
--

TRUNCATE TABLE `rims_equipments`;
--
-- Dumping data for table `rims_equipments`
--

INSERT INTO `rims_equipments` (`id`, `branch_id`, `equipment_type_id`, `equipment_sub_type_id`, `name`, `status`) VALUES
(1, 1, 1, 1, 'Eq1', 'Active'),
(2, 11, 1, 1, 'workshop lubrication & tools', 'Active'),
(3, 1, 1, 1, 'equipment 123', 'Active'),
(4, 3, 1, 1, 'Ewui', 'Active'),
(5, 8, 1, 1, 'equip br8', 'Active'),
(6, 2, 1, 1, 'sbcd', 'Active'),
(7, 2, 1, 1, 'ew23', 'Active'),
(8, 3, 1, 1, 'abcjkfs', 'Active'),
(9, 3, 1, 1, 'abchf', 'Active'),
(10, 3, 1, 1, 'abchf', 'Active'),
(11, 5, 1, 1, 'eq br 5', 'Active'),
(17, 2, 1, 1, 'er4', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment_branch`
--

CREATE TABLE IF NOT EXISTS `rims_equipment_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `quantity` int(10) NOT NULL,
  `purchase_date` date NOT NULL,
  `age` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Truncate table before insert `rims_equipment_branch`
--

TRUNCATE TABLE `rims_equipment_branch`;
--
-- Dumping data for table `rims_equipment_branch`
--

INSERT INTO `rims_equipment_branch` (`id`, `branch_id`, `brand`, `quantity`, `purchase_date`, `age`, `status`) VALUES
(1, 1, 'Hitechi', 100, '2015-11-02', 64, 'Active'),
(2, 3, '', 0, '2015-12-03', 33, 'Active'),
(3, 4, 'Hitachi', 100, '2016-03-01', 29, 'Active'),
(5, 1, 'Suzuki', 500, '2016-01-01', 100, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment_maintenance`
--

CREATE TABLE IF NOT EXISTS `rims_equipment_maintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_task_id` int(11) NOT NULL,
  `equipment_branch_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `maintenance_date` date NOT NULL,
  `next_maintenance_date` date NOT NULL,
  `check_date` date NOT NULL,
  `checked` enum('checked','not-checked') NOT NULL DEFAULT 'not-checked',
  `notes` text NOT NULL,
  `equipment_condition` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`),
  KEY `equipment_task_id` (`equipment_task_id`),
  KEY `equipment_branch_id` (`equipment_branch_id`),
  KEY `employee_id` (`employee_id`),
  KEY `equipment_id` (`equipment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Truncate table before insert `rims_equipment_maintenance`
--

TRUNCATE TABLE `rims_equipment_maintenance`;
--
-- Dumping data for table `rims_equipment_maintenance`
--

INSERT INTO `rims_equipment_maintenance` (`id`, `equipment_task_id`, `equipment_branch_id`, `equipment_id`, `employee_id`, `maintenance_date`, `next_maintenance_date`, `check_date`, `checked`, `notes`, `equipment_condition`, `status`) VALUES
(1, 1, 1, 1, 26, '2016-04-01', '2017-04-01', '2016-04-01', 'not-checked', 'notes1', 'Good', 'Active'),
(2, 2, 1, 1, 28, '2016-04-01', '2016-09-30', '2016-04-01', 'not-checked', 'notes2', 'Good', 'Active'),
(3, 2, 1, 1, 29, '2016-04-08', '2016-10-07', '2016-04-08', 'not-checked', 'notes3', '', 'Active'),
(4, 3, 1, 3, 26, '2016-04-01', '2016-07-01', '2016-04-01', 'not-checked', 'notes4', '', 'Active'),
(6, 3, 1, 3, 27, '2016-04-08', '2016-07-08', '2016-04-08', 'not-checked', 'notes5', 'Good', 'Active'),
(7, 3, 1, 3, 28, '2016-04-15', '2016-07-15', '2016-04-15', 'not-checked', 'notes6', '', 'Active'),
(8, 3, 1, 3, 29, '2016-04-22', '2016-07-22', '2016-04-22', 'not-checked', 'notes7', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment_sub_type`
--

CREATE TABLE IF NOT EXISTS `rims_equipment_sub_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_type_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`),
  KEY `equipment_type_id` (`equipment_type_id`),
  KEY `equipment_type_id_2` (`equipment_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Truncate table before insert `rims_equipment_sub_type`
--

TRUNCATE TABLE `rims_equipment_sub_type`;
--
-- Dumping data for table `rims_equipment_sub_type`
--

INSERT INTO `rims_equipment_sub_type` (`id`, `equipment_type_id`, `name`, `description`, `status`) VALUES
(1, 1, 'oil', 'desc', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment_task`
--

CREATE TABLE IF NOT EXISTS `rims_equipment_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_id` int(11) NOT NULL,
  `task` varchar(100) NOT NULL,
  `check_period` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `equipment_id_2` (`equipment_id`),
  KEY `equipment_id_3` (`equipment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Truncate table before insert `rims_equipment_task`
--

TRUNCATE TABLE `rims_equipment_task`;
--
-- Dumping data for table `rims_equipment_task`
--

INSERT INTO `rims_equipment_task` (`id`, `equipment_id`, `task`, `check_period`, `status`) VALUES
(1, 1, 'Clean up', 'Yearly', 'Active'),
(2, 1, 'check up monthly', '6 Months', 'Active'),
(3, 3, 'Wheel alignment', 'Quarterly', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment_type`
--

CREATE TABLE IF NOT EXISTS `rims_equipment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Truncate table before insert `rims_equipment_type`
--

TRUNCATE TABLE `rims_equipment_type`;
--
-- Dumping data for table `rims_equipment_type`
--

INSERT INTO `rims_equipment_type` (`id`, `name`, `description`, `status`) VALUES
(1, 'Fluid dispensing gun', 'desc', 'Active');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rims_equipments`
--
ALTER TABLE `rims_equipments`
  ADD CONSTRAINT `rims_equipments_ibfk_1` FOREIGN KEY (`equipment_type_id`) REFERENCES `rims_equipment_type` (`id`),
  ADD CONSTRAINT `rims_equipments_ibfk_2` FOREIGN KEY (`equipment_sub_type_id`) REFERENCES `rims_equipment_sub_type` (`id`);

--
-- Constraints for table `rims_equipment_branch`
--
ALTER TABLE `rims_equipment_branch`
  ADD CONSTRAINT `rims_equipment_branch_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `rims_branch` (`id`);

--
-- Constraints for table `rims_equipment_maintenance`
--
ALTER TABLE `rims_equipment_maintenance`
  ADD CONSTRAINT `rims_equipment_maintenance_ibfk_1` FOREIGN KEY (`equipment_task_id`) REFERENCES `rims_equipment_task` (`id`),
  ADD CONSTRAINT `rims_equipment_maintenance_ibfk_2` FOREIGN KEY (`equipment_branch_id`) REFERENCES `rims_equipment_branch` (`id`),
  ADD CONSTRAINT `rims_equipment_maintenance_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`),
  ADD CONSTRAINT `rims_equipment_maintenance_ibfk_4` FOREIGN KEY (`equipment_id`) REFERENCES `rims_equipments` (`id`);

--
-- Constraints for table `rims_equipment_sub_type`
--
ALTER TABLE `rims_equipment_sub_type`
  ADD CONSTRAINT `rims_equipment_sub_type_ibfk_1` FOREIGN KEY (`equipment_type_id`) REFERENCES `rims_equipment_type` (`id`);

--
-- Constraints for table `rims_equipment_task`
--
ALTER TABLE `rims_equipment_task`
  ADD CONSTRAINT `rims_equipment_task_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `rims_equipments` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
