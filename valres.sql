

DROP TABLE IF EXISTS `categorie_salle`;
CREATE TABLE IF NOT EXISTS `categorie_salle` (
  `idCategorieSalle` int NOT NULL,
  `libelle` varchar(32) NOT NULL,
  PRIMARY KEY (`idCategorieSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `categorie_salle` (`idCategorieSalle`, `libelle`) VALUES
(1, 'Salle de réunion'),
(2, 'Salle avec équipements'),
(3, 'Amphithéâtre');


DROP TABLE IF EXISTS `etatreservation`;
CREATE TABLE IF NOT EXISTS `etatreservation` (
  `idEtat` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(32) NOT NULL,
  PRIMARY KEY (`idEtat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `etatreservation` (`idEtat`, `libelle`) VALUES
(1, 'Provisoire'),
(2, 'Confirmé'),
(3, 'Annulé');


DROP TABLE IF EXISTS `periode`;
CREATE TABLE IF NOT EXISTS `periode` (
  `idPeriode` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`idPeriode`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `periode` (`idPeriode`, `libelle`) VALUES
(1, 'Matinée'),
(2, 'Midi'),
(3, 'Après-midi'),
(4, 'Soirée');


DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `idReservation` int NOT NULL AUTO_INCREMENT,
  `datee` date NOT NULL,
  `idPeriode` int NOT NULL,
  `idUtilisateur` int NOT NULL,
  `idEtat` int NOT NULL,
  `idSalle` int NOT NULL,
  `idCreateur` int NOT NULL,
  PRIMARY KEY (`idReservation`),
  KEY `idPeriode` (`idPeriode`),
  KEY `idUtilisateur` (`idUtilisateur`),
  KEY `idEtat` (`idEtat`),
  KEY `reservation_ibfk_3` (`idSalle`),
  KEY `idCreateur` (`idCreateur`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `reservation` (`idReservation`, `datee`, `idPeriode`, `idUtilisateur`, `idEtat`, `idSalle`, `idCreateur`)
VALUES
(1, '2024-01-10', 1, 1, 1, 1, 9),  -- Provisoire: Creator ID 9
(2, '2024-01-11', 2, 2, 1, 1, 9),  -- Provisoire: Creator ID 9
(3, '2024-01-12', 3, 3, 1, 1, 9),  -- Provisoire: Creator ID 9
(4, '2024-01-15', 4, 4, 2, 1, 8),  -- Confirmé: Creator ID 8
(5, '2024-01-16', 2, 5, 2, 1, 8),  -- Confirmé: Creator ID 8
(6, '2024-01-14', 1, 1, 1, 1, 9),  -- Provisoire: Creator ID 9
(7, '2024-01-14', 2, 2, 1, 2, 9),  -- Provisoire: Creator ID 9
(8, '2024-01-14', 3, 3, 1, 3, 9),  -- Provisoire: Creator ID 9
(9, '2024-01-14', 4, 4, 2, 4, 8),  -- Confirmé: Creator ID 8
(10, '2024-01-14', 2, 5, 2, 5, 8),  -- Confirmé: Creator ID 8
(11, '2024-01-14', 3, 6, 2, 6, 9),  -- Provisoire: Creator ID 9
(12, '2024-01-09', 1, 1, 1, 1, 9),  -- Provisoire: Creator ID 9
(13, '2024-01-10', 2, 2, 1, 2, 9),  -- Provisoire: Creator ID 9
(14, '2024-01-11', 3, 3, 1, 3, 9),  -- Provisoire: Creator ID 9
(15, '2024-01-09', 1, 1, 1, 1, 9),  -- Provisoire: Creator ID 9
(16, '2024-01-10', 2, 2, 1, 2, 9),  -- Provisoire: Creator ID 9
(17, '2024-01-11', 3, 3, 1, 3, 9),  -- Provisoire: Creator ID 9
(18, '2024-01-15', 1, 4, 2, 4, 8),  -- Confirmé: Creator ID 8
(19, '2024-01-16', 2, 5, 1, 5, 9),  -- Provisoire: Creator ID 9
(20, '2024-01-17', 3, 6, 1, 6, 9),  -- Provisoire: Creator ID 9
(21, '2024-01-17', 3, 7, 1, 5, 9),  -- Provisoire: Creator ID 9
(22, '2024-01-10', 3, 2, 1, 6, 9),  -- Provisoire: Creator ID 9
(23, '2024-01-08', 3, 7, 1, 1, 9),  -- Provisoire: Creator ID 9
(24, '2024-01-14', 3, 1, 2, 4, 9),  -- Provisoire: Creator ID 9
(25, '2024-01-06', 3, 10, 3, 7, 8),
(26, '2024-01-30', 4, 8, 2, 13, 8),
(27, '2024-01-02', 3, 8, 2, 10, 8),
(28, '2024-01-19', 2, 4, 1, 5, 9),
(29, '2024-01-02', 1, 9, 2, 1, 8),
(30, '2024-01-13', 1, 1, 3, 9, 8),
(31, '2024-01-17', 3, 3, 3, 13, 9),
(32, '2024-01-07', 3, 9, 3, 10, 8),
(33, '2024-01-10', 3, 4, 1, 4, 9),
(34, '2024-12-09', 4, 6, 3, 5, 8),
(35, '2024-01-27', 3, 8, 2, 9, 8),
(36, '2024-01-03', 1, 1, 3, 5, 9),
(37, '2024-01-05', 3, 3, 3, 5, 9),
(38, '2024-01-07', 1, 5, 1, 8, 8),
(39, '2024-01-05', 3, 7, 1, 1, 8),
(40, '2024-01-13', 3, 2, 3, 11, 9),
(41, '2024-01-14', 1, 7, 2, 5, 8),
(42, '2024-01-17', 1, 5, 2, 3, 8),
(43, '2024-01-22', 4, 3, 1, 1, 9),
(44, '2024-01-06', 4, 10, 3, 14, 8);


DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `idSalle` int NOT NULL,
  `salle_nom` varchar(32) NOT NULL,
  `capacite` int NOT NULL,
  `idCategorieSalle` int NOT NULL,
  PRIMARY KEY (`idSalle`),
  KEY `salle_ibfk_1` (`idCategorieSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `salle` (`idSalle`, `salle_nom`, `capacite`, `idCategorieSalle`) VALUES
(1, 'Daum',15, 1),
(2, 'Corbin',20, 1),
(3, 'Baccarat',30, 1),
(4, 'Longwy',12, 1),
(5, 'Multimédia',50, 2),
(6, 'Amphithéâtre',200, 3),
(7, 'Lamour',50, 1),
(8, 'Grüber', 40, 1),
(9, 'Majorelle', 50, 1),
(10, 'Salle de restauration',50, 2),
(11, 'Galerie', 25, 1),
(12, 'Salle informatique', 20, 2),
(13, 'Hall d\'accueil', 50, 2),
(14, 'Gallé',40, 1);


DROP TABLE IF EXISTS `structure`;
CREATE TABLE IF NOT EXISTS `structure` (
  `idStructure` int NOT NULL,
  `structure_nom` varchar(80) DEFAULT NULL,
  `structure_adresse` varchar(80) NOT NULL,
  PRIMARY KEY (`idStructure`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `structure` (`idStructure`, `structure_nom`, `structure_adresse`) VALUES
(1, 'Ligue d\'escrime Lorraine', '5, rue des trois épis 54600 Villers lès Nancy'),
(2, 'Fives Nordon', '5 Pl. Aimé Morot 54000 Nancy'),
(3, 'FFT- COMITE DEPARTEMENTAL DE TENNIS DE MOSELLE', '42, rue de la commanderie 54840 Sexey les bois'),
(4, 'Ligue Volley Ball Lorraine', '30, rue Widric 1er 54600 Villers lès Nancy'),
(5, 'Sporting Club Ennery', '48 Rue Marcel Decker, 57365 Ennery'),
(6, 'Lycée public Frederic Chopin', '39 rue du Sergent Blandan 54000 Nancy'),
(7, 'Association Sportive Nancy Lorraine (ASNL)', '30, rue Widric 1er 54600 Villers lès Nancy'),
(8, 'Maison des ligues', '5 Rue Albéric 57000 Metz');

DROP TABLE IF EXISTS `type_accees`;
CREATE TABLE IF NOT EXISTS `type_accees` (
  `idAccees` int NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`idAccees`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `type_accees` (`idAccees`, `libelle`) VALUES
(1, 'Administrateur'),
(2, 'Secrétariat'),
(3, 'Responsable'),
(4, 'Utilisateur');


DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(32) NOT NULL,
  `motDePasse` varchar(50) NOT NULL,
  `idStructure` int NOT NULL,
  `idAccees` int NOT NULL,
  PRIMARY KEY (`idUtilisateur`),
  KEY `idStructure` (`idStructure`),
  KEY `idAccees` (`idAccees`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `utilisateur` (`idUtilisateur`, `nom`, `prenom`, `mail`, `motDePasse`, `idStructure`, `idAccees`) VALUES
(1, 'BANDILELLA', 'CLEMENT', 'clement@gmail.com', 'clement12', 4, 4),
(2, 'BIACQUEL', 'VERONIQUE', 'vero@gmail.com', 'veronique12321', 2, 4),
(3, 'SILBERT', 'GILLES', 'gilles@gmail.com', 'gilles111', 5, 4),
(4, 'TORTEMANN', 'PIERRE', 'pierre@gmail.com', 'pierre1932', 7, 4),
(5, 'PERNOT', 'LEA', 'lea@gmail.com', 'lea1408', 6, 4),
(6, 'ZUEL', 'STEPHANIE', 'stephanie@gmail.com', 'stephanie131231', 2, 4),
(7, 'LIEVIN', 'NATHAN', 'nathan@gmail.com', 'nathan1111', 3, 4),
(8, 'LEROY', 'NICOLAS', 'nicolas@gmail.com', 'nicolas456', 7, 2),
(9, 'MARTIN', 'LAURA', 'laura@gmail.com', 'laura789', 7, 3),
(10, 'PICARD', 'Emilie', 'emilie@gmail.com', 'emilie9982', 7, 1);

ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`idEtat`) REFERENCES `etatreservation` (`idEtat`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`idSalle`) REFERENCES `salle` (`idSalle`),
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`idPeriode`) REFERENCES `periode` (`idPeriode`),
  ADD CONSTRAINT `reservation_ibfk_5` FOREIGN KEY (`idCreateur`) REFERENCES `utilisateur` (`idUtilisateur`);

ALTER TABLE `salle`
  ADD CONSTRAINT `salle_ibfk_1` FOREIGN KEY (`idCategorieSalle`) REFERENCES `categorie_salle` (`idCategorieSalle`);


ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idStructure`) REFERENCES `structure` (`idStructure`),
  ADD CONSTRAINT `utilisateur_ibfk_3` FOREIGN KEY (`idAccees`) REFERENCES `type_accees` (`idAccees`);
