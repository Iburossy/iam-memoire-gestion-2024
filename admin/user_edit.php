<?php
// Vérifier si l'ID de l'étudiant est spécifié dans l'URL
if(isset($_GET['id'])) {
    // Inclure le fichier de connexion à la base de données
    require_once("../bd.php");

    // Récupérer et valider l'ID de l'étudiant depuis l'URL
    $etudiant_id = intval($_GET['id']);
    if($etudiant_id <= 0) {
        // Rediriger vers une page d'erreur si l'ID de l'étudiant n'est pas valide
        header("Location: erreur.php");
        exit();
    }

    // Construire la requête SQL pour récupérer les informations de l'étudiant
    $sql = "SELECT nom, email, niveau_etude FROM etudiants WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $etudiant_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'étudiant existe dans la base de données
    if ($result->num_rows > 0) {
        // Récupérer les données de l'étudiant
        $etudiant = $result->fetch_assoc();
    } else {
        // Rediriger vers une page d'erreur si l'étudiant n'est pas trouvé
        header("Location: erreur.php");
        exit();
    }

    // Fermer la connexion à la base de données
    $connexion->close();
} else {
    // Rediriger vers une page d'erreur si l'ID de l'étudiant n'est pas spécifié
    header("Location: erreur.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Étudiant</title>
    
    <link rel="stylesheet" href="../css/update.css">
    </head>
    <body>
    <h1 class="titre"> <a href="admin_dashboard.php"><button> Home</button></a> <br> Modifier Étudiant</h1>

    <form action="etudiant_mod.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $etudiant_id; ?>">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $etudiant['nom']; ?>"><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo $etudiant['email']; ?>"><br>
        <label for="niveau_etude">Niveau d'étude :</label>
        <input type="text" id="niveau_etude" name="niveau_etude" value="<?php echo $etudiant['niveau_etude']; ?>"><br>
        <button type="submit">Modifier</button>
    </form>
    </body>
</html>

