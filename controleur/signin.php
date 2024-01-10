<?php 
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}
include_once "$racine/modele/data_process.php"; // pour pouvoir utiliser isLoggedOn()

$titre = "S'enregistrer";
include "$racine/vue/entete.php";
include "$racine/vue/vueSignin.php";
include "$racine/vue/pied.php";
?>