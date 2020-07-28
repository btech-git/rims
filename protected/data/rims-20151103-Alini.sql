-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2015 at 04:26 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rims`
--

-- --------------------------------------------------------

--
-- Table structure for table `rims_bank`
--

CREATE TABLE IF NOT EXISTS `rims_bank` (
`id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` int(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_bank`
--

INSERT INTO `rims_bank` (`id`, `name`, `code`) VALUES
(1, 'BANK BRI', 2),
(2, 'BANK EKSPOR INDONESIA', 3),
(3, 'BANK MANDIRI', 8),
(4, 'BANK BNI', 9),
(5, 'BANK DANAMON', 11),
(6, 'PERMATA BANK', 13),
(7, 'BANK BCA', 14),
(8, 'BANK BII', 16),
(9, 'BANK PANIN', 19),
(10, 'BANK ARTA NIAGA KENCANA', 20),
(11, 'BANK NIAGA', 22),
(12, 'BANK BUANA IND', 23),
(13, 'BANK LIPPO', 26),
(14, 'BANK NISP', 28),
(15, 'AMERICAN EXPRESS BANK LTD', 30),
(16, 'CITIBANK ', 31),
(17, 'JP. MORGAN CHASE BANK, N.A.', 32),
(18, 'BANK OF AMERICA, N.A', 33),
(19, 'ING INDONESIA BANK', 34),
(20, 'BANK MULTICOR TBK.', 36),
(21, 'BANK ARTHA GRAHA', 37),
(22, 'BANK CREDIT AGRICOLE INDOSUEZ', 39),
(23, 'THE BANGKOK BANK COMP. LTD', 40),
(24, 'BANK HSBC', 41),
(25, 'THE BANK OF TOKYO MITSUBISHI UFJ LTD', 42),
(26, 'BANK SUMITOMO MITSUI INDONESIA', 45),
(27, 'BANK DBS INDONESIA', 46),
(28, 'BANK RESONA PERDANIA', 47),
(29, 'BANK MIZUHO INDONESIA', 48),
(30, 'STANDARD CHARTERED BANK', 50),
(31, 'BANK ABN AMRO', 52),
(32, 'BANK KEPPEL TATLEE BUANA', 53),
(33, 'BANK CAPITAL INDONESIA, TBK.', 54),
(34, 'BANK BNP PARIBAS INDONESIA', 57),
(35, 'BANK UOB INDONESIA', 58),
(36, 'KOREA EXCHANGE BANK DANAMON', 59),
(37, 'RABOBANK INTERNASIONAL INDONESIA', 60),
(38, 'ANZ PANIN BANK', 61),
(39, 'DEUTSCHE BANK AG.', 67),
(40, 'BANK WOORI INDONESIA', 68),
(41, 'BANK OF CHINA LIMITED', 69),
(42, 'BANK BUMI ARTA', 76),
(43, 'BANK EKONOMI', 87),
(44, 'BANK ANTARDAERAH', 88),
(45, 'BANK HAGA', 89),
(46, 'BANK IFI', 93),
(47, 'BANK CENTURY, TBK.', 95),
(48, 'BANK MAYAPADA', 97),
(49, 'BANK JABAR', 110),
(50, 'BANK DKI', 111),
(51, 'BPD DIY', 112),
(52, 'BANK JATENG', 113),
(53, 'BANK JATIM', 114),
(54, 'BPD JAMBI', 115),
(55, 'BPD ACEH', 116),
(56, 'BANK SUMUT', 117),
(57, 'BANK NAGARI', 118),
(58, 'BANK RIAU', 119),
(59, 'BANK SUMSEL', 120),
(60, 'BANK LAMPUNG', 121),
(61, 'BPD KALSEL', 122),
(62, 'BPD KALIMANTAN BARAT', 123),
(63, 'BPD KALTIM', 124),
(64, 'BPD KALTENG', 125),
(65, 'BPD SULSEL', 126),
(66, 'BANK SULUT', 127),
(67, 'BPD NTB', 128),
(68, 'BPD BALI', 129),
(69, 'BANK NTT', 130),
(70, 'BANK MALUKU', 131),
(71, 'BPD PAPUA', 132),
(72, 'BANK BENGKULU', 133),
(73, 'BPD SULAWESI TENGAH', 134),
(74, 'BANK SULTRA', 135),
(75, 'BANK NUSANTARA PARAHYANGAN', 145),
(76, 'BANK SWADESI', 146),
(77, 'BANK MUAMALAT', 147),
(78, 'BANK MESTIKA', 151),
(79, 'BANK METRO EXPRESS', 152),
(80, 'BANK SHINTA INDONESIA', 153),
(81, 'BANK MASPION', 157),
(82, 'BANK HAGAKITA', 159),
(83, 'BANK GANESHA', 161),
(84, 'BANK WINDU KENTJANA', 162),
(85, 'HALIM INDONESIA BANK', 164),
(86, 'BANK HARMONI INTERNATIONAL', 166),
(87, 'BANK KESAWAN', 167),
(88, 'BANK TABUNGAN NEGARA (PERSERO)', 200),
(89, 'BANK HIMPUNAN SAUDARA 1906, TBK', 0),
(90, 'BANK TABUNGAN PENSIUNAN NASIONAL', 213),
(91, 'BANK SWAGUNA', 405),
(92, 'BANK JASA ARTA', 422),
(93, 'BANK MEGA', 426),
(94, 'BANK JASA JAKARTA', 427),
(95, 'BANK BUKOPIN', 441),
(96, 'BANK SYARIAH MANDIRI', 451),
(97, 'BANK BISNIS INTERNASIONAL', 459),
(98, 'BANK SRI PARTHA', 466),
(99, 'BANK JASA JAKARTA', 472),
(100, 'BANK BINTANG MANUNGGAL', 484),
(101, 'BANK BUMIPUTERA', 485),
(102, 'BANK YUDHA BHAKTI', 490),
(103, 'BANK MITRANIAGA', 491),
(104, 'BANK AGRO NIAGA', 494),
(105, 'BANK INDOMONEX', 498),
(106, 'BANK ROYAL INDONESIA', 501),
(107, 'BANK ALFINDO', 503),
(108, 'BANK SYARIAH MEGA', 506),
(109, 'BANK INA PERDANA', 513),
(110, 'BANK HARFA', 517),
(111, 'PRIMA MASTER BANK', 520),
(112, 'BANK PERSYARIKATAN INDONESIA', 521),
(113, 'BANK AKITA', 525),
(114, 'LIMAN INTERNATIONAL BANK', 526),
(115, 'ANGLOMAS INTERNASIONAL BANK', 531),
(116, 'BANK DIPO INTERNATIONAL', 523),
(117, 'BANK KESEJAHTERAAN EKONOMI', 535),
(118, 'BANK UIB', 536),
(119, 'BANK ARTOS IND', 542),
(120, 'BANK PURBA DANARTA', 547),
(121, 'BANK MULTI ARTA SENTOSA', 548),
(122, 'BANK MAYORA', 553),
(123, 'BANK INDEX SELINDO', 555),
(124, 'BANK VICTORIA INTERNATIONAL', 566),
(125, 'BANK EKSEKUTIF', 558),
(126, 'CENTRATAMA NASIONAL BANK', 559),
(127, 'BANK FAMA INTERNASIONAL', 562),
(128, 'BANK SINAR HARAPAN BALI', 564),
(129, 'BANK HARDA', 567),
(130, 'BANK FINCONESIA', 945),
(131, 'BANK MERINCORP', 946),
(132, 'BANK MAYBANK INDOCORP', 947),
(133, 'BANK OCBC ? INDONESIA', 948),
(134, 'BANK CHINA TRUST INDONESIA', 949),
(135, 'BANK COMMONWEALTH', 950);

-- --------------------------------------------------------

--
-- Table structure for table `rims_branch`
--

CREATE TABLE IF NOT EXISTS `rims_branch` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_branch`
--

INSERT INTO `rims_branch` (`id`, `code`, `name`, `address`, `province_id`, `city_id`, `zipcode`, `phone`, `fax`, `email`, `status`) VALUES
(1, 'B01', 'Branch 1', 'TEst', 12, 39, '11460', '1234578900', '1231321312', 'test@test.com', 'Active'),
(2, 'B02', 'Branch 2', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'bett@gmail.com', 'Active'),
(3, 'B03', 'Branch 3', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'dindin@gmail.com', 'Active'),
(4, 'B04', 'Branch 4', 'Bekasi', 12, 39, '10230', '261202713', '261202713', 'lolo@gmail,com', 'Active'),
(5, 'B05', 'Branch 5', 'grogol', 12, 39, '10230', '261202713', '261202713', 'irir@gmail.com', 'Active'),
(6, 'B06', 'Branch 6', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'keket@gmail.com', 'Active'),
(7, 'B07', 'Branch 7', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'alal@.gmail.com', 'Active'),
(8, 'B08', 'Branch 8', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'rere@gmail.com', 'Active'),
(11, 'B12', 'Branch 12', 'Jl Asdfghk', 12, 41, '12345', '1234578900', '1231321312', 'test@test.com', 'Active'),
(12, 'R1', 'raperind Kalimalang', 'kalimalang', 12, 41, '13450', '0218643595', '8641717', 'customerservice@raperind.com', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_branch_fax`
--

CREATE TABLE IF NOT EXISTS `rims_branch_fax` (
`id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `fax_no` varchar(20) NOT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_branch_fax`
--

INSERT INTO `rims_branch_fax` (`id`, `branch_id`, `fax_no`, `status`) VALUES
(1, 1, '0987662123', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_branch_phone`
--

CREATE TABLE IF NOT EXISTS `rims_branch_phone` (
`id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) NOT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_branch_phone`
--

INSERT INTO `rims_branch_phone` (`id`, `branch_id`, `phone_no`, `status`) VALUES
(1, 1, '0218881231', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_branch_warehouse`
--

CREATE TABLE IF NOT EXISTS `rims_branch_warehouse` (
`id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_branch_warehouse`
--

INSERT INTO `rims_branch_warehouse` (`id`, `branch_id`, `warehouse_id`) VALUES
(3, 1, 5),
(4, 1, 1),
(5, 11, 6),
(6, 1, 12),
(7, 12, 1),
(8, 12, 13);

-- --------------------------------------------------------

--
-- Table structure for table `rims_chasis_code`
--

CREATE TABLE IF NOT EXISTS `rims_chasis_code` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `year_end` int(11) DEFAULT NULL,
  `year_start` int(11) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_city`
--

CREATE TABLE IF NOT EXISTS `rims_city` (
`id` int(11) NOT NULL,
  `province_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_city`
--

INSERT INTO `rims_city` (`id`, `province_id`, `name`, `code`) VALUES
(1, 1, 'Banda Aceh', NULL),
(2, 1, 'Langsa', NULL),
(3, 1, 'Lhokseumawe', NULL),
(4, 2, 'Binjai', NULL),
(5, 2, 'Gunung Sitoli', NULL),
(6, 2, 'Medan', NULL),
(7, 2, 'Lubuk Pakam', NULL),
(8, 2, 'Padang Sidempuan', NULL),
(9, 2, 'Pematang Siantar', NULL),
(10, 2, 'Sibolga', NULL),
(11, 2, 'Tanjung Balai', NULL),
(12, 2, 'Tebing Tinggi', NULL),
(13, 3, 'Bukittinggi', NULL),
(14, 3, 'Padang', NULL),
(15, 3, 'Padang Panjang', NULL),
(16, 3, 'Pariaman', NULL),
(17, 3, 'Payakumbuh', NULL),
(18, 3, 'Sawah Lunto', NULL),
(19, 3, 'Solok', NULL),
(20, 4, 'Dumai', NULL),
(21, 4, 'Pekanbaru', NULL),
(22, 5, 'Batam', NULL),
(23, 5, 'Tanjung Pinang', NULL),
(24, 6, 'Pangkal Pinang', NULL),
(25, 7, 'Jambi', NULL),
(26, 7, 'Sungai Penuh', NULL),
(27, 8, 'Bengkulu', NULL),
(28, 9, 'Lubuklinggau', NULL),
(29, 9, 'Pagar Alam', NULL),
(30, 9, 'Palembang', NULL),
(31, 9, 'Prabumulih', NULL),
(32, 10, 'Bandar Lampung', NULL),
(33, 10, 'Metro', NULL),
(34, 11, 'Cilegon', NULL),
(35, 12, 'Serang', NULL),
(36, 12, 'Tangerang', NULL),
(37, 12, 'Tangerang Selatan', NULL),
(38, 12, 'Jakarta Barat', NULL),
(39, 12, 'Jakarta Pusat', NULL),
(40, 12, 'Jakarta Selatan', NULL),
(41, 12, 'Jakarta Timur', NULL),
(42, 12, 'Jakara Utara', NULL),
(43, 13, 'Bandung', NULL),
(44, 13, 'Banjar', NULL),
(45, 13, 'Bekasi', NULL),
(46, 13, 'Bogor', NULL),
(47, 13, 'Cimahi', NULL),
(48, 13, 'Cirebon', NULL),
(49, 13, 'Depok', NULL),
(50, 13, 'Sukabumi', NULL),
(51, 13, 'Tasikmalaya', NULL),
(52, 14, 'Magelang', NULL),
(53, 14, 'Pekalongan', NULL),
(54, 14, 'Salatiga', NULL),
(55, 14, 'Semarang', NULL),
(56, 14, 'Surakarta', NULL),
(57, 14, 'Tegal', NULL),
(58, 15, 'Yogyakarta', NULL),
(59, 16, 'Batj', NULL),
(60, 16, 'Blitar', NULL),
(61, 16, 'Kediri', NULL),
(62, 16, 'Madiun', NULL),
(63, 16, 'Malang', NULL),
(64, 16, 'Mojokerto', NULL),
(65, 16, 'Pasuruan', NULL),
(66, 16, 'Probolinggo', NULL),
(67, 16, 'Surabaya', NULL),
(68, 17, 'Denpasar', NULL),
(69, 18, 'Bima', NULL),
(70, 18, 'Mataram', NULL),
(71, 19, 'Kupang', NULL),
(72, 20, 'Pontianak', NULL),
(73, 20, 'Singkawang', NULL),
(74, 21, 'Palangkaraya', NULL),
(75, 22, 'Banjar Baru', NULL),
(76, 22, 'Banjarmasin', NULL),
(77, 23, 'Balikpapan', NULL),
(78, 23, 'Bontang', NULL),
(79, 23, 'Samarinda', NULL),
(80, 23, 'Tarakan', NULL),
(81, 24, 'Gorontalo', NULL),
(82, 25, 'Makassar', NULL),
(83, 25, 'Palopo', NULL),
(84, 25, 'Pare - pare', NULL),
(85, 26, 'Bau - bau', NULL),
(86, 26, 'Kendari', NULL),
(87, 27, 'Palu', NULL),
(88, 28, 'Bitung', NULL),
(89, 28, 'Kotamobagu', NULL),
(90, 28, 'Manado', NULL),
(91, 28, 'Tomohon', NULL),
(92, 30, 'Ambon', NULL),
(93, 30, 'Tual', NULL),
(94, 31, 'Ternate', NULL),
(95, 31, 'Tidore Kepulauan', NULL),
(96, 32, 'Sorong', NULL),
(97, 33, 'Jayapura', NULL),
(98, 34, 'Tarakan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rims_colors`
--

CREATE TABLE IF NOT EXISTS `rims_colors` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_colors`
--

INSERT INTO `rims_colors` (`id`, `name`, `status`) VALUES
(1, 'Red', 'Active'),
(2, 'Black', ''),
(3, 'Blue', '');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer`
--

CREATE TABLE IF NOT EXISTS `rims_customer` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `customer_type` varchar(10) NOT NULL,
  `default_payment_type` int(11) NOT NULL,
  `tenor` int(11) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `birthdate` date NOT NULL,
  `flat_rate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_customer`
--

INSERT INTO `rims_customer` (`id`, `name`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email`, `note`, `customer_type`, `default_payment_type`, `tenor`, `status`, `birthdate`, `flat_rate`) VALUES
(1, 'Budi', 'Jl. abc no 1234', 12, 39, '13231', '123456789', 'budi@gmail.com', 'Testing', 'Individual', 0, 30, 'Active', '0000-00-00', '0.00'),
(2, 'John Legend', 'Jl. Kebon Kacang 2', 12, 39, '12344', '', 'john@legend.co.id', 'Test test test', 'Company', 0, 20, 'Active', '0000-00-00', '0.00'),
(3, 'Stefani', 'Jl. Kebon Melati', 12, 39, '12314', '1231321312', 'test@test.com', '', 'Individual', 0, 0, 'Active', '0000-00-00', '0.00'),
(4, 'Fajar', 'Jalan Aceh No 4', 12, 39, '', '', 'test@test.com', '', 'Individual', 0, 0, 'Active', '0000-00-00', '0.00'),
(5, 'Newira', 'Billy & Moon', 12, 39, '', '', 'abc@yahoo.com', '', 'Individual', 0, 0, 'Active', '0000-00-00', '0.00'),
(6, 'Bambang Pamungkas', 'Jalan Anggrek Loka 4 blok D no.15', 12, 39, '14140', '123456', 'Bambang_pamungkas@yahoo.com', '', 'Company', 0, 10, 'Active', '0000-00-00', '0.00'),
(7, 'Ajeng inem', 'jalan camar 5 no.10', 12, 39, '141710', '123456', 'ajenginem@gmail.com', '', 'Individual', 0, 10, 'Active', '0000-00-00', '0.00'),
(8, 'Ria Astika', 'Jalan kasuari 7 no.13', 12, 39, '171710', '123456', 'riaastika@gmail.com', '', 'Individual', 0, 10, 'Active', '0000-00-00', '0.00'),
(9, 'Sasa Angin', 'jalan cendrawasih 10', 12, 39, '141710', '1243654', 'sasa.angin@yahoo.com', '', 'Individual', 0, 15, 'Active', '0000-00-00', '0.00'),
(10, 'Amin sungkar', 'jalan sesama', 12, 39, '171709', '123456', 'aminsungkar@yahoo.com', '', 'Individual', 0, 20, 'Active', '0000-00-00', '0.00'),
(11, 'sharen ajeng', 'jalan salak 10', 12, 39, '14146', '123456', 'apaaja@yahoo.com', '', 'Individual', 0, 15, 'Active', '0000-00-00', '0.00'),
(12, 'PT CITA PRAKASA', 'Jalan abang irama 10 no.13', 12, 39, '141432', '365452', 'citaprakasa.co.id', '', 'Company', 0, 123, 'Active', '0000-00-00', '1.00'),
(13, 'Pretty Maksimal ', 'Jalan Cabe Terong 5', 12, 39, '171736', '123654', 'Pretty_maksimal@yahoo.com', '', 'Company', 0, 12, 'Active', '0000-00-00', '2.00'),
(14, 'Tommy', 'Jalan Cabe Terong 5', 12, 39, '171736', '123654', 'tommy@yahoo.com', '', 'Individual', 0, 12, 'Active', '0000-00-00', '2.00'),
(15, 'Husni Thamrin', 'Jl.husni thamrin no 101', 12, 39, '161345', '65412354', 'Husni_thamrin@yahoo.com', '', 'Company', 0, 12, 'Active', '0000-00-00', '1.00'),
(16, 'Chiko jeriko', 'Jalan sudirman 10 no.11', 12, 39, '36541236', '6545659', 'Chikojer@yahoo.com', '', 'Company', 0, 123, 'Active', '0000-00-00', '2.00'),
(17, 'Iman Sitepu', 'Jalan Mawar 5', 12, 39, '191865', '6321545', 'Iman@ymail.com', '', 'Individual', 0, 65, 'Active', '0000-00-00', '3.00'),
(18, 'Yenny wulandari', 'Bontang', 12, 39, '321546', '123456', 'yenny_wulandari@yahoo.com', '', 'Individual', 0, 12, 'Active', '0000-00-00', '3.00'),
(19, 'Tora Suyatno', 'Palangkaraya', 12, 39, '141630', '6541263', 'tora_suyatno', '', 'Company', 0, 12, 'Active', '0000-00-00', '12.00'),
(20, 'Rike supriyadi', 'Bogor', 12, 39, '161325', '', 'test@test.com', '', 'Company', 0, 0, 'Active', '0000-00-00', '0.00'),
(21, 'Bblabla', 'blabl', 12, 39, '', '', 'irwansyahdastan@gmail.com', '', 'Individual', 0, 0, 'Active', '0000-00-00', '0.00'),
(22, 'Alini', 'Jl Thamrin2312', 12, 39, '12311', '12312132131321', 'test@test.com', '', 'Individual', 0, 20, '', '1959-02-01', '1.00'),
(27, 'PT. ABCDEFGH', 'afsdafsdfa', 12, 36, '123211', '12312132131321', 'test@test.com', '', 'Individual', 3, 30, '', '1959-02-01', '1.00'),
(28, 'Tester', 'Testing', 12, 38, '12421', '12312132131321', 'test@test.com', '', 'Individual', 1, 20, '', '1987-04-17', '1.00'),
(29, 'Newira', 'Billy Moon', 12, 41, '13450', '', '', '', 'Individual', 1, 30, '', '2015-10-08', '100000.00');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_customer_mobile` (
`id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_customer_mobile`
--

INSERT INTO `rims_customer_mobile` (`id`, `customer_id`, `mobile_no`, `status`) VALUES
(1, 1, '0812', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_phone`
--

CREATE TABLE IF NOT EXISTS `rims_customer_phone` (
`id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_customer_phone`
--

INSERT INTO `rims_customer_phone` (`id`, `customer_id`, `phone_no`, `status`) VALUES
(1, 22, '122212231', NULL),
(2, 28, '09281664241', 'Active'),
(3, 28, '982112122', 'Active'),
(4, 1, '0212212212', 'Active'),
(5, 29, '0218859852', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_pic`
--

CREATE TABLE IF NOT EXISTS `rims_customer_pic` (
`id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `note` text,
  `status` varchar(10) DEFAULT 'Active',
  `birthdate` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_customer_pic`
--

INSERT INTO `rims_customer_pic` (`id`, `customer_id`, `name`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email`, `note`, `status`, `birthdate`) VALUES
(1, 1, 'Tono', 'Jl def', 12, 41, '21091', '', 'tono@gmail.com', 'Testing', 'Active', '1976-09-12'),
(2, 29, 'Andi', 'kalimalang', 13, 45, '17145', '', '', '', 'Active', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_pic_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_customer_pic_mobile` (
`id` int(11) NOT NULL,
  `customer_pic_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_pic_phone`
--

CREATE TABLE IF NOT EXISTS `rims_customer_pic_phone` (
`id` int(11) NOT NULL,
  `customer_pic_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_service_rate`
--

CREATE TABLE IF NOT EXISTS `rims_customer_service_rate` (
`id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_deduction`
--

CREATE TABLE IF NOT EXISTS `rims_deduction` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `amount` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_deduction`
--

INSERT INTO `rims_deduction` (`id`, `name`, `description`, `amount`) VALUES
(1, 'Uniform', '', ''),
(2, 'Shoes', 'Shoes', ''),
(3, 'BPJS', 'Insurance', '');

-- --------------------------------------------------------

--
-- Table structure for table `rims_division`
--

CREATE TABLE IF NOT EXISTS `rims_division` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) DEFAULT 'Active',
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_division`
--

INSERT INTO `rims_division` (`id`, `name`, `status`, `code`) VALUES
(1, 'HR Department', 'Active', 'D01'),
(2, 'Body Repair', 'Active', 'D02'),
(3, 'General Repair', 'Active', 'D03'),
(4, 'Tire', 'Active', 'D04'),
(5, 'Accounting', 'Active', 'D06');

-- --------------------------------------------------------

--
-- Table structure for table `rims_division_branch`
--

CREATE TABLE IF NOT EXISTS `rims_division_branch` (
`id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `email` varchar(60) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_division_branch`
--

INSERT INTO `rims_division_branch` (`id`, `division_id`, `branch_id`, `email`) VALUES
(1, 5, 4, NULL),
(2, 5, 1, 'accounting@test.com'),
(3, 3, 11, NULL),
(4, 1, 1, 'hr@test.com'),
(5, 2, 12, NULL),
(6, 1, 12, NULL),
(7, 5, 12, NULL),
(8, 4, 12, NULL),
(9, 3, 12, NULL),
(10, 3, 1, 'gr@test.com');

-- --------------------------------------------------------

--
-- Table structure for table `rims_division_position`
--

CREATE TABLE IF NOT EXISTS `rims_division_position` (
`id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_division_position`
--

INSERT INTO `rims_division_position` (`id`, `division_id`, `position_id`) VALUES
(1, 1, 4),
(2, 1, 7),
(3, 3, 4),
(4, 3, 6),
(6, 4, 4),
(7, 5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee`
--

CREATE TABLE IF NOT EXISTS `rims_employee` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `local_address` text NOT NULL,
  `home_address` text NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `home_province` int(11) NOT NULL,
  `home_city` int(11) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `email` varchar(60) NOT NULL,
  `id_card` varchar(30) NOT NULL,
  `driving_licence` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `salary_type` varchar(50) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_employee`
--

INSERT INTO `rims_employee` (`id`, `name`, `local_address`, `home_address`, `province_id`, `city_id`, `home_province`, `home_city`, `sex`, `email`, `id_card`, `driving_licence`, `status`, `salary_type`, `basic_salary`, `payment_type`, `code`) VALUES
(26, 'Test', 'Jl perdana', 'jl perdana', 12, 38, 12, 38, 'Male', 'test@test.com', '12314124123231', '79879776870334', 'Active', 'Monthly', '2000000.00', 'Transfer', 'E01'),
(27, 'Sunar', 'Bedeng B123, Pondok Kelapa', 'Simpang 5, pati', 14, 55, 1, 1, 'Male', 's@raperind.com', '834343k3434', '34234', 'Active', 'Daily', '75000.00', 'Transfer', '1001');

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_bank`
--

CREATE TABLE IF NOT EXISTS `rims_employee_bank` (
`id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_employee_bank`
--

INSERT INTO `rims_employee_bank` (`id`, `bank_id`, `employee_id`, `account_no`, `account_name`, `status`) VALUES
(3, 5, 26, 'Ardi', '12312321312', 0),
(4, 7, 27, '2312', '3545345', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_deductions`
--

CREATE TABLE IF NOT EXISTS `rims_employee_deductions` (
`id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `deduction_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_employee_deductions`
--

INSERT INTO `rims_employee_deductions` (`id`, `employee_id`, `deduction_id`, `amount`) VALUES
(1, 27, 1, '50000.00'),
(2, 27, 2, '50000.00'),
(3, 27, 3, '50000.00'),
(4, 26, 1, '300000.00');

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_division_position_level`
--

CREATE TABLE IF NOT EXISTS `rims_employee_division_position_level` (
`id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_employee_division_position_level`
--

INSERT INTO `rims_employee_division_position_level` (`id`, `employee_id`, `division_id`, `position_id`, `level_id`, `status`) VALUES
(2, 26, 1, 4, 3, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_incentives`
--

CREATE TABLE IF NOT EXISTS `rims_employee_incentives` (
`id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `incentive_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_employee_incentives`
--

INSERT INTO `rims_employee_incentives` (`id`, `employee_id`, `incentive_id`, `amount`) VALUES
(1, 26, 2, '40000.00'),
(2, 27, 2, '75000.00'),
(3, 27, 3, '200000.00'),
(4, 27, 4, '300000.00');

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_employee_mobile` (
`id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_employee_mobile`
--

INSERT INTO `rims_employee_mobile` (`id`, `employee_id`, `mobile_no`, `status`) VALUES
(1, 26, '08754868782', NULL),
(2, 27, '0877222111', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_phone`
--

CREATE TABLE IF NOT EXISTS `rims_employee_phone` (
`id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_employee_phone`
--

INSERT INTO `rims_employee_phone` (`id`, `employee_id`, `phone_no`, `status`) VALUES
(1, 26, '0921266616', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rims_incentive`
--

CREATE TABLE IF NOT EXISTS `rims_incentive` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `amount` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_incentive`
--

INSERT INTO `rims_incentive` (`id`, `name`, `description`, `amount`) VALUES
(2, 'Overtime', 'Work hour > 10 hours', ''),
(3, 'Handphone', 'handphone', ''),
(4, 'Transport', 'transport', '');

-- --------------------------------------------------------

--
-- Table structure for table `rims_level`
--

CREATE TABLE IF NOT EXISTS `rims_level` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_level`
--

INSERT INTO `rims_level` (`id`, `name`, `status`) VALUES
(3, 'Junior', 'Active'),
(4, 'Senior', 'Active'),
(5, 'Intern', 'Active'),
(6, 'Head', 'Active'),
(7, 'Manager', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_onvetrains`
--

CREATE TABLE IF NOT EXISTS `rims_onvetrains` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_position`
--

CREATE TABLE IF NOT EXISTS `rims_position` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_position`
--

INSERT INTO `rims_position` (`id`, `name`, `status`) VALUES
(4, 'Mechanic', 'Active'),
(5, 'Manager', 'Active'),
(6, 'Service Advisor', 'Active'),
(7, 'Accounting', 'Active'),
(8, 'Finance', 'Active'),
(9, 'Supervisor', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_position_level`
--

CREATE TABLE IF NOT EXISTS `rims_position_level` (
`id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_position_level`
--

INSERT INTO `rims_position_level` (`id`, `position_id`, `level_id`) VALUES
(3, 9, 6),
(4, 4, 3),
(5, 4, 4),
(6, 4, 6),
(7, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `rims_powercc`
--

CREATE TABLE IF NOT EXISTS `rims_powercc` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product`
--

CREATE TABLE IF NOT EXISTS `rims_product` (
`id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `production_year` int(11) NOT NULL,
  `product_master_category_id` int(11) NOT NULL,
  `product_sub_master_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) NOT NULL,
  `product_specification_type_id` int(11) NOT NULL,
  `vehicle_car_make_id` int(11) NOT NULL,
  `vehicle_car_model_id` int(11) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `minimum_selling_price` decimal(10,2) NOT NULL,
  `hpp` decimal(10,2) NOT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `minimum_stock` int(11) NOT NULL,
  `margin_type` int(11) NOT NULL,
  `margin_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_master_category`
--

CREATE TABLE IF NOT EXISTS `rims_product_master_category` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_product_master_category`
--

INSERT INTO `rims_product_master_category` (`id`, `code`, `name`, `description`, `status`) VALUES
(1, 'A', 'Air, Fuel, Emission & Exhaust', '', 'Active'),
(2, 'B', 'Accessories, Body & Wipers', '', 'Active'),
(3, 'C', 'Batteries, Electrical & Wiring', '', 'Active'),
(4, 'D', 'Brakes, Steering & Suspension', '', 'Active'),
(5, 'E', 'Cooling & Heating', '', 'Active'),
(6, 'F', 'Electronics & Navigation', '', 'Active'),
(7, 'G', 'Engines & Ignition', '', 'Active'),
(8, 'H', 'Tools, Fluids & Garage', '', 'Active'),
(9, 'I', 'Transmission & Drivetrain', '', 'Active'),
(10, 'J', 'Service Material & Supply ', 'Bahan/Perlengkapan', 'Active'),
(11, 'K', 'Service Tools', 'Tools/Alat', 'Active'),
(12, 'L', 'In-Out Parts (Bonus)', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_specification_info`
--

CREATE TABLE IF NOT EXISTS `rims_product_specification_info` (
`id` int(11) NOT NULL,
  `product_specification_type_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_specification_type`
--

CREATE TABLE IF NOT EXISTS `rims_product_specification_type` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_sub_category`
--

CREATE TABLE IF NOT EXISTS `rims_product_sub_category` (
`id` int(11) NOT NULL,
  `product_master_category` int(11) NOT NULL,
  `product_sub_master_category_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1116 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_product_sub_category`
--

INSERT INTO `rims_product_sub_category` (`id`, `product_master_category`, `product_sub_master_category_id`, `code`, `name`, `description`, `status`) VALUES
(1, 1, 1, '01', 'Air Cleaner Assemblies', '', 'Active'),
(2, 1, 1, '02', 'Air Cleaner Components', '', 'Active'),
(3, 1, 1, '03', 'Air Filter Hardware', '', 'Active'),
(4, 1, 1, '04', 'Air Filter Housing', '', 'Active'),
(5, 1, 1, '05', 'Air Filter Oils & Cleaners', '', 'Active'),
(6, 1, 1, '06', 'Air Filters', '', 'Active'),
(7, 1, 1, '07', 'Air Filters Components', '', 'Active'),
(8, 1, 1, '08', 'Air Intake Kits', '', 'Active'),
(9, 1, 1, '09', 'Cabin Air Filter Hardware', '', 'Active'),
(10, 1, 1, '10', 'Cabin Air Filters', '', 'Active'),
(11, 1, 1, '11', 'Dual Flanged Oval Filters', '', 'Active'),
(12, 1, 1, '12', 'Filters - Performance', '', 'Active'),
(13, 1, 1, '13', 'Motorcycle Air Filters', '', 'Active'),
(14, 1, 1, '14', 'Oval Straight Air Filters', '', 'Active'),
(15, 1, 1, '15', 'Oval Tapered Air Filters', '', 'Active'),
(16, 1, 1, '16', 'Rectangular Air Filters', '', 'Active'),
(17, 1, 1, '17', 'Round Straight Air Filters', '', 'Active'),
(18, 1, 1, '18', 'Round Tapered Air Filters', '', 'Active'),
(19, 1, 1, '19', 'Triangular Air Filters', '', 'Active'),
(20, 1, 1, '20', 'Universal Air Filters', '', 'Active'),
(21, 1, 2, '01', 'Accelerator Cables', '', 'Active'),
(22, 1, 2, '02', 'Air Cleaner Assemblies', '', 'Active'),
(23, 1, 2, '03', 'Carburetor Adapter Plates', '', 'Active'),
(24, 1, 2, '04', 'Carburetor Choke Parts', '', 'Active'),
(25, 1, 2, '05', 'Carburetor Dash Pots', '', 'Active'),
(26, 1, 2, '06', 'Carburetor Floats', '', 'Active'),
(27, 1, 2, '07', 'Carburetor Fuel Parts', '', 'Active'),
(28, 1, 2, '08', 'Carburetor Gaskets & Spacers', '', 'Active'),
(29, 1, 2, '09', 'Carburetor Hardware', '', 'Active'),
(30, 1, 2, '10', 'Carburetor Parts', '', 'Active'),
(31, 1, 2, '11', 'Carburetor Repair Kits', '', 'Active'),
(32, 1, 2, '12', 'Carburetor Solenoids', '', 'Active'),
(33, 1, 2, '13', 'Carburetor Studs & Kits', '', 'Active'),
(34, 1, 2, '14', 'Carburetors', '', 'Active'),
(35, 1, 2, '15', 'Carburetors - Performance', '', 'Active'),
(36, 1, 2, '16', 'Holley Jets', '', 'Active'),
(37, 1, 2, '17', 'Intake Manifold Components', '', 'Active'),
(38, 1, 2, '18', 'Intake Manifold Hardware', '', 'Active'),
(39, 1, 2, '19', 'Intake Manifold', '', 'Active'),
(40, 1, 3, '01', 'Air Injection Air Supplies', '', 'Active'),
(41, 1, 3, '02', 'Air Injection Pipes & Tubes', '', 'Active'),
(42, 1, 3, '03', 'Air Injection Valves', '', 'Active'),
(43, 1, 3, '04', 'Air Pump Filters', '', 'Active'),
(44, 1, 3, '05', 'Air Pump Hoses & Grommets', '', 'Active'),
(45, 1, 3, '06', 'Auxilliary Air Valve Parts', '', 'Active'),
(46, 1, 3, '07', 'Auxilliary Air Valves', '', 'Active'),
(47, 1, 3, '08', 'Canister Purge Solenoids', '', 'Active'),
(48, 1, 3, '09', 'Canister Purge Valves', '', 'Active'),
(49, 1, 3, '10', 'Connectors, Valves & Solenoids', '', 'Active'),
(50, 1, 3, '11', 'EGR Valve Parts & Accessories', '', 'Active'),
(51, 1, 3, '12', 'EGR Valves', '', 'Active'),
(52, 1, 3, '13', 'Emission Gaskets & Seals', '', 'Active'),
(53, 1, 3, '14', 'Emission Hardware', '', 'Active'),
(54, 1, 3, '15', 'Emission Mounts', '', 'Active'),
(55, 1, 3, '16', 'Emission Sensors & Solenoids', '', 'Active'),
(56, 1, 3, '18', 'Oxygen Sensor Components', '', 'Active'),
(57, 1, 3, '19', 'PCV Valves & Related', '', 'Active'),
(58, 1, 3, '20', 'Smog Pumps & Pulleys', '', 'Active'),
(59, 1, 3, '21', 'Vacuum Distributor Parts', '', 'Active'),
(60, 1, 3, '22', 'Vacuum Pump Lines & Fittings', '', 'Active'),
(61, 1, 3, '23', 'Vacuum Valves & Brackets', '', 'Active'),
(62, 1, 3, '24', 'Vacuum Valves & Levers', '', 'Active'),
(63, 1, 4, '01', 'Catalytic Converter Brackets', '', 'Active'),
(64, 1, 4, '02', 'Catalytic Converters', '', 'Active'),
(65, 1, 4, '03', 'Exhaust Adapters & Connectors', '', 'Active'),
(66, 1, 4, '04', 'Exhaust Clamps', '', 'Active'),
(67, 1, 4, '05', 'Exhaust Flange Components', '', 'Active'),
(68, 1, 4, '06', 'Exhaust Hangers & Hardware', '', 'Active'),
(69, 1, 4, '07', 'Exhaust Hardware', '', 'Active'),
(70, 1, 4, '08', 'Exhaust Header Hardware', '', 'Active'),
(71, 1, 4, '09', 'Exhaust Headers', '', 'Active'),
(72, 1, 4, '10', 'Exhaust Headers - Performance', '', 'Active'),
(73, 1, 4, '11', 'Exhaust Heat Shields', '', 'Active'),
(74, 1, 4, '12', 'Exhaust Pipes & Related', '', 'Active'),
(75, 1, 4, '13', 'Exhaust Resonators', '', 'Active'),
(76, 1, 4, '14', 'Exhaust Seals', '', 'Active'),
(77, 1, 4, '15', 'Exhaust System Gaskets', '', 'Active'),
(78, 1, 4, '16', 'Exhaust System Kits', '', 'Active'),
(79, 1, 4, '17', 'Exhaust System Kits - Performa', '', 'Active'),
(80, 1, 4, '18', 'Exhaust Tail Pipes', '', 'Active'),
(81, 1, 4, '19', 'Exhaust Tail Spouts', '', 'Active'),
(82, 1, 4, '20', 'Exhaust Tips', '', 'Active'),
(83, 1, 4, '21', 'Exhaust Tubing', '', 'Active'),
(84, 1, 4, '22', 'Header Components', '', 'Active'),
(85, 1, 4, '23', 'Muffler Installation & Repair', '', 'Active'),
(86, 1, 4, '24', 'Muffler Tips', '', 'Active'),
(87, 1, 4, '25', 'Mufflers', '', 'Active'),
(88, 1, 4, '26', 'Mufflers - Performance', '', 'Active'),
(89, 1, 5, '01', 'Fuel Filter Components', '', 'Active'),
(90, 1, 5, '02', 'Fuel Filter Hoses', '', 'Active'),
(91, 1, 5, '03', 'Fuel Filters', '', 'Active'),
(92, 1, 5, '04', 'Oil Filter Components', '', 'Active'),
(93, 1, 5, '05', 'Oil Filters', '', 'Active'),
(94, 1, 5, '06', 'PCV Valves & Related', '', 'Active'),
(95, 1, 6, '01', 'Engine Air Intake Parts', '', 'Active'),
(96, 1, 6, '02', 'Engine RPM Components', '', 'Active'),
(97, 1, 6, '03', 'Fuel Injection Air Flow Meters', '', 'Active'),
(98, 1, 6, '04', 'Fuel Injection Electronics', '', 'Active'),
(99, 1, 6, '05', 'Fuel Injection Gaskets', '', 'Active'),
(100, 1, 6, '06', 'Fuel Injection Hardware', '', 'Active'),
(101, 1, 6, '07', 'Fuel Injection Idle Air Parts', '', 'Active'),
(102, 1, 6, '08', 'Fuel Injection Intake Parts', '', 'Active'),
(103, 1, 6, '09', 'Fuel Injection Kits', '', 'Active'),
(104, 1, 6, '10', 'Fuel Injection Lines', '', 'Active'),
(105, 1, 6, '11', 'Fuel Injection Parts', '', 'Active'),
(106, 1, 6, '12', 'Fuel Injection Rails', '', 'Active'),
(107, 1, 6, '13', 'Fuel Injection Regulators', '', 'Active'),
(108, 1, 6, '14', 'Fuel Injection seals', '', 'Active'),
(109, 1, 6, '15', 'Fuel Injection Solenoids', '', 'Active'),
(110, 1, 6, '16', 'Fuel Injection Valves', '', 'Active'),
(111, 1, 6, '17', 'Fuel Injectors', '', 'Active'),
(112, 1, 6, '18', 'Fuel Lines & Kits', '', 'Active'),
(113, 1, 6, '19', 'Fuel System - Performance', '', 'Active'),
(114, 1, 6, '20', 'Throttle Body Parts', '', 'Active'),
(115, 1, 6, '21', 'Vacuum Parts', '', 'Active'),
(116, 1, 7, '01', 'Fuel Injection Pumps', '', 'Active'),
(117, 1, 7, '02', 'Fuel Injection System componen', '', 'Active'),
(118, 1, 7, '03', 'Fuel Pump Assemblies', '', 'Active'),
(119, 1, 7, '04', 'Fuel Pump Components', '', 'Active'),
(120, 1, 7, '05', 'Fuel Pump Electronics', '', 'Active'),
(121, 1, 7, '06', 'Fuel Pump Hardware', '', 'Active'),
(122, 1, 7, '07', 'Fuel Pump Harnesses', '', 'Active'),
(123, 1, 7, '08', 'Fuel Pump Hoses', '', 'Active'),
(124, 1, 7, '09', 'Fuel Pump Lines', '', 'Active'),
(125, 1, 7, '10', 'Fuel Pump Parts', '', 'Active'),
(126, 1, 7, '11', 'Fuel Pump Pushrods', '', 'Active'),
(127, 1, 7, '12', 'Fuel Pump Seals', '', 'Active'),
(128, 1, 7, '13', 'Fuel Pumps', '', 'Active'),
(129, 1, 7, '14', 'Fuel Pumps - Performance', '', 'Active'),
(130, 1, 7, '15', 'Fuel Sensors', '', 'Active'),
(131, 1, 7, '16', 'Fuel Tank Hardware', '', 'Active'),
(132, 1, 7, '17', 'Fuel Tank Pickup Lines', '', 'Active'),
(133, 1, 7, '18', 'Fuel Tank Sending Units', '', 'Active'),
(134, 1, 7, '19', 'Fuel Tank Straps', '', 'Active'),
(135, 1, 7, '20', 'Fuel Tank Valves', '', 'Active'),
(136, 1, 7, '21', 'Fuel Tanks', '', 'Active'),
(137, 1, 7, '22', 'Fuel Tanks & Sending Units', '', 'Active'),
(138, 1, 7, '23', 'Fuel Tanks Filler Necks', '', 'Active'),
(139, 1, 7, '24', 'Fuel Tanks Hardware', '', 'Active'),
(140, 1, 7, '25', 'Gas Caps', '', 'Active'),
(141, 1, 8, '01', 'Carbon Dioxide Components', '', 'Active'),
(142, 1, 8, '02', 'Carbon dioxide Fuel Bars', '', 'Active'),
(143, 1, 8, '03', 'Cabon Dioxide Purge Systems', '', 'Active'),
(144, 1, 8, '04', 'Carbon Dioxide Sprayers', '', 'Active'),
(145, 1, 8, '05', 'Carbon Dioxide System Hoses', '', 'Active'),
(146, 1, 8, '06', 'carbon Dioxide System Switches', '', 'Active'),
(147, 1, 8, '07', 'Carbon dioxide Tanks', '', 'Active'),
(148, 1, 8, '08', 'Nitrous Bottles & Related', '', 'Active'),
(149, 1, 8, '09', 'Nitrous Oxide Accessories', '', 'Active'),
(150, 1, 8, '10', 'Nitrous Oxide Controllers', '', 'Active'),
(151, 1, 8, '11', 'Nitrous Oxide Distribution', '', 'Active'),
(152, 1, 8, '12', 'Nitrous Oxide Filters', '', 'Active'),
(153, 1, 8, '13', 'Nitrous Oxide Fittings', '', 'Active'),
(154, 1, 8, '14', 'Nitrous Oxide Gauges & Valves', '', 'Active'),
(155, 1, 8, '15', 'Nitrous Oxide Hardware', '', 'Active'),
(156, 1, 8, '16', 'Nitrous Oxide Hoses', '', 'Active'),
(157, 1, 8, '17', 'Nitrous Oxide Injection System', '', 'Active'),
(158, 1, 8, '18', 'Nitrous Oxide Jets', '', 'Active'),
(159, 1, 8, '19', 'Nitrous Oxide Purge Kits', '', 'Active'),
(160, 1, 8, '20', 'Nitrous Oxide Solenoids', '', 'Active'),
(161, 1, 8, '21', 'Nitrous Oxide Tools', '', 'Active'),
(162, 1, 9, '01', 'Oxygen Sensor Components', '', 'Active'),
(163, 1, 9, '02', 'Oxygen Sensors', '', 'Active'),
(164, 1, 10, '01', 'Intercoolers', '', 'Active'),
(165, 1, 10, '02', 'Small Block Superchargers', '', 'Active'),
(166, 1, 10, '03', 'Supercharger Belts & Pulleys', '', 'Active'),
(167, 1, 10, '04', 'Supercharger Gaskets & Seals', '', 'Active'),
(168, 1, 10, '05', 'Supercharger Parts', '', 'Active'),
(169, 1, 10, '06', 'Superchargers', '', 'Active'),
(170, 1, 10, '07', 'Turbocharger Gaskets & Seals', '', 'Active'),
(171, 1, 10, '08', 'Turbocharger Hardware', '', 'Active'),
(172, 1, 10, '09', 'Turbocharger Hoses', '', 'Active'),
(173, 1, 10, '10', 'Turbocharger Parts', '', 'Active'),
(174, 1, 10, '11', 'Turbochargers', '', 'Active'),
(175, 2, 1, '01', 'Air Fresheners & Fragrances', '', 'Active'),
(176, 2, 1, '02', 'Brushes & Vacuums', '', 'Active'),
(177, 2, 1, '03', 'Buckets, Hoses & Nozzles', '', 'Active'),
(178, 2, 1, '04', 'Bug & Tar Removers', '', 'Active'),
(179, 2, 1, '05', 'Carpet & Upholstery Cleaners', '', 'Active'),
(180, 2, 1, '06', 'Cleaners & Polishes', '', 'Active'),
(181, 2, 1, '07', 'Headlight Restoration Kits', '', 'Active'),
(182, 2, 1, '08', 'Leather Cleaners', '', 'Active'),
(183, 2, 1, '09', 'Protectants', '', 'Active'),
(184, 2, 1, '10', 'Shop Towels', '', 'Active'),
(185, 2, 1, '11', 'Sponges, Wash Towels & Chamois', '', 'Active'),
(186, 2, 1, '12', 'Tire Cleaners & Polishes', '', 'Active'),
(187, 2, 1, '13', 'Vehicle Care kits', '', 'Active'),
(188, 2, 1, '14', 'Wash & Shampoos', '', 'Active'),
(189, 2, 1, '15', 'Waxes', '', 'Active'),
(190, 2, 1, '16', 'Window Cleaning Tools', '', 'Active'),
(191, 2, 2, '01', 'Air Bag Components', '', 'Active'),
(192, 2, 2, '02', 'Antennas & Accessories', '', 'Active'),
(193, 2, 2, '03', 'Arm Rest', '', 'Active'),
(194, 2, 2, '04', 'Body Panels & Molding', '', 'Active'),
(195, 2, 2, '05', 'Bulk Items', '', 'Active'),
(196, 2, 2, '06', 'Bumper Components', '', 'Active'),
(197, 2, 2, '07', 'Bumpers', '', 'Active'),
(198, 2, 2, '08', 'Dashboard & Console', '', 'Active'),
(199, 2, 2, '09', 'Door Parts', '', 'Active'),
(200, 2, 2, '10', 'Fender Parts & Accessories', '', 'Active'),
(201, 2, 2, '11', 'Fenders', '', 'Active'),
(202, 2, 2, '12', 'Fuel doors & Related', '', 'Active'),
(203, 2, 2, '13', 'Glass & Window repair', '', 'Active'),
(204, 2, 2, '14', 'Headlamps, Headlights & Parts', '', 'Active'),
(205, 2, 2, '15', 'Hood & Front End', '', 'Active'),
(206, 2, 2, '16', 'Horn Parts', '', 'Active'),
(207, 2, 2, '17', 'Lifts, Latches & Handles', '', 'Active'),
(208, 2, 2, '18', 'Mirrors & Lights', '', 'Active'),
(209, 2, 2, '19', 'Pedals', '', 'Active'),
(210, 2, 2, '20', 'Props, Latches & Mounts', '', 'Active'),
(211, 2, 2, '21', 'Roof tops, Parts & Racks', '', 'Active'),
(212, 2, 2, '22', 'Running Boards & steps', '', 'Active'),
(213, 2, 2, '23', 'Seats', '', 'Active'),
(214, 2, 2, '24', 'Trailer & Towing', '', 'Active'),
(215, 2, 2, '25', 'Trailer Hitch & accessories', '', 'Active'),
(216, 2, 2, '26', 'Trailer Winches', '', 'Active'),
(217, 2, 2, '27', 'Trunk & Tailgate', '', 'Active'),
(218, 2, 2, '28', 'Undercar Protection', '', 'Active'),
(219, 2, 2, '29', 'Windshields, Doors & Windows', '', 'Active'),
(220, 2, 3, '01', 'Body Styling - Performance', '', 'Active'),
(221, 2, 3, '02', 'Body Styling Kits - Performanc', '', 'Active'),
(222, 2, 3, '03', 'Chrome & Dress-Up', '', 'Active'),
(223, 2, 3, '04', 'Chrome & Dress-Up covers', '', 'Active'),
(224, 2, 3, '05', 'Chrome Accessories', '', 'Active'),
(225, 2, 3, '06', 'Chrome Bolts & Brackets', '', 'Active'),
(226, 2, 3, '07', 'Chrome shift Handles', '', 'Active'),
(227, 2, 3, '08', 'Decals & Emblems', '', 'Active'),
(228, 2, 3, '09', 'License Plate Frames', '', 'Active'),
(229, 2, 3, '10', 'Steering Wheel Covers', '', 'Active'),
(230, 2, 3, '11', 'Steering Wheels & Accessories', '', 'Active'),
(231, 2, 3, '12', 'Steering Wheels & Related', '', 'Active'),
(232, 2, 3, '13', 'Wheel Covers', '', 'Active'),
(233, 2, 4, '01', 'ATV Covers', '', 'Active'),
(234, 2, 4, '02', 'Bench Seat Covers', '', 'Active'),
(235, 2, 4, '03', 'Bucket Seat Covers', '', 'Active'),
(236, 2, 4, '04', 'Bug Guards & Shields', '', 'Active'),
(237, 2, 4, '05', 'Bumper Covers', '', 'Active'),
(238, 2, 4, '06', 'Canopy Shelters & Accessories', '', 'Active'),
(239, 2, 4, '07', 'Car Covers & Accessories', '', 'Active'),
(240, 2, 4, '08', 'Dashboard & Console', '', 'Active'),
(241, 2, 4, '09', 'Floor Coverings & Protectors', '', 'Active'),
(242, 2, 4, '10', 'Floormats', '', 'Active'),
(243, 2, 4, '11', 'Front End Covers & Bras', '', 'Active'),
(244, 2, 4, '12', 'Guards, Flaps & Film', '', 'Active'),
(245, 2, 4, '13', 'Motorcycle Covers', '', 'Active'),
(246, 2, 4, '14', 'Pet Pads & Protectors', '', 'Active'),
(247, 2, 4, '15', 'Seat Covers', '', 'Active'),
(248, 2, 4, '16', 'Sun Shades & Shields', '', 'Active'),
(249, 2, 4, '17', 'Sun Visors & Clips', '', 'Active'),
(250, 2, 4, '18', 'Tire & wheel Covers', '', 'Active'),
(251, 2, 4, '19', 'Undercar Protection', '', 'Active'),
(252, 2, 4, '20', 'Visors', '', 'Active'),
(253, 2, 4, '21', 'Window Covers', '', 'Active'),
(254, 2, 4, '22', 'Window Tint', '', 'Active'),
(255, 2, 5, '01', 'Coating & Under-Coating', '', 'Active'),
(256, 2, 5, '02', 'filler Mixing Pallettes', '', 'Active'),
(257, 2, 5, '03', 'Masking Film, Tape & Supplies', '', 'Active'),
(258, 2, 5, '04', 'Paint Removers & Strippers', '', 'Active'),
(259, 2, 5, '05', 'Paints & Enamels', '', 'Active'),
(260, 2, 5, '06', 'Polishers, Buffers & Pads', '', 'Active'),
(261, 2, 5, '07', 'Repair Parts & Accessories', '', 'Active'),
(262, 2, 5, '08', 'Repair Vinyl & Leather', '', 'Active'),
(263, 2, 5, '09', 'Respirators & Accessories', '', 'Active'),
(264, 2, 5, '10', 'Scratch Removers', '', 'Active'),
(265, 2, 5, '11', 'Touch-Up Liquids', '', 'Active'),
(266, 2, 5, '12', 'Touch-Up sprays', '', 'Active'),
(267, 2, 5, '13', 'Truck & Van Paints', '', 'Active'),
(268, 2, 5, '14', 'Wax & Grease removers', '', 'Active'),
(269, 2, 6, '01', 'Alarm Relays & Switches', '', 'Active'),
(270, 2, 6, '02', 'Alcohol Detectors', '', 'Active'),
(271, 2, 6, '03', 'Back-Up Systems', '', 'Active'),
(272, 2, 6, '04', 'Car Alarms & Accessories', '', 'Active'),
(273, 2, 6, '05', 'Deer Warning Whistles', '', 'Active'),
(274, 2, 6, '06', 'Emergency Roadside Kits', '', 'Active'),
(275, 2, 6, '07', 'Fire Extinguishers', '', 'Active'),
(276, 2, 6, '08', 'First Aid Kits', '', 'Active'),
(277, 2, 6, '09', 'Flares & Reflectors', '', 'Active'),
(278, 2, 6, '10', 'Key Covers & Storage', '', 'Active'),
(279, 2, 6, '11', 'Keyless Entry Systems', '', 'Active'),
(280, 2, 6, '12', 'Keys & Accessories', '', 'Active'),
(281, 2, 6, '13', 'Locks', '', 'Active'),
(282, 2, 6, '14', 'Remote Starters & Kits', '', 'Active'),
(283, 2, 6, '15', 'Safety Equipment', '', 'Active'),
(284, 2, 7, '01', '12-Volt Interior Heaters', '', 'Active'),
(285, 2, 7, '02', 'Cable chains', '', 'Active'),
(286, 2, 7, '03', 'De-Icers & Scrapers', '', 'Active'),
(287, 2, 7, '04', 'Engine & Battery Heaters', '', 'Active'),
(288, 2, 7, '05', 'Heat & sound Insulation', '', 'Active'),
(289, 2, 7, '06', 'Snow Plows & Accessories', '', 'Active'),
(290, 2, 7, '07', 'Snow Shovels', '', 'Active'),
(291, 2, 7, '08', 'Tire Chains', '', 'Active'),
(292, 2, 8, '01', 'Cab & Glove Box Organizers', '', 'Active'),
(293, 2, 8, '02', 'Cargo Carriers', '', 'Active'),
(294, 2, 8, '03', 'Cargo Dividers', '', 'Active'),
(295, 2, 8, '04', 'Cargo Nets', '', 'Active'),
(296, 2, 8, '05', 'Cargo Systems', '', 'Active'),
(297, 2, 8, '06', 'Carrier Accessories', '', 'Active'),
(298, 2, 8, '07', 'CD & DVD Holders', '', 'Active'),
(299, 2, 8, '08', 'Consoles & Parts', '', 'Active'),
(300, 2, 8, '09', 'Convertible Interior Covers', '', 'Active'),
(301, 2, 8, '10', 'Coolers', '', 'Active'),
(302, 2, 8, '11', 'Cup Holders', '', 'Active'),
(303, 2, 8, '12', 'Liquid transfer Thanks', '', 'Active'),
(304, 2, 8, '13', 'Miscellaneous Storage', '', 'Active'),
(305, 2, 8, '14', 'Roof Racks & Parts', '', 'Active'),
(306, 2, 8, '15', 'Saddle Bags', '', 'Active'),
(307, 2, 8, '16', 'Trunk & Tailgate', '', 'Active'),
(308, 2, 8, '17', 'Universal Pet Barriers', '', 'Active'),
(309, 2, 9, '01', 'Glass & Window Repair', '', 'Active'),
(310, 2, 9, '02', 'Lifts, Latches & Handles', '', 'Active'),
(311, 2, 9, '03', 'Specialty Wiper Blades', '', 'Active'),
(312, 2, 9, '04', 'Sunroof Parts', '', 'Active'),
(313, 2, 9, '05', 'Washer Fluid Reservoirs', '', 'Active'),
(314, 2, 9, '06', 'Washer Pumps & Repair Kits', '', 'Active'),
(315, 2, 9, '07', 'Window Motors & Parts', '', 'Active'),
(316, 2, 9, '08', 'Windshield Wiper Blades', '', 'Active'),
(317, 2, 9, '09', 'Windshield Wiper Motor Covers', '', 'Active'),
(318, 2, 9, '10', 'Windshield Wiper Motors', '', 'Active'),
(319, 2, 9, '11', 'Windshield Wiper Refills', '', 'Active'),
(320, 2, 9, '12', 'Wipers & Washer Parts', '', 'Active'),
(321, 3, 1, '01', 'Air Bag Components', '', 'Active'),
(322, 3, 1, '02', 'Air Bag Modules', '', 'Active'),
(323, 3, 2, '01', 'Accessory Drive Belts', '', 'Active'),
(324, 3, 2, '02', 'Alternator Bolts & Sets', '', 'Active'),
(325, 3, 2, '03', 'Alternator Brackets', '', 'Active'),
(326, 3, 2, '04', 'Alternator Brush Sets', '', 'Active'),
(327, 3, 2, '05', 'Alternator Commutator End Bear', '', 'Active'),
(328, 3, 2, '06', 'Alternator Components', '', 'Active'),
(329, 3, 2, '07', 'Alternator Connectors', '', 'Active'),
(330, 3, 2, '08', 'Alternator Drive End Bearings', '', 'Active'),
(331, 3, 2, '09', 'Alternator Hardware', '', 'Active'),
(332, 3, 2, '10', 'Alternator Pulleys', '', 'Active'),
(333, 3, 2, '11', 'Alternator Rectifier Sets', '', 'Active'),
(334, 3, 2, '12', 'Alternator Repair Kits', '', 'Active'),
(335, 3, 2, '13', 'Alternator Rotors', '', 'Active'),
(336, 3, 2, '14', 'Alternators', '', 'Active'),
(337, 3, 2, '15', 'Belt Tensioners', '', 'Active'),
(338, 3, 2, '16', 'Belts, Brackets & Bushings', '', 'Active'),
(339, 3, 2, '17', 'Brush Parts', '', 'Active'),
(340, 3, 2, '18', 'Drive Belt Idler & Related', '', 'Active'),
(341, 3, 2, '19', 'Generators', '', 'Active'),
(342, 3, 2, '20', 'Sepertine Belts', '', 'Active'),
(343, 3, 3, '01', 'Automotive Batteries', '', 'Active'),
(344, 3, 3, '02', 'Electronic Batteries', '', 'Active'),
(345, 3, 3, '03', 'Farm & Truck Batteries', '', 'Active'),
(346, 3, 3, '04', 'Golf Cart Batteries', '', 'Active'),
(347, 3, 3, '05', 'Lawn & Garden Batteries', '', 'Active'),
(348, 3, 3, '06', 'Marine Batteries', '', 'Active'),
(349, 3, 3, '07', 'Motorcycle & ATV Batteries', '', 'Active'),
(350, 3, 3, '08', 'Powersport Batteries', '', 'Active'),
(351, 3, 4, '01', 'Battery Accessories', '', 'Active'),
(352, 3, 4, '02', 'Battery Cables', '', 'Active'),
(353, 3, 4, '03', 'Battery Chargers', '', 'Active'),
(354, 3, 4, '04', 'Battery Parts & Tools', '', 'Active'),
(355, 3, 4, '05', 'Battery Straps & Hold-Downs', '', 'Active'),
(356, 3, 4, '06', 'Battery Switches & relays', '', 'Active'),
(357, 3, 4, '07', 'Battery Terminal Components', '', 'Active'),
(358, 3, 4, '08', 'Battery Tools', '', 'Active'),
(359, 3, 4, '09', 'Battery Trays', '', 'Active'),
(360, 3, 5, '01', 'Charging System Harness Parts', '', 'Active'),
(361, 3, 5, '02', 'Drive End Bearings', '', 'Active'),
(362, 3, 5, '03', 'Voltage Regulators', '', 'Active'),
(363, 3, 6, '01', 'Buttons & Knobs', '', 'Active'),
(364, 3, 6, '02', 'Electrical Harness Wire', '', 'Active'),
(365, 3, 6, '03', 'Electrical Tape, Ties & Clamps', '', 'Active'),
(366, 3, 6, '04', 'Extension Cords', '', 'Active'),
(367, 3, 6, '05', 'Heat Shrink Sleeving & Tubing', '', 'Active'),
(368, 3, 6, '06', 'Miscellaneous Wire', '', 'Active'),
(369, 3, 6, '07', 'Pigtails & Sockets', '', 'Active'),
(370, 3, 6, '08', 'Power Cord Reels', '', 'Active'),
(371, 3, 6, '09', 'Primary Wire', '', 'Active'),
(372, 3, 6, '10', 'Soldering Iron & Solder', '', 'Active'),
(373, 3, 6, '11', 'Tolls & Tester', '', 'Active'),
(374, 3, 6, '12', 'Wire Conduit', '', 'Active'),
(375, 3, 6, '13', 'Wire Connectors', '', 'Active'),
(376, 3, 6, '14', 'Wiring Kits', '', 'Active'),
(377, 3, 7, '01', 'Auxilliary Lights', '', 'Active'),
(378, 3, 7, '02', 'Back-Up Lamps & Lights', '', 'Active'),
(379, 3, 7, '03', 'Cornering Lamps & Lights', '', 'Active'),
(380, 3, 7, '04', 'Daytime Running Lamps & Lights', '', 'Active'),
(381, 3, 7, '05', 'Dome Lights & Accessories', '', 'Active'),
(382, 3, 7, '06', 'Emergency Lights', '', 'Active'),
(383, 3, 7, '07', 'Exterior Lights & Bulbs', '', 'Active'),
(384, 3, 7, '08', 'Flashers', '', 'Active'),
(385, 3, 7, '09', 'Fog Lamps & Lights', '', 'Active'),
(386, 3, 7, '10', 'Fuse Blocks, Boxes & Holders', '', 'Active'),
(387, 3, 7, '11', 'Fuses', '', 'Active'),
(388, 3, 7, '12', 'Fusible Links', '', 'Active'),
(389, 3, 7, '13', 'Glass Fuses', '', 'Active'),
(390, 3, 7, '14', 'Headlamps & Lights', '', 'Active'),
(391, 3, 7, '15', 'License Plate Lamps', '', 'Active'),
(392, 3, 7, '16', 'Mirror Lights & Accessories', '', 'Active'),
(393, 3, 7, '17', 'Miscellaneous Accessories', '', 'Active'),
(394, 3, 7, '18', 'Miscellaneous Lamps & Bulbs', '', 'Active'),
(395, 3, 7, '19', 'Parking Lamps & Lights', '', 'Active'),
(396, 3, 7, '20', 'Side Marker Lamps & Lights', '', 'Active'),
(397, 3, 7, '21', 'Spade Fuses', '', 'Active'),
(398, 3, 7, '22', 'Spot & Trouble Lights', '', 'Active'),
(399, 3, 7, '23', 'Tail Lamps & Lights', '', 'Active'),
(400, 3, 7, '24', 'Turn Signal Lights & Bulbs', '', 'Active'),
(401, 3, 8, '01', 'Relays', '', 'Active'),
(402, 3, 8, '02', 'Sensors', '', 'Active'),
(403, 3, 8, '03', 'Switches', '', 'Active'),
(404, 3, 8, '04', 'Off-Road Lamp Relay', '', 'Active'),
(405, 3, 9, '01', 'Starter Brushes', '', 'Active'),
(406, 3, 9, '02', 'Starter Bushings', '', 'Active'),
(407, 3, 9, '03', 'Starter Parts', '', 'Active'),
(408, 3, 9, '04', 'Starter Solenoids & Kits', '', 'Active'),
(409, 3, 9, '05', 'Starters', '', 'Active'),
(410, 4, 1, '01', 'ABS Accumulators & Repair Kits', '', 'Active'),
(411, 4, 1, '02', 'ABS Cables & Brackets', '', 'Active'),
(412, 4, 1, '03', 'ABS Control Modules', '', 'Active'),
(413, 4, 1, '04', 'ABS Harnesses & Connectors', '', 'Active'),
(414, 4, 1, '05', 'ABS Hydraulic Units', '', 'Active'),
(415, 4, 1, '06', 'ABS Pump & Motor Assemblies', '', 'Active'),
(416, 4, 1, '07', 'ABS Rings', '', 'Active'),
(417, 4, 1, '08', 'ABS Speed Sensors', '', 'Active'),
(418, 4, 1, '09', 'ABS Switches, Sensors & Relays', '', 'Active'),
(419, 4, 1, '10', 'ABS Valves & Valve Kits', '', 'Active'),
(420, 4, 2, '01', 'Brake Caliper components', '', 'Active'),
(421, 4, 2, '02', 'Brake Calipers', '', 'Active'),
(422, 4, 3, '01', 'Brake Drum Hardware', '', 'Active'),
(423, 4, 3, '02', 'Brake Drums', '', 'Active'),
(424, 4, 3, '03', 'brake Rotors', '', 'Active'),
(425, 4, 4, '01', 'Brake Adapters & Fittings', '', 'Active'),
(426, 4, 4, '02', 'Brake Adjustment Hardware', '', 'Active'),
(427, 4, 4, '03', 'Brake Bleeders', '', 'Active'),
(428, 4, 4, '04', 'Brake Boosters', '', 'Active'),
(429, 4, 4, '05', 'Brake Cables', '', 'Active'),
(430, 4, 4, '06', 'Brake Clutches', '', 'Active'),
(431, 4, 4, '07', 'Brake Hardware', '', 'Active'),
(432, 4, 4, '08', 'Brake Hoses & Lines', '', 'Active'),
(433, 4, 4, '09', 'Brake Lubricant', '', 'Active'),
(434, 4, 4, '10', 'Brake Master Cylinder Parts', '', 'Active'),
(435, 4, 4, '11', 'Brake Servos & Sensors', '', 'Active'),
(436, 4, 4, '12', 'Brake Shoe Hardware', '', 'Active'),
(437, 4, 4, '13', 'Brake Tools', '', 'Active'),
(438, 4, 4, '14', 'Brake Valves', '', 'Active'),
(439, 4, 4, '15', 'Brake Wheel Cylinders & Kits', '', 'Active'),
(440, 4, 4, '16', 'Parking Brake Parts', '', 'Active'),
(441, 4, 5, '01', 'Brake Pad Components', '', 'Active'),
(442, 4, 5, '02', 'Brake Pads & Shoes', '', 'Active'),
(443, 4, 6, '01', 'Power Steering Control Valves', '', 'Active'),
(444, 4, 6, '02', 'Power Steering Coolers', '', 'Active'),
(445, 4, 6, '03', 'Power Steering Cylinders & Kit', '', 'Active'),
(446, 4, 6, '04', 'Power Steering Filters', '', 'Active'),
(447, 4, 6, '05', 'Power Steering Hose Hardware', '', 'Active'),
(448, 4, 6, '06', 'Power Steering Hoses', '', 'Active'),
(449, 4, 6, '07', 'Power Steering Pulley Bearings', '', 'Active'),
(450, 4, 6, '08', 'Power Steering Pulleys', '', 'Active'),
(451, 4, 6, '09', 'Power Steering Pump Hardware', '', 'Active'),
(452, 4, 6, '10', 'Power Steering Pumps', '', 'Active'),
(453, 4, 6, '11', 'Power Steering Reservoirs', '', 'Active'),
(454, 4, 6, '12', 'Power Steering Seals', '', 'Active'),
(455, 4, 6, '13', 'Power Steering Switches', '', 'Active'),
(456, 4, 7, '01', 'Coil Spring Hardware', '', 'Active'),
(457, 4, 7, '02', 'Coil Springs', '', 'Active'),
(458, 4, 7, '03', 'Leaf Spring Hardware', '', 'Active'),
(459, 4, 7, '04', 'Leaf Springs', '', 'Active'),
(460, 4, 7, '05', 'Shock & Strut Fittings', '', 'Active'),
(461, 4, 7, '06', 'Shock & Strut Installation Gui', '', 'Active'),
(462, 4, 7, '07', 'Shock Absorber Boots', '', 'Active'),
(463, 4, 7, '08', 'Shock Absorber Bumpers', '', 'Active'),
(464, 4, 7, '09', 'Shock Absorber Bushings', '', 'Active'),
(465, 4, 7, '10', 'Shock Absorber Conversion Kit', '', 'Active'),
(466, 4, 7, '11', 'Shock Absorber Hardware', '', 'Active'),
(467, 4, 7, '12', 'Shock Absorber Mounts', '', 'Active'),
(468, 4, 7, '13', 'Shock Absorbers', '', 'Active'),
(469, 4, 7, '14', 'Shocks & Struts Hardware', '', 'Active'),
(470, 4, 7, '15', 'Strut Bearings', '', 'Active'),
(471, 4, 7, '16', 'Strut Bellows', '', 'Active'),
(472, 4, 7, '17', 'Strut Bumpers', '', 'Active'),
(473, 4, 7, '18', 'Strut Hardware', '', 'Active'),
(474, 4, 7, '19', 'Strut Mounts', '', 'Active'),
(475, 4, 7, '20', 'Strut Support', '', 'Active'),
(476, 4, 8, '01', 'Bearings & Bushings', '', 'Active'),
(477, 4, 8, '02', 'Housing & Box Components', '', 'Active'),
(478, 4, 8, '03', 'Idler Arms & Related', '', 'Active'),
(479, 4, 8, '04', 'Pitman Arms & Related', '', 'Active'),
(480, 4, 8, '05', 'Rack & Pinion Bushings', '', 'Active'),
(481, 4, 8, '06', 'Rack & Pinion Components', '', 'Active'),
(482, 4, 8, '07', 'Rack & Pinion Mounts', '', 'Active'),
(483, 4, 8, '08', 'Rack & Pinion Parts', '', 'Active'),
(484, 4, 8, '09', 'Rack & Pinion Rebuild Kits', '', 'Active'),
(485, 4, 8, '10', 'Rack & Pinion Seals', '', 'Active'),
(486, 4, 8, '11', 'Rack & Pinions', '', 'Active'),
(487, 4, 8, '12', 'Radium Arms & Related', '', 'Active'),
(488, 4, 8, '13', 'Steering Bell Cranks', '', 'Active'),
(489, 4, 8, '14', 'Steering Column Components', '', 'Active'),
(490, 4, 8, '15', 'Steering Column Parts', '', 'Active'),
(491, 4, 8, '16', 'Steering Components', '', 'Active'),
(492, 4, 8, '17', 'Steering Gear Kits', '', 'Active'),
(493, 4, 8, '18', 'Steering Gear Shaft Seals', '', 'Active'),
(494, 4, 8, '19', 'Steering Hardware', '', 'Active'),
(495, 4, 8, '20', 'Steering Knuckle Parts', '', 'Active'),
(496, 4, 8, '21', 'Steering Parts', '', 'Active'),
(497, 4, 8, '22', 'Tie Rod Ends & Related', '', 'Active'),
(498, 4, 9, '01', 'Alignment Accessories', '', 'Active'),
(499, 4, 9, '02', 'Alignment Hardware', '', 'Active'),
(500, 4, 9, '03', 'Alignment Kits', '', 'Active'),
(501, 4, 9, '04', 'Alignment Tools', '', 'Active'),
(502, 4, 9, '05', 'Axle Support Hardware', '', 'Active'),
(503, 4, 9, '06', 'Ball Joints & Control arms', '', 'Active'),
(504, 4, 9, '07', 'Chassis', '', 'Active'),
(505, 4, 9, '08', 'Chassis Kits', '', 'Active'),
(506, 4, 9, '09', 'Control Arm Components', '', 'Active'),
(507, 4, 9, '10', 'Lateral Arms & Parts', '', 'Active'),
(508, 4, 9, '11', 'Lifts & Lowering Kits', '', 'Active'),
(509, 4, 9, '12', 'Spindle Parts', '', 'Active'),
(510, 4, 9, '13', 'Strut Parts', '', 'Active'),
(511, 4, 9, '14', 'Suspension Air Components', '', 'Active'),
(512, 4, 9, '15', 'Suspension Ball Joints', '', 'Active'),
(513, 4, 9, '16', 'suspension Components', '', 'Active'),
(514, 4, 9, '17', 'Suspension Control Arm Parts', '', 'Active'),
(515, 4, 9, '18', 'Suspension Control Arms', '', 'Active'),
(516, 4, 9, '19', 'Suspension Hardware', '', 'Active'),
(517, 4, 9, '20', 'Suspension Mounts', '', 'Active'),
(518, 4, 9, '21', 'Suspension Parts', '', 'Active'),
(519, 4, 9, '22', 'Suspension Spring Components', '', 'Active'),
(520, 4, 9, '23', 'Sway Bar Bushings & Brackets', '', 'Active'),
(521, 4, 9, '24', 'Sway Bar Parts & Kits', '', 'Active'),
(522, 4, 9, '25', 'Torsion Bars & Parts', '', 'Active'),
(523, 4, 9, '26', 'Track Bars & Parts', '', 'Active'),
(524, 4, 9, '27', 'Upper Control Arms & Parts', '', 'Active'),
(525, 4, 10, '01', 'Tire Repair', '', 'Active'),
(526, 4, 10, '02', 'Wheel covers', '', 'Active'),
(527, 4, 10, '03', 'Wheel Lug Nuts', '', 'Active'),
(528, 4, 10, '04', 'Wheel Nut Caps', '', 'Active'),
(529, 4, 10, '05', 'Wheel Nut Covers', '', 'Active'),
(530, 4, 10, '06', 'Wheel Nuts', '', 'Active'),
(531, 4, 10, '07', 'Wheel Spacers', '', 'Active'),
(532, 4, 10, '08', 'Wheel Washers', '', 'Active'),
(533, 4, 10, '09', 'Wheel Weights', '', 'Active'),
(534, 4, 10, '10', 'Wheels & Parts', '', 'Active'),
(535, 5, 1, '01', 'AC Ventillation Systems', '', 'Active'),
(536, 5, 1, '02', 'Accumulator Tubing', '', 'Active'),
(537, 5, 1, '03', 'Accumulators & Receiver Driers', '', 'Active'),
(538, 5, 1, '04', 'Receiver Drier Elements', '', 'Active'),
(539, 5, 2, '01', 'AC Clutch Bearings', '', 'Active'),
(540, 5, 2, '02', 'AC Clutch Install Kits', '', 'Active'),
(541, 5, 2, '03', 'AC Clutch Parts', '', 'Active'),
(542, 5, 2, '04', 'AC Clutches', '', 'Active'),
(543, 5, 2, '05', 'AC Compressor Bearing', '', 'Active'),
(544, 5, 2, '06', 'AC Compressor Mounts', '', 'Active'),
(545, 5, 2, '07', 'AC Compressor Pulleys', '', 'Active'),
(546, 5, 2, '08', 'AC Compressor Shaft Parts', '', 'Active'),
(547, 5, 2, '09', 'AC Compressors', '', 'Active'),
(548, 5, 2, '10', 'AC Condenser Fan Shrouds & Bla', '', 'Active'),
(549, 5, 2, '11', 'AC Condensers', '', 'Active'),
(550, 5, 2, '12', 'AC Evaporator Repair Kits', '', 'Active'),
(551, 5, 2, '13', 'AC Evaporator Motors & Related', '', 'Active'),
(552, 5, 2, '14', 'AC Evaporators', '', 'Active'),
(553, 5, 2, '15', 'AC Fan Motors', '', 'Active'),
(554, 5, 2, '16', 'AC Gaskets & Seals', '', 'Active'),
(555, 5, 2, '17', 'AC Hoses & Fittings', '', 'Active'),
(556, 5, 2, '18', 'AC Switches & Resistors', '', 'Active'),
(557, 5, 2, '19', 'AC Valves & Tubing', '', 'Active'),
(558, 5, 2, '20', 'Other Specialty Tools', '', 'Active'),
(559, 5, 3, '01', 'AC Actuators', '', 'Active'),
(560, 5, 3, '02', 'AC Adapters', '', 'Active'),
(561, 5, 3, '03', 'AC Clutch Install Kits', '', 'Active'),
(562, 5, 3, '04', 'AC Connectors', '', 'Active'),
(563, 5, 3, '05', 'AC Drive Belt Tensioners', '', 'Active'),
(564, 5, 3, '06', 'AC Gaskets & Seals', '', 'Active'),
(565, 5, 3, '07', 'AC Hoses & Fittings', '', 'Active'),
(566, 5, 3, '08', 'AC Pipes', '', 'Active'),
(567, 5, 3, '09', 'AC Retro-Fit Kits', '', 'Active'),
(568, 5, 3, '10', 'AC Tools', '', 'Active'),
(569, 5, 3, '11', 'AC Valves & Tubing', '', 'Active'),
(570, 5, 3, '12', 'Fan Switches', '', 'Active'),
(571, 5, 3, '13', 'Gauges & Specialty Tools', '', 'Active'),
(572, 5, 3, '14', 'Leak Detectors', '', 'Active'),
(573, 5, 3, '15', 'Pressure Side Switches', '', 'Active'),
(574, 5, 3, '16', 'Programmers', '', 'Active'),
(575, 5, 3, '17', 'Repair Kits', '', 'Active'),
(576, 5, 3, '18', 'Temperature Sensors', '', 'Active'),
(577, 5, 3, '19', 'Trinary Switches', '', 'Active'),
(578, 5, 4, '01', 'AC Drive Belt Tensioners', '', 'Active'),
(579, 5, 4, '02', 'Accessory Drive Belts', '', 'Active'),
(580, 5, 4, '03', 'Belt Components', '', 'Active'),
(581, 5, 4, '04', 'Belts', '', 'Active'),
(582, 5, 4, '05', 'Bulk Hose', '', 'Active'),
(583, 5, 4, '06', 'Hose Hardware', '', 'Active'),
(584, 5, 4, '07', 'Hoses', '', 'Active'),
(585, 5, 4, '08', 'Pulley Components', '', 'Active'),
(586, 5, 4, '09', 'Pulleys', '', 'Active'),
(587, 5, 5, '01', 'Coolant Air Bleeders', '', 'Active'),
(588, 5, 5, '02', 'Coolant Bypass Parts', '', 'Active'),
(589, 5, 5, '03', 'Coolant Hoses', '', 'Active'),
(590, 5, 5, '04', 'Coolant Pipes & Accessories', '', 'Active'),
(591, 5, 5, '05', 'Coolant Reservoirs & Caps', '', 'Active'),
(592, 5, 5, '06', 'Coolant Sensors', '', 'Active'),
(593, 5, 5, '07', 'Coolant Thermostats', '', 'Active'),
(594, 5, 5, '08', 'Hose Clamps', '', 'Active'),
(595, 5, 5, '09', 'Miscellaneous Coolant Parts', '', 'Active'),
(596, 5, 5, '10', 'Oil Cooler Parts', '', 'Active'),
(597, 5, 5, '11', 'Radiator Fan Switches', '', 'Active'),
(598, 5, 5, '12', 'Transmission Coolers', '', 'Active'),
(599, 5, 5, '13', 'Water Pump Bolts', '', 'Active'),
(600, 5, 5, '14', 'Water Pump Covers', '', 'Active'),
(601, 5, 5, '15', 'Water Pump Fittings', '', 'Active'),
(602, 5, 5, '16', 'Water Pump Gaskets', '', 'Active'),
(603, 5, 5, '17', 'Water Pump Installation', '', 'Active'),
(604, 5, 5, '18', 'Water Pump Pulleys', '', 'Active'),
(605, 5, 5, '19', 'Water Pump Relays', '', 'Active'),
(606, 5, 5, '20', 'Water Pump Repair Kits', '', 'Active'),
(607, 5, 5, '21', 'Water Pump Seals', '', 'Active'),
(608, 5, 5, '22', 'Water Pump Sockets', '', 'Active'),
(609, 5, 5, '23', 'Water Pump Tubing', '', 'Active'),
(610, 5, 5, '24', 'Water Pumps', '', 'Active'),
(611, 5, 5, '25', 'Water Temperature Gauges', '', 'Active'),
(612, 5, 6, '01', 'Blower Motor Components', '', 'Active'),
(613, 5, 6, '02', 'Blower Motor Control Units', '', 'Active'),
(614, 5, 6, '03', 'Blower Motor Resistor Connecto', '', 'Active'),
(615, 5, 6, '04', 'Blower Motor Wheels', '', 'Active'),
(616, 5, 6, '05', 'Blower Motors', '', 'Active'),
(617, 5, 6, '06', 'Cooling Fan Blades', '', 'Active'),
(618, 5, 6, '07', 'Cooling Fan Components', '', 'Active'),
(619, 5, 6, '08', 'Cooling Fan Controllers', '', 'Active'),
(620, 5, 6, '09', 'Cooling Fan Shrouds', '', 'Active'),
(621, 5, 6, '10', 'Cooling Fans', '', 'Active'),
(622, 5, 6, '11', 'Engine Cooling Fans', '', 'Active'),
(623, 5, 6, '12', 'Fan Accessories', '', 'Active'),
(624, 5, 6, '13', 'Fan Clutch Hardware & Brackets', '', 'Active'),
(625, 5, 6, '14', 'Transmission Coolers', '', 'Active'),
(626, 5, 6, '15', 'Water Necks & Shrouds', '', 'Active'),
(627, 5, 7, '01', 'AC Flushes & Solvents ', '', 'Active'),
(628, 5, 7, '02', 'AC Lubricants', '', 'Active'),
(629, 5, 7, '03', 'AC Refrigerants', '', 'Active'),
(630, 5, 7, '04', 'Antifreeze Flush Kits', '', 'Active'),
(631, 5, 7, '05', 'Coolant & Antifreeze', '', 'Active'),
(632, 5, 7, '06', 'Coolant Recovery', '', 'Active'),
(633, 5, 7, '07', 'Odor Eliminators', '', 'Active'),
(634, 5, 7, '08', 'Refrigerant Oil', '', 'Active'),
(635, 5, 8, '01', 'Heater Blend Doors & Parts', '', 'Active'),
(636, 5, 8, '02', 'Heater Boxes & Accessories', '', 'Active'),
(637, 5, 8, '03', 'Heater Control Assemblies', '', 'Active'),
(638, 5, 8, '04', 'Heater Control Knobs', '', 'Active'),
(639, 5, 8, '05', 'Heater Cores & Seals', '', 'Active'),
(640, 5, 8, '06', 'Heater Hoses & Fittings', '', 'Active'),
(641, 5, 8, '07', 'Heater Valves & Related', '', 'Active'),
(642, 5, 8, '08', 'Miscellaneous Heater Parts', '', 'Active'),
(643, 5, 9, '01', 'Coolant Reservoirs & Caps', '', 'Active'),
(644, 5, 9, '02', 'Heater Hoses & Fittings', '', 'Active'),
(645, 5, 9, '03', 'Heater Valves & Related', '', 'Active'),
(646, 5, 9, '04', 'Oil Cooler Seals', '', 'Active'),
(647, 5, 9, '05', 'Oil Coolers', '', 'Active'),
(648, 5, 9, '06', 'Radiator Fan Blades', '', 'Active'),
(649, 5, 9, '07', 'Radiator Fan Clutch', '', 'Active'),
(650, 5, 9, '08', 'Radiator Fan Hardware', '', 'Active'),
(651, 5, 9, '09', 'Radiator Fan Motors', '', 'Active'),
(652, 5, 9, '10', 'Radiator Fans & Parts', '', 'Active'),
(653, 5, 9, '11', 'Radiator Hardware', '', 'Active'),
(654, 5, 9, '12', 'Radiator Hoses', '', 'Active'),
(655, 5, 9, '13', 'Radiator Mounts', '', 'Active'),
(656, 5, 9, '14', 'Radiator Overflow Hoses', '', 'Active'),
(657, 5, 9, '15', 'Radiator Sensors', '', 'Active'),
(658, 5, 9, '16', 'Radiator Support', '', 'Active'),
(659, 5, 9, '17', 'Radiators', '', 'Active'),
(660, 5, 9, '18', 'Radiators Caps', '', 'Active'),
(661, 5, 9, '19', 'Tank Caps, Hoses & Mounts', '', 'Active'),
(662, 5, 9, '20', 'Transmission Coolers', '', 'Active'),
(663, 5, 9, '21', 'Tubing', '', 'Active'),
(664, 5, 10, '01', 'Climate Control Modules', '', 'Active'),
(665, 5, 10, '02', 'Climate Control Sensors', '', 'Active'),
(666, 5, 10, '03', 'Coolant Thermostats', '', 'Active'),
(667, 5, 10, '04', 'Outlet Gaskets', '', 'Active'),
(668, 5, 10, '05', 'Temperature Control Modules', '', 'Active'),
(669, 5, 10, '06', 'Temperature Indicators', '', 'Active'),
(670, 5, 10, '07', 'Thermostat & Outlet Assemblies', '', 'Active'),
(671, 5, 10, '08', 'Thermostat Gaskets', '', 'Active'),
(672, 5, 10, '09', 'Thermostat Housing Covers', '', 'Active'),
(673, 5, 10, '10', 'Thermostat Housing Gaskets', '', 'Active'),
(674, 5, 10, '11', 'Thermostat Housings', '', 'Active'),
(675, 5, 10, '12', 'Thermostat Seals', '', 'Active'),
(676, 5, 10, '13', 'Thermostats', '', 'Active'),
(677, 5, 10, '14', 'Water Outlet', '', 'Active'),
(678, 6, 1, '01', 'Cameras & Cases', '', 'Active'),
(679, 6, 1, '02', 'Cell Phone Accessories', '', 'Active'),
(680, 6, 1, '03', 'Cell Phone Chargers & Batterie', '', 'Active'),
(681, 6, 1, '04', 'Cell Phone Hands-Free', '', 'Active'),
(682, 6, 1, '05', 'Two-Way Radios', '', 'Active'),
(683, 6, 2, '01', 'Adapters & Converters', '', 'Active'),
(684, 6, 2, '02', 'HD Audio Components', '', 'Active'),
(685, 6, 2, '03', 'Mobile Electronics', '', 'Active'),
(686, 6, 2, '04', 'MP3 Player Components', '', 'Active'),
(687, 6, 2, '05', 'MP3 Players', '', 'Active'),
(688, 6, 2, '06', 'Radio Components', '', 'Active'),
(689, 6, 2, '07', 'Radios, MP3 & CD Players', '', 'Active'),
(690, 6, 2, '08', 'Sound Enhancement', '', 'Active'),
(691, 6, 2, '09', 'Speakers & Accessories', '', 'Active'),
(692, 6, 2, '10', 'Televisions & Video Consoles', '', 'Active'),
(693, 6, 3, '01', 'Computer Accessories', '', 'Active'),
(694, 6, 4, '01', 'Air & Water Gauges', '', 'Active'),
(695, 6, 4, '02', 'Amp Gauges', '', 'Active'),
(696, 6, 4, '03', 'Fuel Gauges', '', 'Active'),
(697, 6, 4, '04', 'Gauge Accessories', '', 'Active'),
(698, 6, 4, '05', 'Meter Gauges', '', 'Active'),
(699, 6, 4, '06', 'Oil & Fuel Gauges', '', 'Active'),
(700, 6, 4, '07', 'Pressure Gauges', '', 'Active'),
(701, 6, 4, '08', 'Pyrometers', '', 'Active'),
(702, 6, 4, '09', 'Speedometers & Related', '', 'Active'),
(703, 6, 4, '10', 'Tachometers & Related', '', 'Active'),
(704, 6, 4, '11', 'Temperature Gauges', '', 'Active'),
(705, 6, 4, '12', 'Vacuum Gaguges', '', 'Active'),
(706, 6, 4, '13', 'Volt Gauges', '', 'Active'),
(707, 6, 5, '01', 'Clocks & Compasses', '', 'Active'),
(708, 6, 5, '02', 'Instrument Clusters', '', 'Active'),
(709, 6, 5, '03', 'Instrument Panels', '', 'Active'),
(710, 6, 5, '04', 'Lighters', '', 'Active'),
(711, 6, 6, '01', 'GPS Systems', '', 'Active'),
(712, 6, 7, '01', 'Radar Detectors', '', 'Active'),
(713, 7, 1, '01', 'Case Hardware', '', 'Active'),
(714, 7, 1, '02', 'Connecting Rods & Related', '', 'Active'),
(715, 7, 1, '03', 'Crankshafts & Parts', '', 'Active'),
(716, 7, 1, '04', 'Cylinder Head Components', '', 'Active'),
(717, 7, 1, '05', 'Cylinder Head Harware', '', 'Active'),
(718, 7, 1, '06', 'Cylinder Head Seals', '', 'Active'),
(719, 7, 1, '07', 'Cylinder Heads', '', 'Active'),
(720, 7, 1, '08', 'Cylinders & Related', '', 'Active'),
(721, 7, 1, '09', 'Engine Components', '', 'Active'),
(722, 7, 1, '10', 'Engine Hardware', '', 'Active'),
(723, 7, 1, '11', 'Engine Torque & Related', '', 'Active'),
(724, 7, 1, '12', 'Freeze Plugs', '', 'Active'),
(725, 7, 1, '13', 'Master Kits', '', 'Active'),
(726, 7, 1, '14', 'Oil Pans, Pumps & Parts', '', 'Active'),
(727, 7, 1, '15', 'Pistons & Piston Parts', '', 'Active'),
(728, 7, 1, '16', 'Pushrods & Related', '', 'Active'),
(729, 7, 2, '01', 'Engine Mount Hardware', '', 'Active'),
(730, 7, 2, '02', 'Engine Mounts', '', 'Active'),
(731, 7, 2, '03', 'Engine Parts', '', 'Active'),
(732, 7, 2, '04', 'Engines', '', 'Active'),
(733, 7, 2, '05', 'Harmonic Balancers', '', 'Active'),
(734, 7, 3, '01', 'Analyzers', '', 'Active'),
(735, 7, 3, '02', 'Computer Chips - Performance', '', 'Active'),
(736, 7, 3, '03', 'Computer Chips & Boards', '', 'Active'),
(737, 7, 3, '04', 'Control Modules', '', 'Active'),
(738, 7, 3, '05', 'Engine Computers', '', 'Active'),
(739, 7, 3, '06', 'Engine Control ', '', 'Active'),
(740, 7, 3, '07', 'Engine Modules', '', 'Active'),
(741, 7, 3, '08', 'Engine Wiring', '', 'Active'),
(742, 7, 3, '09', 'Ignition Modules', '', 'Active'),
(743, 7, 3, '10', 'Sensors', '', 'Active'),
(744, 7, 4, '01', 'Camshaft Gaskets', '', 'Active'),
(745, 7, 4, '02', 'Crankshaft Seals', '', 'Active'),
(746, 7, 4, '03', 'Cylinder Head Gaskets', '', 'Active'),
(747, 7, 4, '04', 'Drive Seals', '', 'Active'),
(748, 7, 4, '05', 'Main Bearing Gaskets', '', 'Active'),
(749, 7, 4, '06', 'Manifold Gaskets', '', 'Active'),
(750, 7, 4, '07', 'Rear Main Seals', '', 'Active'),
(751, 7, 4, '08', 'Silicone Sealers & Gaskets', '', 'Active'),
(752, 7, 4, '09', 'Take Off Shaft Seals', '', 'Active'),
(753, 7, 5, '01', 'Ballast Components', '', 'Active'),
(754, 7, 5, '02', 'Diesel Glow Plug Components', '', 'Active'),
(755, 7, 5, '03', 'Diesel glow Plugs', '', 'Active'),
(756, 7, 5, '04', 'Distributor Components', '', 'Active'),
(757, 7, 5, '05', 'Distributors', '', 'Active'),
(758, 7, 5, '06', 'Distributors - Performance', '', 'Active'),
(759, 7, 5, '07', 'Ignition Coil Components', '', 'Active'),
(760, 7, 5, '08', 'Ignition Coil Parts', '', 'Active'),
(761, 7, 5, '09', 'Ignition Coils - Performance', '', 'Active'),
(762, 7, 5, '10', 'Ignition Components', '', 'Active'),
(763, 7, 5, '11', 'Spark Plug Accessories', '', 'Active'),
(764, 7, 5, '12', 'Spark Plug Boots & Shields', '', 'Active'),
(765, 7, 5, '13', 'Spark Plug Inserts', '', 'Active'),
(766, 7, 5, '14', 'Spark Plug Tubes', '', 'Active'),
(767, 7, 5, '15', 'Spark Plugs', '', 'Active'),
(768, 7, 5, '16', 'Spark Wires & Tools', '', 'Active'),
(769, 7, 6, '01', 'Diesel Motor Oil', '', 'Active'),
(770, 7, 6, '02', 'Engine Oil Treatment & Additiv', '', 'Active'),
(771, 7, 6, '03', 'Motor Oil', '', 'Active'),
(772, 7, 6, '04', 'Motorcycle & Powersport', '', 'Active'),
(773, 7, 6, '05', 'Non-Detergent 30W Motor Oil', '', 'Active'),
(774, 7, 6, '06', 'Oil Absorbent', '', 'Active'),
(775, 7, 6, '07', 'Racing Motor Oil', '', 'Active'),
(776, 7, 6, '08', 'Synthetic & Blend', '', 'Active'),
(777, 7, 7, '01', 'Balance Shaft Bearings', '', 'Active'),
(778, 7, 7, '02', 'Balance Shaft Belts', '', 'Active'),
(779, 7, 7, '03', 'Balance Shaft Chain Parts', '', 'Active'),
(780, 7, 7, '04', 'Balance Shaft Chains', '', 'Active'),
(781, 7, 7, '05', 'Balance Shaft Kits', '', 'Active'),
(782, 7, 7, '06', 'Balance Shaft Seals', '', 'Active'),
(783, 7, 7, '07', 'Balance Shaft Sprockets', '', 'Active'),
(784, 7, 7, '08', 'Camshaft Hardware', '', 'Active'),
(785, 7, 7, '09', 'Camshafts', '', 'Active'),
(786, 7, 7, '10', 'Camshafts - Performance', '', 'Active'),
(787, 7, 7, '11', 'Engine Valve Components', '', 'Active'),
(788, 7, 7, '12', 'Engine Valves', '', 'Active'),
(789, 7, 7, '13', 'Push Rods', '', 'Active'),
(790, 7, 7, '14', 'Rocker Arm Hardware', '', 'Active'),
(791, 7, 7, '15', 'Rocker Arms', '', 'Active'),
(792, 7, 7, '16', 'Timing Belt Components', '', 'Active'),
(793, 7, 7, '17', 'Timing Belt Hardware', '', 'Active'),
(794, 7, 7, '18', 'Timing Belts', '', 'Active'),
(795, 7, 7, '19', 'Timing Chain Components', '', 'Active'),
(796, 7, 7, '20', 'Timing Chains', '', 'Active'),
(797, 7, 7, '21', 'Timing Cover Components', '', 'Active'),
(798, 7, 7, '22', 'Timing Covers', '', 'Active'),
(799, 7, 7, '23', 'Timing Hardware', '', 'Active'),
(800, 7, 7, '24', 'Timing Sets', '', 'Active'),
(801, 7, 7, '25', 'Valve Cover Hardware', '', 'Active'),
(802, 7, 7, '26', 'Valve Covers', '', 'Active'),
(803, 7, 7, '27', 'Valve Train Hardware', '', 'Active'),
(804, 8, 1, '01', 'AC Flushes & Solvents', '', 'Active'),
(805, 8, 1, '02', 'AC Lubricants', '', 'Active'),
(806, 8, 1, '03', 'AC Refrigerants', '', 'Active'),
(807, 8, 1, '04', 'Coolant & Antifreeze', '', 'Active'),
(808, 8, 1, '05', 'Antifreeze Flush Kits', '', 'Active'),
(809, 8, 1, '06', 'Brake Cleaners & Fluid', '', 'Active'),
(810, 8, 1, '07', 'Carb Cleaners', '', 'Active'),
(811, 8, 1, '08', 'Coolant Recovery', '', 'Active'),
(812, 8, 1, '09', 'Cylinder Lubricants', '', 'Active'),
(813, 8, 1, '10', 'Exhaust Fluid', '', 'Active'),
(814, 8, 1, '11', 'Fuel Treatments & Cleaners', '', 'Active'),
(815, 8, 1, '12', 'Lead Subtitutes', '', 'Active'),
(816, 8, 1, '13', 'Mercon/Dextron AT Fluid', '', 'Active'),
(817, 8, 1, '14', 'Octane Boost ', '', 'Active'),
(818, 8, 1, '15', 'Odor Eliminators', '', 'Active'),
(819, 8, 1, '16', 'Power Steering Fluids & Stop L', '', 'Active'),
(820, 8, 1, '17', 'Radiator Additives & Flushes', '', 'Active'),
(821, 8, 1, '18', 'Refrigerant Oil', '', 'Active'),
(822, 8, 1, '19', 'Starting Fluids', '', 'Active'),
(823, 8, 1, '20', 'Transmission & Drivetrain', '', 'Active'),
(824, 8, 1, '21', 'Transmission Treatment & Addit', '', 'Active'),
(825, 8, 1, '22', 'Windshield Washers & Treatment', '', 'Active'),
(826, 8, 2, '01', '2 Cycle & Outboard Lubes', '', 'Active'),
(827, 8, 2, '02', 'Assembly Lubes', '', 'Active'),
(828, 8, 2, '03', 'Belt Treatments', '', 'Active'),
(829, 8, 2, '04', 'Brake Grease', '', 'Active'),
(830, 8, 2, '05', 'Brake Lubricant', '', 'Active'),
(831, 8, 2, '06', 'Chain Lubes', '', 'Active'),
(832, 8, 2, '07', 'Cooling & Heating', '', 'Active'),
(833, 8, 2, '08', 'CV Joint Grease', '', 'Active'),
(834, 8, 2, '09', 'Electrical Lubes', '', 'Active'),
(835, 8, 2, '10', 'Engine Gaskets', '', 'Active'),
(836, 8, 2, '11', 'Engine Gaskets & Seals', '', 'Active'),
(837, 8, 2, '12', 'Exhaust Gaskets', '', 'Active'),
(838, 8, 2, '13', 'Gasket Sets', '', 'Active'),
(839, 8, 2, '14', 'Gear Oil', '', 'Active'),
(840, 8, 2, '15', 'Gear Oil Pumps', '', 'Active'),
(841, 8, 2, '16', 'Graphites & Lubricants', '', 'Active'),
(842, 8, 2, '17', 'Grease Cartridges', '', 'Active'),
(843, 8, 2, '18', 'Grease Fittings', '', 'Active'),
(844, 8, 2, '19', 'Grease Injectors', '', 'Active'),
(845, 8, 2, '20', 'Hydraulic Fluids', '', 'Active'),
(846, 8, 2, '21', 'Lithium Grease', '', 'Active'),
(847, 8, 2, '22', 'Marine Lubes', '', 'Active'),
(848, 8, 2, '23', 'Miscellaneous Gaskets', '', 'Active'),
(849, 8, 2, '24', 'Oil Filters', '', 'Active'),
(850, 8, 2, '25', 'Outlet Gaskets', '', 'Active'),
(851, 8, 2, '26', 'Penetrating & Fogging Oil', '', 'Active'),
(852, 8, 2, '27', 'Sealers', '', 'Active'),
(853, 8, 2, '28', 'Thermostat gaskets', '', 'Active'),
(854, 8, 2, '29', 'Transmission & Drivetrain', '', 'Active'),
(855, 8, 2, '30', 'Transmission & Drivetrain Gask', '', 'Active'),
(856, 8, 3, '01', '1/2 Drive', '', 'Active'),
(857, 8, 3, '02', '1/4 Drive', '', 'Active'),
(858, 8, 3, '03', '3/8 Drive', '', 'Active'),
(859, 8, 3, '04', 'Allen & Hex Key Sets', '', 'Active'),
(860, 8, 3, '05', 'Breaker Bars', '', 'Active'),
(861, 8, 3, '06', 'External Torx Sockets', '', 'Active'),
(862, 8, 3, '07', 'Flashlights & Batteries', '', 'Active'),
(863, 8, 3, '08', 'Pliers & Pliers Sets', '', 'Active'),
(864, 8, 3, '09', 'Ratchets', '', 'Active'),
(865, 8, 3, '10', 'Screwdrivers & Sets', '', 'Active'),
(866, 8, 3, '11', 'Socket Sets', '', 'Active'),
(867, 8, 3, '12', 'Sockets', '', 'Active'),
(868, 8, 3, '13', 'Tool Sets', '', 'Active'),
(869, 8, 3, '14', 'Torque & Impact Wrenches', '', 'Active'),
(870, 8, 3, '15', 'Wrenches & Wrenches Sets', '', 'Active'),
(871, 8, 4, '01', 'Adapters', '', 'Active'),
(872, 8, 4, '02', 'AN Fittings', '', 'Active'),
(873, 8, 4, '03', 'Belt Components', '', 'Active'),
(874, 8, 4, '04', 'Bolts', '', 'Active'),
(875, 8, 4, '05', 'Ends', '', 'Active'),
(876, 8, 4, '06', 'Fasteners', '', 'Active'),
(877, 8, 4, '07', 'Fittings', '', 'Active'),
(878, 8, 4, '08', 'Flare Fittings', '', 'Active'),
(879, 8, 4, '09', 'Hoses & Assemblies', '', 'Active'),
(880, 8, 4, '10', 'Industrial Belts', '', 'Active'),
(881, 8, 4, '11', 'Miscellaneous Fittings', '', 'Active'),
(882, 8, 4, '12', 'Nuts', '', 'Active'),
(883, 8, 4, '13', 'Pipe Thread Fittings', '', 'Active'),
(884, 8, 4, '14', 'Radius Ends', '', 'Active'),
(885, 8, 4, '15', 'Screws', '', 'Active'),
(886, 8, 4, '16', 'Swifel Ends', '', 'Active'),
(887, 8, 4, '17', 'Washers', '', 'Active'),
(888, 8, 5, '01', 'Diesel Motor Oil', '', 'Active'),
(889, 8, 5, '02', 'Engine Oil Treatment & Additiv', '', 'Active'),
(890, 8, 5, '03', 'Motor Oil', '', 'Active'),
(891, 8, 5, '04', 'Motorcycle & Powersport', '', 'Active'),
(892, 8, 5, '05', 'Non-Detergent 30W Motor Oil', '', 'Active'),
(893, 8, 5, '06', 'Oil Absorbent', '', 'Active'),
(894, 8, 5, '07', 'Racing Motor Oil', '', 'Active'),
(895, 8, 5, '08', 'Synthetic & Blended', '', 'Active'),
(896, 8, 6, '01', 'Foreign Language Manuals', '', 'Active'),
(897, 8, 6, '02', 'Labor Guides', '', 'Active'),
(898, 8, 6, '03', 'Repair Manuals', '', 'Active'),
(899, 8, 6, '04', 'Shop Manuals', '', 'Active'),
(900, 8, 6, '05', 'Specialty Manuals', '', 'Active'),
(901, 8, 6, '06', 'Wiring Diagrams', '', 'Active'),
(902, 8, 7, '01', 'Air Compressors', '', 'Active'),
(903, 8, 7, '02', 'Benches, Tables, Carts & Stool', '', 'Active'),
(904, 8, 7, '03', 'Brooms, Mops & Floor Squeegees', '', 'Active'),
(905, 8, 7, '04', 'Cleaners & Degreasers', '', 'Active'),
(906, 8, 7, '05', 'Commercial tools & Equipment', '', 'Active'),
(907, 8, 7, '06', 'Creepers, Dollys & Ramps', '', 'Active'),
(908, 8, 7, '07', 'Engine Diagnostics & Flush', '', 'Active'),
(909, 8, 7, '08', 'Floor Protection', '', 'Active'),
(910, 8, 7, '09', 'Fluid Exchangers', '', 'Active'),
(911, 8, 7, '10', 'Garage Organizers', '', 'Active'),
(912, 8, 7, '11', 'Generators', '', 'Active'),
(913, 8, 7, '12', 'Hoists, Stand & Accessories', '', 'Active'),
(914, 8, 7, '13', 'Jacks & Accessories', '', 'Active'),
(915, 8, 7, '14', 'Lift & Accessories', '', 'Active'),
(916, 8, 7, '15', 'Refrigerant Systems', '', 'Active'),
(917, 8, 7, '16', 'Shops Coolers & Heaters', '', 'Active'),
(918, 8, 7, '17', 'Tire & Wheel Tools', '', 'Active'),
(919, 8, 7, '18', 'Training Supplies', '', 'Active'),
(920, 8, 7, '19', 'Vacuums & Pressure Washers', '', 'Active'),
(921, 8, 7, '20', 'Welding Tools & Accessories', '', 'Active'),
(922, 8, 8, '01', 'AC Clutch Install Kits', '', 'Active'),
(923, 8, 8, '02', 'AC Tools, Hardware & Adapters', '', 'Active'),
(924, 8, 8, '03', 'Air Tools', '', 'Active'),
(925, 8, 8, '04', 'Brake Tools', '', 'Active');
INSERT INTO `rims_product_sub_category` (`id`, `product_master_category`, `product_sub_master_category_id`, `code`, `name`, `description`, `status`) VALUES
(926, 8, 8, '05', 'Cutting & Drilling Tools', '', 'Active'),
(927, 8, 8, '06', 'Diagnostic Tools', '', 'Active'),
(928, 8, 8, '07', 'Measuring Tools', '', 'Active'),
(929, 8, 8, '08', 'Oil & Lube Tools', '', 'Active'),
(930, 8, 8, '09', 'Other Specialty Tools', '', 'Active'),
(931, 8, 8, '10', 'Suspension, Springs & Related', '', 'Active'),
(932, 8, 9, '01', 'Drip & Drain Pans', '', 'Active'),
(933, 8, 9, '02', 'Fuel Can Spouts & Accessories', '', 'Active'),
(934, 8, 9, '03', 'Fuel Containers', '', 'Active'),
(935, 8, 9, '04', 'Funnels', '', 'Active'),
(936, 8, 9, '05', 'Garage Accessories', '', 'Active'),
(937, 8, 9, '06', 'Oil change Stickers', '', 'Active'),
(938, 8, 9, '07', 'Plastiv Fuel Cans', '', 'Active'),
(939, 8, 9, '08', 'Siphons', '', 'Active'),
(940, 8, 9, '09', 'Tool Bags', '', 'Active'),
(941, 8, 9, '10', 'Tool Boxes & Accessories', '', 'Active'),
(942, 8, 9, '11', 'Tool Organizers', '', 'Active'),
(943, 8, 9, '12', 'Trailer Mount Tool Boxes', '', 'Active'),
(944, 8, 9, '13', 'Truck Tool Boxes', '', 'Active'),
(945, 8, 9, '14', 'Water Containers', '', 'Active'),
(946, 8, 10, '01', 'Gear Bags & Work Belts', '', 'Active'),
(947, 8, 10, '02', 'Kids Gloves', '', 'Active'),
(948, 8, 10, '03', 'Knee Pads', '', 'Active'),
(949, 8, 10, '04', 'Large Gloves', '', 'Active'),
(950, 8, 10, '05', 'Latex & Nitrile Gloves', '', 'Active'),
(951, 8, 10, '06', 'Medium Gloves', '', 'Active'),
(952, 8, 10, '07', 'Miscellaneous Gloves', '', 'Active'),
(953, 8, 10, '08', 'Personal Care', '', 'Active'),
(954, 8, 10, '09', 'Protective Gear', '', 'Active'),
(955, 8, 10, '10', 'Shoes & Boots', '', 'Active'),
(956, 8, 10, '11', 'Small Gloves ', '', 'Active'),
(957, 8, 10, '12', 'Solvent & Welding Gloves', '', 'Active'),
(958, 8, 10, '13', 'Welding Helmets', '', 'Active'),
(959, 8, 10, '14', 'X-Large Gloves', '', 'Active'),
(960, 8, 10, '15', 'XX-Large Gloves', '', 'Active'),
(961, 9, 1, '01', 'Actuator Cables & Valves', '', 'Active'),
(962, 9, 1, '02', 'Automatic Transmission Compone', '', 'Active'),
(963, 9, 1, '03', 'Bearings & Bearing Kits', '', 'Active'),
(964, 9, 1, '04', 'Control Modules & Connectors', '', 'Active'),
(965, 9, 1, '05', 'Cooler Hoses, Clips & Lines', '', 'Active'),
(966, 9, 1, '06', 'Dipsticks & Dipstick Tubes', '', 'Active'),
(967, 9, 1, '07', 'Gear Shift Levers', '', 'Active'),
(968, 9, 1, '08', 'Line Assemblies & Connectors', '', 'Active'),
(969, 9, 1, '09', 'Modulator Valves, Caps & Pins', '', 'Active'),
(970, 9, 1, '10', 'Oil Pans', '', 'Active'),
(971, 9, 1, '11', 'rebuild Kits', '', 'Active'),
(972, 9, 1, '12', 'Seals & O-Rings', '', 'Active'),
(973, 9, 1, '13', 'Shift Handles', '', 'Active'),
(974, 9, 1, '14', 'Shifters', '', 'Active'),
(975, 9, 1, '15', 'Speedometer Components', '', 'Active'),
(976, 9, 1, '16', 'Temperature Gauges & Sensors', '', 'Active'),
(977, 9, 1, '17', 'Torque Converters & Components', '', 'Active'),
(978, 9, 1, '18', 'Transmission Kits & Components', '', 'Active'),
(979, 9, 1, '19', 'Wiring Harness Connectors', '', 'Active'),
(980, 9, 2, '01', 'Cruise Control Amplifiers & Mo', '', 'Active'),
(981, 9, 2, '02', 'Cruise Control Cables & Bracke', '', 'Active'),
(982, 9, 2, '03', 'Cruise Control Relays', '', 'Active'),
(983, 9, 2, '04', 'Cruise Control Sensor Connecto', '', 'Active'),
(984, 9, 2, '05', 'Cruise Control Sensor Transduc', '', 'Active'),
(985, 9, 2, '06', 'Cruise Control Switch Connecto', '', 'Active'),
(986, 9, 2, '07', 'Cruise Control Switches', '', 'Active'),
(987, 9, 2, '08', 'Cruise Control Units', '', 'Active'),
(988, 9, 2, '09', 'Cruise Control Valves', '', 'Active'),
(989, 9, 3, '01', '4-Wheel Drive (4WD) Hubs', '', 'Active'),
(990, 9, 3, '02', 'Axle Beam Assemblies & Mounts', '', 'Active'),
(991, 9, 3, '03', 'Axle Bearings', '', 'Active'),
(992, 9, 3, '04', 'Axle Flange Gaskets', '', 'Active'),
(993, 9, 3, '05', 'Axle Hardware', '', 'Active'),
(994, 9, 3, '06', 'Axle Hubs & Gaskets', '', 'Active'),
(995, 9, 3, '07', 'Axle Nuts & Lock Plates', '', 'Active'),
(996, 9, 3, '08', 'Axle Shaft & Components', '', 'Active'),
(997, 9, 3, '09', 'Axle Shafts', '', 'Active'),
(998, 9, 3, '10', 'Axle Spindles & Bearings', '', 'Active'),
(999, 9, 3, '11', 'CV Joint Components', '', 'Active'),
(1000, 9, 3, '12', 'Drive Shaft Seals', '', 'Active'),
(1001, 9, 3, '13', 'Intermediate Shaft Bearing', '', 'Active'),
(1002, 9, 3, '14', 'Intermediate Shafts & Related', '', 'Active'),
(1003, 9, 3, '15', 'Pinion Seals', '', 'Active'),
(1004, 9, 3, '16', 'Spindle Lock Nuts', '', 'Active'),
(1005, 9, 3, '17', 'Spindle Nut Sockets', '', 'Active'),
(1006, 9, 3, '18', 'Stub Axles', '', 'Active'),
(1007, 9, 4, '01', 'Differential Bearings', '', 'Active'),
(1008, 9, 4, '02', 'Differential Carrier Bushings', '', 'Active'),
(1009, 9, 4, '03', 'Differential Cases', '', 'Active'),
(1010, 9, 4, '04', 'Differential Covers & Gaskets', '', 'Active'),
(1011, 9, 4, '05', 'Differential Crush Sleeves', '', 'Active'),
(1012, 9, 4, '06', 'Differential Hardware', '', 'Active'),
(1013, 9, 4, '07', 'Differential Mounts', '', 'Active'),
(1014, 9, 4, '08', 'Differential Open Units', '', 'Active'),
(1015, 9, 4, '09', 'Differential Pinions & Related', '', 'Active'),
(1016, 9, 4, '10', 'Differential Seals & Kits', '', 'Active'),
(1017, 9, 4, '11', 'Differential Shims & Kits', '', 'Active'),
(1018, 9, 4, '12', 'Differentials', '', 'Active'),
(1019, 9, 4, '13', 'Differentials & Axles', '', 'Active'),
(1020, 9, 4, '14', 'Fluids & Chemicals', '', 'Active'),
(1021, 9, 4, '15', 'Posi Units', '', 'Active'),
(1022, 9, 5, '01', 'Carrier bearing Spacers', '', 'Active'),
(1023, 9, 5, '02', 'Center Support Bearings', '', 'Active'),
(1024, 9, 5, '03', 'Drive Shaft Bearings', '', 'Active'),
(1025, 9, 5, '04', 'Drive Shaft Couplings & Boots', '', 'Active'),
(1026, 9, 5, '05', 'Drive Shaft Slip Yoke Sleeves', '', 'Active'),
(1027, 9, 5, '06', 'Drie Shaft Support Bushings', '', 'Active'),
(1028, 9, 5, '07', 'Drive Shaft Support Washers', '', 'Active'),
(1029, 9, 5, '08', 'Drive Shafts', '', 'Active'),
(1030, 9, 5, '09', 'Drive Shafts & Axles', '', 'Active'),
(1031, 9, 5, '10', 'Propeller Assemblies', '', 'Active'),
(1032, 9, 5, '11', 'Propeller Shaft Hardware', '', 'Active'),
(1033, 9, 5, '12', 'U-Joint Components', '', 'Active'),
(1034, 9, 5, '13', 'U-Joints', '', 'Active'),
(1035, 9, 6, '01', 'Transmission Fluid', '', 'Active'),
(1036, 9, 6, '02', 'Treatments & Additives', '', 'Active'),
(1037, 9, 7, '01', 'Clutch Cable Hardware', '', 'Active'),
(1038, 9, 7, '02', 'Clutch Cables', '', 'Active'),
(1039, 9, 7, '03', 'Clutch Components', '', 'Active'),
(1040, 9, 7, '04', 'Clutch Discs', '', 'Active'),
(1041, 9, 7, '05', 'Clutch Master Cylinders & Kits', '', 'Active'),
(1042, 9, 7, '06', 'Clutch Operating Shaft Compone', '', 'Active'),
(1043, 9, 7, '07', 'Clutch Pilot Bearings', '', 'Active'),
(1044, 9, 7, '08', 'Clutch Pilot Bushings', '', 'Active'),
(1045, 9, 7, '09', 'Flywheel Components', '', 'Active'),
(1046, 9, 7, '10', 'Flywheels & Flexplates', '', 'Active'),
(1047, 9, 7, '11', 'Gear Shift Components', '', 'Active'),
(1048, 9, 7, '12', 'Manual Transmission Bearings', '', 'Active'),
(1049, 9, 7, '13', 'Manual Transmission Cables', '', 'Active'),
(1050, 9, 7, '14', 'Manual Transmission Components', '', 'Active'),
(1051, 9, 7, '15', 'Manual Transmission Seals', '', 'Active'),
(1052, 9, 7, '16', 'Master & Slave Cylinder Assemb', '', 'Active'),
(1053, 9, 7, '17', 'Pressure Plates & Disc Sets', '', 'Active'),
(1054, 9, 7, '18', 'Release Bearings & Accessories', '', 'Active'),
(1055, 9, 7, '19', 'Shifters', '', 'Active'),
(1056, 9, 7, '20', 'Shifters - Performance', '', 'Active'),
(1057, 9, 8, '01', 'Bearing & Seal Overhaul Kits', '', 'Active'),
(1058, 9, 8, '02', 'Chain Case Seals', '', 'Active'),
(1059, 9, 8, '03', 'Companion Flange Seals', '', 'Active'),
(1060, 9, 8, '04', 'Countershaft Bearings', '', 'Active'),
(1061, 9, 8, '05', 'Differential Bearings', '', 'Active'),
(1062, 9, 8, '06', 'Drive Sprocket Bearings', '', 'Active'),
(1063, 9, 8, '07', 'Idler Shaft Bearings & Seals', '', 'Active'),
(1064, 9, 8, '08', 'Oil Pump Housing Bearings', '', 'Active'),
(1065, 9, 8, '09', 'Oil Pump Housing Seals', '', 'Active'),
(1066, 9, 8, '10', 'Output Shaft Components', '', 'Active'),
(1067, 9, 8, '11', 'Pinion Shaft Components', '', 'Active'),
(1068, 9, 8, '12', 'Transfer Case Assemblies', '', 'Active'),
(1069, 9, 8, '13', 'Transfer Case Bearings & Seals', '', 'Active'),
(1070, 9, 8, '14', 'Transfer Case components', '', 'Active'),
(1071, 9, 9, '01', '(AT) Housing Baskets', '', 'Active'),
(1072, 9, 9, '02', '(AT) Side Cover Gaskets', '', 'Active'),
(1073, 9, 9, '03', 'Differential Carrier Gaskets', '', 'Active'),
(1074, 9, 9, '04', 'Differential Cover Gaskets', '', 'Active'),
(1075, 9, 9, '05', 'Drive Axle Gaskets', '', 'Active'),
(1076, 9, 9, '06', 'Extension Housing Gaskets', '', 'Active'),
(1077, 9, 9, '07', 'Manual Transmission Gasket Sea', '', 'Active'),
(1078, 9, 9, '08', 'Transfer Gear Gaskets', '', 'Active'),
(1079, 9, 9, '09', 'Transmission Gaskets & Sets', '', 'Active'),
(1080, 9, 9, '10', 'Transmission Oil Cooler O-Ring', '', 'Active'),
(1081, 9, 9, '11', 'Valve Body Cover Gaskets', '', 'Active'),
(1082, 9, 10, '01', 'Wheel Bearings', '', 'Active'),
(1083, 9, 10, '02', 'Wheel Hub Hardware', '', 'Active'),
(1084, 9, 10, '03', 'Wheel Races', '', 'Active'),
(1085, 9, 10, '04', 'Wheel Seals', '', 'Active'),
(1086, 9, 10, '05', 'Wheel Spacers', '', 'Active'),
(1087, 9, 10, '06', 'Wheel Studs', '', 'Active'),
(1088, 9, 10, '07', 'Wheels & Components', '', 'Active'),
(1089, 10, 1, '01', 'Base Coat ', 'Cat', 'Active'),
(1090, 10, 1, '02', 'Clear Coat', 'Furnish', 'Active'),
(1091, 10, 1, '03', 'Activators ', 'Penguat Furnish', 'Active'),
(1092, 10, 1, '04', 'Primers', 'Lapisan Dasar', 'Active'),
(1093, 10, 1, '05', 'Thinners', 'Pengencer Cat', 'Active'),
(1094, 10, 1, '06', 'Polyester Putty', 'Dempul', 'Active'),
(1095, 10, 1, '07', 'Polishing Compound', 'Poles', 'Active'),
(1096, 10, 1, '08', 'Plastic Paint System', '', 'Active'),
(1097, 10, 1, '09', 'Sand Paper', 'Amplas', 'Active'),
(1098, 10, 1, '10', 'CPB Brush', 'Kuas', 'Active'),
(1099, 10, 1, '11', 'Other Materials', '', 'Active'),
(1100, 10, 2, '01', 'Engine Repair', '', 'Active'),
(1101, 10, 3, '01', 'Tire Service', '', 'Active'),
(1102, 10, 4, '01', 'Oil Service', '', 'Active'),
(1103, 10, 5, '01', 'Battery service', '', 'Active'),
(1104, 10, 6, '01', 'Car Wash ', '', 'Active'),
(1105, 10, 7, '01', 'Other Services', '', 'Active'),
(1106, 11, 1, '01', 'Body Repair Tools', '', 'Active'),
(1107, 11, 2, '01', 'Engine Repair Tools', '', 'Active'),
(1108, 11, 3, '01', 'Tire Tools', '', 'Active'),
(1109, 11, 4, '01', 'Oil Tools', '', 'Active'),
(1110, 11, 5, '01', 'Battery Tools', '', 'Active'),
(1111, 11, 6, '01', 'Car Wash Tools', '', 'Active'),
(1112, 11, 7, '01', 'Other Services Tools', '', 'Active'),
(1113, 12, 1, '01', 'In-house Bonus', '', 'Active'),
(1114, 12, 2, '01', 'Program Bonus & Discount', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_sub_master_category`
--

CREATE TABLE IF NOT EXISTS `rims_product_sub_master_category` (
`id` int(11) NOT NULL,
  `product_master_category_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_product_sub_master_category`
--

INSERT INTO `rims_product_sub_master_category` (`id`, `product_master_category_id`, `code`, `name`, `status`) VALUES
(1, 1, 'A', 'Air Filters & Related', 'Active'),
(2, 1, 'B', 'Carburetors & Intake Manifolds', 'Active'),
(3, 1, 'C', 'Carburetion', 'Active'),
(4, 1, 'D', 'Emission', 'Active'),
(5, 1, 'E', 'Exhaust', 'Active'),
(6, 1, 'F', 'Fuel & Oil Filters', 'Active'),
(7, 1, 'G', 'Fuel Injection Sytem', 'Active'),
(8, 1, 'H', 'Fuel Pumps & Tanks', 'Active'),
(9, 1, 'I', 'Nitrous Oxide Systems', 'Active'),
(10, 1, 'J', 'Turbos & Superchargers', 'Active'),
(11, 2, 'A', 'Appearance, Wash & Wax', 'Active'),
(12, 2, 'B', 'Auto Body Parts', 'Active'),
(13, 2, 'C', 'Body Styling & Dress-Up', 'Active'),
(14, 2, 'D', 'Car Covers & Body Protection', 'Active'),
(15, 2, 'E', 'Paint & Body Repair', 'Active'),
(16, 2, 'F', 'Roadside Safety, Lock & Alarms', 'Active'),
(17, 2, 'G', 'Seasonal Accessories', 'Active'),
(18, 2, 'H', 'Storage & Cargo', 'Active'),
(19, 2, 'I', 'Windshield, Doors & Window', 'Active'),
(20, 3, 'A', 'Air Bag System & Related', 'Active'),
(21, 3, 'B', 'Alternators, Generators & rela', 'Active'),
(22, 3, 'C', 'Batterie', 'Active'),
(23, 3, 'D', 'Battery Components & Tools', 'Active'),
(24, 3, 'E', 'Charging System', 'Active'),
(25, 3, 'F', 'Electrical Connectors & Socket', 'Active'),
(26, 3, 'G', 'Lights, Flasher Units, Fuses', 'Active'),
(27, 3, 'H', 'Relays, Switches & Sensors', 'Active'),
(28, 3, 'I', 'Starters & Related', 'Active'),
(29, 4, 'A', 'ABS Components', 'Active'),
(30, 4, 'B', 'Brake Calipers & Related', 'Active'),
(31, 4, 'C', 'Brake Drums & Rotors', 'Active'),
(32, 4, 'D', 'Brake Hardware & Components', 'Active'),
(33, 4, 'E', 'Brake Pads & Shoes', 'Active'),
(34, 4, 'F', 'Power Steering Hoses & Pumps', 'Active'),
(35, 4, 'G', 'Shocks & Struts', 'Active'),
(36, 4, 'H', 'Steering, Gear & Pumps', 'Active'),
(37, 4, 'I', 'Suspension, Springs & Related', 'Active'),
(38, 4, 'J', 'Wheel & Tire Parts', 'Active'),
(39, 5, 'A', 'AC Accumulators & Driers', 'Active'),
(40, 5, 'B', 'AC Clutches & Compressors', 'Active'),
(41, 5, 'C', 'AC Tools, Hardware & Adapters', 'Active'),
(42, 5, 'D', 'Belts & Hoses', 'Active'),
(43, 5, 'E', 'Cooling & Water Pumps', 'Active'),
(44, 5, 'F', 'Cooling Fans, Clutches & Motor', 'Active'),
(45, 5, 'G', 'Fluids & Chemicals', 'Active'),
(46, 5, 'H', 'Heater Motors & Cores', 'Active'),
(47, 5, 'I', 'Radiators, Coolers & Related', 'Active'),
(48, 5, 'J', 'Thermostats, Gaskets & Housing', 'Active'),
(49, 6, 'A', 'Camera & Cell Phone Accessorie', 'Active'),
(50, 6, 'B', 'Car Audio & Video', 'Active'),
(51, 6, 'C', 'Gauges & Components', 'Active'),
(52, 6, 'D', 'Instrument Panel & Dash', 'Active'),
(53, 6, 'E', 'Navigation', 'Active'),
(54, 6, 'F', 'Radar & Laser Detection', 'Active'),
(55, 7, 'A', 'Cylinder Block Components', 'Active'),
(56, 7, 'B', 'Engine Components', 'Active'),
(57, 7, 'C', 'Engine Electronics', 'Active'),
(58, 7, 'D', 'Engine Gaskets & Seals', 'Active'),
(59, 7, 'E', 'Ignition & Tune-Up', 'Active'),
(60, 7, 'F', 'Motor Oil & Additives', 'Active'),
(61, 7, 'G', 'Valve Train Components', 'Active'),
(62, 8, 'A', 'Fluids & Chemicals', 'Active'),
(63, 8, 'B', 'Gaskets, Sealers, Grease & Lub', 'Active'),
(64, 8, 'C', 'Hand Tools', 'Active'),
(65, 8, 'D', 'Hardware & Fasteners', 'Active'),
(66, 8, 'E', 'Repair Manuals & Diagrams', 'Active'),
(67, 8, 'F', 'Shop Equipment', 'Active'),
(68, 8, 'G', 'Specialty Tools', 'Active'),
(69, 8, 'H', 'Storage & Containers', 'Active'),
(70, 8, 'I', 'Workwear & Gloves', 'Active'),
(71, 9, 'A', 'Automatic Transmission', 'Active'),
(72, 9, 'B', 'Cruise Control', 'Active'),
(73, 9, 'C', 'CV Axles & Parts', 'Active'),
(74, 9, 'D', 'Differential', 'Active'),
(75, 9, 'E', 'Drive Shaft', 'Active'),
(76, 9, 'F', 'Fluids & Chemicals', 'Active'),
(77, 9, 'G', 'Manual Transmissions', 'Active'),
(78, 9, 'H', 'Transfer Case Parts', 'Active'),
(79, 9, 'I', 'Transmission Gaskets', 'Active'),
(80, 9, 'J', 'Wheels Bearings, Seals & Relat', 'Active'),
(81, 10, 'A', 'Body Repair', 'Active'),
(82, 10, 'B', 'Engine Repair', 'Active'),
(83, 10, 'C', 'Tire Service', 'Active'),
(84, 10, 'D', 'Oil Service', 'Active'),
(85, 10, 'E', 'Battery Service', 'Active'),
(86, 10, 'F', 'Car Wash', 'Active'),
(87, 10, 'G', 'Other Services', 'Active'),
(88, 11, 'A', 'Body Repair Tools', 'Active'),
(89, 11, 'B', 'Engine Repair Tools', 'Active'),
(90, 11, 'C', 'Tire Tools', 'Active'),
(91, 11, 'D', 'Oil Tools', 'Active'),
(92, 11, 'E', 'Battery Tools', 'Active'),
(93, 11, 'F', 'Car Wash Tools', 'Active'),
(94, 11, 'G', 'Other Services Tools', 'Active'),
(95, 12, 'A', 'In-house Bonus', 'Active'),
(96, 12, 'B', 'Program Bonus & Discount', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_province`
--

CREATE TABLE IF NOT EXISTS `rims_province` (
`id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_province`
--

INSERT INTO `rims_province` (`id`, `name`, `code`) VALUES
(1, 'Nanggroe Aceh Darussalam', NULL),
(2, 'Sumatera Utara', NULL),
(3, 'Sumatera Barat', NULL),
(4, 'Riau', NULL),
(5, 'Kepulauan Riau', NULL),
(6, 'Kepulauan Bangka-Belitung', NULL),
(7, 'Jambi', NULL),
(8, 'Bengkulu', NULL),
(9, 'Sumatera Selatan', NULL),
(10, 'Lampung', NULL),
(11, 'Banten', NULL),
(12, 'DKI Jakarta', NULL),
(13, 'Jawa Barat', NULL),
(14, 'Jawa Tengah', NULL),
(15, 'Daerah Istimewa Yogyakarta', NULL),
(16, 'Jawa Timur', NULL),
(17, 'Bali', NULL),
(18, 'Nusa Tenggara Barat', NULL),
(19, 'Nusa Tenggara Timur', NULL),
(20, 'Kalimantan Barat', NULL),
(21, 'Kalimantan Tengah', NULL),
(22, 'Kalimantan Selatan', NULL),
(23, 'Kalimantan Timur', NULL),
(24, 'Gorontalo', NULL),
(25, 'Sulawesi Selatan', NULL),
(26, 'Sulawesi Tenggara', NULL),
(27, 'Sulawesi Tengah', NULL),
(28, 'Sulawesi Utara', NULL),
(29, 'Sulawesi Barat', NULL),
(30, 'Maluku', NULL),
(31, 'Maluku Utara', NULL),
(32, 'Papua Barat', NULL),
(33, 'Papua', NULL),
(34, 'Kalimantan Utara', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rims_section`
--

CREATE TABLE IF NOT EXISTS `rims_section` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `rack_number` varchar(20) NOT NULL,
  `column` varchar(20) NOT NULL,
  `row` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_section_detail`
--

CREATE TABLE IF NOT EXISTS `rims_section_detail` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier`
--

CREATE TABLE IF NOT EXISTS `rims_supplier` (
`id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `company` varchar(30) NOT NULL,
  `position` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email_personal` varchar(60) NOT NULL,
  `email_company` varchar(60) NOT NULL,
  `npwp` varchar(20) NOT NULL,
  `description` varchar(60) NOT NULL,
  `tenor` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_supplier`
--

INSERT INTO `rims_supplier` (`id`, `date`, `code`, `name`, `company`, `position`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email_personal`, `email_company`, `npwp`, `description`, `tenor`) VALUES
(1, '2015-10-13', 'S-01', 'Supplier1', 'PT. Astra Internasional', 'Anything', 'Gading', 12, 42, '32121', '02198321212', 'supplier1@gmail.com', 'supplier1@astra.com', '123123123132132131', 'Testing', 30),
(2, '2015-10-15', 'S-02', 'Supplier 2', 'PT. ABCDEFEGESDFS', 'Marketing', 'JL 123450943402', 12, 40, '32121', '0219832121', 'supplier2@gmail.com', 'supplier2@abcdefghijklm.com', '123878983231', 'Testing2', 30);

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_bank`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_bank` (
`id` int(11) NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `account_no` varchar(20) DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_supplier_bank`
--

INSERT INTO `rims_supplier_bank` (`id`, `bank_id`, `supplier_id`, `account_no`, `account_name`, `status`) VALUES
(2, 9, 2, '9231232131', 'Test', 'Active'),
(10, 1, 1, '132', '78905', 'Active'),
(11, 7, 1, '345', '9846', 'Active'),
(12, 3, 1, '456', '123490', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_mobile` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_supplier_mobile`
--

INSERT INTO `rims_supplier_mobile` (`id`, `supplier_id`, `mobile_no`, `status`) VALUES
(1, 1, '08675562712', NULL),
(2, 1, '081239120345', NULL),
(3, 2, '09875567211', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_phone`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_phone` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_supplier_phone`
--

INSERT INTO `rims_supplier_phone` (`id`, `supplier_id`, `phone_no`, `status`) VALUES
(1, 1, '02198123121', NULL),
(2, 2, '0212231879', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_pic`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_pic` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL COMMENT 'foreign key from supplier table',
  `date` date DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `company` varchar(30) DEFAULT NULL,
  `position` varchar(30) DEFAULT NULL,
  `address` text,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email_personal` varchar(60) DEFAULT NULL,
  `email_company` varchar(60) DEFAULT NULL,
  `npwp` varchar(20) DEFAULT NULL,
  `description` varchar(60) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_supplier_pic`
--

INSERT INTO `rims_supplier_pic` (`id`, `supplier_id`, `date`, `code`, `name`, `company`, `position`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email_personal`, `email_company`, `npwp`, `description`, `status`) VALUES
(1, 1, '2015-10-28', 'pic 1', 'pic 1234', 'PT. Astra International', 'Purchasing', 'Testing', 12, 39, '11340', '02198321212', 'pic@gmail.com', 'pic@astra.com', '323138912313', 'Testing', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_pic_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_pic_mobile` (
`id` int(11) NOT NULL,
  `supplier_pic_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_pic_phone`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_pic_phone` (
`id` int(11) NOT NULL,
  `supplier_pic_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_unit`
--

CREATE TABLE IF NOT EXISTS `rims_unit` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_unit`
--

INSERT INTO `rims_unit` (`id`, `name`, `status`) VALUES
(7, 'Pieces', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle` (
`id` int(11) NOT NULL,
  `plate_number` varchar(10) NOT NULL,
  `machine_number` varchar(30) NOT NULL,
  `frame_number` varchar(30) NOT NULL,
  `car_make_id` int(11) DEFAULT NULL,
  `car_model_id` int(11) DEFAULT NULL,
  `car_sub_model_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_pic_id` int(11) DEFAULT NULL,
  `chasis_id` varchar(30) DEFAULT NULL,
  `power_cc` int(30) DEFAULT NULL,
  `luxury_value` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_vehicle`
--

INSERT INTO `rims_vehicle` (`id`, `plate_number`, `machine_number`, `frame_number`, `car_make_id`, `car_model_id`, `car_sub_model_id`, `color_id`, `year`, `customer_id`, `customer_pic_id`, `chasis_id`, `power_cc`, `luxury_value`) VALUES
(1, 'B1231ERT', '123-456-PPT-32', '234-567-123-FN', 1, 1, 1, 1, '2012', 1, 1, 'E01', 1500, '1.00'),
(2, 'B 1171 TYR', '0433jk94353', 'jkl0234', 1, 1, 1, 1, '2012', 29, 2, '988765677655', 1500, '1.20'),
(3, 'b1167jkl', '4234234234', 'fadsfa799767', 1, 1, 1, 1, '2015', 29, 2, '0985544677', 1500, '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle_car_make`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle_car_make` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_vehicle_car_make`
--

INSERT INTO `rims_vehicle_car_make` (`id`, `name`, `status`) VALUES
(1, 'BMW', 'Active'),
(2, 'Toyota', 'Active'),
(3, 'Honda', 'Active'),
(4, 'Mercedes Benz', 'Active'),
(5, 'Daihatsu', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle_car_model`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle_car_model` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(60) NOT NULL,
  `car_make_id` int(11) NOT NULL COMMENT 'foreign key from vehicle brand table',
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_vehicle_car_model`
--

INSERT INTO `rims_vehicle_car_model` (`id`, `name`, `description`, `car_make_id`, `status`) VALUES
(1, 'E320', 'BMW E320', 1, 'Active'),
(2, 'Avanza', 'MPV', 2, 'Active'),
(3, 'Harrier', 'SUV', 2, 'Active'),
(4, 'C Class', 'C Class', 4, 'Active'),
(5, 'E Class', 'E Series', 4, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle_car_sub_detail`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle_car_sub_detail` (
`id` int(11) NOT NULL,
  `style_name` varchar(10) NOT NULL,
  `assembly_year` varchar(10) NOT NULL,
  `assembly_year_end` varchar(10) NOT NULL,
  `transmission_id` int(11) NOT NULL,
  `fuel_type` varchar(20) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `sub_brand_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `power_id` int(11) NOT NULL,
  `drivetrain` varchar(10) NOT NULL,
  `chasis_id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_vehicle_car_sub_detail`
--

INSERT INTO `rims_vehicle_car_sub_detail` (`id`, `style_name`, `assembly_year`, `assembly_year_end`, `transmission_id`, `fuel_type`, `brand_id`, `sub_brand_id`, `status`, `power_id`, `drivetrain`, `chasis_id`, `description`) VALUES
(1, 'S01', '2013', '2015', 0, 'Gasoline', 1, 1, 'Active', 500, '4WD', 0, ''),
(2, 'C200', '2007', '2014', 0, 'Gasoline', 4, 4, 'Active', 2000, '2WD', 0, ''),
(3, 'C200', '2015', '2016', 0, 'Gasoline', 4, 4, 'Active', 2500, '2WD', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `rims_warehouse`
--

CREATE TABLE IF NOT EXISTS `rims_warehouse` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(60) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_warehouse`
--

INSERT INTO `rims_warehouse` (`id`, `code`, `name`, `description`, `status`) VALUES
(1, 'B01-W01', 'Warehouse1', 'Testing', 'Inactive'),
(2, 'B02-W02', 'Warehouse 2', 'Testing2', 'Active'),
(3, 'B03-W03', 'Warehouse 3', 'Testing', 'Active'),
(4, 'B04-W04', 'Warehouse 4', 'Testing', 'Active'),
(5, 'B05-W05', 'Warehouse 5', 'Testing', 'Active'),
(6, 'B06-W06', 'Warehouse 6', 'Testing', 'Active'),
(7, 'B07-W07', 'Warehouse 7', 'Testing', 'Active'),
(8, 'B08-W08', 'Warehouse 8', 'Testing2', 'Active'),
(9, 'B08-W09', 'Warehouse 9', 'Testing', 'Active'),
(10, 'B03-W03', 'Warehouse 10', 'Testing2', 'Active'),
(11, 'B03-W03', '365421', 'Testing2', 'Active'),
(12, 'B01-W07', 'Warehouse B-7', 'Testing', 'Active'),
(13, 'W-R1-01', 'Warehouse - GR', 'General Repair Warehouse', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_warehouse_division`
--

CREATE TABLE IF NOT EXISTS `rims_warehouse_division` (
`id` int(11) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_warehouse_division`
--

INSERT INTO `rims_warehouse_division` (`id`, `warehouse_id`, `division_id`) VALUES
(3, 1, 4),
(4, 1, 5),
(1, 5, 1),
(2, 10, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rims_bank`
--
ALTER TABLE `rims_bank`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_branch`
--
ALTER TABLE `rims_branch`
 ADD PRIMARY KEY (`id`), ADD KEY `province_id` (`province_id`), ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `rims_branch_fax`
--
ALTER TABLE `rims_branch_fax`
 ADD PRIMARY KEY (`id`), ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `rims_branch_phone`
--
ALTER TABLE `rims_branch_phone`
 ADD PRIMARY KEY (`id`), ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `rims_branch_warehouse`
--
ALTER TABLE `rims_branch_warehouse`
 ADD PRIMARY KEY (`id`), ADD KEY `warehouse_id` (`warehouse_id`), ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `rims_chasis_code`
--
ALTER TABLE `rims_chasis_code`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_city`
--
ALTER TABLE `rims_city`
 ADD PRIMARY KEY (`id`), ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `rims_colors`
--
ALTER TABLE `rims_colors`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_customer`
--
ALTER TABLE `rims_customer`
 ADD PRIMARY KEY (`id`), ADD KEY `province_id` (`province_id`), ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `rims_customer_mobile`
--
ALTER TABLE `rims_customer_mobile`
 ADD PRIMARY KEY (`id`), ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `rims_customer_phone`
--
ALTER TABLE `rims_customer_phone`
 ADD PRIMARY KEY (`id`), ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `rims_customer_pic`
--
ALTER TABLE `rims_customer_pic`
 ADD PRIMARY KEY (`id`), ADD KEY `province_id` (`province_id`), ADD KEY `city_id` (`city_id`), ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `rims_customer_pic_mobile`
--
ALTER TABLE `rims_customer_pic_mobile`
 ADD PRIMARY KEY (`id`), ADD KEY `customer_pic_id` (`customer_pic_id`);

--
-- Indexes for table `rims_customer_pic_phone`
--
ALTER TABLE `rims_customer_pic_phone`
 ADD PRIMARY KEY (`id`), ADD KEY `customer_pic_id` (`customer_pic_id`);

--
-- Indexes for table `rims_customer_service_rate`
--
ALTER TABLE `rims_customer_service_rate`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_deduction`
--
ALTER TABLE `rims_deduction`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_division`
--
ALTER TABLE `rims_division`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_division_branch`
--
ALTER TABLE `rims_division_branch`
 ADD PRIMARY KEY (`id`), ADD KEY `division_id` (`division_id`), ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `rims_division_position`
--
ALTER TABLE `rims_division_position`
 ADD PRIMARY KEY (`id`), ADD KEY `position_id` (`position_id`), ADD KEY `division_id` (`division_id`);

--
-- Indexes for table `rims_employee`
--
ALTER TABLE `rims_employee`
 ADD PRIMARY KEY (`id`), ADD KEY `province_id` (`province_id`), ADD KEY `city_id` (`city_id`), ADD KEY `home_city` (`home_city`), ADD KEY `home_province` (`home_province`);

--
-- Indexes for table `rims_employee_bank`
--
ALTER TABLE `rims_employee_bank`
 ADD PRIMARY KEY (`id`), ADD KEY `bank_id` (`bank_id`,`employee_id`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `rims_employee_deductions`
--
ALTER TABLE `rims_employee_deductions`
 ADD PRIMARY KEY (`id`), ADD KEY `employee_id` (`employee_id`), ADD KEY `deduction_id` (`deduction_id`);

--
-- Indexes for table `rims_employee_division_position_level`
--
ALTER TABLE `rims_employee_division_position_level`
 ADD PRIMARY KEY (`id`), ADD KEY `employee_id` (`employee_id`), ADD KEY `division_id` (`division_id`), ADD KEY `position_id` (`position_id`), ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `rims_employee_incentives`
--
ALTER TABLE `rims_employee_incentives`
 ADD PRIMARY KEY (`id`), ADD KEY `employee_id` (`employee_id`), ADD KEY `incentive_id` (`incentive_id`);

--
-- Indexes for table `rims_employee_mobile`
--
ALTER TABLE `rims_employee_mobile`
 ADD PRIMARY KEY (`id`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `rims_employee_phone`
--
ALTER TABLE `rims_employee_phone`
 ADD PRIMARY KEY (`id`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `rims_incentive`
--
ALTER TABLE `rims_incentive`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_level`
--
ALTER TABLE `rims_level`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_onvetrains`
--
ALTER TABLE `rims_onvetrains`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_position`
--
ALTER TABLE `rims_position`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_position_level`
--
ALTER TABLE `rims_position_level`
 ADD PRIMARY KEY (`id`), ADD KEY `level_id` (`level_id`), ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `rims_powercc`
--
ALTER TABLE `rims_powercc`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_product`
--
ALTER TABLE `rims_product`
 ADD PRIMARY KEY (`id`), ADD KEY `product_master_category_id` (`product_master_category_id`), ADD KEY `product_sub_master_category_id` (`product_sub_master_category_id`), ADD KEY `product_sub_category_id` (`product_sub_category_id`), ADD KEY `product_type_id` (`product_specification_type_id`), ADD KEY `car_make_id` (`vehicle_car_make_id`), ADD KEY `car_model_id` (`vehicle_car_model_id`);

--
-- Indexes for table `rims_product_master_category`
--
ALTER TABLE `rims_product_master_category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_product_specification_info`
--
ALTER TABLE `rims_product_specification_info`
 ADD PRIMARY KEY (`id`), ADD KEY `product_specification_type_id` (`product_specification_type_id`);

--
-- Indexes for table `rims_product_specification_type`
--
ALTER TABLE `rims_product_specification_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_product_sub_category`
--
ALTER TABLE `rims_product_sub_category`
 ADD PRIMARY KEY (`id`), ADD KEY `product_sub_master_category_id` (`product_sub_master_category_id`), ADD KEY `product_master_category` (`product_master_category`);

--
-- Indexes for table `rims_product_sub_master_category`
--
ALTER TABLE `rims_product_sub_master_category`
 ADD PRIMARY KEY (`id`), ADD KEY `product_category_id` (`product_master_category_id`);

--
-- Indexes for table `rims_province`
--
ALTER TABLE `rims_province`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_section`
--
ALTER TABLE `rims_section`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_section_detail`
--
ALTER TABLE `rims_section_detail`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_supplier`
--
ALTER TABLE `rims_supplier`
 ADD PRIMARY KEY (`id`), ADD KEY `province_id` (`province_id`), ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `rims_supplier_bank`
--
ALTER TABLE `rims_supplier_bank`
 ADD PRIMARY KEY (`id`), ADD KEY `bank_id` (`bank_id`,`supplier_id`), ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `rims_supplier_mobile`
--
ALTER TABLE `rims_supplier_mobile`
 ADD PRIMARY KEY (`id`), ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `rims_supplier_phone`
--
ALTER TABLE `rims_supplier_phone`
 ADD PRIMARY KEY (`id`), ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `rims_supplier_pic`
--
ALTER TABLE `rims_supplier_pic`
 ADD PRIMARY KEY (`id`), ADD KEY `supplier_id` (`supplier_id`), ADD KEY `city_id` (`city_id`), ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `rims_supplier_pic_mobile`
--
ALTER TABLE `rims_supplier_pic_mobile`
 ADD PRIMARY KEY (`id`), ADD KEY `supplier_pic_id` (`supplier_pic_id`);

--
-- Indexes for table `rims_supplier_pic_phone`
--
ALTER TABLE `rims_supplier_pic_phone`
 ADD PRIMARY KEY (`id`), ADD KEY `supplier_pic_id` (`supplier_pic_id`);

--
-- Indexes for table `rims_unit`
--
ALTER TABLE `rims_unit`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_vehicle`
--
ALTER TABLE `rims_vehicle`
 ADD PRIMARY KEY (`id`), ADD KEY `customer_id` (`customer_id`), ADD KEY `customer_pic_id` (`customer_pic_id`), ADD KEY `car_make_id` (`car_make_id`), ADD KEY `car_model_id` (`car_model_id`), ADD KEY `car_sub_model_id` (`car_sub_model_id`);

--
-- Indexes for table `rims_vehicle_car_make`
--
ALTER TABLE `rims_vehicle_car_make`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_vehicle_car_model`
--
ALTER TABLE `rims_vehicle_car_model`
 ADD PRIMARY KEY (`id`), ADD KEY `car_make_id` (`car_make_id`), ADD KEY `car_make_id_2` (`car_make_id`);

--
-- Indexes for table `rims_vehicle_car_sub_detail`
--
ALTER TABLE `rims_vehicle_car_sub_detail`
 ADD PRIMARY KEY (`id`), ADD KEY `brand_id` (`brand_id`), ADD KEY `brand_id_2` (`brand_id`), ADD KEY `chasis_id` (`chasis_id`), ADD KEY `chasis_id_2` (`chasis_id`), ADD KEY `brand_id_3` (`brand_id`), ADD KEY `sub_brand_id` (`sub_brand_id`), ADD KEY `chasis_id_3` (`chasis_id`), ADD KEY `chasis_id_4` (`chasis_id`), ADD KEY `chasis_id_5` (`chasis_id`), ADD KEY `chasis_id_6` (`chasis_id`);

--
-- Indexes for table `rims_warehouse`
--
ALTER TABLE `rims_warehouse`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_warehouse_division`
--
ALTER TABLE `rims_warehouse_division`
 ADD PRIMARY KEY (`id`), ADD KEY `warehouse_id` (`warehouse_id`,`division_id`), ADD KEY `division_id` (`division_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rims_bank`
--
ALTER TABLE `rims_bank`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `rims_branch`
--
ALTER TABLE `rims_branch`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `rims_branch_fax`
--
ALTER TABLE `rims_branch_fax`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_branch_phone`
--
ALTER TABLE `rims_branch_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_branch_warehouse`
--
ALTER TABLE `rims_branch_warehouse`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `rims_chasis_code`
--
ALTER TABLE `rims_chasis_code`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_city`
--
ALTER TABLE `rims_city`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `rims_colors`
--
ALTER TABLE `rims_colors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rims_customer`
--
ALTER TABLE `rims_customer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `rims_customer_mobile`
--
ALTER TABLE `rims_customer_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_customer_phone`
--
ALTER TABLE `rims_customer_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rims_customer_pic`
--
ALTER TABLE `rims_customer_pic`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_customer_pic_mobile`
--
ALTER TABLE `rims_customer_pic_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_customer_pic_phone`
--
ALTER TABLE `rims_customer_pic_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_customer_service_rate`
--
ALTER TABLE `rims_customer_service_rate`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_deduction`
--
ALTER TABLE `rims_deduction`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rims_division`
--
ALTER TABLE `rims_division`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rims_division_branch`
--
ALTER TABLE `rims_division_branch`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `rims_division_position`
--
ALTER TABLE `rims_division_position`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rims_employee`
--
ALTER TABLE `rims_employee`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `rims_employee_bank`
--
ALTER TABLE `rims_employee_bank`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rims_employee_deductions`
--
ALTER TABLE `rims_employee_deductions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rims_employee_division_position_level`
--
ALTER TABLE `rims_employee_division_position_level`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_employee_incentives`
--
ALTER TABLE `rims_employee_incentives`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rims_employee_mobile`
--
ALTER TABLE `rims_employee_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_employee_phone`
--
ALTER TABLE `rims_employee_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_incentive`
--
ALTER TABLE `rims_incentive`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rims_level`
--
ALTER TABLE `rims_level`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rims_onvetrains`
--
ALTER TABLE `rims_onvetrains`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_position`
--
ALTER TABLE `rims_position`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `rims_position_level`
--
ALTER TABLE `rims_position_level`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rims_powercc`
--
ALTER TABLE `rims_powercc`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_product`
--
ALTER TABLE `rims_product`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_product_master_category`
--
ALTER TABLE `rims_product_master_category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `rims_product_specification_info`
--
ALTER TABLE `rims_product_specification_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_product_specification_type`
--
ALTER TABLE `rims_product_specification_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_product_sub_category`
--
ALTER TABLE `rims_product_sub_category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1116;
--
-- AUTO_INCREMENT for table `rims_product_sub_master_category`
--
ALTER TABLE `rims_product_sub_master_category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `rims_province`
--
ALTER TABLE `rims_province`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `rims_section`
--
ALTER TABLE `rims_section`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_section_detail`
--
ALTER TABLE `rims_section_detail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_supplier`
--
ALTER TABLE `rims_supplier`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_supplier_bank`
--
ALTER TABLE `rims_supplier_bank`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `rims_supplier_mobile`
--
ALTER TABLE `rims_supplier_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rims_supplier_phone`
--
ALTER TABLE `rims_supplier_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_supplier_pic`
--
ALTER TABLE `rims_supplier_pic`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_supplier_pic_mobile`
--
ALTER TABLE `rims_supplier_pic_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_supplier_pic_phone`
--
ALTER TABLE `rims_supplier_pic_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_unit`
--
ALTER TABLE `rims_unit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rims_vehicle`
--
ALTER TABLE `rims_vehicle`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_make`
--
ALTER TABLE `rims_vehicle_car_make`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_model`
--
ALTER TABLE `rims_vehicle_car_model`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_sub_detail`
--
ALTER TABLE `rims_vehicle_car_sub_detail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rims_warehouse`
--
ALTER TABLE `rims_warehouse`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `rims_warehouse_division`
--
ALTER TABLE `rims_warehouse_division`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `rims_branch`
--
ALTER TABLE `rims_branch`
ADD CONSTRAINT `rims_branch_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `rims_province` (`id`),
ADD CONSTRAINT `rims_branch_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `rims_city` (`id`);

--
-- Constraints for table `rims_branch_fax`
--
ALTER TABLE `rims_branch_fax`
ADD CONSTRAINT `rims_branch_fax_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `rims_branch` (`id`);

--
-- Constraints for table `rims_branch_phone`
--
ALTER TABLE `rims_branch_phone`
ADD CONSTRAINT `rims_branch_phone_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `rims_branch` (`id`);

--
-- Constraints for table `rims_branch_warehouse`
--
ALTER TABLE `rims_branch_warehouse`
ADD CONSTRAINT `rims_branch_warehouse_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `rims_branch` (`id`),
ADD CONSTRAINT `rims_branch_warehouse_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `rims_warehouse` (`id`);

--
-- Constraints for table `rims_city`
--
ALTER TABLE `rims_city`
ADD CONSTRAINT `rims_city_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `rims_province` (`id`);

--
-- Constraints for table `rims_customer`
--
ALTER TABLE `rims_customer`
ADD CONSTRAINT `rims_customer_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `rims_province` (`id`),
ADD CONSTRAINT `rims_customer_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `rims_city` (`id`);

--
-- Constraints for table `rims_customer_mobile`
--
ALTER TABLE `rims_customer_mobile`
ADD CONSTRAINT `rims_customer_mobile_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `rims_customer` (`id`);

--
-- Constraints for table `rims_customer_phone`
--
ALTER TABLE `rims_customer_phone`
ADD CONSTRAINT `rims_customer_phone_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `rims_customer` (`id`);

--
-- Constraints for table `rims_customer_pic`
--
ALTER TABLE `rims_customer_pic`
ADD CONSTRAINT `rims_customer_pic_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `rims_province` (`id`),
ADD CONSTRAINT `rims_customer_pic_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `rims_city` (`id`),
ADD CONSTRAINT `rims_customer_pic_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `rims_customer` (`id`);

--
-- Constraints for table `rims_customer_pic_mobile`
--
ALTER TABLE `rims_customer_pic_mobile`
ADD CONSTRAINT `rims_customer_pic_mobile_ibfk_1` FOREIGN KEY (`customer_pic_id`) REFERENCES `rims_customer_pic` (`id`);

--
-- Constraints for table `rims_customer_pic_phone`
--
ALTER TABLE `rims_customer_pic_phone`
ADD CONSTRAINT `rims_customer_pic_phone_ibfk_1` FOREIGN KEY (`customer_pic_id`) REFERENCES `rims_customer_pic` (`id`);

--
-- Constraints for table `rims_division_branch`
--
ALTER TABLE `rims_division_branch`
ADD CONSTRAINT `rims_division_branch_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `rims_division` (`id`),
ADD CONSTRAINT `rims_division_branch_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `rims_branch` (`id`);

--
-- Constraints for table `rims_division_position`
--
ALTER TABLE `rims_division_position`
ADD CONSTRAINT `rims_division_position_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `rims_division` (`id`),
ADD CONSTRAINT `rims_division_position_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `rims_position` (`id`);

--
-- Constraints for table `rims_employee`
--
ALTER TABLE `rims_employee`
ADD CONSTRAINT `rims_employee_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `rims_province` (`id`),
ADD CONSTRAINT `rims_employee_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `rims_city` (`id`),
ADD CONSTRAINT `rims_employee_ibfk_3` FOREIGN KEY (`home_province`) REFERENCES `rims_province` (`id`),
ADD CONSTRAINT `rims_employee_ibfk_4` FOREIGN KEY (`home_city`) REFERENCES `rims_city` (`id`);

--
-- Constraints for table `rims_employee_bank`
--
ALTER TABLE `rims_employee_bank`
ADD CONSTRAINT `rims_employee_bank_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `rims_bank` (`id`),
ADD CONSTRAINT `rims_employee_bank_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`);

--
-- Constraints for table `rims_employee_deductions`
--
ALTER TABLE `rims_employee_deductions`
ADD CONSTRAINT `rims_employee_deductions_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`),
ADD CONSTRAINT `rims_employee_deductions_ibfk_2` FOREIGN KEY (`deduction_id`) REFERENCES `rims_deduction` (`id`);

--
-- Constraints for table `rims_employee_division_position_level`
--
ALTER TABLE `rims_employee_division_position_level`
ADD CONSTRAINT `rims_employee_division_position_level_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`),
ADD CONSTRAINT `rims_employee_division_position_level_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `rims_division` (`id`),
ADD CONSTRAINT `rims_employee_division_position_level_ibfk_3` FOREIGN KEY (`position_id`) REFERENCES `rims_position` (`id`),
ADD CONSTRAINT `rims_employee_division_position_level_ibfk_4` FOREIGN KEY (`level_id`) REFERENCES `rims_level` (`id`);

--
-- Constraints for table `rims_employee_incentives`
--
ALTER TABLE `rims_employee_incentives`
ADD CONSTRAINT `rims_employee_incentives_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`),
ADD CONSTRAINT `rims_employee_incentives_ibfk_2` FOREIGN KEY (`incentive_id`) REFERENCES `rims_incentive` (`id`);

--
-- Constraints for table `rims_employee_mobile`
--
ALTER TABLE `rims_employee_mobile`
ADD CONSTRAINT `rims_employee_mobile_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`);

--
-- Constraints for table `rims_employee_phone`
--
ALTER TABLE `rims_employee_phone`
ADD CONSTRAINT `rims_employee_phone_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`);

--
-- Constraints for table `rims_position_level`
--
ALTER TABLE `rims_position_level`
ADD CONSTRAINT `rims_position_level_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `rims_position` (`id`),
ADD CONSTRAINT `rims_position_level_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `rims_level` (`id`);

--
-- Constraints for table `rims_product`
--
ALTER TABLE `rims_product`
ADD CONSTRAINT `rims_product_ibfk_1` FOREIGN KEY (`product_master_category_id`) REFERENCES `rims_product_master_category` (`id`),
ADD CONSTRAINT `rims_product_ibfk_2` FOREIGN KEY (`product_sub_master_category_id`) REFERENCES `rims_product_sub_master_category` (`id`),
ADD CONSTRAINT `rims_product_ibfk_3` FOREIGN KEY (`product_sub_category_id`) REFERENCES `rims_product_sub_category` (`id`),
ADD CONSTRAINT `rims_product_ibfk_4` FOREIGN KEY (`product_specification_type_id`) REFERENCES `rims_product_specification_type` (`id`),
ADD CONSTRAINT `rims_product_ibfk_5` FOREIGN KEY (`vehicle_car_make_id`) REFERENCES `rims_vehicle_car_make` (`id`),
ADD CONSTRAINT `rims_product_ibfk_6` FOREIGN KEY (`vehicle_car_model_id`) REFERENCES `rims_vehicle_car_model` (`id`);

--
-- Constraints for table `rims_product_specification_info`
--
ALTER TABLE `rims_product_specification_info`
ADD CONSTRAINT `rims_product_specification_info_ibfk_1` FOREIGN KEY (`product_specification_type_id`) REFERENCES `rims_product_specification_type` (`id`);

--
-- Constraints for table `rims_product_sub_category`
--
ALTER TABLE `rims_product_sub_category`
ADD CONSTRAINT `rims_product_sub_category_ibfk_1` FOREIGN KEY (`product_sub_master_category_id`) REFERENCES `rims_product_sub_master_category` (`id`),
ADD CONSTRAINT `rims_product_sub_category_ibfk_2` FOREIGN KEY (`product_master_category`) REFERENCES `rims_product_master_category` (`id`);

--
-- Constraints for table `rims_product_sub_master_category`
--
ALTER TABLE `rims_product_sub_master_category`
ADD CONSTRAINT `rims_product_sub_master_category_ibfk_1` FOREIGN KEY (`product_master_category_id`) REFERENCES `rims_product_master_category` (`id`);

--
-- Constraints for table `rims_supplier`
--
ALTER TABLE `rims_supplier`
ADD CONSTRAINT `rims_supplier_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `rims_province` (`id`),
ADD CONSTRAINT `rims_supplier_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `rims_city` (`id`);

--
-- Constraints for table `rims_supplier_bank`
--
ALTER TABLE `rims_supplier_bank`
ADD CONSTRAINT `rims_supplier_bank_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `rims_bank` (`id`),
ADD CONSTRAINT `rims_supplier_bank_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `rims_supplier` (`id`);

--
-- Constraints for table `rims_supplier_mobile`
--
ALTER TABLE `rims_supplier_mobile`
ADD CONSTRAINT `rims_supplier_mobile_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `rims_supplier` (`id`);

--
-- Constraints for table `rims_supplier_phone`
--
ALTER TABLE `rims_supplier_phone`
ADD CONSTRAINT `rims_supplier_phone_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `rims_supplier` (`id`);

--
-- Constraints for table `rims_supplier_pic`
--
ALTER TABLE `rims_supplier_pic`
ADD CONSTRAINT `rims_supplier_pic_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `rims_supplier` (`id`),
ADD CONSTRAINT `rims_supplier_pic_ibfk_2` FOREIGN KEY (`province_id`) REFERENCES `rims_province` (`id`),
ADD CONSTRAINT `rims_supplier_pic_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `rims_city` (`id`);

--
-- Constraints for table `rims_supplier_pic_mobile`
--
ALTER TABLE `rims_supplier_pic_mobile`
ADD CONSTRAINT `rims_supplier_pic_mobile_ibfk_1` FOREIGN KEY (`supplier_pic_id`) REFERENCES `rims_supplier_pic` (`id`);

--
-- Constraints for table `rims_supplier_pic_phone`
--
ALTER TABLE `rims_supplier_pic_phone`
ADD CONSTRAINT `rims_supplier_pic_phone_ibfk_1` FOREIGN KEY (`supplier_pic_id`) REFERENCES `rims_supplier_pic` (`id`);

--
-- Constraints for table `rims_vehicle`
--
ALTER TABLE `rims_vehicle`
ADD CONSTRAINT `rims_vehicle_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `rims_customer` (`id`),
ADD CONSTRAINT `rims_vehicle_ibfk_2` FOREIGN KEY (`customer_pic_id`) REFERENCES `rims_customer_pic` (`id`),
ADD CONSTRAINT `rims_vehicle_ibfk_3` FOREIGN KEY (`car_make_id`) REFERENCES `rims_vehicle_car_make` (`id`),
ADD CONSTRAINT `rims_vehicle_ibfk_4` FOREIGN KEY (`car_model_id`) REFERENCES `rims_vehicle_car_model` (`id`),
ADD CONSTRAINT `rims_vehicle_ibfk_5` FOREIGN KEY (`car_sub_model_id`) REFERENCES `rims_vehicle_car_sub_detail` (`id`);

--
-- Constraints for table `rims_vehicle_car_model`
--
ALTER TABLE `rims_vehicle_car_model`
ADD CONSTRAINT `rims_vehicle_car_model_ibfk_1` FOREIGN KEY (`car_make_id`) REFERENCES `rims_vehicle_car_make` (`id`);

--
-- Constraints for table `rims_vehicle_car_sub_detail`
--
ALTER TABLE `rims_vehicle_car_sub_detail`
ADD CONSTRAINT `rims_vehicle_car_sub_detail_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `rims_vehicle_car_make` (`id`),
ADD CONSTRAINT `rims_vehicle_car_sub_detail_ibfk_2` FOREIGN KEY (`sub_brand_id`) REFERENCES `rims_vehicle_car_model` (`id`);

--
-- Constraints for table `rims_warehouse_division`
--
ALTER TABLE `rims_warehouse_division`
ADD CONSTRAINT `rims_warehouse_division_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `rims_warehouse` (`id`),
ADD CONSTRAINT `rims_warehouse_division_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `rims_division` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
