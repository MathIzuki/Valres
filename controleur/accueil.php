<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = ".";
}

$titre = "Accueil";
// Charger le modèle
include_once "$racine/modele/authentification.inc.php";

include "$racine/vue/entete.php";
include "$racine/vue/vueAccueil.php";
include "$racine/vue/pied.php";

?>
