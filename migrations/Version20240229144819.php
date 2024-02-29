<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229144819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_habitat ADD habitat_id INT NOT NULL, ADD no VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commentaire_habitat ADD CONSTRAINT FK_48FF20BBAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('CREATE INDEX IDX_48FF20BBAFFE2D26 ON commentaire_habitat (habitat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_habitat DROP FOREIGN KEY FK_48FF20BBAFFE2D26');
        $this->addSql('DROP INDEX IDX_48FF20BBAFFE2D26 ON commentaire_habitat');
        $this->addSql('ALTER TABLE commentaire_habitat DROP habitat_id, DROP no');
    }
}
