<?php 
    include_once "modele/bd.inc.php";

    function getAccees() {
        $resultat = array();
        try {
            $cnx = connexionPDO();
            $req = $cnx->prepare("SELECT * FROM type_accees");
            $req->execute();
            $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $resultat;
    
    }

?>