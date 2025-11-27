<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
if ($_SESSION['role'] != 'Admin') {
  echo "<script>alert('Akses ditolak!'); history.back();</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - PMB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
    }
    .sidebar {
      height: 100vh;
      background-color: #0d6efd;
      color: white;
      position: fixed;
      width: 230px;
      padding-top: 20px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 5px;
    }
    .content {
      margin-left: 250px;
      padding: 30px;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <h4 class="text-center mb-4">🎓 PMB Admin</h4>
  <a href="dashboard_admin.php">🏠 Dashboard</a>
  <a href="data_pendaftaran.php">📋 Kelola Pendaftaran</a>
  <a href="data_user.php">👤 Kelola Pengguna</a>
  <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">
  <div class="container">
    <div class="card shadow p-4">
      <h3>Selamat Datang, <?= $_SESSION['username']; ?> 👋</h3>
      <p class="text-muted">Anda login sebagai <strong><?= $_SESSION['role']; ?></strong></p>

      <hr>

      <div class="row text-center">
        <div class="col-md-4">
          <div class="card bg-primary text-white shadow">
            <div class="card-body">
              <h5>Kelola Pendaftaran</h5>
              <p>Data calon mahasiswa baru</p>
              <a href="data_pendaftaran.php" class="btn btn-light btn-sm">Lihat Data</a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card bg-success text-white shadow">
            <div class="card-body">
              <h5>Kelola Pengguna</h5>
              <p>Data admin & panitia</p>
              <a href="data_user.php" class="btn btn-light btn-sm">Lihat Data</a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card bg-danger text-white shadow">
            <div class="card-body">
              <h5>Logout</h5>
              <p>Akhiri sesi login</p>
              <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
