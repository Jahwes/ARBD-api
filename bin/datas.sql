INSERT IGNORE INTO `Movie` (`id`, `title`, `duration`)
VALUES
    (1, 'Fatal Punishment'         , 120),
    (2, 'Sudden Blood'             , 120),
    (3, 'Le Grand Vert'            , 120),
    (4, "Coup de foudre à Shanghai", 120),
    (5, 'Star Fight'                , 120),
    (6, 'Le Donjon de la mort 4'    , 120),
    (7, 'Master of Assassination'   , 120),
    (8, 'Microcosmos'               , 120),
    (9, 'L\'horreur dans le miroir' , 120);

--
-- Dumping data for table `User`
--
INSERT IGNORE INTO `User` (`id`, `lastname`, `firstname`, `date_of_birth`, `title`, `email`)
VALUES
    (1, 'HEART'   , 'Kingston' , '1994-02-15', 'Monsieur'    , 'heart_k@etna.io'                 ),
    (2, 'BELANGER', 'Angélique', '1970-04-11', 'Madame'      , 'AngeliqueBelanger@jourrapide.com'),
    (3, 'TALON'   , 'Faure'    , '1986-04-06', 'Monsieur'    , 'TalonFaure@redbearstavern.com'   ),
    (4, 'NOUEL'   , 'Soucy'    , '1941-06-17', 'Madame'      , 'NouelSoucy@rhyta.com'            ),
    (5, 'MELVILLE', 'Lamy'     , '1957-12-04', 'Mademoiselle', 'MelvilleLamy@dayrep.com'         );

--
-- Dumping data for table `Type`
--
INSERT IGNORE INTO `Type` (`id`, `name`)
VALUES
    (1 , 'fantastique'),
    (2 , 'horreur'    ),
    (3 , 'animation'  ),
    (4 , 'drama'      ),
    (5 , 'thriller'   ),
    (6 , 'aventure'   ),
    (7 , 'guerre'     ),
    (8 , 'policier'   ),
    (9 , 'musical'    ),
    (10, 'policier'   ),
    (11, 'romantique' );

--
-- Dumping data for table `Spectator`
--
INSERT IGNORE INTO `Spectator` (`id`, `lastname`, `firstname`, `age`, `title`)
VALUES
    (1, 'HEART'   , 'Kingston' , 25, 'Monsieur'    ),
    (2, 'BELANGER', 'Angélique', 25, 'Madame'      ),
    (3, 'TALON'   , 'Faure'    , 25, 'Monsieur'    ),
    (4, 'NOUEL'   , 'Soucy'    , 25, 'Madame'      ),
    (5, 'MELVILLE', 'Lamy'     , 25, 'Mademoiselle'),
    (6, 'IGNACE'  , 'Béland'   , 25, 'Monsieur'    ),
    (7, 'AUCLAIR' , 'Diane'    , 25, 'Mademoiselle'),
    (8, 'FOREST'  , 'Barry'    , 25, 'Monsieur'    ),
    (9, 'CLOUTIER', 'Minette'  , 25, 'Mademoiselle');

--
-- Dumping data for table `Room`
--
INSERT IGNORE INTO `Room` (`id`, `nb_places`)
VALUES
    (1, 50 ),
    (2, 35 ),
    (3, 78 ),
    (4, 90 ),
    (5, 25 ),
    (6, 129),
    (7, 157);

--
-- Dumping data for table `Price`
--
INSERT IGNORE INTO `Price` (`id`, `type_name`, `value`, `current`)
VALUES
    (1, 'Plein tarif'   , 9.4, 1),
    (2, 'Tarif reduit'  , 7.4, 1),
    (3, 'Senior'        , 6.8, 1),
    (4, 'Tarif etudiant', 6.8, 1);

--
-- Dumping data for table `People`
--
INSERT IGNORE INTO `People` (`id`, `firstname`, `lastname`, `date_of_birth`, `nationality`)
VALUES
    (1,  'Norman'   , 'GRANT'    , '1980-09-10', 'américaine' ),
    (2,  'Rhonda'   , 'BRADY'    , '1965-06-23', 'américaine' ),
    (3,  'Frankie'  , 'PAYNE'    , '1976-12-12', 'britannique'),
    (4,  'Kayla'    , 'WELCH'    , '1987-10-26', 'allemande'  ),
    (5,  'Dean'     , 'HOPKINS'  , '1956-03-06', 'américaine' ),
    (6,  'Lynn'     , 'COOK'     , '1989-05-23', 'britannique'),
    (7,  'Merle'    , 'FLOYD'    , '1976-08-19', 'britannique'),
    (8,  'Marcella' , 'LARSON'   , '1986-07-26', 'britannique'),
    (9,  'William'  , 'COLLIER'  , '1989-04-02', 'française'  ),
    (10, 'Orlando'  , 'RODRIGUEZ', '1968-08-23', 'espagnole'  ),
    (11, 'Dianne'   , 'BREWER'   , '1987-09-09', 'américaine' ),
    (12, 'Priscilla', 'LITTLE'   , '1991-09-09', 'américaine' );



--
-- Dumping data for table `Movie_has_Type`
--
INSERT IGNORE INTO `Movie_has_Type` (`Movie_id`, `Type_id`)
VALUES
    (1, 1 ),
    (2, 1 ),
    (2, 5 ),
    (2, 10),
    (3, 3 ),
    (3, 6 ),
    (3, 7 ),
    (4, 4 ),
    (4, 5 ),
    (4, 6 ),
    (5, 6 );

--
-- Dumping data for table `Movie_has_People`
--
INSERT IGNORE INTO `Movie_has_People` (`Movie_id`, `People_id`, `role`, `significance`)
VALUES
    (1,  1, 'acteur' ,  'principal'),
    (1,  2, 'actrice',  'principal'),
    (1,  3, 'acteur' , 'secondaire'),
    (1,  4, 'actrice', 'secondaire'),
    (2,  5, 'acteur' ,  'principal'),
    (2,  6, 'actrice',  'principal'),
    (2,  1, 'acteur' , 'secondaire'),
    (2,  2, 'actrice', 'secondaire'),
    (3,  7, 'acteur' ,  'principal'),
    (3,  8, 'actrice',  'principal'),
    (3,  9, 'acteur' , 'secondaire'),
    (3,  6, 'actrice', 'secondaire'),
    (4,  9, 'acteur' ,  'principal'),
    (4, 12, 'actrice',  'principal'),
    (4,  5, 'acteur' , 'secondaire'),
    (4,  4, 'actrice', 'secondaire'),
    (5, 10, 'acteur' ,  'principal'),
    (5, 11, 'actrice',  'principal'),
    (5,  1, 'acteur' , 'secondaire'),
    (5,  3, 'acteur' , 'secondaire'),
    (6,  5,  'acteur',  'principal'),
    (6, 10,  'acteur',  'principal'),
    (6,  4, 'actrice', 'secondaire'),
    (6,  8, 'actrice', 'secondaire'),
    (7, 12, 'actrice', 'principal'),
    (7,  3,  'acteur', 'secondaire'),
    (7,  9,  'acteur', 'secondaire'),
    (7,  2, 'actrice', 'secondaire'),
    (8, 11, 'actrice', 'principal'),
    (8,  5,  'acteur', 'secondaire'),
    (8,  6, 'actrice', 'secondaire'),
    (8,  8, 'actrice', 'secondaire'),
    (9,  7,  'acteur',  'principal'),
    (9,  3, 'actrice', 'secondaire'),
    (9,  4,  'acteur', 'secondaire');

--
-- Dumping data for table `Order`
--
INSERT IGNORE INTO `Order` (`id`, `created_at`, `User_id`)
VALUES
    (1, '2016-10-18', 1),
    (2, '2016-09-28', 1),
    (3, '2016-09-27', 2),
    (4, '2016-09-17', 3),
    (5, '2016-09-15', 4),
    (6, '2016-09-13', 4);

--
-- Dumping data for table `Showing`
--
INSERT IGNORE INTO `Showing` (`id`, `date`, `3D`, `Room_id`, `Movie_id`)
VALUES
    (1, '2016-11-18 10:00:00', 1, 1, 1),
    (2, '2016-11-16 09:35:00', 0, 2, 2),
    (3, '2016-11-24 14:50:00', 1, 3, 2),
    (4, '2016-11-28 15:45:00', 0, 4, 3),
    (5, '2016-12-01 13:35:00', 1, 5, 4);

--
-- Dumping data for table `Ticket`
--
INSERT IGNORE INTO `Ticket` (`id`, `Price_id`, `Showing_id`, `Spectator_id`, `Order_id`)
VALUES
    (1, 1, 1, 1, 1),
    (2, 2, 1, 3, 2),
    (3, 3, 3, 4, 3);
