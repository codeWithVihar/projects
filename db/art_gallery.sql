-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 07, 2025 at 04:57 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `art_gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

DROP TABLE IF EXISTS `artists`;
CREATE TABLE IF NOT EXISTS `artists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `bio` text,
  `profile_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artworks`
--

DROP TABLE IF EXISTS `artworks`;
CREATE TABLE IF NOT EXISTS `artworks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artworks`
--

INSERT INTO `artworks` (`id`, `title`, `artist`, `category`, `price`, `image`, `description`, `created_at`) VALUES
(1, 'Abstract Painting', 'John Doe', 'Painting', 250.00, '1757262431.png', '', '2025-09-07 14:05:28'),
(2, 'Modern Sculpture', 'Jane Smith', 'Painting', 500.00, '1757262440.png', '', '2025-09-07 14:05:28'),
(3, 'Digital Illustration', 'Alex Lee', 'Digital Art', 150.00, '1757262450.png', '', '2025-09-07 14:05:28'),
(4, 'Landscape Art', 'Emily Brown', 'Painting', 300.00, '1757262460.png', '', '2025-09-07 14:05:28'),
(6, 'Modern Sculpture', 'Jane Smith', 'Sculpture', 5000.00, '1757262409.png', '', '2025-09-07 14:06:08'),
(7, 'Digital Illustration', 'Alex Lee', 'Digital Art', 1500.00, '1757262415.png', '', '2025-09-07 14:06:08'),
(8, 'Landscape Art', 'Emily Brown', 'Painting', 3000.00, '1757262422.png', '', '2025-09-07 14:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `admin_reply` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `admin_reply`, `created_at`) VALUES
(1, 'vihar', 'vihaarmehta@gmail.com', 'hello', 'eueyubsdyuyd', 'efe', '2025-09-07 16:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `artwork_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `artwork_id` (`artwork_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `artwork_id`, `quantity`, `total_price`, `order_date`, `status`) VALUES
(1, 2, 6, 1, 5000.00, '2025-09-07 14:33:04', 'Pending'),
(2, 2, 6, 1, 5000.00, '2025-09-07 14:33:06', 'Pending'),
(3, 2, 6, 1, 5000.00, '2025-09-07 14:33:07', 'Pending'),
(4, 2, 6, 1, 5000.00, '2025-09-07 14:33:07', 'Pending'),
(5, 2, 6, 1, 5000.00, '2025-09-07 14:33:07', 'Pending'),
(6, 2, 6, 1, 5000.00, '2025-09-07 14:34:33', 'Pending'),
(7, 2, 6, 1, 5000.00, '2025-09-07 14:34:34', 'Pending'),
(8, 2, 6, 1, 5000.00, '2025-09-07 14:34:34', 'Pending'),
(9, 2, 6, 1, 5000.00, '2025-09-07 14:34:57', 'Pending'),
(10, 2, 6, 1, 5000.00, '2025-09-07 14:35:11', 'Pending'),
(11, 2, 6, 1, 5000.00, '2025-09-07 14:43:17', ''),
(12, 2, 11, 1, 3477.00, '2025-09-07 15:19:04', 'Pending'),
(13, 2, 7, 1, 1500.00, '2025-09-07 16:48:50', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@example.com', '0192023a7bbd73250516f069df18b500', 'admin', '2025-09-07 14:15:14'),
(2, 'vihar', 'vihaarmehta@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user', '2025-09-07 14:32:58'),
(3, 'Palak', 'palak@example.com', 'd7e99191793ed9f5845035b41b454a0d', 'admin', '2025-09-07 14:58:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
