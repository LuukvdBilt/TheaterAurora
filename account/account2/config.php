<?php
$dbHost = 'localhost';
$dbName = 'AuroraDB';
$dbUser = 'root';
$dbPass = ''; // of je echte wachtwoord

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbinding met database mislukt: " . $e->getMessage());
}
