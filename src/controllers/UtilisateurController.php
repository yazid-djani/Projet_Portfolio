<?php 
namespace App\Controllers;
use App\Models\Utilisateur;

class UtilisateurController {
    
    public function inscription_form(){
        require __DIR__ . '/../views/connexion_inscription.php';
    }
    
    public function inscription() : void {
        // SÉCURITÉ : On vérifie que le formulaire a bien été soumis
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // CORRECTION : Redirection vers 'auth' car 'accueil' n'existe pas dans le routeur
            header("Location: index.php?route=auth");
            exit;
        }

        // 1. GESTION DU RÔLE
        $rolePost = $_POST['role'] ?? 'utilisateur';
        $rolesAutorises = ['utilisateur', 'ecole', 'entreprise'];
        
        if (!in_array($rolePost, $rolesAutorises)) {
            $rolePost = 'utilisateur';
        }

        // 2. PRÉPARATION DES DONNÉES
        $data = [
            "user_firstname"  => htmlspecialchars($_POST['prenom'] ?? ''),
            "user_lastname"   => htmlspecialchars($_POST['nom'] ?? ''),
            "user_email"      => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            "user_age"        => (int) ($_POST['age'] ?? 0),
            "password_hash"   => password_hash($_POST['password'], PASSWORD_BCRYPT),
            "role"            => $rolePost,
            "status"          => "active",
            "can_create_quiz" => 0
        ];

        $user = new Utilisateur($data);
        
        // 3. SAUVEGARDE EN BDD
        try {
            if($user->save()) {
                // CORRECTION : Redirection vers 'auth' avec message de succès
                header("Location: index.php?route=auth&success=1");
            } else {
                header("Location: index.php?route=auth&error=1");
            }
        } catch (\Exception $e) {
            header("Location: index.php?route=auth&error=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function connexion(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // CORRECTION : Redirection vers 'auth'
            header("Location: index.php?route=auth");
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? ''; 

        if (empty($email) || empty($password)) {
            // CORRECTION : Redirection vers 'auth'
            header("Location: index.php?route=auth&error=missing_fields");
            exit;
        }

        $user = Utilisateur::findByEmail($email);

        if (!$user || !$user->verifyPassword($password)) {
            // CORRECTION : Redirection vers 'auth'
            header("Location: index.php?route=auth&error=login_failed");
            exit;
        }

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_email'] = $user->getEmail(); 
        $_SESSION['role'] = $user->getRole(); 

        if ($user->getRole() === 'admin') {
            header("Location: index.php?route=admin_users");
        } else {
            header("Location: index.php?route=dashboard");
        }
        exit;
    }

    public function deconnexion(){
        session_destroy();
        // CORRECTION : Redirection vers 'auth' après déconnexion
        header("Location: index.php?route=auth");
        exit;
    }
}
?>