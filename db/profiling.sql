-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2022 at 06:31 AM
-- Server version: 5.7.36
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `profiling`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_created` varchar(100) NOT NULL,
  `hashpass` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `fullname`, `role`, `status`, `date_created`, `hashpass`) VALUES
(3, 'admin', 'admin', 'admin', 'admin', 'Active', '2021-01-06', ''),
(12, 'Franklin', 'Lanoy123', 'John Franklin Lanoy', 'Employee', 'Active', '2022-06-22', ''),
(13, 'qwerty123', 'bppbms123', 'Mechelle', 'Employee', 'Active', '2022-06-25', '827ccb0eea8a706c4c34a16891f84e7b'),
(14, 'Jaime123', 'bppbms123', 'Jaime Diamante Jr.', 'Employee', 'Active', '2022-06-25', ''),
(15, 'Josh535', 'bppbms123', 'Josh Enzo Esmail', 'Employee', 'Active', '2022-06-25', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

DROP TABLE IF EXISTS `archive`;
CREATE TABLE IF NOT EXISTS `archive` (
  `resident_id` varchar(200) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `bdate` varchar(100) NOT NULL,
  `age` int(20) NOT NULL,
  `sex` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `citizenship` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `cont_no` varchar(20) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  PRIMARY KEY (`resident_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blotter`
--

DROP TABLE IF EXISTS `blotter`;
CREATE TABLE IF NOT EXISTS `blotter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resident_id` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `age` int(12) NOT NULL,
  `violation` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `complainant` varchar(50) NOT NULL,
  `date_issued` varchar(100) NOT NULL,
  `officer_incharge` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

DROP TABLE IF EXISTS `certificate`;
CREATE TABLE IF NOT EXISTS `certificate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate` varchar(100) NOT NULL,
  `amount` double(50,2) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`id`, `certificate`, `amount`, `status`) VALUES
(5, 'Barangay Clearance', 350.00, 1),
(2, 'Indigency', 100.00, 1),
(3, 'Business Clearance', 500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clearance`
--

DROP TABLE IF EXISTS `clearance`;
CREATE TABLE IF NOT EXISTS `clearance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `civilstatus` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `clearance_type` varchar(100) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `bname` varchar(100) NOT NULL,
  `qty` int(20) NOT NULL,
  `amount` double(50,2) NOT NULL,
  `total` double(50,2) NOT NULL,
  `date_issued` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `official`
--

DROP TABLE IF EXISTS `official`;
CREATE TABLE IF NOT EXISTS `official` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `date_elected` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `official`
--

INSERT INTO `official` (`id`, `firstname`, `middlename`, `lastname`, `position`, `date_elected`) VALUES
(20, 'John Franklin', 'Magallen', 'Lanoy', 'Barangay Captain', '01/06/2021'),
(42, 'Ile Nathaniel', 'Norcos', 'Flores', 'SK Chairman', '01/21/2021'),
(43, 'Eddie', 'Mangunlay', 'Alcazar', 'Barangay Secretary', '01/29/2021'),
(44, 'Jay', 'Bago', 'Ramirez', 'Barangay Treasurer', '01/21/2021'),
(45, 'Jaime', 'Mandalejo', 'Diamante', 'Barangay Kagawad', '01/29/2021'),
(46, 'Cristian', 'Dela Pena', 'Aranas', 'Barangay Kagawad', '01/21/2021'),
(47, 'Bart', 'Yudi', 'Batiancila', 'Barangay Kagawad', '01/29/2021'),
(48, 'Myrine', 'Tumbiga', 'Rizaba', 'Barangay Kagawad', '01/21/2021'),
(49, 'Jon Rex', 'Chupapoy', 'Lumbra', 'Barangay Kagawad', '01/21/2021'),
(50, 'Cyril', 'Erpa', 'Tulod', 'Barangay Kagawad', '01/04/2021'),
(51, 'Jay', 'Pisa', 'Ramirez', 'Barangay Kagawad', '01/14/2021');

-- --------------------------------------------------------

--
-- Table structure for table `purok`
--

DROP TABLE IF EXISTS `purok`;
CREATE TABLE IF NOT EXISTS `purok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purok` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purok`
--

INSERT INTO `purok` (`id`, `purok`) VALUES
(6, 'RaÃ±ada'),
(2, 'Jamilla'),
(11, 'Malabarbas'),
(9, 'Tuazon'),
(10, 'Citizen'),
(12, 'Docci'),
(13, 'Bagong Silang');

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

DROP TABLE IF EXISTS `resident`;
CREATE TABLE IF NOT EXISTS `resident` (
  `resident_id` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `suffix` varchar(10) NOT NULL,
  `bdate` varchar(20) NOT NULL,
  `age` int(10) NOT NULL,
  `sex` varchar(20) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `citizenship` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `cont_no` varchar(50) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  PRIMARY KEY (`resident_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`resident_id`, `fname`, `mname`, `lname`, `suffix`, `bdate`, `age`, `sex`, `religion`, `citizenship`, `status`, `occupation`, `cont_no`, `purok`, `address`, `fullname`) VALUES
('1234-114', 'Cedie', 'Espera', 'Gabriel', '', '02/14/1996', 24, 'Male', 'Roman Catholic', 'Filipino', 'Single', 'Teacher', '09486549878', 'RaÃ±ada', 'Barangay Poblacion, Polomolok, South Cotabato', 'Gabriel Cedie Espera '),
('1234-111', 'Josh Enzo', 'Bastareche', 'Esmail', '', '12/20/1999', 22, 'Male', 'Roman Catholic', 'Filipino', 'Single', 'Collector', '09486532165', 'RaÃ±ada', 'Barangay Poblacion, Polomolok, South Cotabato', 'Esmail Josh Enzo Bastareche '),
('1234-112', 'Jaime', 'Mandalejo', 'Diamante', 'Jr', '02/11/1998', 23, 'Male', 'Roman Catholic', 'Filipino', 'Single', 'Doctor', '09663548754', 'Docci', 'Barangay Poblacion, Polomolok, South Cotabato', 'Diamante Jaime Mandalejo Jr'),
('1234-001', 'Jay', 'Bag-o', 'Ramirez', '', '06/01/2000', 20, 'Male', 'Roman Catholic', 'Filipino', 'Single', 'Cashier', '09104898752', 'RaÃ±ada', 'Barangay Poblacion, Polomolok, South Cotabato', 'Ramirez Jay Bag-o '),
('1234-003', 'Cyril', 'Erpa', 'Tulod', 'Jr', '02/12/1998', 23, 'Male', 'Roman Catholic', 'Filipino', 'Single', 'Founder sa SADBOI', '09104898752', 'RaÃ±ada', 'Barangay Poblacion, Polomolok, South Cotabato', 'Tulod Cyril Erpa Jr'),
('1234-002', 'Cristian', 'Dela Pena', 'Aranas', '', '02/12/1997', 24, 'Male', 'Roman Catholic', 'Filipino', 'Single', 'STL', '09104898752', 'Tuazon', 'Barangay Poblacion, Polomolok, South Cotabato', 'Aranas Cristian Dela Pena ');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
