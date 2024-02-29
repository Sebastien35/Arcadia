<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220150517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE info_animal_nourriture (info_animal_id INT NOT NULL, nourriture_id INT NOT NULL, INDEX IDX_754D00DD23E6912B (info_animal_id), INDEX IDX_754D00DD98BD5834 (nourriture_id), PRIMARY KEY(info_animal_id, nourriture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_animal_nourriture ADD CONSTRAINT FK_754D00DD23E6912B FOREIGN KEY (info_animal_id) REFERENCES info_animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_animal_nourriture ADD CONSTRAINT FK_754D00DD98BD5834 FOREIGN KEY (nourriture_id) REFERENCES nourriture (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_animal_nourriture DROP FOREIGN KEY FK_754D00DD23E6912B');
        $this->addSql('ALTER TABLE info_animal_nourriture DROP FOREIGN KEY FK_754D00DD98BD5834');
        $this->addSql('DROP TABLE info_animal_nourriture');
    }
}
