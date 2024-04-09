<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326143148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_images (id INT AUTO_INCREMENT NOT NULL, habitat_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, INDEX IDX_B1BD4C2BAFFE2D26 (habitat_id), INDEX IDX_B1BD4C2B8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE additional_images ADD CONSTRAINT FK_B1BD4C2BAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE additional_images ADD CONSTRAINT FK_B1BD4C2B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional_images DROP FOREIGN KEY FK_B1BD4C2BAFFE2D26');
        $this->addSql('ALTER TABLE additional_images DROP FOREIGN KEY FK_B1BD4C2B8E962C16');
        $this->addSql('DROP TABLE additional_images');
        
    }
}
