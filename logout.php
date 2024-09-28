<?php
session_start(); // Démarre la session

// Supprimer toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page de login ou d'accueil
header("Location: login.html");
exit();
?>
