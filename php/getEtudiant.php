<?php
include 'connect.php';

// Récupérer l'ID de l'étudiant depuis la requête GET
$id = $_GET['id'];

try {
    // Préparation de la requête SQL
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = :id");

    // Liaison des paramètres et exécution de la requête
    $stmt->execute(['id' => $id]);

    // Récupérer les données de l'étudiant
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Renvoyer les données de l'étudiant au format JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    // En cas d'erreur, renvoyer une réponse d'erreur
    http_response_code(500);
    echo json_encode(array('message' => 'Erreur lors de la récupération des données de l\'étudiant.'));
}
?>
