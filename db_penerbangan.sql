-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Apr 2024 pada 15.10
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penerbangan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_penerbangan`
--

CREATE TABLE `jadwal_penerbangan` (
  `id` bigint(20) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `harga` double NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `pilot_id` bigint(20) NOT NULL,
  `pesawat_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jadwal_penerbangan`
--

INSERT INTO `jadwal_penerbangan` (`id`, `tujuan`, `harga`, `tanggal`, `waktu`, `pilot_id`, `pesawat_id`) VALUES
(1, 'Gorontalo', 1240000, '2024-04-17', '00:00:00', 1, 1),
(4, 'Purwakarta', 1570000, '2024-04-16', '03:04:00', 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesawat`
--

CREATE TABLE `pesawat` (
  `id` bigint(20) NOT NULL,
  `nama_pesawat` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pesawat`
--

INSERT INTO `pesawat` (`id`, `nama_pesawat`, `kapasitas`, `foto`) VALUES
(1, 'Air Lines 21', 100, 'https://asset.kompas.com/crops/recuYnuMkWgjqeK1vzQC32wmNXY=/60x25:860x559/1200x800/data/photo/2021/12/06/61add220baf55.jpg'),
(3, 'Boeing 777', 430, 'assets/pesawat/pesawat_rusak.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pilot`
--

CREATE TABLE `pilot` (
  `id` bigint(20) NOT NULL,
  `nama_pilot` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pilot`
--

INSERT INTO `pilot` (`id`, `nama_pilot`, `foto`) VALUES
(1, 'Raihan Akbar', 'https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1483606600/r8ynjsgnkvtqfxljqbz8.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pilot_id` (`pilot_id`),
  ADD KEY `pesawat_id` (`pesawat_id`);

--
-- Indeks untuk tabel `pesawat`
--
ALTER TABLE `pesawat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pilot`
--
ALTER TABLE `pilot`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pesawat`
--
ALTER TABLE `pesawat`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pilot`
--
ALTER TABLE `pilot`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  ADD CONSTRAINT `jadwal_penerbangan_ibfk_1` FOREIGN KEY (`pilot_id`) REFERENCES `pilot` (`id`),
  ADD CONSTRAINT `jadwal_penerbangan_ibfk_2` FOREIGN KEY (`pesawat_id`) REFERENCES `pesawat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
