<?php
include 'koneksi.php';

$kode = $_GET['kode'] ?? '';

$sql = "SELECT * FROM barang WHERE kode_barang = '$kode'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Data tidak ditemukan']);
}
?>
