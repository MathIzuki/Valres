<?php 
include_once "modele/bd.inc.php";

function getReservations() {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT r.idReservation AS NuméroReservation, p.libelle AS Période, r.datee AS DateReservation, str.structure_nom AS NomStructure, e.libelle AS Etat, s.salle_nom AS Salle
            FROM reservation r
            JOIN periode p ON p.idPeriode = r.idPeriode
            JOIN utilisateur u ON u.idUtilisateur = r.idUtilisateur
            JOIN etatreservation e ON e.idEtat = r.idEtat
            JOIN salle s ON s.idSalle = r.idSalle
            JOIN structure str ON str.idStructure = u.idStructure");
        $req->execute();
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gérer les erreurs si nécessaire
        // Vous pouvez logger l'erreur, afficher un message, etc.
        echo "Erreur : " . $e->getMessage();
    }

    return $resultat;
}

function getReservationsDateCategories($date, $categorie) {
    $resultat = array();

    try {
        $cnx = connexionPDO();

        $sql = "SELECT  p.libelle AS Période, r.datee AS DateReservation, str.structure_nom AS NomStructure, s.salle_nom AS Salle, s.capacite AS Capacite, e.libelle AS Etat, u_createur.nom AS Createur
            FROM reservation r
            JOIN periode p ON p.idPeriode = r.idPeriode
            JOIN utilisateur u ON u.idUtilisateur = r.idUtilisateur
            JOIN etatreservation e ON e.idEtat = r.idEtat
            JOIN salle s ON s.idSalle = r.idSalle
            JOIN structure str ON str.idStructure = u.idStructure
            JOIN categorie_salle c ON c.idCategorieSalle = s.idCategorieSalle
            LEFT JOIN utilisateur u_createur ON u_createur.idUtilisateur = r.idCreateur
            WHERE (:date IS NULL OR r.datee = :date) AND (:categorie IS NULL OR s.idCategorieSalle = :categorie)";

        $req = $cnx->prepare($sql);
        $req->bindParam(':date', $date, PDO::PARAM_STR);
        $req->bindParam(':categorie', $categorie, PDO::PARAM_INT);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gérer les erreurs si nécessaire
        // Vous pouvez logger l'erreur, afficher un message, etc.
        echo "Erreur : " . $e->getMessage();
    }

    return $resultat;
}

function getReservationsStructure($structure) {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT p.libelle AS Période, r.datee AS DateReservation, str.structure_nom AS NomStructure, e.libelle AS Etat, s.capacite AS Capacite, s.salle_nom AS Salle, 
            u_createur.nom AS Createur
            FROM reservation r
            JOIN periode p ON p.idPeriode = r.idPeriode
            JOIN utilisateur u ON u.idUtilisateur = r.idUtilisateur
            JOIN etatreservation e ON e.idEtat = r.idEtat
            JOIN salle s ON s.idSalle = r.idSalle
            JOIN structure str ON str.idStructure = u.idStructure
            LEFT JOIN utilisateur u_createur ON u_createur.idUtilisateur = r.idCreateur
            WHERE str.structure_nom LIKE :structure");

        $structureLike = "%" . $structure . "%";
        $req->bindParam(':structure', $structureLike, PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    return $resultat;
}

function ajouterReservationResponsable($date, $idPeriode, $idUtilisateur, $idSalle, $idCreateur) {
    try {
        $cnx = connexionPDO();
        $sql = "INSERT INTO reservation (datee, idPeriode, idUtilisateur, idEtat, idSalle, idCreateur) 
                VALUES (:date, :idPeriode, :idUtilisateur, 1, :idSalle, :idCreateur)";
        // L'état 1 est pour 'Provisoire' selon la BDD

        $req = $cnx->prepare($sql);
        $req->bindParam(':date', $date, PDO::PARAM_STR);
        $req->bindParam(':idPeriode', $idPeriode, PDO::PARAM_INT);
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':idSalle', $idSalle, PDO::PARAM_INT);
        $req->bindParam(':idCreateur', $idCreateur, PDO::PARAM_INT);
        
        return $req->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function ajouterReservationSecretariat($date, $idPeriode, $idUtilisateur, $idSalle, $idCreateur) {
    try {
        $cnx = connexionPDO();
        $sql = "INSERT INTO reservation (datee, idPeriode, idUtilisateur, idEtat, idSalle, idCreateur) 
                VALUES (:date, :idPeriode, :idUtilisateur, 2, :idSalle, :idCreateur)";
        // L'état 2 est pour 'Confirmé' selon la BDD

        $req = $cnx->prepare($sql);
        $req->bindParam(':date', $date, PDO::PARAM_STR);
        $req->bindParam(':idPeriode', $idPeriode, PDO::PARAM_INT);
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':idSalle', $idSalle, PDO::PARAM_INT);
        $req->bindParam(':idCreateur', $idCreateur, PDO::PARAM_INT);
        
        return $req->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function verifierDisponibilite($date, $idPeriode, $idSalle) {
    try {
        $cnx = connexionPDO();
        $sql = "SELECT COUNT(*) FROM reservation 
                WHERE datee = :date AND idPeriode = :idPeriode AND idSalle = :idSalle";
        $req = $cnx->prepare($sql);
        $req->bindParam(':date', $date, PDO::PARAM_STR);
        $req->bindParam(':idPeriode', $idPeriode, PDO::PARAM_INT);
        $req->bindParam(':idSalle', $idSalle, PDO::PARAM_INT);
        $req->execute();
        $reservations = $req->fetchColumn();

        return $reservations == 0; // Retourne vrai si aucune réservation n'est trouvée
    } catch (PDOException $e) {
        throw $e;
    }
}

function supprimerReservation($date, $idPeriode, $idSalle, $idCreateur) {
    try {
        $cnx = connexionPDO();
        $sql = "DELETE FROM reservation 
                WHERE datee = :date 
                  AND idPeriode = :idPeriode 
                  AND idSalle = :idSalle 
                  AND idCreateur = :idCreateur 
                  AND datee > CURDATE()";
        $req = $cnx->prepare($sql);
        $req->bindParam(':date', $date, PDO::PARAM_STR);
        $req->bindParam(':idPeriode', $idPeriode, PDO::PARAM_INT);
        $req->bindParam(':idSalle', $idSalle, PDO::PARAM_INT);
        $req->bindParam(':idCreateur', $idCreateur, PDO::PARAM_INT);
        $req->execute();
        return $req->rowCount() > 0; // Retourne vrai si au moins une ligne a été supprimée
    } catch (PDOException $e) {
        throw $e;
    }
}

function changerEtatReservation($idReservation, $nouvelEtat) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("UPDATE reservation SET idEtat = :nouvelEtat WHERE idReservation = :idReservation");
        $req->bindParam(':idReservation', $idReservation, PDO::PARAM_INT);
        $req->bindParam(':nouvelEtat', $nouvelEtat, PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (PDOException $e) {
        // Gérer l'erreur
        return false;
    }
}

function getReservationsProvisoires() {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT r.idReservation AS NuméroReservation, p.libelle AS Période, r.datee AS DateReservation, str.structure_nom AS NomStructure, e.libelle AS Etat, s.salle_nom AS Salle
            FROM reservation r
            JOIN periode p ON p.idPeriode = r.idPeriode
            JOIN utilisateur u ON u.idUtilisateur = r.idUtilisateur
            JOIN etatreservation e ON e.idEtat = r.idEtat
            JOIN salle s ON s.idSalle = r.idSalle
            JOIN structure str ON str.idStructure = u.idStructure
            WHERE e.libelle = 'Provisoire'");
        $req->execute();
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    return $resultat;
}

function getDonneesPourSemaine($numeroSemaine) {
    $resultat = array();
    $numeroSemaine = $numeroSemaine - 1;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT r.idReservation, u.idUtilisateur, u.nom, u.prenom, 
                                     s.idStructure, s.structure_nom, s.structure_adresse, 
                                     u.mail, r.idSalle, r.datee, p.idPeriode
                              FROM reservation r
                              JOIN utilisateur u ON r.idUtilisateur = u.idUtilisateur
                              JOIN structure s ON u.idStructure = s.idStructure
                              JOIN periode p ON r.idPeriode = p.idPeriode
                              WHERE WEEK(r.datee) = :numeroSemaine");
        $req->bindParam(':numeroSemaine', $numeroSemaine, PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gérer l'erreur
        echo "Erreur : " . $e->getMessage();
    }
    return $resultat;
}

function genererXMLSemaine($donnees) {
    $xmlContent = "<reservations>\n";

    foreach ($donnees as $reservation) {
        $xmlContent .= "\t<reservation id=\"" . htmlspecialchars($reservation['idReservation']) . "\">\n";
        $xmlContent .= "\t\t<utilisateur_id>" . htmlspecialchars($reservation['idUtilisateur']) . "</utilisateur_id>\n";
        $xmlContent .= "\t\t<nom>" . htmlspecialchars($reservation['nom']) . "</nom>\n";
        $xmlContent .= "\t\t<prenom>" . htmlspecialchars($reservation['prenom']) . "</prenom>\n";
        $xmlContent .= "\t\t<structure_id>" . htmlspecialchars($reservation['idStructure']) . "</structure_id>\n";
        $xmlContent .= "\t\t<structure_nom>" . htmlspecialchars($reservation['structure_nom']) . "</structure_nom>\n";
        $xmlContent .= "\t\t<structure_adresse>" . htmlspecialchars($reservation['structure_adresse']) . "</structure_adresse>\n";
        $xmlContent .= "\t\t<mail>" . htmlspecialchars($reservation['mail']) . "</mail>\n";
        $xmlContent .= "\t\t<salle_id>" . htmlspecialchars($reservation['idSalle']) . "</salle_id>\n";
        $xmlContent .= "\t\t<date>" . htmlspecialchars($reservation['datee']) . "</date>\n";
        $xmlContent .= "\t\t<periode>" . htmlspecialchars($reservation['idPeriode']) . "</periode>\n";
        $xmlContent .= "\t</reservation>\n";
    }

    $xmlContent .= "</reservations>";

    return $xmlContent;
}

