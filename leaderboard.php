<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoire"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si le paramètre 'game' est passé dans l'URL
$gameType = isset($_GET['game']) ? $_GET['game'] : 'calcul';

// Définir le titre en fonction du jeu
$gameTitle = '';
switch ($gameType) {
    case 'calcul20':
        $gameTitle = 'Leaderboard - Calcul 20';
        break;
    case 'tricalcul':
        $gameTitle = 'Leaderboard - Tricalcul';
        break;
    case 'memoire':
        $gameTitle = 'Leaderboard - Mémoire';
        break;
    default:
        die('Jeu invalide.');
}


$orderBy = ($gameType === 'calcul20' || $gameType === 'tricalcul') ? 'ASC' : 'DESC';
$sql = "SELECT users.username, scores.score, scores.date_played 
        FROM scores 
        JOIN users ON scores.user_id = users.id 
        WHERE scores.game_type = ? 
        ORDER BY scores.score $orderBy 
        LIMIT 10"; 

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $gameType);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $gameTitle; ?></title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
           
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        table {
             border-collapse: collapse;
            width: 55%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            left: 50%; /* Shifts to the right by 50% of its container */
            transform: translateX(-50%); /* Brings it back to the center */
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4A90E2;
            color: white;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
		
		div {
			margin: 110px auto
		}
		
		.btn {
			 padding: 10px 20px;
            font-size: 16px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
			position: absolute;
			top: 15px;
			left: 28px;
		}
    </style>
</head>
<body>
<a class="btn" href="accueiljeu.php"> Accueil </a>
    <div>
        <h1><?php echo $gameTitle; ?></h1>
        <table>
            <tr>
                <th>Utilisateur</th>
                <th>Score</th>
                <th>Date</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['score']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date_played']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Aucun score enregistré.</td></tr>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>

