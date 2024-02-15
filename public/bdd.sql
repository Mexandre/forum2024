<?php
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 13 fév. 2024 à 15:26
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `forum_2024`
--

-- --------------------------------------------------------

--
-- Structure de la table `forum_users`
--

CREATE TABLE `forum_users` (
  `id` int(11) NOT NULL,
  `pseudo` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `mdp` text COLLATE utf8mb4_unicode_ci,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `forum_users`
--

INSERT INTO `forum_users` (`id`, `pseudo`, `email`, `mdp`, `date_create`) VALUES
(1, ':pseudo', ':email', ':mdp', '2024-02-23 12:30:20'),
(2, 'Zolive', 'qdfqds', '$2y$10$U2cPqlIObN3t00SLEm5luuevCZb9nS1Sy.H/6OMTb.kJcVW05sYiu', '2024-02-13 14:41:18'),
(3, 'ERic', 'eric@gmail.com', '$2y$10$EZ81nUEX0B1acV5ea9TctObBay4O61grsqGQr4Dxxo.AJD1x64Y26', '2024-02-13 15:19:14');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `forum_users`
--
ALTER TABLE `forum_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `forum_users`
--
ALTER TABLE `forum_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
