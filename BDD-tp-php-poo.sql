CREATE TABLE IF NOT EXISTS users
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(200),
    password VARCHAR(200),
    role_id INT(10)
);


CREATE TABLE IF NOT EXISTS equipements
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS types_logement
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(100)

);

CREATE TABLE IF NOT EXISTS logements
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    pays VARCHAR(50),
    adresse VARCHAR(100),
    ville VARCHAR(60),
    prix DECIMAL(6,2),
    surface VARCHAR(10),
    description VARCHAR(255),
    couchage int(2),
    photo VARCHAR(50),
    annonceur_id INT(10),
    type_logement_id INT(10),
    FOREIGN KEY (annonceur_id) REFERENCES users (id),
    FOREIGN KEY (type_logement_id) REFERENCES types_logement (id)
);

CREATE TABLE IF NOT EXISTS reservations
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    logement_id int(10),
    user_id int(10),
    date_debut date,
    date_fin date,
    FOREIGN KEY (logement_id) REFERENCES logements (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS logement_equipement
(
    logement_id INT(10),
    equipement_id INT(10),
    PRIMARY KEY (logement_id,equipement_id),
    FOREIGN KEY (logement_id) REFERENCES logements (id),
    FOREIGN KEY (equipement_id) REFERENCES equipements (id)
);


INSERT INTO types_logement (libelle)
VALUES
    ('Logement entier'),
    ('Chambre privée'),
    ('Chambre partagée');


INSERT INTO equipements (libelle)
VALUES
    ('Grille-pain'),
    ('Machine à laver'),
    ('Machine à café'),
    ('Lave vaisselle'),
    ('Télé'),
    ('Wifi'),
    ('Bouilloire'),
    ('Sèche cheveux'),
    ('Plaques de cuisson'),
    ('Table'),
    ('Canapé'),
    ('Bureau');


INSERT INTO users (nom, prenom, email, password, role_id)
VALUES
    ('Lafripouille', 'Cyrielle', 'f@gmail.com', '12345', 1),
    ('Limitatrice', 'Marion', 'marion@gmail.com', '456789',2),
    ('Hallyday', 'JeanMarcel', 'jm@gmail.com', '456123',2),
    ('Delafontaine', 'Jean', 'jean@gmail.com', '9999',1);


INSERT INTO logements (pays, adresse, ville, prix, surface, description, couchage,photo, annonceur_id, type_logement_id)
VALUES
    ('France', '17 rue des lilas', 'Paris', '120', '50', 'Ma chambre c\'est la plus cool mais elle est partagée','1','img/chambres/photo.jpg',1,3),
    ('Allemagne', '20 avenue d\'Europe', 'Berlin', '150','60','Je loues ma grande chambre','2','img/chambres/photo.jpg',4,2),
    ('France', '67 Boulevard des apparts', 'Metz', '20','25', 'Petite chambre cosy pour faire une pause','4','img/chambres/photo.jpg',1,2),
    ('France', '10 rue des pietons', 'Angouleme', '70','100','Petit coin de paradis','6','img/chambres/photo.jpg',1,1);

INSERT INTO reservations (logement_id, user_id, date_debut, date_fin)
VALUES
    (4,2,'2023-12-24','2025-01-05'),
    (2,2,'2023-05-10','2023-05-12'),
    (1,3,'2023-07-04','2023-07-06'),
    (3,3,'2023-08-02','2023-08-05');

INSERT INTO logement_equipement(logement_id,equipement_id)
VALUES
    (1,12),
    (1,10),
    (1,5),
    (1,3),
    (2,1),
    (2,6),
    (2,7),
    (2,9),
    (3,6),
    (3,7),
    (3,8),
    (3,9);