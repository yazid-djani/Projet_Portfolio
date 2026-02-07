<?php
    namespace App\Lib;                                          // On définit l'espace de nom pour l'autoloader
    use PDO;                                                    // On utilise la classe native PHP pour la base de données
    use PDOException;                                                     // Pour gérer les erreurs SQL

    class Database {
        private static ?PDO $pdo = null;                        // Variable statique pour garder la connexion ouverte (Singleton)

        public static function getPDO(): PDO {                  // Récupère l'instance unique de la connexion PDO
            if (self::$pdo !== null) {                          // Si la connexion existe déjà, on la renvoie directement (gain de perf)
                return self::$pdo;
            }

            try {                                               // Sinon, on tente de créer la connexion
                $host = $_ENV['DB_HOST'] ?? 'db';               // On récupère les infos du fichier .env (ou utilise les valeurs par défaut)
                $port = $_ENV['DB_PORT'] ?? '3306';
                $dbname = $_ENV['DB_NAME'] ?? 'portfolio_db';
                $user = $_ENV['DB_USER'] ?? 'root';
                $pass = $_ENV['DB_PASS'] ?? '';

                $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";    // On construit la chaîne de connexion (DSN)

                self::$pdo = new PDO($dsn, $user, $pass, [                              // On crée l'objet PDO avec des options de sécurité
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,             // Lance une erreur si le SQL plante
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,                   // Renvoie les données sous forme de tableau associatif
                    PDO::ATTR_EMULATE_PREPARES   => false,                              // Sécurité contre les injections SQL
                ]);

                return self::$pdo;

            } catch (PDOException $e) {
                die("Erreur de connexion BDD : " . $e->getMessage());                   // Si ça échoue, on arrête tout et on affiche l'erreur
            }
        }
    }
?>