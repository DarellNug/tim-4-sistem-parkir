<?php
// 1. Panggil koneksi database (PDO)
include "konfig/db.php";

try {
    // --- PENTING: GANTI 'kendaraan' DI BAWAH INI SESUAI NAMA TABELMU ---
    // (Misalnya: 'data_parkir', 'transaksi', atau 'kendaraan')
    $nama_tabel = 'data_kendaraan'; 
    
    // Query mengambil semua data
    $sql = "SELECT * FROM $nama_tabel ORDER BY jam_masuk DESC"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Laporan Data Parkir</title>
        <style>
            /* CSS Sederhana agar tabel rapi saat diprint */
            body { font-family: sans-serif; }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 10px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .no-print {
                margin-bottom: 20px;
            }
            /* Menyembunyikan tombol saat dicetak kertas */
            @media print {
                .no-print { display: none; }
            }
        </style>
    </head>
    <body>

        <h2 align="center">Laporan Data Parkir</h2>
        
        <div class="no-print">
            <button onclick="window.print()">Cetak Laporan</button>
            <a href="index.php"><button>Kembali</button></a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Kendaraan</th>
                    <th>Pemilik</th>
                    <th>Jabatan</th>
                    <th>Jam Masuk</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                // Looping data dari database
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['plat_nomor']); ?></td>
                    <td><?php echo htmlspecialchars($row['jenis_kendaraan']); ?></td>
                    <td><?php echo htmlspecialchars($row['pemilik_kendaraan']); ?></td>
                    <td><?php echo htmlspecialchars($row['jabatan_pemilik']); ?></td>
                    <td><?php echo htmlspecialchars($row['jam_masuk']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </body>
    </html>

    <?php
} catch (PDOException $e) {
    // Tampilkan error jika nama tabel salah atau koneksi gagal
    echo "<h3>Terjadi Kesalahan:</h3>";
    echo "<p>Pesan Error: " . $e->getMessage() . "</p>";
    echo "<p><em>Tips: Pastikan variabel <b>\$nama_tabel</b> di baris 8 sudah sesuai dengan nama tabel di database kamu.</em></p>";
}
?>