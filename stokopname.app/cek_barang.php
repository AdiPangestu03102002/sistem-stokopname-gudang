<?php
include 'koneksi.php';

$kode_barang = $_POST['kode_barang'];

$query = "SELECT * FROM barang WHERE kode_barang = '$kode_barang'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($data) {
    echo "<h2>Nama: " . $data['nama_barang'] . "</h2>";
    echo "<p>Kategori: " . $data['kategori'] . "</p>";
    echo "<p>Jumlah Tersedia: " . $data['jumlah'] . "</p>";
    // Tambahkan tombol input stok opname di sini
} else {
    echo "<p>Barang tidak ditemukan!</p>";
}
