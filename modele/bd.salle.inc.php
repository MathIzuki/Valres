<?php
    include_once "modele/bd.inc.php";

    function getSallesLibresParPeriode($date, $categorie) {
        $resultat = array();
    
        try {
            $cnx = connexionPDO();
            $sql = "SELECT s.idSalle, s.salle_nom, c.libelle AS categorie, p.libelle AS periode
            FROM salle s
            JOIN categorie_salle c ON s.idCategorieSalle = c.idCategorieSalle
            CROSS JOIN periode p
            LEFT JOIN reservation r ON s.idSalle = r.idSalle AND r.datee = :date AND p.idPeriode = r.idPeriode
            WHERE r.idReservation IS NULL
              AND (:categorie IS NULL OR s.idCategorieSalle = :categorie)
            ORDER BY s.idSalle, p.idPeriode
            ";
    
            $req = $cnx->prepare($sql);
            $req->bindParam(':date', $date, PDO::PARAM_STR);
            $req->bindParam(':categorie', $categorie, PDO::PARAM_INT);
            $req->execute();
    
            $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    
        return $resultat;
    }
    
    function getSalles() {
        $resultat = array();
        try {
            $cnx = connexionPDO();
            $req = $cnx->prepare("SELECT * FROM salle");
            $req->execute();
            $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $resultat;
    }
    
    function getDisponibilitesSallesParPeriode($date, $categorie) {
        $cnx = connexionPDO();
        $sallesDisponibles = [];
    
        // Obtenez toutes les salles de la catégorie choisie
        $stmtSalles = $cnx->prepare("SELECT idSalle, salle_nom FROM salle WHERE idCategorieSalle = :categorie");
        $stmtSalles->execute([':categorie' => $categorie]);
        $salles = $stmtSalles->fetchAll(PDO::FETCH_ASSOC);
    
        // Obtenez toutes les périodes
        $periodes = getPeriodes();
    
        // Initialisation de la structure des disponibilités
        foreach ($periodes as $periode) {
            foreach ($salles as $salle) {
                $sallesDisponibles[$periode['libelle']][$salle['salle_nom']] = 'Libre';
            }
        }
    
        // Vérifiez les réservations existantes pour la date et la catégorie
        $reservations = getReservationsDateCategories($date, $categorie);
        foreach ($reservations as $reservation) {
            // Marquez la salle comme occupée pour la période correspondante
            $sallesDisponibles[$reservation['Période']][$reservation['Salle']] = 'Occupée';
        }
    
        return is_array($sallesDisponibles) ? $sallesDisponibles : [];
    }
    
?>

