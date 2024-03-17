<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure le fichier de connexion à la base de données
    require_once("bd.php");

    // Récupérer les données soumises par le formulaire
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $theme_id = $_POST["theme"];
    $domaine_id = $_POST["domaine"];
    $niveau = $_POST["niveau"];
    $date_ajout = date("Y-m-d"); // Date d'ajout du mémoire

    // Vérifier si un fichier a été uploadé
    if(isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
        // Chemin où enregistrer le fichier uploadé
        $uploadsDirectory = "uploads/";

        // Obtenir le nom et l'extension du fichier
        $fileName = basename($_FILES['fichier']['name']);

        // Déplacer le fichier uploadé vers le répertoire des uploads
        $targetPath = $uploadsDirectory . $fileName;
        move_uploaded_file($_FILES['fichier']['tmp_name'], $targetPath);
    } else {
        // Aucun fichier n'a été uploadé ou une erreur s'est produite
        $targetPath = null; // Définir le chemin du fichier sur null
    }

    // Préparer la requête d'insertion dans la base de données
    $sql = "INSERT INTO Memoires (titre, description, fichier, theme_id, domaine_id, date_ajout, niveau) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Préparer la requête avec PDO pour éviter les injections SQL
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("sssiiss", $titre, $description, $targetPath, $theme_id, $domaine_id, $date_ajout, $niveau);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Rediriger vers la page principale avec un message de succès
        header("Location: interface_user.php?success=1");
        exit();
    } else {
        // Rediriger vers la page principale avec un message d'erreur
        echo("Erreur donnee non envoye");
        exit();
    }

    // Fermer la connexion à la base de données
    $connexion->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord administrateur</title>
    <style>
        body {
            background-color: burlywood;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 20 20" fill="%23777"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.7083 7.95833H4.29167l5.20833-5.20833c.195-0.195 0.195-0.512 0-0.708-0.195-0.195-0.512-0.195-0.708 0L2.373 7.373c-0.195 0.195-0.195 0.512 0 0.707l7.415 7.415c0.195 0.195 0.512 0.195 0.707 0l7.415-7.415c0.195-0.195 0.195-0.512 0-0.707-0.195-0.195-0.512-0.195-0.708 0L15.7083 7.95833z"/></svg>');
            background-size: 12px;
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            padding-right: 30px;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1 class="titre"> <a href="interface_user.php"><button> Home</button></a> <br> Ajouter un mémoire en tant qu'etudiant</h1>
    
    <!-- Formulaire pour ajouter un nouveau mémoire -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre">
        <label for="description">Description :</label>
        <textarea id="description" name="description"></textarea>
        <label for="theme">Thème :</label>
        <select id="theme" name="theme">
            <?php
            // Récupérer les thèmes depuis la base de données
            require_once("bd.php");
            $result = $connexion->query("SELECT id, nom FROM Themes");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
            }
            ?>
        </select>
        <label for="domaine">Domaine :</label>
        <select id="domaine" name="domaine">
            <?php
            // Récupérer les domaines depuis la base de données
            $result = $connexion->query("SELECT id, nom FROM Domaines");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
            }
            ?>
        </select>
        <label for="niveau">Niveau :</label>
        <select id="niveau" name="niveau">
            <option value="licence">Licence</option>
            <option value="master1">Master 1</option>
            <option value="master2">Master 2</option>
        </select>
        <label for="fichier">Fichier :</label>
        <input type="file" id="fichier" name="fichier">
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>

