<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222224846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repas_nourriture DROP FOREIGN KEY FK_D391625A98BD5834');
        $this->addSql('ALTER TABLE repas_nourriture DROP FOREIGN KEY FK_D391625A1D236AAA');
        $this->addSql('DROP TABLE repas_nourriture');
        $this->addSql('ALTER TABLE repas ADD nourriture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repas ADD CONSTRAINT FK_A8D351B398BD5834 FOREIGN KEY (nourriture_id) REFERENCES nourriture (id)');
        $this->addSql('CREATE INDEX IDX_A8D351B398BD5834 ON repas (nourriture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE repas_nourriture (repas_id INT NOT NULL, nourriture_id INT NOT NULL, INDEX IDX_D391625A1D236AAA (repas_id), INDEX IDX_D391625A98BD5834 (nourriture_id), PRIMARY KEY(repas_id, nourriture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE repas_nourriture ADD CONSTRAINT FK_D391625A98BD5834 FOREIGN KEY (nourriture_id) REFERENCES nourriture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE repas_nourriture ADD CONSTRAINT FK_D391625A1D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE repas DROP FOREIGN KEY FK_A8D351B398BD5834');
        $this->addSql('DROP INDEX IDX_A8D351B398BD5834 ON repas');
        $this->addSql('ALTER TABLE repas DROP nourriture_id');
    }
}
