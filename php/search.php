<?php
include 'connect.php';

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
        echo "<div class='table-container'>";
        echo "<table class='table is-bordered is-striped is-hoverable is-fullwidth'>";
        echo "<thead> 
            <tr> 
                <th>ID</th>
                <th>Nom</th> 
                <th>Prénom</th>
                <th>Promotion</th>
                <th>Compétences</th>
                <th>Actions</th>
            </tr> 
            </thead>";
        echo "<tbody>";

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nom'] . "</td>";
            echo "<td>" . $row['prenom'] . "</td>";
            echo "<td>" . $row['promo'] . "</td>";
            echo "<td>" . $row['skills'] . "</td>";
            echo "<td><button class='button is-info edit-button' data-id='" . $row['id'] . "'>Modifier</button></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p class='is-size-4'>Aucun résultat trouvé</p>";
    }
} catch (PDOException $e) {
    header("Location: erreur.php");
    exit;
}
?>
