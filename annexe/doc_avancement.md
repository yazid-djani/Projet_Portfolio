# Projet Quizzeo | Sacha - Leo - Yazid

## Avancement

### - Jour 1 -

Mise en place de l'arborescence du projet (vu avec le prof) :

Quizzeo_SLY/
│
├── database/
│   └── bdd.sql
│
├── public/
│   ├── css/
│   │   ├── accueil.css
│   │   └── style_con_ins.css
│   │
│   └── scriptJS/
│       └── script_con_ins.js
│
├── src/
│   ├── controllers/
│   │   ├── AdminController.php
│   │   ├── GameController.php
│   │   ├── QuizController.php
│   │   └── UtilisateurController.php
│   │
│   ├── lib/
│   │   └── Database.php
│   │
│   ├── models/
│   │   ├── Administrateur.php
│   │   ├── Choix.php
│   │   ├── Ecole.php
│   │   ├── Entreprise.php
│   │   ├── Question.php
│   │   ├── Quiz.php
│   │   ├── Reponse.php
│   │   ├── Tentative.php
│   │   └── Utilisateur.php
│   │
│   └── views/
│       ├── navbar.php       
│       ├── accueil.php
│       ├── add_question.php
│       ├── admin_users.php
│       ├── connexion_inscription.php
│       ├── dashboard.php
│       ├── play_quiz.php
│       ├── quiz_form.php
│       └── resultat.php
│
├── vendor/
├── .env
├── .gitignore
├── composer.json
├── composer.lock
├── index.php
├── LICENSE
└── README.md

Mise en place du serveur PHP et premier test
Mise en place du GitHub collectif
Ajout de vendor au projet
Création du .env comportement les données de connexion sécurisé du serveur

Premier exemplaire de L'UML du site
Premier exemplaire du diagramme d'utilisation du site
Premier exemplaire des tables SQL

### - Jour 2 -

### - Jour 3 -

### - Jour 4 -

### - Jour 5 -

=======================================
composer require vlucas/dotenv

dans le composer.json
{
  "require": {
    "vlucas/phpdotenv": "^5.6"
  },
  "autoload": {
    "psr-4": {
      "App\\": "src/"
    }
  }
}

puis 
composer dump-autoload
======================================
admin@ipssi 

Schema de presentation du powerpoint
1. Uml
2. Code 
3. difficulté / avancement par jours et par taches



.env
composer.json
composer.lock
vendor/