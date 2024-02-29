<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215170029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FFA5C94EF');
        $this->addSql('DROP INDEX IDX_6AAB231FFA5C94EF ON animal');
        $this->addSql('ALTER TABLE animal ADD image_name VARCHAR(255) DEFAULT NULL, DROP zoo_id, DROP nom, DROP image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD zoo_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, ADD image LONGBLOB DEFAULT NULL, DROP image_name');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FFA5C94EF FOREIGN KEY (zoo_id) REFERENCES zoo (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FFA5C94EF ON animal (zoo_id)');
    }
}
