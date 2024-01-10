<?php
// Démarrage ou reprise d'une session PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Définition de la racine du script pour faciliter l'inclusion de fichiers
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = ".";
}

// Vérification si l'utilisateur est connecté et possède un identifiant utilisateur en session
if (!isset($_SESSION['utilisateur']) || !isset($_SESSION['utilisateur']['idUtilisateur'])) {
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
    header('Location: index.php');
    exit();
}

// Inclusion du script de gestion de base de données pour les réservations
include_once "$racine/modele/bd.reservation.inc.php";

// Initialisation de la variable pour stocker les réservations
$listeReservations = array();

// Récupération de la structure soumise via le formulaire
$structure = isset($_POST['structure']) ? $_POST['structure'] : "";

// Vérification si la structure est renseignée
if (!empty($structure)) {
    // Récupération des réservations filtrées par structure
    $listeReservations = getReservationsStructure($structure);
}

// Titre de la page
$titre = "Rechercher les réservations";

// Inclusion de l'en-tête de la page
include "$racine/vue/entete.php";

// Vérification des droits d'accès pour afficher la vue de recherche de réservations
if (estUtilisateur()) {
    // Inclusion de la vue pour la recherche de réservations
    include "$racine/vue/vueRechercheReservation.php";
} else {
    // Redirection vers la page d'accueil si l'utilisateur n'a pas les droits nécessaires
    header('Location: index.php');
}

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
