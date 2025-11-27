<?php 
include 'koneksi.php'; 
session_start();

// CEK LOGIN CALON MAHASISWA
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formulir Pendaftaran Mahasiswa Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body { background: linear-gradient(135deg,#f5f7fa 0%,#c3cfe2 100%); }
    .register-card { max-width: 920px; margin: 40px auto; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
    .register-aside { background: linear-gradient(180deg,#3b82f6,#06b6d4); color: #fff; padding: 36px; }
    .register-aside h3 { font-weight: 700; }
    .form-section { padding: 28px 36px; background: #fff; }
    .form-label { font-weight: 600; }
    .input-group-text { background: #f1f5f9; border: none; }
    .btn-primary { background: linear-gradient(90deg,#06b6d4,#3b82f6); border: none; }
    .small-muted { color: #6b7280; font-size: 0.9rem; }
  </style>
 </head>
 
 <body class="bg-light">
  <div class="register-card">
    <div class="row g-0">
      <div class="col-md-4 register-aside d-flex flex-column justify-content-center align-items-start">
        <h3>Daftar Mahasiswa Baru</h3>
        <p class="small-muted">Mulai perjalanan akademik Anda di Universitas Nusantara. Lengkapi data dengan teliti.</p>
        <ul class="mt-3" style="list-style:none;padding-left:0;">
          <li><i class="bi bi-check-circle-fill me-2"></i>Tahun ajaran terbaru</li>
          <li><i class="bi bi-check-circle-fill me-2"></i>Proses cepat</li>
          <li><i class="bi bi-check-circle-fill me-2"></i>Konfirmasi via email</li>
        </ul>
      </div>
      <div class="col-md-8 form-section">
        <form action="simpan_pendaftaran.php" method="POST">
          
          <!-- kirim id_user ke proses -->
          <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user); ?>">

          <!-- Nama Lengkap -->
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">Nama Lengkap</label>
              <div class="input-group mb-2">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                <input type="text" name="nama_lengkap" class="form-control form-control-lg" placeholder="Nama sesuai ijazah" required>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota/Kabupaten">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" class="form-control">
            </div>
          </div>
 
          <!-- Jenis Kelamin & Alamat -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor HP</label>
              <div class="input-group">
                <span class="input-group-text">+62</span>
                <input type="text" name="no_hp" class="form-control" placeholder="81234567890">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap"></textarea>
          </div>

          <!-- Kontak Tambahan -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" placeholder="email@domain.com">
            </div>
          </div>
 
          <!-- Sekolah & Tahun Lulus -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Asal Sekolah</label>
              <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama sekolah">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tahun Lulus</label>
              <?php
                $currentYear = (int)date('Y');
                $startYear = $currentYear - 30; // tampilkan 30 tahun kebelakang
              ?>
              <select name="tahun_lulus" class="form-select">
                <option value="">-- Pilih Tahun Lulus --</option>
                <?php for ($y = $currentYear; $y >= $startYear; $y--): 
                    $acad = $y . '/' . ($y + 1);
                ?>
                  <option value="<?= $y; ?>"><?= $acad; ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>
 
          <!-- Prodi -->
          <div class="mb-3">
            <label class="form-label">Program Studi Pilihan</label>
            <select name="id_prodi" class="form-select" required>
              <option value="">-- Pilih Program Studi --</option>
              <?php
                $prodi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
                while($p = mysqli_fetch_assoc($prodi)){
                    $id = htmlspecialchars($p['id_prodi']);
                    $nama = htmlspecialchars($p['nama_prodi']);
                    echo "<option value='".$id."'>".$nama."</option>";
                }
              ?>
            </select>
          </div>
 
          <!-- TOMBOL -->
          <div class="d-flex justify-content-between mt-4">
              <a href="dashboard.php" class="btn btn-outline-secondary">← Kembali</a>
 
              <button type="submit" name="submit" class="btn btn-primary btn-lg px-4">
                  <i class="bi bi-send-fill me-2"></i>Kirim Pendaftaran
              </button>
          </div>
 
        </form>
      </div>
    </div>
  </div>
 </body>
 </html>
