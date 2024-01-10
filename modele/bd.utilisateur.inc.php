<?php
  include_once "modele/bd.inc.php";
function getUtilisateurs() {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from utilisateur ORDER BY idAccees DESC");
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function ajouterUtilisateur($nom, $prenom, $email, $motDePasse, $idStructure, $idAcces) {
    try {
        $cnx = connexionPDO();
        $sql = "INSERT INTO utilisateur (nom, prenom, mail, motDePasse, idStructure, idAccees) 
                VALUES (:nom, :prenom, :email, :motDePasse, :idStructure, :idAcces)";

        $req = $cnx->prepare($sql);
        $req->bindParam(':nom', $nom, PDO::PARAM_STR);
        $req->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':motDePasse', $motDePasse, PDO::PARAM_STR); // Considérez hasher le mot de passe
        $req->bindParam(':idStructure', $idStructure, PDO::PARAM_INT);
        $req->bindParam(':idAcces', $idAcces, PDO::PARAM_INT);
        
        return $req->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function modifierTypeAcces($idUtilisateur, $idAcces) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("UPDATE utilisateur SET idAccees = :idAcces WHERE idUtilisateur = :idUtilisateur");
        $req->bindParam(':idAcces', $idAcces, PDO::PARAM_INT);
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        return $req->execute();
    } catch (PDOException $e) {
        // En cas d'erreur, vous pourriez vouloir gérer l'exception différemment.
        // Par exemple, enregistrez l'erreur dans un fichier de log et retournez false.
        error_log("Erreur lors de la modification du type d'accès : " . $e->getMessage());
        return false;
    }
}

function supprimerUtilisateur($idUtilisateur) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("DELETE FROM utilisateur WHERE idUtilisateur = :idUtilisateur");
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        return $req->execute();
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
        return false;
    }
}

function genererXMLUtilisateurs($donnees) {
    $xmlContent = "<utilisateurs>\n";

    foreach ($donnees as $utilisateur) {
        if ($utilisateur['idAccees'] == 4) { // Seulement les utilisateurs avec un accès de type 4
            $xmlContent .= "\t<utilisateur id=\"" . htmlspecialchars($utilisateur['idUtilisateur']) . "\">\n";
            $xmlContent .= "\t\t<nom>" . htmlspecialchars($utilisateur['nom']) . "</nom>\n";
            $xmlContent .= "\t\t<prenom>" . htmlspecialchars($utilisateur['prenom']) . "</prenom>\n";
            $xmlContent .= "\t\t<structure_id>" . htmlspecialchars($utilisateur['idStructure']) . "</structure_id>\n";
            // Assumez que vous avez une fonction pour obtenir le nom et l'adresse de la structure par son ID
            $structure = getStructureParId($utilisateur['idStructure']);
            $xmlContent .= "\t\t<structure_nom>" . htmlspecialchars($structure['structure_nom']) . "</structure_nom>\n";
            $xmlContent .= "\t\t<structure_adresse>" . htmlspecialchars($structure['structure_adresse']) . "</structure_adresse>\n";
            $xmlContent .= "\t\t<mail>" . htmlspecialchars($utilisateur['mail']) . "</mail>\n";
            $xmlContent .= "\t</utilisateur>\n";
        }
    }

    $xmlContent .= "</utilisateurs>";

    return $xmlContent;
}

?>