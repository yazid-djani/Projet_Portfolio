<?php
    declare(strict_types=1);

    namespace App\Lib;

    use PDO;
    use PDOException;

    class Database
    {
        public static function getPDO(): PDO
        {
            static $pdo = null;

            if ($pdo instanceof PDO) {
                return $pdo;
            }

            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $name = $_ENV['DB_NAME'] ?? 'quizzeo';
            $user = $_ENV['DB_USER'] ?? 'root';
            $pass = $_ENV['DB_PASS'] ?? '';

                $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";    // On construit la chaîne de connexion (DSN)

                self::$pdo = new PDO($dsn, $user, $pass, [                              // On crée l'objet PDO avec des options de sécurité
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,             // Lance une erreur si le SQL plante
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,                   // Renvoie les données sous forme de tableau associatif
                    PDO::ATTR_EMULATE_PREPARES   => false,                              // Sécurité contre les injections SQL
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion à la BD : " . $e->getMessage());
            }

            return $pdo;
        }
    }
?>