<?php
// Code pour démarrer la session, vérifier l'accès, etc.

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = ".";
}
include_once "$racine/modele/bd.salle.inc.php";
include_once "$racine/modele/bd.periode.inc.php";
include_once "$racine/modele/bd.reservation.inc.php";

$date = isset($_POST['date']) ? $_POST['date'] : null;
$categorie = isset($_POST['categorie']) ? $_POST['categorie'] : null;
$listeSallesLibresParPeriode = [];

if (!empty($date) && !empty($categorie)) {
    $listeSallesLibresParPeriode = getDisponibilitesSallesParPeriode($date, $categorie);
}
$disponibilites = is_array($listeSallesLibresParPeriode) ? $listeSallesLibresParPeriode : [];

$titre = "Les salles libres";
// Inclusion des vues
include "$racine/vue/entete.php";
if (estSecretaire() or estResponsable() or estAdmin()){
    include "$racine/vue/vueListeSallesLibres.php";
}
else{
    header('Location: index.php');
}

include "$racine/vue/pied.php";
?>
