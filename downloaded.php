<?php
// Assurez-vous que l'ID du mémoire est spécifié dans l'URL
if(isset($_GET['id'])) {
    // Inclure le fichier de connexion à la base de données
    require_once("bd.php");

    // Récupérer et valider l'ID du mémoire depuis l'URL
    $memoire_id = intval($_GET['id']);
    if($memoire_id <= 0) {
        // Rediriger vers une page d'erreur si l'ID du mémoire n'est pas valide
        header("Location: erreur.php");
        exit();
    }

    // Construire la requête SQL pour récupérer les informations du mémoire
    $sql = "SELECT fichier FROM memoires WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $memoire_id);
    $stmt->execute();
    $stmt->store_result();

    // Vérifier si le mémoire existe dans la base de données
    if($stmt->num_rows > 0) {
        // Liaison des résultats de la requête
        $stmt->bind_result($fichier);
        $stmt->fetch();

        // Définir les en-têtes pour le téléchargement
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($fichier) . '"');

        // Lire le fichier et le transmettre au navigateur
        echo $fichier;
        exit();
    } else {
        // Rediriger vers une page d'erreur si le mémoire n'est pas trouvé
        header("Location: erreur.php");
        exit();
    }
} else {
    // Rediriger vers une page d'erreur si l'ID du mémoire n'est pas spécifié
    echo("<script> alert('ID du mémoire non spécifié');</script>");
    exit();
}
?>
