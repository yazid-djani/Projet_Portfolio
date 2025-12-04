-- --------------------------------------------------------
-- 1. Configuration initiale et Base de données
-- --------------------------------------------------------
-- Création de l'utilisateur (si nécessaire)
CREATE USER IF NOT EXISTS 'user_ipssi'@'localhost' IDENTIFIED BY 'Welcome2025!';

-- Création de la BDD
CREATE DATABASE IF NOT EXISTS quizzeo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quizzeo;

-- Attribution des droits
GRANT SELECT, INSERT, UPDATE, DELETE ON quizzeo.* TO 'user_ipssi'@'localhost';
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
    status              ENUM('active','desactive') NOT NULL DEFAULT 'active'
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


-- 1. Ajout de la permission de créer des quiz (0 = non, 1 = oui)
ALTER TABLE users ADD COLUMN can_create_quiz TINYINT(1) DEFAULT 0;

-- 2. Création de l'Administrateur UNIQUE (Mot de passe: "admin123")
-- Le hash ci-dessous correspond à "admin123" via password_hash()
INSERT INTO users (user_lastname, user_firstname, user_email, user_age, password_hash, role, status, can_create_quiz)
VALUES ('Super', 'Admin', 'admin@quizzeo.com', 99, '$2y$10$hMHscKPrztyiDUYrH3SY/ufbnjndlcfl7ozS11VwDdTKfgfwkf3gS', 'admin', 'active', 1);