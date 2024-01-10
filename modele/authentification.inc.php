<?php
// Inclusion du fichier de connexion à la base de données
session_start();

function estConnecte(){
    return isset($_SESSION['utilisateur']);
}

function estAdmin(){
    $idAcces = (int)$_SESSION['utilisateur']['idAccees'];
    return estConnecte() && $idAcces === 1;
}

function estSecretaire(){
    $idAcces = (int)$_SESSION['utilisateur']['idAccees'];
    return estConnecte() && $idAcces === 2;
}

function estResponsable(){
    $idAcces = (int)$_SESSION['utilisateur']['idAccees'];
    return estConnecte() && $idAcces === 3;
}

function estUtilisateur(){
    $idAcces = (int)$_SESSION['utilisateur']['idAccees'];
    return estConnecte() && $idAcces === 4;
}


// Fonction pour obtenir le nom de l'utilisateur depuis la session
function getNom(){
    if(estConnecte()){
        return $_SESSION['utilisateur']['nom'];
    }
    return null; // Retourne null si l'utilisateur n'est pas connecté ou si le nom n'est pas défini dans la session
}

// Fonction pour obtenir le prénom de l'utilisateur depuis la session
function getPrenom(){
    if(estConnecte()){
        return $_SESSION['utilisateur']['prenom'];
    }
    return null; // Retourne null si l'utilisateur n'est pas connecté ou si le prénom n'est pas défini dans la session
}

// Fonction pour obtenir l'email de l'utilisateur depuis la session
function getMail(){
    if(estConnecte()){
        return $_SESSION['utilisateur']['mail'];
    }
    return null; // Retourne null si l'utilisateur n'est pas connecté ou si l'email n'est pas défini dans la session
}
?>
