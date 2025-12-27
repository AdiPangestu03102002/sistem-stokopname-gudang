<?php
include 'koneksi.php';

// Filter tanggal
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Pencarian
$search = $_GET['search'] ?? '';

// Query Join
$query = "
    SELECT so.id_so, b.nama_barang, b.kode_barang, so.tanggal_so, so.jumlah_stok, so.catatan
    FROM stok_opname so
    JOIN barang b ON so.id_barang = b.id_barang
    WHERE 1=1
";

// Filter tanggal
if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND so.tanggal_so BETWEEN '$start_date' AND '$end_date'";
}

// Filter pencarian
if (!empty($search)) {
    $query .= " AND (b.nama_barang LIKE '%$search%' OR b.kode_barang LIKE '%$search%')";
}

$query .= " ORDER BY so.tanggal_so DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Opname</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Optional: Custom scrollbar for table if needed */
        .table-wrapper {
            overflow-x: auto; /* Enable horizontal scrolling on small screens */
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center p-6 font-sans antialiased">

    <div class="bg-white shadow-xl rounded-2xl p-6 sm:p-8 w-full max-w-5xl ring-1 ring-gray-100 mb-8">

        <div class="flex items-center justify-center mb-8 border-b pb-4 border-gray-200">
           
            <h1 class="text-3xl font-extrabold text-gray-800">Laporan Stok Opname</h1>
        </div>
        <p class="text-center text-gray-600 mb-8">Lihat dan filter data hasil stok opname barang.</p>

        <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-8 items-stretch sm:items-end">
            <div class="flex-1 min-w-[150px]">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal:</label>
                <input type="date" name="start_date" id="start_date" value="<?= $start_date ?>"
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
            </div>
            <div class="flex-1 min-w-[150px]">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal:</label>
                <input type="date" name="end_date" id="end_date" value="<?= $end_date ?>"
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
            </div>
            <div class="flex-1 sm:flex-none sm:w-64">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Barang:</label>
                <input type="text" name="search" id="search" placeholder="Nama/Kode Barang..." value="<?= htmlspecialchars($search) ?>"
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
            </div>
            <button type="submit" class="bg-purple-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center justify-center gap-2 sm:self-end">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
        </form>

        <div class="table-wrapper rounded-lg shadow overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID SO</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Barang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Kode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal SO</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jumlah Hasil SO</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id_so'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?= $row['nama_barang'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $row['kode_barang'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $row['tanggal_so'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-semibold"><?= $row['jumlah_stok'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 truncate max-w-xs"><?= empty($row['catatan']) ? '-' : htmlspecialchars($row['catatan']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 bg-gray-50">Tidak ada data stok opname ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="home.php" class="bg-gray-200 text-black-800 px-6 py-3 rounded-lg hover:bg-gray-300 shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7m-9 2v4a1 1 0 001 1h3m-6-6h6"></path></svg>
                Kembali ke Home
            </a>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="export_excel.php?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>&search=<?= $search ?>" 
                   class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 flex items-center gap-2 justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0014.586 3H4a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 14l-3 3-3-3M13 10l-3-3-3 3"></path></svg>
                    Export Excel
                </a>
              
        </div>

    </div>
</body>
</html>