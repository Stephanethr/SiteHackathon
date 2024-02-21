<body>
    <h1>Il semblerait qu'aucune base de données n'existe !</h1>
    <h2>Veuillez téléverser un fichier CSV contenant la base de données</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv">
        <button type="submit" name="submit">Envoyer</button>
    </form>

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
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["csv_file"]["name"]);

        $table = "etudiants";
        // Déplacer le fichier téléversé dans le répertoire de sauvegarde
        if (move_uploaded_file($_FILES["csv_file"]["tmp_name"], $targetFile)) {
            // Ouvrir le fichier CSV
            if (($handle = fopen($targetFile, "r")) !== FALSE) {
                // Préparation de la requête d'insertion
                $insert = "INSERT INTO $table (nom, prenom, promo) VALUES (:nom, :prenom, :promo)";
                $stmt = $pdo->prepare($insert);

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
            echo "<p>Les données ont été insérées avec succès dans la base de données.</p>";
            echo "<p>Vous serez redirigé sur la page d'accueil dans 5 secondes.</p>";
            header("refresh:5;url=index.html");
            exit;
        } else {
            echo "Impossible d'ouvrir le fichier CSV.";
        }
    }
    ?>
</body>

</html>