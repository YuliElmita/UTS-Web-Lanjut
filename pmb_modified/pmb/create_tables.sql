-- create_tables.sql
-- Jalankan file ini di phpMyAdmin (pilih database yang digunakan oleh koneksi.php) atau via mysql client

-- Tabel calon mahasiswa
CREATE TABLE IF NOT EXISTS `tb_calon_mhs` (
  `id_calon` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_lengkap` VARCHAR(255) NOT NULL,
  `tempat_lahir` VARCHAR(150) DEFAULT NULL,
  `tanggal_lahir` DATE DEFAULT NULL,
  `jenis_kelamin` VARCHAR(20) DEFAULT NULL,
  `alamat` TEXT,
  `no_hp` VARCHAR(50) DEFAULT NULL,
  `email` VARCHAR(150) DEFAULT NULL,
  `asal_sekolah` VARCHAR(255) DEFAULT NULL,
  `tahun_lulus` VARCHAR(9) DEFAULT NULL, -- simpan 'YYYY' atau 'YYYY/YYYY'
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_calon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel program studi (jika belum ada)
CREATE TABLE IF NOT EXISTS `tb_prodi` (
  `id_prodi` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_prodi` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_prodi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contoh data program studi
INSERT INTO `tb_prodi` (`nama_prodi`) VALUES
('Teknik Informatika'),
('Sistem Informasi'),
('Manajemen');
