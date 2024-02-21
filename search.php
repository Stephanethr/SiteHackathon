<?php
include './back/connect.php';

// Récupérer la valeur de recherche
$query = $_POST['query'];

try {    
    // Préparation de la requête SQL
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE nom LIKE :query OR prenom LIKE :query");
    
    // Liaison des paramètres et exécution de la requête
    $stmt->execute(array(':query' => '%' . $query . '%'));
    
    // Récupérer les résultats de la recherche
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Affichage des résultats de la recherche
    if (count($results) > 0) {
        foreach ($results as $row) {
            echo "<p>" . $row['nom'] . " " . $row['prenom'] . "</p>";
        }
    } else {
        echo "Aucun résultat trouvé";
    }
} catch (PDOException $e) {
    header("Location: erreur.php");
    exit;
}
?>
