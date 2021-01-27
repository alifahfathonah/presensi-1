-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jan 2021 pada 13.38
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_presensi_binar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `idpresensi` int(7) NOT NULL,
  `idrule` varchar(8) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `no_absen` int(2) NOT NULL,
  `kelas` varchar(15) NOT NULL,
  `waktu` datetime NOT NULL,
  `isi` varchar(200) NOT NULL,
  `address` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rules`
--

CREATE TABLE `rules` (
  `idrule` varchar(8) NOT NULL,
  `iduser` int(3) NOT NULL,
  `tingkat` int(2) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `hari` int(1) NOT NULL,
  `awal` time NOT NULL,
  `akhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `iduser` int(3) NOT NULL,
  `username` varchar(35) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `terdaftar` datetime NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `nama` varchar(35) NOT NULL,
  `jenis` char(1) DEFAULT NULL,
  `status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`iduser`, `username`, `password`, `terdaftar`, `lastlogin`, `nama`, `jenis`, `status`) VALUES
(1, 'binar', 'efcfbe1784fb9b8a84eeac08fa9d1102', '2020-08-17 10:00:00', '2021-01-24 19:28:37', 'Binar Aris Purwaka', 'A', '1'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', '0000-00-00 00:00:00', '2021-01-12 15:30:26', 'Purwaka', 'A', '1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`idpresensi`);

--
-- Indeks untuk tabel `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`idrule`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `idpresensi` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
