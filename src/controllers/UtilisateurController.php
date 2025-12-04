<?php 
namespace App\Controllers;
use App\Models\Utilisateur;

class UtilisateurController {
    
    /**
     * Affiche la page d'authentification (Vue unique avec Sliding Panel).
     * @param string $mode 'login' (défaut) ou 'register'
     */
    public function pageAuth($mode = 'login') {
        // La variable $containerClass sera utilisée dans la vue.
        // Si mode = 'register', on ajoute la classe 'active' pour faire glisser le panneau.
        $containerClass = ($mode === 'register') ? 'active' : '';

        require __DIR__ . '/../views/connexion_inscription.php';
    }
    
    public function inscription() : void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?route=inscription");
            exit;
        }

        $rolePost = $_POST['role'] ?? 'utilisateur';
        $rolesAutorises = ['utilisateur', 'ecole', 'entreprise'];
        
        if (!in_array($rolePost, $rolesAutorises)) {
            $rolePost = 'utilisateur';
        }

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
        
        try {
            if($user->save()) {
                // SUCCÈS : On redirige vers la page CONNEXION (mode login)
                header("Location: index.php?route=connexion&success=1");
            } else {
                // ERREUR : On reste sur INSCRIPTION (mode register)
                header("Location: index.php?route=inscription&error=1");
            }
        } catch (\Exception $e) {
            header("Location: index.php?route=inscription&error=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function connexion(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?route=connexion");
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? ''; 

        if (empty($email) || empty($password)) {
            header("Location: index.php?route=connexion&error=missing_fields");
            exit;
        }

        $user = Utilisateur::findByEmail($email);

        if (!$user || !$user->verifyPassword($password)) {
            // ERREUR : On reste sur CONNEXION
            header("Location: index.php?route=connexion&error=login_failed");
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
        // Après déconnexion, on retourne sur la page de connexion
        header("Location: index.php?route=connexion");
        exit;
    }
}
?>