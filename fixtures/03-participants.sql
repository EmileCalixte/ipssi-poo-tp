CREATE TABLE `participants` (
  `userId` varchar(32) NOT NULL,
  `meetingId` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`userId`, `meetingId`) VALUES
('421c4baefce3406c97b94244d9f8a1b4', 'a067f058d4b04378a1ebd91b8423f39a'),
('64be8faa6d564cdcbbfde626eb12417f', 'a067f058d4b04378a1ebd91b8423f39a');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`userId`,`meetingId`),
  ADD KEY `participants_meetingId` (`meetingId`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_meetingId` FOREIGN KEY (`meetingId`) REFERENCES `meetings` (`id`),
  ADD CONSTRAINT `participants_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);