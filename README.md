# Projet_Quizzeo

1. Présentation du projet

Quizzeo est une application web permettant :
	•	la création et gestion de quiz (écoles / entreprises)
	•	la participation des utilisateurs aux quiz
	•	le calcul automatique des scores et classements
	•	la gestion d’un espace administrateur
	•	des dashboards selon le rôle de l’utilisateur

Le projet est construit en PHP, architecturé en MVC, et utilise Composer pour l’autoload.

2. Arborescence du projet
Projet_Quizzeo/
│
├── public/
│   ├── index.php           # Router principal
│   ├── connexion_inscription.php
│   ├── quiz_form.php
│   ├── resultat.php
│   ├── admin_users.php
│   └── assets/             # (CSS/JS)
│
├── src/
│   ├── Controllers/
│   │   ├── UtilisateurController.php
│   │   ├── QuizController.php
│   │   ├── GameController.php
│   │   └── AdminController.php
│   │
│   ├── Models/
│   │   ├── Utilisateur.php
│   │   ├── Administrateur.php
│   │   ├── Ecole.php
│   │   ├── Entreprise.php
│   │   ├── Quiz.php
│   │   ├── Question.php
│   │   ├── Choix.php
│   │   ├── Tentative.php
│   │   └── Reponse.php
│   │
│   └── Lib/
│       └── Database.php
│
├── database/
│   └── bdd.sql            # Structure + données de test
│
├── composer.json          # Autoload PSR-4  [oai_citation:1‡composer.json](file-service://file-EiYXWdrELtvRLR46JkRniB)
├── composer.lock
├── LICENSE
└── README.md

3. Accéder au site
 
Recherche le fichier d'installation de votre `xampp` et placer dans le fichier htdocs le dossier Quizzeo :
 
**C:\xampp\htdocs**
 
Puis depuis votre navigateur, coller l'URL ci-dessous pour accéder à la bibliothèque :
localhost/Rendu_Projet_Final/Quizzeo

4. Installation de la base de données

Le fichier SQL complet se trouve dans :

database/bdd.sql

Il contient :
	•	création de la base
	•	création des tables
	•	insertion de l’admin
	•	insertion de 10 utilisateurs
	•	insertion de quiz, questions, choix

Ces données son a inétégré dans le logiciel phpmyadmin.

5. Fonctionnement général (MVC)

Front Controller

Le fichier public/index.php joue le rôle de router principal :
	•	il charge l’autoload
	•	initialise l’environnement
	•	lit $_GET['route']
	•	appelle la méthode du bon contrôleur (login, register, dashboard…)
(basé sur le fichier présent dans ton projet)

⸻

Modèles (src/Models)

Chaque modèle correspond à une table SQL :
	•	Utilisateur.php → table users
	•	Quiz.php → table quiz
	•	Question.php → table question
	•	Choix.php → table choix
	•	Tentative.php → table tentative
	•	Reponse.php → table reponse

Ils contiennent :
	•	l’intégration via $data
	•	les getters
	•	les méthodes SQL (save(), findById(), etc.)

⸻

Contrôleurs (src/Controllers)

Chaque contrôleur gère une partie du site :
	•	UtilisateurController → inscription, connexion, déconnexion
	•	QuizController → création + affichage quiz
	•	AdminController → gestion utilisateurs & quiz
	•	GameController → exécution d’un quiz et enregistrement des réponses

6. Comptes de test disponibles

D’après bdd.sql :
      Email                 Mot de passe                   Rôle
admin@quizzeo.com             admin123                     admin
Plusieurs utilisateurs          123            utilisateur / école / entreprise

7. Tests fonctionnels

Vérifier :
	•	accès login → oui
	•	inscription d’un utilisateur → OK
	•	création de quiz → tout fonctionne
	•	participation → enregistre tentative + réponses
	•	dashboard admin → liste des utilisateurs
	•	dashboard école / entreprise → liste des quiz




