<?php
include 'koneksi.php';

$id_barang = $_POST['id_barang'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$catatan = $_POST['catatan'] ?? '';

$query = "INSERT INTO stok_opname (id_barang, tanggal_so, jumlah_stok, catatan)
          VALUES ('$id_barang', '$tanggal', '$jumlah', '$catatan')";

if (mysqli_query($conn, $query)) {
    echo "success";
} else {
    echo "error";
}
?>
