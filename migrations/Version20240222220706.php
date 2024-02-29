<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222220706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_animal ADD nourriture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE info_animal ADD CONSTRAINT FK_A7767C4998BD5834 FOREIGN KEY (nourriture_id) REFERENCES nourriture (id)');
        $this->addSql('CREATE INDEX IDX_A7767C4998BD5834 ON info_animal (nourriture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_animal DROP FOREIGN KEY FK_A7767C4998BD5834');
        $this->addSql('DROP INDEX IDX_A7767C4998BD5834 ON info_animal');
        $this->addSql('ALTER TABLE info_animal DROP nourriture_id');
    }
}
