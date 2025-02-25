-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 03:34 AM
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
-- Database: `db_uniformfinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_cart`
--

CREATE TABLE `tb_cart` (
  `ca_id` int(11) NOT NULL,
  `ca_product` int(11) NOT NULL,
  `ca_user` int(11) NOT NULL,
  `ca_qty` int(11) NOT NULL,
  `ca_size` varchar(255) DEFAULT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_cart`
--

INSERT INTO `tb_cart` (`ca_id`, `ca_product`, `ca_user`, `ca_qty`, `ca_size`, `order_id`) VALUES
(57, 9, 55, 1, 'L', 37),
(58, 18, 55, 1, 'L', 37),
(59, 9, 57, 1, '2XL', 38),
(60, 17, 58, 1, NULL, 39),
(61, 16, 58, 1, 'L', 39),
(62, 11, 58, 1, NULL, 39),
(63, 12, 58, 1, NULL, 39),
(64, 10, 58, 1, '32', 39),
(65, 9, 58, 1, 'L', 39),
(66, 13, 58, 1, '40', 39),
(67, 19, 59, 1, 'M', 40),
(68, 9, 59, 1, 'M', 40),
(69, 10, 59, 1, '32', 40),
(70, 11, 59, 1, NULL, 40),
(71, 12, 59, 1, NULL, 40),
(72, 13, 59, 1, '40', 40),
(73, 9, 60, 1, 'XL', 41),
(74, 10, 60, 1, '40', 41),
(75, 11, 60, 1, '', 41),
(76, 12, 60, 1, '', 41),
(77, 18, 60, 1, 'L', 41),
(78, 19, 61, 1, 'M', 42),
(79, 11, 61, 1, NULL, 42),
(80, 12, 61, 1, NULL, 42),
(81, 9, 63, 2, 'XL', 43),
(82, 10, 63, 1, '30', 43);

-- --------------------------------------------------------

--
-- Table structure for table `tb_cart_quota`
--

CREATE TABLE `tb_cart_quota` (
  `cq_id` int(11) NOT NULL,
  `cq_user` int(11) NOT NULL,
  `cq_product` int(11) NOT NULL,
  `cq_qty` int(11) NOT NULL,
  `cq_size` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_cart_quota`
--

INSERT INTO `tb_cart_quota` (`cq_id`, `cq_user`, `cq_product`, `cq_qty`, `cq_size`, `order_id`) VALUES
(61, 55, 9, 1, 'L', 37),
(62, 55, 10, 1, '36', 37),
(63, 55, 11, 1, '', 37),
(64, 55, 12, 1, '', 37),
(65, 55, 13, 1, '42', 37),
(66, 55, 19, 1, 'L', 37),
(67, 57, 9, 1, 'XL', 38),
(68, 57, 10, 1, '40', 38),
(69, 57, 11, 1, '', 38),
(70, 57, 12, 1, '', 38),
(71, 57, 13, 1, '40', 38),
(72, 57, 19, 1, 'XL', 38),
(78, 63, 10, 1, '40', 43),
(79, 63, 11, 1, '', 43),
(80, 63, 12, 1, '', 43),
(81, 63, 18, 1, 'XL', 43),
(82, 63, 9, 1, 'XL', 43);

-- --------------------------------------------------------

--
-- Table structure for table `tb_department`
--

CREATE TABLE `tb_department` (
  `dep_id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `room_qty` int(11) NOT NULL DEFAULT 1,
  `g_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_department`
--

INSERT INTO `tb_department` (`dep_id`, `department`, `room_qty`, `g_id`) VALUES
(3, 'เทคโนโลยีสารสนเทศ', 1, 5),
(4, 'เทคโนโลยีสารสนเทศ', 2, 4),
(6, 'ช่างยนต์', 1, 5),
(7, 'ยานยนต์', 1, 4),
(8, 'เทคนิคคอมพิวเตอร์', 1, 5),
(9, 'เทคโนโลยีคอมพิวเตอร์', 1, 4),
(10, 'ไฟฟ้ากำลัง', 1, 5),
(11, 'ไฟฟ้ากำลัง', 1, 4),
(12, 'อิเล็กทรอนิก-เเมคคาทรอนิกส์', 1, 4),
(13, 'อิเล็กทรอนิก-เเมคคาทรอนิกส์', 1, 5),
(14, 'ช่างเชื่อมโลหะ', 1, 5),
(15, 'ช่างกลโรงงาน', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tb_grade`
--

CREATE TABLE `tb_grade` (
  `g_id` int(11) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `quota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_grade`
--

INSERT INTO `tb_grade` (`g_id`, `grade`, `quota`) VALUES
(4, 'ประกาศนียบัตรวิชาชีพชั้นสูง', 0),
(5, 'ประกาศนียบัตรวิชาชีพ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `order_id` int(11) NOT NULL,
  `cus_name` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`order_id`, `cus_name`, `total_price`, `order_status`, `order_date`) VALUES
(37, 55, 480, 1, '2025-02-14 11:57:27'),
(38, 57, 300, 1, '2025-02-21 03:12:08'),
(39, 58, 1490, 1, '2025-02-21 03:14:35'),
(40, 59, 1270, 1, '2025-02-21 03:15:58'),
(41, 60, 950, 1, '2025-02-21 04:27:57'),
(42, 61, 330, 0, '2025-02-21 06:47:18'),
(43, 63, 920, 1, '2025-02-23 07:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `tb_preorder`
--

CREATE TABLE `tb_preorder` (
  `pre_id` int(11) NOT NULL,
  `pre_year` varchar(255) NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `pre_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_preorder`
--

INSERT INTO `tb_preorder` (`pre_id`, `pre_year`, `start_at`, `end_at`, `pre_status`) VALUES
(1, '1/2568', '2025-02-07', '2025-03-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(255) NOT NULL,
  `pro_price` int(11) NOT NULL,
  `pro_type` int(11) NOT NULL,
  `pro_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`pro_id`, `pro_name`, `pro_price`, `pro_type`, `pro_img`) VALUES
(9, 'เสื้อฝึกงาน', 300, 1, 'shop_ex1.png'),
(10, 'กางเกงผ้าเสิท', 320, 2, 'ex_3_student.jpg'),
(11, 'หัวเข็มขัด+สาย', 110, 3, 'th-11134207-7r98z-lnzlwqv1kx9jc4-removebg-preview (1).png'),
(12, 'เข็มกลัดอก ', 40, 3, 'K_911.png'),
(13, 'รองเท้าผ้าใบสีดำ', 320, 2, 'shose_student.jpg'),
(16, 'เสื้อขาวเเขนยาว', 220, 1, 'S0e71ac1bfeef4821ac2f1e61b3ac0ca2W.jpg_720x720q80.jpg'),
(17, 'ไทด์', 180, 3, 'nacktai.png'),
(18, 'เสื้อขาวเเขนสั้นชาย', 180, 1, 'original-1656506764621.jpg'),
(19, 'เสื้อขาวเเขนสั้นหญิง', 180, 1, 'ex_student.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_size`
--

CREATE TABLE `tb_size` (
  `size_id` int(11) NOT NULL,
  `size_img` varchar(255) NOT NULL,
  `size_product` varchar(255) NOT NULL,
  `sex` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_size`
--

INSERT INTO `tb_size` (`size_id`, `size_img`, `size_product`, `sex`) VALUES
(1, '20250207012454.jpg', 'เสื้อฝึกงานชาย', 1),
(3, '20250207021127.jpg', 'เสื้อนักเรียนหญิง', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_uquota`
--

CREATE TABLE `tb_uquota` (
  `u_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `u_qty` int(11) NOT NULL,
  `sex` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_uquota`
--

INSERT INTO `tb_uquota` (`u_id`, `pro_id`, `u_qty`, `sex`) VALUES
(42, 10, 1, 1),
(43, 10, 1, 2),
(44, 11, 1, 1),
(45, 11, 1, 2),
(46, 12, 1, 1),
(47, 12, 1, 2),
(48, 18, 1, 1),
(49, 9, 1, 1),
(50, 9, 1, 2),
(51, 19, 1, 2),
(52, 13, 1, 1),
(53, 13, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `citizen_id` varchar(13) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `g_id` int(11) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT 2,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `quota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `fullname`, `citizen_id`, `tel`, `g_id`, `dep_id`, `room`, `user_role`, `username`, `password`, `quota`) VALUES
(54, 'Administrator', '', '', 0, 0, 0, 1, 'admin', '1234', 0),
(55, 'กัณติกรณ์ สรสุริยวงษ์', '1179900459331', '0925195842', 5, 3, 1, 2, NULL, NULL, 1),
(56, 'นวรัตน์ สุขงาม', '1139900459331', '0865521134', 5, 3, 1, 2, NULL, NULL, 1),
(57, 'รัชชานนท์ ลาละคร', '1149900459331', '0875123341', 5, 3, 1, 2, NULL, NULL, 1),
(58, 'อาชวิน วงษ์พานิช', '1159900459331', '0851142348', 4, 4, 1, 2, NULL, NULL, 0),
(59, 'นวรัตน์ สุขงาม', '1169900459331', '0936455792', 4, 4, 1, 2, NULL, NULL, 0),
(60, 'ทิวาพร อินอิ่ม', '1189900459331', '0947789954', 4, 4, 1, 2, NULL, NULL, 0),
(61, 'นาฎนารี เอื้อเฟื้อพันธุ์', '1119900459331', '0854421145', 4, 4, 1, 2, NULL, NULL, 0),
(62, 'เกียรติศักดิ์ เรียบร้อย', '1109900459331', '0865541123', 5, 3, 1, 2, NULL, NULL, 1),
(63, 'กิตติทัต เชาว์เเปดริ้ว', '1219900459331', '0925195842', 5, 8, 1, 2, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD PRIMARY KEY (`ca_id`);

--
-- Indexes for table `tb_cart_quota`
--
ALTER TABLE `tb_cart_quota`
  ADD PRIMARY KEY (`cq_id`);

--
-- Indexes for table `tb_department`
--
ALTER TABLE `tb_department`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tb_preorder`
--
ALTER TABLE `tb_preorder`
  ADD PRIMARY KEY (`pre_id`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `tb_size`
--
ALTER TABLE `tb_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `tb_uquota`
--
ALTER TABLE `tb_uquota`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cart`
--
ALTER TABLE `tb_cart`
  MODIFY `ca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `tb_cart_quota`
--
ALTER TABLE `tb_cart_quota`
  MODIFY `cq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `tb_department`
--
ALTER TABLE `tb_department`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_grade`
--
ALTER TABLE `tb_grade`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tb_preorder`
--
ALTER TABLE `tb_preorder`
  MODIFY `pre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_size`
--
ALTER TABLE `tb_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_uquota`
--
ALTER TABLE `tb_uquota`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
