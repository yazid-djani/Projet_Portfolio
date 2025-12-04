<form method="POST">
    <input type="text" name="name" placeholder="Nom du groupe (ex: Classe B2)" required>
    <select name="type">
        <option value="ECOLE">École</option>
        <option value="ENTREPRISE">Entreprise</option>
    </select>
    <input type="text" name="code" placeholder="Code secret (ex: EPSI-B2)" required>
    <button type="submit">Créer le groupe</button>
</form>

<?php
// Partie PHP (Traitement)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification Admin à faire ici (if role != admin -> exit)
    
    $sql = "INSERT INTO groups (name, type, code) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$_POST['name'], $_POST['type'], $_POST['code']]);
        echo "Groupe créé avec succès !";
    } catch (PDOException $e) {
        echo "Erreur : Ce code existe probablement déjà.";
    }
}
?>