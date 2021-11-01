-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2021 at 07:27 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ess`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `token` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `token`) VALUES
(1, 'Mashood', 'mashood@gmail.com', '123456', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `Balance` float DEFAULT 0,
  `merchant_id` int(11) NOT NULL,
  `payment_time` date DEFAULT current_timestamp(),
  `C_D` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `Balance`, `merchant_id`, `payment_time`, `C_D`) VALUES
(1, 99.6088, 4, '2021-10-25', 0),
(2, 99.5599, 4, '2021-10-25', 0),
(5, 99.511, 4, '2021-10-25', 0),
(6, 99.4621, 4, '2021-10-26', 0),
(7, 99.4621, 4, '2021-10-26', 0),
(10, 99.4132, 4, '2021-10-26', 0),
(11, 99.3643, 4, '2021-10-26', 0),
(12, 99.3154, 4, '2021-10-26', 0),
(14, 99.2665, 4, '2021-10-26', 0),
(15, 99.2176, 4, '2021-10-26', 0),
(16, 99.1687, 4, '2021-10-26', 0),
(17, 99.1198, 4, '2021-10-26', 0),
(22, 149.12, 4, '2021-10-27', 1),
(23, 199.12, 4, '2021-10-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `credit` float DEFAULT 100,
  `token` varchar(512) DEFAULT NULL,
  `charged_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`id`, `name`, `email`, `password`, `credit`, `token`, `charged_id`) VALUES
(1, 'dawood', 'dawood@gmail.com', '123456', 100, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcLyIsImF1ZCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvIiwiaWF0IjoxNjM0OTk5MjU3LCJleHAiOjE2MzUwMDI4NTcsImRhdGEiOnsiZW1haWwiOiJkYXdvb2RAZ21haWwuY29tIiwicGFzc3dvcmQiOiIxMjM0NTYifX0.xASXnFKUJWZ-wrE-_LIwSjcdoEwiAbuRh5CpZUk_S7s', NULL),
(2, 'humza', 'humza@gmail.com', '123456', 100, NULL, NULL),
(4, 'nasir', 'iamkaithebest@gmail.com', '123456', 50, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcLyIsImF1ZCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvIiwiaWF0IjoxNjM1MzMwOTIyLCJleHAiOjE2MzUzMzQ1MjIsImRhdGEiOnsiaWQiOiI0IiwibmFtZSI6Im5hc2lyIiwiZW1haWwiOiJpYW1rYWl0aGViZXN0QGdtYWlsLmNvbSIsInBhc3N3b3JkIjoiMTIzNDU2IiwiY3JlZGl0IjoiMTQ5LjEyIn19.dHwOoFhGErmzCOoaQksnmT5f6qHxl8he8bxswSeN4Kc', 'ch_3Jp9TrEHteAtQ3Yh1RaZNg5t');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `from_email` varchar(50) NOT NULL,
  `to_email` varchar(50) NOT NULL,
  `cc` varchar(50) DEFAULT NULL,
  `bcc` varchar(50) DEFAULT NULL,
  `subject` varchar(50) DEFAULT NULL,
  `body` varchar(50) NOT NULL,
  `merchant_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `from_email`, `to_email`, `cc`, `bcc`, `subject`, `body`, `merchant_id`) VALUES
(26, 'iamkaithebest@gmail.com', 'iamkaithebest@gmail.com', 'hkhurshid95@gmail.com', NULL, 'MAIL JET', 'USING MAIL JET TO SEND MAIL!!!', 4),
(28, 'iamkaithebest@gmail.com', 'iamkaithebest@gmail.com', 'hkhurshid95@gmail.com', NULL, 'MAIL JET', 'USING MAIL JET TO SEND MAIL!!!', 4),
(29, 'iamkaithebest@gmail.com', 'iamkaithebest@gmail.com', 'hkhurshid95@gmail.com', NULL, 'MAIL JET', 'USING MAIL JET TO SEND MAIL!!!', 4),
(30, 'iamkaithebest@gmail.com', 'iamkaithebest@gmail.com', 'hkhurshid95@gmail.com', NULL, 'MAIL JET', 'USING MAIL JET TO SEND MAIL!!!', 4),
(31, 'iamkaithebest@gmail.com', 'iamkaithebest@gmail.com', 'hkhurshid95@gmail.com', NULL, 'MAIL JET', 'USING MAIL JET TO SEND MAIL!!!', 4);

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `message` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `secondary_user`
--

CREATE TABLE `secondary_user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `check_listing` tinyint(1) DEFAULT 0,
  `billing_info` tinyint(1) DEFAULT 0,
  `merchant_id` int(11) NOT NULL,
  `token` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `secondary_user`
--

INSERT INTO `secondary_user` (`id`, `name`, `email`, `password`, `check_listing`, `billing_info`, `merchant_id`, `token`) VALUES
(1, 'haris', 'hkhurshid95@gmail.com', '123456', 1, 0, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcLyIsImF1ZCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvIiwiaWF0IjoxNjM1MjQ1NzYyLCJleHAiOjE2MzUyNDkzNjIsImRhdGEiOnsibmFtZSI6ImhhcmlzIiwiZW1haWwiOiJoa2h1cnNoaWQ5NUBnbWFpbC5jb20iLCJwYXNzd29yZCI6IjEyMzQ1NiIsImNoZWNraW5nX2xpc3RpbmciOiIxIiwiYmlsbGluZ19pbmZvIjoiMCIsIm1lcmNoYW50X2lkIjoiNCJ9fQ.EYS5N1IndYwsYDcL2y7memD2lnTe0Vu3gq0lnYvtY6A'),
(8, 'ali', 'ali@gmail.com', '123456', 0, 1, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcLyIsImF1ZCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvIiwiaWF0IjoxNjM1MjQ1NjI3LCJleHAiOjE2MzUyNDkyMjcsImRhdGEiOnsibmFtZSI6ImFsaSIsImVtYWlsIjoiYWxpQGdtYWlsLmNvbSIsInBhc3N3b3JkIjoiMTIzNDU2IiwiY2hlY2tpbmdfbGlzdGluZyI6IjAiLCJiaWxsaW5nX2luZm8iOiIxIiwibWVyY2hhbnRfaWQiOiI0In19.84QIvoZwa41iiT5dB__zFESW--96sRz1QmnjAsyCOkU');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `secondary_user`
--
ALTER TABLE `secondary_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secondary_user`
--
ALTER TABLE `secondary_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`id`);

--
-- Constraints for table `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `response_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `request` (`id`);

--
-- Constraints for table `secondary_user`
--
ALTER TABLE `secondary_user`
  ADD CONSTRAINT `secondary_user_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
