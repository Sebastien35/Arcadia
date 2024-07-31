-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 25 juil. 2024 à 12:24
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `arcadia_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `additional_images`
--

CREATE TABLE `additional_images` (
  `id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `habitat_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `race` varchar(255) DEFAULT NULL,
  `habitat_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `animal`
--

INSERT INTO `animal` (`id`, `prenom`, `race`, `habitat_id`, `created_at`, `updated_at`, `image_name`) VALUES
(1, 'Alex', 'Lion', 1, '2024-07-17 12:52:21', NULL, '65f81c4100f36738583746.jpeg'),
(2, 'Marty', 'Zèbre', 1, '2024-07-17 12:52:21', NULL, '65f81db9300b9180917397.jpg'),
(3, 'Melman', 'Girafe', 1, '2024-07-17 12:52:21', NULL, '65f82e000fed2051454791.jpg'),
(4, 'Scrat', 'Ecureuil', 4, '2024-07-17 12:52:21', NULL, '65f82e13d4848777523960.jpeg'),
(5, 'Billy', 'Léopard des neiges', 3, '2024-07-17 12:52:21', NULL, '65f82e25ef41f462705377.jpeg'),
(6, 'Sirius', 'Panthère noire', 2, '2024-07-17 12:52:21', NULL, '65f82e5a9bcfa261678134.jpeg'),
(7, 'Moto-Moto', 'Hippopotame', 5, '2024-07-17 12:52:21', NULL, '65f82e8995be2637407034.jpg'),
(8, 'Gloria', 'Hippopotame', 5, '2024-07-17 12:52:21', NULL, '65f82ea57053b403287182.jpg'),
(9, 'Lucie', 'Marmotte', 3, '2024-07-17 12:52:21', NULL, '65f82f10ca9d3556392311.jpeg'),
(10, 'Gia', 'Jaguar', 2, '2024-07-17 12:52:21', NULL, '65f8bb93ec422977272701.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `avis_content` varchar(512) DEFAULT NULL,
  `note` int(11) DEFAULT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `zoo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `pseudo`, `avis_content`, `note`, `validation`, `created_at`, `zoo_id`) VALUES
(1, 'Alex', 'Superbe parc, j ai adoré !', 5, 1, '2024-07-17 12:52:21', 1),
(2, 'Marty', 'J ai passé un super moment, je recommande !', 5, 0, '2024-07-17 12:52:21', 1),
(3, 'Melman', 'J ai adoré, je reviendrai !', 5, 0, '2024-07-17 12:52:21', 1),
(4, 'Scrat', 'J ai adoré, je reviendrai !', 5, 1, '2024-07-17 12:52:21', 1),
(5, 'Billy', 'J ai adoré, je reviendrai !', 5, 1, '2024-07-17 12:52:21', 1),
(6, 'Sirius', 'Le restaurant est vraiment nul !', 1, 1, '2024-07-17 12:52:21', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire_habitat`
--

CREATE TABLE `commentaire_habitat` (
  `id` int(11) NOT NULL,
  `commentaire` text DEFAULT NULL,
  `habitat_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `auteur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commentaire_habitat`
--

INSERT INTO `commentaire_habitat` (`id`, `commentaire`, `habitat_id`, `created_at`, `updated_at`, `auteur_id`) VALUES
(1, 'Il faut changer l\' eau des animaux plus régulièrement', 1, '2024-07-17 12:52:21', NULL, 2),
(2, 'Rien à dire c\'est nickel', 2, '2024-07-17 12:52:21', NULL, 2),
(3, 'Les animaux sont bien traités', 3, '2024-07-17 12:52:21', NULL, 2),
(4, 'L\'enclos est propre, rien de particulier', 4, '2024-07-17 12:52:21', NULL, 2),
(5, 'Penser à replanter des arbustes au bord du point d\'eau numéro 3', 5, '2024-07-17 12:52:21', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `demande_contact`
--

CREATE TABLE `demande_contact` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `answered_at` datetime DEFAULT NULL,
  `answered` tinyint(1) DEFAULT 0,
  `zoo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `demande_contact`
--

INSERT INTO `demande_contact` (`id`, `titre`, `message`, `mail`, `created_at`, `answered_at`, `answered`, `zoo_id`) VALUES
(1, 'Demande de renseignements', 'Bonjour, je souhaiterais avoir des informations sur les horaires d ouverture du zoo.', 'jeanquete.ecfarcadia@gmail.com', '2024-07-17 12:52:22', '2024-07-18 12:16:18', 1, 1),
(2, 'Demande de renseignements', 'Bonjour, je souhaiterais avoir des informations sur les tarifs du zoo.', 'jeanquete.ecfarcadia@gmail.com', '2024-07-17 12:52:22', NULL, 0, 1),
(3, 'Stage de 3eme', 'Bonjour, je cherche un stage pour ma fille.', 'jeanquete.ecfarcadia@gmail.com', '2024-07-17 12:52:22', NULL, 0, 1),
(8, 'Test Cryptage', 'Ceci est un test', 'U8pbtdJYZKnpDJnaF2NulURHeHNPZFFiOFBXL3pVWGwrTUlncXgzYUlHQnhqVTRSK0VOQXRDb3FuUFU9', '2024-07-19 13:57:13', NULL, 0, 1),
(10, 'Test DDC2', 'Test DDC Chiffrement', 'HmYNGFtBDvF6zbj8M+LeoUdXK3Vud2x2ODBnTW5hR3V5ZXd6Vy9vb2F1N215SEdDSGpNaTFqMzgvSUU9', '2024-07-19 14:25:14', '2024-07-19 14:25:31', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `habitat`
--

CREATE TABLE `habitat` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `habitat`
--

INSERT INTO `habitat` (`id`, `nom`, `image_name`, `description`, `updated_at`) VALUES
(1, 'Savane', '65f8173e8dd4c673947480.jpeg', 'Des plaines arides, où vivent des animaux légendaires.', NULL),
(2, 'Jungle', '65f8171ab9f17598360842.jpeg', 'Une jungle luxuriante abritant des espèces rares et sauvages', NULL),
(3, 'Montagne', '65c605b27c6e1149964943.jpeg', 'Des pics rocheux enneigés abritant des espèces rares et captivantes', NULL),
(4, 'Forêt', '65c505469a665418670019.jpeg', 'Une forêt peuple de différents animaux de différents origines', NULL),
(5, 'Marais', '65e1f607678a1876940815.jpeg', 'Un écosystème riche en faune sauvage et en végétation luxuriante', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `horaire`
--

CREATE TABLE `horaire` (
  `id` int(11) NOT NULL,
  `jour` varchar(8) DEFAULT NULL,
  `h_ouverture` time DEFAULT NULL,
  `h_fermeture` time DEFAULT NULL,
  `ouvert` tinyint(1) DEFAULT 0,
  `zoo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `horaire`
--

INSERT INTO `horaire` (`id`, `jour`, `h_ouverture`, `h_fermeture`, `ouvert`, `zoo_id`) VALUES
(1, 'Lundi', '08:00:00', '18:00:00', 1, 1),
(2, 'Mardi', '08:00:00', '18:00:00', 1, 1),
(3, 'Mercredi', '08:00:00', '18:00:00', 1, 1),
(4, 'Jeudi', '08:00:00', '18:00:00', 1, 1),
(5, 'Vendredi', '08:00:00', '18:00:00', 1, 1),
(6, 'Samedi', '08:00:00', '18:00:00', 1, 1),
(7, 'Dimanche', '08:00:00', '18:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `info_animal`
--

CREATE TABLE `info_animal` (
  `id` int(11) NOT NULL,
  `nourriture_id` int(11) DEFAULT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `auteur_id` int(11) DEFAULT NULL,
  `etat` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `grammage` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `info_animal`
--

INSERT INTO `info_animal` (`id`, `nourriture_id`, `animal_id`, `auteur_id`, `etat`, `details`, `grammage`, `created_at`) VALUES
(1, 1, 1, 2, 'Bonne santé', 'RAS', 2000, '2024-07-17 12:52:22'),
(2, 2, 2, 2, 'Bonne santé', 'Marty est craintif', 1800, '2024-07-17 12:52:22'),
(3, 2, 3, 2, 'Malade', 'Melman a un rhume', 1600, '2024-07-17 12:52:22'),
(4, 4, 4, 2, 'Bonne santé', 'Scrat est gourmand', 1500, '2024-07-17 12:52:22'),
(5, 1, 5, 2, 'Bonne santé', 'Billy est joueur', 2000, '2024-07-17 12:52:22'),
(6, 1, 6, 2, 'Bonne santé', 'Sirius se plaît dans son nouvel enclos', 2000, '2024-07-17 12:52:22'),
(7, 2, 7, 2, 'Bonne santé', 'Moto-Moto est gourmand', 2200, '2024-07-17 12:52:22'),
(8, 2, 8, 2, 'Bonne santé', 'Gloria est en surpoids', 1900, '2024-07-17 12:52:22'),
(9, 4, 9, 2, 'Bonne santé', 'Lucie creuse un terrier', 2000, '2024-07-17 12:52:22'),
(10, 1, 10, 2, 'Bonne santé', 'Gia est enceinte', 2000, '2024-07-17 12:52:22');

-- --------------------------------------------------------

--
-- Structure de la table `nourriture`
--

CREATE TABLE `nourriture` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `nourriture`
--

INSERT INTO `nourriture` (`id`, `nom`, `description`) VALUES
(1, 'Nourriture pour félins', 'Mélange de viande, poisson, vitamines et minéraux pour les félins.'),
(2, 'Nourriture pour herbivores', 'Mélange de fruits, légumes, vitamines et minéraux pour les herbivores.'),
(3, 'Nourriture pour omnivores', 'Mélange de viande, fruits, légumes, vitamines et minéraux pour les omnivores.'),
(4, 'Nourriture pour rongeurs', 'Mélange de graines, fruits, légumes, vitamines et minéraux pour les rongeurs.'),
(5, 'Nourriture pour poissons', 'Mélange de granulés, vitamines et minéraux pour les poissons.'),
(6, 'Nourriture pour oiseaux', 'Mélange de graines, fruits, vitamines et minéraux pour les oiseaux.');

-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

CREATE TABLE `repas` (
  `id` int(11) NOT NULL,
  `nourriture_id` int(11) DEFAULT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `auteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `repas`
--

INSERT INTO `repas` (`id`, `nourriture_id`, `animal_id`, `datetime`, `quantite`, `auteur`) VALUES
(1, 1, 1, '2024-07-17 12:52:23', 200, NULL),
(2, 2, 2, '2024-07-17 12:52:23', 180, NULL),
(3, 2, 3, '2024-07-17 12:52:23', 160, NULL),
(4, 4, 4, '2024-07-17 12:52:23', 150, NULL),
(5, 1, 5, '2024-07-17 12:52:23', 200, NULL),
(6, 1, 6, '2024-07-17 12:52:23', 200, NULL),
(7, 2, 7, '2024-07-17 12:52:23', 220, NULL),
(8, 2, 8, '2024-07-17 12:52:23', 190, NULL),
(9, 4, 9, '2024-07-17 12:52:23', 200, NULL),
(10, 1, 10, '2024-07-17 12:52:23', 200, NULL),
(11, 1, 1, '2024-07-10 12:52:23', 200, NULL),
(12, 2, 2, '2024-07-10 12:52:23', 180, NULL),
(13, 2, 3, '2024-07-10 12:52:23', 160, NULL),
(14, 4, 4, '2024-07-10 12:52:23', 150, NULL),
(15, 1, 5, '2024-07-10 12:52:23', 200, NULL),
(16, 1, 6, '2024-07-10 12:52:23', 200, NULL),
(17, 2, 7, '2024-07-10 12:52:23', 220, NULL),
(18, 2, 8, '2024-07-10 12:52:23', 190, NULL),
(19, 4, 9, '2024-07-10 12:52:23', 200, NULL),
(20, 1, 10, '2024-07-10 12:52:23', 200, NULL),
(21, 1, 1, '2024-07-14 12:52:23', 200, NULL),
(22, 2, 2, '2024-07-14 12:52:23', 180, NULL),
(23, 2, 3, '2024-07-14 12:52:23', 160, NULL),
(24, 4, 4, '2024-07-14 12:52:23', 150, NULL),
(25, 1, 5, '2024-07-14 12:52:23', 200, NULL),
(26, 1, 6, '2024-07-14 12:52:23', 200, NULL),
(27, 2, 7, '2024-07-14 12:52:23', 220, NULL),
(28, 2, 8, '2024-07-14 12:52:23', 190, NULL),
(29, 4, 9, '2024-07-14 12:52:23', 200, NULL),
(30, 1, 10, '2024-07-14 12:52:23', 200, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) NOT NULL,
  `hashed_token` varchar(100) NOT NULL,
  `requested_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `zoo_id` int(11) DEFAULT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `zoo_id`, `nom`, `description`, `created_at`, `updated_at`, `image_name`) VALUES
(1, 1, 'Restaurant', 'Profitez d\'une pause gourmande près des animaux.', '2024-07-17 12:52:21', NULL, '65f81f89bb38d643616718.webp'),
(2, 1, 'Balade en petit train', 'Une balade autour du zoo dans un petit train', '2024-07-17 12:52:21', NULL, '65f82c1d3c3a7400963628.webp'),
(3, 1, 'Visite guidée des habitats', 'Visitez les animaux accompagnés d\'un guide vétérinaire.', '2024-07-17 12:52:21', NULL, '65f82d2f91802833866449.webp');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(180) DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `zoo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `roles`, `password`, `created_at`, `updated_at`, `zoo_id`) VALUES
(1, 'jose.ecfarcadia@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$kogaXD.FqLit8B5Uo1721uxzuQYOc6HqyOvC.EcOrLqjHRsb2Ui2u', '2024-07-17 12:52:08', NULL, 1),
(2, 'veterinaire.ecfarcadia@gmail.com', '[\"ROLE_VET\"]', '$2y$13$RsH6PyiFMLAAWTSMfDBh4ucF8FWzWe9DWzzJ19WfDjc6G9pbxPt9C', '2024-07-17 12:52:09', NULL, 1),
(3, 'employe.ecfarcadia@gmail.com', '[\"ROLE_EMPLOYE\"]', '$2y$13$NC8HiV4ORqQuTR6pzwUlg.Xb.7UMhmKBH7ZCV15z4JE5D9G9SHnhy', '2024-07-17 12:52:09', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `zoo`
--

CREATE TABLE `zoo` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `zoo`
--

INSERT INTO `zoo` (`id`, `nom`) VALUES
(1, 'Arcadia');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `additional_images`
--
ALTER TABLE `additional_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_animal_id_for_additional_images` (`animal_id`),
  ADD KEY `FK_habitat_id_for_additional_images` (`habitat_id`);

--
-- Index pour la table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_habitat_for_animal` (`habitat_id`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_zoo_id_for_avis` (`zoo_id`);

--
-- Index pour la table `commentaire_habitat`
--
ALTER TABLE `commentaire_habitat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_habitat_id_for_commentaire` (`habitat_id`),
  ADD KEY `FK_auteur_id_for_commentaire` (`auteur_id`);

--
-- Index pour la table `demande_contact`
--
ALTER TABLE `demande_contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_zoo_id_for_demande` (`zoo_id`);

--
-- Index pour la table `habitat`
--
ALTER TABLE `habitat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `horaire`
--
ALTER TABLE `horaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `info_animal`
--
ALTER TABLE `info_animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_animal_for_infoAnimal` (`animal_id`),
  ADD KEY `FK_nourriture_for_infoAnimal` (`nourriture_id`),
  ADD KEY `FK_auteur_for_infoAnimal` (`auteur_id`);

--
-- Index pour la table `nourriture`
--
ALTER TABLE `nourriture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `repas`
--
ALTER TABLE `repas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_animal_for_repas` (`animal_id`),
  ADD KEY `FK_nourriture_for_repas` (`nourriture_id`),
  ADD KEY `FK_auteur_for_repas` (`auteur`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_for_password_reset` (`user_id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_zoo_id_for_service` (`zoo_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_zoo_id_for_user` (`zoo_id`);

--
-- Index pour la table `zoo`
--
ALTER TABLE `zoo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `additional_images`
--
ALTER TABLE `additional_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commentaire_habitat`
--
ALTER TABLE `commentaire_habitat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `demande_contact`
--
ALTER TABLE `demande_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `habitat`
--
ALTER TABLE `habitat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `horaire`
--
ALTER TABLE `horaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `info_animal`
--
ALTER TABLE `info_animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `nourriture`
--
ALTER TABLE `nourriture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `repas`
--
ALTER TABLE `repas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `zoo`
--
ALTER TABLE `zoo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `additional_images`
--
ALTER TABLE `additional_images`
  ADD CONSTRAINT `FK_animal_id_for_additional_images` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  ADD CONSTRAINT `FK_habitat_id_for_additional_images` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`);

--
-- Contraintes pour la table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `FK_habitat_for_animal` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `FK_zoo_id_for_avis` FOREIGN KEY (`zoo_id`) REFERENCES `zoo` (`id`);

--
-- Contraintes pour la table `commentaire_habitat`
--
ALTER TABLE `commentaire_habitat`
  ADD CONSTRAINT `FK_auteur_id_for_commentaire` FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_habitat_id_for_commentaire` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`);

--
-- Contraintes pour la table `demande_contact`
--
ALTER TABLE `demande_contact`
  ADD CONSTRAINT `FK_zoo_id_for_demande` FOREIGN KEY (`zoo_id`) REFERENCES `zoo` (`id`);

--
-- Contraintes pour la table `info_animal`
--
ALTER TABLE `info_animal`
  ADD CONSTRAINT `FK_animal_for_infoAnimal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  ADD CONSTRAINT `FK_auteur_for_infoAnimal` FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_nourriture_for_infoAnimal` FOREIGN KEY (`nourriture_id`) REFERENCES `nourriture` (`id`);

--
-- Contraintes pour la table `repas`
--
ALTER TABLE `repas`
  ADD CONSTRAINT `FK_animal_for_repas` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  ADD CONSTRAINT `FK_auteur_for_repas` FOREIGN KEY (`auteur`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_nourriture_for_repas` FOREIGN KEY (`nourriture_id`) REFERENCES `nourriture` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_user_for_password_reset` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `FK_zoo_id_for_service` FOREIGN KEY (`zoo_id`) REFERENCES `zoo` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_zoo_id_for_user` FOREIGN KEY (`zoo_id`) REFERENCES `zoo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
