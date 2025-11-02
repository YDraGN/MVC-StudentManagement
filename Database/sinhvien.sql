-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2025 at 01:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dulieu1`
--

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

CREATE TABLE `sinhvien` (
  `id` int(4) NOT NULL,
  `name` varchar(30) NOT NULL,
  `age` int(3) NOT NULL,
  `university` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`id`, `name`, `age`, `university`) VALUES
(1001, 'Nguyễn Quốc Hoàng', 20, 'Trường Đại học Y dược'),
(1002, 'Hoàng Phương Anh', 21, 'Trường Đại học Ngoại ngữ'),
(1003, 'Trần Ngọc Linh', 20, 'Trường Đại học Kinh tế'),
(1004, 'Nguyễn Hoàng Long', 20, 'Trường Đại học Bách khoa'),
(1005, 'Huỳnh Thế Thái', 19, 'Trường Đại học Bách khoa'),
(1006, 'Mai Anh Phương', 19, 'Trường Đại học Y dược'),
(1007, 'Cao Duy Linh', 19, 'Trường Đại học Bách khoa'),
(1008, 'Đặng Huy', 22, 'Trường Đại học Kinh tế'),
(1009, 'Nguyễn Viết Long', 21, 'Trường Đại học Sư phạm'),
(1010, 'Văn Lệ Thu', 22, 'Trường Đại học Ngoại Ngữ'),
(1011, 'Nguyễn Thị Quỳnh', 22, 'Trường Đại học Sư phạm Kỹ thuật'),
(1012, 'Trương Đình Ngọc', 19, 'Trường Đại học Ngoại ngữ'),
(1013, 'Lương Thế Nhân', 22, 'Trường Đại học Y dược'),
(1014, 'Trần Trung Quân', 23, 'Trường Đại học Bách khoa'),
(1015, 'Lương Thùy Trang', 20, 'Trường Đại học Ngoại ngữ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
