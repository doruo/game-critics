<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251230163112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE critic (id INT AUTO_INCREMENT NOT NULL, general_message VARCHAR(180) NOT NULL, visual_message VARCHAR(180) NOT NULL, soundtrack_message VARCHAR(180) NOT NULL, scenario_message VARCHAR(180) NOT NULL, game VARCHAR(180) NOT NULL, author VARCHAR(180) NOT NULL, publicationDate DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, description VARCHAR(180) NOT NULL, release_date DATETIME NOT NULL, developper VARCHAR(180) NOT NULL, publisher VARCHAR(180) NOT NULL, avg_note DOUBLE PRECISION DEFAULT NULL, game_mode VARCHAR(180) NOT NULL, target_age INT NOT NULL, genre VARCHAR(180) NOT NULL, licence VARCHAR(180) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, plateform JSON NOT NULL, images JSON NOT NULL, pochette VARCHAR(180) NOT NULL, approved TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse_email VARCHAR(255) NOT NULL, hashed_email VARCHAR(255) NOT NULL, is_picture_masked TINYINT(1) NOT NULL, profile_picture_name VARCHAR(255) DEFAULT NULL, favorites JSON NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN (login), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (adresse_email), UNIQUE INDEX UNIQ_IDENTIFIER_HASHED_EMAIL (hashed_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE critic');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE user');
    }
}
