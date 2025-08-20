-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2025 at 01:00 PM
-- Server version: 9.4.0
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_appointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','accepted','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `doctor_symptoms` text COLLATE utf8mb4_unicode_ci,
  `prescriptions` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `status`, `notes`, `created_at`, `updated_at`, `doctor_symptoms`, `prescriptions`) VALUES
(1, 7, 6, '2025-08-15', '09:00:00', 'completed', NULL, '2025-08-13 06:00:17', '2025-08-19 08:03:41', 'chest pain', 'dfddgdgfdgdf'),
(2, 7, 5, '2025-08-15', '14:30:00', 'pending', NULL, '2025-08-14 05:58:48', '2025-08-14 05:58:48', NULL, NULL),
(3, 7, 5, '2025-08-14', '12:00:00', 'pending', NULL, '2025-08-14 06:02:05', '2025-08-14 06:02:05', NULL, NULL),
(4, 7, 5, '2025-08-20', '13:00:00', 'pending', NULL, '2025-08-18 09:24:39', '2025-08-18 09:24:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `availabilities`
--

CREATE TABLE `availabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED NOT NULL,
  `day_of_week` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slot_duration` int NOT NULL DEFAULT '15'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `availabilities`
--

INSERT INTO `availabilities` (`id`, `doctor_id`, `day_of_week`, `start_time`, `end_time`, `created_at`, `updated_at`, `slot_duration`) VALUES
(1, 3, 'Monday', '08:00:00', '14:00:00', '2025-08-02 04:05:40', '2025-08-02 04:05:40', 15);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `specialization_id` bigint UNSIGNED NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `can_manage_slots` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `specialization_id`, `bio`, `created_at`, `updated_at`, `can_manage_slots`) VALUES
(1, 4, 6, '5 yr experience from abroad', '2025-07-31 09:16:10', '2025-07-31 09:16:10', 0),
(2, 5, 2, '2 yr experience from mims', '2025-07-31 09:20:18', '2025-07-31 09:20:18', 0),
(3, 6, 1, 'senior doctor with 10 yr experience', '2025-07-31 09:22:13', '2025-08-01 04:36:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `global_time_slots`
--

CREATE TABLE `global_time_slots` (
  `id` bigint UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_duration` int NOT NULL,
  `days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `global_time_slots`
--

INSERT INTO `global_time_slots` (`id`, `start_time`, `end_time`, `slot_duration`, `days`, `created_at`, `updated_at`) VALUES
(1, '09:00:00', '17:00:00', 30, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]', '2025-08-08 09:27:27', '2025-08-08 09:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_04_105217_add_role_to_users_table', 1),
(5, '2025_07_13_110031_add_status_to_users_table', 1),
(6, '2025_07_17_182311_create_specializations_table', 1),
(7, '2025_07_18_062233_create_doctors_table', 1),
(8, '2025_07_18_062637_create_availabilities_table', 1),
(9, '2025_07_18_062809_create_appointments_table', 1),
(10, '2025_07_18_062932_create_notifications_table', 1),
(11, '2025_07_24_112406_add_columns_to_availabilities_table', 2),
(12, '2025_07_25_011507_update_availabilities_table', 2),
(13, '2025_07_25_144319_update_availabilities_add_start_end_time', 2),
(14, '2025_07_27_062442_update_availabilities_add_slot_duration', 2),
(15, '2025_07_27_183928_create_global_time_slots_table', 2),
(16, '2025_07_27_185245_add_can_manage_slots_to_doctors_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('bashibashima@gmail.com', '$2y$12$6qagM4MAiBataj2nqwnwweuWyvvJVNr/NT8JIIORZRx4jeY2qRice', '2025-08-06 06:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0cN1mg9WF34dHqHI11OvqXebblHGQdTtsL8B0msC', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiU1gxT3dTakpPSHNYaTcwamdzZkNtMzBWRzZOZkVpa2xVOWllTlFvVSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZG9jdG9yL2RvY3Rvci9wYXRpZW50LzcvaGlzdG9yeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7fQ==', 1755686990),
('8fcflBErVI9I5m3Pbif84RQcL6isHqKMrx2SxKG2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWUyTW5USnZYNjJETGVBS3REdDdncWJsOFFUMXZ4Z2I0MkZ5cUZmSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1755670314),
('HuSVcUIhDr69lF07VUYZdaz2AjA1QxR0bctNxeGm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFdVUFhjcThFMVNzMkk1SmtPV0J0cWJzWW1hZEdCcVF4N0NPMEU5RSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BhdGllbnQvZGFzaGJvYXJkIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wYXRpZW50L2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1755670306),
('PscjLaAY2gekdIafDqcON5l24rf2fVSDVQlco9h3', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTEVjSHoxSk5vRDdnNlJoTlg1UG41cFdDTzdsaXdhdUNRcnlYeG94NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kb2N0b3IvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1755677324),
('PSDvDKgAxKBQ59pxj0RCXGVdPWUv2HeqDsXf8zDR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYzlHZWlMRHFRWlRQVGkwTnpaMlM3YWNsOFl3RHZ4b2NXRmdZaTVNNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1755670338);

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Cardiologist', '2025-07-31 09:13:21', '2025-07-31 09:13:21'),
(2, 'Dermatologist', '2025-07-31 09:13:21', '2025-07-31 09:13:21'),
(3, 'Pediatrician', '2025-07-31 09:13:21', '2025-07-31 09:13:21'),
(4, 'Gynecologist', '2025-07-31 09:13:21', '2025-07-31 09:13:21'),
(5, 'Neurologist', '2025-07-31 09:13:21', '2025-07-31 09:13:21'),
(6, 'Orthopedic', '2025-07-31 09:13:21', '2025-07-31 09:13:21'),
(7, 'Psychiatrist', '2025-07-31 09:13:21', '2025-07-31 09:13:21'),
(8, 'Dentist', '2025-07-31 09:13:21', '2025-07-31 09:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'patient',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'admin', 'Admin', 'admin@example.com', '2025-07-31 05:19:59', '$2y$12$QPAqlx1VvCQCAUNH/Vs/9un09zWXI.L.zMHawHMfqq1eXrIPQx/nq', 'HPFME3kzOiKDE0WcXEtEzSwrhtvFXkPuFkVXZXTSSobSn5jGQHwdU0YYKcQK', '2025-07-31 05:20:00', '2025-07-31 05:20:00', 'active'),
(2, 'patient', 'patient1', 'patient1@gmail.com', NULL, '$2y$12$TKqYt4CT3H4JTJ.e0AyiU.yvp27Bdf6K6Sr6YEW5QFuNY0g1Gzhk2', NULL, '2025-07-31 05:32:17', '2025-07-31 05:32:17', 'pending'),
(3, 'patient', 'Hamza', 'hamza@gmail.com', NULL, '$2y$12$pjUY696XlrIp6bhQf8RzJ.WRJ7TT7hNzHtkfDzUOUjZDCgg6ZFmsW', NULL, '2025-07-31 08:28:16', '2025-07-31 08:28:16', 'pending'),
(4, 'doctor', 'Shameer', 'doctor@gmail.com', NULL, '$2y$12$ayaQQQDeLeDZ70lyRlKLhOJzQOxbYxToVLU/EYCHpuOIHRSjATO1y', NULL, '2025-07-31 09:16:10', '2025-07-31 09:16:10', 'pending'),
(5, 'doctor', 'Shameena', 'doctor1@gmail.com', NULL, '$2y$12$7j6ff1uKTPaOgP0jm./z5uKYXH/5Agj77WwLZjHqFgojUZSx6cGeq', NULL, '2025-07-31 09:20:18', '2025-08-01 04:36:21', 'approved'),
(6, 'doctor', 'vidhya', 'bashibashima@gmail.com', NULL, '$2y$12$vcred6CChwkDoDUCBsd5Xu8PkJoKvXW.QO1tkSGfkdxPU1RZogXhi', 'zrQcSotANATpBoN6PM17H23zHvRFctW73p10WqA8lffXo2L1tuMqaXQV7Rmu', '2025-07-31 09:22:13', '2025-08-06 05:07:23', 'approved'),
(7, 'patient', 'Rahul', 'bashibashima123@gmail.com', NULL, '$2y$12$s09dHHgBOIRuVaVwD67OjuhBpjcdgtsqL9g54G/MYWSIBHkVm.zPW', NULL, '2025-08-09 00:07:50', '2025-08-09 00:07:50', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `availabilities`
--
ALTER TABLE `availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `availabilities_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`),
  ADD KEY `doctors_specialization_id_foreign` (`specialization_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `global_time_slots`
--
ALTER TABLE `global_time_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `global_time_slots`
--
ALTER TABLE `global_time_slots`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `availabilities`
--
ALTER TABLE `availabilities`
  ADD CONSTRAINT `availabilities_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
