-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2025 at 11:25 AM
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
-- Database: `tishha`
--

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(11) NOT NULL,
  `designation_name` varchar(255) NOT NULL,
  `designation_description` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `designation_name`, `designation_description`, `status`, `created_at`) VALUES
(25, 'MANAGER', 'MANAGE HOSPITAL', 1, '2025-01-16 06:52:03'),
(26, 'ZSDASD', 'ASDAS', 1, '2025-01-16 07:00:48'),
(29, 'SOFT', 'SOFTWARE', 1, '2025-01-16 07:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user_name` varchar(225) NOT NULL,
  `user_password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` longtext NOT NULL,
  `long_description` longtext NOT NULL,
  `status` enum('draft','pending','published','private') DEFAULT 'draft',
  `post_image` varchar(255) DEFAULT NULL,
  `facebook_image` varchar(255) DEFAULT NULL,
  `instagram_image` varchar(255) DEFAULT NULL,
  `whatsapp_image` varchar(255) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','editor','viewer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `first_name`, `last_name`, `gender`, `dob`, `email`, `phone`, `address_line1`, `address_line2`, `city`, `state`, `zip_code`, `country`, `profile_picture`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'ANKUR', 'KUMAR', 'male', '1111-12-12', '', '', '', '', '', '', '', '', '67874f4611868.jpg', '', '', 'admin', '2025-01-15 06:01:55', '2025-01-15 06:01:55'),
(19, 'ANKUR', 'KUMAR', 'male', '1111-11-11', 'sad@dzsd', '', '', '', '', '', '', '', '67875ceb04adf.jpg', 'ankur', '12345', 'admin', '2025-01-15 06:59:55', '2025-01-15 06:59:55'),
(20, 'AMAN', 'KUMAR', 'male', '2012-12-12', 'aman123@gmail.com', '4564564565', '', '', '', '', '', '', '67876403357d0.jpg', 'aman123', '1234', 'admin', '2025-01-15 07:30:11', '2025-01-15 07:30:11'),
(22, 'RUDRANSH', 'PRAJAPATI', 'male', '2011-09-02', 'rudransh@gmail.com', '', '', '', '', '', '', '', '678767a916ed6.jpg', 'rudransh123', '12345', 'admin', '2025-01-15 07:45:45', '2025-01-15 07:45:45'),
(23, 'RUDRANSHRR', 'PRAJAPATIRR', 'male', '2011-09-02', 'rudransh11@gmail.com', '', '', '', '', '', '', '', '6787680ec25d6.jpg', 'rudransh12311', '12345', 'admin', '2025-01-15 07:47:26', '2025-01-15 07:47:26'),
(24, 'RUDRA', 'PRAJAPATI', 'male', '2011-09-02', 'rudra@gmail.com', '7894564564', '', '', '', '', '', '', '6787684b38859.jpg', 'rudra123', '12345', 'admin', '2025-01-15 07:48:27', '2025-01-15 07:48:27'),
(25, 'ASDAD', 'SADSAD', 'male', '2021-12-12', 'sds@zss.com', '', '', '', '', '', '', '', '678769368b3ff.jpg', 'adsad', '11111', 'admin', '2025-01-15 07:52:22', '2025-01-15 07:52:22'),
(26, 'ASDA', 'ASDASD', 'male', '1111-11-11', 'sdadsa@gmail.com', '', '', '', '', '', '', '', '67876be58490f.jpg', 'qwerty', '12345', 'admin', '2025-01-15 08:03:49', '2025-01-15 08:03:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
