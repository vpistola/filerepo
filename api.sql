-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 08, 2021 at 01:15 PM
-- Server version: 5.7.35
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- Table structure for table `Data`
--

CREATE TABLE `Data` (
  `Id` int(11) NOT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Description` text,
  `3durl1` text,
  `3durl2` text NOT NULL,
  `AdditionalInfoUrl` text,
  `Option1` varchar(30) DEFAULT NULL,
  `Option2` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Data`
--

INSERT INTO `Data` (`Id`, `Title`, `Description`, `3durl1`, `3durl2`, `AdditionalInfoUrl`, `Option1`, `Option2`) VALUES
(6, 'ww', 'wwaffdasgfsdfsdf', 'ww', 'ww', 'ww', '1', '1'),
(7, 'ww', 'ww', 'ww', 'ww', 'ww', '2', '1'),
(8, 'ww', 'ww', 'ww', 'ww', 'ww', '2', '2'),
(9, 'rr', 'rr', 'rr', 'rr', 'rr', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `DataFiles`
--

CREATE TABLE `DataFiles` (
  `Id` int(11) NOT NULL,
  `DataId` int(11) NOT NULL,
  `TypeId` int(11) NOT NULL,
  `JsonData` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DataFiles`
--

INSERT INTO `DataFiles` (`Id`, `DataId`, `TypeId`, `JsonData`) VALUES
(9, 6, 1, 'uploads/declaration.pdf'),
(10, 6, 2, 'uploads/disease_classification.jpg'),
(11, 7, 1, 'uploads/1.docx'),
(12, 8, 1, 'uploads/1.docx'),
(13, 9, 1, 'uploads/t.docx'),
(16, 6, 1, 'uploads/aromatika.docx');

-- --------------------------------------------------------

--
-- Table structure for table `FileType`
--

CREATE TABLE `FileType` (
  `Id` int(11) NOT NULL,
  `Description` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `FileType`
--

INSERT INTO `FileType` (`Id`, `Description`) VALUES
(1, 'pdf, doc and docx'),
(2, 'jpg and png');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`Id`, `Username`, `Password`) VALUES
(1, 'User1', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Data`
--
ALTER TABLE `Data`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `DataFiles`
--
ALTER TABLE `DataFiles`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_data_id` (`DataId`),
  ADD KEY `fk_filetype_id` (`TypeId`);

--
-- Indexes for table `FileType`
--
ALTER TABLE `FileType`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Data`
--
ALTER TABLE `Data`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `DataFiles`
--
ALTER TABLE `DataFiles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `FileType`
--
ALTER TABLE `FileType`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `DataFiles`
--
ALTER TABLE `DataFiles`
  ADD CONSTRAINT `fk_data_id` FOREIGN KEY (`DataId`) REFERENCES `Data` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_filetype_id` FOREIGN KEY (`TypeId`) REFERENCES `FileType` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
