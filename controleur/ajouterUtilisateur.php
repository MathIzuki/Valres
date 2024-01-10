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

$titre = "Ajouter un utilisateur";
include_once "modele/bd.utilisateur.inc.php";
include_once "modele/bd.structure.inc.php";
include_once "modele/bd.accees.inc.php";
include_once "$racine/vue/entete.php"; // pour l'en-tête de la page


$listeStructures = getStructure();
$listeAcces = getAccees();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom']; // Valider et nettoyer
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse']; // Hashage du mot de passe
    $idStructure = $_POST['structure'];
    $idAcces = $_POST['acces'];

    try {
        $resultat = ajouterUtilisateur($nom, $prenom, $email, $motDePasse, $idStructure, $idAcces);
        if ($resultat) {
            $_SESSION['alerte'] = "Utilisateur ajoutée avec succès.";
        } else {
            $_SESSION['alerte'] = "Erreur lors de l'ajout de l'utilisateur.";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
// Inclusion de la vue correspondante

if (estAdmin()) {
    include "$racine/vue/vueAjouterUtilisateur.php";
}
else{
    header('Location: index.php');
}

include "$racine/vue/pied.php"; // pour le pied de page
?>
