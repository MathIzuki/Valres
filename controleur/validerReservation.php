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

// Inclusion du script de gestion de base de données pour les réservations
include_once "$racine/modele/bd.reservation.inc.php";

// Récupération de la liste des réservations provisoires
$listeReservations = getReservationsProvisoires();

// Traitement des actions sur les réservations via le formulaire
foreach ($_POST as $key => $value) {
    // Vérification si l'action est de confirmation de réservation
    if (strpos($key, 'confirm_') === 0) {
        $idReservation = substr($key, 8);
        // Changement de l'état de la réservation à "Confirmé"
        changerEtatReservation($idReservation, 2); // 2 pour "Confirmé"
    }
    // Vérification si l'action est d'annulation de réservation
    elseif (strpos($key, 'cancel_') === 0) {
        $idReservation = substr($key, 7);
        // Changement de l'état de la réservation à "Annulé"
        changerEtatReservation($idReservation, 3); // 3 pour "Annulé"
    }
}

// Message de succès pour indiquer que les modifications ont été enregistrées
$_SESSION['message_succes'] = "Les modifications ont été enregistrées avec succès.";

// Titre de la page
$titre = "Valider les réservations";

// Inclusion de l'en-tête de la page
include "$racine/vue/entete.php";

// Inclusion de la vue pour la validation des réservations si l'utilisateur est un secretaire
if (estSecretaire()){
    include "$racine/vue/vueValiderReservation.php";
}else{
    header('Location: index.php');
}
// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
