<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php"); exit;
}

require_once 'konfig/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM data_kendaraan WHERE id = ?");
        $stmt->execute([$id]);
        
        // Redirect back to home
        header("Location: index.php");
    } catch (PDOException $e) {
        die("Gagal menghapus: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
}
?>