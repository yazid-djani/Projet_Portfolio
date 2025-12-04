<?php
namespace App\Models;

use App\Lib\Database;

class Utilisateur {
    private $id;
    private $firstname;
    private $lastname;
    private $age;
    private $email;
    private $password;
    protected $role;
    private $status;
    private $can_create_quiz;
    
    // NOUVEAU : Code de groupe (pour lier des élèves à une école/entreprise)
    private $group_code;

    public function __construct(array $data) {
        $this->id = $data['user_id'] ?? $data['id'] ?? null;
        $this->firstname = $data['user_firstname'] ?? $data['firstname'] ?? '';
        $this->lastname = $data['user_lastname'] ?? $data['lastname'] ?? '';
        $this->email = $data['user_email'] ?? $data['email'] ?? '';
        $this->age = $data['user_age'] ?? $data['age'] ?? 0;
        $this->password = $data['password_hash'] ?? $data['password'] ?? '';
        $this->role = $data['role'] ?? "utilisateur";
        $this->status = $data['status'] ?? "active";
        $this->can_create_quiz = $data['can_create_quiz'] ?? 0;
        
        // Initialisation du code groupe
        $this->group_code = $data['group_code'] ?? null;
    }

    // --- GETTERS ---
    public function getId() { return $this->id; }
    public function getFirstname() { return $this->firstname; }
    public function getLastname() { return $this->lastname; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getRole() { return $this->role; }
    public function isActive() { return $this->status === 'active'; }
    public function canCreateQuiz() { return $this->can_create_quiz == 1; }
    
    // Getter pour le groupe
    public function getGroupCode() { return $this->group_code; }

    // --- VÉRIFICATION MOT DE PASSE ---
    public function verifyPassword($password){
        return password_verify($password, $this->password);
    }

    // --- SAUVEGARDE EN BDD ---
    public function save(){
        $pdo = Database::getPDO();
        
        // Ajout de 'group_code' dans la requête
        $sql = "INSERT INTO users (user_firstname, user_lastname, user_email, user_age, password_hash, role, status, can_create_quiz, group_code) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            $this->firstname,
            $this->lastname,
            $this->email,
            $this->age,
            $this->password,
            $this->role,
            $this->status,
            $this->can_create_quiz,
            $this->group_code // Insertion du code groupe
        ]);
    }

    // --- FACTORY : TROUVER UTILISATEUR PAR EMAIL ---
    public static function findByEmail(string $email): ?Utilisateur
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch();

        if (!$data) return null;

        switch ($data['role']) {
            case 'ecole':
                return new Ecole($data);
            case 'entreprise':
                return new Entreprise($data);
            case 'admin':
                return new Administrateur($data);
            default:
                return new Utilisateur($data);
        }
    }
}
?>