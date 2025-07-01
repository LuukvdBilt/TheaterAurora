<?php
$host = "localhost";
$dbname = "AuroraDB";  // exact zoals je database heet
$user = "root";
$password = "";

$dbFout = false;
$pdo = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $dbFout = true;
}
?>
