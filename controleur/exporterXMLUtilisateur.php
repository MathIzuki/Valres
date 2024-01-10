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

// Inclusion des scripts de gestion de base de données pour les structures et utilisateurs
include_once "$racine/modele/bd.structure.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";

// Récupération de la liste des utilisateurs
$listeUtilisateurs = getUtilisateurs();
// Génération du contenu XML à partir de la liste des utilisateurs
$xml = genererXMLUtilisateurs($listeUtilisateurs);

// Traitement de la requête POST pour générer un fichier XML
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Préparation des en-têtes pour télécharger le fichier XML
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="utilisateurs.xml"');
    // Envoi du fichier XML
    echo $xml;
    exit();
}

// Titre de la page
$titre = "Exporter le fichier XML";

// Inclusion de l'en-tête de la page
include "$racine/vue/entete.php";

// Vérification des droits d'accès pour afficher la vue d'exportation XML
if (estAdmin()){
    // Inclusion de la vue pour exporter le fichier XML des utilisateurs
    include "$racine/vue/vueExporterXMLUtilisateur.php";
}else{
    // Redirection vers la page d'accueil si l'utilisateur n'est pas administrateur
    header('Location: index.php');
}

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
