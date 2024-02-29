<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227172112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_animal DROP INDEX UNIQ_A7767C498E962C16, ADD INDEX IDX_A7767C498E962C16 (animal_id)');
        $this->addSql('ALTER TABLE info_animal CHANGE animal_id animal_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_animal DROP INDEX IDX_A7767C498E962C16, ADD UNIQUE INDEX UNIQ_A7767C498E962C16 (animal_id)');
        $this->addSql('ALTER TABLE info_animal CHANGE animal_id animal_id INT DEFAULT NULL');
    }
}
