<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260118212231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE critic (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, author_id INT NOT NULL, note INT NOT NULL, general_message VARCHAR(500) NOT NULL, visual_message VARCHAR(500) NOT NULL, soundtrack_message VARCHAR(500) NOT NULL, scenario_message VARCHAR(500) NOT NULL, publication_date DATETIME NOT NULL, INDEX IDX_C9E2F7F1E48FD905 (game_id), INDEX IDX_C9E2F7F1F675F31B (author_id), UNIQUE INDEX UNIQ_COUPLE_GAME_USER (author_id, game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, description VARCHAR(500) DEFAULT NULL, release_date DATETIME NOT NULL, developper VARCHAR(60) NOT NULL, publisher VARCHAR(60) DEFAULT NULL, game_mode VARCHAR(50) DEFAULT NULL, target_age INT DEFAULT NULL, genre VARCHAR(50) DEFAULT NULL, licence VARCHAR(50) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, plateform JSON DEFAULT NULL, images JSON DEFAULT NULL, pochette VARCHAR(255) DEFAULT NULL, approved TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, hashed_refresh_token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9BACE7E185819E91 (hashed_refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(20) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN (login), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_game (user_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_59AA7D45A76ED395 (user_id), INDEX IDX_59AA7D45E48FD905 (game_id), PRIMARY KEY(user_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE critic ADD CONSTRAINT FK_C9E2F7F1E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE critic ADD CONSTRAINT FK_C9E2F7F1F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE critic DROP FOREIGN KEY FK_C9E2F7F1E48FD905');
        $this->addSql('ALTER TABLE critic DROP FOREIGN KEY FK_C9E2F7F1F675F31B');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45A76ED395');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45E48FD905');
        $this->addSql('DROP TABLE critic');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_game');
    }
}
