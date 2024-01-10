<?php
// Assurez-vous que session_start() est appelé avant tout envoi de données au navigateur
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = ".";
}

include_once "$racine/modele/bd.reservation.inc.php";

// Initialisation des variables
$listeReservations = array();

// Récupérer les valeurs soumises
$date = isset($_POST['date']) ? $_POST['date'] : null;
$categorie = isset($_POST['categorie']) ? $_POST['categorie'] : null;

// Vérifier si au moins l'un des filtres est appliqué
if (!empty($date) || !empty($categorie)) {
    // Récupération des réservations filtrées
    $listeReservations = getReservationsDateCategories($date, $categorie);
}

$titre = "Les réservations";
// Inclusion de la vue seulement si des réservations sont disponibles
include "$racine/vue/entete.php";
if(estUtilisateur() or estSecretaire() or estResponsable() or estAdmin()){
    include "$racine/vue/vueListeReservationsCategorieDate.php";
}
else{
    header('Location: index.php');
}
include "$racine/vue/pied.php";
?>
