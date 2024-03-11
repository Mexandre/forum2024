-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 11 mars 2024 à 12:47
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
  `sender_ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_posted` datetime NOT NULL,
  `msg` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `msg_read` tinyint(4) NOT NULL DEFAULT '0',
  `ratings` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forum_mp_subject`
--

CREATE TABLE `forum_mp_subject` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `msg` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_sent` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forum_polls`
--

CREATE TABLE `forum_polls` (
  `id` int(11) NOT NULL,
  `poll_question` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poll_start` datetime NOT NULL,
  `poll_end` datetime NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forum_polls_options`
--

CREATE TABLE `forum_polls_options` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `poll_option` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poll_votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forum_post`
--

CREATE TABLE `forum_post` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `msg` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `edited_by_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `post_hide` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forum_theme`
--

CREATE TABLE `forum_theme` (
  `id` int(11) NOT NULL,
  `nom` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_position` tinyint(4) NOT NULL DEFAULT '0',
  `theme_img_url` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `title` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forum_users_ban`
--

CREATE TABLE `forum_users_ban` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ban_date` datetime NOT NULL,
  `ban_expire` datetime DEFAULT NULL,
  `ban_moderator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `level_id` tinyint(4) NOT NULL DEFAULT '0',
  `username` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_link` mediumtext COLLATE utf8mb4_unicode_ci,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_show` tinyint(4) NOT NULL DEFAULT '0',
  `email_blocked` tinyint(4) NOT NULL DEFAULT '0',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `registration_ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `number_posts` int(11) DEFAULT NULL,
  `number_pm` int(11) DEFAULT NULL,
  `blocked` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `token` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `gender_id`, `level_id`, `username`, `avatar_link`, `email`, `email_show`, `email_blocked`, `password`, `lastname`, `firstname`, `address`, `country`, `city`, `zipcode`, `birth_date`, `registration_date`, `registration_ip`, `last_update_date`, `number_posts`, `number_pm`, `blocked`, `active`, `token`) VALUES
(25, NULL, 0, 'Zolive', NULL, 'oallegret@gmail.com', 0, 0, '$argon2id$v=19$m=131072,t=4,p=2$TjFncGFXM3lHeVRCTTVBRA$7UnoTgktJLr3LmehArVWtu8XVGovmP0kq/a4lrjrkXo', 'Allegret', 'Olivier', '55 route de Limonest', 'France', 'Lissieu', '69380', '1968-04-18', '2024-03-11 13:17:49', '::1', NULL, NULL, NULL, 0, 0, '$2y$10$7Munh5h.zqHvVVHNiHU1IOET1ayNTEyTy3bHPEqdTLRl7q.eCnLpe');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_gender`
--

CREATE TABLE `user_gender` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `level` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
