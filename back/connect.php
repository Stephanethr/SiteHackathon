<?php
include 'config.php';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",  $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}