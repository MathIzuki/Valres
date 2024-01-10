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

include "$racine/modele/bd.reservation.inc.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['semaine'])) {
    $numeroSemaine = $_POST['semaine'];
    $donnees = getDonneesPourSemaine($numeroSemaine); // Récupère les données nécessaires
    $xml = genererXMLSemaine($donnees); // Génère le fichier XML

    // Préparer l'en-tête pour télécharger le fichier XML
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="m2lsemaine' . $numeroSemaine . '.xml"');
    echo $xml;
    exit();
}

$titre = "Exporter le fichier XML";
include "$racine/vue/entete.php";
if (estSecretaire()){
    include "$racine/vue/vueExporterXMLSemaine.php";
}else{
    header('Location: index.php');
}
include "$racine/vue/pied.php";
?>
