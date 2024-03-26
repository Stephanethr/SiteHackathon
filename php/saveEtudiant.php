<?php
include 'connect.php';

// Récupérer les données de l'étudiant depuis la requête POST
$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$nom = $data->nom;
$prenom = $data->prenom;
$promo = $data->promo;
$skills = $data->skills;

try {
    // Vérifier si l'étudiant existe déjà en base de données
    $existingStudent = $pdo->prepare("SELECT * FROM etudiants WHERE id = :id");
    $existingStudent->execute(['id' => $id]);
    $rowCount = $existingStudent->rowCount();

    if ($rowCount > 0) {
        // L'étudiant existe déjà, mettre à jour ses données
        $query = "UPDATE etudiants SET nom = :nom, prenom = :prenom, promo = :promo, skills = :skills WHERE id = :id";
    } else {
        // L'étudiant n'existe pas encore, insérer une nouvelle entrée
        $query = "INSERT INTO etudiants (id, nom, prenom, promo, skills) VALUES (:id, :nom, :prenom, :promo, :skills)";
    }

    // Préparation de la requête
    $statement = $pdo->prepare($query);

    // Liaison des paramètres
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':nom', $nom, PDO::PARAM_STR);
    $statement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $statement->bindParam(':promo', $promo, PDO::PARAM_STR);
    $statement->bindParam(':skills', $skills, PDO::PARAM_STR);

    // Exécution de la requête
    $statement->execute();

    // Renvoyer une réponse de succès
    http_response_code(200);
    echo json_encode(array('message' => 'Données de l\'étudiant enregistrées avec succès.'));
} catch (PDOException $e) {
    // En cas d'erreur, renvoyer une réponse d'erreur
    http_response_code(500);
    echo json_encode(array('message' => 'Erreur lors de la sauvegarde des données de l\'étudiant.'));
}
?>
