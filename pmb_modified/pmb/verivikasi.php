<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "UPDATE tb_pendaftaran SET status_pendaftaran='Diterima' WHERE id_pendaftaran='$id'");
echo "<script>alert('Pendaftar diterima!'); window.location='data_pendaftar.php';</script>";
?>
