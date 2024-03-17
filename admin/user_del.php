<?php
// Vérifier si l'ID de l'étudiant est spécifié dans la requête POST
if(isset($_POST['id'])) {
    // Inclure le fichier de connexion à la base de données
    require_once("../bd.php");

    // Récupérer et valider l'ID de l'étudiant depuis la requête POST
    $etudiant_id = intval($_POST['id']);
    if($etudiant_id <= 0) {
        // Rediriger vers une page d'erreur si l'ID de l'étudiant n'est pas valide
        echo("l'ID de l'étudiant n'est pas valide");
        exit();
    }

    // Construire la requête SQL pour supprimer l'étudiant
    $sql = "DELETE FROM etudiants WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $etudiant_id);
    $stmt->execute();

    // Rediriger vers une page de confirmation ou de liste des étudiants après suppression
    header("Location: gestion_users.php?=user_supprimé");
    exit();
} else {
    // Rediriger vers une page d'erreur si l'ID de l'étudiant n'est pas spécifié
    echo("l'ID de l'étudiant n'est pas spécifié ");
    exit();
}
?>
