<?php 
    include_once "modele/bd.inc.php";

    function getStructure() {
        $resultat = array();
        try {
            $cnx = connexionPDO();
            $req = $cnx->prepare("SELECT * FROM structure");
            $req->execute();
            $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $resultat;
    
    }
    function getStructureParId($idStructure) {
        try {
            $cnx = connexionPDO();
            $req = $cnx->prepare("SELECT * FROM structure WHERE idStructure = :idStructure");
            $req->bindParam(':idStructure', $idStructure, PDO::PARAM_INT);
            $req->execute();
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $resultat;
    }
?>
