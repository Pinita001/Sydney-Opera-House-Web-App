-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2025 at 02:48 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinema_booking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `show_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`) VALUES
(1, NULL, '120.00', 'Confirmed', '2025-11-02 05:29:41'),
(2, NULL, '120.00', 'Confirmed', '2025-11-02 13:05:48'),
(3, NULL, '120.00', 'Confirmed', '2025-11-03 02:02:57'),
(4, 3, '350.00', 'Confirmed', '2025-11-03 05:12:21'),
(5, 4, '375.00', 'Confirmed', '2025-11-03 12:22:22'),
(6, NULL, '135.00', 'Confirmed', '2025-11-12 13:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `show_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) DEFAULT NULL,
  `show_time` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `show_id`, `quantity`, `price`, `show_time`, `created_at`) VALUES
(1, 1, 1, 1, '120.00', 'Nov 19 - 2:00 PM', '2025-11-02 05:29:41'),
(2, 2, 1, 1, '120.00', 'Nov 19 - 2:00 PM', '2025-11-02 13:05:48'),
(3, 3, 1, 1, '120.00', 'Nov 19 - 2:00 PM', '2025-11-03 02:02:57'),
(4, 4, 2, 2, '175.00', 'Mar 5 - 9:00 PM', '2025-11-03 05:12:21'),
(5, 5, 3, 3, '125.00', 'Dec 13 - 1:00 PM', '2025-11-03 12:22:22'),
(6, 6, 1, 1, '135.00', 'Nov 21 - 6:00 PM', '2025-11-12 13:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` enum('Credit Card','PayPal','Cash') NOT NULL,
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Pending',
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `payment_status`, `amount`, `created_at`) VALUES
(1, 1, 'Credit Card', 'Paid', '120.00', '2025-11-02 05:29:41'),
(2, 2, 'Credit Card', 'Paid', '120.00', '2025-11-02 13:05:48'),
(3, 3, 'Credit Card', 'Paid', '120.00', '2025-11-03 02:02:57'),
(4, 4, 'Credit Card', 'Paid', '350.00', '2025-11-03 05:12:21'),
(5, 5, 'Credit Card', 'Paid', '375.00', '2025-11-03 12:22:22'),
(6, 6, 'Credit Card', 'Paid', '135.00', '2025-11-12 13:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `guests` int(11) NOT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `full_name`, `email`, `phone`, `date`, `time`, `guests`, `notes`, `created_at`) VALUES
(1, 'shan', 'shan@gmail.com', '90681026', '2025-11-03', '12:00:00', 2, '', '2025-11-03 05:13:53'),
(2, 'pinita', 'pinita001@e.ntu.edu.sg', '90681026', '2025-11-03', '14:30:00', 2, '', '2025-11-03 12:23:20'),
(3, 'pinita', 'pinita001@e.ntu.edu.sg', '90681026', '2025-11-03', '14:30:00', 2, '', '2025-11-03 12:23:23');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `venue` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`id`, `name`, `description`, `venue`, `date`, `price`, `image_url`, `created_at`) VALUES
(1, 'Swan Lake', 'Nov 19 - 2:00 PM', 'Main Hall', '2025-11-02 06:29:41', '120.00', '', '2025-11-02 05:29:41'),
(2, 'Tame Impala', 'Mar 5 - 9:00 PM', 'Main Hall', '2025-11-03 06:12:21', '175.00', '', '2025-11-03 05:12:21'),
(3, 'The Phantom of the Opera', 'Dec 13 - 1:00 PM', 'Main Hall', '2025-11-03 13:22:22', '125.00', '', '2025-11-03 12:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `created_at`) VALUES
(1, 'jane', 'jane@gmail.com', '$2y$10$.YviBowofSkAMigZqPb.FepeTPhdytWu01INTpKq11xDXwJlDmDAu', NULL, '2025-11-02 02:07:54'),
(2, 'hary@Gmail.com', 'hary@gmail.com', '$2y$10$GkRMkVnWozlmCY4yx4qM.uzbAJu6q/XrpD4XEpWvCh57tVEsY5Q0.', NULL, '2025-11-03 02:09:56'),
(3, 'shan', 'shan@gmail.com', '$2y$10$2vRsAKgrP1lSeC1LiBxfP.yv7QkNKkmIDuDWeNAgPOznXM93zdEiK', NULL, '2025-11-03 05:11:25'),
(4, 'azrah', 'azrah@gmail.com', '$2y$10$ubchNpwe1Dpgotc/dxm48eLkbyojbSNsE1a9XlFg6n1LU7ZwjhTlW', NULL, '2025-11-03 12:21:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `show_id` (`show_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `show_id` (`show_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
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
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
