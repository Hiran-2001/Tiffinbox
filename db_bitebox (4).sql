-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 06, 2025 at 05:25 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bitebox`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adminlogin`
--

DROP TABLE IF EXISTS `tbl_adminlogin`;
CREATE TABLE IF NOT EXISTS `tbl_adminlogin` (
  `loginid` INT NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`loginid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_adminlogin`
--

INSERT INTO `tbl_adminlogin` (`loginid`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

DROP TABLE IF EXISTS `tbl_category`;
CREATE TABLE IF NOT EXISTS `tbl_category` (
  `categoryid` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`categoryid`, `category_name`, `image`) VALUES
(7, 'mixed', 'mixed.jpg'),
(8, 'non veg2', 'mixed.jpg'),
(9, 'veg', 'mixed.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `customerid` int NOT NULL AUTO_INCREMENT,
  `customername` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `locationid` int NOT NULL,
  `contactno` bigint NOT NULL,
  `email` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `housename` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pincode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `landmark` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`customerid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customerid`, `customername`, `locationid`, `contactno`, `email`, `username`, `password`, `housename`, `pincode`, `landmark`) VALUES
(1, 'Anagha Reghukumar', 2, 9961480421, 'anaghareghukumar282@gmail', 'anu_anagha', 'annuanagha', '578', '689544', 'vengaloor to'),
(2, 'Ashiq eSalim', 2, 7632468732, 'ashiqesalim29@gamil.com', 'ashiqesalim', 'salimashiq', '703', '689544', 'vengaloor to'),
(3, 'Ashin Aji', 2, 9447820276, 'ashin@gmail.com', 'alen', '1', '703', '689544', 'vengaloor to');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deliveryaddress`
--

DROP TABLE IF EXISTS `tbl_deliveryaddress`;
CREATE TABLE IF NOT EXISTS `tbl_deliveryaddress` (
  `deliveryid` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `contact` BIGINT NOT NULL,
  `locationid` INT NOT NULL,
  `landmark` VARCHAR(50) NOT NULL,
  `houseno` VARCHAR(10) NOT NULL,
  `pincode` INT NOT NULL,
  `requestid` INT NOT NULL,
  PRIMARY KEY (`deliveryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- --------------------------------------------------------

--
-- Table structure for table `tbl_deliveryperson`
--

DROP TABLE IF EXISTS `tbl_deliveryperson`;
CREATE TABLE IF NOT EXISTS `tbl_deliveryperson` (
  `deliverypersonid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `phone` int NOT NULL,
  `email` varchar(40) NOT NULL,
  `districtid` int NOT NULL,
  `locationid` int NOT NULL,
  `landmark` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(8) NOT NULL,
  `houseno` int NOT NULL,
  `pincode` int NOT NULL,
  PRIMARY KEY (`deliverypersonid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_deliveryperson`
--

INSERT INTO `tbl_deliveryperson` (`deliverypersonid`, `name`, `phone`, `email`, `districtid`, `locationid`, `landmark`, `username`, `password`, `houseno`, `pincode`) VALUES
(1, 'ashish shoby', 2147483647, 'ashishshoby23@gmail.com', 1, 2, 'vengaloor town', 'ashishshoby', 'shoby23', 456, 786544);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

DROP TABLE IF EXISTS `tbl_district`;
CREATE TABLE IF NOT EXISTS `tbl_district` (
  `districtid` int NOT NULL AUTO_INCREMENT,
  `districtname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`districtid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_district`
--

INSERT INTO `tbl_district` (`districtid`, `districtname`) VALUES
(1, 'idukki'),
(3, 'Trissur'),
(4, 'kannur'),
(5, 'Eranakulam');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fooditem`
--

DROP TABLE IF EXISTS `tbl_fooditem`;
CREATE TABLE IF NOT EXISTS `tbl_fooditem` (
  `foodid` int NOT NULL AUTO_INCREMENT,
  `foodname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `categoryid` int NOT NULL,
  `mealtypeid` int NOT NULL,
  PRIMARY KEY (`foodid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_fooditem`
--

INSERT INTO `tbl_fooditem` (`foodid`, `foodname`, `image`, `price`, `categoryid`, `mealtypeid`) VALUES
(3, 'mushroom noodles', 'mushroom noodle.jpg', 280, 9, 3),
(4, 'Masala Dosa', 'masala dosa.jpg', 90, 9, 1),
(5, 'Puttu and Kadala', 'puttu and kadala.jpg', 80, 9, 1),
(6, 'Veg Biriyani', 'veg biriyani.jpg', 140, 9, 2),
(7, 'Mushroom rice', 'mushroom rice.jpg', 180, 9, 2),
(8, 'Aaloo paratta', 'aaloo paratta.jpg', 120, 9, 3),
(9, 'Veg noodle', 'veg noodle.jpg', 135, 9, 3),
(10, 'Poori and Potato curry', 'poori and potato curry.jpg', 70, 8, 1),
(11, 'Puttu and kadala', 'puttu and kadala.jpg', 80, 8, 1),
(12, 'Butter chicken and garlic naan', 'butter chicken and garlic naan.jpg', 240, 8, 2),
(13, 'Biriyani', 'nonveg.jpg', 140, 8, 2),
(14, 'Chicken noodles', 'chicken noodles.jpg', 150, 8, 3),
(15, 'Chappathi and egg curry', 'chappathi and curry.jpg', 80, 8, 3),
(24, 'appam', 'appam and steew.jpg', 80, 7, 1),
(25, 'appam', 'appam and steew.jpg', 80, 7, 1),
(26, 'Biriyani', 'nonveg.jpg', 170, 7, 2),
(27, 'pasta with bread', 'Pasta with bread.jpg', 200, 7, 0),
(28, 'Appam and Eggcurry', 'project-3.jpg', 50, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

DROP TABLE IF EXISTS `tbl_location`;
CREATE TABLE IF NOT EXISTS `tbl_location` (
  `locationid` int NOT NULL AUTO_INCREMENT,
  `locationname` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `districtid` int NOT NULL,
  PRIMARY KEY (`locationid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`locationid`, `locationname`, `districtid`) VALUES
(2, 'Vengalloor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mealplandetails`
--

DROP TABLE IF EXISTS `tbl_mealplandetails`;
CREATE TABLE IF NOT EXISTS `tbl_mealplandetails` (
  `detailsid` int NOT NULL AUTO_INCREMENT,
  `mealtypeid` int NOT NULL,
  `foodid` int NOT NULL,
  `daynum` int NOT NULL,
  `subscriptionid` int NOT NULL,
  PRIMARY KEY (`detailsid`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mealplandetails`
--

INSERT INTO `tbl_mealplandetails` (`detailsid`, `mealtypeid`, `foodid`, `daynum`, `subscriptionid`) VALUES
(1, 1, 10, 1, 1),
(2, 2, 12, 1, 1),
(6, 3, 14, 2, 1),
(32, 1, 10, 1, 1),
(33, 2, 12, 1, 1),
(34, 3, 15, 1, 1),
(35, 1, 11, 2, 1),
(36, 2, 12, 2, 1),
(37, 3, 14, 2, 1),
(38, 1, 24, 3, 6),
(39, 2, 26, 3, 6),
(40, 3, 0, 3, 6),
(41, 1, 4, 3, 7),
(42, 2, 6, 3, 7),
(43, 3, 3, 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mealtype`
--

DROP TABLE IF EXISTS `tbl_mealtype`;
CREATE TABLE IF NOT EXISTS `tbl_mealtype` (
  `mealtypeid` int NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`mealtypeid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mealtype`
--

INSERT INTO `tbl_mealtype` (`mealtypeid`, `typename`, `photo`) VALUES
(1, 'Breakfast', 'Beefroast.jpg'),
(2, 'Lunch', 'Beefroast.jpg'),
(3, 'Dinner', 'Beefroast.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

DROP TABLE IF EXISTS `tbl_payment`;
CREATE TABLE IF NOT EXISTS `tbl_payment` (
  `paymentid` int NOT NULL AUTO_INCREMENT,
  `paymentdate` date NOT NULL,
  `amount` int NOT NULL,
  `requestid` int NOT NULL,
  `status` varchar(80) NOT NULL,
  `customerid` int NOT NULL,
  PRIMARY KEY (`paymentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`paymentid`, `paymentdate`, `amount`, `requestid`, `status`, `customerid`) VALUES
(1, '2025-09-15', 457, 11, '0', 2),
(2, '2025-09-15', 457, 10, 'Paid', 2),
(3, '2025-10-06', 5000, 20, 'Paid', 2),
(4, '2025-10-06', 5000, 19, 'Paid', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request`
--

DROP TABLE IF EXISTS `tbl_request`;
CREATE TABLE IF NOT EXISTS `tbl_request` (
  `requestid` int NOT NULL AUTO_INCREMENT,
  `customerid` int NOT NULL,
  `subscriptionid` int NOT NULL,
  `date` int NOT NULL,
  `startdate` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `delivarypersonid` int DEFAULT NULL,
  PRIMARY KEY (`requestid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_request`
--

INSERT INTO `tbl_request` (`requestid`, `customerid`, `subscriptionid`, `date`, `startdate`, `status`, `delivarypersonid`) VALUES
(20, 2, 1, 2025, '2025-10-15', 'Paid', NULL),
(10, 2, 1, 2025, '2025-09-24', 'Paid', NULL),
(11, 2, 4, 2025, '2025-09-21', 'accepted', NULL),
(19, 2, 1, 2025, '2025-10-08', 'Paid', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscription`
--

DROP TABLE IF EXISTS `tbl_subscription`;
CREATE TABLE IF NOT EXISTS `tbl_subscription` (
  `subscriptionid` int NOT NULL AUTO_INCREMENT,
  `subname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `day` decimal(10,0) NOT NULL,
  `amount` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `categoryid` int NOT NULL,
  `image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`subscriptionid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subscription`
--

INSERT INTO `tbl_subscription` (`subscriptionid`, `subname`, `day`, `amount`, `description`, `categoryid`, `image`) VALUES
(1, 'Gold', 1, 5000, 'you will recive good quality food at your door step', 8, 'Italy.jpg'),
(4, 'Platinum', 1, 2500, 'In this silver plan we provide medium quantity food and you can customize your meal as per your need', 8, 'nonveg.webp'),
(5, 'Normal', 2, 500, 'Normal diet plan', 8, ''),
(6, 'Mixed', 2, 2000, 'Mixed food plan with veg and non veg items', 7, ''),
(7, 'Daily', 3, 500, 'A well balanced diet plan', 9, 'butter chicken and garlic naan.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
