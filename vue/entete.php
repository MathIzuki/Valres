<!-- Création du Header -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titre ?></title>
    <style>
        @import url("css/header.css");
        @import url("css/style.css");
        @import url("css/style_signin.css");
    </style>
</head>
<body>
<header>
    <!-- Import du Logo à gauche -->
    <a href="../index.php">
        <div class="logoheader" alt="Valres" title="Valres">V</div>
    </a>
    <nav>
        <ul>
            <!-- Début Fonction "estConnecte" -->
            <?php if (estConnecte()) { ?>

                <!-- Début Fonction "estAdmin" -->
                <?php if (estAdmin()) { ?>
                    <li><a href="../index.php?action=SalleLibreCategorieDate">Salles</a></li>
                    <li><a href="../index.php?action=ReservationCategorieDate">Reservation</a></li>
                    <li><a href="../index.php?action=GererUtilisateur">Gérer</a></li>
                    <li><a href="../index.php?action=AjouterUtilisateur">Ajouter</a></li>
                    <li><a href="../index.php?action=ExporterXMLUtilisateur">Exporter</a></li>
                <!-- Fin Fonction "estAdmin" -->
                <?php } ?>

                <!-- Début Fonction "estUtilisateur" -->
                <?php if (estUtilisateur()) { ?>
                    <li><a href="../index.php?action=ReservationCategorieDate">Reservation</a></li>
                    <li><a href="../index.php?action=RechercheReservationStructure">Recherche</a></li>
                <!-- Fin Fonction "estUtilisateur" -->
                <?php } ?>

                <!-- Début Fonction "estSecretaire" -->
                <?php if (estSecretaire()) { ?>
                    <li><a href="../index.php?action=SalleLibreCategorieDate">Salles</a></li>
                    <li><a href="../index.php?action=AjouterReservation">Ajouter</a></li>
                    <li><a href="../index.php?action=ReservationCategorieDate">Reservation</a></li>
                    <li><a href="../index.php?action=SupprimerReservation">Supression</a></li>
                    <li><a href="../index.php?action=ValidationReservation">Validation</a></li>
                    <li><a href="../index.php?action=ExporterXMLSemaine">Exporter</a></li>
                <!-- Fin Fonction "estSecretaire" -->
                <?php } ?>

                <!-- Début Fonction "estResponsable" -->
                <?php if (estResponsable()) { ?>
                    <li><a href="../index.php?action=SalleLibreCategorieDate">Salles</a></li>
                    <li><a href="../index.php?action=AjouterReservation">Ajouter</a></li>
                    <li><a href="../index.php?action=ReservationCategorieDate">Reservation</a></li>
                    <li><a href="../index.php?action=SupprimerReservation">Supression</a></li>
                <!-- Fin Fonction "estResponsable" -->
                <?php } ?>

                <!-- Fin Fonction "estConnecte" -->
            <?php } else { ?>
                <!-- Si l'utilisateur n'est pas connecté alors il n'y a rien -->

                <?php } ?>
        </ul>
    </nav>

<!-- Début Fonction "estConnecte" -->
    <?php if (estConnecte()) { ?>
        <!-- Affichage du nom d'utilisateur, s'il est connecté -->
        <a href="../index.php?action=Connexion"><?php echo getNom(); ?></a>
        <!-- Fin Fonction "estConnecte" -->
    <?php } else { ?>
        <!-- Affichage "Utilisateur non identifié, s'il est pas connecté -->
        <a href="../index.php?action=Connexion">Utilisateur non identifié</a>
    <?php } ?>
</header>
<div id="corps">

