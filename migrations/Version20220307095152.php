<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307095152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE impressions (id INT AUTO_INCREMENT NOT NULL, film_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_A74C17A0567F5183 (film_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE impressions ADD CONSTRAINT FK_A74C17A0567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE impressions');
        $this->addSql('ALTER TABLE film CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE realisateur realisateur VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
