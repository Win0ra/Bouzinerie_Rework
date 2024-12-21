-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 20 déc. 2024 à 21:47
-- Version du serveur : 8.2.0
-- Version de PHP : 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bouzinerie`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Science', 'Questions sur la science, la physique, la biologie et plus', '2024-12-20 19:06:42'),
(2, 'Films', 'Questions sur le cinéma, les acteurs et les films', '2024-12-20 19:06:42'),
(3, 'Jeux', 'Questions sur les jeux vidéo et autres jeux', '2024-12-20 19:06:42'),
(4, 'Culture Générale', 'Questions de culture générale variées', '2024-12-20 19:06:42'),
(5, 'Voyage', 'Questions sur les pays, la géographie et les cultures', '2024-12-20 19:06:42');

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answers` json NOT NULL,
  `correct_answer` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `question`, `answers`, `correct_answer`, `category_id`, `created_at`) VALUES
(1, 'Quelle est la formule chimique de l\'eau?', '[\"H2O\", \"CO2\", \"O2\", \"H2SO4\"]', 0, 1, '2024-12-20 19:06:42'),
(2, 'Quelle planète est surnommée la planète rouge?', '[\"Venus\", \"Mars\", \"Jupiter\", \"Saturne\"]', 1, 1, '2024-12-20 19:06:42'),
(3, 'Qui a réalisé le film \"Titanic\"?', '[\"Steven Spielberg\", \"James Cameron\", \"Christopher Nolan\", \"Martin Scorsese\"]', 1, 2, '2024-12-20 19:06:42'),
(4, 'En quelle année est sorti le premier Star Wars?', '[\"1975\", \"1977\", \"1980\", \"1983\"]', 1, 2, '2024-12-20 19:06:42'),
(5, 'Quel est le personnage principal de Mario Bros?', '[\"Luigi\", \"Mario\", \"Bowser\", \"Yoshi\"]', 1, 3, '2024-12-20 19:06:42'),
(6, 'Quelle entreprise a créé la PlayStation?', '[\"Microsoft\", \"Nintendo\", \"Sony\", \"Sega\"]', 2, 3, '2024-12-20 19:06:42'),
(7, 'Quelle est la plus grande ville d\'Australie?', '[\"Melbourne\", \"Sydney\", \"Brisbane\", \"Perth\"]', 1, 5, '2024-12-20 19:06:42'),
(8, 'Dans quel pays se trouve la Tour de Pise?', '[\"France\", \"Espagne\", \"Italie\", \"Grèce\"]', 2, 5, '2024-12-20 19:06:42'),
(9, 'Quel est le symbole chimique de l\'or?', '[\"Ag\", \"Fe\", \"Au\", \"Cu\"]', 2, 4, '2024-12-20 19:06:42'),
(10, 'Qui a écrit \"Les Misérables\"?', '[\"Émile Zola\", \"Victor Hugo\", \"Gustave Flaubert\", \"Alexandre Dumas\"]', 1, 4, '2024-12-20 19:06:42');

-- --------------------------------------------------------

--
-- Structure de la table `scores`
--

DROP TABLE IF EXISTS `scores`;
CREATE TABLE IF NOT EXISTS `scores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `score` int NOT NULL,
  `total_questions` int NOT NULL,
  `played_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
