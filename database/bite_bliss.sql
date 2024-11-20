-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 03:10 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bite_bliss`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` int(11) NOT NULL,
  `adminname` varchar(255) NOT NULL,
  `adminpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `adminname`, `adminpassword`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_otp_hash` varchar(64) DEFAULT NULL,
  `reset_otp_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `name`, `address`, `mobile`, `email`, `password`, `reset_otp_hash`, `reset_otp_expires_at`) VALUES
(1, 'Sugyan Shrestha', 'Thimi', 9800000000, 'sugyan@gmail.com', '$2y$10$Y1ltSacLt37Iw5PnOP.B.OqIAmkfRS.SG261hNzHMsPbiBrF.AuO2', NULL, NULL),
(3, 'demo', 'demo', 1234567890, 'demo@gmail.com', '$2y$10$M0tt1cLo5rX9hA55ZN7bWeEOyW7S/m9VmZJsjict6S1/Fhxrk.JHy', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_person`
--

CREATE TABLE `delivery_person` (
  `dpid` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `license` bigint(20) NOT NULL,
  `vehicle` varchar(50) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `status` enum('Pending','Approved','Not Approved') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery_person`
--

INSERT INTO `delivery_person` (`dpid`, `fullname`, `address`, `mobile`, `email`, `password`, `license`, `vehicle`, `vehicle_number`, `status`) VALUES
(1, 'Ram Shrestha', 'Thimi', 9800000000, 'ram@gmail.com', '$2y$10$KTttqg5FIKx.orNJPEVQP.wNKulVb9uWgBlbMYLaOk5rj9ZPEPEjS', 0, 'Motorcycle', '4884', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `foodcategory`
--

CREATE TABLE `foodcategory` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foodcategory`
--

INSERT INTO `foodcategory` (`category_id`, `category_name`) VALUES
(12, 'Appetizers'),
(3, 'Burger'),
(11, 'Cake'),
(9, 'Momo'),
(1, 'Pizza');

-- --------------------------------------------------------

--
-- Table structure for table `fooditem`
--

CREATE TABLE `fooditem` (
  `food_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fooditem`
--

INSERT INTO `fooditem` (`food_id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
(1, 'Ham Burger', 'A tasty ham burger for you my love!!!!', 190.00, '0-02-03-12623f03481b1681d498dee6410a09db08f6d5c3c1002b211d4a4e7844cb474c_cc3b55586073a235.jpg', 3),
(2, 'Buff Momo', 'Juicy buff momo is the one what you need the most', 180.00, '0-02-03-83121869964b200833c01cd04cace1ad588a1f437037c0eda9dbee7a89b9e320_c2074a2a5025d33d.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `nid` int(11) NOT NULL,
  `priority_score` int(11) NOT NULL,
  `target_delivery_time` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dpid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `order_id`, `message`, `is_read`, `created_at`, `dpid`) VALUES
(1, 16, 'New order received from Sugyan Shrestha. Order ID: 16. Please come and receive the order for delivery.', 0, '2024-11-13 10:07:39', NULL),
(2, 23, 'New order received from Sugyan Shrestha. Order ID: 23. Please come and receive the order for delivery.', 0, '2024-11-15 16:43:21', NULL),
(3, 24, 'New order received from Sugyan Shrestha. Order ID: 24. Please come and receive the order for delivery.', 0, '2024-11-15 16:44:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_details_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_details_id`, `order_id`, `food_id`, `quantity`, `price`) VALUES
(22, 24, 1, 4, 190.00),
(24, 26, 1, 2, 190.00),
(25, 27, 2, 1, 180.00),
(27, 29, 1, 5, 190.00),
(28, 30, 2, 1, 180.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `delivery_status` enum('Pending','Shipped','Delivered') DEFAULT 'Pending',
  `shipping_address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `payment_method` enum('Cash on Delivery') DEFAULT 'Cash on Delivery',
  `distance` decimal(5,2) DEFAULT NULL,
  `estimated_delivery_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `cid`, `order_date`, `total_amount`, `delivery_status`, `shipping_address`, `city`, `payment_method`, `distance`, `estimated_delivery_time`) VALUES
(24, 1, '2024-11-15 16:44:23', 760.00, 'Delivered', 'dghb', 'dfb', 'Cash on Delivery', 6.00, 50),
(26, 3, '2024-11-16 10:49:19', 380.00, 'Pending', 'awed', 'qwd', 'Cash on Delivery', 5.00, 45),
(27, 3, '2024-11-16 12:46:11', 180.00, 'Pending', 'demo', 'demo', 'Cash on Delivery', 10.00, 70),
(29, 3, '2024-11-16 13:11:48', 950.00, 'Delivered', 'demo address', 'demo address', 'Cash on Delivery', 7.00, 55),
(30, 3, '2024-11-16 13:13:22', 180.00, 'Pending', 'shipping', 'city', 'Cash on Delivery', 5.00, 45);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `reset_otp_hash` (`reset_otp_hash`);

--
-- Indexes for table `delivery_person`
--
ALTER TABLE `delivery_person`
  ADD PRIMARY KEY (`dpid`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `foodcategory`
--
ALTER TABLE `foodcategory`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `fooditem`
--
ALTER TABLE `fooditem`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`nid`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dpid` (`dpid`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`cid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_person`
--
ALTER TABLE `delivery_person`
  MODIFY `dpid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `foodcategory`
--
ALTER TABLE `foodcategory`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fooditem`
--
ALTER TABLE `fooditem`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fooditem`
--
ALTER TABLE `fooditem`
  ADD CONSTRAINT `fooditem_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `foodcategory` (`category_id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_dpid` FOREIGN KEY (`dpid`) REFERENCES `delivery_person` (`dpid`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `fooditem` (`food_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `customer` (`cid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
