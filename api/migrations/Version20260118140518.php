<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260118140518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game CHANGE description description VARCHAR(500) DEFAULT NULL, CHANGE publisher publisher VARCHAR(60) DEFAULT NULL, CHANGE game_mode game_mode VARCHAR(50) DEFAULT NULL, CHANGE target_age target_age INT DEFAULT NULL, CHANGE genre genre VARCHAR(50) DEFAULT NULL, CHANGE plateform plateform JSON DEFAULT NULL, CHANGE images images JSON DEFAULT NULL, CHANGE pochette pochette VARCHAR(255) DEFAULT NULL, CHANGE approved approved TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game CHANGE description description VARCHAR(500) NOT NULL, CHANGE publisher publisher VARCHAR(60) NOT NULL, CHANGE game_mode game_mode VARCHAR(50) NOT NULL, CHANGE target_age target_age INT NOT NULL, CHANGE genre genre VARCHAR(50) NOT NULL, CHANGE plateform plateform JSON NOT NULL, CHANGE images images JSON NOT NULL, CHANGE pochette pochette VARCHAR(255) NOT NULL, CHANGE approved approved TINYINT(1) NOT NULL');
    }
}
