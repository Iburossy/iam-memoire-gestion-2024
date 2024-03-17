 <!-- MODIFICATION DE L'USER -->
 <?php
// Vérifier si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs nécessaires sont présents dans la requête POST
    if (isset($_POST['id'], $_POST['nom'], $_POST['email'], $_POST['niveau_etude'])) {
        // Inclure le fichier de connexion à la base de données
        require_once("../bd.php");

        // Récupérer et valider l'ID de l'étudiant
        $etudiant_id = intval($_POST['id']);
        if ($etudiant_id <= 0) {
            // Rediriger vers une page d'erreur si l'ID de l'étudiant n'est pas valide
            echo("l'ID de l'étudiant n'est pas valide pour le mofidier");
            exit();
        }

        // Récupérer et valider les données de l'étudiant
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $niveau = $_POST['niveau_etude'];

        // Construire la requête SQL pour mettre à jour les informations de l'étudiant
        $sql = "UPDATE etudiants SET nom = ?, email = ?, niveau_etude = ? WHERE id = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("sssi", $nom, $email, $niveau, $etudiant_id);

        // Exécuter la requête de mise à jour
        if ($stmt->execute()) {
            // Rediriger vers une page de confirmation ou de liste des étudiants après la modification
            header("Location: gestion_users.php?=Succes");
            exit();
        } else {
            // Rediriger vers une page d'erreur en cas d'échec de la mise à jour
            header("Location:  gestion_users.php?=user_non_modifie");
            exit();
        }
    } else {
        // Rediriger vers une page d'erreur si les champs nécessaires ne sont pas présents dans la requête POST
        echo("Toutes les champs nécessaires ne sont pas présents dans la requête POST");
        exit();
    }
} 
?>