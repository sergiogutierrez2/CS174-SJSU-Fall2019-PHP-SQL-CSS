-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2019 at 08:16 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: 'antivirus'
--

-- --------------------------------------------------------

--
-- Table structure for table 'admin'
--

CREATE TABLE 'admin' (
  'id' int(11) NOT NULL,
  'username' varchar(50) NOT NULL,
  'password' varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table 'admin'
--

INSERT INTO 'admin' ('id', 'username', 'password') VALUES
(1, 'admin1', '0f84138dd4bc2114a8750963895ddb25'),
(2, 'admin2', 'e1390af5e52ad37a443ec49e06f9a8b7');

-- --------------------------------------------------------

--
-- Table structure for table 'malware'
--

CREATE TABLE 'malware' (
  'id' int(11) NOT NULL,
  'name' varchar(50) NOT NULL,
  'bytes' varchar(50) NOT NULL,
  'malware_type_id' int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table 'malware'
--

INSERT INTO 'malware' ('id', 'name', 'bytes', 'malware_type_id') VALUES
(1, 'Virus 1', '%PDF-1.5\\r\\n%µµµµ\\r\\n1 0', 1),
(3, 'Altered Images 2', 'ÿØÿà\\0JFIF\\0\\0'\\0'\\0\\0', 2);

-- --------------------------------------------------------

--
-- Table structure for table 'malware_type'
--

CREATE TABLE 'malware_type' (
  'id' int(11) NOT NULL,
  'name' varchar(50) NOT NULL,
  'desc' varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table 'malware_type'
--

INSERT INTO 'malware_type' ('id', 'name', 'desc') VALUES
(1, 'Infected File', 'It is a File that contains a Virus.'),
(2, 'Putative Infected File', 'It is a File that might contain the Virus and needs to go under analysis.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table 'admin'
--
ALTER TABLE 'admin'
  ADD PRIMARY KEY ('id'),
  ADD UNIQUE KEY 'username' ('username');

--
-- Indexes for table 'malware'
--
ALTER TABLE 'malware'
  ADD PRIMARY KEY ('id'),
  ADD UNIQUE KEY 'name' ('name'),
  ADD KEY 'bytes' ('bytes');

--
-- Indexes for table 'malware_type'
--
ALTER TABLE 'malware_type'
  ADD PRIMARY KEY ('id'),
  ADD UNIQUE KEY 'name' ('name');

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table 'admin'
--
ALTER TABLE 'admin'
  MODIFY 'id' int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table 'malware'
--
ALTER TABLE 'malware'
  MODIFY 'id' int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table 'malware_type'
--
ALTER TABLE 'malware_type'
  MODIFY 'id' int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
