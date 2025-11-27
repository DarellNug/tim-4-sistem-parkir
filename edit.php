<?php
// Panggil koneksi database
include "konfig/db.php";

// --- KONFIGURASI ---
// Ganti dengan nama tabel yang benar di databasemu (misal: 'parkir' atau 'kendaraan')
$nama_tabel = 'data_kendaraan'; 

// 1. Ambil ID dari URL (untuk menampilkan data lama di form)
if (!isset($_GET['id'])) {
    // Jika tidak ada ID, kembalikan ke index
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Ambil data lama untuk ditampilkan di input form
$stmt = $pdo->prepare("SELECT * FROM $nama_tabel WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// 2. PROSES UPDATE SAAT TOMBOL DITEKAN
if (isset($_POST['update'])) {
    $plat    = trim($_POST['plat_nomor']);
    $jenis   = trim($_POST['jenis_kendaraan']);
    $pemilik = trim($_POST['pemilik_kendaraan']);
    $jabatan = trim($_POST['jabatan_pemilik']);
    // Jam masuk biasanya tidak diedit, tapi jika perlu silakan tambahkan

    // --- VALIDASI 1: CEK DATA KOSONG ---
    if (empty($plat) || empty($jenis) || empty($pemilik) || empty($jabatan)) {
        echo "<script>alert('Gagal! Semua kolom wajib diisi, tidak boleh kosong.');</script>";
    } else {
        
        // --- VALIDASI 2: CEK PLAT NOMOR DUPLIKAT ---
        // Logika: Cari plat nomor yang sama TAPI bukan punya ID ini
        $cek_sql = "SELECT id FROM $nama_tabel WHERE plat_nomor = ? AND id != ?";
        $stmt_cek = $pdo->prepare($cek_sql);
        $stmt_cek->execute([$plat, $id]);

        if ($stmt_cek->rowCount() > 0) {
            // Jika ketemu, berarti plat nomor sudah dipakai orang lain
            echo "<script>alert('Gagal! Plat Nomor $plat sudah terdaftar pada data lain.');</script>";
        } else {
            // --- EKSEKUSI UPDATE ---
            try {
                // Update timestamp otomatis diperbarui oleh MySQL jika setting kolomnya 'ON UPDATE CURRENT_TIMESTAMP'
                // Atau kita update manual kolom 'jam_diubah' (jika ada)
                $sql_update = "UPDATE $nama_tabel SET 
                                plat_nomor = ?, 
                                jenis_kendaraan = ?, 
                                pemilik_kendaraan = ?, 
                                jabatan_pemilik = ? 
                                WHERE id = ?";
                
                $stmt_update = $pdo->prepare($sql_update);
                $stmt_update->execute([$plat, $jenis, $pemilik, $jabatan, $id]);

                echo "<script>
                        alert('Data berhasil diperbarui!');
                        window.location='index.php';
                      </script>";
            } catch (PDOException $e) {
                echo "Error Database: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Kendaraan</title>
</head>
<body>
    <h2>Edit Data</h2>
    
    <form method="POST" action="">
        <label>Plat Nomor:</label><br>
        <input type="text" name="plat_nomor" value="<?php echo htmlspecialchars($data['plat_nomor']); ?>" required>
        <br><br>

        <label>Jenis Kendaraan:</label><br>
        <select name="jenis_kendaraan" required>
            <option value="Motor" <?php if($data['jenis_kendaraan'] == 'Motor') echo 'selected'; ?>>Motor</option>
            <option value="Mobil" <?php if($data['jenis_kendaraan'] == 'Mobil') echo 'selected'; ?>>Mobil</option>
            <option value="Truk" <?php if($data['jenis_kendaraan'] == 'Truk') echo 'selected'; ?>>Truk</option>
        </select>
        <br><br>

        <label>Pemilik Kendaraan:</label><br>
        <input type="text" name="pemilik_kendaraan" value="<?php echo htmlspecialchars($data['pemilik_kendaraan']); ?>" required>
        <br><br>

        <label>Jabatan:</label><br>
        <input type="text" name="jabatan_pemilik" value="<?php echo htmlspecialchars($data['jabatan_pemilik']); ?>" required>
        <br><br>

        <button type="submit" name="update">Simpan Perubahan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>