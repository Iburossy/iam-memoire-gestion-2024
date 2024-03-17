<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
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
<h1 class="titre"> <a href="admin_dashboard.php"><button> Home</button></a> <br> Gestions Des Etudiants</h1>
    <?php
    // Inclure le fichier de connexion à la base de données
    require_once("../bd.php");

    // Récupérer les étudiants depuis la base de données
    $sql = "SELECT id, nom, email, niveau_etude FROM etudiants";
    $result = $connexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Nom</th><th>Email</th><th>Niveau d'étude</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["nom"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["niveau_etude"] . "</td>";
            echo "<td>";
            echo "<form action='user_edit.php' method='GET'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<button type='submit' class='edit-btn'>Modifier</button>";
            echo "</form>";
            echo "<form action='user_del.php' method='POST'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<button type='submit' class='delete-btn'>Supprimer</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun étudiant trouvé.";
    }

    // Fermer la connexion à la base de données
    $connexion->close();
    ?>
</body>
</html>
