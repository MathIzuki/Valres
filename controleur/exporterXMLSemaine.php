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
include "$racine/modele/bd.reservation.inc.php";

// Traitement de la requête POST pour générer un fichier XML
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['semaine'])) {
    // Récupération du numéro de semaine envoyé par le formulaire
    $numeroSemaine = $_POST['semaine'];
    // Obtention des données nécessaires pour la semaine spécifiée
    $donnees = getDonneesPourSemaine($numeroSemaine);
    // Génération du contenu du fichier XML
    $xml = genererXMLSemaine($donnees);

    // Préparation des en-têtes pour télécharger le fichier XML
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="m2lsemaine' . $numeroSemaine . '.xml"');
    // Envoi du fichier XML
    echo $xml;
    exit();
}

// Titre de la page
$titre = "Exporter le fichier XML";

// Inclusion de l'en-tête de la page
include "$racine/vue/entete.php";

// Vérification des droits d'accès pour afficher la vue d'exportation XML
if (estSecretaire()){
    // Inclusion de la vue pour exporter le fichier XML
    include "$racine/vue/vueExporterXMLSemaine.php";
}else{
    // Redirection vers la page d'accueil si l'utilisateur n'a pas les droits nécessaires
    header('Location: index.php');
}

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
