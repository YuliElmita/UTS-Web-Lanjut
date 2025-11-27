<?php
session_start();
require_once 'koneksi.php';

// Hanya terima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Akses tidak valid'); window.location='daftar.php';</script>";
    exit;
}

// Ambil input
$nama_lengkap  = trim($_POST['nama_lengkap'] ?? '');
$tempat_lahir  = trim($_POST['tempat_lahir'] ?? '');
$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
$jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
$alamat        = trim($_POST['alamat'] ?? '');
$no_hp         = trim($_POST['no_hp'] ?? '');
$email         = trim($_POST['email'] ?? '');
$asal_sekolah  = trim($_POST['asal_sekolah'] ?? '');
$tahun_lulus   = trim($_POST['tahun_lulus'] ?? '');
$id_prodi      = (int)($_POST['id_prodi'] ?? 0);

$errors = [];

// Validasi sederhana
if ($nama_lengkap === '') $errors[] = 'Nama lengkap wajib diisi.';
if ($no_hp === '') $errors[] = 'Nomor HP wajib diisi.';
if ($asal_sekolah === '') $errors[] = 'Asal sekolah wajib diisi.';
if ($tahun_lulus === '') $errors[] = 'Tahun lulus wajib dipilih.';
if ($id_prodi === 0) $errors[] = 'Program studi wajib dipilih.';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
}

// Validasi tahun lulus: angka 4 digit & dalam rentang wajar
if ($tahun_lulus !== '') {
    if (!preg_match('/^\d{4}$/', $tahun_lulus)) {
        $errors[] = 'Tahun lulus harus 4 digit (misal: 2023).';
    } else {
        $y = (int)$tahun_lulus;
        $currentYear = (int)date('Y');
        $minYear = $currentYear - 50;
        if ($y < $minYear || $y > $currentYear) {
            $errors[] = 'Tahun lulus di luar rentang yang diperbolehkan.';
        }
    }
}

if (!empty($errors)) {
    echo "<h3>Terjadi kesalahan:</h3><ul>";
    foreach ($errors as $e) {
        echo "<li style='color:red;'>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul><p><a href='daftar.php'>← Kembali ke formulir</a></p>";
    exit;
}

/* =========== 1. SIMPAN KE tb_calon_mahasiswa =========== */
$sqlCalon = "INSERT INTO tb_calon_mahasiswa
    (nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_hp, email, asal_sekolah, tahun_lulus)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt1 = $koneksi->prepare($sqlCalon);
if (!$stmt1) {
    die("Gagal menyiapkan query calon_mahasiswa: " . $koneksi->error);
}

$stmt1->bind_param(
    'sssssssss',
    $nama_lengkap,
    $tempat_lahir,
    $tanggal_lahir,
    $jenis_kelamin,
    $alamat,
    $no_hp,
    $email,
    $asal_sekolah,
    $tahun_lulus
);

if (!$stmt1->execute()) {
    die("Gagal menyimpan data calon mahasiswa: " . $stmt1->error);
}

$id_calon = $koneksi->insert_id; // ID calon yang baru dibuat
$stmt1->close();

/* =========== 2. SIMPAN KE tb_pendaftaran =========== */
$sqlDaftar = "INSERT INTO tb_pendaftaran
    (id_calon, id_prodi, tanggal_daftar, status_pendaftaran)
    VALUES (?, ?, NOW(), 'Menunggu')";

$stmt2 = $koneksi->prepare($sqlDaftar);
if (!$stmt2) {
    die("Gagal menyiapkan query pendaftaran: " . $koneksi->error);
}

$stmt2->bind_param('ii', $id_calon, $id_prodi);

if (!$stmt2->execute()) {
    die("Gagal menyimpan data pendaftaran: " . $stmt2->error);
}

$stmt2->close();
$koneksi->close();

echo "<script>
    alert('Pendaftaran berhasil dikirim!');
    window.location='dashboard.php';
</script>";
