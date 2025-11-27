<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username='$username' AND password='$password'");
$user = mysqli_fetch_assoc($query);

if ($user) {
  // Simpan data ke session
  $_SESSION['username'] = $user['username'];
  $_SESSION['role'] = $user['role']; // 🔹 Tambahkan ini agar role tersimpan
  $_SESSION['id_user'] = $user['id_user'];

  header("Location: dashboard.php");
  exit;
} else {
  echo "<script>
          alert('Login gagal! Username atau password salah.');
          window.location='login.php';
        </script>";
}
?>
