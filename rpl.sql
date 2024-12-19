-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 10:18 AM
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
-- Database: `rpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `topic_id`, `comment`, `created_at`) VALUES
(22, 16, 'coba cek youtube Pak Grafer, di sana banyak tutorial ', '2024-12-11 11:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `kritik_saran`
--

CREATE TABLE `kritik_saran` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kritik_saran`
--

INSERT INTO `kritik_saran` (`id`, `nama`, `email`, `pesan`, `tanggal`) VALUES
(7, 'Prima', 'prima@gmail.com', 'Jujur, websitenya udah keren, tapi kadang navigasinya agak ribet kalau buka dari HP, jadi suka bikin kurang nyaman. Mungkin bisa dibikin lebih responsif biar pas akses dari ponsel tuh tetap enak dan lancar. Semangat terus buat improve, yaa', '2024-12-14 04:00:12'),
(8, 'Kevin', 'kevingaul@gmail.com', 'Gambarnya keren-keren, tapi beberapa loadingnya lumayan lama, apalagi kalau koneksi internet lagi lambat. Mungkin bisa dicoba kompres gambar atau kasih loading bar biar pengunjung nggak bingung. Overall, websitenya udah oke banget kok, tinggal dipoles dikit lagi ajaa', '2024-12-14 04:00:34');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `username`, `image`, `uploaded_at`, `updated_at`) VALUES
(20, 'Maharani', '1734422481_2.JPG', '2024-12-14 03:22:37', '2024-12-17 08:01:21'),
(21, 'Wawan', '675cfa37b9254.jpg', '2024-12-14 03:23:35', '2024-12-17 07:15:15'),
(22, 'Samsudin', '675cfa5c876f2.jpg', '2024-12-14 03:24:12', '2024-12-17 07:15:15'),
(23, 'Muzala', '675cfa7b0963b.jpg', '2024-12-14 03:24:43', '2024-12-17 07:15:15'),
(25, 'Admin', '67613165b25c5.jpg', '2024-12-17 08:08:05', '2024-12-17 08:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topic` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `topic`, `created_at`) VALUES
(16, 'gimana ya cara agar hasil foto bagus?', '2024-12-11 09:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pengguna') DEFAULT 'pengguna',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'jeongwoo', '$2y$10$jQ91OnpNRdRnGNsGXZfdI.E7FkDsj3MgdM7sPMJ9RYlaBDt9HiXF.', 'pengguna', '2024-12-11 04:51:57'),
(2, 'admin', '$2b$12$.23QPfmNk5QWLjcXzw/tJ.aotsAczY0Hu7yB4omqCA.p9lodfO562', 'admin', '2024-12-11 04:53:07'),
(3, 'user', '$2y$10$irnLMOl1101tAYmFHqeCseHBFSRcXW/s47a.jhu30lhP.RPs24ZIa', 'pengguna', '2024-12-14 03:33:22'),
(4, 'Beni', '$2y$10$qN7BvFX49Hr.tay1LWLyE.aitBXSstQyOWZf/2F30gAwoNAZWmw6O', 'pengguna', '2024-12-15 20:54:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
