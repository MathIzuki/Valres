<?php
function controleurPrincipal($action) {
    $lesActions = array();
    $lesActions["defaut"] = "accueil.php";
    $lesActions["Connexion"] = "signin.php";
    $lesActions["ReservationCategorieDate"] = "listeReservationsCategorieDate.php";
    $lesActions["RechercheReservationStructure"] = "listeRechercheReservation.php";
    $lesActions["SalleLibreCategorieDate"] = "listeSallesLibres.php";
    $lesActions["AjouterReservation"] = "ajouterReservation.php";
    $lesActions["ValidationReservation"] = "validerReservation.php";
    $lesActions["SupprimerReservation"] = "supprimerReservation.php";
    $lesActions["ExporterXMLSemaine"] = "exporterXMLSemaine.php";
    $lesActions["AjouterUtilisateur"] = "ajouterUtilisateur.php";
    $lesActions["GererUtilisateur"] = "gererUtilisateur.php";
    $lesActions["ExporterXMLUtilisateur"] = "exporterXMLUtilisateur.php";
    $lesActions["deconnexion"] = "logout.php";

    if (array_key_exists($action, $lesActions)) {
        return $lesActions[$action];
    } else {
        return $lesActions["defaut"];
    }
}


?>