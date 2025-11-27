<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php"); exit;
}


require_once "konfig/db.php";

// PHP LOGIC (Unchanged)
$cari = $_GET["q"] ?? ""; 
if ($cari) {
    $sql = "SELECT * FROM data_kendaraan WHERE plat_nomor LIKE :search ORDER BY jam_masuk DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$cari%"]);
} else {
    $sql = "SELECT * FROM data_kendaraan ORDER BY jam_masuk DESC";
    $stmt = $pdo->query($sql);
}
$list_kendaraan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CONFIG FOR TAILWIND COLORS -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        mono: ['Orbitron', 'monospace'],
                    },
                    colors: {
                        cyber: {
                            black: '#0a0a0f',
                            dark: '#13131f',
                            panel: '#1c1c2e',
                            neon: '#00f3ff',
                            purple: '#bc13fe',
                            pink: '#ff0055'
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a0f; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #00f3ff; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .dark .glass-panel {
            background: rgba(19, 19, 31, 0.6);
            border: 1px solid rgba(0, 243, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 dark:bg-cyber-black dark:text-gray-200 transition-colors duration-500 font-sans min-h-screen">

    <!-- BACKGROUND EFFECTS (Dark Mode Only) -->
    <div class="fixed inset-0 pointer-events-none hidden dark:block">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-cyber-purple/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-cyber-neon/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto p-6 sm:p-8">
        
        <!-- HEADER -->
        <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-cyber-purple to-cyber-neon rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(0,243,255,0.5)]">
                    <span class="text-2xl">APA WEH</span>
                </div>
                <div>
                    <h1 class="text-4xl font-mono font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-cyber-neon dark:to-cyber-purple">
                        Sistem Parkir Kendaraan Siswa & Guru
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 tracking-widest uppercase">SMK AK NUSA BANGSA BOGOR</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- THEME TOGGLE -->
                <button id="theme-toggle" class="glass-panel p-3 rounded-full hover:bg-gray-200 dark:hover:bg-cyber-neon/20 transition-all duration-300 group">
                    <!-- Sun Icon -->
                    <svg class="w-6 h-6 text-orange-500 hidden dark:block group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <!-- Moon Icon -->
                    <svg class="w-6 h-6 text-slate-700 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>

                <!-- ADD BUTTON -->
                <a href="create.php" class="relative overflow-hidden group bg-blue-600 dark:bg-transparent dark:border dark:border-cyber-neon text-white px-8 py-3 rounded-lg font-bold tracking-wide transition-all hover:shadow-[0_0_20px_rgba(0,243,255,0.4)]">
                    <span class="absolute inset-0 w-full h-full bg-cyber-neon/20 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></span>
                    <span class="relative flex items-center gap-2">
                        <span>+</span> Tambah Data
                    </span>
                </a>
            </div>
        </header>

        <!-- CONTROL PANEL -->
        <div class="glass-panel rounded-2xl p-1 mb-8 shadow-xl">
            <form action="" method="GET" class="flex flex-col md:flex-row gap-0">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="q" value="<?= htmlspecialchars($cari) ?>" placeholder="Search License Plate ID..." 
                        class="w-full bg-transparent border-none text-gray-800 dark:text-white placeholder-gray-500 py-4 pl-12 pr-4 focus:ring-0 text-lg font-light tracking-wide outline-none">
                </div>
                <button type="submit" class="bg-gray-200 dark:bg-cyber-neon/10 text-gray-700 dark:text-cyber-neon hover:bg-gray-300 dark:hover:bg-cyber-neon hover:text-gray-900 dark:hover:text-black px-8 py-3 md:py-0 md:rounded-r-xl font-mono font-bold transition-all uppercase text-sm tracking-wider">
                    Cari
                </button>
                <?php if($cari): ?>
                    <a href="index.php" class="flex items-center px-6 text-pink-500 hover:text-pink-400 font-mono text-xs uppercase tracking-widest border-l border-gray-300 dark:border-gray-700">
                        [ Clear ]
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- DATA GRID -->
        <div class="glass-panel rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-200 dark:bg-cyber-dark/80 text-gray-600 dark:text-gray-400 uppercase text-xs font-mono tracking-wider">
                        <tr>
                            <th class="py-5 px-6 font-semibold">Nomor Plat</th>
                            <th class="py-5 px-6 font-semibold">Pemilik</th>
                            <th class="py-5 px-6 font-semibold">Jenis Kendaraan</th>
                            <th class="py-5 px-6 font-semibold">Jam Masuk</th>
                            <th class="py-5 px-6 text-center font-semibold">CRUD</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800/50">
                        <?php if(count($list_kendaraan) > 0): ?>
                            <?php foreach($list_kendaraan as $row): ?>
                            <tr class="group hover:bg-white/50 dark:hover:bg-cyber-neon/5 transition-colors duration-200">
                                <!-- PLATE -->
                                <td class="py-4 px-6">
                                    <span class="font-mono text-lg font-bold text-gray-800 dark:text-cyber-neon border-l-2 border-blue-500 dark:border-cyber-neon pl-3">
                                        <?= htmlspecialchars($row['plat_nomor']) ?>
                                    </span>
                                </td>
                                
                                <!-- OWNER -->
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-gray-700 dark:text-white"><?= htmlspecialchars($row['pemilik_kendaraan']) ?></div>
                                    <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-xs font-medium 
                                        <?= $row['jabatan_pemilik'] == 'Siswa' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' ?>
                                        <?= $row['jabatan_pemilik'] == 'Guru' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300' : '' ?>
                                        <?= $row['jabatan_pemilik'] == 'Tamu' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300' : '' ?>
                                        <?= $row['jabatan_pemilik'] == 'Staf' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' ?>">
                                        <?= htmlspecialchars($row['jabatan_pemilik']) ?>
                                    </span>
                                </td>

                                <!-- TYPE -->
                                <td class="py-4 px-6 text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center gap-2">
                                        <!-- Simple Icons based on type -->
                                        <span>
                                            <?= $row['jenis_kendaraan'] == 'Motor' ? '🏍️' : '' ?>
                                            <?= $row['jenis_kendaraan'] == 'Mobil' ? '🚗' : '' ?>
                                            <?= $row['jenis_kendaraan'] == 'Sepeda' ? '🚲' : '' ?>
                                            <?= $row['jenis_kendaraan'] == 'Jet-Ski' ? '🚤' : '' ?>
                                        </span>
                                        <?= htmlspecialchars($row['jenis_kendaraan']) ?>
                                    </div>
                                </td>

                                <!-- TIME -->
                                <td class="py-4 px-6 font-mono text-sm text-gray-500 dark:text-gray-400">
                                    <?= date('d M Y', strtotime($row['jam_masuk'])) ?>
                                    <span class="block text-xs opacity-60"><?= date('H:i:s', strtotime($row['jam_masuk'])) ?></span>
                                </td>

                                <!-- ACTIONS -->
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="p-2 text-blue-600 dark:text-cyber-neon hover:bg-blue-100 dark:hover:bg-cyber-neon/20 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <a href="delete.php?id=<?= $row['id'] ?>" 
                                           class="p-2 text-red-600 dark:text-cyber-pink hover:bg-red-100 dark:hover:bg-cyber-pink/20 rounded-lg transition-colors"
                                           onclick="return confirm('WARNING: Deleting record from database. Confirm?')" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-500">
                                        <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-lg font-light">No Data Found in Sector 7</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- FOOTER STATS -->
            <div class="bg-gray-200 dark:bg-black/40 p-4 border-t border-gray-300 dark:border-white/10 flex justify-between items-center text-xs font-mono text-gray-500 dark:text-gray-400">
                <span>Total Kendaraan: <?= count($list_kendaraan) ?></span>
                <span>Status Database: <span class="text-green-500">Berjalan</span></span>
            </div>
        </div>
    </div>

    <!-- SCRIPT FOR DARK MODE TOGGLE -->
    <script>
        const html = document.documentElement;
        const toggleBtn = document.getElementById('theme-toggle');

        // 1. Check LocalStorage or System Preference on Load
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        // 2. Toggle Function
        toggleBtn.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    </script>
    <a href="print.php" target="_blank">Print Data</a>
</body>
</html>