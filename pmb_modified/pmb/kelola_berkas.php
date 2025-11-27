<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// ----------------- PROSES HAPUS BERKAS -----------------
if (isset($_GET['hapus'])) {
    $id_berkas = (int) $_GET['hapus'];

    // ambil file_path dulu
    $qFile = mysqli_query($koneksi, "SELECT file_path FROM tb_berkas WHERE id_berkas = $id_berkas");
    if ($qFile && $rowF = mysqli_fetch_assoc($qFile)) {
        $path = $rowF['file_path'];
        if (!empty($path) && file_exists($path)) {
            @unlink($path); // hapus file fisik
        }
    }

    mysqli_query($koneksi, "DELETE FROM tb_berkas WHERE id_berkas = $id_berkas");
    header("Location: kelola_berkas.php?msg=hapus-ok");
    exit;
}

// ----------------- PROSES SIMPAN BERKAS BARU -----------------
$err = '';
if (isset($_POST['simpan'])) {
    $id_pendaftaran = (int) $_POST['id_pendaftaran'];
    $jenis_berkas   = trim($_POST['jenis_berkas']);
    $status_berkas  = trim($_POST['status_berkas']);

    if ($id_pendaftaran <= 0 || $jenis_berkas === '') {
        $err = 'Pilih pendaftar dan isi jenis berkas.';
    } elseif (!isset($_FILES['file_berkas']) || $_FILES['file_berkas']['error'] !== 0) {
        $err = 'File berkas wajib diunggah.';
    } else {
        $file      = $_FILES['file_berkas'];
        $namaAsli  = $file['name'];
        $tmp       = $file['tmp_name'];
        $ukuran    = $file['size'];

        // batas ukuran 5 MB
        if ($ukuran > 5 * 1024 * 1024) {
            $err = 'Ukuran file terlalu besar (maksimal 5MB).';
        } else {
            $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
            $ext     = strtolower(pathinfo($namaAsli, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $err = 'Tipe file tidak diizinkan. Hanya PDF / JPG / PNG.';
            } else {
                // pastikan folder ada
                if (!is_dir('uploads')) {
                    mkdir('uploads');
                }
                if (!is_dir('uploads/berkas')) {
                    mkdir('uploads/berkas');
                }

                $namaBaru = 'berkas_' . $id_pendaftaran . '_' . time() . '.' . $ext;
                $tujuan   = 'uploads/berkas/' . $namaBaru;

                if (move_uploaded_file($tmp, $tujuan)) {
                    $sql = "INSERT INTO tb_berkas (id_pendaftaran, jenis_berkas, file_path, status_berkas)
                            VALUES ($id_pendaftaran, '$jenis_berkas', '$tujuan', '$status_berkas')";
                    $ok = mysqli_query($koneksi, $sql);

                    if ($ok) {
                        header("Location: kelola_berkas.php?msg=simpan-ok");
                        exit;
                    } else {
                        $err = 'Gagal menyimpan ke database: ' . mysqli_error($koneksi);
                    }
                } else {
                    $err = 'Gagal mengunggah file ke server.';
                }
            }
        }
    }
}

// ----------------- DATA UNTUK DROPDOWN PENDAFTAR -----------------
$sqlPendaftar = "
    SELECT d.id_pendaftaran, c.nama_lengkap, p.nama_prodi
    FROM tb_pendaftaran d
    LEFT JOIN tb_calon_mahasiswa c ON d.id_calon = c.id_calon
    LEFT JOIN tb_prodi           p ON d.id_prodi = p.id_prodi
    ORDER BY d.id_pendaftaran DESC
";
$pendaftar_q = mysqli_query($koneksi, $sqlPendaftar);

// ----------------- DATA BERKAS UNTUK TABEL -----------------
$sqlBerkas = "
    SELECT b.*, c.nama_lengkap, p.nama_prodi
    FROM tb_berkas b
    LEFT JOIN tb_pendaftaran      d ON b.id_pendaftaran = d.id_pendaftaran
    LEFT JOIN tb_calon_mahasiswa  c ON d.id_calon       = c.id_calon
    LEFT JOIN tb_prodi            p ON d.id_prodi       = p.id_prodi
    ORDER BY b.id_berkas DESC
";
$berkas_q = mysqli_query($koneksi, $sqlBerkas);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Berkas Pendaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="theme-white">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-3 text-primary">Kelola Berkas Pendaftar</h3>

        <a href="dashboard_admin.php" class="btn btn-secondary mb-3">&larr; Kembali ke Dashboard</a>

        <?php if (!empty($_GET['msg']) && $_GET['msg'] == 'simpan-ok'): ?>
            <div class="alert alert-success">Berkas berhasil diunggah.</div>
        <?php elseif (!empty($_GET['msg']) && $_GET['msg'] == 'hapus-ok'): ?>
            <div class="alert alert-success">Berkas berhasil dihapus.</div>
        <?php endif; ?>

        <?php if ($err): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
        <?php endif; ?>

        <!-- FORM UPLOAD BERKAS -->
        <div class="card mb-4">
            <div class="card-header">Upload Berkas Baru</div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="id_pendaftaran" class="form-label">Pendaftar</label>
                        <select name="id_pendaftaran" id="id_pendaftaran" class="form-select" required>
                            <option value="">-- Pilih Pendaftar --</option>
                            <?php if ($pendaftar_q): ?>
                                <?php while ($pd = mysqli_fetch_assoc($pendaftar_q)): ?>
                                    <option value="<?= $pd['id_pendaftaran']; ?>">
                                        <?= $pd['id_pendaftaran']; ?> - <?= htmlspecialchars($pd['nama_lengkap']); ?> (<?= htmlspecialchars($pd['nama_prodi']); ?>)
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_berkas" class="form-label">Jenis Berkas</label>
                        <input type="text" name="jenis_berkas" id="jenis_berkas" class="form-control"
                               placeholder="Contoh: KTP, KK, Ijazah, Raport" required>
                    </div>

                    <div class="mb-3">
                        <label for="file_berkas" class="form-label">File Berkas (PDF / JPG / PNG, maks 5MB)</label>
                        <input type="file" name="file_berkas" id="file_berkas" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="status_berkas" class="form-label">Status Berkas</label>
                        <select name="status_berkas" id="status_berkas" class="form-select">
                            <option value="Menunggu">Menunggu</option>
                            <option value="Valid">Valid</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>

                    <button type="submit" name="simpan" class="btn btn-primary">Simpan Berkas</button>
                </form>
            </div>
        </div>

        <!-- TABEL BERKAS -->
        <h5>Daftar Berkas</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pendaftar</th>
                        <th>Prodi</th>
                        <th>Jenis Berkas</th>
                        <th>Status</th>
                        <th>File</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                if ($berkas_q && mysqli_num_rows($berkas_q) > 0):
                    while ($b = mysqli_fetch_assoc($berkas_q)):
                        $nama   = $b['nama_lengkap'] ?? '-';
                        $prodi  = $b['nama_prodi'] ?? '-';
                        $status = $b['status_berkas'] ?? 'Menunggu';

                        $badge = 'bg-secondary';
                        if (stripos($status, 'valid') !== false)  $badge = 'bg-success';
                        if (stripos($status, 'tolak') !== false)  $badge = 'bg-danger';
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($nama); ?></td>
                        <td><?= htmlspecialchars($prodi); ?></td>
                        <td><?= htmlspecialchars($b['jenis_berkas']); ?></td>
                        <td><span class="badge <?= $badge; ?>"><?= htmlspecialchars($status); ?></span></td>
                        <td>
                            <?php if (!empty($b['file_path']) && file_exists($b['file_path'])): ?>
                                <a href="<?= $b['file_path']; ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                            <?php else: ?>
                                <span class="text-muted">File tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?hapus=<?= $b['id_berkas']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin hapus berkas ini?');">
                               Hapus
                            </a>
                        </td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada berkas yang diunggah.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
