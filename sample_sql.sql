-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2023 at 10:49 AM
-- Server version: 10.4.8-MariaDB
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
-- Database: `capy_hr_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `set_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `firstname`, `lastname`, `set_id`) VALUES
(2, 'John', 'Doe', 0),
(3, 'George', 'Mikan', 0),
(4, 'Gregory', 'Del Pilar', 4),
(5, 'Jacky', 'Lin', 0),
(6, 'Cidney', 'Austria', 0),
(8, 'John1', 'Doe', 0),
(9, 'John2', 'Doe', 0),
(10, 'John3', 'Doe', 0),
(11, 'John4', 'Doe', 0),
(12, 'John5', 'Doe', 0),
(13, 'John6', 'Doe', 0);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_name`, `uploaded_on`) VALUES
(3, 'dpworld.png', '2023-03-08 11:19:24');

-- --------------------------------------------------------

--
-- Table structure for table `peripherals`
--

CREATE TABLE `peripherals` (
  `component_id` int(11) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `serial_number` int(100) NOT NULL,
  `specs` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `purchase_date` date NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `set_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peripherals`
--

INSERT INTO `peripherals` (`component_id`, `brand`, `unit`, `serial_number`, `specs`, `price`, `manufacturer`, `purchase_date`, `receipt_id`, `set_id`) VALUES
(1, 'Brand', 'Unit', 123, '1231231', 200, 'Cappy', '2023-02-01', 1124, 3),
(2, 'Brand', 'Name', 111, 'Specs4', 500, '123', '2023-12-31', 3321, 2),
(3, 'Item', 'Item', 110011, 'Specs', 250, 'Capy', '2023-03-14', 2231, 2),
(4, 'Item2', 'Item2', 110012, 'Sp3', 240, 'Capyy', '2022-12-31', 1133, 0),
(5, 'Item3', 'Unit3', 110013, 'Sp3', 100, 'Capy2', '2022-11-28', 2223, 4);

-- --------------------------------------------------------

--
-- Table structure for table `set_bundle`
--

CREATE TABLE `set_bundle` (
  `set_id` int(100) NOT NULL,
  `set_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `set_bundle`
--

INSERT INTO `set_bundle` (`set_id`, `set_name`) VALUES
(1, 'Archived'),
(2, 'Set2'),
(3, 'set3'),
(4, 'Set4');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `user_type`) VALUES
(1, 'admin', '$2y$10$FJEL77rhWjMPa5ZgMuQsVevR8ldT.MsAxG7L4P7A0t/v8OzjWNDdC', '2022-08-02 17:48:31', 1),
(2, 'user', '$2y$10$AbPH3dAcr.v7H5lWOvVOvur7xgtdJr2LBxV1csZXZeh6wqlT5hx1i', '2023-03-09 16:29:18', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `set_id` (`set_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peripherals`
--
ALTER TABLE `peripherals`
  ADD PRIMARY KEY (`component_id`);

--
-- Indexes for table `set_bundle`
--
ALTER TABLE `set_bundle`
  ADD PRIMARY KEY (`set_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `peripherals`
--
ALTER TABLE `peripherals`
  MODIFY `component_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `set_bundle`
--
ALTER TABLE `set_bundle`
  MODIFY `set_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
