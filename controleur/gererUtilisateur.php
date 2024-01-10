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

include_once "$racine/modele/bd.utilisateur.inc.php";
include_once "$racine/modele/bd.accees.inc.php";

$listeUtilisateurs = getUtilisateurs();
$listeTypesAcces = getAccees();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['enregistrer'])) {
        foreach ($_POST['type_acces'] as $idUtilisateur => $idAcces) {
            modifierTypeAcces($idUtilisateur, $idAcces);
        }
        $_SESSION['alerte'] = "Les modifications ont été enregistrées.";
    } elseif (isset($_POST['supprimer'])) {
        $idUtilisateurASupprimer = $_POST['supprimer'];
        supprimerUtilisateur($idUtilisateurASupprimer);
        $_SESSION['alerte'] = "Utilisateur supprimé avec succès.";
    }
    header('Location: index.php?action=GererUtilisateur');
    exit();
}

// Inclure l'en-tête de la page
$titre = "Gérer les utilisateurs";
include_once "$racine/vue/entete.php";

// Inclure la vue pour modifier les types d'accès
include "$racine/vue/vueGererUtilisateur.php";

// Inclure le pied de page
include "$racine/vue/pied.php";
?>
