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

include_once "$racine/modele/bd.structure.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";


$listeUtilisateurs = getUtilisateurs();
$xml = genererXMLUtilisateurs($listeUtilisateurs);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="utilisateurs.xml"');
    echo $xml;
    exit();
}


$titre = "Exporter le fichier XML";
include "$racine/vue/entete.php";
if (estAdmin()){
    include "$racine/vue/vueExporterXMLUtilisateur.php";
}else{
    header('Location: index.php');
}
include "$racine/vue/pied.php";
?>
