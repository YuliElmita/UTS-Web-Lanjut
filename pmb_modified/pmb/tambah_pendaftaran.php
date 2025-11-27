<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
  $id_calon = $_POST['id_calon'];
  $id_prodi = $_POST['id_prodi'];
  $tanggal_daftar = $_POST['tanggal_daftar'];
  $status = $_POST['status'];

  $query = "INSERT INTO tb_pendaftaran (id_calon, id_prodi, tanggal_daftar, status_pendaftaran)
            VALUES ('$id_calon', '$id_prodi', '$tanggal_daftar', '$status')";
  mysqli_query($koneksi, $query);

  header("Location: data_pendaftaran.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Pendaftaran</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Sesuaikan dengan tema biru-cyan yang lain */
    body { background: linear-gradient(135deg,#f5f7fa 0%,#c3cfe2 100%); min-height:100vh; font-family:'Poppins',sans-serif; display:flex; align-items:center; }
    .card { width:520px; margin:48px auto; border-radius:12px; overflow:hidden; box-shadow:0 12px 40px rgba(12,18,42,0.08); }
    .card-header-gradient { background: linear-gradient(90deg,#3b82f6,#06b6d4); color:#fff; padding:20px 24px; text-align:center; }
    .card-body { background:#fff; padding:28px 30px; }
    .form-label { font-weight:600; color:#0f172a; }
    .btn-primary { background: linear-gradient(90deg,#06b6d4,#3b82f6); border:none; box-shadow:0 6px 18px rgba(59,130,246,0.18); }
    .btn-primary:hover { filter:brightness(0.96); }
    a.text-decoration-none { color:#08132a; }
    input.form-control, select.form-select, textarea.form-control { border-radius:8px; }
  </style>
</head>
<body>

  <div class="card">
    <div class="card-header-gradient">
      <h3 class="mb-0">Tambah Pendaftaran</h3>
      <div class="small" style="opacity:.95;">Lengkapi data calon mahasiswa</div>
    </div>
    <div class="card-body">
    <form method="POST">
      <div class="mb-3">
        <label for="id_calon" class="form-label">ID Calon</label>
        <input type="text" class="form-control" id="id_calon" name="id_calon" required>
      </div>

      <div class="mb-3">
        <label for="id_prodi" class="form-label">ID Prodi</label>
        <input type="text" class="form-control" id="id_prodi" name="id_prodi" required>
      </div>

      <div class="mb-3">
        <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
        <input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar" required>
      </div>

      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
          <option value="">-- Pilih Status --</option>
          <option value="Menunggu">Menunggu</option>
          <option value="Diterima">Diterima</option>
          <option value="Ditolak">Ditolak</option>
        </select>
      </div>

      <div class="d-grid">
        <button type="submit" name="submit" class="btn btn-primary btn-lg">💾 Simpan</button>
      </div>
    </form>

    <div class="text-center mt-3">
      <a href="data_pendaftaran.php" class="text-decoration-none">⬅ Kembali ke Data Pendaftaran</a>
    </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
