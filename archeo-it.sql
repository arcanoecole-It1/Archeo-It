-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : dim. 15 juin 2025 à 09:22
-- Version du serveur : 11.5.2-MariaDB
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `archeo-it`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualites`
--

DROP TABLE IF EXISTS `actualites`;
CREATE TABLE IF NOT EXISTS `actualites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_creation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `actualites`
--

INSERT INTO `actualites` (`id`, `titre`, `description`, `image`, `date_creation`) VALUES
(21, 'Découverte d&#039;une villa gallo-romaine en Normandie', 'Des archéologues ont mis au jour les vestiges d\\&#039;une luxueuse villa datant du Ier siècle après J.-C., avec des mosaïques exceptionnelles', 'uploads/actualites/actualite_684e897869388.jpg', 1749977464),
(22, 'Un puits médiéval intact retrouvé à Lyon', 'Lors de travaux dans le Vieux Lyon, un puits datant du XIIIe siècle a été retrouvé avec son mécanisme en bois préservé', 'uploads/actualites/actualite_684e89addae20.jpeg', 1749977517),
(23, 'Une sépulture gauloise découverte près de Toulouse', 'Une tombe exceptionnelle contenant armes, bijoux et poteries a été fouillée à proximité de Toulouse', 'uploads/actualites/actualite_684e89e0e879b.jpeg', 1749977568),
(24, 'Les alignements de Carnac révélés par Lidar', 'Une analyse par drone Lidar a permis d\\&#039;identifier de nouveaux alignements mégalithiques dans la région de Carnac', 'uploads/actualites/actualite_684e8a18ed571.jpeg', 1749977624),
(25, 'Reconstitution numérique du forum antique de Nîmes', 'Des chercheurs ont réalisé une reconstitution 3D du forum romain de Nîmes, visible en réalité virtuelle', 'uploads/actualites/actualite_684e8a459f51d.jpeg', 1749977669),
(26, 'Nouvelle campagne de fouilles au Mont Beuvray', 'Des fouilles reprennent à Bibracte sur le Mont Beuvray avec des étudiants en archéologie de toute l’Europe', 'uploads/actualites/actualite_684e8a6c215a5.jpeg', 1749977708),
(27, 'Traces d’un sanctuaire celtique en Alsace', 'Un site cultuel celtique avec autels et dépôts votifs a été identifié près de Sélestat', 'uploads/actualites/actualite_684e8aa7bd28a.jpeg', 1749977767),
(28, 'Découverte d’une mosaïque romaine à Narbonne', 'Une mosaïque polychrome représentant des scènes de chasse a été retrouvée intacte sur un chantier préventif', 'uploads/actualites/actualite_684e8af617bd9.jpeg', 1749977846),
(29, 'Exposition « Trésors d’Archéologie » à Lille', 'Une exposition temporaire au Palais des Beaux-Arts présente des objets archéologiques rares provenant de fouilles en région Hauts-de-France', 'uploads/actualites/actualite_684e8b592f0b1.jpeg', 1749977945);

-- --------------------------------------------------------

--
-- Structure de la table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
CREATE TABLE IF NOT EXISTS `agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_evenement` date NOT NULL,
  `heure_evenement` time DEFAULT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `agenda`
--

INSERT INTO `agenda` (`id`, `titre`, `description`, `date_evenement`, `heure_evenement`, `lieu`, `created_by`, `created_at`) VALUES
(2, 'Visite guidée de notre chantier de fouille à Orléans ', 'Venez découvrir  le quotidien des archéologues et les vestiges gallo-romains mis à jour cette année', '2025-07-10', '14:00:00', 'Chantier archéologique de la rue Royale , Orléans', 4, '2025-06-15 09:12:11');

-- --------------------------------------------------------

--
-- Structure de la table `chantiers`
--

DROP TABLE IF EXISTS `chantiers`;
CREATE TABLE IF NOT EXISTS `chantiers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `localisation` varchar(255) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` enum('planifie','actif','termine') DEFAULT 'actif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `chantiers`
--

INSERT INTO `chantiers` (`id`, `nom`, `description`, `image`, `localisation`, `date_debut`, `date_fin`, `statut`, `created_at`) VALUES
(19, 'Fouilles Gallo-Romaines à Arles', 'Exploration d’un ancien théâtre gallo-romain', 'uploads/chantiers/chantier_684e8291ac1a9.jpeg', 'Arles', '2025-06-15', '2025-08-01', 'actif', '2025-06-15 08:21:37'),
(18, 'Fortifications Vauban', 'Fouilles autour des fortifications de Vauban à Besançon', 'uploads/chantiers/chantier_684e80f07df0f.jpeg', 'Besançon', '2025-01-20', '2025-02-20', 'termine', '2025-06-15 08:14:40'),
(20, 'Site Néolithique de Carnac', 'Étude des célèbres alignements de menhir', 'uploads/chantiers/chantier_684e831763ee2.jpeg', 'Carnac', '2025-07-01', '2025-07-31', 'termine', '2025-06-15 08:23:51'),
(21, 'Château Médiéval de Carcassonne', 'Fouilles pour restaurer les fondations du château', 'uploads/chantiers/chantier_684e8538ef7ae.jpeg', 'Occitanie', '2025-05-05', '2025-05-25', 'termine', '2025-06-15 08:32:56'),
(22, 'Site Médiéval de Rouen', 'Étude d’une ancienne cité médiévale dans le centre de Rouen', 'uploads/chantiers/chantier_684e85cf09372.jpeg', 'Rouen', '2025-09-05', '2025-10-02', 'planifie', '2025-06-15 08:35:27'),
(23, 'Oppidum d’Entremont', 'Exploration d’un oppidum celte dans les Alpes-de-Haute-Provence', 'uploads/chantiers/chantier_684e86cf89777.jpeg', 'Alpes-de-Haute-Provence', '2025-06-10', '2025-07-05', 'actif', '2025-06-15 08:39:43'),
(24, 'Abbaye de Cluny', 'Fouilles autour de l’abbaye bénédictine célèbre en Bourgogne', 'uploads/chantiers/chantier_684e8735e3821.jpeg', 'Bourgogne', '2025-04-15', '2025-06-05', 'termine', '2025-06-15 08:41:25'),
(25, 'Grotte de Lascaux', 'Étude complémentaire des peintures rupestres dans la Dordogne', 'uploads/chantiers/chantier_684e87ab31704.jpeg', 'Dordogne', '2025-06-01', '2025-07-01', 'actif', '2025-06-15 08:43:23'),
(26, 'Site Néolithique d’Alsace', 'Exploration d’un village néolithique dans le Bas-Rhin', 'uploads/chantiers/chantier_684e887ca8e29.jpeg', 'Alsace', '2025-10-03', '2025-11-07', 'planifie', '2025-06-15 08:46:52'),
(27, 'Théâtre Antique de Lyon', 'Fouilles autour du théâtre antique de Fourvière à Lyon', 'uploads/chantiers/chantier_684e88c683dc7.jpeg', 'Lyon', '2025-10-04', '2025-10-30', 'planifie', '2025-06-15 08:48:06');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `commentaire` text NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `nom`, `email`, `commentaire`, `date_creation`) VALUES
(1, 'Richard', 'test@gmail.com', 'bçpfp_', '2025-06-13 18:43:08');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `last_name`, `first_name`, `email`, `subject`, `comment`) VALUES
(2, 'Bintcha', 'Cedric', 'test@gmail.com', 'Demande de Rendez-vous', 'wze(tyil');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `is_admin`) VALUES
(3, 'Kadi', 'testings@test.fr', '$2y$10$OJMPxhc2OyMHxDielwvcGOXepbCkPRbYfrUiwdKz0VnkN/3/ohlwe', 'Grace', 'Kadidia', 1),
(2, 'Richard', 'useless@email.com', '$2y$10$GKb2s9uZAi.yRiIoyWZ1Be1.WrKreTd2P2UjNAQBipP.XO3UISBui', 'test', 'test', 1),
(4, 'Grace', 'tchibindagrace5@gmail.com', '$2y$10$uYLxsKIsuq0BmrEsvzmhougTYjai69GtZTBAuU7qimYQlygUtZWV.', 'Kadidia grace', 'TCHIBINDA DIAW', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
