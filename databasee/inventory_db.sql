-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 26, 2025 at 11:19 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `no` varchar(50) NOT NULL,
  `code_item` varchar(10) NOT NULL,
  `category` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `stock` int(11) DEFAULT '0',
  `created_by` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `no`, `code_item`, `category`, `item_name`, `stock`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'DEV/20250826/0001', 'CLT', 'Clothes', 'Baju Lengan Panjang', 20, 'Admin', '2025-08-26 09:11:22', '2025-08-26 11:09:09'),
(2, 'DEV/20250826/0002', 'SND', 'Single Clothes', 'Baju Lengan Pendek', 75, 'Admin', '2025-08-26 09:16:14', '2025-08-26 10:48:55'),
(3, 'DEV/20250826/0003', 'CN', 'Double Clothes', 'Celana Panjang', 800, 'Admin', '2025-08-26 09:40:22', '2025-08-26 10:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

CREATE TABLE `stock_history` (
  `id` int(11) NOT NULL,
  `type` enum('IN','OUT') NOT NULL,
  `category` varchar(100) NOT NULL,
  `code_item` varchar(50) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_history`
--

INSERT INTO `stock_history` (`id`, `type`, `category`, `code_item`, `item_name`, `qty`, `created_by`, `created_at`) VALUES
(1, 'IN', 'Clothes', 'CLT', 'Baju Lengan Panjang', 20, 'Admin', '2025-08-26 03:32:52'),
(2, 'IN', 'Single Clothes', 'SND', 'Baju Lengan Pendek', 5, 'Admin', '2025-08-26 03:34:50'),
(3, 'IN', 'Double Clothes', 'CN', 'Celana Panjang', 10, 'Admin', '2025-08-26 03:35:04'),
(4, 'OUT', 'Clothes', 'CLT', 'Baju Lengan Panjang', 10, 'Admin', '2025-08-26 03:48:37'),
(5, 'OUT', 'Single Clothes', 'SND', 'Baju Lengan Pendek', 5, 'Admin', '2025-08-26 03:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `stock_in`
--

CREATE TABLE `stock_in` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `code_item` varchar(50) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `qty_in` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_in`
--

INSERT INTO `stock_in` (`id`, `category`, `code_item`, `item_name`, `qty_in`, `created_by`, `created_at`) VALUES
(1, '', 'CLT', 'Baju Lengan Panjang', 20, 'Admin', '2025-08-26 10:32:52'),
(2, '', 'SND', 'Baju Lengan Pendek', 5, 'Admin', '2025-08-26 10:34:50'),
(3, '', 'CN', 'Celana Panjang', 10, 'Admin', '2025-08-26 10:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `stock_out`
--

CREATE TABLE `stock_out` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `code_item` varchar(50) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `qty_out` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_out`
--

INSERT INTO `stock_out` (`id`, `category`, `code_item`, `item_name`, `qty_out`, `created_by`, `created_at`) VALUES
(1, '', 'CLT', 'Baju Lengan Panjang', 10, 'Admin', '2025-08-26 10:48:37'),
(2, '', 'SND', 'Baju Lengan Pendek', 5, 'Admin', '2025-08-26 10:48:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_out`
--
ALTER TABLE `stock_out`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_in`
--
ALTER TABLE `stock_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_out`
--
ALTER TABLE `stock_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
