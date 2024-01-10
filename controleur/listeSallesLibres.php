<?php
// Code pour démarrer la session, vérifier l'accès, etc.

// Démarrage ou reprise de la session PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Définition de la racine du script pour faciliter l'inclusion de fichiers
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = ".";
}

// Inclusion des scripts de gestion de base de données pour les salles, périodes et réservations
include_once "$racine/modele/bd.salle.inc.php";
include_once "$racine/modele/bd.periode.inc.php";
include_once "$racine/modele/bd.reservation.inc.php";

// Récupération des données du formulaire (date et catégorie) si elles existent
$date = isset($_POST['date']) ? $_POST['date'] : null;
$categorie = isset($_POST['categorie']) ? $_POST['categorie'] : null;

// Initialisation de la variable pour stocker les disponibilités des salles
$listeSallesLibresParPeriode = [];

// Vérification si la date et la catégorie sont renseignées
if (!empty($date) && !empty($categorie)) {
    // Récupération des disponibilités des salles pour une période et catégorie données
    $listeSallesLibresParPeriode = getDisponibilitesSallesParPeriode($date, $categorie);
}

// Assure que les disponibilités sont dans un format de tableau
$disponibilites = is_array($listeSallesLibresParPeriode) ? $listeSallesLibresParPeriode : [];

// Titre de la page
$titre = "Les salles libres";

// Inclusion de l'en-tête de la page
include "$racine/vue/entete.php";

// Vérification des droits d'accès pour afficher la liste des salles libres
if (estSecretaire() or estResponsable() or estAdmin()){
    // Affichage de la vue correspondante aux salles libres
    include "$racine/vue/vueListeSallesLibres.php";
}
else{
    // Redirection vers la page d'accueil si l'utilisateur n'a pas les droits nécessaires
    header('Location: index.php');
}

// Inclusion du pied de page
include "$racine/vue/pied.php";
?>
