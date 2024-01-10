<?php
// Démarrage ou reprise d'une session PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Définition de la racine du script pour l'inclusion de fichiers
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = ".";
}

// Inclusion du script de gestion de base de données pour les réservations
include_once "$racine/modele/bd.reservation.inc.php";

// Initialisation de la variable pour stocker les réservations
$listeReservations = array();

// Récupération des valeurs soumises par formulaire (date et catégorie)
$date = isset($_POST['date']) ? $_POST['date'] : null;
$categorie = isset($_POST['categorie']) ? $_POST['categorie'] : null;

// Vérification si des filtres de recherche sont appliqués (date ou catégorie)
if (!empty($date) || !empty($categorie)) {
    // Récupération des réservations filtrées selon la date et la catégorie
    $listeReservations = getReservationsDateCategories($date, $categorie);
}

// Titre de la page
$titre = "Les réservations";

// Inclusion de l'en-tête de la page
include "$racine/vue/entete.php";

// Vérification des droits d'utilisateur avant d'afficher la liste des réservations
if(estUtilisateur() or estSecretaire() or estResponsable() or estAdmin()){
    // Affichage de la vue correspondante aux réservations filtrées
    include "$racine/vue/vueListeReservationsCategorieDate.php";
}
else{
    // Redirection vers la page d'accueil si l'utilisateur n'a pas les droits nécessaires
    header('Location: index.php');
}

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
