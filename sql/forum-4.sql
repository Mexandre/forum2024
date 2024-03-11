-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 11 mars 2024 à 11:17
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
-- Base de données : `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `forum_mp_msg`
--

CREATE TABLE `forum_mp_msg` (
  `id` int(11) NOT NULL,
  `mp_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_ip` varchar(40) NOT NULL,
  `date_posted` datetime NOT NULL,
  `msg` text NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `msg_read` tinyint(4) NOT NULL DEFAULT '0',
  `ratings` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_mp_subject`
--

CREATE TABLE `forum_mp_subject` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_ip` varchar(40) NOT NULL,
  `date_sent` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_polls`
--

CREATE TABLE `forum_polls` (
  `id` int(11) NOT NULL,
  `poll_question` varchar(150) NOT NULL,
  `poll_start` datetime NOT NULL,
  `poll_end` datetime NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_polls_options`
--

CREATE TABLE `forum_polls_options` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `poll_option` varchar(200) NOT NULL,
  `poll_votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_post`
--

CREATE TABLE `forum_post` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(40) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `edited_by_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `post_hide` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_theme`
--

CREATE TABLE `forum_theme` (
  `id` int(11) NOT NULL,
  `nom` varchar(120) NOT NULL,
  `theme_position` tinyint(4) NOT NULL DEFAULT '0',
  `theme_img_url` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `forum_theme`
--

INSERT INTO `forum_theme` (`id`, `nom`, `theme_position`, `theme_img_url`) VALUES
(1, 'Martial Art', 0, 0),
(2, 'Football', 0, 0),
(3, 'Vehicle', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `forum_topic`
--

CREATE TABLE `forum_topic` (
  `id` int(11) NOT NULL,
  `title` varchar(180) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(40) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `poll_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `first_post_id` int(11) NOT NULL,
  `first_post_date` datetime NOT NULL,
  `last_post_id` int(11) NOT NULL,
  `last_post_date` datetime NOT NULL,
  `num_views` int(11) NOT NULL,
  `num_replies` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_users_ban`
--

CREATE TABLE `forum_users_ban` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(40) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `msg` text NOT NULL,
  `ban_date` datetime NOT NULL,
  `ban_expire` datetime DEFAULT NULL,
  `ban_moderator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `level_id` tinyint(4) NOT NULL DEFAULT '0',
  `username` varchar(70) NOT NULL,
  `avatar_link` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `email_show` tinyint(4) NOT NULL DEFAULT '0',
  `email_blocked` tinyint(4) NOT NULL,
  `password` varchar(100) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `address` varchar(180) DEFAULT NULL,
  `country` varchar(80) DEFAULT NULL,
  `city` varchar(80) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `registration_ip` varchar(40) NOT NULL,
  `last_update_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `number_posts` int(11) NOT NULL,
  `number_pm` int(11) NOT NULL,
  `blocked` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `gender_id`, `level_id`, `username`, `avatar_link`, `email`, `email_show`, `email_blocked`, `password`, `lastname`, `firstname`, `address`, `country`, `city`, `zipcode`, `birth_date`, `registration_date`, `registration_ip`, `last_update_date`, `number_posts`, `number_pm`, `blocked`, `active`, `token`) VALUES
(1, NULL, 4, 'Zoliver', '', 'oallegret@gmail.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$Sm5jdnNUVFN4WklUaVJlRA$XNeCIrJ2iBWzNojmTKlNEMBEnE9u+fQi8sOPjO9gbkc', 'Allegret', 'Olivier', '55 route de Limonest', 'France', 'Lissieu', '69380', '1968-04-18', '2024-03-09 21:17:58', '', '2024-03-11 09:10:22', 0, 0, 0, 0, '$2y$10$W2d/lROdiw2Vh4q8Zu9FbOgNz03i8N49cruByEn2Vm4ruN3knuWT2'),
(2, NULL, 0, ':username', '', ':email', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$RjNXYlNXRExjcjNFN0k5eQ$QNYxmcoTbCa4GhTkmRduElfWljlef91d1K6iFrBdNXQ', ':lastname', ':firstname', ':address', 'blabla', ':city', ':zipcode', '1973-10-10', '2024-03-09 21:21:21', '', '2024-03-10 23:55:55', 0, 0, 0, 0, NULL),
(5, NULL, 0, 'Bobby', '', 'bobby@hotmail.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$ZnR5REFOS1hSbEo0VTVQMg$GOlVOsCkFJg2L9a7wWin4tAkgMYSsko5aSxKvDt5lM0', NULL, NULL, NULL, NULL, NULL, NULL, '1982-04-17', '2024-03-09 21:25:08', '', NULL, 0, 0, 0, 0, NULL),
(7, NULL, 0, 'Samuel', '', 'sam@lepompier.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$MUxsOGJWZ1M1UzNvQzhWMg$VXGSiUhCZRv1A0e1aYhJCl+hdjBqYG2SxFEY33YG644', NULL, NULL, NULL, NULL, NULL, NULL, '1989-11-05', '2024-03-09 21:38:50', '', NULL, 0, 0, 0, 0, NULL),
(11, NULL, 0, 'scljhsd@', '', 'ssdf@gmail.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$MUM3ZGFDYlZuSUQxYXBrQg$WvKqf6ntsuMrvyuqH02Df1CYtpyFLn/svRUyME4MDJo', NULL, NULL, NULL, NULL, NULL, NULL, '2000-02-10', '2024-03-09 21:43:50', '', NULL, 0, 0, 0, 0, NULL),
(16, NULL, 0, 'Patoche', '', 'olivier@rugbyfederal.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$T2lkWVlnMnhQZU1OL1J6aQ$PhgpJqkgYixATnZM+t8LsHJsvZqww4iVLUoQzUZmPNg', NULL, NULL, NULL, NULL, NULL, NULL, '1997-10-18', '2024-03-09 21:49:54', '', NULL, 0, 0, 0, 0, NULL),
(17, NULL, 0, 'Francis', '', 'admin@gmail.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$aFpPZDZ3azdOdG1IZWhWMw$kONlhj/WK2TxAfNHyQld8Hv+/2ubBbFlduYMBPYChVs', NULL, NULL, NULL, NULL, NULL, NULL, '1954-04-18', '2024-03-09 21:52:12', '', NULL, 0, 0, 0, 0, NULL),
(21, NULL, 0, 'grelkj', '', '', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$OFpsZW5aZjJvWk15OHlZbg$V1XqCwEIH85cQdyaaSerq+Gn9ujFqeU4sedK9Pwu7zE', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-10', '2024-03-09 22:04:30', '', NULL, 0, 0, 0, 0, NULL),
(22, NULL, 0, 'Zolive', '', 'obiwan@gmail.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$RjZjd3E0TGxkT0V2a1RqNA$/X3eRnRit+LOldpSLsDkSy0uSc07f8X0iLmBXZDlGrk', NULL, NULL, NULL, NULL, NULL, NULL, '2000-02-10', '2024-03-09 22:05:16', '', NULL, 0, 0, 0, 0, NULL),
(23, NULL, 0, 'Boba', '', 'boba@gmail.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$NVFPa2FBeXByb3lSQzVaLg$i66zfiMSxjWnjoXtGgGignYL4CEDnOKRXAMWQ6cX+tM', NULL, NULL, NULL, NULL, NULL, NULL, '1995-05-05', '2024-03-09 23:07:05', '', NULL, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_blocked`
--

CREATE TABLE `user_blocked` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `blocked_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_gender`
--

CREATE TABLE `user_gender` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_gender`
--

INSERT INTO `user_gender` (`id`, `name`) VALUES
(2, 'Female'),
(1, 'Male'),
(3, 'Non-Binary'),
(6, 'Not Specified'),
(5, 'Queer'),
(4, 'Transgender');

-- --------------------------------------------------------

--
-- Structure de la table `user_level`
--

CREATE TABLE `user_level` (
  `id` int(11) NOT NULL,
  `level` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_level`
--

INSERT INTO `user_level` (`id`, `level`) VALUES
(1, 'Guest'),
(2, 'Member'),
(3, 'Moderator'),
(4, 'Administrator');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `forum_mp_msg`
--
ALTER TABLE `forum_mp_msg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_RoomId_UserId` (`mp_id`),
  ADD KEY `FK_ParticipantUserId_UserId` (`mp_id`);

--
-- Index pour la table `forum_mp_subject`
--
ALTER TABLE `forum_mp_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ExchangeSenderId_ParticipantUserId` (`owner_id`);

--
-- Index pour la table `forum_polls`
--
ALTER TABLE `forum_polls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `forum_polls_options`
--
ALTER TABLE `forum_polls_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `poll_id` (`poll_id`);

--
-- Index pour la table `forum_post`
--
ALTER TABLE `forum_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PostUserId_UserID` (`user_id`),
  ADD KEY `FK_PostTopicId_TopicID` (`topic_id`);

--
-- Index pour la table `forum_theme`
--
ALTER TABLE `forum_theme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`nom`);

--
-- Index pour la table `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_Title_IdTheme` (`title`,`theme_id`),
  ADD KEY `FK_TopicUserId_UserID` (`user_id`),
  ADD KEY `FK_TopicThemeId_ThemeID` (`theme_id`);

--
-- Index pour la table `forum_users_ban`
--
ALTER TABLE `forum_users_ban`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK_UsergenderId_genderId` (`gender_id`);

--
-- Index pour la table `user_blocked`
--
ALTER TABLE `user_blocked`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_BeRequesterId_ParticipantUserId` (`requester_id`),
  ADD KEY `FK_BeBlockedId_ParticipantUserId` (`blocked_id`);

--
-- Index pour la table `user_gender`
--
ALTER TABLE `user_gender`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `forum_mp_msg`
--
ALTER TABLE `forum_mp_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_mp_subject`
--
ALTER TABLE `forum_mp_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_polls`
--
ALTER TABLE `forum_polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_polls_options`
--
ALTER TABLE `forum_polls_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_post`
--
ALTER TABLE `forum_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_theme`
--
ALTER TABLE `forum_theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `forum_topic`
--
ALTER TABLE `forum_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `forum_users_ban`
--
ALTER TABLE `forum_users_ban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `user_blocked`
--
ALTER TABLE `user_blocked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_gender`
--
ALTER TABLE `user_gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `forum_mp_msg`
--
ALTER TABLE `forum_mp_msg`
  ADD CONSTRAINT `FK_ParticipantUserId_UserId` FOREIGN KEY (`mp_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `forum_mp_subject`
--
ALTER TABLE `forum_mp_subject`
  ADD CONSTRAINT `FK_ExchangeSenderId_ParticipantUserId` FOREIGN KEY (`owner_id`) REFERENCES `forum_mp_msg` (`mp_id`);

--
-- Contraintes pour la table `forum_polls_options`
--
ALTER TABLE `forum_polls_options`
  ADD CONSTRAINT `forum_polls_options_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `forum_polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `forum_post`
--
ALTER TABLE `forum_post`
  ADD CONSTRAINT `FK_PostTopicId_TopicID` FOREIGN KEY (`topic_id`) REFERENCES `forum_topic` (`id`),
  ADD CONSTRAINT `FK_PostUserId_UserID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD CONSTRAINT `FK_TopicThemeId_ThemeID` FOREIGN KEY (`theme_id`) REFERENCES `forum_theme` (`id`),
  ADD CONSTRAINT `FK_TopicUserId_UserID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `forum_users_ban`
--
ALTER TABLE `forum_users_ban`
  ADD CONSTRAINT `forum_users_ban_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_UsergenderId_genderId` FOREIGN KEY (`gender_id`) REFERENCES `user_gender` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
