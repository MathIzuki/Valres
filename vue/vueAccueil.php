<div class="page-accueil">

<?php
// Test des différentes fonctions
if (estConnecte()){
    echo "<h1>Bienvenue sur le site de la Maison des Ligues</h1>";

    // Afficher le nom et prénom de l'utilisateur connecté
    echo "<p>Bienvenue " . getNom() . " " . getPrenom() . ", vous êtes un(e) ";

    // Déterminer le rôle de l'utilisateur et l'afficher
    if (estAdmin()) {
        echo "Administrateur";
    } elseif (estSecretaire()) {
        echo "Secrétaire";
    } elseif (estResponsable()) {
        echo "Responsable";
    } elseif (estUtilisateur()) {
        echo "Utilisateur";
    }

    echo ".</p>";

    // Afficher le mail de l'utilisateur
    echo "<p>Votre mail est : " . getMail() . "</p>";

    // Informations complémentaires sur les rôles
    echo "<div>";
    echo "<h3>Les périodes de location des salles seront à compter de ce jour définies : </h3>";
    echo "<p><strong> La matinée </strong> (de 8h30 à 12h30)</p>";
    echo "<p><strong> L'après-midi </strong> (de 14h à 18h)</p>";
    echo "<p><strong> Le midi </strong> (de 11h30 à 14h30)</p>";
    echo "<p><strong> La soirée </strong> (de 18h30 à 23h00)</p>";
    echo "</br>";
    echo "<h3> Les tarifs de base des salles : </h3>";
    echo "<p><strong> Salle de réunion </strong> 720 euros HT la période</p>";
    echo "<p><strong> Salle avec équipements </strong> 960 euros HT la période</p>";
    echo "<p><strong> Amphithéâtre </strong> 1200 euros HT la période</p>";
    echo "</div>";
} else {
    echo "<h1>Bienvenue sur le site de la Maison des Ligues</h1>";
    echo "<p>Connectez-vous pour accéder aux fonctionnalités du site.</p>";
}
?>
</div>