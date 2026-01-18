-- Scripts for database

-- DROP
DROP TABLE IF EXISTS critic;
DROP TABLE IF EXISTS game;
DROP TABLE IF EXISTS refresh_tokens;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS user_game;

-- CREATE

CREATE TABLE critic (
    id INT AUTO_INCREMENT NOT NULL, 
    game_id INT NOT NULL, 
    author_id INT NOT NULL, 
    note INT NOT NULL,
    general_message VARCHAR(500) NOT NULL, 
    visual_message VARCHAR(500) NOT NULL, 
    soundtrack_message VARCHAR(500) NOT NULL, 
    scenario_message VARCHAR(500) NOT NULL, 
    publication_date DATETIME NOT NULL, 
    INDEX IDX_C9E2F7F1E48FD905 (game_id), 
    INDEX IDX_C9E2F7F1F675F31B (author_id), 
    UNIQUE INDEX UNIQ_COUPLE_GAME_USER (author_id, game_id), 
    PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
    
CREATE TABLE game (
    id INT AUTO_INCREMENT NOT NULL, 
    name VARCHAR(40) NOT NULL, 
    description VARCHAR(500) DEFAULT NULL, 
    release_date DATETIME NOT NULL, 
    developper VARCHAR(60) NOT NULL, 
    publisher VARCHAR(60) DEFAULT NULL, 
    game_mode VARCHAR(50) DEFAULT NULL, 
    target_age INT DEFAULT NULL, 
    genre VARCHAR(50) DEFAULT NULL, 
    licence VARCHAR(50) DEFAULT NULL, 
    price DOUBLE PRECISION NOT NULL, 
    plateform JSON DEFAULT NULL, 
    images JSON DEFAULT NULL, 
    pochette VARCHAR(255) DEFAULT NULL, 
    approved TINYINT(1) DEFAULT NULL, 
    UNIQUE INDEX UNIQ_IDENTIFIER_NAME (name), 
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

CREATE TABLE refresh_tokens (
    id INT AUTO_INCREMENT NOT NULL, 
    username VARCHAR(255) NOT NULL, 
    valid DATETIME NOT NULL, 
    hashed_refresh_token VARCHAR(255) NOT NULL, 
    UNIQUE INDEX UNIQ_9BACE7E185819E91 (hashed_refresh_token), 
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

CREATE TABLE user (
    id INT AUTO_INCREMENT NOT NULL, 
    login VARCHAR(20) NOT NULL, 
    roles JSON NOT NULL, 
    password VARCHAR(255) NOT NULL, 
    email VARCHAR(50) NOT NULL, 
    UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN (login), 
    UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), 
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

CREATE TABLE user_game (
    user_id INT NOT NULL, 
    game_id INT NOT NULL, 
    INDEX IDX_59AA7D45A76ED395 (user_id), 
    INDEX IDX_59AA7D45E48FD905 (game_id), 
    PRIMARY KEY(user_id, game_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

ALTER TABLE critic ADD CONSTRAINT FK_C9E2F7F1E48FD905 FOREIGN KEY (game_id) REFERENCES game (id);
ALTER TABLE critic ADD CONSTRAINT FK_C9E2F7F1F675F31B FOREIGN KEY (author_id) REFERENCES user (id);
ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE;
ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE;

-- INSERT

-- Users
INSERT INTO user (login, roles, password, email) VALUES 
('admin', '["ROLE_ADMIN"]', '$2y$13$F3j8XQd1dUz9xQZ8xYqZ9u', 'admin@example.com'),
('john_doe', '["ROLE_USER"]', '$2y$13$JkLmNopqRstUvWxYzAbcde', 'john@example.com'),
('jane_critic', '["ROLE_CRITIC"]', '$2y$13$fGhIjKlMnOpQrStUvWxYza', 'jane@example.com');

-- Games
INSERT INTO game (name, description, release_date, developper, publisher, game_mode, target_age, genre, licence, price, plateform, images, pochette, approved) VALUES 
('Space Odyssey', 'Epic space adventure', '2023-01-15 00:00:00', 'Cosmo Studios', 'Galaxy Games', 'Single-player', 16, 'Sci-Fi', 'Original', 59.99, '["PC", "PS5", "Xbox"]', '["screenshot1.jpg", "screenshot2.jpg"]', 'space_odyssey.jpg', 1),
('Medieval Quest', 'Fantasy RPG', '2023-03-22 00:00:00', 'Dragon Forge', 'Knight Publishing', 'Multiplayer', 12, 'RPG', 'Original', 49.99, '["PC", "Switch"]', '["screenshot3.jpg", "screenshot4.jpg"]', 'medieval_quest.jpg', 1),
('Cyber Race', 'Futuristic racing', '2023-05-10 00:00:00', 'Neon Labs', 'Speed Co', 'Multiplayer', 7, 'Racing', 'Original', 39.99, '["PS5", "Xbox"]', '["screenshot5.jpg", "screenshot6.jpg"]', 'cyber_race.jpg', 1);

-- Critics (Reviews)
INSERT INTO critic (game_id, author_id, note, general_message, visual_message, soundtrack_message, scenario_message, publication_date) VALUES 
(1, 3, 9, 'Incredible space adventure!', 'Stunning visuals', 'Immersive soundtrack', 'Engaging story', '2023-02-01 10:00:00'),
(2, 3, 8, 'Great fantasy experience', 'Beautiful art style', 'Epic music', 'Rich lore', '2023-04-15 14:30:00'),
(3, 3, 7, 'Fast-paced racing fun', 'Colorful graphics', 'Pumping beats', 'Light story', '2023-06-01 09:15:00');

-- Favorites
INSERT INTO user_game (user_id, game_id) VALUES 
(1, 1),
(1, 2),
(2, 1),
(2, 3);

-- Insert Refresh Token
INSERT INTO refresh_tokens (username, valid, hashed_refresh_token) VALUES 
('john_doe', '2024-01-01 00:00:00', '$2y$13$abcd1234efgh5678ijklmnop');