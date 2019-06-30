--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `passwordHash`) VALUES
('1653390815b44993a7bf2d3a601fe78e', 'Emile Calixte', 'calixte.emile@gmail.com', '$2y$10$9eh6M8XhBsDLYshFyM9Z9u/Ow1A.0cAg07uYmjQyAhqceH9i5gY5G'),
('3d7cbfb676e44911870cb38f4b9962b7', 'demo2', 'demo2@example.com', '$2y$10$OK19PxFAby93yq1DRwXI1.qXIF5bFNWQosNn8JHzOD0VAlcM6VKWC'),
('421c4baefce3406c97b94244d9f8a1b4', 'demo1', 'demo1@example.com', '$2y$10$IQWM82ajoAuEu3vJ7mSUROYavMj3IwFOvp/DfZwNhrJ1R6EVfOCBO'),
('64be8faa6d564cdcbbfde626eb12417f', 'demo3', 'demo3@example.com', '$2y$10$eItV0GBEVuEY6/XLEwuSX.nk3ITnvlK.WAL2U52I6N1YU2rZRc25u'),
('f9600655acac47cca11b414e3346c0ea', 'demo4', 'demo4@example.com', '$2y$10$l2dk1cSw4hd4SLqbo52a.uW671TVUJHcYTw6ZY0l9vKb8LCwd4zEa');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);