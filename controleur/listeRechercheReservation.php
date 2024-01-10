<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = ".";
}

// Vérifiez si l'utilisateur est connecté et a un identifiant utilisateur dans la session
if (!isset($_SESSION['utilisateur']) || !isset($_SESSION['utilisateur']['idUtilisateur'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header('Location: index.php');
    exit();
}

include_once "$racine/modele/bd.reservation.inc.php";

// Initialisation des variables
$listeReservations = array();

// Récupérer la structure soumise
$structure = isset($_POST['structure']) ? $_POST['structure'] : "";

// Vérifier si la structure est appliquée
if (!empty($structure)) {
    // Récupération des réservations filtrées par structure
    $listeReservations = getReservationsStructure($structure);
}
$titre = "Rechercher les réservations";

// Inclusion de la vue seulement si des réservations sont disponibles
include "$racine/vue/entete.php";
if(estUtilisateur()){
    include "$racine/vue/vueRechercheReservation.php";
}
else{
    header('Location: index.php');
}

include "$racine/vue/pied.php";
?>
