<?php
include 'koneksi.php';

$username = 'admin1';
$password = password_hash('1234', PASSWORD_DEFAULT);

$query = "INSERT INTO admin1 (username, password) VALUES ('$username', '$password')";
if (mysqli_query($conn, $query)) {
    echo "Admin berhasil ditambahkan.";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>
