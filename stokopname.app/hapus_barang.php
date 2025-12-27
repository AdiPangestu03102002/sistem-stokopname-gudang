<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Ambil ID dari parameter URL dengan nama yang sesuai
$id = $_GET['id'] ?? null; // Karena link-nya pakai id=... bukan id_barang=...

if ($id) {
    // Gunakan kolom yang sesuai dengan struktur tabel
    $hapus = mysqli_query($conn, "DELETE FROM barang WHERE id_barang='$id'");

    if ($hapus) {
        header("Location: data_barang.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}
