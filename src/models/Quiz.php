<?php
namespace App\Models;
use App\Lib\Database;

class Quiz{
    private $id_quiz;
    private $user_id;
    private $titre;
    private $description;
    private $statut;
    private $proprietaire;
    private $visibility; // NOUVEAU
    private $date_lancement;
    private $date_cloture;
    private $created_at;
    
    public function __construct(array $data){
        $this->id_quiz          = $data['id_quiz'] ?? null;
        $this->user_id          = $data['user_id'];
        $this->titre            = $data['titre'];
        $this->description      = $data['description'] ?? null;
        $this->statut           = $data['statut'] ?? 'brouillon';
        $this->proprietaire     = $data['proprietaire'] ?? 'utilisateur';
        $this->visibility       = $data['visibility'] ?? 'public'; // Par défaut public
        $this->date_lancement   = !empty($data['date_lancement']) ? $data['date_lancement'] : null;
        $this->date_cloture     = !empty($data['date_cloture']) ? $data['date_cloture'] : null;
        $this->created_at       = $data['created_at'] ?? null;
    }

    public function getId() { return $this->id_quiz; }
    public function getTitre() { return $this->titre; }
    public function getVisibility() { return $this->visibility; }

    public function save() {
        $pdo = Database::getPDO();
        // Ajout de 'visibility' dans l'INSERT
        $sql = "INSERT INTO quiz (user_id, titre, description, proprietaire, status, visibility, date_lancement, date_cloture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->user_id,
            $this->titre,
            $this->description,
            $this->proprietaire,
            $this->statut,
            $this->visibility, // Sauvegarde de la visibilité
            $this->date_lancement,
            $this->date_cloture
        ]);
    }

    public static function quizByUser($user_id) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM quiz WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    
    public static function getLastId() {
        return Database::getPDO()->lastInsertId();
    }

    /**
     * NOUVEAU : Récupère les quiz visibles pour un utilisateur donné.
     * - Les quiz PUBLIC
     * - Les quiz PRIVÉS dont le créateur a le MÊME group_code que l'utilisateur
     */
    public static function getAvailableQuizzesForUser($user) {
        $pdo = Database::getPDO();
        
        // Si l'utilisateur n'est pas connecté ou n'a pas de groupe
        $userGroup = ($user) ? $user->getGroupCode() : null;

        if (empty($userGroup)) {
            // Uniquement les quiz publics
            $sql = "SELECT * FROM quiz WHERE status = 'published' AND visibility = 'public' ORDER BY created_at DESC";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll();
        } else {
            // Publics + Privés du même groupe
            $sql = "SELECT q.* FROM quiz q
                    JOIN users u ON q.user_id = u.user_id
                    WHERE q.status = 'published' 
                    AND (
                        q.visibility = 'public' 
                        OR 
                        (q.visibility = 'private' AND u.group_code = ?)
                    )
                    ORDER BY q.created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userGroup]);
            return $stmt->fetchAll();
        }
    }
}
?>