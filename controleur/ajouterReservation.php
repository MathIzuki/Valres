<?php
// Démarrage ou reprise de la session PHP
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

// Titre de la page
$titre = "Ajouter une réservation";

// Inclusion des scripts de gestion de base de données pour les réservations, périodes, salles, et utilisateurs
include_once "$racine/modele/bd.reservation.inc.php";
include_once "$racine/modele/bd.periode.inc.php";
include_once "$racine/modele/bd.salle.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";

// Inclusion de l'en-tête de la page
include_once "$racine/vue/entete.php";

// Récupération de l'ID de l'utilisateur connecté à partir de la session
$idCreateur = $_SESSION['utilisateur']['idUtilisateur'];

// Récupération des listes des périodes, utilisateurs et salles disponibles
$listePeriode = getPeriodes();
$listeUtilisateur = getUtilisateurs();
$listeSalle = getSalles();

// Traitement de la requête POST pour l'ajout d'une réservation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $date = $_POST['date'];
    $idPeriode = $_POST['periode'];
    $idUtilisateur = $_POST['utilisateur'];
    $idSalle = $_POST['salle'];

    // Vérification de la disponibilité de la salle avant d'ajouter la réservation
    if (verifierDisponibilite($date, $idPeriode, $idSalle)) {
        // Ajout de la réservation selon le rôle de l'utilisateur
        if (estResponsable()) {
            $resultat = ajouterReservationResponsable($date, $idPeriode, $idUtilisateur, $idSalle, $idCreateur);
        }
        else if(estSecretaire()){
            $resultat = ajouterReservationSecretariat($date, $idPeriode, $idUtilisateur, $idSalle, $idCreateur);
        }
        // Affichage d'un message selon le résultat de l'ajout
        if ($resultat) {
            $_SESSION['alerte'] = "Réservation ajoutée avec succès.";
        } else {
            $_SESSION['alerte'] = "Erreur lors de l'ajout de la réservation.";
        }
    }
}

// Inclusion de la vue pour l'ajout d'une réservation si l'utilisateur est secrétaire ou responsable
if (estSecretaire() or estResponsable()) {
    include "$racine/vue/vueAjouterReservation.php";
}
else{
    // Redirection vers la page d'accueil si l'utilisateur n'a pas les droits nécessaires
    header('Location: index.php');
}

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
