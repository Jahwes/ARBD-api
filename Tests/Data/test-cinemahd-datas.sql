--
-- Database: `test_cinemahd`
--


--
-- Dumping data for table `Movie`
--
INSERT INTO `Movie` (`id`, `title`, `duration`)
VALUES
    (1,  'Miss Peregrine et les enfants particuliers', 127),
    (2,  'Deepwater'                                 , 107),
    (3,  'Kubo et l\'armure magique'                 , 102),
    (4,  'Mechanic Résurrection'                     , 99 ),
    (5,  'Pacific Rim'                               , 130),
    (6,  'Fatal Punishment'                          , 120),
    (7,  'Sudden Blood'                              , 120),
    (8,  'Le Grand Vert'                             , 120),
    (9,  'Coup de foudre à Shanghai'                 , 120),
    (10, 'Star Fight'                                , 120),
    (11, 'Le Donjon de la mort 4'                    , 120),
    (12, 'Master of Assassination'                   , 120),
    (13, 'Microcosmos'                               , 120),
    (14, 'L\'horreur dans le miroir'                  , 120);

--
-- Dumping data for table `User`
--
INSERT INTO `User` (`id`, `lastname`, `firstname`, `date_of_birth`, `title`, `email`)
VALUES
    (1, 'HEART'   , 'Kingston' , '1994-02-15', 'Monsieur'    , 'heart_k@etna.io'                 ),
    (2, 'BELANGER', 'Angélique', '1970-04-11', 'Madame'      , 'AngeliqueBelanger@jourrapide.com'),
    (3, 'TALON'   , 'Faure'    , '1986-04-06', 'Monsieur'    , 'TalonFaure@redbearstavern.com'   ),
    (4, 'NOUEL'   , 'Soucy'    , '1941-06-17', 'Madame'      , 'NouelSoucy@rhyta.com'            ),
    (5, 'MELVILLE', 'Lamy'     , '1957-12-04', 'Mademoiselle', 'MelvilleLamy@dayrep.com'         );

--
-- Dumping data for table `Type`
--
INSERT INTO `Type` (`id`, `name`)
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
INSERT INTO `Spectator` (`id`, `lastname`, `firstname`, `age`, `title`)
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
INSERT INTO `Room` (`id`, `nb_places`)
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
INSERT INTO `Price` (`id`, `type_name`, `value`)
VALUES
    (1, 'Plein tarif'   , 9.4),
    (2, 'Tarif reduit'  , 7.4),
    (3, 'Senior'        , 6.8),
    (4, 'Tarif etudiant', 6.8);

--
-- Dumping data for table `People`
--
INSERT INTO `People` (`id`, `firstname`, `lastname`, `date_of_birth`, `nationality`)
VALUES
    (1 , 'Eva'      , 'GREEN'      , '1980-07-06', 'française'    ),
    (2 , 'Asa'      , 'BUTTERFIELD', '1997-04-01', 'britannique'  ),
    (3 , 'Samuel'   , 'JACKSON'    , '1948-12-21', 'américaine'   ),
    (4 , 'Tim'      , 'BURTON'     , '1958-08-25', 'américaine'   ),
    (5 , 'Peter'    , 'BERG'       , '1964-03-11', 'américaine'   ),
    (6 , 'Marc'     , 'WAHLBERG'   , '1971-06-05', 'américaine'   ),
    (7 , 'Kate'     , 'HUDSON'     , '1979-04-19', 'américaine'   ),
    (8 , 'Dylan'    , 'O\'BRIAN'   , '1991-08-26', 'américaine'   ),
    (9 , 'Travis'   , 'KNIGHT'     , '1978-11-07', 'américaine'   ),
    (10, 'Charlize' , 'THERON'     , '1975-08-07', 'sud-africaine'),
    (11, 'Art'      , 'PARKINSON'  , '2001-10-19', 'irlandaise'   ),
    (12, 'Denis'    , 'GANSEL'     , '1973-10-04', 'allemande'    ),
    (13, 'Jason'    , 'STATHAM'    , '1967-07-26', 'britannique'  ),
    (14, 'Jessica'  , 'ALBA'       , '1981-04-28', 'américaine'   ),
    (15, 'Tommy'    , 'LEE JONES'  , '1946-09-15', 'américaine'   ),
    (16, 'Guillermo', 'DEL TORO'   , '1964-10-09', 'mexicaine'    ),
    (17, 'Charlie'  , 'HUNNAM'     , '1980-04-10', 'britannique'  ),
    (18, 'Rinko'    , 'KIKUCHI'    , '1981-01-06', 'japonaise'    );

--
-- Dumping data for table `Movie_has_Type`
--
INSERT INTO `Movie_has_Type` (`Movie_id`, `Type_id`)
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
INSERT INTO `Movie_has_People` (`Movie_id`, `People_id`, `role`)
VALUES
    (1, 1 , 'actrice'    ),
    (1, 2 , 'acteur'     ),
    (1, 3 , 'acteur'     ),
    (1, 4 , 'réalisateur'),
    (2, 5 , 'réalisateur'),
    (2, 6 , 'acteur'     ),
    (2, 7 , 'actrice'    ),
    (2, 8 , 'acteur'     ),
    (3, 9 , 'producteur' ),
    (3, 10, 'actrice'    ),
    (3, 11, 'acteur'     ),
    (4, 12, 'réalisateur'),
    (4, 13, 'acteur'     ),
    (4, 14, 'actrice'    ),
    (4, 15, 'acteur'     ),
    (5, 16, 'réalisateur'),
    (5, 17, 'acteur'     ),
    (5, 18, 'actrice'    );

--
-- Dumping data for table `Order`
--
INSERT INTO `Order` (`id`, `created_at`, `User_id`)
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
INSERT INTO `Showing` (`id`, `date`, `3D`, `Room_id`, `Movie_id`)
VALUES
    (1, '2016-11-18 10:00:00', 1, 1, 1),
    (2, '2016-11-16 09:35:00', 0, 2, 2),
    (3, '2016-11-24 14:50:00', 1, 3, 2),
    (4, '2016-11-28 15:45:00', 0, 4, 3),
    (5, '2016-12-01 13:35:00', 1, 5, 4);

--
-- Dumping data for table `Ticket`
--
INSERT INTO `Ticket` (`id`, `Price_id`, `Showing_id`, `Spectator_id`, `Order_id`)
VALUES
    (1, 1, 1, 1, 1),
    (2, 2, 1, 3, 2),
    (3, 3, 3, 4, 3);
