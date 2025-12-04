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
            header("Location: index.php?route=accueil");
            exit;
        }

        // 1. GESTION DU RÔLE
        // On récupère le rôle choisi ou on met 'utilisateur' par défaut
        $rolePost = $_POST['role'] ?? 'utilisateur';
        
        // Liste blanche des rôles autorisés à l'inscription (Admin est INTERDIT ici)
        $rolesAutorises = ['utilisateur', 'ecole', 'entreprise'];
        
        // Si le rôle envoyé n'est pas dans la liste, on force 'utilisateur'
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
            "role"            => $rolePost,     // Le rôle choisi (sécurisé)
            "status"          => "active",
            "can_create_quiz" => 0              // IMPORTANT : 0 par défaut, seul l'admin pourra le changer
        ];

        $user = new Utilisateur($data);
        
        // 3. SAUVEGARDE EN BDD
        try {
            if($user->save()) {
                // Succès : redirection vers la page de connexion avec message
                header("Location: index.php?route=accueil&success=1");
            } else {
                // Erreur générique
                header("Location: index.php?route=accueil&error=1");
            }
        } catch (\Exception $e) {
            // Erreur SQL (ex: email déjà pris)
            header("Location: index.php?route=accueil&error=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function connexion(){
        // SÉCURITÉ : Empêche le crash si on accède à cette page sans soumettre le formulaire
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?route=accueil");
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? ''; 

        if (empty($email) || empty($password)) {
            header("Location: index.php?route=accueil&error=missing_fields");
            exit;
        }

        $user = Utilisateur::findByEmail($email);

        if (!$user || !$user->verifyPassword($password)) {
            header("Location: index.php?route=accueil&error=login_failed");
            exit;
        }

        // Connexion réussie : On stocke les infos en session
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_email'] = $user->getEmail(); 
        $_SESSION['role'] = $user->getRole(); 

        // Redirection intelligente selon le rôle
        if ($user->getRole() === 'admin') {
            header("Location: index.php?route=admin_users");
        } else {
            // École, Entreprise ou Utilisateur vont vers le dashboard standard
            // Le dashboard gérera l'affichage spécifique selon le rôle
            header("Location: index.php?route=dashboard");
        }
        exit;
    }

    public function deconnexion(){
        session_destroy();
        header("Location: index.php?route=accueil");
        exit;
    }
}
?>