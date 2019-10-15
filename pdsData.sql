-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 08, 2019 at 12:54 PM
-- Server version: 8.0.17
-- PHP Version: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pdsData`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parcelID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customerID` int(11) NOT NULL,
  `parcelName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiverName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `receiverAddress` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `receiverPhone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `parcelStatus` tinyint(1) NOT NULL DEFAULT '1',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bookings`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contactNo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--
DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastKnowPosition` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `firstName`, `lastName`, `lastKnowPosition`, `status`) VALUES
(15, 'Driver Test', 'Test', NULL, 0),
(20, 'Driver', 'A', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--
DROP TABLE IF EXISTS `inbox`;
CREATE TABLE IF NOT EXISTS `inbox` (
  `parcelID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `remark` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `customerID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `parcelID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `invoiceID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customerID` int(11) NOT NULL,
  `costAmount` decimal(10,0) NOT NULL DEFAULT '0',
  `gstAmount` decimal(10,0) NOT NULL DEFAULT '0',
  `deliveryAmount` decimal(10,0) NOT NULL DEFAULT '0',
  `settle` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoices`
--

-- --------------------------------------------------------

--
-- Table structure for table `parcel_location`
--
DROP TABLE IF EXISTS `parcel_location`;
CREATE TABLE IF NOT EXISTS `parcel_location` (
  `parcelID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `info` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parcel_location`
--

-- --------------------------------------------------------

--
-- Table structure for table `parcel_status`
--
DROP TABLE IF EXISTS `parcel_status`;
CREATE TABLE IF NOT EXISTS `parcel_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parcel_status`
--

INSERT INTO `parcel_status` (`id`, `status`) VALUES
(1, 'pending'),
(2, 'picked up'),
(3, 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--
DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `invoiceID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cardName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cardNum` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cardExp` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cardCVV` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment`
--

-- --------------------------------------------------------

--
-- Table structure for table `report`
--
DROP TABLE IF EXISTS `report`;
CREATE TABLE IF NOT EXISTS `report` (
  `driverID` int(11) NOT NULL,
  `report` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `report`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `parcelID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customerID` int(11) NOT NULL,
  `driverID` int(11) NOT NULL,
  `pickedDate` timestamp NULL DEFAULT NULL,
  `deliveredDate` timestamp NULL DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tasks`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_customer` tinyint(1) NOT NULL DEFAULT '1',
  `is_driver` tinyint(1) NOT NULL DEFAULT '0',
  `is_manager` int(11) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_customer`, `is_driver`, `is_manager`, `is_admin`) VALUES
(1, 'manager@t.com', '$2y$10$RjjFtMrMIGFsvELT6qZDFuGe6ehAe3/Kxmjnj7rMJichQsG0cBDXG', 0, 0, 1, 0),
(15, 'driver@t.com', '$2y$10$RjjFtMrMIGFsvELT6qZDFuGe6ehAe3/Kxmjnj7rMJichQsG0cBDXG', 0, 1, 0, 0),
(20, 'driverA@test.com', '$2y$10$FRl3LV9WuEGSFOb0r6U9V.1lk7LOE5tLpWpjx213/SmhK2ifNDiTK', 0, 1, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
