# Projet Quizzeo | Sacha - Leo - Yazid

## Avancement

### - Jour 1 -

Mise en place de l'arborescence du projet (vu avec le prof) :

/Bibliotheque
├── README.md                   (Vitrine du Projet)
├── composer.json               (Configuration BDD)
├── .env                        (Configuration BDD)
├── .gitignore                  (Sécurité pour push GitHub)
│
├── /annexe                     (Dossier comportant les fichiers annexe (Diagramme, UML, ...))
│ ├── Diagramme_utilisation.png
│ ├── UML_V1.png                
│ ├── UML_V2.png               
│ ├── UML_V3.png           
│ └── doc_avancement.md
│
├── /database
│ └── bdd.sql                   (Requete SQL pour BDD)
│
├── /public
│ ├── /css
│ ├── /images
│ │ ├──form_livre.php          (Formulaire Ajout/Modification)
│ │ └── liste.php               (Tableau des livres)
│ ├── /scriptJS
│ │ ├──form_livre.php          (Formulaire Ajout/Modification)
│ │ └── liste.php               (Tableau des livres)
│ ├── UML_V2.png               
│ ├── UML_V3.png           
│ └── doc_avancement.md
│
├── /public
│ ├── /emprunt
│ │ ├──form_livre.php          (Formulaire Ajout/Modification)
│ │ └── liste.php               (Tableau des livres)
│

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

Schema de presentation :
Uml
Code 
difficulté / avancement par jours et par taches