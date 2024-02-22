<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219180513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nourriture (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, date DATETIME NOT NULL, quantity INT NOT NULL, INDEX IDX_7447E6138E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nourriture ADD CONSTRAINT FK_7447E6138E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('DROP TABLE nourriture');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nourriture DROP FOREIGN KEY FK_7447E6138E962C16');
        $this->addSql('DROP TABLE nourriture');
    }
}
