-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 03, 2026 at 07:42 PM
-- Server version: 8.4.3
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wedding_planner`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `service_id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `booking_date` date NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `event_type` varchar(50) DEFAULT NULL,
  `venue` varchar(100) DEFAULT NULL,
  `guest_count` int DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `event_name`, `event_date`, `event_type`, `venue`, `guest_count`, `budget`, `status`, `created_at`, `approval_status`) VALUES
(1, 1, 'Engament', '2026-12-15', 'Engagement', 'banquet', 400, 3000000.00, NULL, '2026-07-03 19:21:39', 'approved'),
(2, 1, 'Engament', '2026-01-01', 'Mehndi', 'banquet', 600, 300000.00, 'pending', '2026-07-03 19:39:47', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `description`, `price`, `category`, `status`) VALUES
(1, 'Decoration', 'Premium floral and stage decoration', 50000.00, 'Decor', 'active'),
(2, 'Catering', 'Delicious food for all guests', 30000.00, 'Food', 'active'),
(3, 'Photography', 'Professional photography and videography', 25000.00, 'Media', 'active'),
(4, 'Makeup', 'Bridal makeup and beauty services', 15000.00, 'Beauty', 'active'),
(5, 'Music', 'Live band and DJ services', 20000.00, 'Entertainment', 'active'),
(6, 'Venue', 'Luxury hall rental', 100000.00, 'Venue', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `address`, `created_at`) VALUES
(1, 'yusra', 'yusra@aptechgdn.net', '$2y$12$Z2U.8MtAn.0Vx0JdfK02a.NdVxb/2PMOjWYKwWPDj0dx1l.CXgQma', '0332124049', '', '2026-07-03 18:36:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- inquiry form

CREATE TABLE `inquiries` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `full_name` varchar(100) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `email` varchar(100) NOT NULL,
    `wedding_date` date DEFAULT NULL,
    `wedding_event` varchar(50) DEFAULT NULL,
    `venue` varchar(200) DEFAULT NULL,
    `guests` int(11) DEFAULT NULL,
    `budget` varchar(50) DEFAULT NULL,
    `theme` varchar(50) DEFAULT NULL,
    `catering` varchar(20) DEFAULT NULL,
    `message` text DEFAULT NULL,
    `status` enum('pending','read','replied') DEFAULT 'pending',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `bookings` 
  ADD COLUMN `product_id` INT(11) DEFAULT NULL AFTER `user_id`,
  ADD COLUMN `product_name` VARCHAR(255) DEFAULT NULL AFTER `product_id`,
  ADD COLUMN `product_price` VARCHAR(100) DEFAULT NULL AFTER `product_name`,
  ADD COLUMN `full_name` VARCHAR(100) DEFAULT NULL AFTER `product_price`,
  ADD COLUMN `email` VARCHAR(100) DEFAULT NULL AFTER `full_name`,
  ADD COLUMN `phone` VARCHAR(20) DEFAULT NULL AFTER `email`,
  ADD COLUMN `event_date` DATE DEFAULT NULL AFTER `phone`,
  ADD COLUMN `guests` INT(11) DEFAULT NULL AFTER `event_date`,
  MODIFY COLUMN `booking_date` DATE NULL DEFAULT NULL;