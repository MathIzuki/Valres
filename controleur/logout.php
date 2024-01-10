<?php
session_start();
// Détruit toutes les données de la session
session_destroy();

// Redirection vers index.php
header("Location: ../index.php");
exit;
?>

