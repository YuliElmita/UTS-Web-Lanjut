<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data pendaftaran dengan prepared statement
$data = [];
if ($id > 0) {
    if ($stmt = $koneksi->prepare("SELECT * FROM tb_pendaftaran WHERE id_pendaftaran = ?")) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $data = $res->fetch_assoc();
        $stmt->close();
    }
}

// Proses update
if (isset($_POST['submit'])) {
    $tanggal_raw = trim($_POST['tanggal_daftar']);
    // normalisasi tanggal: terima YYYY-MM-DD atau DD/MM/YYYY
    $tanggal_obj = DateTime::createFromFormat('Y-m-d', $tanggal_raw);
    if (!$tanggal_obj) $tanggal_obj = DateTime::createFromFormat('d/m/Y', $tanggal_raw);
    $tanggal_daftar = $tanggal_obj ? $tanggal_obj->format('Y-m-d') : null;

    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    if ($stmt = $koneksi->prepare("UPDATE tb_pendaftaran SET tanggal_daftar = ?, status_pendaftaran = ? WHERE id_pendaftaran = ?")) {
        $stmt->bind_param('ssi', $tanggal_daftar, $status, $id);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: data_pendaftaran.php');
    exit;
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Pendaftaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Warna dan gaya disesuaikan agar konsisten dengan form lain */
    body { background: linear-gradient(135deg,#f5f7fa 0%,#c3cfe2 100%); min-height:100vh; }
    .card { max-width:760px; margin:40px auto; border-radius:12px; overflow:hidden; box-shadow:0 12px 40px rgba(17,24,39,0.08); }
    /* Header gradient: biru -> cyan (sama dengan register) */
    .card-header-gradient { background: linear-gradient(90deg,#3b82f6,#06b6d4); color:#fff; padding:22px 24px; text-align:center; }
    .card-body { padding:28px 36px; background:#fff; }
    .form-label { font-weight:600; color:#0f172a; }
    /* Tombol utama pakai gradient cyan->blue */
    .btn-primary { background: linear-gradient(90deg,#06b6d4,#3b82f6); border:none; box-shadow:0 6px 18px rgba(59,130,246,0.18); }
    .btn-primary:hover { filter:brightness(0.96); }
    .btn-outline-secondary { border-radius:6px; color:#0f172a; border-color:rgba(15,23,42,0.08); }
  </style>
 </head>
 <body>
  <div class="card">
    <div class="card-header-gradient">
      <h3 class="mb-0">Edit Data Pendaftaran</h3>
    </div>
    <div class="card-body">
      <form method="post" class="row g-3">
        <?php
          // siapkan nilai untuk input date (format YYYY-MM-DD)
          $dateVal = '';
          if (!empty($data) && !empty($data['tanggal_daftar'])) {
              // coba parsing berbagai format
              $d = DateTime::createFromFormat('Y-m-d', $data['tanggal_daftar']);
              if (!$d) $d = DateTime::createFromFormat('d/m/Y', $data['tanggal_daftar']);
              if ($d) $dateVal = $d->format('Y-m-d');
          }
          $currentStatus = !empty($data['status_pendaftaran']) ? $data['status_pendaftaran'] : '';
        ?>

        <div class="col-md-6">
          <label class="form-label">Tanggal Daftar</label>
          <input type="date" name="tanggal_daftar" class="form-control" value="<?= htmlspecialchars($dateVal); ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <?php
              $opts = ['Menunggu','Diterima','Ditolak'];
              foreach ($opts as $o) {
                  $sel = ($o === $currentStatus) ? 'selected' : '';
                  echo "<option value='".htmlspecialchars($o)."' $sel>".htmlspecialchars($o)."</option>";
              }
            ?>
          </select>
        </div>

        <div class="col-12 d-flex justify-content-between mt-3">
          <a href="data_pendaftaran.php" class="btn btn-outline-secondary">← Kembali</a>
          <button type="submit" name="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
