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
    
    // NOUVELLE PROPRIÉTÉ
    private $can_create_quiz;

    // INITIALISATION DES DONNÉES
    public function __construct(array $data) {
        // Gestion des alias pour supporter les noms de colonnes BDD (user_*) ou les noms simples
        $this->id = $data['user_id'] ?? $data['id'] ?? null;
        $this->firstname = $data['user_firstname'] ?? $data['firstname'] ?? '';
        $this->lastname = $data['user_lastname'] ?? $data['lastname'] ?? '';
        $this->email = $data['user_email'] ?? $data['email'] ?? '';
        $this->age = $data['user_age'] ?? $data['age'] ?? 0;
        $this->password = $data['password_hash'] ?? $data['password'] ?? '';
        $this->role = $data['role'] ?? "utilisateur";
        $this->status = $data['status'] ?? "active";
        $this->can_create_quiz = $data['can_create_quiz'] ?? 0;
    }

    // --- GETTERS ---
    public function getId() { return $this->id; }
    public function getFirstname() { return $this->firstname; }
    public function getLastname() { return $this->lastname; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getRole() { return $this->role; }
    
    public function isActive() { 
        return $this->status === 'active'; 
    }

    // NOUVEAU GETTER POUR LA PERMISSION
    public function canCreateQuiz() { 
        return $this->can_create_quiz == 1; 
    }

    // --- VÉRIFICATION MOT DE PASSE ---
    public function verifyPassword($password){
        return password_verify($password, $this->password);
    }

    // --- SAUVEGARDE EN BDD ---
    public function save(){
        $pdo = Database::getPDO();
        
        // Ajout de la colonne 'can_create_quiz' dans la requête
        $sql = "INSERT INTO users (user_firstname, user_lastname, user_email, user_age, password_hash, role, status, can_create_quiz) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            $this->firstname,
            $this->lastname,
            $this->email,
            $this->age,
            $this->password,
            $this->role,
            $this->status,
            $this->can_create_quiz // Insertion de la valeur (0 ou 1)
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

        // Retourne la bonne classe enfant selon le rôle
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