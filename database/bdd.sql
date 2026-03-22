CREATE DATABASE IF NOT EXISTS portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio_db;

-- 1. Table Admins : Gère les accès sécurisés au panel d'administration.
CREATE TABLE IF NOT EXISTS admins (
                                      id INT AUTO_INCREMENT PRIMARY KEY,
                                      username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

-- 2. Table Projets : Stocke le portfolio (images, vidéos, descriptions modale, github).
CREATE TABLE IF NOT EXISTS projets (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       titre VARCHAR(255) NOT NULL,
    description TEXT,
    detail TEXT,
    categorie ENUM('developpement', 'reseau') NOT NULL,
    technologies VARCHAR(255),
    image_url VARCHAR(255) DEFAULT 'default.jpg',
    lien_github VARCHAR(255),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
    );

-- 3. Table Messages Contact : Enregistre les formulaires envoyés depuis le site public.
CREATE TABLE IF NOT EXISTS messages_contact (
                                                id INT AUTO_INCREMENT PRIMARY KEY,
                                                nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    sujet VARCHAR(255),
    message TEXT NOT NULL,
    lu TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

-- 4. Table Visites : Historise le trafic, les IP et différencie les vues des clics (CV, Liens).
CREATE TABLE IF NOT EXISTS visites (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       page VARCHAR(100),
    type ENUM('vue', 'clic') DEFAULT 'vue',
    ip_address VARCHAR(45),
    user_agent TEXT,
    visited_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

-- 5. Table Profil : Ligne unique contenant toutes les variables globales du site (Textes, liens, photo).
CREATE TABLE IF NOT EXISTS profil (
                                      id INT AUTO_INCREMENT PRIMARY KEY,
                                      nom VARCHAR(100) DEFAULT '',
    prenom VARCHAR(100) DEFAULT '',
    titre_poste VARCHAR(255) DEFAULT '',
    entreprise VARCHAR(255) DEFAULT '',
    description_hero TEXT,
    description_about TEXT,
    email_contact VARCHAR(255) DEFAULT '',
    lien_github VARCHAR(255) DEFAULT '',
    lien_linkedin VARCHAR(255) DEFAULT '',
    localisation VARCHAR(255) DEFAULT '',
    lien_cv VARCHAR(255) DEFAULT '',
    image_profil VARCHAR(255) DEFAULT 'default_profil.png'
    );

-- 6. Table Compétences : Alimente dynamiquement les barres de progression de la section Compétences.
CREATE TABLE IF NOT EXISTS competences (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
                                           nom VARCHAR(100) NOT NULL,
    pourcentage INT NOT NULL,
    categorie ENUM('developpement', 'reseau') NOT NULL
    );

-- 7. Table Outils : Stocke les petites cartes (logos) affichées sous les compétences.
CREATE TABLE IF NOT EXISTS outils (
                                      id INT AUTO_INCREMENT PRIMARY KEY,
                                      nom VARCHAR(100) DEFAULT '',
    image_url VARCHAR(255) NOT NULL
    );

-- 8. Table Certifications : Stocke les diplômes avec leurs descriptions pour la galerie dédiée.
CREATE TABLE IF NOT EXISTS certifications (
                                              id INT AUTO_INCREMENT PRIMARY KEY,
                                              nom VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255) NOT NULL
    );

-- 9. Table Parcours : Historise les formations et expériences (type, titre, établissement, période, description).
CREATE TABLE IF NOT EXISTS parcours (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        type ENUM('formation', 'experience') NOT NULL,
    titre VARCHAR(255) NOT NULL,
    etablissement VARCHAR(255) NOT NULL,
    date_periode VARCHAR(100) NOT NULL,
    description TEXT
    );

-- Insertion du profil vide par défaut
INSERT INTO profil (nom, prenom, titre_poste, entreprise, description_hero, description_about, email_contact, lien_github, lien_linkedin, localisation, lien_cv, image_profil)
VALUES ('', '', '', '', '', '', '', '', '', '', '', 'default_profil.png');

-- Insertion Compte Admin (user : 'admin', pass : 'password_admin')
-- Pense à changer le hash avec un vrai mot de passe !
INSERT INTO admins (username, password_hash) VALUES
    ('admin', '$2y$10$/eShQXa8QCAFswSbBsQDueuAUP/20liq8fOPek7Kd4cgBsrJ6NSVy');