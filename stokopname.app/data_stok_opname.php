<?php
include 'koneksi.php';
$query = "SELECT stok_opname.*, barang.nama_barang 
          FROM stok_opname 
          JOIN barang ON stok_opname.id_barang = barang.id_barang";
$result = mysqli_query($conn, $query);
?>

<table border="1">
  <tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Nama Barang</th>
    <th>Jumlah Fisik</th>
    <th>Catatan</th>
  </tr>
  <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
  <tr>
    <td><?= $no++; ?></td>
    <td><?= $row['tanggal']; ?></td>
    <td><?= $row['nama_barang']; ?></td>
    <td><?= $row['jumlah_fisik']; ?></td>
    <td><?= $row['catatan']; ?></td>
  </tr>
  <?php endwhile; ?>
</table>
