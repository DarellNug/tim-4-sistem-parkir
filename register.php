<?php
// register.php
$host = 'localhost';
$dbname = 'db_team4_parkir';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user  = $_POST['username'];
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    if (!empty($user) && !empty($email) && !empty($pass)) {
        // SQL Insert (Password disimpan plain text sesuai permintaanmu)
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :pass)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute(['username' => $user, 'email' => $email, 'pass' => $pass]);
            
            // --- LOGIKA ROUTING ---
            // Jika berhasil, langsung arahkan ke login.php
            header("Location: login.php");
            exit(); // Selalu gunakan exit setelah header redirect
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Mohon isi semua kolom.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h2>Halaman Register</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>