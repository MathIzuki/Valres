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
include_once "$racine/modele/bd.periode.inc.php";
include_once "$racine/modele/bd.salle.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";

$idCreateur = $_SESSION['utilisateur']['idUtilisateur'];

$listePeriode = getPeriodes();
$listeSalle = getSalles();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $idPeriode = $_POST['periode'];
    $idSalle = $_POST['salle'];

    if (supprimerReservation($date, $idPeriode, $idSalle, $idCreateur)) {
            $_SESSION['alerte'] = "Réservation supprimée avec succès.";
            
        }
    else{
        $_SESSION['alerte'] = "Erreur lors de la suppresion de la réservation. ";
    }
    }


$titre = "Supprimer une réservation";
include_once "$racine/vue/entete.php";
if (estSecretaire() or estResponsable()) {
    include "$racine/vue/vueSupprimerReservation.php";
}
else{
    header('Location: index.php');
}
include "$racine/vue/pied.php";
?>
