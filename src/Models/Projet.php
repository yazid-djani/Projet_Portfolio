<?php
namespace App\Models;
use App\Lib\Database;

class Projet
{
    /**
     * Récupère TOUS les projets triés par date
     */
    public static function findAll(): array
    {
        $pdo = Database::getPDO();
        $sql = "SELECT * FROM projets ORDER BY date_creation DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère UN projet par son ID
     */
    public static function findById(int $id): array|false
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM projets WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouveau projet
     */
    public static function create(string $titre, string $description, string $categorie, ?string $technologies = null, ?string $lien_github = null): bool
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("
                INSERT INTO projets (titre, description, categorie, technologies, lien_github, date_creation)
                VALUES (:titre, :description, :categorie, :technologies, :lien_github, NOW())
            ");
        return $stmt->execute([
            'titre'         => $titre,
            'description'   => $description,
            'categorie'     => $categorie,
            'technologies'  => $technologies,
            'lien_github'   => $lien_github,
        ]);
    }

    /**
     * Met à jour un projet existant
     */
    public static function update(int $id, string $titre, string $description, string $categorie, ?string $technologies = null, ?string $lien_github = null): bool
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("
                UPDATE projets SET titre = :titre, description = :description, categorie = :categorie,
                technologies = :technologies, lien_github = :lien_github WHERE id = :id
            ");
        return $stmt->execute([
            'id'            => $id,
            'titre'         => $titre,
            'description'   => $description,
            'categorie'     => $categorie,
            'technologies'  => $technologies,
            'lien_github'   => $lien_github,
        ]);

    }}