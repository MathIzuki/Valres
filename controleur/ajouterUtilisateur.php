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
$titre = "Ajouter un utilisateur";

// Inclusion des scripts de gestion de base de données pour les utilisateurs, structures et accès
include_once "modele/bd.utilisateur.inc.php";
include_once "modele/bd.structure.inc.php";
include_once "modele/bd.accees.inc.php";

// Inclusion de l'en-tête de la page
include_once "$racine/vue/entete.php";

// Récupération des listes des structures et des types d'accès
$listeStructures = getStructure();
$listeAcces = getAccees();

// Traitement de la requête POST pour l'ajout d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et validation des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse']; // Le mot de passe doit être sécurisé (hashé)
    $idStructure = $_POST['structure'];
    $idAcces = $_POST['acces'];

    try {
        // Tentative d'ajout de l'utilisateur dans la base de données
        $resultat = ajouterUtilisateur($nom, $prenom, $email, $motDePasse, $idStructure, $idAcces);
        if ($resultat) {
            $_SESSION['alerte'] = "Utilisateur ajouté avec succès.";
        } else {
            $_SESSION['alerte'] = "Erreur lors de l'ajout de l'utilisateur.";
        }
    } catch (Exception $e) {
        // Gestion des erreurs
        echo "Erreur : " . $e->getMessage();
    }
}

// Inclusion de la vue pour l'ajout d'un utilisateur si l'utilisateur est administrateur
if (estAdmin()) {
    include "$racine/vue/vueAjouterUtilisateur.php";
}
else {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas administrateur
    header('Location: index.php');
}

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
