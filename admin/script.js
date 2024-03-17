// Fonctions JavaScript pour gérer les fonctionnalités interactives

function ajouterMemoire() {
    // Redirection vers la page d'ajout de mémoire
    window.location.href = "add_memoire.php";
}

function ajouterTheme() {
    // Récupérer le nom du thème depuis le formulaire
    var nomTheme = document.getElementById("nomTheme").value;
    // Envoyer le nom du thème à un script PHP pour l'ajout dans la base de données
    // Rafraîchir la liste des thèmes après l'ajout
}

function ajouterUtilisateur() {
    // Redirection vers la page d'ajout d'utilisateur
    window.location.href = "add_user.php";
}

// Ajoutez d'autres fonctions JavaScript pour les fonctionnalités supplémentaires
