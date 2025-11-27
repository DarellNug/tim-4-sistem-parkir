<?php
session_start();
require "konfig/db.php"; // pastikan path sama

$user = $_POST['username'];
$pass = $_POST['password'];

// Gunakan PDO, bukan mysqli_query()
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->execute([$user, $pass]);
$data = $stmt->fetch();

if($data){
    $_SESSION['user'] = $data['username'];
    header("Location: index.php");
    exit;
}else{
    echo "<script>alert('Login gagal! Username/Password salah.'); window.location='login.php';</script>";
}
?>
