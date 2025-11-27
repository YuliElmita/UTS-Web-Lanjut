<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {

  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $password = md5($_POST['password']); // MD5 untuk cocok dengan database lama

  $query = mysqli_query($koneksi, 
            "SELECT * FROM tb_user 
             WHERE username='$username' AND password='$password'");

  if (!$query) {
      die("Query Error: " . mysqli_error($koneksi));
  }

  $data = mysqli_fetch_assoc($query);

  if ($data) {
    // simpan sesi
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['id_user'] = $data['id_user'];

    // arahkan sesuai role
    if ($data['role'] == 'Admin') {
      header("Location: dashboard_admin.php");
    } 
    else if ($data['role'] == 'Panitia') {
      header("Location: dashboard_panitia.php");
    } 
    else {
      // Calon mahasiswa diarahkan isi formulir
      header("Location: form_pendaftaran.php");
    }
    exit;
  } 
  else {
    echo "<script>alert('Username atau password salah!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Login - PMB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0062E6, #33AEFF);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .btn-primary {
      background: linear-gradient(90deg, #007BFF, #00C6FF);
      border: none;
    }

    .btn-primary:hover {
      background: linear-gradient(90deg, #0062E6, #0094FF);
    }

    h3 {
      font-weight: 700;
      color: #007BFF;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">

        <div class="card p-4">

          <div class="text-center mb-3">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="80">
            <h3 class="mt-3">Login PMB</h3>
            <p class="text-muted">Silakan masuk ke akun Anda</p>
          </div>

         <form method="POST">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
          </div>

          <!-- Tombol Masuk -->
         <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
          <a href="index.php" class="btn btn-outline-secondary w-100 mt-2">Kembali</a>

        </form>


          <div class="text-center mt-3 text-muted">
            <small>© 2025 Sistem PMB | Universitas Anda</small>
          </div>

        </div>

      </div>
    </div>
  </div>

</body>

</html>
