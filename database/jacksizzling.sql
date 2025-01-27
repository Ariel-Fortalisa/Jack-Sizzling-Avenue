-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 12:47 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jacksizzling`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `activity_logs` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `activity_logs`, `date_created`, `added_by`) VALUES
(1, 'Added a new category named Veggies.', '2024-12-08 20:21:40', 1),
(2, 'Added a new category named Crispy Fried Noodles.', '2024-12-08 20:24:01', 2),
(3, 'Archived the category named Silog Meals.', '2024-12-08 20:45:33', 1),
(4, 'Archived the category named Pares.', '2024-12-08 21:16:52', 1),
(5, 'Restored the category named Crispy Rice Meal.', '2024-12-08 21:18:22', 1),
(6, 'Restored the category named Silog Meals.', '2024-12-08 21:18:35', 1),
(7, 'Restored the category named Pares.', '2024-12-08 21:19:34', 1),
(8, 'Added a new unit of measurement named Liters.', '2024-12-08 23:26:35', 1),
(9, 'Added a new unit of measurement named mL.', '2024-12-08 23:30:01', 1),
(10, 'Edited the unit of measurement from mL to Milliliter.', '2024-12-09 00:37:39', 1),
(11, 'Edited the category from Crispy Fried Noodles to Crispy Pata.', '2024-12-09 00:45:48', 1),
(12, 'Archived the unit of measurement named Milliliter.', '2024-12-09 01:43:55', 1),
(13, 'Restored the unit of measurement named grams.', '2024-12-09 01:47:56', 1),
(14, 'Added a new account with the username Modako.', '2024-12-09 02:19:29', 1),
(15, 'Changed the role of username Modako from Inv. Admin to Cashier.', '2024-12-09 02:48:09', 1),
(16, 'Changed the role of username Modako from Cashier to Inv. Admin.', '2024-12-09 02:49:03', 1),
(17, 'Archived the Account of username Modako.', '2024-12-09 02:52:48', 1),
(18, 'Restored the Account of username Modako.', '2024-12-10 16:57:23', 1),
(19, 'Archived the Account of username Modako.', '2024-12-10 17:03:54', 1),
(20, 'Restored the Account of username Modako.', '2024-12-10 17:04:03', 1),
(21, 'Archived the Account of username Modako.', '2024-12-10 17:04:11', 1),
(22, 'Restored the Account of username Modako.', '2024-12-10 17:04:56', 1),
(23, 'Archived the Account of username Haruu.', '2024-12-10 17:29:28', 1),
(24, 'Restored the Account of username Haruu.', '2024-12-10 17:29:39', 1),
(25, 'Login to the system', '2024-12-10 18:45:44', 3),
(26, 'Logout to the system', '2024-12-10 18:56:50', 3),
(27, 'Login to the system', '2024-12-10 18:56:53', 1),
(28, 'Restored the product named Mami pares.', '2024-12-10 19:32:03', 1),
(29, 'Updated the details of Pork lungss', '2024-12-10 22:23:46', 1),
(30, 'Updated the details of Pork lungs', '2024-12-10 22:30:43', 1),
(31, 'Archived the Ingredients named Pork lungs.', '2024-12-10 22:40:47', 1),
(32, 'Restored the Ingredient named Pork lungs.', '2024-12-10 22:52:33', 1),
(33, 'Archived the Ingredients named Pork lungs.', '2024-12-10 23:52:12', 1),
(34, 'Restored the Ingredient named Tender Joicy hotdog.', '2024-12-10 23:54:36', 1),
(35, 'Login to the system.', '2024-12-11 16:04:20', 1),
(36, 'Added a new ingredients named Soy Sauce', '2024-12-11 18:35:00', 1),
(37, 'Login to the system.', '2024-12-11 18:40:33', 1),
(38, 'Added a new batch for Bagnet with Batch ID #10000067', '2024-12-11 19:55:33', 1),
(39, 'Added a new batch for Flour with Batch ID #10000068', '2024-12-11 20:02:05', 1),
(40, 'Updated batch details for Bagnet with Batch ID #10000067', '2024-12-11 20:34:07', 1),
(41, 'Archived the batch Bagnet with Batch ID 10000067.', '2024-12-11 20:49:34', 1),
(42, 'Login to the system.', '2024-12-11 21:10:42', 1),
(43, 'Restored the batch Bagnet with Batch ID 10000067.', '2024-12-11 21:29:32', 1),
(44, 'Archived the batch Bagnet with batch ID 10000067.', '2024-12-11 21:33:34', 1),
(45, 'Restored the batch Bagnet with batch ID 10000067.', '2024-12-11 21:34:02', 1),
(46, 'Login to the system.', '2024-12-12 16:00:28', 1),
(47, 'Logout to the system.', '2024-12-13 14:05:20', 1),
(48, 'Login to the system.', '2024-12-13 14:05:58', 1),
(49, 'Logout to the system.', '2024-12-13 14:06:02', 1),
(50, 'Login to the system.', '2024-12-17 12:41:56', 1),
(51, 'Logout to the system.', '2024-12-18 15:02:55', 1),
(52, 'Updated the details of Tender Joicy hotdog', '2024-12-18 19:00:52', 1),
(53, 'Archived the batch Tender Joicy hotdog with batch ID 10000061.', '2024-12-18 19:01:01', 1),
(54, 'Updated the details of Egg', '2024-12-18 19:01:14', 1),
(55, 'Archived the batch Egg with batch ID 10000056.', '2024-12-18 19:01:21', 1),
(56, 'Updated the details of Egg', '2024-12-18 19:01:26', 1),
(57, 'Archived the batch Bagnet with batch ID 10000067.', '2024-12-18 19:01:47', 1),
(58, 'Updated the details of Bagnet', '2024-12-18 19:01:56', 1),
(59, 'Archived the batch Garlic with batch ID 10000053.', '2024-12-18 19:02:06', 1),
(60, 'Added a new ingredients named vinegar', '2024-12-18 20:24:20', 1),
(61, 'Added a new ingredients named Beans', '2024-12-18 20:25:10', 1),
(62, 'A new store logo has been updated.', '2024-12-19 01:32:25', 1),
(63, 'A new store logo has been updated.', '2024-12-19 01:35:35', 1),
(64, 'A new store logo has been updated.', '2024-12-19 01:37:41', 1),
(65, 'A new store logo has been updated.', '2024-12-19 01:38:01', 1),
(66, 'A new store logo has been updated.', '2024-12-19 01:38:31', 1),
(67, 'Updated the details of the store.', '2024-12-19 01:39:24', 1),
(68, 'Updated the details of the store.', '2024-12-19 01:39:43', 1),
(69, 'Login background image updated successfully.', '2024-12-19 01:52:30', 1),
(70, 'Login background image updated successfully.', '2024-12-19 01:53:36', 1),
(71, 'Login to the system.', '2024-12-19 17:10:14', 1),
(72, 'Logout to the system.', '2024-12-19 17:13:14', 1),
(73, 'Login to the system.', '2024-12-21 16:54:50', 1),
(74, 'A new profile picture has been updated.', '2024-12-22 19:14:35', 1),
(75, 'A new profile picture has been updated.', '2024-12-22 19:17:55', 1),
(76, 'A new profile picture has been updated.', '2024-12-22 19:18:17', 1),
(77, 'Logout to the system.', '2024-12-22 20:04:55', 1),
(78, 'Login to the system.', '2024-12-22 20:04:58', 1),
(79, 'Logout to the system.', '2024-12-22 20:26:34', 1),
(80, 'Login to the system.', '2024-12-22 20:26:44', 3),
(81, 'Logout to the system.', '2024-12-22 20:29:59', 3),
(82, 'Login to the system.', '2024-12-22 20:30:03', 1),
(83, 'Logout to the system.', '2024-12-22 20:30:15', 1),
(84, 'Login to the system.', '2024-12-22 20:30:22', 3),
(85, 'Failed to update the details of the Haruu account.', '2024-12-22 21:26:42', 3),
(86, 'Updated the details of Haruu account.', '2024-12-22 21:28:47', 3),
(87, 'Updated the details of Haruu account.', '2024-12-22 21:32:20', 3),
(88, 'Failed to update the details of the Haruu account.', '2024-12-22 21:33:38', 3),
(89, 'Updated the details of Haruu account.', '2024-12-22 21:33:53', 3),
(90, 'Failed to update the details of the Haruu account.', '2024-12-22 21:33:58', 3),
(91, 'Updated the details of Haruu account.', '2024-12-22 21:34:08', 3),
(92, 'Updated the details of Haruu account.', '2024-12-22 21:34:27', 3),
(93, 'Failed to update the details of the Haruu account.', '2024-12-22 21:34:36', 3),
(94, 'Failed to update the details of the Haruu account.', '2024-12-22 21:34:38', 3),
(95, 'Failed to update the details of the Haruu account.', '2024-12-22 21:39:40', 3),
(96, 'Updated the details of Haruu account.', '2024-12-22 21:39:56', 3),
(97, 'Failed to update the details of the Haruu account.', '2024-12-22 21:40:33', 3),
(98, 'Failed to update the details of the Haruu account.', '2024-12-22 21:40:39', 3),
(99, 'Failed to update the details of the Haruu account.', '2024-12-22 21:40:47', 3),
(100, 'Failed to update the details of the Haruu account.', '2024-12-22 21:42:44', 3),
(101, 'Failed to update the details of the Haruu account.', '2024-12-22 21:42:50', 3),
(102, 'Updated the details of Haruu account.', '2024-12-22 21:46:28', 3),
(103, 'Updated the details of Haruu account.', '2024-12-22 21:46:52', 3),
(104, 'Failed to update the details of the Haruu account.', '2024-12-22 21:46:57', 3),
(105, 'Failed to update the details of the Haruu account.', '2024-12-22 21:48:47', 3),
(106, 'Failed to update the details of the Haruu account.', '2024-12-22 21:48:51', 3),
(107, 'Updated the details of Haruu account.', '2024-12-22 21:49:10', 3),
(108, 'Updated the details of Haruu account.', '2024-12-22 21:49:21', 3),
(109, 'Logout to the system.', '2024-12-22 21:57:13', 3),
(110, 'Login to the system.', '2024-12-22 21:57:18', 1),
(111, 'Archived the Account of username SeafoodShrimp.', '2024-12-22 21:57:27', 1),
(112, 'Logout to the system.', '2024-12-22 21:57:49', 1),
(113, 'Login to the system.', '2024-12-22 21:57:57', 2),
(114, 'Logout to the system.', '2024-12-22 21:58:00', 2),
(115, 'Login to the system.', '2024-12-22 22:04:21', 1),
(116, 'Logout to the system.', '2024-12-22 23:10:24', 1),
(117, 'Login to the system.', '2024-12-22 23:51:42', 1),
(118, 'Archived the product named Mami pares.', '2024-12-23 01:25:34', 1),
(119, 'Logout to the system.', '2024-12-23 01:56:36', 1),
(120, 'Login to the system.', '2024-12-23 16:45:05', 1),
(121, 'Updated batch details for Bangus with Batch ID #10000044', '2024-12-23 17:38:08', 1),
(122, 'Archived the product named Ham&Bcn.', '2024-12-23 17:52:13', 1),
(123, 'Restored the product named Ham&Bcn.', '2024-12-23 17:54:18', 1),
(124, 'Archived the product named Ham&Bcn.', '2024-12-23 17:56:53', 1),
(125, 'Restored the product named Ham&Bcn.', '2024-12-23 18:02:18', 1),
(126, 'Archived the product named Ham&Bcn.', '2024-12-23 18:02:42', 1),
(127, 'Restored the product named Ham&Bcn.', '2024-12-23 18:05:32', 1),
(128, 'Archived the product named Ham&Bcn.', '2024-12-23 18:06:48', 1),
(129, 'Restored the product named Ham&Bcn.', '2024-12-23 18:09:01', 1),
(130, 'Archived the product named Ham&Bcn.', '2024-12-23 18:09:59', 1),
(131, 'Restored the product named Ham&Bcn.', '2024-12-23 18:12:01', 1),
(132, 'Updated batch details for Tender Joicy hotdog with Batch ID #10000047', '2024-12-23 18:14:19', 1),
(133, 'Updated batch details for Tender Joicy hotdog with Batch ID #10000047', '2024-12-23 18:14:25', 1),
(134, 'Updated batch details for Tender Joicy hotdog with Batch ID #10000047', '2024-12-23 18:15:20', 1),
(135, 'Archived the product named Ham&Bcn.', '2024-12-23 18:16:01', 1),
(136, 'Restored the product named Ham&Bcn.', '2024-12-23 18:18:04', 1),
(137, 'Archived the product named Ham&Bcn.', '2024-12-23 18:18:14', 1),
(138, 'Restored the product named Ham&Bcn.', '2024-12-23 18:22:19', 1),
(139, 'Archived the product named Ham&Bcn.', '2024-12-23 18:22:30', 1),
(140, 'Updated batch details for Bangus with Batch ID #10000044', '2024-12-23 18:25:30', 1),
(141, 'Logout to the system.', '2024-12-26 03:21:49', 1),
(142, 'Login to the system.', '2024-12-26 22:20:45', 1),
(143, 'Logout to the system.', '2024-12-26 22:38:54', 1),
(144, 'Login to the system.', '2024-12-26 22:39:39', 3),
(145, 'Logout to the system.', '2024-12-26 22:57:37', 3),
(146, 'Login to the system.', '2024-12-26 22:57:46', 1),
(147, 'Archived the Ingredients named .', '2024-12-26 23:30:57', 1),
(148, 'Updated batch details for Buns with Batch ID #10000045', '2024-12-26 23:36:45', 1),
(149, 'Logout to the system.', '2024-12-27 00:50:59', 1),
(150, 'Login to the system.', '2024-12-27 00:52:26', 3),
(151, 'Logout to the system.', '2024-12-27 00:56:54', 3),
(152, 'Login to the system.', '2024-12-27 00:57:07', 9),
(153, 'Logout to the system.', '2024-12-27 01:04:28', 9),
(154, 'Login to the system.', '2024-12-27 01:04:31', 1),
(155, 'Logout to the system.', '2024-12-27 01:05:36', 1),
(156, 'Login to the system.', '2024-12-27 01:05:44', 3),
(157, 'Logout to the system.', '2024-12-27 01:05:48', 3),
(158, 'Login to the system.', '2024-12-27 01:05:53', 9),
(159, 'Logout to the system.', '2024-12-27 01:09:39', 9),
(160, 'Login to the system.', '2024-12-27 01:09:42', 1),
(161, 'Logout to the system.', '2024-12-27 01:11:23', 1),
(162, 'Login to the system.', '2024-12-27 01:11:27', 9),
(163, 'Logout to the system.', '2024-12-27 01:12:12', 9),
(164, 'Login to the system.', '2024-12-27 01:12:15', 1),
(165, 'Logout to the system.', '2024-12-27 01:37:22', 1),
(166, 'Login to the system.', '2024-12-27 01:37:28', 9),
(167, 'Logout to the system.', '2024-12-27 01:41:47', 9),
(168, 'Login to the system.', '2024-12-27 01:42:05', 3),
(169, 'Logout to the system.', '2024-12-27 01:44:04', 3),
(170, 'Login to the system.', '2024-12-27 01:44:19', 9),
(171, 'Logout to the system.', '2024-12-27 01:50:26', 9),
(172, 'Login to the system.', '2024-12-27 01:50:28', 1),
(173, 'Logout to the system.', '2024-12-27 02:04:31', 1),
(174, 'Login to the system.', '2024-12-27 02:04:35', 3),
(175, 'Logout to the system.', '2024-12-27 02:04:46', 3),
(176, 'Login to the system.', '2024-12-27 02:04:52', 9),
(177, 'Logout to the system.', '2024-12-27 02:05:51', 9),
(178, 'Login to the system.', '2024-12-27 02:05:55', 1),
(179, 'Logout to the system.', '2024-12-27 03:13:56', 1),
(180, 'Login to the system.', '2024-12-27 03:19:57', 1),
(181, 'Logout to the system.', '2024-12-27 03:36:04', 1),
(182, 'Login to the system.', '2024-12-27 03:36:10', 1),
(183, 'Login to the system.', '2024-12-27 19:58:51', 1),
(184, 'Login to the system.', '2024-12-28 12:32:59', 1),
(185, 'Logout to the system.', '2024-12-29 00:05:29', 1),
(186, 'Login to the system.', '2024-12-29 00:23:32', 1),
(187, 'Added a new batch for Buns with Batch ID #10000071', '2024-12-29 01:41:29', 1),
(188, 'Archived the product named sweet&spcy.', '2024-12-29 01:52:52', 1),
(189, 'Restored the product named sweet&spcy.', '2024-12-29 01:54:31', 1),
(190, 'Archived the product named sweet&spcy.', '2024-12-29 01:55:41', 1),
(191, 'Archived the batch Buns with batch ID 10000071.', '2024-12-29 01:56:15', 1),
(192, 'Restored the product named sweet&spcy.', '2024-12-29 01:57:34', 1),
(193, 'Archived the product named sweet&spcy.', '2024-12-29 01:58:37', 1),
(194, 'Restored the product named sweet&spcy.', '2024-12-29 01:59:01', 1),
(195, 'Archived the product named sweet&spcy.', '2024-12-29 01:59:11', 1),
(196, 'Restored the product named sweet&spcy.', '2024-12-29 02:04:27', 1),
(197, 'Archived the product named sweet&spcy.', '2024-12-29 02:04:52', 1),
(198, 'Restored the product named sweet&spcy.', '2024-12-29 02:05:19', 1),
(199, 'Archived the product named sweet&spcy.', '2024-12-29 02:05:29', 1),
(200, 'Archived the product named Crispy Sisig.', '2024-12-29 02:06:07', 1),
(201, 'Restored the product named Crispy Sisig.', '2024-12-29 02:11:29', 1),
(202, 'Restored the product named sweet&spcy.', '2024-12-29 02:11:34', 1),
(203, 'Archived the product named sweet&spcy.', '2024-12-29 02:11:44', 1),
(204, 'Archived the product named Crispy Sisig.', '2024-12-29 02:14:40', 1),
(205, 'Updated batch details for Beef with Batch ID #10000046', '2024-12-29 02:15:15', 1),
(206, 'Updated batch details for Beef with Batch ID #10000046', '2024-12-29 02:15:42', 1),
(207, 'Restored the product named sweet&spcy.', '2024-12-29 02:17:04', 1),
(208, 'Restored the product named Crispy Sisig.', '2024-12-29 02:17:08', 1),
(209, 'Archived the Ingredients named .', '2024-12-29 02:58:44', 1),
(210, 'Archived the batch Carrot with batch ID 10000059.', '2024-12-29 02:59:40', 1),
(211, 'Archived the Ingredients named .', '2024-12-29 03:01:56', 1),
(212, 'Restored the Ingredient named Tender Joicy hotdog.', '2024-12-29 03:02:15', 1),
(213, 'Restored the Ingredient named Carrot.', '2024-12-29 03:02:20', 1),
(214, 'Update the details of product named Boneless Crispy Pata.', '2024-12-29 14:21:31', 0),
(215, 'Added a new product named Pares Overload.', '2024-12-29 14:27:14', 1),
(216, 'Update the details of product named Pares Overload.', '2024-12-29 14:28:05', 0),
(217, 'Update the details of product named Pares Overload.', '2024-12-29 14:31:28', 0),
(218, 'Update the details of product named Pares Overload.', '2024-12-29 14:40:07', 0),
(219, 'Update the details of product named Pares Overload.', '2024-12-29 14:43:48', 0),
(220, 'Update the details of product named Pares Overload.', '2024-12-29 14:44:42', 1),
(221, 'Update the details of product named Pares Overload.', '2024-12-29 14:46:38', 1),
(222, 'Update the details of product named Pares Overload.', '2024-12-29 14:56:55', 1),
(223, 'Update the details of product named Pares Overload.', '2024-12-29 14:57:52', 1),
(224, 'Update the details of product named Pares Overload.', '2024-12-29 14:58:22', 1),
(225, 'Update the details of product named Pares Overload.', '2024-12-29 14:59:30', 1),
(226, 'Update the details of product named Pares Overload.', '2024-12-29 14:59:44', 1),
(227, 'Update the details of product named Pares Overload.', '2024-12-29 15:00:51', 1),
(228, 'Update the details of product named Pares Overload.', '2024-12-29 15:02:40', 1),
(229, 'Update the details of product named Pares Overload.', '2024-12-29 15:04:24', 1),
(230, 'Update the details of product named Pares Overload.', '2024-12-29 15:04:40', 1),
(231, 'Update the details of product named Pares Overload.', '2024-12-29 15:05:11', 1),
(232, 'Logout to the system.', '2024-12-29 15:38:47', 1),
(233, 'Login to the system.', '2025-01-01 19:09:54', 1),
(234, 'Logout to the system.', '2025-01-01 19:09:59', 1),
(235, 'Login to the system.', '2025-01-01 19:10:20', 1),
(236, 'Logout to the system.', '2025-01-01 19:15:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `add_ons`
--

CREATE TABLE `add_ons` (
  `addOns_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `addons_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_ons`
--

INSERT INTO `add_ons` (`addOns_id`, `product_id`, `addons_name`, `price`) VALUES
(16, 40, 'Chicharon', 30),
(17, 40, 'Bagnet', 90),
(18, 40, 'Rice', 15),
(19, 47, 'Chicharon', 30),
(20, 47, 'Bagnet', 30),
(21, 47, 'Rice', 15),
(25, 0, 'Chicharon Bulaklak', 30),
(26, 0, 'Bagnet', 30),
(27, 0, 'Rice', 15),
(64, 63, 'Chicharon Bulaklak', 30),
(65, 63, 'Bagnet', 30),
(66, 63, 'ASS', 3);

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `cost` float NOT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `expiration_status` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `archive_status` int(11) NOT NULL,
  `date_archived` datetime NOT NULL,
  `archived_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `stock_id`, `qty`, `cost`, `expiration_date`, `expiration_status`, `date_created`, `archive_status`, `date_archived`, `archived_by`) VALUES
(10000038, 30, 0, 701, '2024-12-25 20:11:42', 3, '2024-11-03 14:55:06', 0, '2024-11-04 08:34:53', 1),
(10000043, 35, 0, 400, '2025-01-03 00:00:00', 2, '2024-11-03 17:02:39', 0, '0000-00-00 00:00:00', 1),
(10000044, 36, 1, 120, '2024-12-03 00:00:00', 3, '2024-11-03 17:03:30', 0, '0000-00-00 00:00:00', 1),
(10000045, 37, 25, 1, '2024-12-02 00:00:00', 3, '2024-11-03 17:04:18', 0, '0000-00-00 00:00:00', 1),
(10000046, 38, 8, 500, '2025-02-27 00:00:00', 1, '2024-11-03 17:05:03', 0, '0000-00-00 00:00:00', 1),
(10000047, 30, 0, 700, '2024-12-03 00:00:00', 3, '2024-11-03 20:26:08', 0, '2024-12-05 19:22:02', 1),
(10000048, 30, 0, 700, '2025-01-03 00:00:00', 2, '2024-11-03 21:39:56', 0, '0000-00-00 00:00:00', 1),
(10000049, 35, 0, 400, '2024-12-12 00:00:00', 3, '2024-11-03 21:54:24', 0, '0000-00-00 00:00:00', 1),
(10000050, 39, 100, 600, '2024-11-27 15:46:29', 3, '2024-11-04 01:45:04', 0, '0000-00-00 00:00:00', 1),
(10000051, 39, 11, 600, '2024-11-30 00:00:00', 3, '2024-11-04 06:53:30', 0, '0000-00-00 00:00:00', 1),
(10000052, 39, 14, 600, '2025-02-07 00:00:00', 1, '2024-11-04 06:53:47', 0, '0000-00-00 00:00:00', 1),
(10000053, 40, 28, 1500, '2025-02-20 00:00:00', 1, '2024-11-08 23:12:16', 1, '2024-12-18 19:02:06', 1),
(10000054, 41, 60, 1400, '2024-12-08 00:00:00', 3, '2024-11-08 23:12:40', 0, '0000-00-00 00:00:00', 1),
(10000055, 42, 42, 1500, '2025-01-10 00:00:00', 2, '2024-11-08 23:13:18', 0, '0000-00-00 00:00:00', 1),
(10000056, 43, 60, 1000, '2025-06-28 00:00:00', 1, '2024-11-08 23:14:11', 1, '2024-12-18 19:01:21', 1),
(10000057, 44, 71, 300, '2025-02-12 00:00:00', 1, '2024-11-08 23:15:22', 0, '0000-00-00 00:00:00', 1),
(10000058, 43, 60, 1000, '2025-01-31 01:43:56', 1, '2024-11-09 01:39:16', 0, '2024-11-09 01:44:19', 1),
(10000059, 35, 18, 400, '2024-12-24 00:00:00', 3, '2024-11-24 22:47:09', 1, '2024-12-29 02:59:40', 1),
(10000060, 45, 111, 111, '2025-01-10 00:00:00', 2, '2024-12-02 18:32:19', 0, '0000-00-00 00:00:00', 1),
(10000061, 30, 56, 700, '2025-02-15 00:00:00', 1, '2024-12-04 19:54:52', 1, '2024-12-18 19:01:01', 1),
(10000062, 46, 50, 1000, '2025-02-15 00:00:00', 1, '2024-12-07 21:52:43', 0, '0000-00-00 00:00:00', 1),
(10000063, 47, 20, 5000, '2025-12-11 00:00:00', 1, '2024-12-11 18:29:27', 0, '0000-00-00 00:00:00', 1),
(10000064, 48, 500, 100, '2025-07-11 00:00:00', 1, '2024-12-11 18:35:00', 0, '0000-00-00 00:00:00', 1),
(10000067, 44, 300, 300, '2025-01-10 00:00:00', 2, '2024-12-11 19:55:33', 1, '2024-12-18 19:01:47', 1),
(10000068, 47, 30, 5000, '2026-02-11 00:00:00', 1, '2024-12-11 20:02:05', 0, '0000-00-00 00:00:00', 1),
(10000069, 49, 1500, 1500, '2025-12-18 00:00:00', 1, '2024-12-18 20:24:20', 0, '0000-00-00 00:00:00', 1),
(10000070, 50, 10, 3000, '2025-12-18 00:00:00', 1, '2024-12-18 20:25:10', 0, '0000-00-00 00:00:00', 1),
(10000071, 37, 25, 120, '2025-02-28 00:00:00', 1, '2024-12-29 01:41:29', 1, '2024-12-29 01:56:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `archive_status` int(200) NOT NULL,
  `add-ons` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `archive_status`, `add-ons`) VALUES
(1, 'Crispy Rice Meal', 0, 0),
(2, 'Silog Meals', 0, 0),
(3, 'Pares', 0, 1),
(4, 'Crispy Fried Noodles', 0, 0),
(8, 'Rice Platter', 0, 0),
(52, 'Veggies', 0, 0),
(53, 'Crispy Pata', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `category` int(11) NOT NULL,
  `product_status` tinytext NOT NULL,
  `archive_status` tinytext NOT NULL DEFAULT 'unarchived',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `product_description` varchar(200) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date_archived` datetime DEFAULT NULL,
  `archived_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `category`, `product_status`, `archive_status`, `date_added`, `product_description`, `added_by`, `date_archived`, `archived_by`) VALUES
(45, 'Crispy tight', 1, 'unavailable', 'unarchived', '2024-11-07 15:20:19', 'Sizzling with gravy on top', 1, '0000-00-00 00:00:00', 0),
(46, 'Rice', 8, 'available', 'unarchived', '2024-11-07 16:11:59', '', 1, '0000-00-00 00:00:00', 0),
(47, 'Pares Overload', 0, 'unavailable', 'unarchived', '2024-11-07 22:58:28', '', 1, '0000-00-00 00:00:00', 0),
(48, 'Boneless Crispy Pata', 1, 'available', 'unarchived', '2024-11-07 23:19:07', '', 1, '0000-00-00 00:00:00', 0),
(49, 'Crispy tight', 1, 'unavailable', 'unarchived', '2024-11-11 15:47:46', '', 1, '0000-00-00 00:00:00', 0),
(50, 'Longganisa', 2, 'unavailable', 'unarchived', '2024-11-11 15:48:50', '', 1, '0000-00-00 00:00:00', 0),
(51, 'Sausage', 2, 'unavailable', 'archived', '2024-11-11 15:49:18', '', 1, '0000-00-00 00:00:00', 0),
(52, 'Crispy Noodles Seafood', 4, 'unavailable', 'unarchived', '2024-11-11 15:50:33', '', 1, '0000-00-00 00:00:00', 0),
(53, 'Mami pares', 4, 'unavailable', 'archived', '2024-11-11 16:00:57', '', 1, '0000-00-00 00:00:00', 0),
(54, 'Noodles Beef', 4, 'unavailable', 'unarchived', '2024-11-11 16:02:35', '', 1, '0000-00-00 00:00:00', 0),
(55, 'Kare Kare', 1, 'unavailable', 'unarchived', '2024-11-11 16:05:14', '', 1, '0000-00-00 00:00:00', 0),
(56, 'Ham&Bcn', 1, 'unavailable', 'archived', '2024-11-11 16:07:06', '', 1, '0000-00-00 00:00:00', 0),
(57, 'sweet&spcy', 1, 'unavailable', 'unarchived', '2024-11-11 16:07:45', '', 1, '0000-00-00 00:00:00', 0),
(59, 'Crispy Sisig', 1, 'unavailable', 'unarchived', '2024-11-11 16:13:56', '', 1, '0000-00-00 00:00:00', 0),
(63, 'Pares Overload', 3, 'available', 'unarchived', '2024-12-29 14:27:14', '', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_ingredients`
--

CREATE TABLE `product_ingredients` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_ingredients`
--

INSERT INTO `product_ingredients` (`id`, `product_id`, `stock_id`, `size_id`, `quantity`) VALUES
(197, 33, 29, 36, 2),
(198, 34, 30, 37, 1),
(199, 34, 24, 37, 1),
(200, 34, 28, 37, 1),
(201, 34, 29, 37, 1),
(202, 35, 27, 38, 2),
(203, 35, 22, 39, 2),
(204, 35, 28, 40, 3),
(205, 35, 25, 41, 5),
(206, 36, 23, 42, 4),
(207, 36, 28, 42, 4),
(208, 37, 27, 43, 2),
(209, 37, 29, 43, 2),
(210, 37, 27, 44, 2),
(211, 37, 29, 44, 2),
(212, 38, 24, 45, 5),
(213, 38, 28, 45, 5),
(214, 39, 22, 46, 5),
(215, 39, 29, 47, 6),
(216, 43, 36, 50, 2),
(217, 43, 37, 50, 2),
(218, 43, 38, 50, 2),
(219, 44, 36, 51, 2),
(220, 44, 37, 51, 2),
(221, 44, 38, 51, 2),
(222, 45, 36, 52, 2),
(223, 45, 37, 52, 2),
(224, 45, 38, 52, 9),
(225, 46, 37, 53, 3),
(226, 46, 36, 54, 3),
(227, 46, 38, 55, 3),
(228, 46, 35, 56, 3),
(229, 47, 30, 57, 1),
(230, 47, 35, 57, 1),
(231, 47, 36, 57, 1),
(232, 47, 37, 57, 1),
(233, 47, 38, 57, 1),
(234, 47, 39, 57, 1),
(235, 48, 38, 58, 3),
(236, 49, 35, 59, 1),
(237, 49, 37, 59, 1),
(238, 50, 36, 60, 1),
(239, 50, 44, 60, 1),
(240, 51, 37, 61, 1),
(241, 51, 38, 61, 1),
(242, 52, 35, 62, 1),
(243, 52, 37, 62, 1),
(244, 52, 42, 62, 1),
(245, 53, 36, 63, 1),
(246, 53, 38, 63, 1),
(247, 53, 44, 63, 1),
(248, 54, 40, 64, 1),
(249, 54, 41, 64, 1),
(250, 54, 42, 64, 1),
(251, 55, 35, 65, 1),
(252, 55, 37, 65, 1),
(253, 55, 42, 65, 1),
(254, 56, 36, 66, 1),
(255, 56, 37, 66, 1),
(256, 56, 38, 66, 2),
(257, 57, 35, 67, 1),
(258, 57, 40, 67, 1),
(259, 57, 42, 67, 1),
(260, 59, 30, 69, 1),
(261, 59, 40, 69, 1),
(262, 59, 43, 69, 1),
(263, 62, 30, 72, 2),
(264, 62, 35, 72, 2),
(265, 62, 36, 72, 1),
(266, 62, 37, 72, 3),
(267, 0, 35, 74, 1),
(297, 63, 35, 90, 1),
(298, 63, 36, 90, 2),
(299, 63, 37, 90, 3),
(300, 63, 30, 91, 1),
(301, 63, 35, 91, 1),
(302, 63, 36, 91, 2),
(303, 63, 37, 91, 3),
(304, 63, 39, 91, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `size_id` int(11) NOT NULL,
  `product_id` int(200) NOT NULL,
  `size_name` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `size_status` varchar(100) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`size_id`, `product_id`, `size_name`, `price`, `size_status`) VALUES
(52, 45, 'Regular', 599, 'unavailable'),
(53, 46, 'Plain Rice', 55, 'unavailable'),
(54, 46, 'Garlic Fried Rice', 85, 'unavailable'),
(55, 46, 'Bagoon Fried Rice', 130, 'available'),
(56, 46, 'Tinapa Fried Rice', 130, 'unavailable'),
(57, 47, 'Regular', 59, 'unavailable'),
(58, 48, 'Regular', 599, 'available'),
(59, 49, 'Crispy liempo', 599, 'unavailable'),
(60, 50, 'Regular', 59, 'unavailable'),
(61, 51, 'Regular', 59, 'unavailable'),
(62, 52, 'Regular', 220, 'unavailable'),
(63, 53, 'Regular', 220, 'unavailable'),
(64, 54, 'Regular', 220, 'unavailable'),
(65, 55, 'Regular', 599, 'unavailable'),
(66, 56, 'Regular', 599, 'unavailable'),
(67, 57, 'Regular', 599, 'unavailable'),
(68, 58, 'Regular', 130, 'available'),
(69, 59, 'Regular', 599, 'unavailable'),
(70, 60, 'Nig', 111, 'available'),
(71, 61, 'Regular', 200, 'available'),
(72, 62, 'dddsd', 33333, 'unavailable'),
(74, 0, 'Regular', 59, 'available'),
(90, 63, 'Regular', 59, 'available'),
(91, 63, 'sss', 1000000, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `security_question`
--

CREATE TABLE `security_question` (
  `id` int(11) NOT NULL,
  `list_question` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_question`
--

INSERT INTO `security_question` (`id`, `list_question`) VALUES
(1, 'What was the name of your first pet?'),
(2, 'What is your mother\'s maiden name?'),
(3, 'What is the name of the street you grew up on?'),
(4, 'What was your first job?'),
(5, 'What is your favorite color?'),
(6, 'What is your dream car?'),
(7, 'Who is your childhood friend?');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL,
  `stock_name` varchar(200) NOT NULL,
  `cost` int(200) NOT NULL,
  `unit` varchar(200) NOT NULL,
  `crit` int(11) NOT NULL,
  `archive_status` int(200) NOT NULL,
  `date_archived` datetime DEFAULT NULL,
  `stock_status` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_name`, `cost`, `unit`, `crit`, `archive_status`, `date_archived`, `stock_status`, `date_added`, `added_by`) VALUES
(30, 'Tender Joicy hotdog', 700, '1', 30, 0, '2024-12-29 03:02:15', 3, '2024-11-09 15:54:25', 1),
(35, 'Carrot', 400, '1', 10, 0, '2024-12-29 03:02:20', 3, '2024-11-09 15:54:25', 1),
(36, 'Bangus', 120, '1', 10, 0, NULL, 2, '2024-11-09 15:54:25', 1),
(37, 'Buns', 120, '1', 15, 0, '2024-12-04 17:40:34', 1, '2024-11-09 15:54:27', 1),
(38, 'Beef', 500, '3', 50, 0, NULL, 2, '2024-11-09 15:54:29', 1),
(39, 'White Onion', 600, '3', 22, 0, NULL, 1, '2024-11-09 15:54:32', 1),
(40, 'Garlic', 1500, '3', 15, 0, NULL, 3, '2024-11-09 01:45:53', 1),
(41, 'Corn', 1400, '1', 30, 0, NULL, 1, '2024-11-09 01:45:55', 1),
(42, 'Chicken Tight', 1500, '1', 30, 0, NULL, 1, '2024-11-09 15:54:17', 1),
(43, 'Egg', 1000, '1', 60, 1, '2024-12-26 23:30:57', 2, '0000-00-00 00:00:00', 1),
(44, 'Bagnet', 300, '1', 80, 0, NULL, 2, '2024-11-24 22:35:26', 1),
(46, 'Pork lungs', 1000, '1', 25, 0, '2024-12-10 22:52:33', 1, '2024-11-25 22:35:26', 1),
(47, 'Flour', 5000, '3', 10, 0, '0000-00-00 00:00:00', 1, '2024-12-11 18:29:27', 1),
(48, 'Soy Sauce', 100, '7', 250, 0, '0000-00-00 00:00:00', 1, '2024-12-11 18:35:00', 1),
(49, 'vinegar', 1500, '8', 750, 0, '0000-00-00 00:00:00', 1, '2024-12-18 20:24:20', 1),
(50, 'Beans', 3000, '3', 5, 0, '0000-00-00 00:00:00', 1, '2024-12-18 20:25:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `system_id` int(11) NOT NULL,
  `store_name` varchar(200) NOT NULL,
  `store_address` varchar(200) NOT NULL,
  `tin-number` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`system_id`, `store_name`, `store_address`, `tin-number`, `contact`) VALUES
(1, 'Jack Sizzling Avenue', 'Congressional Road Angara Alderman 4117 General Mariano Alvarez, Cavite', '009-491-731-011', '0998-765-4321');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `amount_tendered` int(200) NOT NULL,
  `vat_amount` float NOT NULL,
  `vat_sales` float NOT NULL,
  `change_amount` float NOT NULL,
  `discount` int(11) NOT NULL,
  `cs_name` varchar(200) NOT NULL,
  `cs_id` varchar(200) NOT NULL,
  `discount_type` varchar(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `total_amount`, `amount_tendered`, `vat_amount`, `vat_sales`, `change_amount`, `discount`, `cs_name`, `cs_id`, `discount_type`, `date_created`, `added_by`) VALUES
(61, 1113, 1500, 119.25, 993.75, 387, 0, '', '', '', '2024-11-02 00:18:28', 1),
(62, 248, 248, 26.57, 221.43, 0, 0, '', '', '', '2024-11-01 00:18:28', 1),
(63, 114, 114, 12.21, 101.79, 0, 0, '', '', '', '2024-11-03 00:18:28', 1),
(64, 342, 500, 36.64, 305.36, 158, 0, '', '', '', '2024-11-01 10:20:01', 1),
(65, 477, 500, 51.11, 425.89, 23, 0, '', '', '', '2024-11-01 10:27:13', 1),
(66, 295, 500, 31.61, 263.39, 205, 0, '', '', '', '2024-11-04 10:43:52', 1),
(67, 1575, 2000, 168.75, 1406.25, 425, 0, '', '', '', '2024-11-03 10:44:56', 1),
(68, 295, 295, 31.61, 263.39, 0, 0, '', '', '', '2023-11-01 10:57:46', 1),
(69, 287, 300, 30.75, 256.25, 13, 0, '', '', '', '2023-11-01 10:59:50', 1),
(70, 287, 300, 30.75, 256.25, 13, 0, '', '', '', '2023-11-01 11:04:19', 1),
(71, 287, 300, 30.75, 256.25, 13, 0, '', '', '', '2024-11-01 11:04:37', 1),
(72, 287, 300, 30.75, 256.25, 13, 0, '', '', '', '2024-11-01 11:05:21', 1),
(73, 287, 300, 30.75, 256.25, 13, 0, '', '', '', '2024-11-01 11:05:28', 1),
(74, 287, 300, 30.75, 256.25, 13, 0, '', '', '', '2024-11-01 11:06:02', 1),
(75, 287, 300, 30.75, 256.25, 13, 0, '', '', '', '2024-11-01 11:12:28', 1),
(76, 228, 500, 24.43, 203.57, 272, 0, '', '', '', '2024-11-01 11:13:11', 1),
(77, 228, 500, 24.43, 203.57, 272, 0, '', '', '', '2024-11-01 11:17:53', 1),
(78, 228, 500, 24.43, 203.57, 272, 0, '', '', '', '2023-11-01 11:18:44', 1),
(79, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:19:03', 1),
(80, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:19:32', 1),
(81, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:19:58', 1),
(82, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:20:27', 1),
(83, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:20:41', 1),
(84, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:22:24', 1),
(85, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:27:55', 1),
(86, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:28:35', 1),
(87, 287, 500, 30.75, 256.25, 272, 0, '', '', '', '2024-11-01 11:30:30', 1),
(88, 114, 114, 12.21, 101.79, 0, 0, '', '', '', '2024-11-01 11:33:35', 1),
(89, 114, 114, 12.21, 101.79, 0, 0, '', '', '', '2024-11-01 11:35:09', 1),
(90, 114, 114, 12.21, 101.79, 0, 0, '', '', '', '2024-11-01 11:40:09', 1),
(91, 228, 500, 24.43, 203.57, 272, 0, '', '', '', '2024-11-01 11:40:47', 1),
(92, 114, 500, 12.21, 101.79, 386, 0, '', '', '', '2024-11-01 11:46:15', 1),
(93, 114, 500, 12.21, 101.79, 386, 0, '', '', '', '2024-11-01 14:59:55', 1),
(94, 114, 500, 12.21, 101.79, 386, 0, '', '', '', '2024-11-01 15:04:56', 1),
(95, 283, 300, 30.32, 252.68, 17, 0, '', '', '', '2024-11-02 14:21:07', 1),
(96, 283, 300, 30.32, 252.68, 17, 0, '', '', '', '2024-11-06 14:32:34', 1),
(97, 283, 300, 30.32, 252.68, 17, 0, '', '', '', '2024-11-02 14:54:13', 1),
(98, 283, 300, 30.32, 252.68, 17, 0, '', '', '', '2024-11-04 00:18:28', 1),
(99, 283, 300, 30.32, 252.68, 17, 0, '', '', '', '2024-11-06 00:18:28', 1),
(100, 283, 300, 30.32, 252.68, 17, 0, '', '', '', '2024-11-05 00:00:00', 1),
(101, 283, 300, 30.32, 252.68, 17, 0, '', '', '', '2024-11-02 18:15:08', 1),
(102, 283, 300, 30.32, 252.68, 17, 0, '', '', '', '2024-11-02 18:23:02', 1),
(103, 456, 500, 48.86, 407.14, 44, 0, '', '', '', '2024-11-02 18:23:39', 1),
(104, 275, 300, 29.46, 245.54, 25, 0, '', '', '', '2024-11-02 18:28:53', 1),
(105, 275, 300, 29.46, 245.54, 25, 0, '', '', '', '2024-11-02 18:29:24', 1),
(106, 110, 110, 11.79, 98.21, 0, 0, '', '', '', '2024-11-02 18:48:55', 1),
(107, 3815, 4000, 408.75, 3406.25, 185, 0, '', '', '', '2024-11-09 00:18:28', 1),
(108, 3815, 4000, 408.75, 3406.25, 185, 0, '', '', '', '2024-11-04 18:50:56', 1),
(109, 3815, 4000, 408.75, 3406.25, 185, 0, '', '', '', '2024-11-02 18:51:04', 1),
(110, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-11-07 15:21:54', 1),
(111, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-11-07 16:42:25', 1),
(112, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-11-07 16:44:57', 1),
(113, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-11-07 16:47:14', 1),
(114, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-11-07 16:51:09', 1),
(115, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-11-08 21:29:24', 1),
(117, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-11-10 14:37:15', 1),
(120, 220, 220, 23.57, 196.43, 0, 0, '', '', '', '2024-11-11 15:55:18', 1),
(121, 59, 59, 6.32, 52.68, 0, 0, '', '', '', '2024-11-11 15:55:27', 1),
(122, 59, 59, 6.32, 52.68, 0, 0, '', '', '', '2024-11-11 15:55:34', 1),
(123, 599, 1000, 64.18, 534.82, 401, 0, '', '', '', '2024-11-11 15:55:45', 1),
(124, 440, 500, 47.14, 392.86, 60, 0, '', '', '', '2024-11-11 16:18:57', 1),
(125, 118, 200, 12.64, 105.36, 82, 0, '', '', '', '2024-11-11 16:19:32', 1),
(126, 118, 200, 12.64, 105.36, 82, 0, '', '', '', '2024-11-11 16:30:37', 1),
(127, 1198, 2000, 128.36, 1069.64, 802, 0, '', '', '', '2024-11-11 16:52:58', 1),
(128, 717, 717, 76.82, 640.18, 0, 0, '', '', '', '2024-11-11 17:40:15', 1),
(129, 717, 717, 76.82, 640.18, 0, 0, '', '', '', '2024-11-11 17:40:51', 1),
(130, 658, 658, 70.5, 587.5, 0, 0, '', '', '', '2024-11-11 17:41:13', 1),
(131, 658, 1000, 70.5, 587.5, 342, 0, '', '', '', '2024-11-11 17:50:39', 1),
(132, 658, 1000, 70.5, 587.5, 342, 0, '', '', '', '2024-11-11 17:51:15', 1),
(133, 658, 1000, 70.5, 587.5, 342, 0, '', '', '', '2024-11-11 17:51:51', 1),
(134, 658, 1000, 70.5, 587.5, 342, 0, '', '', '', '2024-11-11 17:53:28', 1),
(148, 1159, 11111, 124.18, 1034.82, 9952, 0, '', '', '', '2024-11-11 18:07:14', 1),
(150, 1198, 1500, 128.36, 1069.64, 302, 0, '', '', '', '2024-11-11 22:29:34', 1),
(151, 165, 200, 17.68, 147.32, 35, 0, '', '', '', '2024-11-11 22:29:45', 1),
(152, 346, 500, 37.07, 308.93, 154, 0, '', '', '', '2024-11-12 11:55:46', 1),
(153, 1257, 1500, 134.68, 1122.32, 243, 0, '', '', '', '2024-11-12 14:29:09', 1),
(154, 878, 1000, 94.07, 783.93, 122, 0, '', '', '', '2024-11-14 03:58:42', 1),
(155, 220, 300, 23.57, 196.43, 80, 0, '', '', '', '2024-11-13 03:59:24', 1),
(156, 599, 1000, 64.18, 534.82, 401, 0, '', '', '', '2024-11-14 04:04:14', 1),
(157, 59, 60, 6.32, 52.68, 1, 0, '', '', '', '2024-11-18 00:03:02', 1),
(159, 44, 50, 4.71, 39.29, 6, 20, 'Cenloid', '123-46121', 'student', '2024-11-18 00:32:04', 1),
(160, 47.2, 47, 5.06, 42.14, 0, 20, 'Reymar Yaba', '1080-2222', 'senior', '2024-11-18 00:33:50', 1),
(161, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-11-18 01:31:36', 1),
(162, 59, 60, 6.32, 52.68, 1, 0, '', '', '', '2024-11-27 19:36:00', 1),
(163, 59, 60, 6.32, 52.68, 1, 0, '', '', '', '2024-11-27 19:37:29', 1),
(164, 59, 59, 6.32, 52.68, 0, 0, '', '', '', '2024-11-28 00:10:44', 1),
(165, 59, 60, 6.32, 52.68, 1, 0, '', '', '', '2024-12-02 15:15:11', 1),
(166, 59, 60, 6.32, 52.68, 1, 0, '', '', '', '2024-12-06 23:21:13', 1),
(167, 59, 60, 6.32, 52.68, 1, 0, '', '', '', '2024-12-13 17:35:25', 1),
(168, 55, 55, 5.89, 49.11, 0, 0, '', '', '', '2024-12-13 18:13:38', 1),
(169, 59, 59, 6.32, 52.68, 0, 0, '', '', '', '2024-12-13 18:13:52', 1),
(170, 59, 59, 6.32, 52.68, 0, 0, '', '', '', '2024-12-13 18:14:02', 1),
(171, 118, 118, 12.64, 105.36, 0, 0, '', '', '', '2024-12-13 18:14:09', 1),
(172, 599, 700, 64.18, 534.82, 101, 0, '', '', '', '2024-12-13 18:14:36', 1),
(173, 59, 59, 6.32, 52.68, 0, 0, '', '', '', '2024-12-18 18:49:24', 1),
(174, 47.2, 47, 5.06, 42.14, 0, 20, 'Cenloid', '123-46121', 'PWD', '2024-12-25 21:15:38', 1),
(175, 59, 59, 6.32, 52.68, 0, 0, '', '', '', '2024-12-26 01:39:05', 1),
(176, 59, 59, 6.32, 52.68, 0, 0, '', '', '', '2024-12-26 01:44:00', 1),
(177, 55, 55, 5.89, 49.11, 0, 0, '', '', '', '2024-12-26 01:44:09', 1),
(178, 220, 220, 23.57, 196.43, 0, 0, '', '', '', '2024-12-26 01:44:24', 1),
(179, 599, 600, 64.18, 534.82, 1, 0, '', '', '', '2024-12-26 01:44:38', 1),
(180, 59, 60, 6.32, 52.68, 1, 0, '', '', '', '2024-12-26 01:44:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `tp_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`tp_id`, `transaction_id`, `product_id`, `product_name`, `qty`, `price`, `subtotal`) VALUES
(70, 61, 33, 'Crispy Bangus / Regular', 1, 100, 100),
(71, 61, 35, 'Rice / Plain Rice', 1, 55, 55),
(72, 61, 34, 'Hotsilog / Regular', 1, 59, 59),
(73, 61, 36, 'Crispy Pata / Regular', 1, 699, 699),
(74, 62, 35, 'Rice / Bagoong Fried Rice', 1, 130, 130),
(75, 62, 39, 'Pares testing lang / Regular', 1, 59, 59),
(76, 62, 37, 'Pares All Star / Basic Pares', 1, 59, 59),
(77, 63, 35, 'Rice / Plain Rice', 1, 55, 55),
(78, 63, 39, 'Pares testing lang / Regular', 1, 59, 59),
(79, 64, 35, 'Rice / Plain Rice', 3, 55, 165),
(80, 64, 40, 'paresan ni diwata / Regular', 3, 59, 177),
(81, 65, 34, 'Hotsilog / Regular', 3, 59, 177),
(82, 65, 33, 'Crispy Bangus / Regular', 3, 100, 300),
(83, 66, 34, 'Hotsilog / Regular', 3, 59, 177),
(84, 66, 37, 'Pares All Star / Basic Pares', 2, 59, 118),
(85, 67, 37, 'Pares All Star / Basic Pares', 3, 59, 177),
(86, 67, 36, 'Crispy Pata / Regular', 2, 699, 1398),
(87, 68, 39, 'Pares testing lang / Regular', 3, 59, 177),
(88, 68, 40, 'paresan ni diwata / Regular', 2, 59, 118),
(89, 69, 35, 'Rice / Plain Rice', 2, 55, 110),
(90, 69, 37, 'Pares All Star / Basic Pares', 3, 59, 177),
(91, 70, 35, 'Rice / Plain Rice', 2, 55, 110),
(92, 70, 37, 'Pares All Star / Basic Pares', 3, 59, 177),
(93, 71, 35, 'Rice / Plain Rice', 2, 55, 110),
(94, 71, 37, 'Pares All Star / Basic Pares', 2, 59, 177),
(95, 72, 35, 'Rice / Plain Rice', 2, 55, 110),
(96, 72, 37, 'Pares All Star / Basic Pares', 3, 59, 177),
(97, 73, 35, 'Rice / Plain Rice', 2, 55, 110),
(98, 73, 37, 'Pares All Star / Basic Pares', 3, 59, 177),
(99, 74, 35, 'Rice / Plain Rice', 2, 55, 110),
(100, 74, 37, 'Pares All Star / Basic Pares', 3, 59, 177),
(101, 75, 35, 'Rice / Plain Rice', 2, 55, 110),
(102, 75, 37, 'Pares All Star / Basic Pares', 3, 59, 177),
(103, 76, 35, 'Rice / Plain Rice', 2, 55, 110),
(104, 76, 39, 'Pares testing lang / Regular', 2, 59, 118),
(105, 77, 35, 'Rice / Plain Rice', 2, 55, 110),
(106, 77, 39, 'Pares testing lang / Regular', 2, 59, 118),
(107, 78, 35, 'Rice / Plain Rice', 2, 55, 110),
(108, 78, 39, 'Pares testing lang / Regular', 2, 59, 118),
(109, 79, 35, 'Rice / Plain Rice', 2, 55, 110),
(110, 79, 39, 'Pares testing lang / Regular', 3, 59, 177),
(111, 80, 35, 'Rice / Plain Rice', 2, 55, 110),
(112, 80, 39, 'Pares testing lang / Regular', 3, 59, 177),
(113, 81, 35, 'Rice / Plain Rice', 2, 55, 110),
(114, 81, 39, 'Pares testing lang / Regular', 3, 59, 177),
(115, 82, 35, 'Rice / Plain Rice', 2, 55, 110),
(116, 82, 39, 'Pares testing lang / Regular', 3, 59, 177),
(117, 83, 35, 'Rice / Plain Rice', 2, 55, 110),
(118, 83, 39, 'Pares testing lang / Regular', 3, 59, 177),
(119, 84, 35, 'Rice / Plain Rice', 2, 55, 110),
(120, 84, 39, 'Pares testing lang / Regular', 3, 59, 177),
(121, 85, 35, 'Rice / Plain Rice', 2, 55, 110),
(122, 85, 39, 'Pares testing lang / Regular', 3, 59, 177),
(123, 86, 35, 'Rice / Plain Rice', 2, 55, 110),
(124, 86, 39, 'Pares testing lang / Regular', 3, 59, 177),
(125, 87, 35, 'Rice / Plain Rice', 2, 55, 110),
(126, 87, 39, 'Pares testing lang / Regular', 3, 59, 177),
(127, 88, 35, 'Rice / Plain Rice', 1, 55, 55),
(128, 88, 39, 'Pares testing lang / Regular', 1, 59, 59),
(129, 89, 35, 'Rice / Plain Rice', 1, 55, 55),
(130, 89, 39, 'Pares testing lang / Regular', 1, 59, 59),
(131, 90, 35, 'Rice / Plain Rice', 1, 55, 55),
(132, 90, 39, 'Pares testing lang / Regular', 1, 59, 59),
(133, 91, 35, 'Rice / Plain Rice', 1, 55, 110),
(134, 91, 39, 'Pares testing lang / Regular', 2, 59, 118),
(135, 92, 34, 'Hotsilog / Regular', 1, 59, 59),
(136, 92, 35, 'Rice / Plain Rice', 1, 55, 55),
(137, 93, 34, 'Hotsilog / Regular', 1, 59, 59),
(138, 93, 35, 'Rice / Plain Rice', 1, 55, 55),
(139, 94, 34, 'Hotsilog / Regular', 1, 59, 59),
(140, 94, 35, 'Rice / Plain Rice', 1, 55, 55),
(141, 95, 35, 'Rice / Plain Rice', 3, 55, 165),
(142, 95, 39, 'Pares testing lang / Regular', 1, 59, 118),
(143, 96, 35, 'Rice / Plain Rice', 3, 55, 165),
(144, 96, 39, 'Pares testing lang / Regular', 1, 59, 118),
(145, 97, 35, 'Rice / Plain Rice', 3, 55, 165),
(146, 98, 35, 'Rice / Plain Rice', 3, 55, 165),
(147, 98, 39, 'Pares testing lang / Regular', 1, 59, 118),
(148, 99, 35, 'Rice / Plain Rice', 3, 55, 165),
(149, 99, 39, 'Pares testing lang / Regular', 1, 59, 118),
(150, 100, 35, 'Rice / Plain Rice', 3, 55, 165),
(151, 100, 39, 'Pares testing lang / Regular', 1, 59, 118),
(152, 101, 35, 'Rice / Plain Rice', 3, 55, 165),
(153, 101, 39, 'Pares testing lang / Regular', 1, 59, 118),
(154, 102, 35, 'Rice / Plain Rice', 3, 55, 165),
(155, 102, 39, 'Pares testing lang / Regular', 1, 59, 118),
(156, 103, 35, 'Rice / Plain Rice', 1, 55, 220),
(157, 103, 37, 'Pares All Star / Basic Pares', 1, 59, 236),
(158, 104, 35, 'Rice / Plain Rice', 5, 55, 275),
(159, 105, 35, 'Rice / Plain Rice', 1, 55, 275),
(160, 106, 35, 'Rice / Plain Rice', 2, 55, 110),
(161, 107, 34, 'Hotsilog / Regular', 6, 59, 354),
(162, 107, 33, 'Crispy Bangus / Regular', 5, 100, 500),
(163, 107, 36, 'Crispy Pata / Regular', 4, 699, 2796),
(164, 107, 35, 'Rice / Plain Rice', 3, 55, 165),
(165, 108, 34, 'Hotsilog / Regular', 6, 59, 354),
(166, 108, 33, 'Crispy Bangus / Regular', 5, 100, 500),
(167, 108, 36, 'Crispy Pata / Regular', 4, 699, 2796),
(168, 108, 35, 'Rice / Plain Rice', 3, 55, 165),
(169, 109, 34, 'Hotsilog / Regular', 6, 59, 354),
(170, 109, 33, 'Crispy Bangus / Regular', 5, 100, 500),
(171, 109, 36, 'Crispy Pata / Regular', 4, 699, 2796),
(172, 109, 35, 'Rice / Plain Rice', 3, 55, 165),
(173, 110, 45, 'Crispy tight / Regular', 1, 599, 599),
(174, 111, 45, 'Crispy tight / Regular', 1, 599, 599),
(175, 112, 45, 'Crispy tight / Regular', 1, 599, 599),
(176, 113, 45, 'Crispy tight / Regular', 1, 599, 599),
(177, 114, 45, 'Crispy tight / Regular', 1, 599, 599),
(178, 115, 45, 'Crispy tight / Regular', 1, 599, 599),
(179, 117, 45, 'Crispy tight / Regular', 1, 599, 599),
(180, 118, 48, 'Boneless Crispy Pata / Regular', 1, 599, 599),
(181, 120, 52, 'Crispy Noodles Seafood / Regular', 1, 220, 220),
(182, 121, 51, 'Sausage / Regular', 1, 59, 59),
(183, 122, 50, 'Longganisa / Regular', 1, 59, 59),
(184, 123, 49, 'Crispy tight / Crispy liempo', 1, 599, 599),
(185, 124, 54, 'Noodles Beef / Regular', 1, 220, 220),
(186, 124, 53, 'Mami pares / Regular', 1, 220, 220),
(187, 125, 51, 'Sausage / Regular', 1, 59, 59),
(188, 125, 50, 'Longganisa / Regular', 1, 59, 59),
(189, 126, 51, 'Sausage / Regular', 1, 59, 59),
(190, 126, 50, 'Longganisa / Regular', 1, 59, 59),
(191, 127, 49, 'Crispy tight / Crispy liempo', 1, 599, 599),
(192, 127, 48, 'Boneless Crispy Pata / Regular', 1, 599, 599),
(193, 128, 47, 'Pares Overload / Regular', 2, 59, 118),
(194, 128, 45, 'Crispy tight / Regular', 1, 599, 599),
(195, 129, 47, 'Pares Overload / Regular', 2, 59, 118),
(196, 129, 45, 'Crispy tight / Regular', 1, 599, 599),
(197, 130, 47, 'Pares Overload / Regular', 1, 59, 59),
(198, 130, 45, 'Crispy tight / Regular', 1, 599, 599),
(199, 131, 45, 'Crispy tight / Regular', 1, 599, 599),
(200, 131, 47, 'Pares Overload / Regular', 1, 59, 59),
(201, 132, 47, 'Pares Overload / Regular', 1, 59, 59),
(202, 132, 45, 'Crispy tight / Regular', 1, 599, 599),
(203, 133, 47, 'Pares Overload / Regular', 1, 59, 59),
(204, 133, 45, 'Crispy tight / Regular', 1, 599, 599),
(205, 134, 47, 'Pares Overload / Regular', 1, 59, 59),
(206, 134, 45, 'Crispy tight / Regular', 1, 599, 599),
(207, 135, 48, 'Boneless Crispy Pata / Regular', 7, 599, 4193),
(208, 135, 47, 'Pares Overload / Regular', 4, 59, 295),
(209, 136, 48, 'Boneless Crispy Pata / Regular', 7, 599, 4193),
(210, 136, 47, 'Pares Overload / Regular', 5, 59, 295),
(211, 137, 48, 'Boneless Crispy Pata / Regular', 7, 599, 4193),
(212, 137, 47, 'Pares Overload / Regular', 5, 59, 295),
(213, 138, 48, 'Boneless Crispy Pata / Regular', 7, 599, 4193),
(214, 138, 47, 'Pares Overload / Regular', 5, 59, 295),
(237, 150, 45, 'Crispy tight / Regular', 1, 599, 599),
(238, 150, 48, 'Boneless Crispy Pata / Regular', 1, 599, 599),
(239, 151, 46, 'Rice / Plain Rice', 3, 55, 165),
(240, 152, 47, 'Pares Overload / Regular', 4, 59, 236),
(241, 152, 46, 'Rice / Plain Rice', 2, 55, 110),
(242, 153, 45, 'Crispy tight / Regular', 1, 599, 599),
(243, 153, 47, 'Pares Overload / Regular', 1, 59, 59),
(244, 153, 55, 'Kare Kare / Regular', 1, 599, 599),
(245, 154, 52, 'Crispy Noodles Seafood / Regular', 1, 220, 220),
(246, 154, 51, 'Sausage / Regular', 1, 59, 59),
(247, 154, 55, 'Kare Kare / Regular', 1, 599, 599),
(248, 155, 52, 'Crispy Noodles Seafood / Regular', 1, 220, 220),
(249, 156, 45, 'Crispy tight / Regular', 1, 599, 599),
(250, 157, 47, 'Pares Overload / Regular', 1, 59, 59),
(251, 158, 47, 'Pares Overload / Regular', 1, 59, 118),
(252, 159, 46, 'Rice / Plain Rice', 1, 55, 55),
(253, 160, 47, 'Pares Overload / Regular', 1, 59, 59),
(254, 161, 45, 'Crispy tight / Regular', 1, 599, 599),
(255, 162, 47, 'Pares Overload / Regular', 1, 59, 59),
(256, 163, 47, 'Pares Overload / Regular', 1, 59, 59),
(257, 164, 47, 'Pares Overload / Regular', 1, 59, 59),
(258, 165, 51, 'Sausage / Regular', 1, 59, 59),
(259, 166, 47, 'Pares Overload / Regular', 1, 59, 59),
(260, 167, 50, 'Longganisa / Regular', 1, 59, 59),
(261, 168, 46, 'Rice / Plain Rice', 1, 55, 55),
(262, 169, 51, 'Sausage / Regular', 1, 59, 59),
(263, 170, 47, 'Pares Overload / Regular', 1, 59, 59),
(264, 171, 47, 'Pares Overload / Regular', 1, 59, 118),
(265, 172, 45, 'Crispy tight / Regular', 1, 599, 599),
(266, 173, 47, 'Pares Overload / Regular', 1, 59, 59),
(267, 174, 47, 'Pares Overload / Regular', 1, 59, 59),
(268, 175, 50, 'Longganisa / Regular', 1, 59, 59),
(269, 176, 47, 'Pares Overload / Regular', 1, 59, 59),
(270, 177, 46, 'Rice / Plain Rice', 1, 55, 55),
(271, 178, 54, 'Noodles Beef / Regular', 1, 220, 220),
(272, 179, 45, 'Crispy tight / Regular', 1, 599, 599),
(273, 180, 50, 'Longganisa / Regular', 1, 59, 59);

-- --------------------------------------------------------

--
-- Table structure for table `unit_of_measurement`
--

CREATE TABLE `unit_of_measurement` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(11) NOT NULL,
  `archive_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_of_measurement`
--

INSERT INTO `unit_of_measurement` (`unit_id`, `unit_name`, `archive_status`) VALUES
(1, 'pieces', 0),
(2, 'box', 0),
(3, 'kg', 0),
(4, 'grams', 0),
(7, 'Liters', 0),
(8, 'Milliliter', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` int(255) NOT NULL,
  `archive_status` int(11) NOT NULL,
  `security_question1` int(11) NOT NULL,
  `answer_1` varchar(11) NOT NULL,
  `login_attempt` int(11) NOT NULL,
  `next_attempt` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `password`, `user_role`, `archive_status`, `security_question1`, `answer_1`, `login_attempt`, `next_attempt`) VALUES
(1, 'Keith', 'De Asis', 'admin', '$2y$10$JQ55Q5K/036cZw4xB8ixI.ouk2n1z1GQDYwP6wd3fpZHpCuGysZZO', 1, 0, 1, 'pitchie', 3, '2025-01-01 20:44:20.000000'),
(2, 'Juan ', 'Dela Cruz', 'SeafoodShrimp', '$2y$10$XyissbK7VHvJdQ1QwhTPAuM3HVO6wvFCtdDPYi3KiAeUPKr08b8Sq', 2, 1, 6, 'lambo', 1, NULL),
(3, 'Limrod', 'Alipao', 'Haruu', '$2y$10$aCtCN2QujkjBuVxWFME4xuVZNWo7JCnzFYU6WbTrzjZ0ZeU19GbJu', 3, 0, 7, 'gabriel', 0, NULL),
(9, 'Cenloid', 'Perez', 'Modako', '$2y$10$gm/O.ddtIO8sDGKMzKAgT.5v9vGsA1mLbOp7.2JzMi5L.f5n1dhqi', 2, 0, 7, 'juan', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `add_ons`
--
ALTER TABLE `add_ons`
  ADD PRIMARY KEY (`addOns_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `security_question`
--
ALTER TABLE `security_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`system_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`tp_id`);

--
-- Indexes for table `unit_of_measurement`
--
ALTER TABLE `unit_of_measurement`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `add_ons`
--
ALTER TABLE `add_ons`
  MODIFY `addOns_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000072;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `security_question`
--
ALTER TABLE `security_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `system_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `unit_of_measurement`
--
ALTER TABLE `unit_of_measurement`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
