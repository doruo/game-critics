<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260102010303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE critic (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, general_message VARCHAR(180) NOT NULL, visual_message VARCHAR(180) NOT NULL, soundtrack_message VARCHAR(180) NOT NULL, scenario_message VARCHAR(180) NOT NULL, game VARCHAR(180) NOT NULL, date DATETIME NOT NULL, INDEX IDX_C9E2F7F1F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, description VARCHAR(180) NOT NULL, release_date DATETIME NOT NULL, developper VARCHAR(180) NOT NULL, publisher VARCHAR(180) NOT NULL, avg_note DOUBLE PRECISION DEFAULT NULL, game_mode VARCHAR(180) NOT NULL, target_age INT NOT NULL, genre VARCHAR(180) NOT NULL, licence VARCHAR(180) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, plateform JSON NOT NULL, images JSON NOT NULL, pochette VARCHAR(180) NOT NULL, approved TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, adresse_email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN (login), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (adresse_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_game (user_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_59AA7D45A76ED395 (user_id), INDEX IDX_59AA7D45E48FD905 (game_id), PRIMARY KEY(user_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_critic (user_id INT NOT NULL, critic_id INT NOT NULL, INDEX IDX_ACB0ECCCA76ED395 (user_id), INDEX IDX_ACB0ECCCC7BE2830 (critic_id), PRIMARY KEY(user_id, critic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE critic ADD CONSTRAINT FK_C9E2F7F1F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_critic ADD CONSTRAINT FK_ACB0ECCCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_critic ADD CONSTRAINT FK_ACB0ECCCC7BE2830 FOREIGN KEY (critic_id) REFERENCES critic (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE critic DROP FOREIGN KEY FK_C9E2F7F1F675F31B');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45A76ED395');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45E48FD905');
        $this->addSql('ALTER TABLE user_critic DROP FOREIGN KEY FK_ACB0ECCCA76ED395');
        $this->addSql('ALTER TABLE user_critic DROP FOREIGN KEY FK_ACB0ECCCC7BE2830');
        $this->addSql('DROP TABLE critic');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_game');
        $this->addSql('DROP TABLE user_critic');
    }
}
