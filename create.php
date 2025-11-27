<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php"); exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">🚙 Catat Kendaraan Masuk</h2>

        <!-- FORM START -->
        <!-- 'action' is where data goes. 'method' MUST be POST for saving data. -->
        <form action="store.php" method="POST">
            
            <!-- PLAT NOMOR -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Plat Nomor</label>
                <input type="text" name="plat_nomor" required placeholder="B 1234 XYZ"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- PEMILIK -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pemilik</label>
                <input type="text" name="pemilik_kendaraan" required placeholder="Nama Lengkap"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- JABATAN (Radio Buttons for quick selection) -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Status Pemilik</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="jabatan_pemilik" value="Siswa" class="form-radio text-blue-600" checked>
                        <span class="ml-2">Siswa</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="jabatan_pemilik" value="Guru" class="form-radio text-blue-600">
                        <span class="ml-2">Guru</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="jabatan_pemilik" value="Tamu" class="form-radio text-blue-600">
                        <span class="ml-2">Tamu</span>
                    </label>
                </div>
            </div>

            <!-- JENIS KENDARAAN (Select Dropdown) -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kendaraan</label>
                <select name="jenis_kendaraan" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="Motor">Motor</option>
                    <option value="Mobil">Mobil</option>
                    <option value="Sepeda">Sepeda</option>
                    <option value="Jet-Ski">Jet-Ski</option> 
                </select>
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-between items-center">
                <a href="index.php" class="text-gray-500 hover:underline">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-bold">
                    Simpan Data
                </button>
            </div>

        </form>
    </div>

</body>
</html>