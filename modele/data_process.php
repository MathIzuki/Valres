<?php
include_once "bd.inc.php";
// Vérification des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['motdepasse'])) {
    $email = $_POST['email'];
    $motDePasse = $_POST['motdepasse'];

    // Requête pour récupérer l'utilisateur en fonction de l'email
    $stmt = connexionPDO()->prepare("SELECT * FROM utilisateur WHERE mail = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $utilisateur = $stmt->fetch();

    // Vérification du mot de passe
    if ($utilisateur && $motDePasse === $utilisateur['motDePasse']) {
        // Authentification réussie

        // Démarrage de la session et stockage des informations de l'utilisateur
        session_start();
        $_SESSION['utilisateur'] = $utilisateur;

         // Redirection vers index.php avec une alerte en JavaScript
    echo '<script>alert("Bonjour ' . $utilisateur['prenom'] . ' ' . $utilisateur['nom'] . '"); window.location.href = "../index.php";</script>';
    exit();
        // Redirection vers index.php
        header("Location: ../index.php");
        exit();
    } else {
        // Redirection vers index.php
        header("Location: ../index.php?action=Connexion");
        exit();;
    }
}
?>
