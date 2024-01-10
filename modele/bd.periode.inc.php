<?php 
    include_once "modele/bd.inc.php";
    
    function getPeriodes() {
        $resultat = array();
        try {
            $cnx = connexionPDO();
            $req = $cnx->prepare("SELECT * FROM periode");
            $req->execute();
            $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $resultat;
    }

  
?>