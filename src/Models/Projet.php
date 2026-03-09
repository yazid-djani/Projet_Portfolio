<?php
namespace App\Models;
use App\Lib\Database;

class Projet extends Model
{
    protected static string $table = 'projets';

    public static function create(string $titre, string $description, string $detail, string $categorie, ?string $technologies = null, ?string $image_url = 'default.jpg', ?string $lien_github = null): bool
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("
                INSERT INTO projets (titre, description, detail, categorie, technologies, image_url, lien_github, date_creation)
                VALUES (:titre, :description, :detail, :categorie, :technologies, :image_url, :lien_github, NOW())
            ");
        return $stmt->execute([
            'titre'         => $titre,
            'description'   => $description,
            'detail'        => $detail,
            'categorie'     => $categorie,
            'technologies'  => $technologies,
            'image_url'     => $image_url,
            'lien_github'   => $lien_github,
        ]);
    }
}