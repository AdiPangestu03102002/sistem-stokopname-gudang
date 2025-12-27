<?php
include 'koneksi.php';

$kode = $_GET['kode'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '$kode'");
$data = mysqli_fetch_assoc($result);

if ($data) {
    echo json_encode(["success" => true, "data" => $data]);
} else {
    echo json_encode(["success" => false]);
}
?>
