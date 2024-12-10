-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 05:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iii`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(5) NOT NULL,
  `UserName` char(45) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ShopOwnerName` varchar(255) DEFAULT NULL,
  `ShopName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`, `UpdationDate`, `ShopOwnerName`, `ShopName`) VALUES
(3, '21012021038', 8849097364, 'heetkakdiya567@gmail.com', 'c40c2a5d7311636ce1cb3f7720ed058f', '2024-09-11 05:34:05', '2024-09-17 07:35:34', ' Heet', 'HK');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `CategoryName` varchar(200) DEFAULT NULL,
  `CategoryCode` varchar(255) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `userID`, `CategoryName`, `CategoryCode`, `PostingDate`) VALUES
(1, 3, 'biscuuit', '7', '2024-10-12 16:16:03'),
(3, 3, 'wafer', 'W', '2024-10-14 15:28:46');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `CompanyName` varchar(150) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `userID`, `CompanyName`, `PostingDate`) VALUES
(1, 3, 'poc', '2024-10-12 16:24:31'),
(3, 3, 'Balagi', '2024-10-14 15:29:10'),
(4, 3, 'Lays', '2024-10-14 15:29:15');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `InvoiceNumber` int(11) DEFAULT NULL,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerContactNo` bigint(12) DEFAULT NULL,
  `PaymentMode` varchar(100) DEFAULT NULL,
  `InvoiceGenDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userID`, `ProductId`, `Quantity`, `InvoiceNumber`, `CustomerName`, `CustomerContactNo`, `PaymentMode`, `InvoiceGenDate`) VALUES
(1, 3, 2, 50, 929752167, 'Vivek', 7410852963, 'cash', '2024-10-12 16:49:09'),
(2, 3, 3, 5, 148494663, 'heet', 231456987, 'cash', '2024-10-12 16:53:49'),
(3, 3, 2, 21, 152790228, 'ROSE', 7896541230, 'cash', '2024-10-12 17:04:41'),
(4, 3, 2, 1, 871412383, 'Vivek', 7418529630, 'cash', '2024-10-12 17:09:46'),
(5, 3, 4, 50, 873976590, 'Heet', 8956230147, 'cash', '2024-10-14 15:31:37'),
(6, 3, 5, 50, 282203040, 'meet', 4561237890, 'cash', '2024-10-14 15:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `SubCategoryName` varchar(255) DEFAULT NULL,
  `CompanyName` varchar(150) DEFAULT NULL,
  `ProductName` varchar(150) DEFAULT NULL,
  `ProductPrice` decimal(10,0) DEFAULT current_timestamp(),
  `ExpiryDate` datetime DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `userID`, `CategoryName`, `SubCategoryName`, `CompanyName`, `ProductName`, `ProductPrice`, `ExpiryDate`, `Stock`, `PostingDate`, `UpdationDate`) VALUES
(2, 3, 'normal', 'normal', 'poc', 'T', 35, '2024-10-19 00:00:00', 8, '2024-10-12 17:09:46', '2024-10-12 17:09:46'),
(3, 3, 'normal', 'normal', 'poc', 'T', 3500, '2024-10-25 00:00:00', 0, '2024-10-12 16:53:49', '2024-10-12 16:53:49'),
(4, 3, 'wafer', 'Salted Wafer', 'Balagi', 'salted wafer', 10, '2024-10-30 00:00:00', 50, '2024-10-14 15:31:37', '2024-10-14 15:31:37'),
(5, 3, 'wafer', 'Masala Wafer', 'Lays', 'masala wafer', 10, NULL, 50, '2024-10-14 15:34:26', '2024-10-14 15:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `category_code` varchar(255) DEFAULT NULL,
  `sub_category_code` varchar(255) DEFAULT NULL,
  `sub_category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `userID`, `category_code`, `sub_category_code`, `sub_category_name`) VALUES
(1, 3, 'M', 'AM', 'normal'),
(2, 3, 'M', 'AM', 'normal'),
(3, 3, 'W', 'SW', 'Salted Wafer'),
(4, 3, 'W', 'MW', 'Masala Wafer'),
(5, 3, 'W', 'TW', 'Tometo Wafer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
