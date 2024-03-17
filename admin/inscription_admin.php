<?php
// Inclure le fichier de connexion à la base de données
require_once("../bd.php");

// Traitement de l'inscription d'un étudiant
if(isset($_POST['inscription_admin'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $passwords = $_POST['passwords'];
    
    // Hashage du mot de passe
    $hashed_password = password_hash($passwords, PASSWORD_DEFAULT);
    
    // Requête SQL pour insérer l'étudiant dans la table
    $requete = $connexion->prepare("INSERT INTO admins (nom, email, passwords) VALUES (?, ?, ?)");
    $requete->bind_param("sss", $nom, $email, $hashed_password);
    
    if ($requete->execute()) {
        // Rediriger l'étudiant vers la page de connexion
        header("Location: index.php");
        exit(); // Assurez-vous d'arrêter le script après la redirection
    } else {
        echo "Erreur lors de l'inscription.";
    }
    
    // Fermeture de la requête
    $requete->close();
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/connexion.css">
  <title>Inscription</title>
</head>
<body>
  
<div class="container">
    <div class="form_area">
        <p class="title">Inscription Admin</p>
        <form action="inscription_admin.php" method="post">
            <div class="form_group">
                <label class="sub_title" for="nom">Nom</label>
                <input placeholder="Nom et Prenom" class="form_style" type="text" name="nom">
            </div>

            <div class="form_group">
                <label class="sub_title" for="email">Email</label>
                <input placeholder="Entrez votre mail" id="email" class="form_style" type="email" name="email">
            </div>
            <div class="form_group">
                <label class="sub_title" for="passwords">Password</label>
                <input placeholder="Votre password" id="password" class="form_style" type="password" name="passwords">
            </div>
            <div>
            <button class="btn" name="inscription_admin">S'inscrire</button>

                <p>Deja un compte ? <a class="link" href="index.php">Se connecter !</a></p>
        
        
    </form>
</div>
</div>

</body>
</html>