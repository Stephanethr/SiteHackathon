<?php
// Vérifier si un fichier a été téléversé
if (isset($_FILES["csv_file"])) {
    // Paramètres de connexion à la base de données
    include 'createDB.php';

    // Connexion à la base de données
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Chemin de sauvegarde du fichier téléversé
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($_FILES["csv_file"]["name"]);

    $table = "etudiants";
    // Déplacer le fichier téléversé dans le répertoire de sauvegarde
    if (move_uploaded_file($_FILES["csv_file"]["tmp_name"], $targetFile)) {
        // Préparation de la requête d'insertion
        $insert = "INSERT INTO $table (nom, prenom, promo) VALUES (:nom, :prenom, :promo)";
        $stmt = $pdo->prepare($insert);

        // Ouvrir le fichier CSV
        if (($handle = fopen($targetFile, "r")) !== FALSE) {

            // Boucle sur chaque ligne du fichier CSV
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                // Assignation des données de la ligne à des variables
                $nom = $data[0];
                $prenom = $data[1];
                $promo = $data[2];

                // Exécution de la requête d'insertion avec les valeurs de la ligne

                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':promo', $promo);
                $stmt->execute();
            }
        }
        fclose($handle);
        echo "Téléversement réussi."; // Réponse au client
        
    } else {
        echo "Impossible d'ouvrir le fichier CSV."; // Réponse au client
    }
}

?>
