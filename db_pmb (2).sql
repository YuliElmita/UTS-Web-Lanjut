-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 12:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pmb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_berkas`
--

CREATE TABLE `tb_berkas` (
  `id_berkas` int(11) NOT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL,
  `jenis_berkas` varchar(50) DEFAULT NULL,
  `file_path` varchar(200) DEFAULT NULL,
  `status_berkas` enum('Lengkap','Tidak Lengkap') DEFAULT 'Tidak Lengkap'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_calon_mahasiswa`
--

CREATE TABLE `tb_calon_mahasiswa` (
  `id_calon` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `tahun_lulus` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_calon_mahasiswa`
--

INSERT INTO `tb_calon_mahasiswa` (`id_calon`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_hp`, `email`, `asal_sekolah`, `tahun_lulus`) VALUES
(1, 'alya', 'padang', '2001-02-13', 'Perempuan', 'padang ', '0865748392', 'alya@gmail.com', 'sman 1 padang', '2002'),
(2, 'amel', 'padang', '2008-08-12', 'Perempuan', 'pariaman', '0876458934', 'amel@gmail.com', 'sman 1 pariaman', '2001'),
(3, 'yuli elmita', 'Kampung Pauh', '2006-08-12', 'Perempuan', 'kampung pauh', '082152592770', 'yuli@gmail.com', 'SMAN 1 V KOTO KAMPUNG DALAM', '2001'),
(5, 'siti aini', 'pariaman', '2005-03-23', 'Perempuan', 'padang pariaman', '851246374687', 'ni@gmail.com', 'sman 2 pariaman', '2024'),
(6, 'siti aini', 'pariaman', '2005-03-23', 'Perempuan', 'padang pariaman', '851246374687', 'ni@gmail.com', 'sman 2 pariaman', '2024'),
(7, 'siti aini', 'pariaman', '2005-03-23', 'Perempuan', 'padang pariaman', '851246374687', 'ni@gmail.com', 'sman 2 pariaman', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendaftaran`
--

CREATE TABLE `tb_pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_calon` int(11) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `status_pendaftaran` enum('Menunggu','Diverifikasi','Diterima','Ditolak') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pendaftaran`
--

INSERT INTO `tb_pendaftaran` (`id_pendaftaran`, `id_calon`, `id_prodi`, `tanggal_daftar`, `status_pendaftaran`) VALUES
(4, 1, 2, '2026-07-19', 'Diterima'),
(7, 3, 2, '2025-09-13', 'Diterima'),
(11, 2, 2, '2025-11-26', 'Menunggu'),
(14, 7, 3, '2025-11-27', 'Menunggu');

-- --------------------------------------------------------

--
-- Table structure for table `tb_prodi`
--

CREATE TABLE `tb_prodi` (
  `id_prodi` int(11) NOT NULL,
  `nama_prodi` varchar(100) DEFAULT NULL,
  `jenjang` enum('D3','S1') DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_prodi`
--

INSERT INTO `tb_prodi` (`id_prodi`, `nama_prodi`, `jenjang`, `kuota`) VALUES
(1, 'Teknik Informatika', 'S1', 60),
(2, 'Sistem Informasi', 'S1', 40),
(3, 'Manajemen', 'S1', 50);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Admin','Panitia','calon mahasiswa') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
(2, 'user', '5f4dcc3b5aa765d61d8327deb882cf99', 'Panitia'),
(3, 'calon1', '827ccb0eea8a706c4c34a16891f84e7b', 'calon mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_berkas`
--
ALTER TABLE `tb_berkas`
  ADD PRIMARY KEY (`id_berkas`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indexes for table `tb_calon_mahasiswa`
--
ALTER TABLE `tb_calon_mahasiswa`
  ADD PRIMARY KEY (`id_calon`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_calon` (`id_calon`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indexes for table `tb_prodi`
--
ALTER TABLE `tb_prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_berkas`
--
ALTER TABLE `tb_berkas`
  MODIFY `id_berkas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_calon_mahasiswa`
--
ALTER TABLE `tb_calon_mahasiswa`
  MODIFY `id_calon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_prodi`
--
ALTER TABLE `tb_prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_berkas`
--
ALTER TABLE `tb_berkas`
  ADD CONSTRAINT `tb_berkas_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tb_pendaftaran` (`id_pendaftaran`);

--
-- Constraints for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `tb_pendaftaran_ibfk_1` FOREIGN KEY (`id_calon`) REFERENCES `tb_calon_mahasiswa` (`id_calon`),
  ADD CONSTRAINT `tb_pendaftaran_ibfk_2` FOREIGN KEY (`id_prodi`) REFERENCES `tb_prodi` (`id_prodi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
