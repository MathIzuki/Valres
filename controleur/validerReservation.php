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

$listeReservations = getReservationsProvisoires();

if (!isset($_SESSION['utilisateur']) || !isset($_SESSION['utilisateur']['idUtilisateur'])) {
    header('Location: ' . $racine . '/pageConnexion.php');
    exit();
}

foreach ($_POST as $key => $value) {
    if (strpos($key, 'confirm_') === 0) {
        $idReservation = substr($key, 8);
        changerEtatReservation($idReservation, 2); // 2 pour "Confirmé"
    } elseif (strpos($key, 'cancel_') === 0) {
        $idReservation = substr($key, 7);
        changerEtatReservation($idReservation, 3); // 3 pour "Annulé"
    }
}

$_SESSION['message_succes'] = "Les modifications ont été enregistrées avec succès.";

$titre = "Valider les réservations";
include "$racine/vue/entete.php";
include "$racine/vue/vueValiderReservation.php";
include "$racine/vue/pied.php";
?>
