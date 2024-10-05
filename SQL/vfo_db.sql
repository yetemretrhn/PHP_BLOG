-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 03:51 AM
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
-- Database: `vfo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'furkan', '123');

-- --------------------------------------------------------

--
-- Table structure for table `iletisim`
--

CREATE TABLE `iletisim` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mesaj` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `iletisim`
--

INSERT INTO `iletisim` (`id`, `ad`, `email`, `mesaj`, `tarih`) VALUES
(1, 'ee', 'eee@gmaasdsad', 'eee', '2024-10-04 18:36:15'),
(2, 'ee', 'eee@gmaasdsad', 'eee', '2024-10-04 18:36:26'),
(3, 'wadawd', 'awdaw@awdawdaw', 'awdawdawd', '2024-10-04 18:53:15'),
(4, 'dwada', 'awdawd@dawdaw', 'awdawd', '2024-10-04 21:01:15');

-- --------------------------------------------------------

--
-- Table structure for table `kullanici`
--

CREATE TABLE `kullanici` (
  `id` int(11) NOT NULL,
  `isim` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kullanici`
--

INSERT INTO `kullanici` (`id`, `isim`, `email`, `sifre`, `tarih`) VALUES
(3, 'Veli Furkan Özdemir', 'vfo@gmail.com', '123123', '2024-10-04 21:47:57'),
(4, 'veli furkan özdemir', 'vfoo@gmail.com', '123', '2024-10-04 21:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `icerik` mediumtext NOT NULL,
  `resim` varchar(255) NOT NULL,
  `yazar` varchar(255) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `baslik`, `icerik`, `resim`, `yazar`, `tarih`) VALUES
(2, 'Self-driving cars', 'We survey research on self-driving cars published in the literature focusing on autonomous cars developed since the DARPA challenges, which are equipped with an autonomy system that can be categorized as SAE level 3 or higher. The architecture of the autonomy system of self-driving cars is typically organized into the perception system and the decision-making system. The perception system is generally divided into many subsystems responsible for tasks such as self-driving-car localization, static obstacles mapping, moving obstacles detection and tracking, road mapping, traffic signalization detection and recognition, among others. The decision-making system is commonly partitioned as well into many subsystems responsible for tasks such as route planning, path planning, behavior selection, motion planning, and control. In this survey, we present the typical architecture of the autonomy system of self-driving cars. We also review research on relevant methods for perception and decision making. Furthermore, we present a detailed description of the architecture of the autonomy system of the self-driving car developed at the Universidade Federal do Espírito Santo (UFES), named Intelligent Autonomous Robotics Automobile (IARA). Finally, we list prominent self-driving car research platforms developed by academia and technology companies, and reported in the media.', 'background.jpg', 'emre', '2024-10-04 18:24:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `iletisim`
--
ALTER TABLE `iletisim`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `iletisim`
--
ALTER TABLE `iletisim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
