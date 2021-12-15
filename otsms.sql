-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2021 at 01:54 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `otsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `customization`
--

CREATE TABLE `customization` (
  `custom_id` bigint(20) NOT NULL,
  `reference_id` varchar(50) NOT NULL,
  `garment_type` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Pending',
  `pickup_date` date NOT NULL,
  `downpayment` double NOT NULL,
  `fullpayment` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `proof_of_payment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customization`
--

INSERT INTO `customization` (`custom_id`, `reference_id`, `garment_type`, `details`, `user_id`, `status`, `pickup_date`, `downpayment`, `fullpayment`, `price`, `proof_of_payment`, `created_at`) VALUES
(1, 'C-202112102020', 'Jersey', '<table class=\"table table-bordered\">\n                                            <thead>\n                                                <tr>\n                                                    <td><b>Quantity per Size: sample</b></td>\n                                                </tr>\n                                                <tr>\n                                                    <td><b>Color:&nbsp;</b><span style=\"font-weight: bolder;\">sample</span></td>\n                                                </tr>\n                                                <tr>\n                                                    <td><b>Measurement:&nbsp;</b><span style=\"font-weight: bolder;\">sample</span></td>\n                                                </tr>\n                                            </thead>\n                                        </table>', 7, 'Active', '2021-12-29', 500, 8000, NULL, 'uploads/customization/4yD2sCev0gr1uHMLF6GRceKtgVUUQFnCOMyzbCLT.webp', '2021-12-10 15:49:20'),
(3, 'C-202112141919', 'Jersey', '<table class=\"table table-bordered\">\n                                            <thead>\n                                                <tr>\n                                                    <td><b>Quantity per Size:</b> </td>\n                                                </tr>\n                                                <tr>\n                                                    <td><b>Color:</b> </td>\n                                                </tr>\n                                                <tr>\n                                                    <td><b>Measurement:</b> </td>\n                                                </tr>\n                                            </thead>\n                                        </table>', 6, 'Pending', '2021-12-30', 0, 0, 5000, 'uploads/customization/bk85hF8SNVwBVlguCALr4jN8gwjQn8SQfALmIXK5.png', '2021-12-14 18:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `employee_schedule`
--

CREATE TABLE `employee_schedule` (
  `schedule_id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `day` varchar(15) NOT NULL,
  `time_from` time DEFAULT NULL,
  `time_to` time DEFAULT NULL,
  `off_duty` tinyint(1) DEFAULT NULL,
  `create_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_schedule`
--

INSERT INTO `employee_schedule` (`schedule_id`, `user_id`, `day`, `time_from`, `time_to`, `off_duty`, `create_by`, `created_at`) VALUES
(22, 2, 'Monday', NULL, NULL, 1, 2, '2021-12-05 01:59:37'),
(23, 2, 'Tuesday', '01:12:00', '08:12:00', 0, 2, '2021-12-05 01:59:37'),
(24, 2, 'Wednesday', '13:12:00', '22:12:00', 0, 2, '2021-12-05 01:59:37'),
(25, 2, 'Thursday', '23:12:00', '12:12:00', 0, 2, '2021-12-05 01:59:37'),
(26, 2, 'Friday', '08:12:00', '17:12:00', 0, 2, '2021-12-05 01:59:37'),
(27, 2, 'Saturday', NULL, NULL, 0, 2, '2021-12-05 01:59:37'),
(28, 2, 'Sunday', NULL, NULL, 0, 2, '2021-12-05 01:59:37'),
(36, 1, 'Monday', '12:59:00', '00:58:00', 0, 2, '2021-12-05 02:00:32'),
(37, 1, 'Tuesday', NULL, NULL, 0, 2, '2021-12-05 02:00:32'),
(38, 1, 'Wednesday', NULL, NULL, 0, 2, '2021-12-05 02:00:32'),
(39, 1, 'Thursday', NULL, NULL, 0, 2, '2021-12-05 02:00:32'),
(40, 1, 'Friday', '17:12:00', '06:12:00', 0, 2, '2021-12-05 02:00:32'),
(41, 1, 'Saturday', NULL, NULL, 0, 2, '2021-12-05 02:00:32'),
(42, 1, 'Sunday', NULL, NULL, 0, 2, '2021-12-05 02:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `item_name`, `description`, `price`, `quantity`, `status`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(1, 'Scissor', 'for cutting', 10, 100, 'Active', 2, '2021-12-04 01:24:41', NULL, '2021-12-09 11:03:04'),
(3, 'Needles', NULL, 57, 39, 'Active', 2, '2021-12-04 02:23:06', NULL, '2021-12-09 10:57:00'),
(4, 'sad', NULL, 2, 32, 'Active', 2, '2021-12-04 13:40:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `measurement`
--

CREATE TABLE `measurement` (
  `measurement_id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shoulder_length` double DEFAULT NULL,
  `sleeve_length` double DEFAULT NULL,
  `bust_chest` double DEFAULT NULL,
  `waist` double DEFAULT NULL,
  `skirt_length` double DEFAULT NULL,
  `slack_length` double DEFAULT NULL,
  `slack_front_rise` double DEFAULT NULL,
  `slack_fit_seat` double DEFAULT NULL,
  `slack_fit_thigh` double DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `measurement`
--

INSERT INTO `measurement` (`measurement_id`, `user_id`, `shoulder_length`, `sleeve_length`, `bust_chest`, `waist`, `skirt_length`, `slack_length`, `slack_front_rise`, `slack_fit_seat`, `slack_fit_thigh`, `created_by`, `created_at`) VALUES
(3, 2, 1, 2, 3, 4, 55, 6, 7, 8, 9, 2, '2021-12-05 17:29:55'),
(4, 6, 3, 2, 4, 6, NULL, NULL, NULL, NULL, NULL, 6, '2021-12-10 09:16:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_12_02_074214_create_failed_jobs_table', 0),
(6, '2021_12_02_074214_create_password_resets_table', 0),
(7, '2021_12_02_074214_create_personal_access_tokens_table', 0),
(8, '2021_12_02_074214_create_users_table', 0),
(9, '2021_12_02_074227_create_failed_jobs_table', 0),
(10, '2021_12_02_074227_create_password_resets_table', 0),
(11, '2021_12_02_074227_create_personal_access_tokens_table', 0),
(12, '2021_12_02_074227_create_users_table', 0),
(13, '2021_12_02_075540_create_users_table', 0),
(14, '2021_12_02_075541_add_foreign_keys_to_users_table', 0),
(15, '2021_12_03_050352_create_product_sales_table', 0),
(16, '2021_12_03_050353_add_foreign_keys_to_product_sales_table', 0),
(17, '2021_12_03_162158_create_product_sales_table', 0),
(18, '2021_12_03_162159_add_foreign_keys_to_product_sales_table', 0),
(19, '2021_12_03_170215_create_inventory_table', 0),
(20, '2021_12_03_192721_create_users_table', 0),
(21, '2021_12_03_192722_add_foreign_keys_to_users_table', 0),
(22, '2021_12_04_053507_create_failed_jobs_table', 0),
(23, '2021_12_04_053507_create_inventory_table', 0),
(24, '2021_12_04_053507_create_password_resets_table', 0),
(25, '2021_12_04_053507_create_personal_access_tokens_table', 0),
(26, '2021_12_04_053507_create_product_sales_table', 0),
(27, '2021_12_04_053507_create_user_type_table', 0),
(28, '2021_12_04_053507_create_users_table', 0),
(29, '2021_12_04_053508_add_foreign_keys_to_product_sales_table', 0),
(30, '2021_12_04_053508_add_foreign_keys_to_users_table', 0),
(31, '2021_12_04_162710_create_employee_schedule_table', 0),
(32, '2021_12_04_162711_add_foreign_keys_to_employee_schedule_table', 0),
(33, '2021_12_05_082533_create_measurement_table', 0),
(34, '2021_12_09_032213_create_orders_table', 0),
(35, '2021_12_09_032214_add_foreign_keys_to_orders_table', 0),
(36, '2021_12_09_043927_create_orders_table', 0),
(37, '2021_12_09_043928_add_foreign_keys_to_orders_table', 0),
(38, '2021_12_10_070809_create_customization_table', 0),
(39, '2021_12_10_074022_create_customization_table', 0),
(40, '2021_12_10_074023_add_foreign_keys_to_customization_table', 0),
(41, '2021_12_13_130428_create_payment_methods_table', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `reference_id` varchar(100) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `downpayment_amount` double DEFAULT NULL,
  `receipt` text DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `addtional_fee` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `product_id`, `reference_id`, `user_id`, `pickup_date`, `downpayment_amount`, `receipt`, `return_date`, `addtional_fee`, `status`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(1, 5, 'ITM-20211215565656', 6, '2021-12-23', 400, 'uploads/orders/3LExJddGxgtMEup98NWdtFNKAsoRTDjcsUAyoTKk.webp', NULL, NULL, 'Approved', 6, '2020-12-15 20:14:56', NULL, '2021-12-15 20:36:09'),
(2, 6, 'ITM-20211215040404', 6, '2021-12-23', 1000, 'uploads/orders/kAIwwjLxq6spqp2JzWoU164cERF0uv2k8AcAhWhd.webp', NULL, NULL, 'Approved', 6, '2020-12-15 20:15:04', NULL, '2021-12-15 20:36:16'),
(3, 2, 'ITM-20211215111111', 6, '2021-12-29', 800, 'uploads/orders/7JRpcbQhRvvH0NSzFkprwgQghnux5IhqvFpzN9Jj.webp', '2021-12-29', 0, 'Approved', 6, '2021-12-15 20:15:11', NULL, '2021-12-15 20:24:56'),
(4, 1, 'ITM-20211215151515', 6, '2021-12-24', 500, 'uploads/orders/jj4zaLHBataOGbg1B5fR9xuVbBe5x4R9lh0PaK2v.jpg', '2021-12-23', 0, 'Approved', 6, '2021-12-15 20:15:15', NULL, '2021-12-15 20:25:09'),
(5, 7, 'ITM-20211215191919', 6, NULL, NULL, NULL, NULL, NULL, 'Pending', 6, '2021-12-15 20:15:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `method_id` bigint(20) NOT NULL,
  `method_name` varchar(150) NOT NULL,
  `bank_name` varchar(250) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `account_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`method_id`, `method_name`, `bank_name`, `account_no`, `account_name`) VALUES
(4, 'GCASH Payment', 'GCash', '0901256884', 'Gcash sample'),
(5, 'BPI', 'BPI', '1234567899', 'BPI Account Name');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

CREATE TABLE `product_sales` (
  `product_id` bigint(20) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
  `amount` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `type` varchar(10) NOT NULL,
  `create_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_sales`
--

INSERT INTO `product_sales` (`product_id`, `product_code`, `product_name`, `description`, `amount`, `quantity`, `image`, `status`, `type`, `create_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(1, 'asd', 'asdasd', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1000', '12', 'uploads/products/LON7sfUBUFCx5V4LtM3B7Sdhwd5HuNFX5pEkEZSQ.jpg', 'Active', 'Rent', 2, '2021-12-03 17:29:52', NULL, '2021-12-10 22:07:16'),
(2, 'test', 'test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1500', '1', 'uploads/products/LTNxJpiBeXeKtUnxPGlMPyOZOdetkaQZXv6vZKDW.jpg', 'Active', 'Rent', 2, '2021-11-03 17:50:54', NULL, '2021-12-15 13:06:57'),
(5, 'sample', 'sample', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '800', '1', 'uploads/products/DySeNVhVu2ik43qSEhw8lZ7vM8TTiBB4pu7GGkDm.jpg', 'Active', 'Sale', 2, '2021-12-03 23:02:14', NULL, '2021-12-10 22:07:23'),
(6, 'new', 'new', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1120', '121', 'uploads/products/gbJ7nQaQBoi8ko4y4MHxZQju96zo0P2yx8JIgove.jpg', 'Active', 'Sale', 2, '2021-12-04 00:23:19', NULL, '2021-12-10 22:07:26'),
(7, 'asdasda', 'asdasd', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '3200', '32', 'uploads/products/1BLaoZm680KHL4GTLeqMWSVXIOpDkbJFVM0IXrrk.jpg', 'Active', 'Sale', 2, '2021-12-04 00:25:19', NULL, '2021-12-10 22:07:28'),
(8, 'rent', 'rent', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1500', '1', 'uploads/products/s5KMGA4LPACIulowXcSUDHzm26vY6mZa9R3jMESd.jpg', 'Active', 'Rent', 2, '2021-12-04 00:37:04', NULL, '2021-12-10 22:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 0,
  `contact_no` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` double DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_changed` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `status`, `first_name`, `middle_name`, `last_name`, `user_type`, `contact_no`, `birthday`, `email`, `salary`, `email_verified_at`, `password`, `password_changed`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Active', 'John Michael', 'Espina', 'Panganiban', 1, '09123457', '2021-01-01', 'admin@gmail.com', NULL, NULL, '$2y$10$setuzxK8n3bN.INosfsM.uTZ/V14wMf5PnCeE66NLtISsGtmejyFu', 1, NULL, '2021-12-02 00:18:07', '2021-12-02 00:18:07'),
(2, 'Active', 'John Michael', 'Espina', 'Panganiban', 2, '0912345671', '2021-03-03', 'admin2@gmail.com', NULL, NULL, '$2y$10$pDsd1obpihRMd3Nc/BJ/p.ogJKVqHnMwvclrhRX9/u2IWqP/Ii3bq', 1, NULL, '2021-12-02 07:20:36', '2021-12-03 11:11:01'),
(6, 'Active', 'customer', NULL, 'customer', 0, '12345678', '2021-01-01', 'test@gmail.com', NULL, NULL, '$2y$10$E.EL6Sfb1AG/RHJLc6W5deoRdkifqUhKr4N/ZUGh4JFHUPDYiBNfy', 1, NULL, '2021-12-08 17:48:35', '2021-12-08 17:48:35'),
(7, 'Active', 'John', 'E', 'Doe', 0, '12345678', '2021-01-01', 'arya@gmail.com', NULL, NULL, '$2y$10$nqz2B34bhxuh3TA5Rdq0PeNVa9CKxKPHzb2RWnHQ4cR4WyA1SQr8u', 1, NULL, '2021-12-09 18:47:16', '2021-12-09 18:47:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `user_type`) VALUES
(0, 'Customer'),
(1, 'Admin'),
(2, 'Tailor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customization`
--
ALTER TABLE `customization`
  ADD PRIMARY KEY (`custom_id`),
  ADD KEY `fk_custom_user_id` (`user_id`);

--
-- Indexes for table `employee_schedule`
--
ALTER TABLE `employee_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `fk_schedule_user_id` (`user_id`),
  ADD KEY `fk_schedule_created_by` (`create_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `measurement`
--
ALTER TABLE `measurement`
  ADD PRIMARY KEY (`measurement_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_product_id` (`product_id`),
  ADD KEY `fk_orders_user_id` (`user_id`),
  ADD KEY `fk_orders_created_by` (`created_by`),
  ADD KEY `fk_orders_modified_by` (`modified_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`method_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_user_created_by` (`create_by`),
  ADD KEY `fk_user_modified_by` (`modified_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `fk_user_type_id` (`user_type`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customization`
--
ALTER TABLE `customization`
  MODIFY `custom_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_schedule`
--
ALTER TABLE `employee_schedule`
  MODIFY `schedule_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `measurement`
--
ALTER TABLE `measurement`
  MODIFY `measurement_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `method_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customization`
--
ALTER TABLE `customization`
  ADD CONSTRAINT `fk_custom_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_schedule`
--
ALTER TABLE `employee_schedule`
  ADD CONSTRAINT `fk_schedule_created_by` FOREIGN KEY (`create_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_schedule_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_product_id` FOREIGN KEY (`product_id`) REFERENCES `product_sales` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD CONSTRAINT `fk_user_created_by` FOREIGN KEY (`create_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_type_id` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
