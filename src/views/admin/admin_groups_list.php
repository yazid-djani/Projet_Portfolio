<h3>Liste des Groupes</h3>
<ul>
<?php
    // Récupérer tous les groupes
    $stmt = $pdo->query("SELECT * FROM groups ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        echo "<li>";
        echo "<strong>" . htmlspecialchars($row['name']) . "</strong> ";
        echo "(" . $row['type'] . ") - Code: " . $row['code'];
        // Lien pour voir les membres
        echo " <a href='?view_group_id=" . $row['group_id'] . "'>Voir les membres</a>";
        echo "</li>";
    }
?>
</ul>

<hr>
<?php
    if (isset($_GET['view_group_id'])) {
        $groupId = $_GET['view_group_id'];

        $stmtUsers = $pdo->prepare("SELECT user_firstname, user_lastname, user_email FROM users WHERE group_id = ?");
        $stmtUsers->execute([$groupId]);
        $users = $stmtUsers->fetchAll();

        echo "<h4>Membres du groupe sélectionné :</h4>";
        if (count($users) > 0) {
            echo "<ul>";
            foreach ($users as $user) {
                echo "<li>" . htmlspecialchars($user['user_firstname'] . " " . $user['user_lastname']) . " (" . $user['user_email'] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun utilisateur dans ce groupe.</p>";
        }
    }
?>