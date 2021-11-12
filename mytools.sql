-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 12 nov. 2021 à 13:44
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mytools`
--

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `taskName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taskCategory` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`taskName`),
  KEY `cateogryId` (`taskCategory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`taskName`, `taskCategory`, `creationDate`) VALUES
('Formation', 3, '2021-11-12 09:08:30'),
('Ménage', 2, '2021-11-12 09:09:25');

-- --------------------------------------------------------

--
-- Structure de la table `taskcategories`
--

DROP TABLE IF EXISTS `taskcategories`;
CREATE TABLE IF NOT EXISTS `taskcategories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `taskcategories`
--

INSERT INTO `taskcategories` (`categoryId`, `categoryName`) VALUES
(1, 'Autres'),
(2, 'Appartement'),
(3, 'Boulot'),
(4, 'Formation');

-- --------------------------------------------------------

--
-- Structure de la table `taskelements`
--

DROP TABLE IF EXISTS `taskelements`;
CREATE TABLE IF NOT EXISTS `taskelements` (
  `elementId` int(11) NOT NULL AUTO_INCREMENT,
  `elementName` varchar(535) COLLATE utf8mb4_unicode_ci NOT NULL,
  `elementTask` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`elementId`),
  KEY `elementTask` (`elementTask`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`taskCategory`) REFERENCES `taskcategories` (`categoryId`);

--
-- Contraintes pour la table `taskelements`
--
ALTER TABLE `taskelements`
  ADD CONSTRAINT `taskelements_ibfk_1` FOREIGN KEY (`elementTask`) REFERENCES `task` (`taskName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
