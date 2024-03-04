<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304162934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_habitat ADD auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire_habitat ADD CONSTRAINT FK_48FF20BB60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_48FF20BB60BB6FE6 ON commentaire_habitat (auteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_habitat DROP FOREIGN KEY FK_48FF20BB60BB6FE6');
        $this->addSql('DROP INDEX IDX_48FF20BB60BB6FE6 ON commentaire_habitat');
        $this->addSql('ALTER TABLE commentaire_habitat DROP auteur_id');
    }
}
