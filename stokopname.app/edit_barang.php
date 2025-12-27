<?php
session_start(); // Pastikan session dimulai jika Anda ingin menggunakan session di sini

include 'koneksi.php'; // Pastikan file koneksi.php ada dan berfungsi

// Redirect jika tidak ada ID atau ID tidak valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: data_barang.php");
    exit;
}

// Ambil ID dari parameter URL
$id = intval($_GET['id']); // Pastikan ID adalah integer untuk keamanan

// Ambil data barang berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan, redirect
if (!$data) {
    header("Location: data_barang.php");
    exit;
}

// Jika tombol update diklik
if (isset($_POST['update'])) {
    // Escape string untuk mencegah SQL Injection
    $nama = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $kode = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $jumlah = intval($_POST['jumlah']); // Pastikan jumlah adalah integer

    // Proses update
    $update_query = "UPDATE barang SET
        nama_barang='$nama',
        kode_barang='$kode',
        kategori='$kategori',
        jumlah='$jumlah'
        WHERE id_barang='$id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: data_barang.php");
        exit;
    } else {
        $error = "Gagal mengupdate data: " . mysqli_error($conn);
        // Jika ada error, data yang ditampilkan di form harus tetap yang lama
        // atau ambil ulang dari DB jika ingin menampilkan data yang gagal diupdate
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Stok Opname</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for consistency if needed */
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
            <h2 class="text-3xl font-extrabold text-gray-800">Edit Data Barang</h2>
        </div>
        <p class="text-center text-gray-600 mb-6">Perbarui detail barang yang sudah ada.</p>

        <?php if (isset($error)) : ?>
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg flex items-center gap-3 shadow-sm">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <strong class="font-semibold">Terjadi Kesalahan!</strong>
                    <p class="text-sm"><?= $error ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" class="space-y-5">
            <div>
                <label for="kode_barang" class="block mb-1 font-semibold text-gray-700">Kode Barang</label>
                <input type="text" name="kode_barang" id="kode_barang" value="<?= htmlspecialchars($data['kode_barang']); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required>
            </div>

            <div>
                <label for="nama_barang" class="block mb-1 font-semibold text-gray-700">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" value="<?= htmlspecialchars($data['nama_barang']); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required>
            </div>

            <div>
                <label for="kategori" class="block mb-1 font-semibold text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required>
                    <option value="" disabled>Pilih Kategori</option>
                    <?php
                    // Array kategori yang tersedia
                    $categories = ["ALL ITEMS", "MINUMAN", "COKLAT", "COOKIES"];
                    foreach ($categories as $cat) {
                        $selected = ($data['kategori'] == $cat) ? 'selected' : '';
                        echo "<option value=\"$cat\" $selected>$cat</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="jumlah" class="block mb-1 font-semibold text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" value="<?= htmlspecialchars($data['jumlah']); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" min="0" required>
            </div>

            <div class="flex items-center justify-between pt-4">
                <a href="data_barang.php" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                    Batal
                </a>
                <button type="submit" name="update" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>
</html>