<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php"); exit;
}

// 1. Connect to Database
require_once 'konfig/db.php';

// 2. Check if the form was actually submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 3. Collect Data from the Form
    // Pro Tip: 'strtoupper' ensures B 1234 xy becomes B 1234 XY automatically
    $plat_nomor = strtoupper($_POST['plat_nomor']); 
    $pemilik = $_POST['pemilik_kendaraan'];
    $jabatan = $_POST['jabatan_pemilik'];
    $jenis = $_POST['jenis_kendaraan'];

    // 4. Validation (Basic)
    // Even though HTML has 'required', we check again in PHP for security.
    if (empty($plat_nomor) || empty($pemilik)) {
        die("Harap isi semua data!");
    }

    try {
        // 5. Prepare the SQL (The Safe Way)
        // We use :placeholders instead of putting variables directly in SQL
        $sql = "INSERT INTO data_kendaraan (plat_nomor, pemilik_kendaraan, jabatan_pemilik, jenis_kendaraan) 
                VALUES (:plat, :pemilik, :jabatan, :jenis)";
        
        $stmt = $pdo->prepare($sql);

        // 6. Execute the Query
        $stmt->execute([
            ':plat' => $plat_nomor,
            ':pemilik' => $pemilik,
            ':jabatan' => $jabatan,
            ':jenis' => $jenis
        ]);

        // 7. Redirect back to Dashboard on success
        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        // If something breaks (like duplicate ID), show error
        echo "Gagal menyimpan data: " . $e->getMessage();
    }
}
?>