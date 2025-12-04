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
    private $visibility;
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
        $this->visibility       = $data['visibility'] ?? 'public';
        $this->date_lancement   = !empty($data['date_lancement']) ? $data['date_lancement'] : null;
        $this->date_cloture     = !empty($data['date_cloture']) ? $data['date_cloture'] : null;
        $this->created_at       = $data['created_at'] ?? null;
    }

    public function getId() { return $this->id_quiz; }
    public function getTitre() { return $this->titre; }
    public function getVisibility() { return $this->visibility; }

    public function save() {
        $pdo = Database::getPDO();
        $sql = "INSERT INTO quiz (user_id, titre, description, proprietaire, status, visibility, date_lancement, date_cloture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->user_id,
            $this->titre,
            $this->description,
            $this->proprietaire,
            $this->statut,
            $this->visibility,
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

    public static function getAvailableQuizzesForUser($user) {
        $pdo = Database::getPDO();
        $userGroupId = ($user) ? $user->getGroupId() : null;

        if (!$userGroupId) {
            $sql = "SELECT q.*, u.user_firstname, u.user_lastname 
                    FROM quiz q
                    JOIN users u ON q.user_id = u.user_id
                    WHERE q.status = 'published' AND q.visibility = 'public'
                    ORDER BY q.created_at DESC";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll();
        } 
        else {
            $sql = "SELECT q.*, u.user_firstname, u.user_lastname 
                    FROM quiz q
                    JOIN users u ON q.user_id = u.user_id
                    WHERE q.status = 'published' 
                    AND (
                        q.visibility = 'public' 
                        OR 
                        (q.visibility = 'private' AND u.group_id = ?)
                    )
                    ORDER BY q.created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userGroupId]);
            return $stmt->fetchAll();
        }
    }
}
?>