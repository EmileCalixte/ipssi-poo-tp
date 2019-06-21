CREATE TABLE `films` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `films` (`title`) VALUES
  ('Star Wars épisode 1'),
  ('Star Wars épisode 2'),
  ('Star Wars épisode 3'),
  ('Star Wars épisode 4'),
  ('Star Wars épisode 5'),
  ('Star Wars épisode 6'),
  ('Star Wars épisode 7'),
  ('Star Wars épisode 8'),
  ('Star Wars épisode 9');
