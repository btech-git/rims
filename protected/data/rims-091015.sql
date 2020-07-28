-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2015 at 06:29 AM
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
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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
(8, 'B08', 'Branch 8', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'rere@gmail.com', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_branch_warehouse`
--

CREATE TABLE IF NOT EXISTS `rims_branch_warehouse` (
`id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_chasis_code`
--

CREATE TABLE IF NOT EXISTS `rims_chasis_code` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `tenor` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `birthdate` date NOT NULL,
  `flat_rate` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_customer`
--

INSERT INTO `rims_customer` (`id`, `name`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email`, `note`, `customer_type`, `default_payment_type`, `tenor`, `status`, `birthdate`, `flat_rate`) VALUES
(1, 'Budi', 'Jl. abc no 1234', 12, 39, '13231', '123456789', 'budi@gmail.com', 'Testing', 'Individual', 0, 30, 'Active', '0000-00-00', '0.00'),
(2, 'John Legend', 'Jl. Kebon Kacang 2', 12, 39, '12344', '', 'john@legend.co.id', '', 'Company', 0, 20, 'Active', '0000-00-00', '0.00'),
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
(28, 'Tester', 'Testing', 12, 38, '12421', '12312132131321', 'test@test.com', '', 'Individual', 1, 20, '', '1987-04-17', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_customer_mobile` (
`id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_phone`
--

CREATE TABLE IF NOT EXISTS `rims_customer_phone` (
`id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_customer_phone`
--

INSERT INTO `rims_customer_phone` (`id`, `customer_id`, `phone_no`, `status`) VALUES
(1, 22, '122212231', NULL),
(2, 28, '09281664241', 'Active'),
(3, 28, '982112122', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_pic`
--

CREATE TABLE IF NOT EXISTS `rims_customer_pic` (
`id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_division`
--

CREATE TABLE IF NOT EXISTS `rims_division` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL,
  `position_id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `sex` varchar(10) NOT NULL,
  `email` varchar(60) NOT NULL,
  `id_card` varchar(30) NOT NULL,
  `driving_licence` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `salary_type` varchar(50) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_employee`
--

INSERT INTO `rims_employee` (`id`, `name`, `local_address`, `home_address`, `province_id`, `city_id`, `sex`, `email`, `id_card`, `driving_licence`, `status`, `salary_type`, `basic_salary`, `payment_type`, `code`) VALUES
(2, 'Wati', 'Jl def no 456', '', 12, 39, 'Female', 'wati@gmail.com', '1.23141E+13', '', '', '1', '300000.00', '1', 'TESTEST'),
(3, 'Jackie', 'Jl Panjang Raya No 3', '', 12, 39, 'Male', 'test@test.com', '9019090909', '', '', 'M2', '3000000.00', '123', 'M123'),
(4, 'adi', 'grogol', '', 12, 39, 'Male', 'test@test.com', '1234', '', '', '2000000', '2000000.00', 'transfer', '1234'),
(5, 'nana', 'grogol', '', 12, 39, 'Male', 'test@test.com', '133524524', '', '', '2000000', '2000000.00', 'transfer', '45346357357'),
(6, 'dave', 'grogol', '', 12, 39, 'Male', 'test@test.com', '234534536', '', '', '2000000', '2000000.00', 'transfer', '4574746746'),
(7, 'dadi', 'grogol', '', 12, 39, 'Male', 'test@test.com', '35656', '', '', '2000000', '2000000.00', 'transfer', '54645646'),
(8, 'trans', 'grogol', '', 12, 39, 'Male', 'test@test.com', '345363', '', '', '2000000', '2000000.00', 'transfer', '4564564'),
(9, 'Nana Suryana', 'Jalan Rambutan', '', 12, 39, 'Male', 'nanasuryana@gmail.com', '365412', 'sim c', '', 'apa aja boleh', '1500000.00', 'cash', '1234'),
(10, 'Ade', 'Grogol', '', 12, 39, 'Male', 'adi@mail.com', '8968', '', '', '1', '3000000.00', 'transfer', '455'),
(11, 'Merry Febrianti', 'Jalan kenari 9 no.89', '', 12, 39, 'Female', 'merry_feb@yahoo.com', '123654789', 'sim a', '', '1', '5500000.00', '123', '1234'),
(12, 'Merry Febrianti', 'Jalan kenari 9 no.89', '', 12, 39, 'Female', 'merry_feb@yahoo.com', '123654789', 'sim a', '', '1', '5500000.00', '123', '1234'),
(13, 'Ratna', 'Grogol', '', 12, 39, 'Female', '', '80789', '', '', '2', '3000000.00', '1', '8786'),
(14, 'Frans Hariyadi', 'Jalan Kasmaran banget no.8', '', 12, 39, 'Male', 'frans_hari@gmail.com', '12987456', 'sim c', '', '1', '2500000.00', '123', '89745'),
(15, 'Cika Mariska', 'Jalan kenangan indah no.1', '', 12, 39, 'Female', 'Cika_mariska@gmail.com', '6354789645', 'sim b', '', '12', '6500000.00', '132', '2134'),
(16, 'Indah Neneng ', 'Jalan imam bonjol 6c no.47', '', 12, 39, 'Female', 'Indah@ymail.com', '1365845236', 'sim a', '', '12', '4500000.00', '231', '3214'),
(17, 'Christin Karina', 'Jalan Amin Bontang blok c no.10', '', 12, 39, 'Female', 'Christin_kar@gmail.com', '658456512', 'sim a', '', '21', '2000000.00', '132', '3215'),
(18, 'Raka Setiawan', 'Jalan S.Parman 23 no.13', '', 12, 39, 'Male', 'Raka_setiawan@ymailcom', '6.48799E+11', 'sim z', '', '12', '4000000.00', '10', '1235'),
(19, 'Adrian Irawan', 'Jalan Agus Prayitno no. 354', '', 12, 39, 'Male', 'Adrianir@yahoo.com', '5.46856E+12', 'dfsdfs', '', '12', '1000000.00', '12', '4652'),
(20, 'Agus Sugeng', 'Bandung selatan', '', 12, 39, 'Male', 'blabla@yahoo.com', '54645456', 'dfsjf', '', '12', '1256000.00', '43', '2463'),
(21, 'Barly sumanto', 'Jalan apa aja boleh', '', 12, 39, 'Male', 'sumanto@gmail.com', '12335645', 'sim z x', '', '65', '2354600.00', '2', '6795'),
(22, 'Ryan Sukamto', 'Jalan Kentang enak', '', 12, 39, 'Male', 'sukamto@yahoo.com', '21654654', 'sim z', '', '36', '1250000.00', '3', '1236');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_employee_mobile` (
`id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_phone`
--

CREATE TABLE IF NOT EXISTS `rims_employee_phone` (
`id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_incentive`
--

CREATE TABLE IF NOT EXISTS `rims_incentive` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `amount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_level`
--

CREATE TABLE IF NOT EXISTS `rims_level` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_level`
--

INSERT INTO `rims_level` (`id`, `name`, `status`) VALUES
(3, 'Junior', 'Active'),
(4, 'Senior', 'Active'),
(5, 'Intern', 'Active'),
(6, 'Head', 'Active');

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
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_position`
--

INSERT INTO `rims_position` (`id`, `name`, `status`) VALUES
(4, 'Mechanic', 'Active'),
(5, 'Manager', 'Active'),
(6, 'Service Advisor', 'Active'),
(7, 'Accounting', 'Active'),
(8, 'Finance', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_powercc`
--

CREATE TABLE IF NOT EXISTS `rims_powercc` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `date` date NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `company` varchar(30) NOT NULL,
  `position` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email_personal` int(60) NOT NULL,
  `email_company` varchar(60) NOT NULL,
  `npwp` varchar(20) NOT NULL,
  `description` varchar(60) NOT NULL,
  `tenor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_bank`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_bank` (
`id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_mobile` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_phone`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_phone` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_pic`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_pic` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL COMMENT 'foreign key from supplier table',
  `date` date NOT NULL,
  `code` int(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rims_unit`
--

INSERT INTO `rims_unit` (`id`, `name`, `status`) VALUES
(1, 'cm', 'Active'),
(2, 'kg', 'Active'),
(3, 'gram', 'Active'),
(4, 'm', 'Active'),
(5, 'litre', 'Active'),
(6, 'tons', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle` (
`id` int(11) NOT NULL,
  `plate_number` varchar(10) NOT NULL,
  `machine_number` varchar(30) NOT NULL,
  `frame_number` varchar(30) NOT NULL,
  `car_make_id` int(11) NOT NULL,
  `car_model_id` int(11) NOT NULL,
  `car_sub_model_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `year` varchar(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_pic_id` int(11) NOT NULL,
  `chasis_id` int(11) NOT NULL,
  `power_cc` int(11) NOT NULL,
  `luxury_value` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle_car_make`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle_car_make` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rims_warehouse`
--

CREATE TABLE IF NOT EXISTS `rims_warehouse` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(60) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

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
(11, 'B03-W03', '365421', 'Testing2', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_warehouse_division`
--

CREATE TABLE IF NOT EXISTS `rims_warehouse_division` (
`id` int(11) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `rims_branch_warehouse`
--
ALTER TABLE `rims_branch_warehouse`
 ADD PRIMARY KEY (`id`), ADD KEY `branch_id` (`branch_id`,`warehouse_id`), ADD KEY `warehouse_id` (`warehouse_id`);

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
 ADD PRIMARY KEY (`id`);

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
 ADD PRIMARY KEY (`id`), ADD KEY `province_id` (`province_id`), ADD KEY `city_id` (`city_id`);

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
-- Indexes for table `rims_employee`
--
ALTER TABLE `rims_employee`
 ADD PRIMARY KEY (`id`), ADD KEY `province_id` (`province_id`), ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `rims_employee_bank`
--
ALTER TABLE `rims_employee_bank`
 ADD PRIMARY KEY (`id`), ADD KEY `bank_id` (`bank_id`,`employee_id`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `rims_employee_division_position_level`
--
ALTER TABLE `rims_employee_division_position_level`
 ADD PRIMARY KEY (`id`);

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
-- Indexes for table `rims_powercc`
--
ALTER TABLE `rims_powercc`
 ADD PRIMARY KEY (`id`);

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
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_vehicle_car_make`
--
ALTER TABLE `rims_vehicle_car_make`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_vehicle_car_model`
--
ALTER TABLE `rims_vehicle_car_model`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_vehicle_car_sub_detail`
--
ALTER TABLE `rims_vehicle_car_sub_detail`
 ADD PRIMARY KEY (`id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `rims_branch_warehouse`
--
ALTER TABLE `rims_branch_warehouse`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_customer`
--
ALTER TABLE `rims_customer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `rims_customer_mobile`
--
ALTER TABLE `rims_customer_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_customer_phone`
--
ALTER TABLE `rims_customer_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rims_customer_pic`
--
ALTER TABLE `rims_customer_pic`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_division`
--
ALTER TABLE `rims_division`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_employee`
--
ALTER TABLE `rims_employee`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `rims_employee_bank`
--
ALTER TABLE `rims_employee_bank`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_employee_division_position_level`
--
ALTER TABLE `rims_employee_division_position_level`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_employee_mobile`
--
ALTER TABLE `rims_employee_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_employee_phone`
--
ALTER TABLE `rims_employee_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_incentive`
--
ALTER TABLE `rims_incentive`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_level`
--
ALTER TABLE `rims_level`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rims_onvetrains`
--
ALTER TABLE `rims_onvetrains`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_position`
--
ALTER TABLE `rims_position`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `rims_powercc`
--
ALTER TABLE `rims_powercc`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_supplier_bank`
--
ALTER TABLE `rims_supplier_bank`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_supplier_mobile`
--
ALTER TABLE `rims_supplier_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_supplier_phone`
--
ALTER TABLE `rims_supplier_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_supplier_pic`
--
ALTER TABLE `rims_supplier_pic`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rims_vehicle`
--
ALTER TABLE `rims_vehicle`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_make`
--
ALTER TABLE `rims_vehicle_car_make`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_model`
--
ALTER TABLE `rims_vehicle_car_model`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_sub_detail`
--
ALTER TABLE `rims_vehicle_car_sub_detail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_warehouse`
--
ALTER TABLE `rims_warehouse`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `rims_warehouse_division`
--
ALTER TABLE `rims_warehouse_division`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
ADD CONSTRAINT `rims_customer_pic_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `rims_city` (`id`);

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
-- Constraints for table `rims_employee`
--
ALTER TABLE `rims_employee`
ADD CONSTRAINT `rims_employee_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `rims_province` (`id`),
ADD CONSTRAINT `rims_employee_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `rims_city` (`id`);

--
-- Constraints for table `rims_employee_bank`
--
ALTER TABLE `rims_employee_bank`
ADD CONSTRAINT `rims_employee_bank_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `rims_bank` (`id`),
ADD CONSTRAINT `rims_employee_bank_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`);

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
-- Constraints for table `rims_warehouse_division`
--
ALTER TABLE `rims_warehouse_division`
ADD CONSTRAINT `rims_warehouse_division_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `rims_warehouse` (`id`),
ADD CONSTRAINT `rims_warehouse_division_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `rims_division` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
