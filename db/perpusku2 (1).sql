-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jan 2024 pada 08.33
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpusku2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('aktif','tdk aktif') NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `status`, `create_date`) VALUES
(1, 'admin', '$2y$10$dmdVtV/DJBMos2AbV0E5L.hXBSxHMFll/WqPGfu3Y5RBBpmCaHDwi', 'aktif', '2023-12-23 08:30:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(5) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `jenis_buku` enum('Buku Bacaan','Buku Ajar(Diktat)') NOT NULL,
  `id_admin` int(5) NOT NULL,
  `file` varchar(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul_buku`, `deskripsi`, `pengarang`, `jenis_buku`, `id_admin`, `file`, `create_date`) VALUES
(1, 'Struktur Data Java', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magnam omnis quod ea, dolor neque hic deserunt harum nisi commodi rem amet delectus esse culpa, ratione recusandae numquam dolores reiciendis beatae?\r\nMolestiae temporibus quo labore, obcaecati esse repudiandae ut quam, laboriosam praesentium laborum, facilis magni quisquam placeat dignissimos accusamus nobis. Quidem alias maxime laboriosam illo debitis nulla natus hic? Harum, quam!\r\nLaborum iure dolorem corporis. Sequi officia ipsam quod cumque fugiat quasi exercitationem eum repellat, expedita commodi minus eius voluptas repudiandae, voluptates nisi nam rem? Consequuntur magnam dolores nobis recusandae impedit.\r\nModi deleniti iure debitis, explicabo atque reprehenderit distinctio! Obcaecati, voluptatum sint quod architecto repellat debitis odio iure cum, dolorem doloribus esse eos tenetur at magni adipisci magnam corrupti similique maiores!\r\nOmnis, doloremque consectetur unde nemo atque ratione ad voluptas. Dolor, possimus beatae. Sit quidem quo aut vero illum nisi, velit odio sapiente sequi blanditiis tenetur optio nostrum dicta laborum iure?', 'Pat Morin', 'Buku Bacaan', 1, 'ods-java.pdf', '2023-12-30 23:14:14'),
(26, 'Learn OOP Java', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nesciunt perferendis et harum, quia fugit quae perspiciatis labore? Magnam eos maiores voluptatem. Consequatur maiores ducimus rem impedit, id tenetur quidem laudantium.\r\nObcaecati sint facere labore eius quas explicabo modi quo ipsa quos cumque asperiores voluptatibus nostrum consectetur possimus, voluptates pariatur maxime error facilis iusto provident voluptatem, dolorum doloribus voluptatum laudantium! Cumque.\r\nSed minima doloremque eos, officia eius cumque tenetur excepturi mollitia porro fugiat quae veritatis eveniet, incidunt voluptate molestiae consequuntur. Ullam saepe corporis earum impedit repudiandae, rem nemo illum ipsum quam.\r\nRecusandae soluta, quo impedit tenetur magni corrupti error autem omnis tempore alias vero dolorem delectus ipsa nemo amet beatae, ratione eos officia blanditiis, quas laborum enim! Sequi perspiciatis voluptates consectetur.\r\nAlias libero adipisci molestias totam voluptatibus corporis, nisi ea quidem voluptatem. Sint eaque harum quaerat impedit qui nihil vel expedita nisi commodi aperiam et, ab delectus possimus ex debitis magnam.', 'Rudolf Pecinvovsky', 'Buku Bacaan', 1, 'PecinovskyOOP.pdf', '2024-01-15 07:36:22'),
(29, 'buku Laraver', 'buku', 'mr. x', 'Buku Bacaan', 1, 'Laravel.pdf', '2024-01-18 03:16:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lap_ta`
--

CREATE TABLE `lap_ta` (
  `id_laporan` int(5) NOT NULL,
  `judul_laporan` varchar(255) NOT NULL,
  `abstrak` text NOT NULL,
  `nim` int(8) NOT NULL,
  `file` varchar(255) NOT NULL,
  `status` enum('Proses','Selesai','Ditolak') NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lap_ta`
--

INSERT INTO `lap_ta` (`id_laporan`, `judul_laporan`, `abstrak`, `nim`, `file`, `status`, `create_date`) VALUES
(1, 'Implementasi Tanda Tangan Digital pada Kantor Kelurahan ABC', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Officiis similique et, modi qui dolores excepturi iure inventore esse nostrum vel omnis porro debitis blanditiis voluptas deserunt! Maiores et blanditiis omnis.\r\nAccusamus officia obcaecati repellat, autem placeat, a enim sed provident dolorem maiores quisquam maxime perspiciatis nihil est doloribus fugiat esse quidem. Veniam quibusdam delectus consequatur commodi maiores ducimus fugit odio.\r\nMagni vitae impedit nostrum fuga ullam, ipsum cupiditate rem odio exercitationem quasi commodi in aliquam fugit itaque voluptatum. Architecto illum repudiandae at mollitia aperiam tempore possimus, eaque magni temporibus fuga!\r\nReprehenderit illo similique omnis, libero tempora soluta aliquid voluptates asperiores tempore numquam velit consequatur veritatis ex accusantium molestias. Cupiditate, rem. Laborum, dicta. Fugit fugiat itaque recusandae iure? Eligendi, deserunt provident?\r\nMollitia iste facere dolor dolore rem? Sint alias molestiae aperiam pariatur saepe! Quae, neque nihil quisquam, hic iure placeat itaque quam quod necessitatibus distinctio commodi dolor culpa quasi dicta? Laboriosam?', 22302025, 'OMG UML.pdf', 'Selesai', '2024-01-15 07:46:36'),
(2, 'Pengembangan Situs Web UMKM Desa ABC untuk meningkatkan performa dan memperbaiki tampilan situs untuk meningkatkan daya tarik pembeli', '\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Commodi facere pariatur ducimus necessitatibus ex accusamus numquam. Hic quae libero impedit quo voluptas, alias placeat praesentium eaque. Modi id consequatur illo?\r\nQuo eveniet adipisci esse corrupti dolorum quidem et qui, hic totam rem! Earum ut minus iusto mollitia suscipit nihil, magnam, tenetur eveniet animi libero ullam perferendis, pariatur deserunt optio sit.\r\nExplicabo, delectus dolorum fugit accusantium aliquid nulla quis nesciunt sunt quidem debitis deserunt! Eum repudiandae velit, non magnam consectetur adipisci, architecto tempore nihil totam, accusamus labore obcaecati. Magnam, voluptas dolores.\r\nTempore, incidunt! Sunt harum sapiente vel, nostrum fuga quae ipsum dolorum totam soluta? Itaque cumque ipsa assumenda unde dicta inventore numquam, sed quam commodi sapiente magnam praesentium laborum quasi ullam.\r\nSapiente eos assumenda porro libero ab id ipsum aliquid! Sint, nesciunt molestiae. Odio aliquid iusto eum pariatur laborum iure, cupiditate iste quam velit assumenda autem, quos, aperiam architecto aspernatur voluptatibus!', 22302002, 'Pengembangan situs web UMKM.pdf', 'Selesai', '2023-12-30 23:24:59'),
(3, 'Pembuatan situs web pembelian e-tiketing untuk event jejepangan ROD Community', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi facere pariatur ducimus necessitatibus ex accusamus numquam. Hic quae libero impedit quo voluptas, alias placeat praesentium eaque. Modi id consequatur illo?\r\nQuo eveniet adipisci esse corrupti dolorum quidem et qui, hic totam rem! Earum ut minus iusto mollitia suscipit nihil, magnam, tenetur eveniet animi libero ullam perferendis, pariatur deserunt optio sit.\r\nExplicabo, delectus dolorum fugit accusantium aliquid nulla quis nesciunt sunt quidem debitis deserunt! Eum repudiandae velit, non magnam consectetur adipisci, architecto tempore nihil totam, accusamus labore obcaecati. Magnam, voluptas dolores.\r\nTempore, incidunt! Sunt harum sapiente vel, nostrum fuga quae ipsum dolorum totam soluta? Itaque cumque ipsa assumenda unde dicta inventore numquam, sed quam commodi sapiente magnam praesentium laborum quasi ullam.\r\nSapiente eos assumenda porro libero ab id ipsum aliquid! Sint, nesciunt molestiae. Odio aliquid iusto eum pariatur laborum iure, cupiditate iste quam velit assumenda autem, quos, aperiam architecto aspernatur voluptatibus! 😁', 22302001, 'Situs web pembelian e.pdf', 'Selesai', '2024-01-15 08:19:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mhs`
--

CREATE TABLE `mhs` (
  `nim` int(8) NOT NULL,
  `nama_mhs` varchar(50) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `id_prodi` int(5) NOT NULL,
  `id_smt` int(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('aktif','cuti','DO','undri') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mhs`
--

INSERT INTO `mhs` (`nim`, `nama_mhs`, `jenis_kelamin`, `id_prodi`, `id_smt`, `email`, `password`, `status`) VALUES
(12345, 'Amat', 'laki-laki', 1, 6, 'lordparadik@mail.com', '$2y$10$zKLoA6MpUQEFwahn6rpHBukuk5ktWtr93dKi0WNuwRjXoljv5AWZa', 'aktif'),
(22302001, 'Ancaya', 'perempuan', 1, 6, 'ancaya@mail.com', '$2y$10$OZcndYc9qQ5L5iRrLjSTGO0.dux9uZ6QFkGETTbiUd0RH.rdZoDXW', 'aktif'),
(22302002, 'Aya Salma', 'perempuan', 1, 6, 'aya@mail.com', '$2y$10$SpG5SqCzMYk3J5SMmzkxvOJMnEH1UnOOuC.FdoYK0toZ46xnTvOZO', 'aktif'),
(22302003, 'Basran', 'laki-laki', 2, 5, 'basran@mail.com', '$2y$10$LvRaZidyqWNMmOuWuyPjuOJqfGRBGBLHAv0a6D6nb91iG2aUWSFEa', 'undri'),
(22302011, 'Fajaruddin', 'laki-laki', 1, 3, 'fjr123@gmail.com', '$2y$10$pNsjF4CbYNAUJ0OMDCVu0Ojs0RTB1YjxdGTH6ZRagYoqNcx.JBBM6', 'cuti'),
(22302014, 'Muhammad Humaidi', 'laki-laki', 1, 3, 'mhumaidi@gmail.com', '$2y$10$SMD7d9Sz56mqxTq9ye8hwuxoeViYG0XhxPphUPWo1z/afCuy7Sgxy', 'aktif'),
(22302025, 'Pradika', 'laki-laki', 1, 6, 'lordparadik@mail.com', '$2y$10$5wjWfJiMqhlLBr5HzYiBHOPnYEDNr0mV1P.DpNJPsSdvHfpwTUpX2', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int(5) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL,
  `jenjang` enum('D3','D4') NOT NULL,
  `status` enum('aktif','tdk aktif') NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `nama_prodi`, `jenjang`, `status`, `create_date`) VALUES
(1, 'Teknik Informatika', 'D3', 'aktif', '2023-12-18 17:29:59'),
(2, 'Teknik Otomotif', 'D3', 'aktif', '2023-12-18 17:29:59'),
(3, 'Budidaya Tanaman Perkebunan', 'D3', 'aktif', '2023-12-18 17:29:59'),
(4, 'Bisnis Digital', 'D4', 'aktif', '2023-12-18 17:29:59'),
(5, 'Akuntansi Bisnis Digital', 'D4', 'aktif', '2023-12-18 17:29:59'),
(6, 'Manajemen Pemasaran Internasional', 'D4', 'aktif', '2023-12-18 17:29:59'),
(7, 'Rekayasa Multimedia', 'D4', 'tdk aktif', '2023-12-18 17:29:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `smt`
--

CREATE TABLE `smt` (
  `id_smt` int(5) NOT NULL,
  `nama_smt` enum('I','II','III','IV','V','VI','VII','VIII') NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `smt`
--

INSERT INTO `smt` (`id_smt`, `nama_smt`, `create_date`) VALUES
(1, 'I', '2023-12-18 17:28:27'),
(2, 'II', '2023-12-18 17:28:27'),
(3, 'III', '2023-12-18 17:28:27'),
(4, 'IV', '2023-12-18 17:28:27'),
(5, 'V', '2023-12-18 17:28:27'),
(6, 'VI', '2023-12-18 17:28:27'),
(7, 'VII', '2023-12-18 17:28:27'),
(8, 'VIII', '2023-12-18 17:28:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indeks untuk tabel `lap_ta`
--
ALTER TABLE `lap_ta`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `nim` (`nim`);

--
-- Indeks untuk tabel `mhs`
--
ALTER TABLE `mhs`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `id_prodi` (`id_prodi`),
  ADD KEY `id_smt` (`id_smt`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indeks untuk tabel `smt`
--
ALTER TABLE `smt`
  ADD PRIMARY KEY (`id_smt`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `lap_ta`
--
ALTER TABLE `lap_ta`
  MODIFY `id_laporan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `smt`
--
ALTER TABLE `smt`
  MODIFY `id_smt` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lap_ta`
--
ALTER TABLE `lap_ta`
  ADD CONSTRAINT `lap_ta_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mhs` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mhs`
--
ALTER TABLE `mhs`
  ADD CONSTRAINT `mhs_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mhs_ibfk_2` FOREIGN KEY (`id_smt`) REFERENCES `smt` (`id_smt`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
