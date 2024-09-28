<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    echo "Utilisateur non connecté.";
    exit;
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoire"; // Remplace par le nom de ta base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifie si le score et le jeu sont envoyés
if (isset($_POST['score']) && isset($_POST['game'])) {
    $score = floatval($_POST['score']);  // Assure que le score est bien un float avec décimales
    $game = $_POST['game'];  // Le type de jeu envoyé depuis le jeu

    // Récupérer l'ID de l'utilisateur via la session
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $userId = $user['id'];

        // Insérer le score dans la table scores avec le bon format pour le score (float avec décimales)
        $sql = "INSERT INTO scores (user_id, game_type, score, date_played) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isd", $userId, $game, $score);

        if ($stmt->execute()) {
            echo "Score enregistré avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement du score.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }

    $stmt->close();
} else {
    echo "Données manquantes ou utilisateur non connecté.";
}

// Fermer la connexion
$conn->close();
?>
