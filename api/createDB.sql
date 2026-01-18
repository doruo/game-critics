-- Utilisateurs
-- mdp en clair pour les imports suivants : Motdepasse1
INSERT INTO user (login, roles, password, email) VALUES
                                                     ('admin', '["ROLE_ADMIN"]', '$2y$13$MNBrg8Pyhcv81/on.hzPwOnPZPrpRYnBUUoNE30doIPGM2F8qNluG', 'admin@example.com'),
                                                     ('user', '[]', '$2y$13$MNBrg8Pyhcv81/on.hzPwOnPZPrpRYnBUUoNE30doIPGM2F8qNluG', 'user@example.com'),
                                                     ('userPDP', '[]', '$2y$13$MNBrg8Pyhcv81/on.hzPwOnPZPrpRYnBUUoNE30doIPGM2F8qNluG', 'uneEmailAvecUnePDPSurMyAvatar@email.com');

-- Jeux
INSERT INTO game (name, description, release_date, developper, publisher, game_mode, target_age, genre, licence, price, plateform, images, pochette, approved) VALUES
                                                                                                                                                                   ('Odyssée Spatiale', 'Épopée spatiale', '2023-01-15 00:00:00', 'Cosmo Studios', 'Galaxy Games', 'Solo', 16, 'Science-Fiction', 'Original', 59.99, '["PC", "PS5", "Xbox"]', null, null, 1),
                                                                                                                                                                   ('Quête Médiévale', 'RPG fantastique', '2023-03-22 00:00:00', 'Dragon Forge', 'Knight Publishing', 'Multijoueur', 12, 'RPG', 'Original', 49.99, '["PC", "Switch"]', null, null, 1),
                                                                                                                                                                   ('Course Cyber', 'Course futuriste', '2023-05-10 00:00:00', 'Neon Labs', 'Speed Co', 'Multijoueur', 7, 'Course', 'Original', 39.99, '["PS5", "Xbox"]', null, null, 0);

-- Critics
INSERT INTO critic (game_id, author_id, note, general_message, visual_message, soundtrack_message, scenario_message, publication_date) VALUES
                                                                                                                                           (1, 3, 18, 'Incroyable aventure spatiale !', 'Visuels époustouflants', 'Bande-son immersive', 'Histoire captivante', '2023-02-01 10:00:00'),
                                                                                                                                           (2, 3, 16, 'Excellente expérience fantastique', 'Style artistique magnifique', 'Musique épique', 'Lore riche', '2023-04-15 14:30:00'),
                                                                                                                                           (3, 3, 14, 'Course rapide et amusante', 'Graphismes colorés', 'Rythme musical entraînant', 'Scénario léger', '2023-06-01 09:15:00'),
                                                                                                                                           (1, 2, 20, 'Une odyssée à couper le souffle !', 'Images incroyables', 'Soundtrack de folie', 'Histoire passionnante', '2023-02-05 12:00:00'),
                                                                                                                                           (2, 1, 18, 'Plongée totale dans le monde médiéval', 'Graphismes détaillés', 'Musique immersive', 'Quêtes bien pensées', '2023-03-30 16:45:00'),
                                                                                                                                           (3, 2, 16, 'Course intense mais fun', 'Ambiance visuelle futuriste', 'Bande-son dynamique', 'Scénario secondaire sympa', '2023-06-10 11:20:00'),
                                                                                                                                           (1, 1, 16, 'Très bon jeu spatial', 'Univers graphique réussi', 'Bande-son correcte', 'Histoire intéressante', '2023-02-12 08:30:00'),
                                                                                                                                           (3, 1, 12, 'Bon divertissement rapide', 'Graphismes moyens', 'Musique sympa', 'Scénario léger', '2023-06-15 10:05:00');

-- Favoris
INSERT INTO user_game (user_id, game_id) VALUES
                                             (1, 1),
                                             (1, 2),
                                             (2, 1),
                                             (2, 3);
