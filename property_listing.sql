-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 12:25 AM
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
-- Database: `property_listing`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `agency_name` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `social_media_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_media_links`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `full_name`, `email`, `phone`, `agency_name`, `profile_picture`, `biography`, `social_media_links`, `created_at`) VALUES
(1, 'Franklin Gothic', 'franklinuu@gmail.com', '123-456-78978', 'Luxury Realty', 'images/dummy-image.jpg', 'bdjgaukgdjada', '{\"facebook\": \"facebook.com/johndoe\", \"linkedin\": \"linkedin.com/in/johndoe\"}', '2024-11-01 04:54:59'),
(2, 'Jassica George uuu', 'jassica@gmail.com', '987-654-3210', 'Elite Homes', 'images/dummy-image.jpg', 'Passionate about helping clients find their dream homes. udpataa', '{\"instagram\": \"instagram.com/janesmith\", \"twitter\": \"twitter.com/janesmith\"}', '2024-11-01 04:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `property_id`, `quantity`) VALUES
(53, 1, 20, 3);

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_submissions`
--

CREATE TABLE `contact_form_submissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form_submissions`
--

INSERT INTO `contact_form_submissions` (`id`, `name`, `email`, `phone`, `website`, `message`, `created_at`) VALUES
(1, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', 'www.jass.com', 'test', '2024-10-31 02:07:45'),
(2, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', 'www.jass.com', 'test', '2024-11-01 12:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Tajinder', 'tajinder@gmail.com', 'kjkhjkhjjk', '2024-11-21 16:15:13'),
(2, 'Jaspreet singh', 'jaszsingh6@gmail.com', 'this is feedback', '2024-11-22 08:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `billing_name` varchar(100) NOT NULL,
  `billing_email` varchar(100) NOT NULL,
  `billing_phone` varchar(20) DEFAULT NULL,
  `billing_address` varchar(255) NOT NULL,
  `billing_city` varchar(50) DEFAULT NULL,
  `billing_state` varchar(50) DEFAULT NULL,
  `billing_postal_code` varchar(20) DEFAULT NULL,
  `billing_country` varchar(50) DEFAULT NULL,
  `shipping_name` varchar(100) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(50) DEFAULT NULL,
  `shipping_state` varchar(50) DEFAULT NULL,
  `shipping_postal_code` varchar(20) DEFAULT NULL,
  `shipping_country` varchar(50) DEFAULT NULL,
  `shipping_method` varchar(50) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total`, `billing_name`, `billing_email`, `billing_phone`, `billing_address`, `billing_city`, `billing_state`, `billing_postal_code`, `billing_country`, `shipping_name`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_postal_code`, `shipping_country`, `shipping_method`, `order_date`) VALUES
(4, 1, 1250000.00, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'Jaspreet singh', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'standard', '2024-11-01 03:38:17'),
(5, 1, 850000.00, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'Jaspreet singh', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'standard', '2024-11-01 03:42:42'),
(6, 1, 1250000.00, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'Jaspreet singh', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'standard', '2024-11-01 03:46:21'),
(7, 1, 850000.00, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'Jaspreet singh', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'standard', '2024-11-01 03:56:23'),
(8, 1, 850000.00, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'Jaspreet singh', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'standard', '2024-11-01 03:56:48'),
(9, 1, 2200000.00, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'Jaspreet singh', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'standard', '2024-11-01 04:07:28'),
(10, 1, 950000.00, 'tajinder', 'tjkaur@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'tajinder', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'express', '2024-11-01 04:10:54'),
(11, 1, 3050000.00, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'Jaspreet singh', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'standard', '2024-11-01 05:57:25'),
(12, 1, 1300000.00, 'Jaspreet singh', 'jaszsingh6@gmail.com', '5483280947', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'Jaspreet singh', '259 Wellington Street', 'Brantford', 'ON', 'N3S 3Z8', 'Canada', 'standard', '2024-11-01 06:34:18'),
(13, 1, 1826999.00, 'Tajinder', 'taj@gmail.com', '8726637388', '123 sheridan street', 'brantford', 'Ontario', 'n3te09', 'canada', 'Tajinder', '123 sheridan street', 'brantford', 'Ontario', 'n3te09', 'canada', 'standard', '2024-11-22 02:30:29'),
(14, 1, 900000.00, 'Taijij', 'kjhj@kjh.com', '876876876', 'hgvhggh', 'ghgvghg', 'hghgf', 'hgy7y6v', 'uhg', 'Taijij', 'hgvhggh', 'ghgvghg', 'hghgf', 'hgy7y6v', 'uhg', 'standard', '2024-11-22 03:05:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `listed_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `description`, `price`, `address`, `image`, `listed_by`, `created_at`, `bedrooms`, `bathrooms`, `size`) VALUES
(7, 'Modern Apartment in New York updated ', 'Beautiful 2-bedroom apartment in the heart of Manhattan. Fully furnished, modern kitchen, and just steps away from Central Park and public transportation.', 26999.00, '456 Central Park West, New York, NY, USA', 'apartment1.webp', NULL, '2024-10-31 02:16:07', 2, 1, 1200),
(8, 'Cozy Cottage in the Countryside', 'A charming 3-bedroom cottage nestled in the countryside. Perfect for a quiet retreat, with a large garden and a cozy fireplace.', 450000.00, '789 Country Lane, Countryside, UK', 'cottage1.webp', NULL, '2024-10-31 02:16:08', 3, 2, 1800),
(9, 'Beachfront Condo in Miami', 'Wake up to stunning ocean views in this 2-bedroom beachfront condo in Miami. Enjoy direct beach access, modern amenities, and a large balcony.', 950000.00, '101 Ocean Drive, Miami, FL, USA', 'condo1.jpeg', NULL, '2024-10-31 02:16:08', 2, 2, 1500),
(10, 'Historic Townhouse in London', 'A beautiful 4-bedroom townhouse in the heart of London, featuring historic architecture, a private garden, and modern interior upgrades.', 1350000.00, '202 Heritage St, London, UK', 'townhouse1.jpeg', NULL, '2024-10-31 02:16:08', 4, 3, 3200),
(18, 'test', 'jbsjbfksbjk', 569.00, 'abdjhbad', '../uploads/6724cb4a4cbc6-DSC_8101 3 (Large).jpg', NULL, '2024-11-01 12:36:26', 5, 5, 5),
(19, 'firebase', 'dbjahbsda', 54841.00, 'dbajbdaj', '67401880ad02c-young-man-playing-guitar-field-sunsetgenerative-ai_391052-16330.avif', NULL, '2024-11-22 05:37:05', 5, 5, 2),
(20, 'checkput', 'bjabdbakd', 1000.00, 'ajdbjabjd', '67402612cc3df-DSC_8541 (Large).jpg', NULL, '2024-11-22 06:34:59', 5, 5, 2),
(21, 'new proper', 'jkbdaja', 5000.00, 'kandak', '674089bfa4962-DSC_8583 (Large).jpg', NULL, '2024-11-22 13:40:20', 5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_path`) VALUES
(6, 7, 'P2G1.avif'),
(7, 7, 'P2G2.avif'),
(8, 7, 'P2G3.avif'),
(9, 7, 'P2G4.avif'),
(10, 7, 'P2G5.avif'),
(11, 8, 'P3G1.avif'),
(12, 8, 'P3G2.avif'),
(13, 8, 'P3G3.avif'),
(14, 8, 'P3G4.avif'),
(15, 8, 'P3G5.avif'),
(16, 9, 'P4G1.avif'),
(17, 9, 'P4G2.avif'),
(18, 9, 'P4G3.avif'),
(19, 9, 'P4G4.avif'),
(20, 9, 'P4G5.avif'),
(21, 10, 'P5G1.avif'),
(22, 10, 'P5G2.avif'),
(23, 10, 'P5G3.avif'),
(24, 10, 'P5G4.avif'),
(25, 10, 'P5G5.avif'),
(36, 18, '../uploads/6724cb4a57fbe-DSC_8297 (Large).jpg'),
(37, 18, '../uploads/6724cb4a6f478-DSC_8414 (Large).jpg'),
(38, 18, '../uploads/6724cb4a7636a-DSC_8448 (Large).jpg'),
(39, 19, '674018818b69a-DSC_8448 (Large).jpg'),
(40, 19, '67401881efb36-DSC_8456 (Large).jpg'),
(41, 20, '67402613a98e7-DSC_8448 (Large).jpg'),
(42, 20, '674026140699a-DSC_8456 (Large).jpg'),
(43, 21, '674089c445f34-DSC_8019 (Large).jpg'),
(44, 21, '674089c498a8c-DSC_8035-1 2 (Large).jpg'),
(45, 21, '674089c4eb352-DSC_8101 3 (Large).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_role`, `created_at`) VALUES
(1, 'admin', '$2y$10$s/xXvKSgXhfFpJj/u78XWeHTs/7JVuiEDd8Abk5Nh/oGVwdeNlLOy', 'jaszsingh6@gmail.com', 'user', '2024-10-31 02:50:13'),
(2, 'ashu', '$2y$10$KJCGwpGSNXAChTYyEzz3lO6.PyO.CVJ2c.jfJCjbRt0.NRtD4Y4wK', 'ashu@gmail.com', 'user', '2024-11-21 06:43:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`property_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `contact_form_submissions`
--
ALTER TABLE `contact_form_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listed_by` (`listed_by`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `contact_form_submissions`
--
ALTER TABLE `contact_form_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`listed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `fk_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
