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

$titre = "Ajouter une réservation";
include_once "$racine/modele/bd.reservation.inc.php";
include_once "$racine/modele/bd.periode.inc.php";
include_once "$racine/modele/bd.salle.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php"; // pour les fonctions liées à l'utilisateur
include_once "$racine/vue/entete.php"; // pour l'en-tête de la page

$idCreateur = $_SESSION['utilisateur']['idUtilisateur']; // Récupérez l'ID du créateur à partir de la session

$listePeriode = getPeriodes();
$listeUtilisateur = getUtilisateurs();
$listeSalle = getSalles();


// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $date = $_POST['date'];
    $idPeriode = $_POST['periode'];
    $idUtilisateur = $_POST['utilisateur'];
    $idSalle = $_POST['salle'];

    // Vérification de la disponibilité avant d'ajouter la réservation
    if (verifierDisponibilite($date, $idPeriode, $idSalle)) {
            if (estResponsable()) {
                $resultat = ajouterReservationResponsable($date, $idPeriode, $idUtilisateur, $idSalle, $idCreateur);
            }
            else if(estSecretaire()){
                $resultat = ajouterReservationSecretariat($date, $idPeriode, $idUtilisateur, $idSalle, $idCreateur);
            }
            if ($resultat) {
                $_SESSION['alerte'] = "Réservation ajoutée avec succès.";
            } else {
                $_SESSION['alerte'] = "Erreur lors de l'ajout de la réservation.";
            }
        }
    
    }

// Inclusion de la vue correspondante

if (estSecretaire() or estResponsable()) {
include "$racine/vue/vueAjouterReservation.php";
}
else{
    header('Location: index.php');
}

include "$racine/vue/pied.php"; // pour le pied de page
?>
