<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260117175530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE critic ADD game_id INT NOT NULL, DROP game');
        $this->addSql('ALTER TABLE critic ADD CONSTRAINT FK_C9E2F7F1E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_C9E2F7F1E48FD905 ON critic (game_id)');
        $this->addSql('ALTER TABLE game DROP avg_note, CHANGE release_date release_date VARCHAR(255) NOT NULL, CHANGE game_mode game_mode VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME ON game (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE critic DROP FOREIGN KEY FK_C9E2F7F1E48FD905');
        $this->addSql('DROP INDEX IDX_C9E2F7F1E48FD905 ON critic');
        $this->addSql('ALTER TABLE critic ADD game VARCHAR(255) NOT NULL, DROP game_id');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME ON game');
        $this->addSql('ALTER TABLE game ADD avg_note DOUBLE PRECISION DEFAULT NULL, CHANGE release_date release_date DATETIME NOT NULL, CHANGE game_mode game_mode VARCHAR(180) NOT NULL');
    }
}
