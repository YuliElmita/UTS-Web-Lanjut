<?php
// include koneksi jika ada
// include 'koneksi.php';

if(isset($_POST['simpan'])) {
    // ambil input (pastikan validasi + sanitize di kode produksi)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // contoh respons sementara (ganti dengan query INSERT)
    // $query = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
    // mysqli_query($koneksi, $query);

    echo "<div class='alert alert-success'>User <strong>$username</strong> berhasil ditambahkan (simulasi)</div>";
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Form Tambah User</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="card-title mb-4">Form Tambah User</h2>

        <form method="POST" class="row g-3">
          <div class="col-12">
            <label class="form-label">Username :</label>
            <input type="text" name="username" class="form-control" required>
          </div>

          <div class="col-12">
            <label class="form-label">Password :</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="col-12">
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS (opsional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
