
<?php
// Vérifier si l'ID du mémoire à supprimer est envoyé via POST
if(isset($_POST['id'])) {
    // Inclure le fichier de connexion à la base de données
    require_once("../bd.php");

    // Récupérer et valider l'ID du mémoire à supprimer
    $memoire_id = intval($_POST['id']);
    if($memoire_id <= 0) {
        // Rediriger vers une page d'erreur si l'ID du mémoire n'est pas valide
        header("Location: erreur.php");
        exit();
    }

    // Supprimer toutes les références à ce mémoire dans les tables liées
    $sql_delete_admin_memoires = "DELETE FROM Admin_Memoires WHERE memoire_id = ?";
    $stmt_delete_admin_memoires = $connexion->prepare($sql_delete_admin_memoires);
    $stmt_delete_admin_memoires->bind_param("i", $memoire_id);
    $stmt_delete_admin_memoires->execute();

    $sql_delete_etudiant_memoires = "DELETE FROM Etudiant_Memoires WHERE memoire_id = ?";
    $stmt_delete_etudiant_memoires = $connexion->prepare($sql_delete_etudiant_memoires);
    $stmt_delete_etudiant_memoires->bind_param("i", $memoire_id);
    $stmt_delete_etudiant_memoires->execute();

    // Supprimer le mémoire lui-même de la table Memoires
    $sql_delete_memoire = "DELETE FROM Memoires WHERE id = ?";
    $stmt_delete_memoire = $connexion->prepare($sql_delete_memoire);
    $stmt_delete_memoire->bind_param("i", $memoire_id);

    // Exécuter les requêtes de suppression
    if($stmt_delete_memoire->execute()) {
        // Rediriger vers la page principale avec un message de succès
        header("Location: deletmod.php?success=1");
        exit();
    } else {
        // Rediriger vers la page principale avec un message d'erreur
        header("Location: deletmod.php?error=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des mémoires</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: burlywood;

        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
       
        .titre{
            text-align: center;
            margin-top: 20px;
            color: #333;

        }
    </style>
</head>
<body>
    <h1 class="titre"> <a href="admin_dashboard.php"><button> Home</button></a> <br> Liste des mémoires</h1>
    <?php
    // Inclure le fichier de connexion à la base de données
    require_once("../bd.php");

    // Récupérer les mémoires depuis la base de données
    $sql = "SELECT m.id, m.titre, m.niveau, t.nom AS theme, d.nom AS domaine
            FROM Memoires m
            LEFT JOIN Themes t ON m.theme_id = t.id
            LEFT JOIN Domaines d ON m.domaine_id = d.id";
    $result = $connexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Titre</th><th>Theme</th><th>Domaine</th><th>Niveau</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["titre"] . "</td>";
            echo "<td>" . $row["theme"] . "</td>";
            echo "<td>" . $row["domaine"] . "</td>";
            echo "<td>" . $row["niveau"] . "</td>";
            echo "<td>";
            echo "<form action='modifier_memoire.php' method='GET'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<button type='submit' class='edit-btn'>Modifier</button>";
            echo "</form>";
            echo "<form action='deletmod.php' method='POST'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<button type='submit' class='delete-btn'>Supprim</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun mémoire trouvé.";
    }

    // Fermer la connexion à la base de données
    $connexion->close();
    ?>
</body>
</html>
