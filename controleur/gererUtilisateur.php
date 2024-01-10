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

// Inclusion des scripts de gestion de base de données pour les utilisateurs et les accès
include_once "$racine/modele/bd.utilisateur.inc.php";
include_once "$racine/modele/bd.accees.inc.php";

// Récupération de la liste des utilisateurs et des types d'accès disponibles
$listeUtilisateurs = getUtilisateurs();
$listeTypesAcces = getAccees();

// Traitement des requêtes POST pour la gestion des utilisateurs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Traitement de l'enregistrement des modifications des types d'accès
    if (isset($_POST['enregistrer'])) {
        foreach ($_POST['type_acces'] as $idUtilisateur => $idAcces) {
            modifierTypeAcces($idUtilisateur, $idAcces);
        }
        $_SESSION['alerte'] = "Les modifications ont été enregistrées.";
    } 
    // Traitement de la suppression d'un utilisateur
    elseif (isset($_POST['supprimer'])) {
        $idUtilisateurASupprimer = $_POST['supprimer'];
        supprimerUtilisateur($idUtilisateurASupprimer);
        $_SESSION['alerte'] = "Utilisateur supprimé avec succès.";
    }
    // Redirection après le traitement de la requête
    header('Location: index.php?action=GererUtilisateur');
    exit();
}

// Titre de la page
$titre = "Gérer les utilisateurs";

// Inclusion de l'en-tête de la page
include_once "$racine/vue/entete.php";

// Inclusion de la vue pour la gestion des utilisateurs
include "$racine/vue/vueGererUtilisateur.php";

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
