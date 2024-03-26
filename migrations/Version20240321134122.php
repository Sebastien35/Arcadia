<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321134122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE race race VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE animal RENAME INDEX fk_habitat_for_animal TO IDX_6AAB231FAFFE2D26');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_zoo_id_for_avis');
        $this->addSql('DROP INDEX FK_zoo_id_for_avis ON avis');
        $this->addSql('ALTER TABLE avis DROP zoo_id, CHANGE pseudo pseudo VARCHAR(255) NOT NULL, CHANGE avis_content avis_content VARCHAR(512) NOT NULL, CHANGE note note INT NOT NULL, CHANGE validation validation TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE commentaire_habitat DROP FOREIGN KEY FK_auteur_id_for_commentaire');
        $this->addSql('ALTER TABLE commentaire_habitat CHANGE habitat_id habitat_id INT NOT NULL, CHANGE auteur_id auteur_id INT NOT NULL, CHANGE commentaire commentaire LONGTEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE commentaire_habitat ADD CONSTRAINT FK_48FF20BB60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaire_habitat RENAME INDEX fk_habitat_id_for_commentaire TO IDX_48FF20BBAFFE2D26');
        $this->addSql('ALTER TABLE commentaire_habitat RENAME INDEX fk_auteur_id_for_commentaire TO IDX_48FF20BB60BB6FE6');
        $this->addSql('ALTER TABLE demande_contact DROP FOREIGN KEY FK_zoo_id_for_demande');
        $this->addSql('DROP INDEX FK_zoo_id_for_demande ON demande_contact');
        $this->addSql('ALTER TABLE demande_contact DROP zoo_id, CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE message message LONGTEXT NOT NULL, CHANGE mail mail VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE answered_at answered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE answered answered TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE habitat CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(4096) NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE horaire DROP zoo_id, CHANGE jour jour VARCHAR(8) NOT NULL, CHANGE h_ouverture h_ouverture TIME NOT NULL, CHANGE h_fermeture h_fermeture TIME NOT NULL, CHANGE ouvert ouvert TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE info_animal DROP FOREIGN KEY FK_auteur_for_infoAnimal');
        $this->addSql('ALTER TABLE info_animal CHANGE animal_id animal_id INT NOT NULL, CHANGE auteur_id auteur_id INT NOT NULL, CHANGE etat etat VARCHAR(255) NOT NULL, CHANGE details details VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE info_animal ADD CONSTRAINT FK_A7767C4960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX fk_nourriture_for_infoanimal TO IDX_A7767C4998BD5834');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX fk_animal_for_infoanimal TO IDX_A7767C498E962C16');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX fk_auteur_for_infoanimal TO IDX_A7767C4960BB6FE6');
        $this->addSql('ALTER TABLE nourriture CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(512) NOT NULL');
        $this->addSql('ALTER TABLE repas CHANGE animal_id animal_id INT NOT NULL, CHANGE datetime datetime DATETIME NOT NULL, CHANGE quantite quantite INT NOT NULL');
        $this->addSql('ALTER TABLE repas RENAME INDEX fk_nourriture_for_repas TO IDX_A8D351B398BD5834');
        $this->addSql('ALTER TABLE repas RENAME INDEX fk_animal_for_repas TO IDX_A8D351B38E962C16');
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
        $this->addSql('ALTER TABLE animal CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE race race VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE animal RENAME INDEX idx_6aab231faffe2d26 TO FK_habitat_for_animal');
        $this->addSql('ALTER TABLE avis ADD zoo_id INT DEFAULT NULL, CHANGE pseudo pseudo VARCHAR(255) DEFAULT NULL, CHANGE avis_content avis_content VARCHAR(512) DEFAULT NULL, CHANGE note note INT DEFAULT NULL, CHANGE validation validation TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_zoo_id_for_avis FOREIGN KEY (zoo_id) REFERENCES zoo (id)');
        $this->addSql('CREATE INDEX FK_zoo_id_for_avis ON avis (zoo_id)');
        $this->addSql('ALTER TABLE commentaire_habitat DROP FOREIGN KEY FK_48FF20BB60BB6FE6');
        $this->addSql('ALTER TABLE commentaire_habitat CHANGE habitat_id habitat_id INT DEFAULT NULL, CHANGE auteur_id auteur_id INT DEFAULT NULL, CHANGE commentaire commentaire TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire_habitat ADD CONSTRAINT FK_auteur_id_for_commentaire FOREIGN KEY (auteur_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE commentaire_habitat RENAME INDEX idx_48ff20bbaffe2d26 TO FK_habitat_id_for_commentaire');
        $this->addSql('ALTER TABLE commentaire_habitat RENAME INDEX idx_48ff20bb60bb6fe6 TO FK_auteur_id_for_commentaire');
        $this->addSql('ALTER TABLE demande_contact ADD zoo_id INT DEFAULT NULL, CHANGE titre titre VARCHAR(255) DEFAULT NULL, CHANGE message message TEXT DEFAULT NULL, CHANGE mail mail VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE answered_at answered_at DATETIME DEFAULT NULL, CHANGE answered answered TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE demande_contact ADD CONSTRAINT FK_zoo_id_for_demande FOREIGN KEY (zoo_id) REFERENCES zoo (id)');
        $this->addSql('CREATE INDEX FK_zoo_id_for_demande ON demande_contact (zoo_id)');
        $this->addSql('ALTER TABLE habitat CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(512) DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE horaire ADD zoo_id INT DEFAULT NULL, CHANGE jour jour VARCHAR(8) DEFAULT NULL, CHANGE h_ouverture h_ouverture TIME DEFAULT NULL, CHANGE h_fermeture h_fermeture TIME DEFAULT NULL, CHANGE ouvert ouvert TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE info_animal DROP FOREIGN KEY FK_A7767C4960BB6FE6');
        $this->addSql('ALTER TABLE info_animal CHANGE animal_id animal_id INT DEFAULT NULL, CHANGE auteur_id auteur_id INT DEFAULT NULL, CHANGE etat etat VARCHAR(255) DEFAULT NULL, CHANGE details details TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE info_animal ADD CONSTRAINT FK_auteur_for_infoAnimal FOREIGN KEY (auteur_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX idx_a7767c4998bd5834 TO FK_nourriture_for_infoAnimal');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX idx_a7767c4960bb6fe6 TO FK_auteur_for_infoAnimal');
        $this->addSql('ALTER TABLE info_animal RENAME INDEX idx_a7767c498e962c16 TO FK_animal_for_infoAnimal');
        $this->addSql('ALTER TABLE nourriture CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(512) DEFAULT NULL');
        $this->addSql('ALTER TABLE repas CHANGE animal_id animal_id INT DEFAULT NULL, CHANGE datetime datetime DATETIME DEFAULT NULL, CHANGE quantite quantite INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repas RENAME INDEX idx_a8d351b38e962c16 TO FK_animal_for_repas');
        $this->addSql('ALTER TABLE repas RENAME INDEX idx_a8d351b398bd5834 TO FK_nourriture_for_repas');
        $this->addSql('ALTER TABLE service CHANGE nom nom VARCHAR(128) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service RENAME INDEX idx_e19d9ad2fa5c94ef TO FK_zoo_id_for_service');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74 ON users');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) DEFAULT NULL, CHANGE roles roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE zoo_id zoo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_zoo_id_for_user FOREIGN KEY (zoo_id) REFERENCES zoo (id)');
        $this->addSql('CREATE INDEX FK_zoo_id_for_user ON users (zoo_id)');
        $this->addSql('ALTER TABLE zoo CHANGE nom nom VARCHAR(255) DEFAULT NULL');
    }
}
