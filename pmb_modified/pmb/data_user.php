<?php
session_start();
include 'koneksi.php';

// Pastikan hanya admin yang bisa akses
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
if ($_SESSION['role'] != 'Admin') {
  echo "<script>alert('Akses ditolak! Hanya admin yang bisa mengelola pengguna.'); history.back();</script>";
  exit;
}

// Ambil data user dari database
$query = mysqli_query($koneksi, "SELECT * FROM tb_user ORDER BY id_user ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="theme-white">

<div class="container mt-5">
  <div class="card shadow p-4">
    <h2 class="mb-4 text-primary">Kelola Pengguna</h2>
    <a href="tambah_user.php" class="btn btn-success mb-3">+ Tambah User Baru</a>
    <a href="dashboard_admin.php" class="btn btn-secondary mb-3">⬅ Kembali</a>

    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
              <td><?= htmlspecialchars($row['id_user']); ?></td>
              <td><?= htmlspecialchars($row['username']); ?></td>
              <td><?= htmlspecialchars($row['role']); ?></td>
              <td>
                <a href="edit_user.php?id=<?= $row['id_user']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus_user.php?id=<?= $row['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?');">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
