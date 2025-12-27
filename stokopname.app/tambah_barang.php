<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php'; // Pastikan file koneksi.php ada dan berfungsi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $jumlah = intval($_POST['jumlah']);

    $query = "INSERT INTO barang (kode_barang, nama_barang, kategori, jumlah) VALUES ('$kode', '$nama', '$kategori', '$jumlah')";
    if (mysqli_query($conn, $query)) {
        header("Location: data_barang.php");
        exit;
    } else {
        $error = "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Stok Opname</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles if needed, but Tailwind should cover most */
        /* Contoh: Fokus pada select agar lebih konsisten */
        select:focus {
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-shadow);
            border-color: var(--tw-ring-color);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 font-sans antialiased">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md ring-1 ring-gray-100">
        <div class="flex items-center justify-center mb-6">
            <h2 class="text-3xl font-extrabold text-gray-800">Tambah Barang Baru</h2>
        </div>
        <p class="text-center text-gray-600 mb-6">Isi detail barang untuk menambahkannya ke inventaris.</p>

        <?php if (isset($error)) : ?>
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg flex items-center gap-3 shadow-sm">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <strong class="font-semibold">Terjadi Kesalahan!</strong>
                    <p class="text-sm"><?= $error ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-5">
            <div>
                <label for="kode_barang" class="block mb-1 font-semibold text-gray-700">Kode Barang</label>
                <input type="text" name="kode_barang" id="kode_barang" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" placeholder="Contoh: BRG001" required>
            </div>

            <div>
                <label for="nama_barang" class="block mb-1 font-semibold text-gray-700">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" placeholder="Contoh: Susu Full Cream" required>
            </div>

            <div>
                <label for="kategori" class="block mb-1 font-semibold text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required>
                    <option value="" disabled selected>Pilih Kategori Barang</option>
                    <option value="ALL ITEMS">ALL ITEMS</option>
                    <option value="MINUMAN">MINUMAN</option>
                    <option value="COKLAT">COKLAT</option>
                    <option value="COOKIES">COOKIES</option>
                    </select>
            </div>

            <div>
                <label for="jumlah" class="block mb-1 font-semibold text-gray-700">Jumlah Awal</label>
                <input type="number" name="jumlah" id="jumlah" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" min="0" placeholder="Contoh: 100" required>
            </div>

            <div class="flex items-center justify-between pt-4">
                <a href="data_barang.php" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                    Kembali
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>

</body>
</html>