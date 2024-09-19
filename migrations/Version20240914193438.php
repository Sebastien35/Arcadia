<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240914193438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional_images CHANGE image_name image_name VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE additional_images RENAME INDEX fk_habitat_id_for_additional_images TO IDX_B1BD4C2BAFFE2D26');
        $this->addSql('ALTER TABLE additional_images RENAME INDEX fk_animal_id_for_additional_images TO IDX_B1BD4C2B8E962C16');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_habitat_for_animal');
        $this->addSql('ALTER TABLE animal CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE race race VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE animal RENAME INDEX fk_habitat_for_animal TO IDX_6AAB231FAFFE2D26');
        $this->addSql('ALTER TABLE avis RENAME INDEX fk_zoo_id_for_avis TO IDX_8F91ABF0FA5C94EF');
        $this->addSql('ALTER TABLE commentaire_habitat DROP FOREIGN KEY FK_auteur_id_for_commentaire');
        $this->addSql('ALTER TABLE commentaire_habitat CHANGE habitat_id habitat_id INT NOT NULL, CHANGE auteur_id auteur_id INT NOT NULL, CHANGE commentaire commentaire LONGTEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE commentaire_habitat ADD CONSTRAINT FK_48FF20BB60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaire_habitat RENAME INDEX fk_habitat_id_for_commentaire TO IDX_48FF20BBAFFE2D26');
        $this->addSql('ALTER TABLE commentaire_habitat RENAME INDEX fk_auteur_id_for_commentaire TO IDX_48FF20BB60BB6FE6');
        $this->addSql('ALTER TABLE demande_contact CHANGE zoo_id zoo_id INT NOT NULL, CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE message message LONGTEXT NOT NULL, CHANGE mail mail VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE answered_at answered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE answered answered TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE demande_contact RENAME INDEX fk_zoo_id_for_demande TO IDX_7C955D97FA5C94EF');
        $this->addSql('ALTER TABLE habitat CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE horaire DROP zoo_id, CHANGE jour jour VARCHAR(8) NOT NULL, CHANGE h_ouverture h_ouverture TIME NOT NULL, CHANGE h_fermeture h_fermeture TIME NOT NULL, CHANGE ouvert ouvert TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE info_animal DROP FOREIGN KEY FK_auteur_for_infoAnimal');
        $this->addSql('ALTER TABLE info_animal CHANGE animal_id animal_id INT NOT NULL, CHANGE auteur_id auteur_id INT NOT NULL, CHANGE etat etat VARCHAR(255) NOT NULL, CHANGE details details VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE info_animal ADD CONSTRAINT FK_A7767C4960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX fk_nourriture_for_infoanimal TO IDX_A7767C4998BD5834');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX fk_animal_for_infoanimal TO IDX_A7767C498E962C16');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX fk_auteur_for_infoanimal TO IDX_A7767C4960BB6FE6');
        $this->addSql('ALTER TABLE nourriture CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(512) NOT NULL');
        $this->addSql('ALTER TABLE repas DROP FOREIGN KEY FK_auteur_for_repas');
        $this->addSql('DROP INDEX FK_auteur_for_repas ON repas');
        $this->addSql('ALTER TABLE repas DROP auteur, CHANGE animal_id animal_id INT NOT NULL, CHANGE datetime datetime DATETIME NOT NULL, CHANGE quantite quantite INT NOT NULL');
        $this->addSql('ALTER TABLE repas RENAME INDEX fk_nourriture_for_repas TO IDX_A8D351B398BD5834');
        $this->addSql('ALTER TABLE repas RENAME INDEX fk_animal_for_repas TO IDX_A8D351B38E962C16');
        $this->addSql('ALTER TABLE reset_password_request CHANGE requested_at requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE expires_at expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reset_password_request RENAME INDEX fk_user_for_password_reset TO IDX_7CE748AA76ED395');
        $this->addSql('ALTER TABLE service CHANGE nom nom VARCHAR(128) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE service RENAME INDEX fk_zoo_id_for_service TO IDX_E19D9AD2FA5C94EF');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_zoo_id_for_user');
        $this->addSql('DROP INDEX FK_zoo_id_for_user ON users');
        $this->addSql('ALTER TABLE users CHANGE zoo_id zoo_id INT NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE zoo CHANGE nom nom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional_images CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE image_name image_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE additional_images RENAME INDEX idx_b1bd4c2b8e962c16 TO FK_animal_id_for_additional_images');
        $this->addSql('ALTER TABLE additional_images RENAME INDEX idx_b1bd4c2baffe2d26 TO FK_habitat_id_for_additional_images');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FAFFE2D26');
        $this->addSql('ALTER TABLE animal CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE race race VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_habitat_for_animal FOREIGN KEY (habitat_id) REFERENCES habitat (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE animal RENAME INDEX idx_6aab231faffe2d26 TO FK_habitat_for_animal');
        $this->addSql('ALTER TABLE avis RENAME INDEX idx_8f91abf0fa5c94ef TO FK_zoo_id_for_avis');
        $this->addSql('ALTER TABLE commentaire_habitat DROP FOREIGN KEY FK_48FF20BB60BB6FE6');
        $this->addSql('ALTER TABLE commentaire_habitat CHANGE habitat_id habitat_id INT DEFAULT NULL, CHANGE auteur_id auteur_id INT DEFAULT NULL, CHANGE commentaire commentaire TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire_habitat ADD CONSTRAINT FK_auteur_id_for_commentaire FOREIGN KEY (auteur_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE commentaire_habitat RENAME INDEX idx_48ff20bb60bb6fe6 TO FK_auteur_id_for_commentaire');
        $this->addSql('ALTER TABLE commentaire_habitat RENAME INDEX idx_48ff20bbaffe2d26 TO FK_habitat_id_for_commentaire');
        $this->addSql('ALTER TABLE demande_contact CHANGE zoo_id zoo_id INT DEFAULT NULL, CHANGE titre titre VARCHAR(255) DEFAULT NULL, CHANGE message message TEXT DEFAULT NULL, CHANGE mail mail VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE answered_at answered_at DATETIME DEFAULT NULL, CHANGE answered answered TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE demande_contact RENAME INDEX idx_7c955d97fa5c94ef TO FK_zoo_id_for_demande');
        $this->addSql('ALTER TABLE habitat CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(512) DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE horaire ADD zoo_id INT DEFAULT NULL, CHANGE jour jour VARCHAR(8) DEFAULT NULL, CHANGE h_ouverture h_ouverture TIME DEFAULT NULL, CHANGE h_fermeture h_fermeture TIME DEFAULT NULL, CHANGE ouvert ouvert TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE info_animal DROP FOREIGN KEY FK_A7767C4960BB6FE6');
        $this->addSql('ALTER TABLE info_animal CHANGE animal_id animal_id INT DEFAULT NULL, CHANGE auteur_id auteur_id INT DEFAULT NULL, CHANGE etat etat VARCHAR(255) DEFAULT NULL, CHANGE details details TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE info_animal ADD CONSTRAINT FK_auteur_for_infoAnimal FOREIGN KEY (auteur_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX idx_a7767c4998bd5834 TO FK_nourriture_for_infoAnimal');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX idx_a7767c4960bb6fe6 TO FK_auteur_for_infoAnimal');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX idx_a7767c498e962c16 TO FK_animal_for_infoAnimal');
        $this->addSql('ALTER TABLE nourriture CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(512) DEFAULT NULL');
        $this->addSql('ALTER TABLE repas ADD auteur INT DEFAULT NULL, CHANGE animal_id animal_id INT DEFAULT NULL, CHANGE datetime datetime DATETIME DEFAULT NULL, CHANGE quantite quantite INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repas ADD CONSTRAINT FK_auteur_for_repas FOREIGN KEY (auteur) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX FK_auteur_for_repas ON repas (auteur)');
        $this->addSql('ALTER TABLE repas RENAME INDEX idx_a8d351b38e962c16 TO FK_animal_for_repas');
        $this->addSql('ALTER TABLE repas RENAME INDEX idx_a8d351b398bd5834 TO FK_nourriture_for_repas');
        $this->addSql('ALTER TABLE reset_password_request CHANGE requested_at requested_at DATETIME NOT NULL, CHANGE expires_at expires_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request RENAME INDEX idx_7ce748aa76ed395 TO FK_user_for_password_reset');
        $this->addSql('ALTER TABLE service CHANGE nom nom VARCHAR(128) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service RENAME INDEX idx_e19d9ad2fa5c94ef TO FK_zoo_id_for_service');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74 ON users');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) DEFAULT NULL, CHANGE roles roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE zoo_id zoo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_zoo_id_for_user FOREIGN KEY (zoo_id) REFERENCES zoo (id)');
        $this->addSql('CREATE INDEX FK_zoo_id_for_user ON users (zoo_id)');
        $this->addSql('ALTER TABLE zoo CHANGE nom nom VARCHAR(255) DEFAULT NULL');
    }
}
