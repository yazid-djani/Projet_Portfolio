-- --------------------------------------------------------
-- 1. Configuration initiale et Base de données
-- --------------------------------------------------------
-- Création de l'utilisateur (si nécessaire)
CREATE USER IF NOT EXISTS 'user_quizzeo'@'localhost' IDENTIFIED BY 'Welcome2025!';

-- Création de la BDD
CREATE DATABASE IF NOT EXISTS quizzeo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quizzeo;

-- Attribution des droits
GRANT SELECT, INSERT, UPDATE, DELETE ON quizzeo.* TO 'user_quizzeo'@'localhost';
FLUSH PRIVILEGES;

-- --------------------------------------------------------
-- 2. Table users (Remplace Utilisateur, Ecole, Entreprise, Admin)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS users 
(
    user_id             INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_lastname       VARCHAR(100) NOT NULL,
    user_firstname      VARCHAR(100) NOT NULL,
    user_email          VARCHAR(255) NOT NULL UNIQUE,
    user_age            INT UNSIGNED NOT NULL,
    password_hash       VARCHAR(255) NOT NULL,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role                ENUM('admin','ecole','entreprise','utilisateur') NOT NULL DEFAULT 'utilisateur',
    status              ENUM('active','desactive') NOT NULL DEFAULT 'active',
    can_create_quiz     TINYINT(1) NOT NULL DEFAULT 0   -- 1. Ajout de la permission de créer des quiz (0 = non, 1 = oui)
);

-- --------------------------------------------------------
-- 3. Table quiz
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS quiz 
(
    id_quiz             INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id             INT UNSIGNED NOT NULL,
    titre               VARCHAR (255) NOT NULL, 
    description         TEXT NULL,
    proprietaire        ENUM('entreprise', 'ecole', 'utilisateur') NOT NULL, 
    status              ENUM('brouillon', 'published', 'archived') NOT NULL DEFAULT 'brouillon',
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_lancement      DATETIME NULL,
    date_cloture        DATETIME NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- --------------------------------------------------------
-- 4. Table question
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS question 
(
    id_question    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_quiz        INT UNSIGNED NOT NULL,
    libelle        VARCHAR(255) NOT NULL,
    
    FOREIGN KEY (id_quiz) REFERENCES quiz(id_quiz)
);

-- --------------------------------------------------------
-- 5. Table choix (Pour les QCM)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS choix 
(
    id_choix       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_question    INT UNSIGNED NOT NULL,
    libelle        VARCHAR(255) NOT NULL,
    est_correct    TINYINT(1) NOT NULL DEFAULT 0,
    
    FOREIGN KEY (id_question) REFERENCES question(id_question)
);

-- --------------------------------------------------------
-- 6. Table tentative (Lien Joueur <-> Quiz)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS tentative 
(
    id_tentative   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_quiz        INT UNSIGNED NOT NULL,
    user_id        INT UNSIGNED NOT NULL, -- Correction du nom pour correspondre à la table users
    date_debut     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_fin       DATETIME NULL,
    score_total    INT NULL,
    
    FOREIGN KEY (id_quiz) REFERENCES quiz(id_quiz),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- --------------------------------------------------------
-- 7. Table reponse (Le coeur du système)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS reponse 
(
    id_reponse     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    est_correct    TINYINT(1) NULL,
    
    id_tentative   INT UNSIGNED NOT NULL,
    id_question    INT UNSIGNED NOT NULL,
    id_choix       INT UNSIGNED NULL, -- Nullable car peut être une réponse libre (si tu le gères plus tard)
    
    FOREIGN KEY (id_tentative) REFERENCES tentative(id_tentative),
    FOREIGN KEY (id_question) REFERENCES question(id_question),
    FOREIGN KEY (id_choix) REFERENCES choix(id_choix)
);

-- --------------------------------------------------------
-- NOTE SUR LE CLASSEMENT
-- La table classement a été retirée car elle est redondante.
-- Le classement se calcule dynamiquement avec :
-- SELECT * FROM tentative WHERE id_quiz = X ORDER BY score_total DESC;
-- --------------------------------------------------------


-- 2. Création de l'Administrateur UNIQUE (Mot de passe: "admin123")
-- Le hash ci-dessous correspond à "admin123" via password_hash()

-- --------------------------------------------------------
-- 8. Données de test : Users
-- --------------------------------------------------------

-- 1. Création de l'Administrateur UNIQUE (Mot de passe: "admin123")
-- Le hash ci-dessous correspond à "admin123" via password_hash()

INSERT INTO users (user_lastname, user_firstname, user_email, user_age, password_hash, role, status, can_create_quiz)
VALUES ('Super', 'Admin', 'admin@quizzeo.com', 99, '$2y$10$hMHscKPrztyiDUYrH3SY/ufbnjndlcfl7ozS11VwDdTKfgfwkf3gS', 'admin', 'active', 1);


-- 1. Création de d'utilisateurs aléatoires (Mot de passe: "123")
-- Le hash ci-dessous correspond à "123" via password_hash()

INSERT INTO users (user_lastname, user_firstname, user_email, user_age, password_hash, role, status, can_create_quiz)
VALUES
('Durand', 'Paul', 'paul.durand@quizzeo.com', 22, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0),
('Martin', 'Lina', 'lina.martin@quizzeo.com', 19, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0),
('Petit', 'Hugo', 'hugo.petit@quizzeo.com', 25, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'ecole', 'active', 1),
('Robert', 'Emma', 'emma.robert@quizzeo.com', 23, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'entreprise', 'active', 1),
('Morel', 'Lucas', 'lucas.morel@quizzeo.com', 28, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0),
('Lefevre', 'Chloe', 'chloe.lefevre@quizzeo.com', 21, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0),
('Roux', 'Nicolas', 'nicolas.roux@quizzeo.com', 32, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'ecole', 'active', 1),
('Fournier', 'Elisa', 'elisa.fournier@quizzeo.com', 26, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'entreprise', 'active', 1),
('Girard', 'Adam', 'adam.girard@quizzeo.com', 18, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0),
('Lambert', 'Sarah', 'sarah.lambert@quizzeo.com', 24, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0); 

-- --------------------------------------------------------
-- 9. Données de test : Quiz
-- --------------------------------------------------------

INSERT INTO quiz (id_quiz, user_id, titre, description, proprietaire, status, created_at, date_lancement, date_cloture)
VALUES
-- Quiz 1 : PHP débutant (créé par une école : user_id = 4, Hugo Petit)
(1, 4, 'Quiz PHP débutant', 'Questions simples pour réviser les bases de PHP.', 'ecole', 'published', '2025-01-01 10:00:00', '2025-01-05 09:00:00', NULL),

-- Quiz 2 : Culture générale (créé par une entreprise : user_id = 5, Emma Robert)
(2, 5, 'Quiz Culture générale', 'Un quiz pour tester tes connaissances générales.', 'entreprise', 'published', '2025-01-02 11:00:00', '2025-01-06 09:00:00', NULL),

-- Quiz 3 : Sport (créé par un utilisateur : user_id = 2, Paul Durand)
(3, 2, 'Quiz Sport', 'Questions sur le sport et ses règles.', 'utilisateur', 'brouillon', '2025-01-03 12:00:00', NULL, NULL);

-- --------------------------------------------------------
-- 9. Données de test : Questions
-- --------------------------------------------------------

INSERT INTO question (id_question, id_quiz, libelle)
VALUES
-- Quiz 1 : PHP débutant (id_quiz = 1)
(1, 1, 'Que signifie l''acronyme PHP ?'),
(2, 1, 'Quelle superglobale PHP contient les données envoyées en POST ?'),
(3, 1, 'Quel opérateur est utilisé pour la concaténation de chaînes en PHP ?'),

-- Quiz 2 : Culture générale (id_quiz = 2)
(4, 2, 'Quelle est la capitale de la France ?'),
(5, 2, 'Combien y a-t-il de continents sur Terre (modèle classique) ?'),
(6, 2, 'Quelle est la plus grande planète du système solaire ?'),

-- Quiz 3 : Sport (id_quiz = 3)
(7, 3, 'Combien de joueurs y a-t-il sur le terrain pour une équipe de football en match officiel ?'),
(8, 3, 'En NBA, combien de points vaut un tir derrière la ligne à trois points ?'),
(9, 3, 'Quel pays a remporté la Coupe du Monde de football en 2018 ?');

-- --------------------------------------------------------
-- 10. Données de test : Choix
-- --------------------------------------------------------

INSERT INTO choix (id_choix, id_question, libelle, est_correct)
VALUES
-- Question 1 : Que signifie PHP ?
(1, 1, 'Hypertext Preprocessor', 1),
(2, 1, 'Personal Home Page', 0),
(3, 1, 'Programming Hyperlink Protocol', 0),

-- Question 2 : Superglobale POST
(4, 2, '$_GET', 0),
(5, 2, '$_POST', 1),
(6, 2, '$_SESSION', 0),

-- Question 3 : Concaténation en PHP
(7, 3, '.', 1),
(8, 3, '+', 0),
(9, 3, '&', 0),

-- Question 4 : Capitale de la France
(10, 4, 'Madrid', 0),
(11, 4, 'Paris', 1),
(12, 4, 'Londres', 0),

-- Question 5 : Continents
(13, 5, '5', 0),
(14, 5, '6', 0),
(15, 5, '7', 1),

-- Question 6 : Plus grande planète
(16, 6, 'Mars', 0),
(17, 6, 'Jupiter', 1),
(18, 6, 'Venus', 0),

-- Question 7 : Joueurs de foot sur le terrain (par équipe)
(19, 7, '9', 0),
(20, 7, '10', 0),
(21, 7, '11', 1),

-- Question 8 : Tir à 3 points en NBA
(22, 8, '2 points', 0),
(23, 8, '3 points', 1),
(24, 8, '4 points', 0),

-- Question 9 : Champion du monde 2018
(25, 9, 'France', 1),
(26, 9, 'Allemagne', 0),
(27, 9, 'Brésil', 0);