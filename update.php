<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php"); exit;
}

require_once 'konfig/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $plat = strtoupper($_POST['plat_nomor']);
    $pemilik = $_POST['pemilik_kendaraan'];
    $jabatan = $_POST['jabatan_pemilik'];
    $jenis = $_POST['jenis_kendaraan'];

    try {
        $sql = "UPDATE data_kendaraan 
                SET plat_nomor = ?, 
                    pemilik_kendaraan = ?, 
                    jabatan_pemilik = ?, 
                    jenis_kendaraan = ? 
                WHERE id = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$plat, $pemilik, $jabatan, $jenis, $id]);

        header("Location: index.php");
    } catch (PDOException $e) {
        die("Gagal update: " . $e->getMessage());
    }
}
?>