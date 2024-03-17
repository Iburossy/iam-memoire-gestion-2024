<?php
// Vérifier si l'ID du mémoire est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    // Inclure le fichier de connexion à la base de données
    require_once("../bd.php");

    // Récupérer l'ID du mémoire à modifier depuis l'URL
    $memoire_id = $_GET['id'];

    // Vérifier si le formulaire de modification a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données soumises par le formulaire
        $titre = $_POST["titre"];
        $theme_nom = $_POST["theme_nom"];
        $description = $_POST["description"];
        
        // Préparer la requête de mise à jour dans la base de données
        $sql = "UPDATE Memoires SET titre=?, description=? WHERE id=?";

        // Préparer la requête avec PDO pour éviter les injections SQL
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("ssi", $titre, $description, $memoire_id);

        // Exécuter la requête
        if ($stmt->execute()) {
            // Mettre à jour le nom du thème dans la table Themes
            $update_sql = "UPDATE Themes SET nom=? WHERE id=?";
            $update_stmt = $connexion->prepare($update_sql);
            $update_stmt->bind_param("si", $theme_nom, $memoire['theme_id']);
            $update_stmt->execute();

            // Rediriger vers la page principale avec un message de succès
            header("Location: deletmod.php?success=1");
            exit();
        } else {
            // Rediriger vers la page principale avec un message d'erreur
            header("Location: index.php?error=1");
            exit();
        }
    } else {
        // Récupérer les informations du mémoire depuis la base de données
        $sql = "SELECT m.titre, m.description, t.nom AS theme_nom FROM Memoires m JOIN Themes t ON m.theme_id = t.id WHERE m.id=?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("i", $memoire_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $memoire = $result->fetch_assoc();
    }
} else {
    // Rediriger vers une page d'erreur si l'ID du mémoire n'est pas spécifié
    header("Location: erreur.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Mémoire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: burlywood;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 100px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
    <link rel="stylesheet" href="">
</head>
<body>
<h1 class="titre"> <a href="admin_dashboard.php"><button> Home</button></a> <br> Modifier Mémoire</h1>
    <div class="container">    
        <form action="modifier_memoire.php?id=<?php echo $memoire_id; ?>" method="POST">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" value="<?php echo $memoire['titre']; ?>">
            <label for="theme_nom">Nom du Thème :</label>
            <input type="text" id="theme_nom" name="theme_nom" value="<?php echo $memoire['theme_nom']; ?>">
            <label for="description">Description :</label>
            <textarea id="description" name="description"><?php echo $memoire['description']; ?></textarea>
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$connexion->close();
?>
