<?php
require 'koneksi.php';

// header untuk file excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_stok_opname.xls");

echo "<h3>Laporan Stok Opname</h3>";

$query = "SELECT so.id_so, b.nama_barang, b.kode_barang, so.tanggal_so, so.jumlah_stok, so.catatan 
          FROM stok_opname so
          JOIN barang b ON so.id_barang = b.id_barang
          ORDER BY so.tanggal_so DESC";
$result = mysqli_query($conn, $query);
?>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nama Barang</th>
        <th>Kode Barang</th>
        <th>Tanggal SO</th>
        <th>Jumlah</th>
        <th>Catatan</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id_so'] ?></td>
        <td><?= $row['nama_barang'] ?></td>
        <td><?= $row['kode_barang'] ?></td>
        <td><?= $row['tanggal_so'] ?></td>
        <td><?= $row['jumlah_stok'] ?></td>
        <td><?= $row['catatan'] ?></td>
    </tr>
    <?php } ?>
</table>
