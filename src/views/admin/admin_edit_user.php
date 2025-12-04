<?php
// 1. Récupérer l'utilisateur qu'on veut modifier (par exemple ID 42)
$id_user_a_modifier = $_GET['id']; 
$userStmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$userStmt->execute([$id_user_a_modifier]);
$user = $userStmt->fetch();

// 2. Récupérer la liste de TOUS les groupes pour le menu déroulant
$groupsStmt = $pdo->query("SELECT group_id, name FROM groups");
$allGroups = $groupsStmt->fetchAll();

// 3. Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newGroupId = $_POST['group_id'];
    
    // Mise à jour
    $updateStmt = $pdo->prepare("UPDATE users SET group_id = ? WHERE user_id = ?");
    $updateStmt->execute([$newGroupId, $id_user_a_modifier]);
    
    echo "Utilisateur déplacé vers le nouveau groupe !";
    // Rafraichir la page pour voir le changement
    header("Refresh:0"); 
}
?>

<form method="POST">
    <label>Changer le groupe de <?php echo $user['user_firstname']; ?> :</label>
    
    <select name="group_id">
        <option value="">-- Aucun groupe --</option>
        <?php foreach ($allGroups as $g): ?>
            <option value="<?= $g['group_id'] ?>" 
                <?= ($user['group_id'] == $g['group_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($g['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <button type="submit">Enregistrer</button>
</form>