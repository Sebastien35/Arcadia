USE arcadia_db;
SET NAMES 'utf8mb4';
INSERT INTO Horaire(jour, h_ouverture, h_fermeture, ouvert) VALUES
('Lundi', '08:00:00', '18:00:00', 1),
('Mardi', '08:00:00', '18:00:00', 1),
('Mercredi', '08:00:00', '18:00:00', 1),
('Jeudi', '08:00:00', '18:00:00', 1),
('Vendredi', '08:00:00', '18:00:00', 1),
('Samedi', '08:00:00', '18:00:00', 1),
('Dimanche', '08:00:00', '18:00:00', 1);

INSERT INTO Habitat (id, nom, image_name, description, updated_at) VALUES
(1,'Savane','65c4f28208809965150037.jpeg', 'Des plaines arides, où vivent des animaux légendaires.', null),
(2,'Jungle','65cce69a4ed31928698932.jpeg', 'Une jungle luxuriante abritant des espèces rares et sauvages' , null),
(3,'Montagne','65c605b27c6e1149964943.jpeg','Des pics rocheux enneigés abritant des espèces rares et captivantes', null),
(4,'Forêt','65c505469a665418670019.jpeg', 'Une forêt peuple de différents animaux de différents origines', null),
(5,'Marais','65e1f607678a1876940815.jpeg', 'Un écosystème riche en faune sauvage et en végétation luxuriante', null);

INSERT INTO Animal (id, habitat_id, prenom, race, created_at, updated_at, image_name) VALUES
(1, 1, 'Alex', 'Lion', NOW(), null, '65f81c4100f36738583746.jpeg'),
(2, 1, 'Marty', 'Zèbre', NOW(), null, '65f81db9300b9180917397.jpg'),
(3, 1, 'Melman', 'Girafe', NOW(), null, '65f82e000fed2051454791.jpg'),
(4, 4, 'Scrat', 'Ecureuil', NOW(), null, '65f82e13d4848777523960.jpeg'),
(5, 3, 'Billy', 'Léopard des neiges', NOW(), null, '65f82e25ef41f462705377.jpeg'),
(6, 2, 'Sirius', 'Panthère noire', NOW(), null, '65f82e5a9bcfa261678134.jpeg'),
(7, 5, 'Moto-Moto', 'Hippopotame', NOW(), null, '65f82e8995be2637407034.jpg'),
(8, 5, 'Gloria', 'Hippopotame', NOW(), null, '65f82ea57053b403287182.jpg'),
(9, 3, 'Lucie', 'Marmotte', NOW(), null, '65f82f10ca9d3556392311.jpeg'),
(10, 2, 'Gia', 'Jaguar', NOW(), null, '65f8bb93ec422977272701.jpg');

INSERT INTO Avis (id, pseudo, avis_content, note, validation, created_at) VALUES
(1, 'Alex', 'Superbe parc, j ai adoré !', 5, 1,NOW()),
(2, 'Marty', 'J ai passé un super moment, je recommande !', 5, 0,NOW()),
(3, 'Melman', 'J ai adoré, je reviendrai !', 5, 0,NOW()),
(4, 'Scrat', 'J ai adoré, je reviendrai !', 5, 1,NOW()),
(5, 'Billy', 'J ai adoré, je reviendrai !', 5, 1,NOW()),
(6, 'Sirius', 'Le restaurant est vraiment nul !', 1, 1,NOW());


INSERT INTO commentaire_habitat (id, commentaire, habitat_id, created_at, updated_at, auteur_id) VALUES
(1, "Il faut changer l' eau des animaux plus régulièrement", 1, NOW(), null, 2),
(2, "Rien à dire c'est nickel", 1, NOW(), null, 2),
(3, "Les animaux sont bien traités", 1, NOW(), null, 2),
(4, "L'enclos est propre, rien de particulier", 1, NOW(), null, 2),
(5, "Penser à replanter des arbustes au bord du point d'eau numéro 3", 5, NOW(), null, 2);


INSERT INTO service (id, nom, description, created_at, updated_at, zoo_id, image_name) VALUES
(1, 'Restaurant', "Profitez d'une pause gourmande près des animaux.", NOW(), NULL, NULL, '65f81f89bb38d643616718.webp'),
(2, 'Balade en petit train', 'Une balade autour du zoo dans un petit train', NOW(), NULL, NULL, '65f82c1d3c3a7400963628.webp'),
(3, 'Visite guidée des habitats', "Visitez les animaux accompagnés d'un guide vétérinaire.", NOW(), NULL, NULL, '65f82d2f91802833866449.webp');


INSERT INTO demande_contact (id, titre, message, mail, created_at, answered_at, answered) VALUES
(1, 'Demande de renseignements', 'Bonjour, je souhaiterais avoir des informations sur les horaires d ouverture du zoo.', 'jeanquete.ecfarcadia@gmail.com', NOW(), NULL, 0),
(2, 'Demande de renseignements', 'Bonjour, je souhaiterais avoir des informations sur les tarifs du zoo.', 'jeanquete.ecfarcadia@gmail.com', NOW(), NULL, 0),
(3, 'Stage de 3eme', 'Bonjour, je cherche un stage pour ma fille.', 'jeanquete.ecfarcadia@gmail.com', NOW(), NULL, 0),
(4, 'Demande de renseignements', 'Bonjour, je souhaiterais avoir des informations sur les horaires d ouverture du zoo.', 'jeanquete.ecfarcadia@gmail.com', NOW(), NOW(), 1);


INSERT INTO nourriture (id, nom, description) VALUES
(1, 'Nourriture pour félins', 'Mélange de viande, poisson, vitamines et minéraux pour les félins.'),
(2, 'Nourriture pour herbivores', 'Mélange de fruits, légumes, vitamines et minéraux pour les herbivores.'),
(3, 'Nourriture pour omnivores', 'Mélange de viande, fruits, légumes, vitamines et minéraux pour les omnivores.'),
(4, 'Nourriture pour rongeurs', 'Mélange de graines, fruits, légumes, vitamines et minéraux pour les rongeurs.'),
(5, 'Nourriture pour poissons', 'Mélange de granulés, vitamines et minéraux pour les poissons.'),
(6, 'Nourriture pour oiseaux', 'Mélange de graines, fruits, vitamines et minéraux pour les oiseaux.');


INSERT INTO info_animal (id, nourriture_id, animal_id, auteur_id, etat, details, grammage, created_at) VALUES
(1, 1, 1, 2, "Bonne santé", "RAS", 2000, NOW()),
(2, 2, 2, 2, "Bonne santé", "Marty est craintif", 1800, NOW()),
(3, 2, 3, 2, "Malade", "Melman a un rhume", 1600, NOW()),
(4, 4, 4, 2, "Bonne santé", "Scrat est gourmand", 1500, NOW()),
(5, 1, 5, 2, "Bonne santé", "Billy est joueur", 2000, NOW()),
(6, 1, 6, 2, "Bonne santé", "Sirius se plaît dans son nouvel enclos", 2000, NOW()),
(7, 2, 7, 2, "Bonne santé", "Moto-Moto est gourmand", 2200, NOW()),
(8, 2, 8, 2, "Bonne santé", "Gloria est en surpoids", 1900, NOW()),
(9, 4, 9, 2, "Bonne santé", "Lucie creuse un terrier", 2000, NOW()),
(10, 1, 10, 2, "Bonne santé", "Gia est enceinte", 2000, NOW());

INSERT INTO repas (id, nourriture_id, animal_id, datetime, quantite) VALUES
(1, 1, 1, NOW(), 200),
(2, 2, 2, NOW(), 180),
(3, 2, 3, NOW(), 160),
(4, 4, 4, NOW(), 150),
(5, 1, 5, NOW(), 200),
(6, 1, 6, NOW(), 200),
(7, 2, 7, NOW(), 220),
(8, 2, 8, NOW(), 190),
(9, 4, 9, NOW(), 200),
(10, 1, 10, NOW(), 200),
(11, 1, 1, DATE_SUB(NOW(), INTERVAL 7 DAY), 200),
(12, 2, 2, DATE_SUB(NOW(), INTERVAL 7 DAY), 180),
(13, 2, 3, DATE_SUB(NOW(), INTERVAL 7 DAY), 160),
(14, 4, 4, DATE_SUB(NOW(), INTERVAL 7 DAY), 150),
(15, 1, 5, DATE_SUB(NOW(), INTERVAL 7 DAY), 200),
(16, 1, 6, DATE_SUB(NOW(), INTERVAL 7 DAY), 200),
(17, 2, 7, DATE_SUB(NOW(), INTERVAL 7 DAY), 220),
(18, 2, 8, DATE_SUB(NOW(), INTERVAL 7 DAY), 190),
(19, 4, 9, DATE_SUB(NOW(), INTERVAL 7 DAY), 200),
(20, 1, 10, DATE_SUB(NOW(), INTERVAL 7 DAY), 200),
(21, 1, 1, DATE_SUB(NOW(), INTERVAL 3 DAY), 200),
(22, 2, 2, DATE_SUB(NOW(), INTERVAL 3 DAY), 180),
(23, 2, 3, DATE_SUB(NOW(), INTERVAL 3 DAY), 160),
(24, 4, 4, DATE_SUB(NOW(), INTERVAL 3 DAY), 150),
(25, 1, 5, DATE_SUB(NOW(), INTERVAL 3 DAY), 200),
(26, 1, 6, DATE_SUB(NOW(), INTERVAL 3 DAY), 200),
(27, 2, 7, DATE_SUB(NOW(), INTERVAL 3 DAY), 220),
(28, 2, 8, DATE_SUB(NOW(), INTERVAL 3 DAY), 190),
(29, 4, 9, DATE_SUB(NOW(), INTERVAL 3 DAY), 200),
(30, 1, 10, DATE_SUB(NOW(), INTERVAL 3 DAY), 200);