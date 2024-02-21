<?php

include "config.php";
// Connexion à MySQL
try {
    $pdo = new PDO("mysql:host=$host",  $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à MySQL : " . $e->getMessage());
}

$table1 = 'etudiants';
$table2 = 'equipes';
$table3 = 'etu_equipes';

// Requête SQL pour créer la base de données
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
// Exécuter la requête de création de la base de données
try {
    $pdo->exec($sql);
} catch (PDOException $e) {
    die("Erreur lors de la création de la base de données : " . $e->getMessage());
}

// Requête SQL pour créer les tables
$sql = "CREATE TABLE IF NOT EXISTS etudiants (
    id INT(6) AUTO_INCREMENT,
    nom VARCHAR(30) NOT NULL,
    prenom VARCHAR(30) NOT NULL,
    promo VARCHAR(30) NOT NULL,
    skills VARCHAR(30),
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS equipes (
    id INT(6) AUTO_INCREMENT,
    nom VARCHAR(30) NOT NULL,
    date DATE NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS etu_equipes (
    id_etu INT(6),
    id_equipe INT(6),
    PRIMARY KEY (id_etu, id_equipe),
    FOREIGN KEY (id_etu) REFERENCES etudiants(id),
    FOREIGN KEY (id_equipe) REFERENCES equipes(id)
);";

// Exécuter la requête de création de la table

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",  $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec($sql);
    echo "Les tables $table1, $table2, $table3 ont été créées avec succès.<br>";
} catch (PDOException $e) {
    die("Erreur lors de la création de la table : " . $e->getMessage());
}
