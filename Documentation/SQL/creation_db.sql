CREATE DATABASE IF NOT EXISTS arcadia_db CHARACTER SET utf8 COLLATE utf8_general_ci;

USE arcadia_db;

CREATE TABLE Zoo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255)
);

CREATE TABLE Animal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(255),
    race VARCHAR(255),
    habitat_id INT,
    created_at DATETIME,
    updated_at DATETIME NULL,
    image_name VARCHAR(255) NULL
);

CREATE TABLE Avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(255),
    avis_content VARCHAR(512),
    note INT,
    validation TINYINT(1),
    created_at DATETIME,
    zoo_id INT
);

CREATE TABLE commentaire_habitat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commentaire TEXT,
    habitat_id INT,
    created_at DATETIME,
    updated_at DATETIME NULL,
    auteur_id INT
);

CREATE TABLE demande_contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    message TEXT,
    mail VARCHAR(255),
    created_at DATETIME,
    answered_at DATETIME NULL,
    answered TINYINT(1) DEFAULT 0,
    zoo_id INT 
);

CREATE TABLE Habitat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    image_name VARCHAR(255) NULL,
    description VARCHAR(512),
    updated_at DATETIME NULL
);

CREATE TABLE Horaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jour VARCHAR(8),
    h_ouverture TIME,
    h_fermeture TIME,
    ouvert TINYINT(1) DEFAULT 0,
    zoo_id INT
);

CREATE TABLE info_animal(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nourriture_id INT,
    animal_id INT,
    auteur_id INT,
    etat VARCHAR(255),
    details TEXT,
    grammage INT,
    created_at DATETIME
);

CREATE TABLE Nourriture (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    description VARCHAR(512)
);

CREATE TABLE repas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nourriture_id INT,
    animal_id INT,
    datetime DATETIME,
    quantite INT,
    auteur INT
);

CREATE TABLE Service (
    id INT AUTO_INCREMENT PRIMARY KEY,
    zoo_id INT,
    nom VARCHAR(128),
    description LONGTEXT,
    created_at DATETIME,
    updated_at DATETIME NULL,
    image_name VARCHAR(255) NULL
);

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(180),
    roles JSON,
    password VARCHAR(255),
    created_at DATETIME,
    updated_at DATETIME NULL,
    zoo_id INT
);

CREATE TABLE additional_images (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    image_name VARCHAR(255) NOT NULL,
    animal_id INT,
    habitat_id INT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL
);





ALTER TABLE Animal ADD CONSTRAINT FK_habitat_for_animal FOREIGN KEY (habitat_id) REFERENCES Habitat(id) ON DELETE SET NULL;

ALTER TABLE Avis ADD CONSTRAINT FK_zoo_id_for_avis FOREIGN KEY (zoo_id) REFERENCES Zoo(id);

ALTER TABLE commentaire_habitat ADD CONSTRAINT FK_habitat_id_for_commentaire FOREIGN KEY (habitat_id) REFERENCES Habitat(id);
ALTER TABLE commentaire_habitat ADD CONSTRAINT FK_auteur_id_for_commentaire FOREIGN KEY (auteur_id) REFERENCES Users(id) ON DELETE SET NULL;

ALTER TABLE demande_contact ADD CONSTRAINT FK_zoo_id_for_demande FOREIGN KEY (zoo_id) REFERENCES Zoo(id);

ALTER TABLE info_animal ADD CONSTRAINT FK_animal_for_infoAnimal FOREIGN KEY (animal_id) REFERENCES Animal(id);
ALTER TABLE info_animal ADD CONSTRAINT FK_nourriture_for_infoAnimal FOREIGN KEY (nourriture_id) REFERENCES Nourriture(id);
ALTER TABLE info_animal ADD CONSTRAINT FK_auteur_for_infoAnimal FOREIGN KEY (auteur_id) REFERENCES Users(id) ON DELETE SET NULL;

ALTER TABLE repas ADD CONSTRAINT FK_animal_for_repas FOREIGN KEY (animal_id) REFERENCES Animal(id);
ALTER TABLE repas ADD CONSTRAINT FK_nourriture_for_repas FOREIGN KEY (nourriture_id) REFERENCES Nourriture(id);
ALTER TABLE repas ADD CONSTRAINT FK_auteur_for_repas FOREIGN KEY (auteur) REFERENCES Users(id) ON DELETE SET NULL;

ALTER TABLE Service ADD CONSTRAINT FK_zoo_id_for_service FOREIGN KEY (zoo_id) REFERENCES Zoo(id);

ALTER TABLE Users ADD CONSTRAINT FK_zoo_id_for_user FOREIGN KEY (zoo_id) REFERENCES Zoo(id);

ALTER TABLE additional_images ADD CONSTRAINT FK_animal_id_for_additional_images FOREIGN KEY (animal_id) REFERENCES Animal(id);
ALTER TABLE additional_images ADD CONSTRAINT FK_habitat_id_for_additional_images FOREIGN KEY (habitat_id) REFERENCES Habitat(id);





INSERT INTO Zoo VALUES 
(1, 'Arcadia');