<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219092404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64936F1FB5F');
        $this->addSql('DROP INDEX IDX_8D93D64936F1FB5F ON user');
        $this->addSql('ALTER TABLE user DROP works_at_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD works_at_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64936F1FB5F FOREIGN KEY (works_at_id) REFERENCES zoo (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64936F1FB5F ON user (works_at_id)');
    }
}
