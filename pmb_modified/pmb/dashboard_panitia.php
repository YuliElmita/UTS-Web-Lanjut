<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
if ($_SESSION['role'] != 'Panitia') {
  echo "<script>alert('Akses ditolak! Halaman ini hanya untuk Panitia.'); history.back();</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Panitia - PMB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* minimal layout overrides to integrate with theme */
    body { padding: 20px }
    .sidebar { width:230px; position:fixed; top:20px; left:20px }
    .sidebar .card { background:var(--card); border-radius:12px; padding:16px }
    .content { margin-left: 270px; padding: 30px }
    .sidebar a{ display:block; padding:10px 12px; color:var(--muted); text-decoration:none }
    .sidebar a:hover{ color:#0b1220 }
  </style>
</head>
<body class="theme-white">

<div class="sidebar card">
  <h4 class="text-center mb-4">👩‍💼 PMB Panitia</h4>
  <a href="dashboard_panitia.php">🏠 Dashboard</a>
  <a href="data_pendaftaran.php">📋 Kelola Pendaftaran</a>
  <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">
  <div class="container">
    <div class="card shadow p-4" style="background:var(--card); border:1px solid rgba(15,23,42,0.03)">
      <h3>Selamat Datang, <?= $_SESSION['username']; ?> 👋</h3>
      <p class="text-muted">Anda login sebagai <strong><?= $_SESSION['role']; ?></strong></p>

      <hr>

      <div class="row text-center">
        <div class="col-md-6">
          <div class="card shadow" style="background:#10b981;color:#fff">
            <div class="card-body">
              <h5>Kelola Pendaftaran</h5>
              <p>Data calon mahasiswa baru</p>
              <a href="data_pendaftaran.php" class="btn btn-light btn-sm">Lihat Data</a>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card shadow" style="background:#ef4444;color:#fff">
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
