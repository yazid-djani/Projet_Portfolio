-- --------------------------------------------------------
-- 0. Configuration initiale et Base de données
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
-- 1. Table users 
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS groups (
    group_id            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, -- Ajout de UNSIGNED
    name                VARCHAR(100) NOT NULL,
    type                ENUM('ECOLE', 'ENTREPRISE') NOT NULL,
    code                VARCHAR(50) NOT NULL UNIQUE,      -- UNIQUE suffit (KEY est implicite)
    created_at          DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------
-- 2. Table users 
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS users 
(
    user_id             INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_lastname       VARCHAR(100) NOT NULL,
    user_firstname      VARCHAR(100) NOT NULL,
    user_email          VARCHAR(255) NOT NULL UNIQUE,
    group_id            INT UNSIGNED NULL,
    user_age            INT UNSIGNED NOT NULL,
    password_hash       VARCHAR(255) NOT NULL,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role                ENUM('admin','ecole','entreprise','utilisateur') NOT NULL DEFAULT 'utilisateur',
    status              ENUM('active','desactive') NOT NULL DEFAULT 'active',
    can_create_quiz     TINYINT(1) NOT NULL DEFAULT 0,

    FOREIGN KEY (group_id) REFERENCES groups(group_id)
);

-- --------------------------------------------------------
-- 3. Table quiz (Mise à jour avec visibility)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS quiz 
(
    id_quiz             INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id             INT UNSIGNED NOT NULL,
    titre               VARCHAR (255) NOT NULL, 
    description         TEXT NULL,
    proprietaire        ENUM('entreprise', 'ecole', 'utilisateur') NOT NULL, 
    status              ENUM('brouillon', 'published', 'archived') NOT NULL DEFAULT 'brouillon',
    visibility          ENUM('public', 'private') NOT NULL DEFAULT 'public', -- Ajouté ici
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
-- 5. Table choix
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
-- 6. Table tentative
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS tentative 
(
    id_tentative   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_quiz        INT UNSIGNED NOT NULL,
    user_id        INT UNSIGNED NOT NULL, 
    date_debut     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_fin       DATETIME NULL,
    score_total    INT NULL,
    
    FOREIGN KEY (id_quiz) REFERENCES quiz(id_quiz),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- --------------------------------------------------------
-- 7. Table reponse
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS reponse 
(
    id_reponse     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    est_correct    TINYINT(1) NULL,
    
    id_tentative   INT UNSIGNED NOT NULL,
    id_question    INT UNSIGNED NOT NULL,
    id_choix       INT UNSIGNED NULL, 
    
    FOREIGN KEY (id_tentative) REFERENCES tentative(id_tentative),
    FOREIGN KEY (id_question) REFERENCES question(id_question),
    FOREIGN KEY (id_choix) REFERENCES choix(id_choix)
);

-- --------------------------------------------------------
-- 8. Données de test : Users (Avec Groupes)
-- --------------------------------------------------------

-- Admin (Pas de groupe)
INSERT INTO users (user_lastname, user_firstname, user_email, user_age, password_hash, role, status, can_create_quiz, group_code)
VALUES ('Super', 'Admin', 'admin@quizzeo.com', 99, '$2y$10$hMHscKPrztyiDUYrH3SY/ufbnjndlcfl7ozS11VwDdTKfgfwkf3gS', 'admin', 'active', 1, NULL);

INSERT INTO users (user_lastname, user_firstname, user_email, user_age, password_hash, role, status, can_create_quiz, group_code)
VALUES
-- GROUPE 1 : "ECOLE_PARIS" (Hugo est le prof, Paul, Lina et Adam sont les élèves)
('Petit', 'Hugo', 'hugo.petit@quizzeo.com', 25, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'ecole', 'active', 1, 'ECOLE_PARIS'),
('Durand', 'Paul', 'paul.durand@quizzeo.com', 22, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0, 'ECOLE_PARIS'),
('Martin', 'Lina', 'lina.martin@quizzeo.com', 19, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0, 'ECOLE_PARIS'),
('Girard', 'Adam', 'adam.girard@quizzeo.com', 18, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0, 'ECOLE_PARIS'),

-- GROUPE 2 : "TECH_CORP" (Emma est la manager, Lucas est l'employé)
('Robert', 'Emma', 'emma.robert@quizzeo.com', 23, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'entreprise', 'active', 1, 'TECH_CORP'),
('Morel', 'Lucas', 'lucas.morel@quizzeo.com', 28, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0, 'TECH_CORP'),

-- GROUPE 3 : "UNIV_LYON" (Nicolas est le prof, Sarah est l'étudiante)
('Roux', 'Nicolas', 'nicolas.roux@quizzeo.com', 32, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'ecole', 'active', 1, 'UNIV_LYON'),
('Lambert', 'Sarah', 'sarah.lambert@quizzeo.com', 24, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0, 'UNIV_LYON'),

-- GROUPE 4 : "DATA_SOLUTIONS" (Elisa est la manager)
('Fournier', 'Elisa', 'elisa.fournier@quizzeo.com', 26, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'entreprise', 'active', 1, 'DATA_SOLUTIONS'),

-- SANS GROUPE (Utilisateur lambda)
('Lefevre', 'Chloe', 'chloe.lefevre@quizzeo.com', 21, '$2y$10$/K9Vtxz6SLB7Ws7WwJBOIekL1vSzykI0LZpoVE/FU75icVf9gqVKu', 'utilisateur', 'active', 0, NULL);


-- --------------------------------------------------------
-- 9. Données de test : Quiz (Avec Visibilité)
-- --------------------------------------------------------

INSERT INTO quiz (id_quiz, user_id, titre, description, proprietaire, status, visibility, created_at, date_lancement, date_cloture)
VALUES
-- Quiz 1 : PHP (Public, créé par Hugo ECOLE_PARIS) -> Visible par tout le monde
(1, 2, 'Quiz PHP débutant', 'Questions simples pour réviser les bases de PHP.', 'ecole', 'published', 'public', '2025-01-01 10:00:00', '2025-01-05 09:00:00', NULL),

-- Quiz 2 : Culture G (Privé, créé par Emma TECH_CORP) -> Visible UNIQUEMENT par Lucas (qui est dans TECH_CORP)
(2, 6, 'Culture d\'Entreprise', 'Test interne pour les employés de Tech Corp.', 'entreprise', 'published', 'private', '2025-01-02 11:00:00', '2025-01-06 09:00:00', NULL),

-- Quiz 3 : Sport (Brouillon, créé par Paul) -> Visible par personne sauf Paul
(3, 3, 'Quiz Sport', 'Questions sur le sport et ses règles.', 'utilisateur', 'brouillon', 'public', '2025-01-03 12:00:00', NULL, NULL);

-- --------------------------------------------------------
-- 10. Données de test : Questions & Choix (Inchangés)
-- --------------------------------------------------------

INSERT INTO question (id_question, id_quiz, libelle)
VALUES
(1, 1, 'Que signifie l''acronyme PHP ?'),
(2, 1, 'Quelle superglobale PHP contient les données envoyées en POST ?'),
(3, 1, 'Quel opérateur est utilisé pour la concaténation de chaînes en PHP ?'),
(4, 2, 'Quelle est la valeur principale de Tech Corp ?'),
(5, 2, 'En quelle année a été fondée l\'entreprise ?'),
(6, 2, 'Qui est le CEO actuel ?'),
(7, 3, 'Combien de joueurs y a-t-il sur le terrain pour une équipe de football en match officiel ?'),
(8, 3, 'En NBA, combien de points vaut un tir derrière la ligne à trois points ?'),
(9, 3, 'Quel pays a remporté la Coupe du Monde de football en 2018 ?');

INSERT INTO choix (id_choix, id_question, libelle, est_correct)
VALUES
(1, 1, 'Hypertext Preprocessor', 1), 
(2, 1, 'Personal Home Page', 0), 
(3, 1, 'Programming Hyperlink Protocol', 0),
(4, 2, '$_GET', 0), 
(5, 2, '$_POST', 1), 
(6, 2, '$_SESSION', 0),
(7, 3, '.', 1), 
(8, 3, '+', 0), 
(9, 3, '&', 0),
-- Réponses Quiz Entreprise
(10, 4, 'L''innovation', 1), 
(11, 4, 'Le profit', 0), 
(12, 4, 'La stagnation', 0),
(13, 5, '2010', 0), 
(14, 5, '2015', 1), 
(15, 5, '2020', 0),
(16, 6, 'Elon Musk', 0), 
(17, 6, 'Emma Robert', 1), 
(18, 6, 'Jeff Bezos', 0),
-- Réponses Quiz Sport
(19, 7, '9', 0), 
(20, 7, '10', 0), 
(21, 7, '11', 1),
(22, 8, '2 points', 0), 
(23, 8, '3 points', 1), 
(24, 8, '4 points', 0),
(25, 9, 'France', 1), 
(26, 9, 'Allemagne', 0), 
(27, 9, 'Brésil', 0);