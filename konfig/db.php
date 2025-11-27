<?php
$host     = "localhost";
$dbname   = "db_team4_parkir";
$username = "root";
$password = "";

try {

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    // Koneksi database via PDO
    $pdo = new PDO($dsn, $username, $password);

    // Setting mode error dan fetch default
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $z) {
    die("Connection Failed: " . $z->getMessage());
}
?>