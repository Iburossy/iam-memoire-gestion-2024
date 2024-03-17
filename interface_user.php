

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord étudiant</title>
    <link rel="stylesheet" href="css/ui.css">
</head>

<body>
<div class="container">
        <h1 class="titre">Tableau de bord étudiant</h1>        
        <!-- Section pour rechercher les mémoires -->
       
<div class="section">
    <h2>Trouver un mémoires ou <a href="mem_ajout.php"> <button onclick="ajouterMemoire()">ajouter un mémoire</button></a></h2>
    <form id="formRecherche" action="interface_user.php" method="GET">
        <label for="selectTheme">Thème :</label>
        
            <!-- gestion de theme -->
            <select id="selectTheme" name="theme">
            <option value="">Sélectionner un thème</option>
            <?php
            require_once("bd.php"); 
            // Récupérer les thèmes depuis la base de données
            $result = $connexion->query("SELECT id, nom FROM Themes");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
            }
            ?>
            </select>

            <!-- gestion de domaines -->
             <label for="selectDomaine">Domaine :</label>
            <select id="selectDomaine" name="domaine">
            <option value="">Sélectionner un domaine</option>
            <!-- Options de domaines affichées ici -->
            <?php
            // Récupérer les domaines depuis la base de données
            $result = $connexion->query("SELECT id, nom FROM Domaines");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
            }
            ?>
          </select>

            <label for="titreMemoire">Titre du mémoire :</label>
            <input type="text" id="titreMemoire" name="titreMemoire">
            <button type="submit">Rechercher</button>

        </form>
    </div>
    </div>
    
    <script src="script.js"></script>

    <?php

require_once("bd.php");

// Traitement de la recherche de mémoires
if(isset($_GET['titreMemoire'])) {
    // Récupérer les valeurs de recherche
    $theme = $_GET['theme'];
    $domaine = $_GET['domaine'];
    $titreMemoire = $_GET['titreMemoire'];
    
    // Construire la requête SQL pour la recherche
    $sql = "SELECT m.id, m.titre, m.description, m.fichier, t.nom AS theme, d.nom AS domaine
            FROM Memoires m
            LEFT JOIN Themes t ON m.theme_id = t.id
            LEFT JOIN Domaines d ON m.domaine_id = d.id
            WHERE 1=1";
    
    // Ajouter les conditions de recherche si des critères sont spécifiés
    if(!empty($theme)) {
        $sql .= " AND m.theme_id = $theme";
    }
    if(!empty($domaine)) {
        $sql .= " AND m.domaine_id = $domaine";
    }
    if(!empty($titreMemoire)) {
        $sql .= " AND m.titre LIKE '%$titreMemoire%'";
    }
    
    // Exécuter la requête
    $result = $connexion->query($sql);
    
    // Vérifier si des mémoires ont été trouvées
    if ($result->num_rows > 0) {
        // Afficher les mémoires trouvées
        echo "<div class='resultat_recherche'>";
        echo "<h2 >Résultats de la recherche</h2>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='memoire'>";
            echo "<h3>" . $row["titre"] . "</h3>";
            echo "<p><strong>Thème:</strong> " . $row["theme"] . "</p>";
            echo "<p><strong>Domaine:</strong> " . $row["domaine"] . "</p>";
            echo "<p><strong>Description:</strong> " . $row["description"] . "</p>";
            // Lien de téléchargement du mémoire
            echo "<a href='downloaded.php?id=" . $row["id"] . "' download>Télécharger le mémoire</a>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<div class='section'>";
        echo "<p>Aucun mémoire trouvé.</p>";
        echo "</div>";
    }
    $connexion->close();
}
?>
</body>
</html>



