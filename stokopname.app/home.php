<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Stok Opname</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for subtle animations and depth */
        .card-menu {
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.05); /* initial subtle shadow */
        }
        .card-menu:hover {
            transform: translateY(-8px) scale(1.02); /* lift and slightly grow on hover */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), 0 20px 40px rgba(0, 0, 0, 0.1); /* more prominent shadow on hover */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 min-h-screen flex items-center justify-center p-4 font-sans antialiased">

    <div class="bg-white shadow-2xl rounded-3xl p-8 sm:p-10 w-full max-w-5xl ring-1 ring-gray-100 backdrop-blur-sm bg-opacity-95">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-10 border-b pb-6 border-gray-200">
            <div class="text-center sm:text-left">
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Halo, <span class="text-blue-600"><?= htmlspecialchars($_SESSION['username'] ?? 'Pengguna') ?></span>!
                </h1>
                <p class="text-gray-600 text-lg mt-2">Selamat datang di Dashboard Stok Opname.</p>
            </div>
            <a href="logout.php" class="mt-6 sm:mt-0 px-6 py-2 bg-purple-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                <svg class="w-5 h-5 inline-block mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 text-center">

            <a href="scan_barang.php" class="card-menu bg-white border border-blue-200 rounded-2xl p-6 shadow-lg hover:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-200 focus:ring-opacity-75">
                <div class="flex justify-center mb-4">
                    <img src="https://img.icons8.com/3d-fluency/100/camera.png" alt="Scan" class="w-16 h-16" />
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-1">Scan Barang</h2>
                <p class="text-gray-500 text-sm">Cepat melakukan stok opname dengan pemindaian.</p>
            </a>

            <a href="data_barang.php" class="card-menu bg-white border border-green-200 rounded-2xl p-6 shadow-lg hover:border-green-300 focus:outline-none focus:ring-4 focus:ring-green-200 focus:ring-opacity-75">
                <div class="flex justify-center mb-4">
                    <img src="https://img.icons8.com/3d-fluency/100/database.png" alt="Data Barang" class="w-16 h-16" />
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-1">Data Master Barang</h2>
                <p class="text-gray-500 text-sm">Kelola daftar produk dan inventaris Anda.</p>
            </a>

            <a href="laporan.php" class="card-menu bg-white border border-purple-200 rounded-2xl p-6 shadow-lg hover:border-purple-300 focus:outline-none focus:ring-4 focus:ring-purple-200 focus:ring-opacity-75">
                <div class="flex justify-center mb-4">
                    <img src="https://img.icons8.com/3d-fluency/100/report-file.png" alt="Laporan" class="w-20 h-20" />
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-1">Laporan Stok Opname</h2>
                <p class="text-gray-500 text-sm">Lihat ringkasan dan analisis data stok.</p>
            </a>

        </div>
    </div>

</body>
</html>