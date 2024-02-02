<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122115918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire DROP FOREIGN KEY FK_BBC83DB61CE947F9');
        $this->addSql('DROP INDEX UNIQ_BBC83DB61CE947F9 ON horaire');
        $this->addSql('ALTER TABLE horaire DROP id_etablissement_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire ADD id_etablissement_id INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE horaire ADD CONSTRAINT FK_BBC83DB61CE947F9 FOREIGN KEY (id_etablissement_id) REFERENCES zoo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BBC83DB61CE947F9 ON horaire (id_etablissement_id)');
    }
}
