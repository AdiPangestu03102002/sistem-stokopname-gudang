<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';
$query = $cari ?
    "SELECT * FROM barang WHERE nama_barang LIKE '%$cari%' OR kode_barang LIKE '%$cari%' OR kategori LIKE '%$cari%'" :
    "SELECT * FROM barang ORDER BY nama_barang ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar untuk tabel */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: #cbd5e0; /* gray-400 */
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background-color: #f7fafc; /* gray-50 */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-6 font-sans antialiased">

<div class="bg-white shadow-lg rounded-xl p-6 sm:p-8 max-w-6xl mx-auto ring-1 ring-gray-200">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 border-b pb-4 border-gray-200">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-extrabold text-gray-800">Data Barang</h2>
        </div>
        <a href="tambah_barang.php" class="mt-4 md:mt-0 bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            <span class="mr-1">+</span> Tambah Barang Baru
        </a>
    </div>

    <form method="GET" action="data_barang.php" class="mb-6 flex flex-col sm:flex-row gap-4">
        <input type="text" name="cari" placeholder="Cari berdasarkan nama, kode, atau kategori..."
               value="<?= htmlspecialchars($cari) ?>"
               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-700 shadow-sm">
        <button type="submit" class="bg-purple-600 text-white px-5 py-2 rounded-lg hover:purple-700 transition duration-200 shadow-md transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
            Cari Data
        </button>
        <?php if ($cari): ?>
        <a href="data_barang.php" class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600 transition duration-200 shadow-md transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 text-center sm:w-auto">
            Reset
        </a>
        <?php endif; ?>
    </form>

    <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-5 py-3 border-b border-gray-200 font-semibold">Kode Barang</th>
                    <th class="px-5 py-3 border-b border-gray-200 font-semibold">Nama Barang</th>
                    <th class="px-5 py-3 border-b border-gray-200 font-semibold">Kategori</th>
                    <th class="px-5 py-3 border-b border-gray-200 font-semibold text-center">Jumlah</th>
                    <th class="px-5 py-3 border-b border-gray-200 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-5 py-3 whitespace-nowrap"><?= htmlspecialchars($row['kode_barang']) ?></td>
                            <td class="px-5 py-3 whitespace-nowrap font-medium text-gray-800"><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td class="px-5 py-3 whitespace-nowrap"><?= htmlspecialchars($row['kategori']) ?></td>
                            <td class="px-5 py-3 whitespace-nowrap text-center"><?= htmlspecialchars($row['jumlah']) ?></td>
                            <td class="px-5 py-3 whitespace-nowrap text-center space-x-3">
                                <a href="edit_barang.php?id=<?= $row['id_barang'] ?>" class="text-blue-600 hover:text-blue-800 font-medium transition duration-150 ease-in-out">Edit</a>
                                <a href="hapus_barang.php?id=<?= $row['id_barang'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini? Tindakan ini tidak bisa dibatalkan.')" class="text-red-600 hover:text-red-800 font-medium transition duration-150 ease-in-out">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-500 text-lg">
                            <p class="mb-2">Tidak ada data barang yang ditemukan.</p>
                            <?php if ($cari): ?>
                                <p>Coba sesuaikan kata kunci pencarian Anda.</p>
                            <?php else: ?>
                                <p>Silakan tambahkan barang baru untuk memulai.</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-8 text-center">
        <a href="home.php" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-150 ease-in-out">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
            Kembali ke Dashboard
        </a>
        <a href="logout.php" class="ml-4 inline-flex items-center text-gray-500 hover:text-gray-700 font-medium transition duration-150 ease-in-out">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Logout
        </a>
    </div>
</div>

</body>
</html>