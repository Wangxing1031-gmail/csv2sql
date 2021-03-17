-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2021 at 03:01 PM
-- Server version: 5.5.65-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trialpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `Database_garage-door-repair`
--

CREATE TABLE `Database_garage-door-repair` (
  `ID` int(6) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Full_Address` varchar(200) NOT NULL,
  `Street_Address` varchar(150) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(20) NOT NULL,
  `Zip` varchar(20) NOT NULL,
  `Plus_Code` varchar(250) NOT NULL,
  `Website` varchar(250) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Email` varchar(125) NOT NULL,
  `Facebook` varchar(200) NOT NULL,
  `Twitter` varchar(200) NOT NULL,
  `Instagram` varchar(200) NOT NULL,
  `Lat` varchar(60) NOT NULL,
  `Lng` varchar(60) NOT NULL,
  `Category` varchar(60) NOT NULL,
  `Rating` decimal(2,1) NOT NULL,
  `Reviews` int(6) NOT NULL,
  `Top_Image_URL` varchar(250) NOT NULL,
  `Sub_Title` varchar(50) NOT NULL,
  `Monday` varchar(50) NOT NULL,
  `Tuesday` varchar(50) NOT NULL,
  `Wednesday` varchar(50) NOT NULL,
  `Thursday` varchar(50) NOT NULL,
  `Friday` varchar(50) NOT NULL,
  `Saturday` varchar(50) NOT NULL,
  `Sunday` varchar(50) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `verified` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Database_garage-door-repair`
--
ALTER TABLE `Database_garage-door-repair`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Database_garage-door-repair`
--
ALTER TABLE `Database_garage-door-repair`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
