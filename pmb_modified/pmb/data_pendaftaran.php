<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

// tentukan link dashboard sesuai role
$dashboard_link = ($_SESSION['role'] == 'Admin')
  ? 'dashboard_admin.php'
  : 'dashboard_panitia.php';

// AMBIL DATA DARI tb_pendaftaran + JOIN NAMA CALON & PRODI
// AMBIL DATA DARI tb_pendaftaran + JOIN NAMA CALON & PRODI
$sql = "
  SELECT d.id_pendaftaran,
         d.id_calon,
         d.tanggal_daftar,
         d.status_pendaftaran,
         c.nama_lengkap,
         p.nama_prodi
  FROM tb_pendaftaran d
  LEFT JOIN tb_calon_mahasiswa c ON d.id_calon = c.id_calon
  LEFT JOIN tb_prodi          p ON d.id_prodi  = p.id_prodi
  ORDER BY d.tanggal_daftar DESC, d.id_pendaftaran DESC
";


$data = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pendaftaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="theme-white">

<div class="container mt-5">
  <div class="card shadow p-4">
    <h3 class="mb-3 text-primary">Kelola Pendaftaran</h3>

    <a href="tambah_pendaftaran.php" class="btn btn-success mb-3">+ Tambah Data</a>
    <a href="<?= $dashboard_link ?>" class="btn btn-secondary mb-3">⬅ Kembali ke Dashboard</a>

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Nama Calon</th>
            <th>Prodi</th>
            <th>Tanggal Daftar</th>
            <th>Status</th>
            <th style="width: 180px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        if ($data && mysqli_num_rows($data) > 0):
          while ($row = mysqli_fetch_assoc($data)):

            $nama  = $row['nama_lengkap'] ?? ('Calon#'.$row['id_calon']);
            $prodi = $row['nama_prodi'] ?? '-';

            // format tanggal
            $tgl = '-';
            if (!empty($row['tanggal_daftar']) &&
                $row['tanggal_daftar'] != '0000-00-00' &&
                $row['tanggal_daftar'] != '0000-00-00 00:00:00') {
              $tgl = date('d-m-Y', strtotime($row['tanggal_daftar']));
            }

            $status = $row['status_pendaftaran'] ?? '-';
            $lower  = strtolower($status);
            $badgeClass = 'badge bg-secondary-subtle text-secondary';
            if (str_contains($lower,'terima')) {
              $badgeClass = 'badge bg-success-subtle text-success';
            } elseif (str_contains($lower,'tolak')) {
              $badgeClass = 'badge bg-danger-subtle text-danger';
            } elseif (str_contains($lower,'menunggu') || str_contains($lower,'pending')) {
              $badgeClass = 'badge bg-warning-subtle text-warning';
            }
        ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($nama); ?></td>
            <td><?= htmlspecialchars($prodi); ?></td>
            <td><?= htmlspecialchars($tgl); ?></td>
            <td><span class="<?= $badgeClass; ?>"><?= htmlspecialchars($status); ?></span></td>
            <td>
              <a href="edit_pendaftaran.php?id=<?= $row['id_pendaftaran']; ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="hapus_pendaftaran.php?id=<?= $row['id_pendaftaran']; ?>"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Yakin hapus data ini?');">
                 Hapus
              </a>
            </td>
          </tr>
        <?php
          endwhile;
        else:
        ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-3">
              Belum ada data pendaftaran.
            </td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
