<?php 
namespace App\Controllers;
use App\Models\Utilisateur;

class UtilisateurController {
    
    public function pageAuth($mode = 'login') {
        $containerClass = ($mode === 'register') ? 'active' : '';
        require __DIR__ . '/../views/connexion_inscription.php';
    }
    
    public function inscription() : void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?route=inscription");
            exit;
        }

        // Gestion du rôle
        $rolePost = $_POST['role'] ?? 'utilisateur';
        $rolesAutorises = ['utilisateur', 'ecole', 'entreprise'];
        
        if (!in_array($rolePost, $rolesAutorises)) {
            $rolePost = 'utilisateur';
        }

        // --- DEBUT DE LA MODIFICATION POUR LE GROUPE ---
        
        // 1. Récupération du code saisi
        $groupCode = !empty($_POST['group_code']) ? strtoupper(trim(htmlspecialchars($_POST['group_code']))) : null;
        $groupIdTrouve = null;

        // 2. Vérification s'il y a un code
        if ($groupCode) {
            // Appel de la méthode statique du Modèle
            $groupIdTrouve = Utilisateur::verifierCodeGroupe($groupCode);

            // Si le code est incorrect (la méthode renvoie false)
            if (!$groupIdTrouve) {
                $msg = "Le code groupe '{$groupCode}' est invalide.";
                header("Location: index.php?route=inscription&error=" . urlencode($msg));
                exit; // On arrête tout ici
            }
        }
        // --- FIN DE LA MODIFICATION ---

        $data = [
            "user_firstname"  => htmlspecialchars($_POST['prenom'] ?? ''),
            "user_lastname"   => htmlspecialchars($_POST['nom'] ?? ''),
            "user_email"      => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            "user_age"        => (int) ($_POST['age'] ?? 0),
            "password_hash"   => password_hash($_POST['password'], PASSWORD_BCRYPT),
            "role"            => $rolePost,
            "status"          => "active",
            "can_create_quiz" => 0,
            "group_id"        => $groupIdTrouve // On passe l'ID validé (ou null)
        ];

        $user = new Utilisateur($data);
        
        try {
            if($user->save()) {
                header("Location: index.php?route=connexion&success=1");
            } else {
                header("Location: index.php?route=inscription&error=Erreur technique");
            }
        } catch (\Exception $e) {
            // Gestion erreur duplication email
            if ($e->getCode() == 23000) {
                $msg = "Cet email est déjà utilisé.";
            } else {
                $msg = "Erreur : " . $e->getMessage();
            }
            header("Location: index.php?route=inscription&error=" . urlencode($msg));
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
            header("Location: index.php?route=connexion&error=login_failed");
            exit;
        }

        // Si l'utilisateur est désactivé
        if (!$user->isActive()) {
            header("Location: index.php?route=connexion&error=account_disabled");
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
        header("Location: index.php?route=connexion");
        exit;
    }
}
?>