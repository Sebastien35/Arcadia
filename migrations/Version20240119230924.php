<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119230924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, id_etablissement_id INT NOT NULL, id_jour INT NOT NULL, h_ouverture TIME NOT NULL, h_fermeture TIME NOT NULL, UNIQUE INDEX UNIQ_BBC83DB61CE947F9 (id_etablissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horaire ADD CONSTRAINT FK_BBC83DB61CE947F9 FOREIGN KEY (id_etablissement_id) REFERENCES zoo (id)');
        $this->addSql('ALTER TABLE zoo ADD h_ouverture TIME NOT NULL, ADD h_fermeture TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire DROP FOREIGN KEY FK_BBC83DB61CE947F9');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('ALTER TABLE zoo DROP h_ouverture, DROP h_fermeture');
    }
}
