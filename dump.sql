-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2025 at 12:14 PM
-- Server version: 8.0.40-0ubuntu0.24.04.1
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_rework`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `created_at`) VALUES
(1, 'League of Legends', 'Questions sur l\'univers de LoL', NULL, '2024-12-20 19:06:42'),
(2, 'World of Warcraft', 'Questions sur l\'univers de WoW', NULL, '2024-12-20 19:06:42'),
(3, 'Dofus', 'Questions sur l\'univers de Dofus', NULL, '2024-12-20 19:06:42'),
(4, 'Histoire', 'Questions sur l\'Histoire', NULL, '2024-12-20 19:06:42'),
(5, 'Géographie', 'Questions sur les pays, la géographie et les cultures', NULL, '2024-12-20 19:06:42'),
(6, 'Films', 'Questions sur l\'univers du cinéma', NULL, '2025-01-02 14:51:40'),
(7, 'Sciences', 'Questions sur la science, la physique, la biologie et plus', NULL, '2025-01-02 14:52:21'),
(8, 'Littérature', 'Questions diverses sur la littérature', NULL, '2025-01-02 14:55:09'),
(9, 'Cuisine', 'Questions diverses sur la cuisine mondiale', NULL, '2025-01-02 14:55:28'),
(40, 'abdellah', 'eeeeeee', '', '2025-01-03 18:51:17'),
(44, 'padu', 'de', '', '2025-01-03 18:58:57'),
(45, 'padu', 'de', 'Screenshot from 2024-12-06 12-34-20.png', '2025-01-03 19:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `question` text NOT NULL,
  `answers` json NOT NULL,
  `correct_answer` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `answers`, `correct_answer`, `category_id`, `created_at`) VALUES
(1, 'Quelle est la formule chimique de l\'eau?', '[\"H2O\", \"CO²\", \"H2+\", \"HTML\"]', 0, 7, '2024-12-20 19:06:42'),
(2, 'Quelle planète est surnommée la planète rouge?', '[\"Venus\", \"Mars\", \"Jupiter\", \"Saturne\"]', 1, 1, '2024-12-20 19:06:42'),
(3, 'Qui a réalisé le film \"Titanic\"?', '[\"Steven Spielberg\", \"James Cameron\", \"Christopher Nolan\", \"Martin Scorsese\"]', 1, 2, '2024-12-20 19:06:42'),
(4, 'En quelle année est sorti le premier Star Wars?', '[\"1975\", \"1977\", \"1980\", \"1983\"]', 1, 2, '2024-12-20 19:06:42'),
(5, 'Quel est le personnage principal de Mario Bros?', '[\"Luigi\", \"Mario\", \"Bowser\", \"Yoshi\"]', 1, 3, '2024-12-20 19:06:42'),
(6, 'Quelle entreprise a créé la PlayStation?', '[\"Microsoft\", \"Nintendo\", \"Sony\", \"Sega\"]', 2, 3, '2024-12-20 19:06:42'),
(7, 'Quelle est la plus grande ville d\'Australie?', '[\"Melbourne\", \"Sydney\", \"Brisbane\", \"Perth\"]', 1, 5, '2024-12-20 19:06:42'),
(8, 'Dans quel pays se trouve la Tour de Pise?', '[\"France\", \"Espagne\", \"Italie\", \"Grèce\"]', 2, 5, '2024-12-20 19:06:42'),
(9, 'Quel est le symbole chimique de l\'or?', '[\"Ag\", \"Fe\", \"Au\", \"Cu\"]', 2, 4, '2024-12-20 19:06:42'),
(10, 'Qui a écrit \"Les Misérables\"?', '[\"Émile Zola\", \"Victor Hugo\", \"Gustave Flaubert\", \"Alexandre Dumas\"]', 1, 4, '2024-12-20 19:06:42'),
(11, 'testing question', '[\"test 1\", \"test 1\", \"AAAAA\", \"AAAAA\"]', 0, 7, '2025-01-03 15:46:47'),
(12, 'testing questionAAAAA', '[\"aaaa\", \"aasas\", \"sasa\", \"sasa\"]', 0, 7, '2025-01-03 15:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `score` int NOT NULL,
  `quiz_id` int DEFAULT NULL,
  `total_correct_questions` int NOT NULL,
  `played_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `user_id`, `score`, `quiz_id`, `total_correct_questions`, `played_at`) VALUES
(14, 11, 26, 7, 1, '2025-01-07 01:29:49'),
(13, 11, 90, 9, 3, '2025-01-03 20:27:48'),
(9, 5, 77, 7, 3, '2025-01-03 20:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `pseudo` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `is_admin`, `pseudo`) VALUES
(1, 'anne@test.com', 'hashed_password', '2024-12-30 19:28:51', 0, 'Anne-Boolé'),
(2, 'bouzin69@test.com', 'hashed_password', '2024-12-30 19:28:51', 0, 'Bouzin69'),
(3, 'raoul@test.com', 'hashed_password', '2024-12-30 19:28:51', 0, 'Raoul'),
(4, 'charlotte@test.com', 'hashed_password', '2024-12-30 19:28:51', 0, 'Charlotte'),
(5, 'marc@test.com', 'hashed_password', '2024-12-30 19:28:51', 0, 'Marc'),
(6, 'maevabouvard@gmail.com', '$2y$10$.UWzzY0CQc4R9meVA7n.We0s1h6bfNwUnr8XevqQegPtqdif/Qr.a', '2024-12-31 13:42:47', 1, 'Winora'),
(11, 'saaidi.best1@gmail.com', '$2y$10$wo/2rWUyYnxu52O29SQJRuT4IAax7/VhNlOkzl0BFgUjTrIToAMW2', '2025-01-03 15:33:11', 1, 'metallicos');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_score` (`score`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;