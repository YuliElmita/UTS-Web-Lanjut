<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM tb_pendaftaran WHERE id_pendaftaran=$id");
header("Location: data_pendaftaran.php");
?>
