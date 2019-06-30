--
-- Structure de la table `meetings`
--

CREATE TABLE `meetings` (
  `id` varchar(32) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` varchar(10000) DEFAULT NULL,
  `organizerId` varchar(32) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `meetings`
--

INSERT INTO `meetings` (`id`, `title`, `description`, `organizerId`, `startDate`, `endDate`) VALUES
('7c0eee44fecb4efc9d744b8efdb16415', 'Pique-nique', NULL, '1653390815b44993a7bf2d3a601fe78e', '2019-07-03 11:00:00', '2019-07-03 14:00:00'),
('a067f058d4b04378a1ebd91b8423f39a', 'Réunion', 'Achat de fournitures', '1653390815b44993a7bf2d3a601fe78e', '2019-07-01 08:00:00', '2019-07-01 10:00:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizerId` (`organizerId`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_organizerId` FOREIGN KEY (`organizerId`) REFERENCES `users` (`id`);