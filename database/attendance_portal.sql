-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2022 at 01:28 PM
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
-- Database: `laravel_internship_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `password`, `profile_pic`, `created_at`, `updated_at`) VALUES
(2, 'Ayesha Khan', 'admin@gmail.com', '$2y$10$EtBnvEt45POpFrgmdz7Qpe5UL7JF/mivBs6L5YpM6XImttPmnFEgu', '1658826082.jpg', '2022-07-26 04:01:22', '2022-07-26 04:01:22');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presents` int(11) DEFAULT NULL,
  `leaves` int(11) DEFAULT NULL,
  `grades` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`user_id`, `name`, `email`, `presents`, `leaves`, `grades`, `created_at`, `updated_at`) VALUES
(17, 'Ayesha Khan', 'ayesha@gmail.com', 4, 1, 'D', '2022-07-26 03:45:28', '2022-07-26 03:50:44'),
(18, 'Muhammad Ibrahim', 'ibrahim@gmail.com', 4, 1, 'D', '2022-07-26 03:46:15', '2022-07-26 03:58:37'),
(19, 'Eshaal Noor', 'eshaal@gmail.com', 3, 2, 'D', '2022-07-26 03:47:26', '2022-07-26 03:56:41');

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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2022_07_24_062132_create_users_table', 1),
(3, '2022_07_24_130824_create_admin_table', 2);

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `profile_pic`, `created_at`, `updated_at`) VALUES
(17, 'Ayesha Khan', 'ayesha@gmail.com', '$2y$10$PQqnIZ2FWZgzlRqqyDFDtux7j78YtQByKliJUUQqLtMYJdTOJGXyW', '1658825127.jpg', '2022-07-26 03:45:28', '2022-07-26 03:45:28'),
(18, 'Muhammad Ibrahim', 'ibrahim@gmail.com', '$2y$10$zQ1rL1Zh5S01nkNQddapWOUQYyxUFjlxerRUQ38Qpq815LKbNyXWa', '1658825174.jpg', '2022-07-26 03:46:15', '2022-07-26 03:46:15'),
(19, 'Eshaal Noor', 'eshaal@gmail.com', '$2y$10$//Drc1hCMLaVsFDDRTtij./lvrZ6PBcod5ykC3FI0WjNaT73M2qwq', '1658825245.jpg', '2022-07-26 03:47:26', '2022-07-26 03:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `users_attendance`
--

CREATE TABLE `users_attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attendance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_req` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `leave_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_attendance`
--

INSERT INTO `users_attendance` (`id`, `name`, `email`, `attendance`, `leave_req`, `attendance_date`, `leave_status`, `created_at`, `updated_at`) VALUES
(55, 'Ayesha Khan', 'ayesha@gmail.com', 'Present', NULL, '2022-07-21', '', NULL, NULL),
(56, 'Ayesha Khan', 'ayesha@gmail.com', 'Present', NULL, '2022-07-22', '', NULL, NULL),
(57, 'Ayesha Khan', 'ayesha@gmail.com', 'Present', NULL, '2022-07-23', '', NULL, NULL),
(58, 'Ayesha Khan', 'ayesha@gmail.com', 'Present', NULL, '2022-07-24', '', NULL, NULL),
(59, 'Ayesha Khan', 'ayesha@gmail.com', 'Leave', 'Respected sir, I\'ve an urgent piece of work at home. That\'s why I\'m unable to come. Kindly grant me leave for one day. Thanks.', '2022-07-25', '', NULL, NULL),
(60, 'Eshaal Noor', 'eshaal@gmail.com', 'Leave', 'Respected sir, I\'ve an urgent piece of work at home. That\'s why I\'m unable to come. Kindly grant me leave for one day. Thanks.', '2022-07-25', '', NULL, NULL),
(61, 'Eshaal Noor', 'eshaal@gmail.com', 'Present', NULL, '2022-07-22', '', NULL, NULL),
(62, 'Eshaal Noor', 'eshaal@gmail.com', 'Present', NULL, '2022-07-23', '', NULL, NULL),
(63, 'Eshaal Noor', 'eshaal@gmail.com', 'Leave', 'Respected sir, I\'m having fever. That\'s why I\'m unable to come. Kindly grant me leave. Thanks.', '2022-07-24', 'Disapproved', NULL, '2022-07-26 04:03:04'),
(64, 'Eshaal Noor', 'eshaal@gmail.com', 'Present', NULL, '2022-07-21', '', NULL, NULL),
(65, 'Muhammad Ibrahim', 'ibrahim@gmail.com', 'Present', NULL, '2022-07-21', '', NULL, NULL),
(66, 'Muhammad Ibrahim', 'ibrahim@gmail.com', 'Leave', 'Respected sir, I\'ve an urgent piece of work at home. That\'s why I\'m unable to come. Kindly grant me leave for one day. Thanks.', '2022-07-22', 'Approved', NULL, '2022-07-26 04:03:01'),
(67, 'Muhammad Ibrahim', 'ibrahim@gmail.com', 'Present', NULL, '2022-07-23', '', NULL, NULL),
(68, 'Muhammad Ibrahim', 'ibrahim@gmail.com', 'Present', NULL, '2022-07-24', '', NULL, NULL),
(69, 'Muhammad Ibrahim', 'ibrahim@gmail.com', 'Present', NULL, '2022-07-25', '', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_attendance`
--
ALTER TABLE `users_attendance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users_attendance`
--
ALTER TABLE `users_attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
