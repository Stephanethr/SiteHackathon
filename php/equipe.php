<?php
// Inclure la connexion à la base de données
include 'connect.php';

// Vérifier si une action est spécifiée dans la requête
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Exécuter différentes actions en fonction de la demande
    switch ($action) {
        case 'fetch':
            // Charger toutes les équipes depuis la base de données
            $teams = fetchTeams($pdo);
            echo json_encode($teams);
            break;
        case 'create':
            // Créer une nouvelle équipe avec le nom fourni
            if (isset($_POST['teamName'])) {
                $teamName = $_POST['teamName'];
                createTeam($pdo, $teamName);
            } else {
                echo 'Erreur: Nom de l\'équipe non spécifié.';
            }
            break;
        // Ajouter d'autres cas d'action au besoin
        default:
            echo 'Erreur: Action non reconnue.';
            break;
    }
}

// Fonction pour charger toutes les équipes depuis la base de données
function fetchTeams($pdo) {
    $stmt = $pdo->query("SELECT * FROM equipes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour créer une nouvelle équipe avec le nom spécifié
function createTeam($pdo, $teamName) {
    $stmt = $pdo->prepare("INSERT INTO equipes (name, date) VALUES (:name, NOW())");
    $stmt->bindParam(':name', $teamName);
    if ($stmt->execute()) {
        echo 'Équipe créée avec succès.';
    } else {
        echo 'Erreur lors de la création de l\'équipe.';
    }
}
?>
