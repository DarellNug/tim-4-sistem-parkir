DROP DATABASE IF EXISTS db_team4_parkir;
CREATE DATABASE db_team4_parkir;
USE db_team4_parkir;

CREATE TABLE data_kendaraan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plat_nomor VARCHAR(15) NOT NULL,
    jenis_kendaraan ENUM("Motor", "Mobil", "Sepeda", "Jet-Ski") NOT NULL,
    pemilik_kendaraan VARCHAR(100) NOT NULL,
    jabatan_pemilik ENUM("Siswa", "Guru", "Staf", "Tamu") NOT NULL,
    jam_masuk DATETIME DEFAULT CURRENT_TIMESTAMP,
    jam_diubah DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (plat_nomor)
);

