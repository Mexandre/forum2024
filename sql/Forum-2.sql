-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 29 fév. 2024 à 13:38
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `bloquage_echange`
--

CREATE TABLE `bloquage_echange` (
  `id` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `id_demandeur` int(11) NOT NULL,
  `id_bloque` int(11) NOT NULL,
  `date_creat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_post`
--

CREATE TABLE `forum_post` (
  `id` int(11) NOT NULL,
  `id_sujet` int(11) NOT NULL,
  `msg` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `date_creat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_maj` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `note` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_sujet`
--

CREATE TABLE `forum_sujet` (
  `id` int(11) NOT NULL,
  `titre` varchar(180) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_theme` int(11) NOT NULL,
  `date_creat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_maj` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_theme`
--

CREATE TABLE `forum_theme` (
  `id` int(11) NOT NULL,
  `nom` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `forum_theme`
--

INSERT INTO `forum_theme` (`id`, `nom`) VALUES
(2, 'Figurine'),
(1, 'Foot'),
(3, 'Vehicule');

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `nom`) VALUES
(3, 'Autre'),
(5, 'Chevre'),
(2, 'Femme'),
(1, 'Homme'),
(4, 'NB');

-- --------------------------------------------------------

--
-- Structure de la table `mp_echange`
--

CREATE TABLE `mp_echange` (
  `id` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `msg` text NOT NULL,
  `id_expediteur` int(11) NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_maj` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mp_participant`
--

CREATE TABLE `mp_participant` (
  `id` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mp_participant`
--

INSERT INTO `mp_participant` (`id`, `id_salon`, `id_utilisateur`) VALUES
(1, 1, 1),
(3, 1, 2),
(2, 2, 3),
(4, 2, 7);

-- --------------------------------------------------------

--
-- Structure de la table `mp_salon`
--

CREATE TABLE `mp_salon` (
  `id` int(11) NOT NULL,
  `nom` varchar(80) NOT NULL,
  `id_createur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mp_salon`
--

INSERT INTO `mp_salon` (`id`, `nom`, `id_createur`) VALUES
(1, 'x', 1),
(2, 'z', 3);

--
-- Déclencheurs `mp_salon`
--
DELIMITER $$
CREATE TRIGGER `T_Salon_Ins` AFTER INSERT ON `mp_salon` FOR EACH ROW INSERT INTO participant(id_salon,id_utilisateur)
SELECT
	id,
    id_createur
FROM salon
ORDER BY id DESC
LIMIT 1
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id_utilisateur` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `adresse` varchar(180) DEFAULT NULL,
  `pays` varchar(80) DEFAULT NULL,
  `ville` varchar(80) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `date_creat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_maj` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id_utilisateur`, `id_genre`, `nom`, `prenom`, `adresse`, `pays`, `ville`, `cp`, `date_creat`, `date_maj`) VALUES
(1, 3, 'Berre', 'Cunégonde', 'Apt 1803', 'France', NULL, '54154', '2024-02-20 16:03:59', NULL),
(2, 1, 'Triebner', 'Sòng', 'PO Box 13615', 'France', 'Saint-Quentin-en-Yvelines', '78925', '2024-02-20 16:03:59', NULL),
(3, 1, 'Lovejoy', 'Esbjörn', NULL, 'France', 'Oyonnax', '01117', '2024-02-20 16:03:59', NULL),
(4, 1, 'Felce', 'Mén', 'Suite 97', 'France', 'Nantes', '44094', '2024-02-20 16:03:59', NULL),
(5, 2, NULL, 'Måns', 'Apt 1074', 'France', NULL, '13298', '2024-02-20 16:03:59', NULL),
(6, 3, 'Antrag', 'Amélie', '9th Floor', 'France', 'Le Puy-en-Velay', '43010', '2024-02-20 16:03:59', NULL),
(7, 3, NULL, 'Pénélope', 'Apt 782', 'France', 'Savigny-le-Temple', NULL, '2024-02-20 16:03:59', NULL),
(8, 5, 'Petters', 'Aí', 'PO Box 10531', 'France', 'Strasbourg', '67013', '2024-02-20 16:03:59', NULL),
(9, 5, NULL, 'Magdalène', NULL, 'France', 'Pamiers', '09104', '2024-02-20 16:03:59', NULL),
(10, 2, 'Bruckmann', 'Desirée', 'Apt 1307', 'France', NULL, '33515', '2024-02-20 16:03:59', NULL),
(11, 2, 'Demoge', 'Judicaël', 'Suite 51', NULL, 'Puget-sur-Argens', '83484', '2024-02-20 16:03:59', NULL),
(12, 5, 'Mariault', 'Géraldine', '13th Floor', NULL, NULL, '92509', '2024-02-20 16:03:59', NULL),
(13, 1, 'Pee', 'Célestine', 'Room 1018', 'France', 'Saint-Jean-de-Luz', NULL, '2024-02-20 16:03:59', NULL),
(14, 5, NULL, 'Hélèna', 'PO Box 10880', NULL, 'Saint-Marcellin', '38164', '2024-02-20 16:03:59', NULL),
(15, 4, 'Schwant', 'Gaïa', '10th Floor', NULL, 'Bourg-en-Bresse', NULL, '2024-02-20 16:03:59', NULL),
(16, 2, 'Boulsher', 'Célestine', 'PO Box 43997', 'France', 'Clichy', '92613', '2024-02-20 16:03:59', NULL),
(17, 5, 'Cadney', NULL, 'Room 554', 'France', 'Cergy-Pontoise', '95061', '2024-02-20 16:03:59', NULL),
(18, 1, 'Ffrench', 'Intéressant', 'PO Box 73974', 'France', NULL, NULL, '2024-02-20 16:03:59', NULL),
(19, 5, 'Masurel', 'Kuí', '6th Floor', 'France', 'Paris 01', '75100', '2024-02-20 16:03:59', NULL),
(20, 2, 'Easter', 'Nélie', 'Room 127', 'France', 'Saint-Dié-des-Vosges', '88109', '2024-02-20 16:03:59', NULL),
(21, 3, 'Akess', 'Kù', 'Room 1926', 'France', 'Bordeaux', '33911', '2024-02-20 16:03:59', NULL),
(22, 3, 'Grinston', 'Solène', '19th Floor', 'France', 'Laval', NULL, '2024-02-20 16:03:59', NULL),
(23, 2, 'Livoir', 'Ruò', 'PO Box 22163', 'France', 'Meylan', '38244', '2024-02-20 16:03:59', NULL),
(24, 2, 'Chatterton', 'Aimée', 'PO Box 36255', 'France', NULL, '49066', '2024-02-20 16:03:59', NULL),
(25, 5, 'Piens', 'Geneviève', '6th Floor', 'France', 'Roissy Charles-de-Gaulle', NULL, '2024-02-20 16:03:59', NULL),
(26, 2, 'Scothron', 'Mårten', '18th Floor', NULL, NULL, '93737', '2024-02-20 16:03:59', NULL),
(27, 4, 'Checci', 'Maïté', '16th Floor', 'France', 'Pau', NULL, '2024-02-20 16:03:59', NULL),
(28, 3, 'Aukland', 'Yáo', '12th Floor', 'France', 'Avignon', '84092', '2024-02-20 16:03:59', NULL),
(29, 1, 'Anderl', 'Dà', 'Room 204', 'France', NULL, NULL, '2024-02-20 16:03:59', NULL),
(30, 1, 'de Courcy', 'Vénus', 'Room 1579', 'France', 'Saintes', '17104', '2024-02-20 16:03:59', NULL),
(31, 4, 'Bulluck', 'Gaëlle', NULL, 'France', NULL, '77224', '2024-02-20 16:03:59', NULL),
(32, 4, 'Baldacchi', 'Béatrice', 'PO Box 18686', 'France', 'Castres', NULL, '2024-02-20 16:03:59', NULL),
(33, 2, 'Purveys', 'Anaël', 'Apt 1854', 'France', 'La Rochelle', NULL, '2024-02-20 16:03:59', NULL),
(34, 5, NULL, 'Fèi', '15th Floor', NULL, NULL, '64029', '2024-02-20 16:03:59', NULL),
(35, 1, 'Cumesky', 'Cléa', 'Apt 1935', 'France', 'Nancy', '54009', '2024-02-20 16:03:59', NULL),
(36, 1, NULL, 'Gisèle', 'Suite 91', 'France', 'Bry-sur-Marne', '94364', '2024-02-20 16:03:59', NULL),
(37, 1, 'Gilbart', 'Frédérique', '15th Floor', 'France', NULL, '79083', '2024-02-20 16:03:59', NULL),
(38, 3, NULL, 'Gaïa', 'Room 666', 'France', NULL, '60477', '2024-02-20 16:03:59', NULL),
(39, 1, 'Wybrew', 'Örjan', 'PO Box 10547', 'France', NULL, '11104', '2024-02-20 16:03:59', NULL),
(40, 5, 'Servant', 'Vénus', 'Room 1525', NULL, NULL, NULL, '2024-02-20 16:03:59', NULL),
(41, 5, 'Stockney', 'Eléonore', 'PO Box 22111', 'France', 'Wasquehal', '59444', '2024-02-20 16:03:59', NULL),
(42, 5, 'Antoszewski', 'Cinéma', NULL, 'France', NULL, '33911', '2024-02-20 16:03:59', NULL),
(43, 4, 'Eilhertsen', 'Agnès', 'PO Box 88256', 'France', 'Futuroscope', '86964', '2024-02-20 16:03:59', NULL),
(44, 4, NULL, 'Almérinda', '7th Floor', 'France', 'Vierzon', '18104', '2024-02-20 16:03:59', NULL),
(45, 5, 'Baytrop', 'Lèi', 'Suite 98', 'France', 'Agen', NULL, '2024-02-20 16:03:59', NULL),
(46, 5, 'Sabben', 'Geneviève', 'Apt 1714', 'France', 'Lyon', '69939', '2024-02-20 16:03:59', NULL),
(47, 3, 'Barltrop', 'Léane', 'Suite 36', 'France', 'La Plaine-Saint-Denis', '93571', '2024-02-20 16:03:59', NULL),
(48, 1, 'Jacquemard', 'Gösta', '10th Floor', 'France', 'Bobigny', NULL, '2024-02-20 16:03:59', NULL),
(49, 3, 'Kyrkeman', 'Maéna', 'Suite 5', 'France', NULL, '75582', '2024-02-20 16:03:59', NULL),
(50, 5, 'Hrachovec', 'Noémie', 'Suite 59', 'France', 'Mont-de-Marsan', '40025', '2024-02-20 16:03:59', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `niveau_id` tinyint(4) NOT NULL DEFAULT '0',
  `pseudo` varchar(70) NOT NULL,
  `mail` varchar(120) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `date_naiss` date NOT NULL,
  `date_ins` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_maj` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `date_expiration_ban` datetime DEFAULT NULL,
  `avertissement` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `actif` tinyint(1) NOT NULL DEFAULT '0',
  `jeton` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `niveau_id`, `pseudo`, `mail`, `pass`, `date_naiss`, `date_ins`, `date_maj`, `date_expiration_ban`, `avertissement`, `actif`, `jeton`) VALUES
(1, 0, 'jofdrd03', 'kcornell0@shareasale.com', '$2a$04$sPa1Q/N4Va9cDbJ2MknN0.KMNrmhZvBJqL66tDvWpQMc8YDmV8WR6', '1978-01-18', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(2, 0, 'qnlbwu84', 'smcgow1@i2i.jp', '$2a$04$BZUlFaAsI9.bLHivVnKVCONL83X906C5uEcmHzN8BbDtN/gRSu9aq', '1974-09-09', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(3, 0, 'iwsiva88', 'mlebreton2@harvard.edu', '$2a$04$LAYTpWRuPgOsp4.oJ2v7HOBUHW5trfva9afFEH4s9j4Z7PGEhMAP.', '1974-03-15', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(4, 0, 'txjkgx98', 'pkeirle3@slashdot.org', '$2a$04$JNqUdhqzPd6T0QVAYCxu6.3CBkBYnirZUNztoCYjvB6EPPx6XLuBq', '1971-01-25', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(5, 0, 'rrwnct96', 'cnolli4@dagondesign.com', '$2a$04$xF8.NbCkfnXOl179naaGCueOopFSrxo9eYkCw2Io6BJuG5OSU4zbO', '1986-01-07', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(6, 0, 'xnmava54', 'jmorit5@multiply.com', '$2a$04$rMT8rdhNyNiKmhFvQ9cpk.N8ubiNAhauxu3KQcv6Iv.t5AWOMFolC', '1972-07-05', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(7, 0, 'wovodb64', 'adresser6@google.pl', '$2a$04$5jt.ZW8BNHULUL5PUb4fJ.c/TviRM.9fYJox3rHVLuYDqYzLeD8ia', '1982-11-25', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(8, 0, 'smhert54', 'zcockerell7@quantcast.com', '$2a$04$2rMVYUZDUz0Q74LVlifaTu1tqm2C7FyFUzL5bnUN600GoagMPFLkG', '1988-04-23', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(9, 0, 'lhkilv59', 'teddowes8@about.com', '$2a$04$3HJWImygLN7JhJYREVXyIeEcwqWX7GBhL1.dQJxbNLlxPC3Q5OAkS', '1983-01-16', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(10, 0, 'ycuyth30', 'bdown9@surveymonkey.com', '$2a$04$0At0PF7kKwMFqYejZwigbOX1BeJgjdDm4VvxNjq7M9Y/rwBOcuCHO', '1977-05-27', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(11, 0, 'zsggki23', 'cthunnercliffea@sakura.ne.jp', '$2a$04$0H/HGeNtTWw.eBWS7ck.seEnVEZdDaP0Ly9LR7RZiv1fdEZsEZ8ju', '1973-02-24', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(12, 0, 'acfpkb53', 'cmatasovb@howstuffworks.com', '$2a$04$NaffXQOwBS6wUAOIoc5m2.3jTQyRK.didZL8gJK8H6a.33ad/JoPG', '1973-07-10', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(13, 0, 'ivwsqt59', 'koxnamc@nba.com', '$2a$04$GPgqjas2jXLkvleTG4H4De4QwHPPumVPVWTZXKnqsJLS53DBrYKry', '1973-08-25', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(14, 0, 'iqvcfo76', 'jsewardsd@lycos.com', '$2a$04$npoFeELr7e19R4E9nx1aFuBkbDwrlZC2StfpTnlfc2ayS2/iyH.qG', '1987-06-03', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(15, 0, 'qkbbhy71', 'jgothupe@photobucket.com', '$2a$04$Edkcxr.XwQPU9B1Qr.vbVOFSWI5gShj9pCp6TvQntq8dYmjDz4Xle', '1971-12-04', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(16, 0, 'grqwel41', 'theintzschf@tinyurl.com', '$2a$04$z8GolnB2M/KjpF.8soz/0OWCfGSw78NqVZDZwhOl.DIl8.kjJyda6', '1989-04-29', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(17, 0, 'ryfwjg46', 'oraubheimg@smh.com.au', '$2a$04$EEfu3YykLA7GA7uopGcWiuS.S0hRz6xZayQJzyh9dkMdLkkqW0ieq', '1970-11-14', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(18, 0, 'fdfgtz41', 'bkibbleh@google.ru', '$2a$04$JIx4i53Ufn4ciZUANRxfceFS7kHbKj9D2G/GKtigMAHnSCttfl7DW', '1978-04-14', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(19, 0, 'bosayk34', 'dzanettoi@wikipedia.org', '$2a$04$6M8nRW33AwZRo1yIFKr9LuID8Cth.I/hgpoUCdofQkTKvwAa9ZK9m', '1989-05-04', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(20, 0, 'wfodhg66', 'crosbottomj@census.gov', '$2a$04$0cGOZvWzg.gXz9qWpeukuuF3.YZ2mKGCH7MYgW5Sus0t1Jwpor10G', '1988-05-11', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(21, 0, 'wbmbay76', 'bgiovanittik@mozilla.com', '$2a$04$8qRXnAhCfsWVsrrmkn6BJ.OPNIVSu7KQOuqLPzQYjTPP0WcutYsJW', '1981-06-24', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(22, 0, 'gchyjo09', 'yromerol@soundcloud.com', '$2a$04$RGjRQzV4a9/ZtHwzG6QgHubTQmFKVWbhDzB66Bem0qQtpY4DJHIRq', '1981-04-25', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(23, 0, 'jwuwkp38', 'aleaburnm@psu.edu', '$2a$04$kqrlOVwVW2NcSiQ4p9y4yu8xRFjbf6okrpBx2EI7ABFwhf6Vdq/eK', '1986-09-09', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(24, 0, 'fkpkaa68', 'eodorann@purevolume.com', '$2a$04$QTZioKZi4/34raV5b0dn/.iCpTnT1FgaaTwN5RAVfg6NM4rrwLm3e', '1989-10-29', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(25, 0, 'ppnhpw18', 'wpetrashovo@pbs.org', '$2a$04$8pgWhkkBRgd5ylq7old7BePFj.u2aZp5S49pE0wggn8V4cAjJZSX.', '1985-10-24', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(26, 0, 'ranrcf17', 'gbatmanp@va.gov', '$2a$04$7zVMa0GnHg3EXsghyikQE.GFF.i/.xxYi.Eij4ZPDfrxVVfvfCF/.', '1983-08-21', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(27, 0, 'ybjoxs81', 'gguilleq@nhs.uk', '$2a$04$8jU1JT8Xd89gyN/r.p6zDe/mnWRFdKWR18bC47kDYkUB1V12Vy5CC', '1971-02-08', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(28, 0, 'cpctyi00', 'jbalshawr@fotki.com', '$2a$04$qcji..JWAc5P2nxxztlHKO/A9tLUuA0EDcahEYSugJemGYYl4Q07S', '1973-11-19', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(29, 0, 'uieplw59', 'sgresties@last.fm', '$2a$04$BxrDTwDloIYplNxCBAff5.T4C6babKo7y1Z3S.60P99P4atrNeo0G', '1976-08-10', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(30, 0, 'pxrnor92', 'wborthet@shutterfly.com', '$2a$04$hjC27HT8FPXO8/TG4jhzyOl9eZJgcBzlmwxR.NYH996E6TuJSFVsS', '1981-02-10', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(31, 0, 'fmtkum38', 'lheadanu@sakura.ne.jp', '$2a$04$GJA./b5xMfEW90Fag4wNBuXfVhEWIjj9iQecgi6GgOKPYSCyd/1ja', '1977-11-16', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(32, 0, 'bkbrdk49', 'bgeeritsv@rambler.ru', '$2a$04$6SEBpjMFoIY15TdW14UHP.881Q0DZw1UB7ZF/qvuhAYXuBB3.YAkG', '1985-12-13', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(33, 0, 'sfidxj34', 'ndeshonw@chicagotribune.com', '$2a$04$K2QUDe1O0yGKogAc1II5h.f/qj1jDQw57j1fvenYXriHo5r6VAZua', '1986-02-23', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(34, 0, 'oykfwu33', 'cskylettx@yandex.ru', '$2a$04$N1CoYDeUimZklI9cRF5DV.S/mGybiYk0EZfIhFFKUwenXVZUtXhTG', '1971-05-26', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(35, 0, 'akrjxr85', 'hparsonsy@google.com.br', '$2a$04$sbkCrIEx6SdLbYBp./fce.9k/brdGMBoF.QgzQk.5laSB9QFMjYbe', '1983-12-31', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(36, 0, 'vrmlly70', 'nbeedomz@hp.com', '$2a$04$lKomJsaa6wYRk/kKq6Ak5OeTJetQfLAfxvhC3MTL4S9GliNwES0cW', '1977-05-24', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(37, 0, 'bxcpwi00', 'lpakenham10@cyberchimps.com', '$2a$04$S9W13HNDQVV0wegLMTr1Uup54ZTgJXwUiF3IZbGDHQ5SAML4rgamq', '1987-03-27', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(38, 0, 'usuxou02', 'cmaccawley11@redcross.org', '$2a$04$amMjqyszr459D6QoWccQwuS7v/vTgreQifcyKkdZuD6YylaP..Jm.', '1988-04-29', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(39, 0, 'krmmko61', 'atosney12@spotify.com', '$2a$04$zRmuD6ZYHTxvRc61n8gpqu2lfAbTZbXq3UMHN3ZSY2ApwMiuOcVj.', '1984-10-12', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(40, 0, 'wtfisp50', 'sbamford13@bbc.co.uk', '$2a$04$Z5g4q5iBf9t6b8N/Bj/z5..t7nphYySTpqCOkP6M/700vRzPmCKve', '1984-08-24', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(41, 0, 'niocqo68', 'fdotterill14@reverbnation.com', '$2a$04$b1jl.EkcxGAYbQgv04LJluE6CiCGTzdg00R4PnY27YLPeBzo26pXe', '1974-03-11', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(42, 0, 'qkmbqf23', 'sfridaye15@hp.com', '$2a$04$aYhrtyKuEydgbwlF35QB1ORXgJbicRs4xt5BZO8iQcK2UjTm0YmHC', '1982-06-28', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(43, 0, 'lpvwag24', 'pbaudry16@arstechnica.com', '$2a$04$Tw3KjHDNkwdubIY41YWileu8YDNFqwZC5plR00M3r/OmRHkKN2j.m', '1978-03-20', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(44, 0, 'osjlzi82', 'chawthorne17@china.com.cn', '$2a$04$5/o1LWZIw.ZEtVQbq/m/teim9j.g8XLSgqQ20kIn597vlvN9jAe.K', '1971-12-15', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(45, 0, 'oaqxsj09', 'kpaur18@booking.com', '$2a$04$tSazxovRw/hcZz724eQxQ.XmvmsqxZiVaxdta/675jcVWx1iyEini', '1977-01-11', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(46, 0, 'lwvseb36', 'gcollocott19@foxnews.com', '$2a$04$fR9/FG9nXJd6/2ij8MZGJONAJ2MbZx4cFichSr8Q8YZ7zIZCogEFi', '1984-06-08', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(47, 0, 'kigxht82', 'cgrisdale1a@histats.com', '$2a$04$DrJCHYyuMdME3GAy7w2lPuRfjaFG80CwbLAEWk1/B3dkkdCsvJJHS', '1978-12-03', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(48, 0, 'ysslvr61', 'slaybourn1b@ning.com', '$2a$04$YolR3o/OfJtTeBP1/J7cbezTqxLM7MKQ3yHraHfkZtGq7kQ2YX.cW', '1970-10-28', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(49, 0, 'xtbqgy98', 'hhertwell1c@walmart.com', '$2a$04$hZFi1dsnViIbhS9eH75K.u0i0H3k6bAAcsIfmPHXI4iR0EN4K5BOK', '1985-03-10', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(50, 0, 'hjwedp47', 'kfishleigh1d@nyu.edu', '$2a$04$pESvLPU12i9p9Bxyog62hO0RS1MccizWQmeP0yg5OnWuDp/dHqMJa', '1970-12-30', '2024-02-20 16:03:59', NULL, NULL, 0, 0, NULL),
(51, 0, 'Samuel60', 'rahamniasamuel@gmail.com', '$2y$10$scd41cbDON9ig8X4nktv5uxEPdm2evjmfLIuQgtzQcb.soXRLo5Yq', '2000-01-01', '2024-02-20 22:14:43', NULL, NULL, 0, 0, NULL),
(52, 0, 'zolive', 'z@z.fr', '$2y$10$Nm/ANU3BDIkgPkEgEf1oBuaf/B6CIp8Z6rh0v2/OzCc2O9rN/NY5G', '1950-01-01', '2024-02-20 22:46:46', NULL, NULL, 0, 0, NULL),
(53, 0, 'coucou', 'dd@dd.dd', '$2y$10$NtGjxqQqK/KDW.rde.PIGuhD4ae5Tb65.ed/RDQYtln9YNlOYsa.6', '2003-02-01', '2024-02-20 23:29:43', NULL, NULL, 0, 0, NULL),
(54, 0, 'Christelle', 'mllecgungui@gmail.com', '$2y$10$HgBuy2/0KGmRQH.07g0Tpuz86OsViE6N9Xm9QcFvQyHGZVT9XdyV6', '2024-02-22', '2024-02-22 10:05:40', NULL, NULL, 0, 0, NULL),
(55, 0, 'ddddd', 'ddddddd@azerty.fr', '$2y$10$wnpd8uld/gjHp2c7bnUFCeSj/o7k5TvumpfPpbrjfWywPKO8VX1nG', '1289-09-09', '2024-02-27 10:08:40', NULL, NULL, 0, 0, NULL),
(56, 0, 'amar', 'amar@amar.amar', '$2y$10$C/O9TQqQTBlLfJFDkaTvseAn3bt9jj8mt.N.mXSgpiJF6dub7izl.', '1990-02-01', '2024-02-27 10:36:25', NULL, NULL, 0, 0, NULL),
(57, 0, 'de', '', '$2y$10$fDoT3P2zzixoopP12P0NK.qmDJAdmu5xxv9KoJrhIPrI4LUJokE5q', '2000-12-12', '2024-02-27 15:09:31', NULL, NULL, 0, 0, NULL),
(58, 0, 'anthonin', 'anthonin@anthonin.fr', '$2y$10$ECOxVCt.EPKxfcpluRBZoupTnC0mZEmBvUDr6WpDkrG1tB1Xlu2Ce', '2000-12-12', '2024-02-27 15:10:53', NULL, NULL, 0, 0, NULL),
(59, 0, 'qsdf', 'qsdf@qsdf.fr', '$2y$10$TlSedQMVWYGQ4hn02Dchx.SWU7URGPTeG7T..3fTvnb0DuHnOd3Y2', '2001-01-01', '2024-02-27 15:23:27', NULL, NULL, 0, 0, NULL),
(61, 0, 'Olivier', 'olivier@colnem.net', '$2y$10$llcExDYB/vzKRUN3xuMlyuuJAz5Vf5dF4LMo95NqwFyiXev9UjhPi', '1990-02-02', '2024-02-29 10:53:59', '2024-02-29 11:59:37', NULL, 0, 0, '$2y$10$iobe59RkzeEmLXGmwLHKgO6k3vMJqy0eNvCHgT32CsV2DdQeMSMqG'),
(62, 4, 'admin', 'admin@gmail.com', '$2y$10$pVpEG7GkK7OH4jNh0eF8h.yOpYYlDJPerKQxC71WawW9X.4GdHw0S', '2018-10-04', '2024-02-29 13:37:11', '2024-02-29 14:37:23', NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_niveau`
--

CREATE TABLE `utilisateur_niveau` (
  `id` int(11) NOT NULL,
  `niveau` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur_niveau`
--

INSERT INTO `utilisateur_niveau` (`id`, `niveau`) VALUES
(1, 'Invité'),
(2, 'Membre'),
(3, 'Modérateur'),
(4, 'Administrateur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bloquage_echange`
--
ALTER TABLE `bloquage_echange`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_BeIdSalon_SalonId` (`id_salon`),
  ADD KEY `FK_BeIdDemandeur_ParticipantIdUtilisateur` (`id_demandeur`),
  ADD KEY `FK_BeIdBloque_ParticipantIdUtilisateur` (`id_bloque`);

--
-- Index pour la table `forum_post`
--
ALTER TABLE `forum_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_DiscussionIdUtilisateur_UtilisateurId` (`id_utilisateur`),
  ADD KEY `FK_DiscussionIdSujet_SujetId` (`id_sujet`);

--
-- Index pour la table `forum_sujet`
--
ALTER TABLE `forum_sujet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_Titre_IdTheme` (`titre`,`id_theme`),
  ADD KEY `FK_SujetIdUtilisateur_UtilisateurId` (`id_utilisateur`),
  ADD KEY `FK_SujetIdTheme_ThemeId` (`id_theme`);

--
-- Index pour la table `forum_theme`
--
ALTER TABLE `forum_theme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `mp_echange`
--
ALTER TABLE `mp_echange`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_EchangeIdSalon_SalonId` (`id_salon`),
  ADD KEY `FK_EchangeIdExpediteur_ParticipantIdUtilisateur` (`id_expediteur`);

--
-- Index pour la table `mp_participant`
--
ALTER TABLE `mp_participant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_IdSalon_IdUtilisateur` (`id_salon`,`id_utilisateur`),
  ADD KEY `FK_ParticipantIdUtilisateur_UtilisateurId` (`id_utilisateur`);

--
-- Index pour la table `mp_salon`
--
ALTER TABLE `mp_salon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_SalonIdCreateur_UtilisateurId` (`id_createur`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD KEY `FK_ProfilIdGenre_GenreId` (`id_genre`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `utilisateur_niveau`
--
ALTER TABLE `utilisateur_niveau`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bloquage_echange`
--
ALTER TABLE `bloquage_echange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_post`
--
ALTER TABLE `forum_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_sujet`
--
ALTER TABLE `forum_sujet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_theme`
--
ALTER TABLE `forum_theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `mp_echange`
--
ALTER TABLE `mp_echange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mp_participant`
--
ALTER TABLE `mp_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `mp_salon`
--
ALTER TABLE `mp_salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `utilisateur_niveau`
--
ALTER TABLE `utilisateur_niveau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bloquage_echange`
--
ALTER TABLE `bloquage_echange`
  ADD CONSTRAINT `FK_BeIdBloque_ParticipantIdUtilisateur` FOREIGN KEY (`id_bloque`) REFERENCES `mp_participant` (`id_utilisateur`),
  ADD CONSTRAINT `FK_BeIdDemandeur_ParticipantIdUtilisateur` FOREIGN KEY (`id_demandeur`) REFERENCES `mp_participant` (`id_utilisateur`),
  ADD CONSTRAINT `FK_BeIdSalon_SalonId` FOREIGN KEY (`id_salon`) REFERENCES `mp_salon` (`id`);

--
-- Contraintes pour la table `forum_post`
--
ALTER TABLE `forum_post`
  ADD CONSTRAINT `FK_DiscussionIdSujet_SujetId` FOREIGN KEY (`id_sujet`) REFERENCES `forum_sujet` (`id`),
  ADD CONSTRAINT `FK_DiscussionIdUtilisateur_UtilisateurId` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `forum_sujet`
--
ALTER TABLE `forum_sujet`
  ADD CONSTRAINT `FK_SujetIdTheme_ThemeId` FOREIGN KEY (`id_theme`) REFERENCES `forum_theme` (`id`),
  ADD CONSTRAINT `FK_SujetIdUtilisateur_UtilisateurId` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `mp_echange`
--
ALTER TABLE `mp_echange`
  ADD CONSTRAINT `FK_EchangeIdExpediteur_ParticipantIdUtilisateur` FOREIGN KEY (`id_expediteur`) REFERENCES `mp_participant` (`id_utilisateur`),
  ADD CONSTRAINT `FK_EchangeIdSalon_SalonId` FOREIGN KEY (`id_salon`) REFERENCES `mp_salon` (`id`);

--
-- Contraintes pour la table `mp_participant`
--
ALTER TABLE `mp_participant`
  ADD CONSTRAINT `FK_ParticipantIdSalon_SalonId` FOREIGN KEY (`id_salon`) REFERENCES `mp_salon` (`id`),
  ADD CONSTRAINT `FK_ParticipantIdUtilisateur_UtilisateurId` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `mp_salon`
--
ALTER TABLE `mp_salon`
  ADD CONSTRAINT `FK_SalonIdCreateur_UtilisateurId` FOREIGN KEY (`id_createur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `FK_ProfilIdGenre_GenreId` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `FK_ProfilIdUtilisateur_UtilisateurId` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
