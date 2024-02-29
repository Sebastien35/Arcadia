<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240216103704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP nb_clicks, DROP etat, DROP nourriture, DROP grammage, DROP date_de_passage, DROP detail_etat_animal');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD nb_clicks INT DEFAULT NULL, ADD etat JSON NOT NULL COMMENT \'(DC2Type:json)\', ADD nourriture JSON NOT NULL COMMENT \'(DC2Type:json)\', ADD grammage INT DEFAULT NULL, ADD date_de_passage DATETIME DEFAULT NULL, ADD detail_etat_animal DATETIME DEFAULT NULL');
    }
}
