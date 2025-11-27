<?php
session_start();

// Pastikan jalur file ini benar sesuai struktur foldermu.
// Jika file koneksi ada di folder yang sama, cukup: include "db_connection.php";
// Di sini saya pakai asumsi kamu, yaitu ada folder 'konfig'
include "konfig/db.php"; 

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Ambil data user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $data = $stmt->fetch();

    // 2. Cek Password (TANPA ENKRIPSI)
    // Kita cek apakah data user ditemukan DAN password input sama persis dengan password di database
    if($data && $password === $data['password']) {
        
        // Login Berhasil
        // Catatan: Pastikan kolom di database namanya 'username', sesuaikan jika pakai 'nama'
        $_SESSION['user'] = $data['username']; 
        
        header("location:index.php");
        exit;
    } else {
        // Login Gagal
        echo "<script>alert('Username atau password salah!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>

<h2>LOGIN</h2>
<form method="POST" action="">
    <input type="text" name="username" placeholder="Masukkan Username" required><br><br>
    <input type="password" name="password" placeholder="Masukkan Password" required><br><br>
    <button type="submit" name="login">Masuk</button>
</form>

<p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

</body>
</html>