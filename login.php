<?php
session_start(); // Démarre la session

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoire"; // Remplace par le nom de ta base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête SQL pour récupérer l'utilisateur avec le nom d'utilisateur fourni
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Vérification si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        // Enregistrer le nom d'utilisateur dans la session
        $_SESSION['username'] = $username;

        // Rediriger vers la page d'accueil après connexion réussie
        header("Location: accueiljeu.php");
        exit(); // Arrête l'exécution du script après la redirection
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }

    $stmt->close();
}

$conn->close();
?>
