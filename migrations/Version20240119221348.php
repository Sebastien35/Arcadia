<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119221348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, habitat_id INT DEFAULT NULL, zoo_id INT DEFAULT NULL, nb_clicks INT DEFAULT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, race JSON NOT NULL COMMENT \'(DC2Type:json)\', image LONGBLOB DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', etat JSON NOT NULL COMMENT \'(DC2Type:json)\', nourriture JSON NOT NULL COMMENT \'(DC2Type:json)\', grammage INT DEFAULT NULL, date_de_passage DATETIME DEFAULT NULL, detail_etat_animal DATETIME DEFAULT NULL, INDEX IDX_6AAB231FAFFE2D26 (habitat_id), INDEX IDX_6AAB231FFA5C94EF (zoo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, image LONGBLOB DEFAULT NULL, description VARCHAR(4096) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FFA5C94EF FOREIGN KEY (zoo_id) REFERENCES zoo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FAFFE2D26');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FFA5C94EF');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE habitat');
    }
}
