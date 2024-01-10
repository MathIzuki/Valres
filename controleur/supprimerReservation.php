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

// Inclusion des scripts de gestion de base de données pour réservations, périodes, salles et utilisateurs
include_once "$racine/modele/bd.reservation.inc.php";
include_once "$racine/modele/bd.periode.inc.php";
include_once "$racine/modele/bd.salle.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";

// Récupération de l'identifiant de l'utilisateur connecté
$idCreateur = $_SESSION['utilisateur']['idUtilisateur'];

// Récupération des listes des périodes et des salles disponibles
$listePeriode = getPeriodes();
$listeSalle = getSalles();

// Traitement du formulaire de suppression de réservation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $date = $_POST['date'];
    $idPeriode = $_POST['periode'];
    $idSalle = $_POST['salle'];

    // Tentative de suppression de la réservation
    if (supprimerReservation($date, $idPeriode, $idSalle, $idCreateur)) {
        // Message de succès en cas de suppression réussie
        $_SESSION['alerte'] = "Réservation supprimée avec succès.";
    } else {
        // Message d'erreur si la suppression échoue
        $_SESSION['alerte'] = "Erreur lors de la suppression de la réservation.";
    }
}

// Titre de la page
$titre = "Supprimer une réservation";

// Inclusion de l'en-tête de la page
include_once "$racine/vue/entete.php";

// Vérification des droits d'accès pour afficher la vue de suppression de réservation
if (estSecretaire() or estResponsable()) {
    include "$racine/vue/vueSupprimerReservation.php";
} else {
    // Redirection vers la page d'accueil si l'utilisateur n'a pas les droits nécessaires
    header('Location: index.php');
}

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
