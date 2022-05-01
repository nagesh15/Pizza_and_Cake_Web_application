-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2021 at 07:14 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza_cake`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_db`
--

CREATE TABLE `admin_db` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_db`
--

INSERT INTO `admin_db` (`id`, `username`, `password`) VALUES
(1, 'Admin', 'admin'),
(2, 'admin', 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `stat` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `type`, `stat`) VALUES
(2, 'Non-veg Pizza', 'pizza', 1),
(3, 'Veg Cake', 'cake', 1),
(4, 'Non-Veg Cake', 'cake', 0),
(5, 'Veg Pizza', 'pizza', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `addr` varchar(255) NOT NULL,
  `total` float NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `order_status` varchar(20) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `user_id`, `addr`, `total`, `order_type`, `payment_type`, `payment_status`, `order_status`, `added_on`) VALUES
(1, 1, 'NS SHOP, Manipal Branch', 860, 'takeaway', 'COD', 'success', 'success', '2021-10-07 21:25:53'),
(2, 1, 'Manipal Udupi', 2400, 'delivery', 'COD', 'pending', 'Cancelled', '2021-10-08 08:37:44'),
(3, 1, 'Manipal,Udupi', 1360, 'delivery', 'COD', 'pending', 'success', '2021-10-08 11:43:26'),
(5, 1, 'Manipal,Udupi', 200, 'delivery', 'COD', 'pending', 'pending', '2021-10-11 19:47:36'),
(6, 1, 'NS SHOP,Udupi Branch', 720, 'takeaway', 'COD', 'pending', 'pending', '2021-10-11 19:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `od_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`od_id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 1, 4, 180),
(2, 1, 2, 1, 120),
(3, 2, 1, 1, 180),
(4, 2, 7, 2, 1100),
(5, 3, 5, 1, 700),
(6, 3, 3, 2, 320),
(7, 4, 1, 1, 180),
(8, 5, 1, 1, 180),
(9, 6, 5, 1, 700);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_type` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `mrp` float NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `category_type`, `product_name`, `mrp`, `price`, `image`, `description`, `status`) VALUES
(1, 5, 'pizza', 'Peppy Paneer', 200, 180, 'peppy_paneer.jpg', 'Chunky paneer with crisp capsicum and spicy red pepper', 1),
(2, 5, 'pizza', 'Veggie Pizza', 180, 120, 'veggie_pizza.jpg', 'Zucchini, Fresh Mushrooms, Green or Red Pepper, Part-skim Mozzarella cheese, Onion', 1),
(3, 2, 'pizza', 'Chicken Deluxe', 350, 320, 'chicken_deluxe.jpg', 'Chicken Breast, Mushrooms, Red Peppers, Green Peppers, Tomato Sauce, Mozzarella Cheese', 1),
(4, 2, 'pizza', 'Pepporoni', 250, 240, 'nonveg_pepporoni.jpg', 'Pepporoni, Mozzarella Cheese', 1),
(5, 3, 'cake', 'Vanilla Cake', 750, 700, 'eggless_vanilla.jpg', 'This is Eggless Vanilla Cake. Made up of pastry flour, Vanilla extract, Apple Cider Vinegar, Yogurt.', 1),
(6, 3, 'cake', 'Red Velvet Cake', 900, 880, 'redvelvet.jpg', 'This is Eggless Cake, Made up of All-purpose flour, Baking powder, Unsweetened cocoa powder, Butter, Sour cream, Pure vanilla extract, Buttermilk, Red food color, Cream Cheese Frosting', 1),
(7, 4, 'cake', 'Black forest Cake', 1200, 1100, 'black forest cake.jpg', 'All Purpose flour, Cocoa Powder, Egg, Vanilla Extract, Milk, Butter', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_db`
--

CREATE TABLE `user_db` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(200) NOT NULL,
  `pincode` int(11) NOT NULL,
  `phone_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_db`
--

INSERT INTO `user_db` (`id`, `name`, `password`, `email`, `address`, `pincode`, `phone_no`) VALUES
(1, 'user1', 'hello', 'hello@gmail.com', 'Manipal,Udupi', 576108, 6258845),
(8, 'Test', 'test', 'Tets@gmail.com', 'Manipal Road, Udupi', 848515, 995959555),
(9, 'shashank', 'shashank', 'shashumalpe@gmail.com', 'malpe', 576106, 2147483647),
(10, 'abhishek', 'bbbb', 'aaaabbb@gmail.com', 'udupi', 576102, 767666857),
(11, 'Nagesh Shenoy', 'wipe', 'wipedevil@gmail.com', 'Manipal', 574101, 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_db`
--
ALTER TABLE `admin_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`od_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_db`
--
ALTER TABLE `user_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `od_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_db`
--
ALTER TABLE `user_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
