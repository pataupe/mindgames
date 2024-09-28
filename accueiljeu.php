<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Site de Jeux</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }
        .container {
            width: 60%;
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 36px;
            margin-bottom: 40px;
        }
        .button-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        a {
            display: inline-block;
            padding: 15px 25px;
            font-size: 18px;
            background-color: #4A90E2;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        a:hover {
            background-color: #357ABD;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .button-game {
            background-color: #4A90E2;
        }
        .button-leaderboard {
            background-color: #f39c12;
        }
        .button-leaderboard:hover {
            background-color: #e67e22;
        }
        .logout {
            margin-top: 30px;
            display: inline-block;
            background-color: #e74c3c;
        }
        .logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <a href="http://localhost" style="position: absolute; top: 0; left: 0; margin: 0; padding: 0; border: none; background: none;color:black"> localhost </a>
    <div class="container">
        <h1>Bienvenue !</h1>

        <div class="button-grid">
            <a class="button-game" href="javascript:void(0);" onclick="checkLogin('calculV6.html')">Jouer à Calcul 20</a>
            <a class="button-leaderboard" href="leaderboard.php?game=calcul20">Leaderboard - Calcul 20</a>

            <a class="button-game" href="javascript:void(0);" onclick="checkLogin('tricalculV3.html')">Jouer à Tricalcul</a>
            <a class="button-leaderboard" href="leaderboard.php?game=tricalcul">Leaderboard - Tricalcul</a>

            <a class="button-game" href="javascript:void(0);" onclick="checkLogin('memoire.html')">Jouer à Mémoire</a>
            <a class="button-leaderboard" href="leaderboard.php?game=memoire">Leaderboard - Mémoire</a>
        </div>

        <a class="logout" href="logout.php">Déconnexion</a>
    </div>

    <script>
        const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;

        function checkLogin(gameUrl) {
            if (!isLoggedIn) {
                window.location.href = 'login.html';
            } else {
                window.location.href = gameUrl;
            }
        }
    </script>
</body>
</html>
