-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2015 at 06:17 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rims4`
--

-- --------------------------------------------------------

--
-- Table structure for table `rims_bank`
--

CREATE TABLE IF NOT EXISTS `rims_bank` (
`id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` int(5) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `rims_branch`
--

INSERT INTO `rims_branch` (`id`, `code`, `name`, `address`, `province_id`, `city_id`, `zipcode`, `phone`, `fax`, `email`, `status`) VALUES
(1, 'R-1', 'Branch 1', 'TEst', 12, 39, '11460', '1234578900', '1231321312', 'test@test.com', 'Active'),
(2, 'R-2', 'Branch 2', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'bett@gmail.com', 'Active'),
(3, 'R-3', 'Branch 3', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'dindin@gmail.com', 'Active'),
(4, 'R-4', 'Branch 4', 'Bekasi', 12, 39, '10230', '261202713', '261202713', 'lolo@gmail.com', 'Active'),
(5, 'R-5', 'Branch 5', 'grogol', 12, 39, '10230', '261202713', '261202713', 'irir@gmail.com', 'Active'),
(6, 'R-6', 'Branch 6', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'keket@gmail.com', 'Active'),
(7, 'R-7', 'Branch 7', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'alal@gmail.com', 'Active'),
(8, 'R-8', 'Branch 8', 'Grogol', 12, 39, '10230', '261202713', '261202713', 'rere@gmail.com', 'Active'),
(11, 'R-11', 'Branch 12', 'Jl Asdfghk', 12, 41, '12345', '1234578900', '1231321312', 'test@test.com', 'Active'),
(12, 'R-12', 'raperind Kalimalang', 'kalimalang', 12, 41, '13450', '0218643595', '8641717', 'customerservice@raperind.com', 'Active'),
(13, 'R-', 'Branch 332', 'Jl. kopi', 12, 41, '13450', NULL, NULL, 'branch33@raperind.com', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_branch_fax`
--

CREATE TABLE IF NOT EXISTS `rims_branch_fax` (
`id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `fax_no` varchar(20) NOT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rims_branch_fax`
--

INSERT INTO `rims_branch_fax` (`id`, `branch_id`, `fax_no`, `status`) VALUES
(1, 1, '0987662123', 'Active'),
(2, 13, '0987662123', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_branch_phone`
--

CREATE TABLE IF NOT EXISTS `rims_branch_phone` (
`id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) NOT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rims_branch_phone`
--

INSERT INTO `rims_branch_phone` (`id`, `branch_id`, `phone_no`, `status`) VALUES
(1, 1, '0218881231', 'Active'),
(2, 13, '0218881231', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_branch_warehouse`
--

CREATE TABLE IF NOT EXISTS `rims_branch_warehouse` (
`id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `rims_branch_warehouse`
--

INSERT INTO `rims_branch_warehouse` (`id`, `branch_id`, `warehouse_id`) VALUES
(3, 1, 5),
(4, 1, 1),
(5, 11, 6),
(6, 1, 12),
(7, 12, 1),
(8, 12, 13),
(9, 13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `rims_brand`
--

CREATE TABLE IF NOT EXISTS `rims_brand` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rims_brand`
--

INSERT INTO `rims_brand` (`id`, `name`, `status`) VALUES
(1, 'Achilles', 'Active'),
(2, 'GS', 'Active');

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
  `car_make_id` int(11) NOT NULL,
  `car_model_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_city`
--

CREATE TABLE IF NOT EXISTS `rims_city` (
`id` int(11) NOT NULL,
  `province_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `rims_customer`
--

INSERT INTO `rims_customer` (`id`, `name`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email`, `note`, `customer_type`, `default_payment_type`, `tenor`, `status`, `birthdate`, `flat_rate`) VALUES
(1, 'Budi', 'Jl. abc no 1234', 12, 39, '13231', '123456789', 'budi@gmail.com', 'Testing', 'Individual', 0, 30, 'Active', '1989-11-01', '0.00'),
(2, 'John Legend', 'Jl. Kebon Kacang 2', 12, 39, '12344', '', 'john@legend.co.id', 'Test test test', 'Company', 0, 20, 'Active', '0000-00-00', '0.00'),
(3, 'Stefani', 'Jl. Kebon Melati', 12, 39, '12314', '1231321312', 'test@test.com', '', 'Individual', 0, 0, 'Active', '0000-00-00', '0.00'),
(4, 'Fajar', 'Jalan Aceh No 4', 12, 39, '11321', '', 'tes2t@test.com', '', 'Individual', 0, 10, 'Active', '0000-00-00', '0.00'),
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
(29, 'Newira', 'Billy Moon', 12, 41, '13450', '', '', '', 'Individual', 1, 30, '', '2015-10-08', '100000.00'),
(30, 'Tester12', 'Jl opdsfd', 12, 40, '123211', '', 'tester123@tes.com', '', 'Individual', 1, 10, 'Active', '1990-07-08', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_customer_mobile` (
`id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rims_customer_mobile`
--

INSERT INTO `rims_customer_mobile` (`id`, `customer_id`, `mobile_no`, `status`) VALUES
(1, 30, '0812341211', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_phone`
--

CREATE TABLE IF NOT EXISTS `rims_customer_phone` (
`id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rims_customer_phone`
--

INSERT INTO `rims_customer_phone` (`id`, `customer_id`, `phone_no`, `status`) VALUES
(1, 22, '122212231', NULL),
(2, 28, '09281664241', 'Active'),
(3, 28, '982112122', 'Active'),
(5, 29, '0218859852', 'Active'),
(6, 30, '0218859852', 'Active');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `rims_customer_pic`
--

INSERT INTO `rims_customer_pic` (`id`, `customer_id`, `name`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email`, `note`, `status`, `birthdate`) VALUES
(1, 1, 'Tono', 'Jl def', 12, 41, '21091', '', 'tono@gmail.com', 'Testing', 'Active', '1976-09-12'),
(2, 29, 'Andi', 'kalimalang', 13, 45, '17145', '', '', '', 'Active', '0000-00-00'),
(3, 1, 'Teddy', 'Jl abc', 12, 36, '231211', '', 'teddy@gmail.com', 'testing1234', 'Active', '1989-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_pic_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_customer_pic_mobile` (
`id` int(11) NOT NULL,
  `customer_pic_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_pic_phone`
--

CREATE TABLE IF NOT EXISTS `rims_customer_pic_phone` (
`id` int(11) NOT NULL,
  `customer_pic_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_customer_service_rate`
--

CREATE TABLE IF NOT EXISTS `rims_customer_service_rate` (
`id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_deduction`
--

CREATE TABLE IF NOT EXISTS `rims_deduction` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `amount` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `rims_division_branch`
--

INSERT INTO `rims_division_branch` (`id`, `division_id`, `branch_id`, `email`) VALUES
(1, 5, 4, ''),
(2, 5, 1, 'accounting@rapind.com'),
(3, 3, 11, ''),
(4, 1, 1, 'hr@test.com'),
(5, 2, 12, ''),
(6, 1, 12, ''),
(7, 5, 12, ''),
(8, 4, 12, ''),
(9, 3, 12, ''),
(10, 3, 1, 'gr@test.com'),
(11, 1, 13, 'hr_branch33@raperind.com');

-- --------------------------------------------------------

--
-- Table structure for table `rims_division_position`
--

CREATE TABLE IF NOT EXISTS `rims_division_position` (
`id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `rims_employee`
--

INSERT INTO `rims_employee` (`id`, `name`, `local_address`, `home_address`, `province_id`, `city_id`, `home_province`, `home_city`, `sex`, `email`, `id_card`, `driving_licence`, `status`, `salary_type`, `basic_salary`, `payment_type`, `code`) VALUES
(26, 'Test', 'Jl perdana', 'jl perdana', 12, 38, 12, 38, 'Male', 'test@test.com', '12314124123231', '79879776870334', 'Active', 'Monthly', '2000000.00', 'Transfer', 'E-26'),
(27, 'Sunar', 'Bedeng B123, Pondok Kelapa', 'Simpang 5, pati', 14, 55, 1, 1, 'Male', 's@raperind.com', '834343k3434', '34234', 'Active', 'Daily', '75000.00', 'Transfer', '1001'),
(28, 'Sunar ', 'Jl A123', 'Jl A123', 12, 42, 12, 42, 'Male', '', '12314124123231', '79879776870334', 'Active', 'Weekly', '300000.00', 'Cash', 'E-28');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `rims_employee_bank`
--

INSERT INTO `rims_employee_bank` (`id`, `bank_id`, `employee_id`, `account_no`, `account_name`, `status`) VALUES
(3, 5, 26, '123123213121', 'Ardi', 0),
(4, 7, 27, '2312', '3545345', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_branch_division_position_level`
--

CREATE TABLE IF NOT EXISTS `rims_employee_branch_division_position_level` (
`id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rims_employee_branch_division_position_level`
--

INSERT INTO `rims_employee_branch_division_position_level` (`id`, `employee_id`, `branch_id`, `division_id`, `position_id`, `level_id`, `status`) VALUES
(1, 26, 1, 1, 4, 3, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_deductions`
--

CREATE TABLE IF NOT EXISTS `rims_employee_deductions` (
`id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `deduction_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `rims_employee_deductions`
--

INSERT INTO `rims_employee_deductions` (`id`, `employee_id`, `deduction_id`, `amount`) VALUES
(1, 27, 1, '50000.00'),
(2, 27, 2, '50000.00'),
(3, 27, 3, '50000.00'),
(4, 26, 2, '330000.00');

-- --------------------------------------------------------

--
-- Table structure for table `rims_employee_incentives`
--

CREATE TABLE IF NOT EXISTS `rims_employee_incentives` (
`id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `incentive_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `rims_employee_incentives`
--

INSERT INTO `rims_employee_incentives` (`id`, `employee_id`, `incentive_id`, `amount`) VALUES
(1, 26, 4, '42000.00'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rims_employee_phone`
--

INSERT INTO `rims_employee_phone` (`id`, `employee_id`, `phone_no`, `status`) VALUES
(1, 26, '0921266616', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment`
--

CREATE TABLE IF NOT EXISTS `rims_equipment` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `maintenance_schedule` datetime NOT NULL,
  `period` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rims_equipment`
--

INSERT INTO `rims_equipment` (`id`, `name`, `purchase_date`, `maintenance_schedule`, `period`, `status`) VALUES
(1, 'Alat11', '1996-11-08 00:00:00', '2015-11-18 00:00:00', 30, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipments`
--

CREATE TABLE IF NOT EXISTS `rims_equipments` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rims_equipments`
--

INSERT INTO `rims_equipments` (`id`, `name`, `status`, `stock`) VALUES
(2, 'Equipment 1', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment_branch`
--

CREATE TABLE IF NOT EXISTS `rims_equipment_branch` (
`id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `age` int(11) NOT NULL,
  `eq_condition` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rims_equipment_branch`
--

INSERT INTO `rims_equipment_branch` (`id`, `branch_id`, `equipment_id`, `purchase_date`, `age`, `eq_condition`) VALUES
(2, 1, 2, '2015-12-01', 0, 'Good');

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment_maintenance`
--

CREATE TABLE IF NOT EXISTS `rims_equipment_maintenance` (
`id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `equipment_task_id` int(11) NOT NULL,
  `equipment_branch_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `maintenance_date` date NOT NULL,
  `next_maintenance_date` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rims_equipment_maintenance`
--

INSERT INTO `rims_equipment_maintenance` (`id`, `equipment_id`, `equipment_task_id`, `equipment_branch_id`, `employee_id`, `maintenance_date`, `next_maintenance_date`) VALUES
(2, 2, 2, 2, 26, '2015-12-04', '2015-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `rims_equipment_task`
--

CREATE TABLE IF NOT EXISTS `rims_equipment_task` (
`id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `task` varchar(100) NOT NULL,
  `check_period` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rims_equipment_task`
--

INSERT INTO `rims_equipment_task` (`id`, `equipment_id`, `task`, `check_period`) VALUES
(2, 2, 'Task 1', '40');

-- --------------------------------------------------------

--
-- Table structure for table `rims_incentive`
--

CREATE TABLE IF NOT EXISTS `rims_incentive` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `amount` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
-- Table structure for table `rims_position`
--

CREATE TABLE IF NOT EXISTS `rims_position` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product`
--

CREATE TABLE IF NOT EXISTS `rims_product` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `manufacturer_code` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `production_year` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `extension` varchar(50) NOT NULL,
  `product_master_category_id` int(11) NOT NULL,
  `product_sub_master_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) NOT NULL,
  `product_specification_type_id` int(11) DEFAULT NULL,
  `vehicle_car_make_id` int(11) DEFAULT NULL,
  `vehicle_car_model_id` int(11) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT '0.00',
  `recommended_selling_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `hpp` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT '0',
  `minimum_stock` int(11) NOT NULL,
  `margin_type` int(11) NOT NULL,
  `margin_amount` int(11) DEFAULT NULL,
  `is_usable` varchar(5) NOT NULL DEFAULT 'No',
  `status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

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
-- Table structure for table `rims_product_specification_battery`
--

CREATE TABLE IF NOT EXISTS `rims_product_specification_battery` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `parts_serial_number` varchar(30) NOT NULL,
  `sub_brand_id` int(11) NOT NULL,
  `sub_brand_series_id` int(11) NOT NULL,
  `voltage` int(11) NOT NULL,
  `amp` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text NOT NULL,
  `car_type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_specification_info`
--

CREATE TABLE IF NOT EXISTS `rims_product_specification_info` (
`id` int(11) NOT NULL,
  `product_specification_type_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_specification_oil`
--

CREATE TABLE IF NOT EXISTS `rims_product_specification_oil` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_usage` varchar(30) NOT NULL,
  `oil_type` varchar(30) NOT NULL,
  `transmission` int(11) NOT NULL,
  `code_serial` varchar(30) NOT NULL,
  `sub_brand_id` int(11) NOT NULL,
  `sub_brand_series_id` int(11) NOT NULL,
  `fuel` varchar(30) NOT NULL,
  `dot_code` int(11) NOT NULL,
  `viscosity_low_t` varchar(10) NOT NULL,
  `viscosity_high` varchar(10) NOT NULL,
  `api_code` varchar(10) NOT NULL,
  `size_measurements` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `car_use` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_specification_tire`
--

CREATE TABLE IF NOT EXISTS `rims_product_specification_tire` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `serial_number` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `sub_brand_id` int(11) NOT NULL,
  `sub_brand_series_id` int(11) NOT NULL,
  `attribute` varchar(30) NOT NULL,
  `overall_diameter` int(11) NOT NULL,
  `section_width_inches` int(11) NOT NULL,
  `section_width_mm` int(11) NOT NULL,
  `aspect_ratio` int(11) NOT NULL,
  `radial_type` varchar(5) NOT NULL,
  `rim_diameter` int(11) NOT NULL,
  `load_index` int(11) NOT NULL,
  `speed_symbol` varchar(5) NOT NULL,
  `ply_rating` int(11) NOT NULL,
  `lettering` varchar(5) NOT NULL,
  `terrain` varchar(5) NOT NULL,
  `local_import` varchar(10) NOT NULL,
  `car_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_specification_type`
--

CREATE TABLE IF NOT EXISTS `rims_product_specification_type` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_product_sub_category`
--

CREATE TABLE IF NOT EXISTS `rims_product_sub_category` (
`id` int(11) NOT NULL,
  `product_master_category_id` int(11) NOT NULL,
  `product_sub_master_category_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1115 ;

--
-- Dumping data for table `rims_product_sub_category`
--

INSERT INTO `rims_product_sub_category` (`id`, `product_master_category_id`, `product_sub_master_category_id`, `code`, `name`, `description`, `status`) VALUES
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
INSERT INTO `rims_product_sub_category` (`id`, `product_master_category_id`, `product_sub_master_category_id`, `code`, `name`, `description`, `status`) VALUES
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

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
-- Table structure for table `rims_product_vehicle`
--

CREATE TABLE IF NOT EXISTS `rims_product_vehicle` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `vehicle_car_make_id` int(11) NOT NULL,
  `vehicle_car_model_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_province`
--

CREATE TABLE IF NOT EXISTS `rims_province` (
`id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_section_detail`
--

CREATE TABLE IF NOT EXISTS `rims_section_detail` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_service`
--

CREATE TABLE IF NOT EXISTS `rims_service` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` double NOT NULL,
  `description` varchar(60) NOT NULL,
  `service_category_id` int(11) NOT NULL,
  `service_type_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `difficulty_level` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1561 ;

--
-- Dumping data for table `rims_service`
--

INSERT INTO `rims_service` (`id`, `code`, `name`, `price`, `description`, `service_category_id`, `service_type_id`, `status`, `difficulty_level`) VALUES
(1, 'GR-AC-1', 'ANTENNA ASSEMBLY WITH HOLDER R', 0, '', 1, 1, 'Active', 0),
(2, 'GR-AC-2', 'COMB:OPPOSITE SIDE ', 0, '', 1, 1, 'Active', 0),
(3, 'GR-AC-3', 'COMB:OPPOSITE SIDE ', 0, '', 1, 1, 'Active', 0),
(4, 'GR-AC-4', 'COMP WITH MagneticClutchAssy R', 0, '', 1, 1, 'Active', 0),
(5, 'GR-AC-5', 'CONDENSER ASSEMBLY R&R', 0, '', 1, 1, 'Active', 0),
(6, 'GR-AC-6', 'COOLER CONTROL SWITCH R&R', 0, '', 1, 1, 'Active', 0),
(7, 'GR-AC-7', 'COOLER CTRL SWITCH SUBASSY R&R', 0, '', 1, 1, 'Active', 0),
(8, 'GR-AC-8', 'COOLER THERMISTOR R&R', 0, '', 1, 1, 'Active', 0),
(9, 'GR-AC-9', 'COOLER UNIT ASSEMBLY R&R', 0, '', 1, 1, 'Active', 0),
(10, 'GR-AC-10', 'EVAPORATOR SUBASSEMBLY R&R', 0, '', 1, 1, 'Active', 0),
(11, 'GR-AC-11', 'EXPANSION VALVE R&R', 0, '', 1, 1, 'Active', 0),
(12, 'GR-AC-12', 'IDLER PULLEY SUBASSEMBLY R&R', 0, '', 1, 1, 'Active', 0),
(13, 'GR-AC-13', 'MAGNETIC CLUTCH ASSEMBLY R&R', 0, '', 1, 1, 'Active', 0),
(14, 'GR-AC-14', 'RADIO SPEAKER ASSY, Fr(1 Sd) R', 0, '', 1, 1, 'Active', 0),
(15, 'GR-AC-15', 'RADIO SPEAKER ASSY, Rr(1 Sd) R', 0, '', 1, 1, 'Active', 0),
(16, 'GR-AC-16', 'RADIO TUNER ASSEMBLY R&R', 0, '', 1, 1, 'Active', 0),
(17, 'GR-AC-17', 'REAR BLOWER RESISTOR R&R', 0, '', 1, 1, 'Active', 0),
(18, 'GR-AC-18', 'REAR COOLER BLOWER MOTOR R&R', 0, '', 1, 1, 'Active', 0),
(19, 'GR-AC-19', 'REAR UNIT EXPANSION VALVE R&R', 0, '', 1, 1, 'Active', 0),
(20, 'GR-AC-20', 'RECEIVER AND DRYER ASSEMBLY R&', 0, '', 1, 1, 'Active', 0),
(21, 'GR-AC-21', 'V-BELT R&R', 0, '', 1, 1, 'Active', 0),
(22, 'BR-BE-1', 'BACK-UP LIGHT SWITCH ASSY R&R', 0, '', 2, 2, 'Active', 0),
(23, 'BR-BE-2', 'BULB AND/OR SOCKET (ALL) R&R', 0, '', 2, 2, 'Active', 0),
(24, 'BR-BE-3', 'CENTER STOP LIGHT ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(25, 'BR-BE-4', 'CIGARETTE LIGHTER ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(26, 'BR-BE-5', 'COMB:ADJUST OF THE HEADLIGHT ', 0, '', 2, 2, 'Active', 0),
(27, 'BR-BE-6', 'COMBINATION METER ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(28, 'BR-BE-7', 'CourtesyLightSwitchAssy(1Sd) R', 0, '', 2, 2, 'Active', 0),
(29, 'BR-BE-8', 'DEFOGGER Rr Win SWITCH (R&R) ', 0, '', 2, 2, 'Active', 0),
(30, 'BR-BE-9', 'ENGINE TACHOMETER ASSY R&R', 0, '', 2, 2, 'Active', 0),
(31, 'BR-BE-10', 'FOG LIGHT ASSY (ONE SIDE) R&R', 0, '', 2, 2, 'Active', 0),
(32, 'BR-BE-11', 'FOG LIGHT BULB (ONE SIDE) R&R', 0, '', 2, 2, 'Active', 0),
(33, 'BR-BE-12', 'FOR 5-SPEED TRANSMISSION ', 0, '', 2, 2, 'Active', 0),
(34, 'BR-BE-13', 'Fr WIPER BLADE ASSY(BOTH Sd) R', 0, '', 2, 2, 'Active', 0),
(35, 'BR-BE-14', 'FRONT WIPER BLADE(BOTH Sd) R&R', 0, '', 2, 2, 'Active', 0),
(36, 'BR-BE-15', 'FrTurnSignalLightBulb(1 Sd) R&', 0, '', 2, 2, 'Active', 0),
(37, 'BR-BE-16', 'FUEL SENDER GAUGE ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(38, 'BR-BE-17', 'FUSIBLE LINK R&R', 0, '', 2, 2, 'Active', 0),
(39, 'BR-BE-18', 'GENERATOR REGULATOR R&R', 0, '', 2, 2, 'Active', 0),
(40, 'BR-BE-19', 'HAZARD WARNING SWITCH R&R', 0, '', 2, 2, 'Active', 0),
(41, 'BR-BE-20', 'HEADLAMP ASSEMBLY (ONE SIDE) ', 0, '', 2, 2, 'Active', 0),
(42, 'BR-BE-21', 'HEADLIGHT BULB (ONE SIDE) R&R', 0, '', 2, 2, 'Active', 0),
(43, 'BR-BE-22', 'HEADLIGHT CONTROL RELAY R&R', 0, '', 2, 2, 'Active', 0),
(44, 'BR-BE-23', 'HEADLIGHT UNIT (ONE SIDE) R&R', 0, '', 2, 2, 'Active', 0),
(45, 'BR-BE-24', 'HORN ASSEMBLY (ALL) R&R', 0, '', 2, 2, 'Active', 0),
(46, 'BR-BE-25', 'HORN RELAY ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(47, 'BR-BE-26', 'IGNITION SWITCH ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(48, 'BR-BE-27', 'INTERIOR LIGHT ASSY (ONE) R&R', 0, '', 2, 2, 'Active', 0),
(49, 'BR-BE-28', 'INTERIOR LIGHT BULB (ONE) R&R', 0, '', 2, 2, 'Active', 0),
(50, 'BR-BE-29', 'LicensePlateLightAssy(1 Sd) R&', 0, '', 2, 2, 'Active', 0),
(51, 'BR-BE-30', 'LicensePlateLightBulb(1 Sd) R&', 0, '', 2, 2, 'Active', 0),
(52, 'BR-BE-31', 'LicensePlateLightLens(1 Sd) R&', 0, '', 2, 2, 'Active', 0),
(53, 'BR-BE-32', 'LIGHT CONTROL SWITCH ASSY R&R', 0, '', 2, 2, 'Active', 0),
(54, 'BR-BE-33', 'LOCK CYLINDER SET R&R', 0, '', 2, 2, 'Active', 0),
(55, 'BR-BE-34', 'MAIN RELAY (IGNITION) R&R', 0, '', 2, 2, 'Active', 0),
(56, 'BR-BE-35', 'MAP LIGHT ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(57, 'BR-BE-36', 'METER CIRCUIT PLATE SUBASSY R&', 0, '', 2, 2, 'Active', 0),
(58, 'BR-BE-37', 'NEUTRAL START SWITCH ASSY R&R', 0, '', 2, 2, 'Active', 0),
(59, 'BR-BE-38', 'OIL PRESSURE SWITCH ASSEMBLY R', 0, '', 2, 2, 'Active', 0),
(60, 'BR-BE-39', 'OUTER MIRROR SWITCH ASSEMBLY R', 0, '', 2, 2, 'Active', 0),
(61, 'BR-BE-40', 'PARKING BRAKE SWITCH ASSY R&R', 0, '', 2, 2, 'Active', 0),
(62, 'BR-BE-41', 'PARKING CLEARANCE LAMP BULB R&', 0, '', 2, 2, 'Active', 0),
(63, 'BR-BE-42', 'Pwr Win RELAY ASSY (R&R) R&R', 0, '', 2, 2, 'Active', 0),
(64, 'BR-BE-43', 'REAR INTERIOR LIGHT ASSEMBLY R', 0, '', 2, 2, 'Active', 0),
(65, 'BR-BE-44', 'REAR INTERIOR LIGHT BULB R&R', 0, '', 2, 2, 'Active', 0),
(66, 'BR-BE-45', 'REAR WIPER BLADE ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(67, 'BR-BE-46', 'REAR WIPER MOTOR ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(68, 'BR-BE-47', 'Rr WINDS WASHER MOTOR & PUMP R', 0, '', 2, 2, 'Active', 0),
(69, 'BR-BE-48', 'Rr WINDSHIELD WASHER NOZZLE R&', 0, '', 2, 2, 'Active', 0),
(70, 'BR-BE-49', 'Rr WINDSHIELD WIPER ARM ASSY R', 0, '', 2, 2, 'Active', 0),
(71, 'BR-BE-50', 'Rr WIPER BLADE (RUBBER ONLY) R', 0, '', 2, 2, 'Active', 0),
(72, 'BR-BE-51', 'RrCombinationLightAssy(1 Sd) R', 0, '', 2, 2, 'Active', 0),
(73, 'BR-BE-52', 'RrCombinationLightBulb(1 Sd) R', 0, '', 2, 2, 'Active', 0),
(74, 'BR-BE-53', 'SdTurnSignalLightAssy(1 Sd) R&', 0, '', 2, 2, 'Active', 0),
(75, 'BR-BE-54', 'SdTurnSignalLightBulb(1 Sd) R&', 0, '', 2, 2, 'Active', 0),
(76, 'BR-BE-55', 'SdTurnSignalLightLens(1 Sd) R&', 0, '', 2, 2, 'Active', 0),
(77, 'BR-BE-56', 'SolenoidLockDoorControlRelay R', 0, '', 2, 2, 'Active', 0),
(78, 'BR-BE-57', 'STOP LIGHT SWITCH ASSEMBLY R&R', 0, '', 2, 2, 'Active', 0),
(79, 'BR-BE-58', 'TURN SIGNAL FLASHER ASSEMBLY R', 0, '', 2, 2, 'Active', 0),
(80, 'BR-BE-59', 'WINDS WASHER NOZZLE(BOTH Sd) R', 0, '', 2, 2, 'Active', 0),
(81, 'BR-BE-60', 'WINDS WIPER ARM ASSY(BothSd) R', 0, '', 2, 2, 'Active', 0),
(82, 'BR-BE-61', 'WINDSHIELD WASHER JAR CAP R&R', 0, '', 2, 2, 'Active', 0),
(83, 'BR-BE-62', 'WINDSHIELD WASHER JAR R&R', 0, '', 2, 2, 'Active', 0),
(84, 'BR-BE-63', 'WINDSHIELD WIPER LINK ASSY R&R', 0, '', 2, 2, 'Active', 0),
(85, 'BR-BE-64', 'WINDSHIELD WIPER MOTOR ASSY R&', 0, '', 2, 2, 'Active', 0),
(86, 'BR-BE-65', 'WindshieldWasherMtr AND PUMP R', 0, '', 2, 2, 'Active', 0),
(87, 'BR-BE-66', 'WIPER SWITCH ASSY R&R', 0, '', 2, 2, 'Active', 0),
(88, 'BR-BX-1', 'BACK DOOR LOCK ASSEMBLY R&R', 0, '', 3, 2, 'Active', 0),
(89, 'BR-BX-2', 'BACK DOOR PANEL SUBASSEMBLY R&', 0, '', 3, 2, 'Active', 0),
(90, 'BR-BX-3', 'BACK DOOR WEATHERSTRIP R&R', 0, '', 3, 2, 'Active', 0),
(91, 'BR-BX-4', 'BACK DOOR WINDOW GLASS R&R', 0, '', 3, 2, 'Active', 0),
(92, 'BR-BX-5', 'BACK DOORSTOPPER R&R', 0, '', 3, 2, 'Active', 0),
(93, 'BR-BX-6', 'BACK Win GLASS/WEATHERSTRIP R&', 0, '', 3, 2, 'Active', 0),
(94, 'BR-BX-7', 'BACKDOOR LOCKSTRIKER SUBASSY R', 0, '', 3, 2, 'Active', 0),
(95, 'BR-BX-8', 'BackDoorUpperHingeAssy(1 Sd) R', 0, '', 3, 2, 'Active', 0),
(96, 'BR-BX-9', 'BackDoorUpperStayAssy(1 Sd) R&', 0, '', 3, 2, 'Active', 0),
(97, 'BR-BX-10', 'COMB:OPPOSITE SIDE ', 0, '', 3, 2, 'Active', 0),
(98, 'BR-BX-11', 'COMB:OPPOSITE SIDE ', 0, '', 3, 2, 'Active', 0),
(99, 'BR-BX-12', 'COMB:OPPOSITE SIDE ', 0, '', 3, 2, 'Active', 0),
(100, 'BR-BX-13', 'COMB:OPPOSITE SIDE ', 0, '', 3, 2, 'Active', 0),
(101, 'BR-BX-14', 'COMB:OPPOSITE SIDE ', 0, '', 3, 2, 'Active', 0),
(102, 'BR-BX-15', 'COMB:OPPOSITE SIDE ', 0, '', 3, 2, 'Active', 0),
(103, 'BR-BX-16', 'COMB:OPPOSITE SIDE ', 0, '', 3, 2, 'Active', 0),
(104, 'BR-BX-17', 'COMB:OPPOSITE SIDE ', 0, '', 3, 2, 'Active', 0),
(105, 'BR-BX-18', 'DOOR LOCK CYL AND KeySetAssy R', 0, '', 3, 2, 'Active', 0),
(106, 'BR-BX-19', 'DoorLock CYL AndKeySet(1 Sd) R', 0, '', 3, 2, 'Active', 0),
(107, 'BR-BX-20', 'Fr DOOR CHECK ASSY(ONE SIDE) R', 0, '', 3, 2, 'Active', 0),
(108, 'BR-BX-21', 'Fr DOOR GLASS RUN (ONE SIDE) R', 0, '', 3, 2, 'Active', 0),
(109, 'BR-BX-22', 'Fr DOOR LOCK ASSY (ONE SIDE) R', 0, '', 3, 2, 'Active', 0),
(110, 'BR-BX-23', 'Fr DOOR MAGNET LOCK SOLENOID R', 0, '', 3, 2, 'Active', 0),
(111, 'BR-BX-24', 'Fr DOOR OUTSd HANDLE(1 Sd) R&R', 0, '', 3, 2, 'Active', 0),
(112, 'BR-BX-25', 'Fr DOOR P/W REG ASSY(1 Sd) R&R', 0, '', 3, 2, 'Active', 0),
(113, 'BR-BX-26', 'Fr DOOR PANEL SUBASSY (1 Sd) R', 0, '', 3, 2, 'Active', 0),
(114, 'BR-BX-27', 'Fr DOOR SCUFF PLATE(1 SIDE) R&', 0, '', 3, 2, 'Active', 0),
(115, 'BR-BX-28', 'Fr DOOR UP/LOW HINGE ASSY R&R', 0, '', 3, 2, 'Active', 0),
(116, 'BR-BX-29', 'Fr DOOR WinReg SUBASSY(1 Sd) R', 0, '', 3, 2, 'Active', 0),
(117, 'BR-BX-30', 'Fr DoorArmrestAssy(1 SIDE) R&R', 0, '', 3, 2, 'Active', 0),
(118, 'BR-BX-31', 'Fr FENDER LINER (ONE SIDE) R&R', 0, '', 3, 2, 'Active', 0),
(119, 'BR-BX-32', 'Fr FENDER SUBASSY (ONE SIDE) R', 0, '', 3, 2, 'Active', 0),
(120, 'BR-BX-33', 'FrDoorInSdHandleAssy(1 Sd) R&R', 0, '', 3, 2, 'Active', 0),
(121, 'BR-BX-34', 'FRONT BUMPER BAR ASSEMBLY R&R', 0, '', 3, 2, 'Active', 0),
(122, 'BR-BX-35', 'FRONT DOOR GLASS OR CHANNEL R&', 0, '', 3, 2, 'Active', 0),
(123, 'BR-BX-36', 'FRONT DOOR MAGNET LOCK ASSY R&', 0, '', 3, 2, 'Active', 0),
(124, 'BR-BX-37', 'FRONT DOOR REG HANDLE R&R', 0, '', 3, 2, 'Active', 0),
(125, 'BR-BX-38', 'FRONT DOOR TRIM PANEL ASSY R&R', 0, '', 3, 2, 'Active', 0),
(126, 'BR-BX-39', 'FRONT DOOR WEATHERSTRIP R&R', 0, '', 3, 2, 'Active', 0),
(127, 'BR-BX-40', 'FRONT INNER WEATHERSTRIP R&R', 0, '', 3, 2, 'Active', 0),
(128, 'BR-BX-41', 'FRONT OUTER WEATHERSTRIP R&R', 0, '', 3, 2, 'Active', 0),
(129, 'BR-BX-42', 'HINGE ASSEMBLY (BOTH SIDES) R&', 0, '', 3, 2, 'Active', 0),
(130, 'BR-BX-43', 'HOOD LOCK ASSEMBLY R&R', 0, '', 3, 2, 'Active', 0),
(131, 'BR-BX-44', 'HOOD LOCK CONTROL CABLE ASSY R', 0, '', 3, 2, 'Active', 0),
(132, 'BR-BX-45', 'HOOD SUBASSEMBLY R&R', 0, '', 3, 2, 'Active', 0),
(133, 'BR-BX-46', 'LuggageCompartmentDoorMark 1 R', 0, '', 3, 2, 'Active', 0),
(134, 'BR-BX-47', 'Pwr Win MASTER SWITCH ASSY R&R', 0, '', 3, 2, 'Active', 0),
(135, 'BR-BX-48', 'Pwr Win REGULATOR MOTOR REAR R', 0, '', 3, 2, 'Active', 0),
(136, 'BR-BX-49', 'PwrWin REGULATOR MOTOR FRONT R', 0, '', 3, 2, 'Active', 0),
(137, 'BR-BX-50', 'PwrWinSwitch(ForPassengerSd) R', 0, '', 3, 2, 'Active', 0),
(138, 'BR-BX-51', 'QUARTER Win GLASS (ONE SIDE) R', 0, '', 3, 2, 'Active', 0),
(139, 'BR-BX-52', 'QUARTER Win Rr WEATHERSTRIP R&', 0, '', 3, 2, 'Active', 0),
(140, 'BR-BX-53', 'RADIATOR GRILLE ASSEMBLY R&R', 0, '', 3, 2, 'Active', 0),
(141, 'BR-BX-54', 'RADIATOR GRILLE EMBLEM PLATE R', 0, '', 3, 2, 'Active', 0),
(142, 'BR-BX-55', 'REAR BODY TAIL GATE ASSEMBLY ', 0, '', 3, 2, 'Active', 0),
(143, 'BR-BX-56', 'REAR BUMPER BAR ASSEMBLY R&R', 0, '', 3, 2, 'Active', 0),
(144, 'BR-BX-57', 'REAR DOOR GLASS OR CHANNEL R&R', 0, '', 3, 2, 'Active', 0),
(145, 'BR-BX-58', 'REAR DOOR MAGNET LOCK ASSY R&R', 0, '', 3, 2, 'Active', 0),
(146, 'BR-BX-59', 'REAR DOOR QUARTER R&R', 0, '', 3, 2, 'Active', 0),
(147, 'BR-BX-60', 'REAR DOOR REG HANDLE R&R', 0, '', 3, 2, 'Active', 0),
(148, 'BR-BX-61', 'REAR DOOR TRIM PANEL R&R', 0, '', 3, 2, 'Active', 0),
(149, 'BR-BX-62', 'REAR DOOR WEATHERSTRIP R&R', 0, '', 3, 2, 'Active', 0),
(150, 'BR-BX-63', 'REAR INNER WEATHERSTRIP R&R', 0, '', 3, 2, 'Active', 0),
(151, 'BR-BX-64', 'REAR OUTER WEATHERSTRIP R&R', 0, '', 3, 2, 'Active', 0),
(152, 'BR-BX-65', 'ROOF DRIP Sd MOULD/RETAINER R&', 0, '', 3, 2, 'Active', 0),
(153, 'BR-BX-66', 'Rr DOOR GLASS RUN (ONE SIDE) R', 0, '', 3, 2, 'Active', 0),
(154, 'BR-BX-67', 'Rr DOOR LOCK ASSY (ONE SIDE) R', 0, '', 3, 2, 'Active', 0),
(155, 'BR-BX-68', 'Rr DOOR MAGNET LOCK SOLENOID R', 0, '', 3, 2, 'Active', 0),
(156, 'BR-BX-69', 'Rr DOOR P/W REG ASSY(1 Sd) R&R', 0, '', 3, 2, 'Active', 0),
(157, 'BR-BX-70', 'Rr DOOR UP/LOW HINGE ASSY R&R', 0, '', 3, 2, 'Active', 0),
(158, 'BR-BX-71', 'Rr DOOR WinReg SUBASSY(1 Sd) R', 0, '', 3, 2, 'Active', 0),
(159, 'BR-BX-72', 'Rr DoorArmrestAssy(1 SIDE) R&R', 0, '', 3, 2, 'Active', 0),
(160, 'BR-BX-73', 'RrDoor PANEL SUBASSY(1 SIDE) R', 0, '', 3, 2, 'Active', 0),
(161, 'BR-BX-74', 'RrDOOR SCUFF PLATE(ONE SIDE) R', 0, '', 3, 2, 'Active', 0),
(162, 'BR-BX-75', 'RrDoorOutSdHandleAssy(1 Sd) R&', 0, '', 3, 2, 'Active', 0),
(163, 'BR-BX-76', 'SPARE WHEEL CARRIER ASSEMBLY R', 0, '', 3, 2, 'Active', 0),
(164, 'BR-BX-77', 'TAIL GATE LOCK STRIKER(1 Sd) ', 0, '', 3, 2, 'Active', 0),
(165, 'BR-BX-78', 'WINDS GLASS/WEATHERSTRIP R&R', 0, '', 3, 2, 'Active', 0),
(166, 'BR-BX-79', 'WindshieldOutSdMoulding(All) R', 0, '', 3, 2, 'Active', 0),
(167, 'BR-BI-1', 'ACCELERATOR PEDAL R&R', 0, '', 4, 2, 'Active', 0),
(168, 'BR-BI-2', 'ACCELERATOR WIRE ASSEMBLY R&R', 0, '', 4, 2, 'Active', 0),
(169, 'BR-BI-3', 'ADD:REAR COOLING UNIT ', 0, '', 4, 2, 'Active', 0),
(170, 'BR-BI-4', 'BckWinSdGarnishCovAssy(1 Sd) R', 0, '', 4, 2, 'Active', 0),
(171, 'BR-BI-5', 'CenterPillarGarnish(1 SIDE) R&', 0, '', 4, 2, 'Active', 0),
(172, 'BR-BI-6', 'CowlSdTrimBoardSubassy(1 Sd) R', 0, '', 4, 2, 'Active', 0),
(173, 'BR-BI-7', 'FOR 3-POINT SEAT BELT ', 0, '', 4, 2, 'Active', 0),
(174, 'BR-BI-8', 'FOR 5 DOOR ', 0, '', 4, 2, 'Active', 0),
(175, 'BR-BI-9', 'FOR 5 DOOR ', 0, '', 4, 2, 'Active', 0),
(176, 'BR-BI-10', 'FOR 5 DOOR ', 0, '', 4, 2, 'Active', 0),
(177, 'BR-BI-11', 'Fr DoorOpeningTrim(1 SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(178, 'BR-BI-12', 'Fr FLOOR CARPET AND/OR MAT R&R', 0, '', 4, 2, 'Active', 0),
(179, 'BR-BI-13', 'Fr SEAT BACK ASSY (ONE SIDE) R', 0, '', 4, 2, 'Active', 0),
(180, 'BR-BI-14', 'Fr SEAT BACK COVER(ONE SIDE) R', 0, '', 4, 2, 'Active', 0),
(181, 'BR-BI-15', 'Fr SEAT CUSHION SHIELD(1 Sd) R', 0, '', 4, 2, 'Active', 0),
(182, 'BR-BI-16', 'Fr SEAT HEADREST ASSY (1 Sd) R', 0, '', 4, 2, 'Active', 0),
(183, 'BR-BI-17', 'Fr SeatCushionAssy(1 SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(184, 'BR-BI-18', 'FRONT CONSOLE BOX R&R', 0, '', 4, 2, 'Active', 0),
(185, 'BR-BI-19', 'FRONT PILLAR GARNISH ASSY R&R', 0, '', 4, 2, 'Active', 0),
(186, 'BR-BI-20', 'FRONT SEAT ASSY (ONE SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(187, 'BR-BI-21', 'FRONT SEAT BELT (ONE SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(188, 'BR-BI-22', 'FrSeat CUSHION COVER(1 SIDE) R', 0, '', 4, 2, 'Active', 0),
(189, 'BR-BI-23', 'GLOVE COMPARTMEN DOOR SUBASS R', 0, '', 4, 2, 'Active', 0),
(190, 'BR-BI-24', 'INNER REAR VIEW MIRROR ASSY R&', 0, '', 4, 2, 'Active', 0),
(191, 'BR-BI-25', 'InsPanel ASH RECEPTACLE ASSY R', 0, '', 4, 2, 'Active', 0),
(192, 'BR-BI-26', 'INSTRUMEN PANEL GARNISH ASSY R', 0, '', 4, 2, 'Active', 0),
(193, 'BR-BI-27', 'INSTRUMENT CENTER PANEL R&R', 0, '', 4, 2, 'Active', 0),
(194, 'BR-BI-28', 'INSTRUMENT CLUSTER PANEL R&R', 0, '', 4, 2, 'Active', 0),
(195, 'BR-BI-29', 'INSTRUMENT LOUVER R&R', 0, '', 4, 2, 'Active', 0),
(196, 'BR-BI-30', 'INSTRUMENT PANEL SUBASSEMBLY R', 0, '', 4, 2, 'Active', 0),
(197, 'BR-BI-31', 'LUGGAGE COMPARTMEN FLOOR MAT R', 0, '', 4, 2, 'Active', 0),
(198, 'BR-BI-32', 'OuterRrViewMirrorAssy(1 Sd) R&', 0, '', 4, 2, 'Active', 0),
(199, 'BR-BI-33', 'PASSENGER SIDE ', 0, '', 4, 2, 'Active', 0),
(200, 'BR-BI-34', 'QUARTER TRIM PanelAssy(1 Sd) R', 0, '', 4, 2, 'Active', 0),
(201, 'BR-BI-35', 'REAR CONSOLE BOX R&R', 0, '', 4, 2, 'Active', 0),
(202, 'BR-BI-36', 'REAR FLOOR CARPET AND/OR MAT R', 0, '', 4, 2, 'Active', 0),
(203, 'BR-BI-37', 'REAR FLOOR FINISH PLATE R&R', 0, '', 4, 2, 'Active', 0),
(204, 'BR-BI-38', 'REAR SEAT BELT (ONE SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(205, 'BR-BI-39', 'RECLINING SEAT ADJUSTER R&R', 0, '', 4, 2, 'Active', 0),
(206, 'BR-BI-40', 'ROOF HEADLINING ASSEMBLY R&R', 0, '', 4, 2, 'Active', 0),
(207, 'BR-BI-41', 'Rr DoorOpeningTrim(1 SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(208, 'BR-BI-42', 'Rr SEAT BACK ASSY (ONE SIDE) R', 0, '', 4, 2, 'Active', 0),
(209, 'BR-BI-43', 'Rr SEAT BACK ASSY (ONE SIDE) R', 0, '', 4, 2, 'Active', 0),
(210, 'BR-BI-44', 'Rr SEAT BACK COVER(ONE SIDE) R', 0, '', 4, 2, 'Active', 0),
(211, 'BR-BI-45', 'Rr SEAT BACK COVER(ONE SIDE) R', 0, '', 4, 2, 'Active', 0),
(212, 'BR-BI-46', 'Rr SeatCushionAssy(1 SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(213, 'BR-BI-47', 'Rr SeatCushionAssy(1 SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(214, 'BR-BI-48', 'RrSeat CUSHION COVER(1 SIDE) R', 0, '', 4, 2, 'Active', 0),
(215, 'BR-BI-49', 'RrSeat CUSHION COVER(1 SIDE) R', 0, '', 4, 2, 'Active', 0),
(216, 'BR-BI-50', 'SEAT TRACK ASSY/EQUALIZ WIRE R', 0, '', 4, 2, 'Active', 0),
(217, 'BR-BI-51', 'SIDE VENTILATOR DUCT R&R', 0, '', 4, 2, 'Active', 0),
(218, 'BR-BI-52', 'SIDE VENTILATOR LOUVER R&R', 0, '', 4, 2, 'Active', 0),
(219, 'BR-BI-53', 'VISOR ASSEMBLY(BOTH SIDE) R&R', 0, '', 4, 2, 'Active', 0),
(220, 'BR-BI-54', 'VISOR HANGER R&R', 0, '', 4, 2, 'Active', 0),
(221, 'GR-BS-1', 'BERSIHKAN RUANG BAKAR', 0, '', 6, 1, 'Active', 0),
(222, 'GR-BS-2', 'BOOSTER VACUM HOSE-GANTI', 0, '', 6, 1, 'Active', 0),
(223, 'GR-BS-3', 'BRACKET LOWER ARM FR REP', 0, '', 6, 1, 'Active', 0),
(224, 'GR-BS-4', 'BRAKE BOOSTER ASSEMBLY R&R', 0, '', 6, 1, 'Active', 0),
(225, 'GR-BS-5', 'BRAKE BOOSTER ASSY-GANTI', 0, '', 6, 1, 'Active', 0),
(226, 'GR-BS-6', 'BRAKE BOOSTER-OVERHAUL', 0, '', 6, 1, 'Active', 0),
(227, 'GR-BS-7', 'BRAKE DISC 2 RODA (BERSIHKAN)', 0, '', 6, 1, 'Active', 0),
(228, 'GR-BS-8', 'BRAKE DISC BK/PS', 0, '', 6, 1, 'Active', 0),
(229, 'GR-BS-9', 'BRAKE DISC-GANTI (1 PCS)', 0, '', 6, 1, 'Active', 0),
(230, 'GR-BS-10', 'BRAKE DISC-GANTI (2 PCS)', 0, '', 6, 1, 'Active', 0),
(231, 'GR-BS-11', 'BRAKE DRUM-GANTI (1 PCS)', 0, '', 6, 1, 'Active', 0),
(232, 'GR-BS-12', 'BRAKE DRUM-GANTI (2 PCS)', 0, '', 6, 1, 'Active', 0),
(233, 'GR-BS-13', 'BRAKE DRUM-GANTI (3 PCS)', 0, '', 6, 1, 'Active', 0),
(234, 'GR-BS-14', 'BRAKE DRUM-GANTI (4 PCS)', 0, '', 6, 1, 'Active', 0),
(235, 'GR-BS-15', 'BRAKE FLUID-BLEEDING/GANTI', 0, '', 6, 1, 'Active', 0),
(236, 'GR-BS-16', 'BRAKE HOSE-GANTI (1 PCS)', 0, '', 6, 1, 'Active', 0),
(237, 'GR-BS-17', 'BRAKE HOSE-GANTI (2 PCS)', 0, '', 6, 1, 'Active', 0),
(238, 'GR-BS-18', 'BRAKE HOSE-GANTI (3 PCS)', 0, '', 6, 1, 'Active', 0),
(239, 'GR-BS-19', 'BRAKE HOSE-GANTI (4 PCS)', 0, '', 6, 1, 'Active', 0),
(240, 'GR-BS-20', 'BRAKE OVERHAUL RR 2 PCS', 0, '', 6, 1, 'Active', 0),
(241, 'GR-BS-21', 'BRAKE OVERHAUL-3 RODA', 0, '', 6, 1, 'Active', 0),
(242, 'GR-BS-22', 'BRAKE PAD-GANTI (2 RODA)', 0, '', 6, 1, 'Active', 0),
(243, 'GR-BS-23', 'BRAKE PEDAL SUBASSEMBLY R&R', 0, '', 6, 1, 'Active', 0),
(244, 'GR-BS-24', 'BRAKE SHOE-GANTI (2 RODA)', 0, '', 6, 1, 'Active', 0),
(245, 'GR-BS-25', 'BRAKE SHOE-GANTI (4 RODA)', 0, '', 6, 1, 'Active', 0),
(246, 'GR-BS-26', 'BRAKE SWITCH LAMP-GANTI', 0, '', 6, 1, 'Active', 0),
(247, 'GR-BS-27', 'BRAKE-BERSIHKAN/CHECK (2 RODA)', 0, '', 6, 1, 'Active', 0),
(248, 'GR-BS-28', 'BRAKE-BERSIHKAN/CHECK (4 RODA)', 0, '', 6, 1, 'Active', 0),
(249, 'GR-BS-29', 'BRAKE-OVERHAUL (ALL) WITH MAST', 0, '', 6, 1, 'Active', 0),
(250, 'GR-BS-30', 'BRAKE-OVERHAUL 2 RODA', 0, '', 6, 1, 'Active', 0),
(251, 'GR-BS-31', 'BRAKE-STEL 2 RODA', 0, '', 6, 1, 'Active', 0),
(252, 'GR-BS-32', 'BRAKE-STEL 4 RODA', 0, '', 6, 1, 'Active', 0),
(253, 'GR-BS-33', 'BRAKE-STEL/BERSIHKAN (3)', 0, '', 6, 1, 'Active', 0),
(254, 'GR-BS-34', 'CALIPPER REP.KIT-GANTI (1 RODA', 0, '', 6, 1, 'Active', 0),
(255, 'GR-BS-35', 'CALIPPER REP.KIT-GANTI (2 RODA', 0, '', 6, 1, 'Active', 0),
(256, 'GR-BS-36', 'COMB:OPPOSITE SIDE ', 0, '', 6, 1, 'Active', 0),
(257, 'GR-BS-37', 'COMB:OPPOSITE SIDE ', 0, '', 6, 1, 'Active', 0),
(258, 'GR-BS-38', 'COMB:OPPOSITE SIDE ', 0, '', 6, 1, 'Active', 0),
(259, 'GR-BS-39', 'COMB:OPPOSITE SIDE ', 0, '', 6, 1, 'Active', 0),
(260, 'GR-BS-40', 'COMB:OPPOSITE SIDE ', 0, '', 6, 1, 'Active', 0),
(261, 'GR-BS-41', 'COMB:OPPOSITE SIDE ', 0, '', 6, 1, 'Active', 0),
(262, 'GR-BS-42', 'COMB:OPPOSITE SIDE ', 0, '', 6, 1, 'Active', 0),
(263, 'GR-BS-43', 'FAN + SHROUD FAN GT', 0, '', 6, 1, 'Active', 0),
(264, 'GR-BS-44', 'FLEXIBLE HOSE (Fr, ONE SIDE) R', 0, '', 6, 1, 'Active', 0),
(265, 'GR-BS-45', 'FLEXIBLE HOSE (Rr, ONE SIDE) R', 0, '', 6, 1, 'Active', 0),
(266, 'GR-BS-46', 'FOR RHD WITH A/T ', 0, '', 6, 1, 'Active', 0),
(267, 'GR-BS-47', 'FOR RHD WITH A/T AND ABS ', 0, '', 6, 1, 'Active', 0),
(268, 'GR-BS-48', 'FOR RHD WITH M/T ', 0, '', 6, 1, 'Active', 0),
(269, 'GR-BS-49', 'FOR RHD WITH M/T AND ABS ', 0, '', 6, 1, 'Active', 0),
(270, 'GR-BS-50', 'Fr DiscBrake CYL KIT(BothSd) R', 0, '', 6, 1, 'Active', 0),
(271, 'GR-BS-51', 'FrDiscBrakeCaliperAssy(1 Sd) O', 0, '', 6, 1, 'Active', 0),
(272, 'GR-BS-52', 'FrDiscBrakeCaliperAssy(1 Sd) R', 0, '', 6, 1, 'Active', 0),
(273, 'GR-BS-53', 'FRONT BRAKE PAD R&L R&R', 0, '', 6, 1, 'Active', 0),
(274, 'GR-BS-54', 'FRONT DISC (ONE SIDE) R&R', 0, '', 6, 1, 'Active', 0),
(275, 'GR-BS-55', 'HAND BRAKE CABLE-GANTI', 0, '', 6, 1, 'Active', 0),
(276, 'GR-BS-56', 'HAND BRAKE OVERHOUL', 0, '', 6, 1, 'Active', 0),
(277, 'GR-BS-57', 'HAND BRAKE SHOE-GANTI', 0, '', 6, 1, 'Active', 0),
(278, 'GR-BS-58', 'HAND BRAKE-STEL', 0, '', 6, 1, 'Active', 0),
(279, 'GR-BS-59', 'HOSE (FOR BRAKE BOOSTER) R&R', 0, '', 6, 1, 'Active', 0),
(280, 'GR-BS-60', 'KURAS MINYAK REM', 0, '', 6, 1, 'Active', 0),
(281, 'GR-BS-61', 'LOWER ARM GT', 0, '', 6, 1, 'Active', 0),
(282, 'GR-BS-62', 'MASTER CYLD. ASSY-GANTI', 0, '', 6, 1, 'Active', 0),
(283, 'GR-BS-63', 'MASTER CYLD.-OVERHAUL', 0, '', 6, 1, 'Active', 0),
(284, 'GR-BS-64', 'MASTR CYLINDER RESERVOIR SET R', 0, '', 6, 1, 'Active', 0),
(285, 'GR-BS-65', 'MST CYL RESERVOIR FILLER CAP R', 0, '', 6, 1, 'Active', 0),
(286, 'GR-BS-66', 'ParkBrakeRr CBL ASSY(BothSd) R', 0, '', 6, 1, 'Active', 0),
(287, 'GR-BS-67', 'PARKING BRAKE CABLE R&R', 0, '', 6, 1, 'Active', 0),
(288, 'GR-BS-68', 'PARKING BRAKE LEVER SUBASSY R&', 0, '', 6, 1, 'Active', 0),
(289, 'GR-BS-69', 'PEDAL ACELERATOR-GT/R', 0, '', 6, 1, 'Active', 0),
(290, 'GR-BS-70', 'PEDAL KOPLING-STELL', 0, '', 6, 1, 'Active', 0),
(291, 'GR-BS-71', 'PEDAL REM-STEL SPELING', 0, '', 6, 1, 'Active', 0),
(292, 'GR-BS-72', 'PLATE DISC BRAKE REP', 0, '', 6, 1, 'Active', 0),
(293, 'GR-BS-73', 'PROPORTION AND BYPASS VALVE R&', 0, '', 6, 1, 'Active', 0),
(294, 'GR-BS-74', 'PROPORTIONING VALVE R&R', 0, '', 6, 1, 'Active', 0),
(295, 'GR-BS-75', 'REAR BRAKE DRUM (ONE SIDE) R&R', 0, '', 6, 1, 'Active', 0),
(296, 'GR-BS-76', 'ROD BOOSTER-STEL', 0, '', 6, 1, 'Active', 0),
(297, 'GR-BS-77', 'Rr Wh CYLIND CUP KIT(BothSd) R', 0, '', 6, 1, 'Active', 0),
(298, 'GR-BS-78', 'Rr WHEEL BRAKE CYLINDER ASSY O', 0, '', 6, 1, 'Active', 0),
(299, 'GR-BS-79', 'Rr WHEEL BRAKE CYLINDER ASSY R', 0, '', 6, 1, 'Active', 0),
(300, 'GR-BS-80', 'RrBRAKE SHOE ASSY(BOTH SIDE) R', 0, '', 6, 1, 'Active', 0),
(301, 'GR-BS-81', 'RrBrakeBackPlateSbassy(1 Sd) R', 0, '', 6, 1, 'Active', 0),
(302, 'GR-BS-82', 'SEAL KIT BOSTER REM (GT)', 0, '', 6, 1, 'Active', 0),
(303, 'GR-BS-83', 'SEAT FRONT SPRING-GT', 0, '', 6, 1, 'Active', 0),
(304, 'GR-BS-84', 'SEAT REAR SPRING-REP/GT', 0, '', 6, 1, 'Active', 0),
(305, 'GR-BS-85', 'SWITCH HAND BRAKE-R/GT', 0, '', 6, 1, 'Active', 0),
(306, 'GR-BS-86', 'TABUNG MINYAK REM-GANTI', 0, '', 6, 1, 'Active', 0),
(307, 'GR-BS-87', 'TANDEM MASTER CYLINDER ASSY OH', 0, '', 6, 1, 'Active', 0),
(308, 'GR-BS-88', 'TANDEM MASTER CYLINDER ASSY R&', 0, '', 6, 1, 'Active', 0),
(309, 'GR-BS-89', 'TANDEM MASTER CYLINDER KIT R&R', 0, '', 6, 1, 'Active', 0),
(310, 'GR-BS-90', 'WHEEL CYLD. ASSY-GANTI (1 RODA', 0, '', 6, 1, 'Active', 0),
(311, 'GR-BS-91', 'WHEEL CYLD. ASSY-GANTI (2 RODA', 0, '', 6, 1, 'Active', 0),
(312, 'GR-BS-92', 'WHEEL CYLD. ASSY-GANTI (3 RODA', 0, '', 6, 1, 'Active', 0),
(313, 'GR-BS-93', 'WHEEL CYLD. ASSY-GANTI (4 RODA', 0, '', 6, 1, 'Active', 0),
(314, 'GR-BS-94', 'WHEEL CYLD.-OVERHAUL (1 RODA)', 0, '', 6, 1, 'Active', 0),
(315, 'GR-BS-95', 'WHEEL CYLD.-OVERHAUL (2 RODA)', 0, '', 6, 1, 'Active', 0),
(316, 'GR-BS-96', 'WHEEL CYLD.-OVERHAUL (3 RODA)', 0, '', 6, 1, 'Active', 0),
(317, 'GR-BS-97', 'WHEEL CYLD.-OVERHAUL (4 RODA)', 0, '', 6, 1, 'Active', 0),
(318, 'GR-CL-1', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(319, 'GR-CL-2', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(320, 'GR-CL-3', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(321, 'GR-CL-4', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(322, 'GR-CL-5', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(323, 'GR-CL-6', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(324, 'GR-CL-7', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(325, 'GR-CL-8', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(326, 'GR-CL-9', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(327, 'GR-CL-10', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(328, 'GR-CL-11', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(329, 'GR-CL-12', 'ADD:AIR CONDITIONING ', 0, '', 8, 1, 'Active', 0),
(330, 'GR-CL-13', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(331, 'GR-CL-14', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(332, 'GR-CL-15', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(333, 'GR-CL-16', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(334, 'GR-CL-17', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(335, 'GR-CL-18', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(336, 'GR-CL-19', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(337, 'GR-CL-20', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(338, 'GR-CL-21', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(339, 'GR-CL-22', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(340, 'GR-CL-23', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(341, 'GR-CL-24', 'ADD:POWER STEERING ', 0, '', 8, 1, 'Active', 0),
(342, 'GR-CL-25', 'BUSHING PEDAL KOPLING-GT', 0, '', 8, 1, 'Active', 0),
(343, 'GR-CL-26', 'CENTER SUPPORT BEARING (ALL) R', 0, '', 8, 1, 'Active', 0),
(344, 'GR-CL-27', 'CLUTCH CABLE-GANTI', 0, '', 8, 1, 'Active', 0),
(345, 'GR-CL-28', 'CLUTCH COVER SUBASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(346, 'GR-CL-29', 'CLUTCH DISC ASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(347, 'GR-CL-30', 'CLUTCH FLEXIBLE HOSE-GANTI', 0, '', 8, 1, 'Active', 0),
(348, 'GR-CL-31', 'CLUTCH FLEXIBLE STER (GT)', 0, '', 8, 1, 'Active', 0),
(349, 'GR-CL-32', 'CLUTCH MASTER CYLINDER ASSY R&', 0, '', 8, 1, 'Active', 0),
(350, 'GR-CL-33', 'CLUTCH MASTER CYLINDER KIT R&R', 0, '', 8, 1, 'Active', 0),
(351, 'GR-CL-34', 'CLUTCH MASTER-GANTI/REPAIR', 0, '', 8, 1, 'Active', 0),
(352, 'GR-CL-35', 'CLUTCH OIL-GANTI/BLEEDING', 0, '', 8, 1, 'Active', 0),
(353, 'GR-CL-36', 'CLUTCH PEDAL SUBASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(354, 'GR-CL-37', 'CLUTCH PIPE/HOSE-GANTI', 0, '', 8, 1, 'Active', 0),
(355, 'GR-CL-38', 'CLUTCH RELEASE BEARING-GANTI', 0, '', 8, 1, 'Active', 0),
(356, 'GR-CL-39', 'CLUTCH RELEASE CABLE ASSY R&R', 0, '', 8, 1, 'Active', 0),
(357, 'GR-CL-40', 'CLUTCH RELEASE CYLD.-GANTI/REP', 0, '', 8, 1, 'Active', 0),
(358, 'GR-CL-41', 'CLUTCH RELEASE CYLINDER ASSY O', 0, '', 8, 1, 'Active', 0),
(359, 'GR-CL-42', 'CLUTCH RELEASE CYLINDER ASSY R', 0, '', 8, 1, 'Active', 0),
(360, 'GR-CL-43', 'CLUTCH RELEASE FORK R&R', 0, '', 8, 1, 'Active', 0),
(361, 'GR-CL-44', 'CLUTCH RELEASE FORK-GANTI', 0, '', 8, 1, 'Active', 0),
(362, 'GR-CL-45', 'COMB:CLUTCH RLS BALL BEARING ', 0, '', 8, 1, 'Active', 0),
(363, 'GR-CL-46', 'COMB:EACH ADDITIONAL SPIDER ', 0, '', 8, 1, 'Active', 0),
(364, 'GR-CL-47', 'COUNTERSHAFT AND BEARING R&R', 0, '', 8, 1, 'Active', 0),
(365, 'GR-CL-48', 'COUNTERSHAFT GEAR R&R', 0, '', 8, 1, 'Active', 0),
(366, 'GR-CL-49', 'CTRL SHIFT LEVER RET SUBASSY R', 0, '', 8, 1, 'Active', 0),
(367, 'GR-CL-50', 'DIFFERENT SIDE BEARING(ALL) R&', 0, '', 8, 1, 'Active', 0),
(368, 'GR-CL-51', 'DIFFERENTIAL CASE SUBASSY AT R', 0, '', 8, 1, 'Active', 0),
(369, 'GR-CL-52', 'DIFFERENTIAL CASE SUBASSY ML R', 0, '', 8, 1, 'Active', 0),
(370, 'GR-CL-53', 'DifferentPinionAnd/Or SdGear R', 0, '', 8, 1, 'Active', 0),
(371, 'GR-CL-54', 'DifferentPinionAnd/Or SdGear R', 0, '', 8, 1, 'Active', 0),
(372, 'GR-CL-55', 'DISC CLUTCH-OVERHAUL', 0, '', 8, 1, 'Active', 0),
(373, 'GR-CL-56', 'ENGINE MOUNTING Rr INSULATOR R', 0, '', 8, 1, 'Active', 0),
(374, 'GR-CL-57', 'EXT HOUSING OR TRANS CASE R&R', 0, '', 8, 1, 'Active', 0),
(375, 'GR-CL-58', 'EXTENSION HOUSING GASKET R&R', 0, '', 8, 1, 'Active', 0),
(376, 'GR-CL-59', 'EXTENSION HOUSING SUBASSY R&R', 0, '', 8, 1, 'Active', 0),
(377, 'GR-CL-60', 'FLEXIBLE HOSE R&R', 0, '', 8, 1, 'Active', 0),
(378, 'GR-CL-61', 'GREASE KABEL KOPLING', 0, '', 8, 1, 'Active', 0),
(379, 'GR-CL-62', 'GREASE LINK/STICK TRANMISI', 0, '', 8, 1, 'Active', 0),
(380, 'GR-CL-63', 'HEXAGON BOLT (ALL) R&R', 0, '', 8, 1, 'Active', 0),
(381, 'GR-CL-64', 'INPUT SHAFT R&R', 0, '', 8, 1, 'Active', 0),
(382, 'GR-CL-65', 'INPUT SHAFT R&R', 0, '', 8, 1, 'Active', 0),
(383, 'GR-CL-66', 'KOPLING-STEL', 0, '', 8, 1, 'Active', 0),
(384, 'GR-CL-67', 'OIL COOLER HOSE R&R', 0, '', 8, 1, 'Active', 0),
(385, 'GR-CL-68', 'OIL SEAL (FOR INPUT SHAFT) R&R', 0, '', 8, 1, 'Active', 0),
(386, 'GR-CL-69', 'OILSEAL(FOR BEARING CAPSIDE) R', 0, '', 8, 1, 'Active', 0),
(387, 'GR-CL-70', 'OILSEAL(FORBEARING RETAINER) R', 0, '', 8, 1, 'Active', 0),
(388, 'GR-CL-71', 'OUTPUT SHAFT R&R', 0, '', 8, 1, 'Active', 0),
(389, 'GR-CL-72', 'OUTPUT SHAFT R&R', 0, '', 8, 1, 'Active', 0),
(390, 'GR-CL-73', 'PAKET GANTI KOPLING', 0, '', 8, 1, 'Active', 0),
(391, 'GR-CL-74', 'PILOT BEARING-GANTI', 0, '', 8, 1, 'Active', 0),
(392, 'GR-CL-75', 'POSITION INDICATOR PLATE R&R', 0, '', 8, 1, 'Active', 0),
(393, 'GR-CL-76', 'PROP INTERM WITH CNT BEARING R', 0, '', 8, 1, 'Active', 0),
(394, 'GR-CL-77', 'SHIFT AND SELECT LEVER BOOT R&', 0, '', 8, 1, 'Active', 0),
(395, 'GR-CL-78', 'SHIFT LEVER KNOB R&R', 0, '', 8, 1, 'Active', 0),
(396, 'GR-CL-79', 'SHIFT LEVER KNOB SUBASSEMBLY R', 0, '', 8, 1, 'Active', 0),
(397, 'GR-CL-80', 'SHIFT LEVER R&R', 0, '', 8, 1, 'Active', 0),
(398, 'GR-CL-81', 'SHIFT LEVER SUBASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(399, 'GR-CL-82', 'ShiftLeverBoot AND/OR RETAIN R', 0, '', 8, 1, 'Active', 0),
(400, 'GR-CL-83', 'SPEEDOMETER DRIVE CABLE ASSY R', 0, '', 8, 1, 'Active', 0),
(401, 'GR-CL-84', 'SPEEDOMETER GEAR OR SENSOR R&R', 0, '', 8, 1, 'Active', 0),
(402, 'GR-CL-85', 'STARTER CLUCTH SUB ASSY-GT', 0, '', 8, 1, 'Active', 0),
(403, 'GR-CL-86', 'SYNCHRONIZER RING (ALL) R&R', 0, '', 8, 1, 'Active', 0),
(404, 'GR-CL-87', 'SYNCHRONIZER RING (ALL) R&R', 0, '', 8, 1, 'Active', 0),
(405, 'GR-CL-88', 'TAPERED ROLLER BEARING R&R', 0, '', 8, 1, 'Active', 0),
(406, 'GR-CL-89', 'TORQUE CONVERTER ASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(407, 'GR-CL-90', 'TORQUE CONVERTER ASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(408, 'GR-CL-91', 'TRANSAXLE ASSEMBLY OH', 0, '', 8, 1, 'Active', 0),
(409, 'GR-CL-92', 'TRANSAXLE ASSEMBLY OH', 0, '', 8, 1, 'Active', 0),
(410, 'GR-CL-93', 'TRANSAXLE ASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(411, 'GR-CL-94', 'TRANSAXLE ASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(412, 'GR-CL-95', 'TransmisionControlCableOrRod R', 0, '', 8, 1, 'Active', 0),
(413, 'GR-CL-96', 'TRANSMISSION ASSEMBLY OH', 0, '', 8, 1, 'Active', 0),
(414, 'GR-CL-97', 'TRANSMISSION ASSEMBLY OH', 0, '', 8, 1, 'Active', 0),
(415, 'GR-CL-98', 'TRANSMISSION ASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(416, 'GR-CL-99', 'TRANSMISSION ASSEMBLY R&R', 0, '', 8, 1, 'Active', 0),
(417, 'GR-CL-100', 'TRANSMISSION CASE R&R', 0, '', 8, 1, 'Active', 0),
(418, 'GR-CL-101', 'TRANSMISSION CONTROL CABLE R&R', 0, '', 8, 1, 'Active', 0),
(419, 'GR-CL-102', 'TYPE T OIL SEAL(ForExtHouse) R', 0, '', 8, 1, 'Active', 0),
(420, 'GR-CL-103', 'TYPE T OIL SEAL(ForExtHouse) R', 0, '', 8, 1, 'Active', 0),
(421, 'GR-CL-104', 'TypeT OilSeal(ForInputShaft) R', 0, '', 8, 1, 'Active', 0),
(422, 'GR-CL-105', 'TypeTOilSeal(ForSdGearShaft) R', 0, '', 8, 1, 'Active', 0),
(423, 'GR-CL-106', 'UNIVERSAL JOINT R&R', 0, '', 8, 1, 'Active', 0),
(424, 'GR-CL-107', 'UNIVERSAL JOINT SPIDER (ONE) R', 0, '', 8, 1, 'Active', 0),
(425, 'GR-CL-108', 'VALVE BODY R&R', 0, '', 8, 1, 'Active', 0),
(426, 'GR-CS-1', 'AIR RADIATOR-KURAS', 0, '', 9, 1, 'Active', 0),
(427, 'GR-CS-2', 'ALTENATOR BEARING-GT', 0, '', 9, 1, 'Active', 0),
(428, 'GR-CS-3', 'BLADE FAN (GT)', 0, '', 9, 1, 'Active', 0),
(429, 'GR-CS-4', 'BRACKET RADIATOR-R/GT', 0, '', 9, 1, 'Active', 0),
(430, 'GR-CS-5', 'COOLING SYSTEM-CHEK/REPAIR', 0, '', 9, 1, 'Active', 0),
(431, 'GR-CS-6', 'CUP RADIATOR-GT', 0, '', 9, 1, 'Active', 0),
(432, 'GR-CS-7', 'ENGINE BONGKAR', 0, '', 9, 1, 'Active', 0),
(433, 'GR-CS-8', 'ENGINE TOP OH', 0, '', 9, 1, 'Active', 0),
(434, 'GR-CS-9', 'EXTRA FAN-GANTI', 0, '', 9, 1, 'Active', 0),
(435, 'GR-CS-10', 'FULLY WATER PUMP-R/GT', 0, '', 9, 1, 'Active', 0),
(436, 'GR-CS-11', 'GAS BUANG CHEK', 0, '', 9, 1, 'Active', 0),
(437, 'GR-CS-12', 'GASKET CUP TERMOSTAT-GT', 0, '', 9, 1, 'Active', 0),
(438, 'GR-CS-13', 'HEATER HOSE-GANTI', 0, '', 9, 1, 'Active', 0),
(439, 'GR-CS-14', 'HOSE FUEL TANK/R', 0, '', 9, 1, 'Active', 0),
(440, 'GR-CS-15', 'HOSE INLET RADIATOR/REP', 0, '', 9, 1, 'Active', 0),
(441, 'GR-CS-16', 'JARAK RADIATOR + COND./R', 0, '', 9, 1, 'Active', 0),
(442, 'GR-CS-17', 'OIL COOLER BS/PS', 0, '', 9, 1, 'Active', 0),
(443, 'GR-CS-18', 'OIL COOLER-GANTI/REPAIR', 0, '', 9, 1, 'Active', 0),
(444, 'GR-CS-19', 'PIPA AIR HORN-GT', 0, '', 9, 1, 'Active', 0),
(445, 'GR-CS-20', 'PIPA BYPASS-GANTI/REPAIR', 0, '', 9, 1, 'Active', 0),
(446, 'GR-CS-21', 'PIPA INLET WATER-GT', 0, '', 9, 1, 'Active', 0),
(447, 'GR-CS-22', 'RADIATOR HOSE ATAS-GANTI INLET', 0, '', 9, 1, 'Active', 0),
(448, 'GR-CS-23', 'RADIATOR HOSE BAWAH-GANTI OUTL', 0, '', 9, 1, 'Active', 0),
(449, 'GR-CS-24', 'RADIATOR WATER CONTROL-GANTI', 0, '', 9, 1, 'Active', 0),
(450, 'GR-CS-25', 'RADIATOR-GANTI/PERBAIKAN', 0, '', 9, 1, 'Active', 0),
(451, 'GR-CS-26', 'SERVICE RADIATOR', 0, '', 9, 1, 'Active', 0),
(452, 'GR-CS-27', 'SERVICE RADIATOR & MANGKOKAN', 0, '', 9, 1, 'Active', 0),
(453, 'GR-CS-28', 'SWITCH INJECTION PUMP', 0, '', 9, 1, 'Active', 0),
(454, 'GR-CS-29', 'TEMPERATURE METER-GANTI', 0, '', 9, 1, 'Active', 0),
(455, 'GR-CS-30', 'THERMO SWITCH-GANTI', 0, '', 9, 1, 'Active', 0),
(456, 'GR-CS-31', 'THERMOSTAT/HOUSING-GANTI', 0, '', 9, 1, 'Active', 0),
(457, 'GR-CS-32', 'UNION PIPE-GT', 0, '', 9, 1, 'Active', 0),
(458, 'GR-CS-33', 'V BELT AC.-GANTI', 0, '', 9, 1, 'Active', 0),
(459, 'GR-CS-34', 'V BELT AC.-GANTI', 0, '', 9, 1, 'Active', 0),
(460, 'GR-CS-35', 'V BELT/FAN-GANTI', 0, '', 9, 1, 'Active', 0),
(461, 'GR-CS-36', 'V BELT/FAN-GANTI', 0, '', 9, 1, 'Active', 0),
(462, 'GR-CS-37', 'VALVE THERMOTHAT-GT', 0, '', 9, 1, 'Active', 0),
(463, 'GR-CS-38', 'VAN PUMP STEER-OH/GT', 0, '', 9, 1, 'Active', 0),
(464, 'GR-CS-39', 'WATER PIPE INLET-GANTI', 0, '', 9, 1, 'Active', 0),
(465, 'GR-CS-40', 'WATER PUMP ASSY-GANTI', 0, '', 9, 1, 'Active', 0),
(466, 'GR-CS-41', 'WATER PUMP-OVERHAUL', 0, '', 9, 1, 'Active', 0),
(467, 'GR-DF-1', 'DEFERENTIAL-OVERHAUL RR', 0, '', 10, 1, 'Active', 0),
(468, 'GR-DF-2', 'DEFFERENTIAL ASSY-GANTI', 0, '', 10, 1, 'Active', 0),
(469, 'GR-DF-3', 'DEFFERENTIAL-OVERHAUL', 0, '', 10, 1, 'Active', 0),
(470, 'GR-DF-4', 'HOUSING AXLE-GANTI (1 PCS)', 0, '', 10, 1, 'Active', 0),
(471, 'GR-DF-5', 'OIL DEFERENTIAL GANTI', 0, '', 10, 1, 'Active', 0),
(472, 'GR-DF-6', 'PINION SHAFT SEAL-GANTI', 0, '', 10, 1, 'Active', 0),
(473, 'GR-DF-7', 'POWER UP (GT)', 0, '', 10, 1, 'Active', 0),
(474, 'GR-DF-8', 'PULLY ALTENATOR-GT', 0, '', 10, 1, 'Active', 0),
(475, 'GR-EF-1', 'CIRCUIT OPENING RELAY ASSY R&R', 0, '', 11, 1, 'Active', 0),
(476, 'GR-EF-2', 'COMB:BOTH ', 0, '', 11, 1, 'Active', 0),
(477, 'GR-EF-3', 'FOR DOHC ', 0, '', 11, 1, 'Active', 0),
(478, 'GR-EF-4', 'FOR DOHC ', 0, '', 11, 1, 'Active', 0),
(479, 'GR-EF-5', 'FRONT OXYGEN SENSOR (ONE) R&R', 0, '', 11, 1, 'Active', 0),
(480, 'GR-EF-6', 'FUEL INJECTION ECU ASSEMBLY R&', 0, '', 11, 1, 'Active', 0),
(481, 'GR-EF-7', 'FUEL INJECTOR ASSEMBLY (ALL) R', 0, '', 11, 1, 'Active', 0),
(482, 'GR-EF-8', 'FUEL PRESSURE REGULATOR ASSY R', 0, '', 11, 1, 'Active', 0),
(483, 'GR-EF-9', 'IDLE SPEED CONTROL VALVE R&R', 0, '', 11, 1, 'Active', 0),
(484, 'GR-EF-10', 'KNOCK CONTROL SENSOR (FRONT) R', 0, '', 11, 1, 'Active', 0),
(485, 'GR-EF-11', 'MAIN RELAY (EFI) R&R', 0, '', 11, 1, 'Active', 0),
(486, 'GR-EF-12', 'THROTTLE POSITION SENSOR R&R', 0, '', 11, 1, 'Active', 0),
(487, 'GR-EF-13', 'VACUUM SENSOR ASSEMBLY R&R', 0, '', 11, 1, 'Active', 0),
(488, 'GR-EF-14', 'WATER TEMPERATURE SENSOR R&R', 0, '', 11, 1, 'Active', 0),
(489, 'GR-EL-1', 'AC ASSY-PASANG BARU', 0, '', 12, 1, 'Active', 0),
(490, 'GR-EL-2', 'AC FREON-CHECK/TAMBAH', 0, '', 12, 1, 'Active', 0),
(491, 'GR-EL-3', 'AC SWICTH-PERBAIKI', 0, '', 12, 1, 'Active', 0),
(492, 'GR-EL-4', 'AC-PS BARU (PDC)', 0, '', 12, 1, 'Active', 0),
(493, 'GR-EL-5', 'ALTENATOR BRACKET-REP', 0, '', 12, 1, 'Active', 0),
(494, 'GR-EL-6', 'ALTENATOR BRUSH/R/GT', 0, '', 12, 1, 'Active', 0),
(495, 'GR-EL-7', 'ALTERNATOR ASSY-GANTI', 0, '', 12, 1, 'Active', 0),
(496, 'GR-EL-8', 'ALTERNATOR HOSE-GANTI/REPAIR', 0, '', 12, 1, 'Active', 0),
(497, 'GR-EL-9', 'ALTERNATOR-OVERHAUL', 0, '', 12, 1, 'Active', 0),
(498, 'GR-EL-10', 'AMPERE/VOLT METER-PASANG BARU', 0, '', 12, 1, 'Active', 0),
(499, 'GR-EL-11', 'ANTENA RADIO-GANTI', 0, '', 12, 1, 'Active', 0),
(500, 'GR-EL-12', 'BATTERY CABLE MASA-GANTI/REPAI', 0, '', 12, 1, 'Active', 0),
(501, 'GR-EL-13', 'BATTERY CABLE STARTER-GANTI/RE', 0, '', 12, 1, 'Active', 0),
(502, 'GR-EL-14', 'BATTERY-GANTI/CHARGER/STROOM', 0, '', 12, 1, 'Active', 0),
(503, 'GR-EL-15', 'BAUT ALTERNATOR-R', 0, '', 12, 1, 'Active', 0),
(504, 'GR-EL-16', 'BERSIHKAN POOL ACCU', 0, '', 12, 1, 'Active', 0),
(505, 'GR-EL-17', 'BOLB LAMP 1 PCS', 0, '', 12, 1, 'Active', 0),
(506, 'GR-EL-18', 'BOLB LAMP 2 PCS GT', 0, '', 12, 1, 'Active', 0),
(507, 'GR-EL-19', 'BOLP LAMP-GT (1PC)', 0, '', 12, 1, 'Active', 0),
(508, 'GR-EL-20', 'BOLP LAMP-GT (2PC)', 0, '', 12, 1, 'Active', 0),
(509, 'GR-EL-21', 'BRACKET AC-REPEIR/GT', 0, '', 12, 1, 'Active', 0),
(510, 'GR-EL-22', 'BRACKET COMPRESOR', 0, '', 12, 1, 'Active', 0),
(511, 'GR-EL-23', 'BRACKET SHOCK BREKER FR/RH', 0, '', 12, 1, 'Active', 0),
(512, 'GR-EL-24', 'CABIN ASSY GT', 0, '', 12, 1, 'Active', 0),
(513, 'GR-EL-25', 'CABLE AMPERE +JAM-R', 0, '', 12, 1, 'Active', 0),
(514, 'GR-EL-26', 'CABLE BATERY MASA-GT/R', 0, '', 12, 1, 'Active', 0),
(515, 'GR-EL-27', 'CABLE CENTRAL LOCK (R)', 0, '', 12, 1, 'Active', 0),
(516, 'GR-EL-28', 'CABLE COMPRESOR AC (R)', 0, '', 12, 1, 'Active', 0),
(517, 'GR-EL-29', 'CABLE CUP ENGINE-GT', 0, '', 12, 1, 'Active', 0),
(518, 'GR-EL-30', 'CABLE FUEL SENDER-REPAIR', 0, '', 12, 1, 'Active', 0),
(519, 'GR-EL-31', 'CABLE SENSOR RPM-R', 0, '', 12, 1, 'Active', 0),
(520, 'GR-EL-32', 'CABLE SLEDING RH/LH GT', 0, '', 12, 1, 'Active', 0),
(521, 'GR-EL-33', 'CABLE TURN SIGNAL SEIN R', 0, '', 12, 1, 'Active', 0),
(522, 'GR-EL-34', 'CARBURATOR REP', 0, '', 12, 1, 'Active', 0),
(523, 'GR-EL-35', 'CHARGING SYSTEM-CHECK/STEL', 0, '', 12, 1, 'Active', 0),
(524, 'GR-EL-36', 'CLOCK ELECTRICAL-GANTI', 0, '', 12, 1, 'Active', 0),
(525, 'GR-EL-37', 'COMBINATION LAMP (REAR)-GANTI', 0, '', 12, 1, 'Active', 0),
(526, 'GR-EL-38', 'COMBINATION METER ASSY-GANTI', 0, '', 12, 1, 'Active', 0),
(527, 'GR-EL-39', 'CONDENSOR AC + FREON GT', 0, '', 12, 1, 'Active', 0),
(528, 'GR-EL-40', 'DASHBORD INDICATOR LAMP-GANTI', 0, '', 12, 1, 'Active', 0),
(529, 'GR-EL-41', 'DUDUKAN BATTERY-GT', 0, '', 12, 1, 'Active', 0),
(530, 'GR-EL-42', 'ELECTRICAL SYSTEM-CHECK', 0, '', 12, 1, 'Active', 0),
(531, 'GR-EL-43', 'ENGINE CHEK', 0, '', 12, 1, 'Active', 0),
(532, 'GR-EL-44', 'ESEK-ESEK CHASIS', 0, '', 12, 1, 'Active', 0),
(533, 'GR-EL-45', 'EVAPORATOR HEATER/FAN-GANTI', 0, '', 12, 1, 'Active', 0),
(534, 'GR-EL-46', 'EXTRA FAN MOTOR AC-GT/R', 0, '', 12, 1, 'Active', 0),
(535, 'GR-EL-47', 'FAN MOTOR RADIATOR-GT', 0, '', 12, 1, 'Active', 0),
(536, 'GR-EL-48', 'FLASHER COIL-GANTI', 0, '', 12, 1, 'Active', 0),
(537, 'GR-EL-49', 'FUSE BOX GT/R', 0, '', 12, 1, 'Active', 0),
(538, 'GR-EL-50', 'FUSE BOX-GANTI', 0, '', 12, 1, 'Active', 0),
(539, 'GR-EL-51', 'FUSE ENGINE-GT', 0, '', 12, 1, 'Active', 0),
(540, 'GR-EL-52', 'FUSE FOG LAMP-GT', 0, '', 12, 1, 'Active', 0),
(541, 'GR-EL-53', 'FUSE GAUGE-GT', 0, '', 12, 1, 'Active', 0),
(542, 'GR-EL-54', 'FUSE HOUSING-R (GT)', 0, '', 12, 1, 'Active', 0),
(543, 'GR-EL-55', 'FUSEBLE LINK-GANTI/REPAIR', 0, '', 12, 1, 'Active', 0),
(544, 'GR-EL-56', 'GT/R LAMPU DISPLAY TAPE', 0, '', 12, 1, 'Active', 0),
(545, 'GR-EL-57', 'HANGER SPARE HWEEL-GT', 0, '', 12, 1, 'Active', 0),
(546, 'GR-EL-58', 'HEAD LAMP ASSY-GANTI (1 PCS)', 0, '', 12, 1, 'Active', 0),
(547, 'GR-EL-59', 'HEAD LAMP ASSY-GANTI (2 PCS)', 0, '', 12, 1, 'Active', 0),
(548, 'GR-EL-60', 'HEAD LAMP BOLB-GANTI (1 PCS)', 0, '', 12, 1, 'Active', 0),
(549, 'GR-EL-61', 'HEAD LAMP BOLB-GANTI (2 PCS)', 0, '', 12, 1, 'Active', 0),
(550, 'GR-EL-62', 'HEAD LAMP LH + FOOT STEP RH GT', 0, '', 12, 1, 'Active', 0),
(551, 'GR-EL-63', 'HEAD LAMP-STEL', 0, '', 12, 1, 'Active', 0),
(552, 'GR-EL-64', 'HORN RELAY-PASANG/ROMBAK', 0, '', 12, 1, 'Active', 0),
(553, 'GR-EL-65', 'HORN SWITCH-REPAIR', 0, '', 12, 1, 'Active', 0),
(554, 'GR-EL-66', 'HORN-GANTI/STEL (1 PCS)', 0, '', 12, 1, 'Active', 0),
(555, 'GR-EL-67', 'HOSE BLOWER AC/R', 0, '', 12, 1, 'Active', 0),
(556, 'GR-EL-68', 'IDLE ARM GANTI', 0, '', 12, 1, 'Active', 0),
(557, 'GR-EL-69', 'IGNATION SWITCH-GANTI', 0, '', 12, 1, 'Active', 0),
(558, 'GR-EL-70', 'KABEL ALARAM-REPAIR', 0, '', 12, 1, 'Active', 0),
(559, 'GR-EL-71', 'KABEL FUSE AC (R)', 0, '', 12, 1, 'Active', 0),
(560, 'GR-EL-72', 'KABEL LAMP MUNDUR-(R)', 0, '', 12, 1, 'Active', 0),
(561, 'GR-EL-73', 'KABEL LAMPU BESAR-REPAIR (1 PC', 0, '', 12, 1, 'Active', 0),
(562, 'GR-EL-74', 'KABEL LAMPU BESAR-REPAIR (2 PC', 0, '', 12, 1, 'Active', 0),
(563, 'GR-EL-75', 'KABEL LAMPU SEIN/KECIL-REPAIR ', 0, '', 12, 1, 'Active', 0),
(564, 'GR-EL-76', 'KABEL LAMPU SEIN/KECIL-REPAIR ', 0, '', 12, 1, 'Active', 0),
(565, 'GR-EL-77', 'KABEL LAMPU SEIN/KECIL-REPAIR ', 0, '', 12, 1, 'Active', 0),
(566, 'GR-EL-78', 'KABEL LAMPU SEIN/KECIL-REPAIR ', 0, '', 12, 1, 'Active', 0),
(567, 'GR-EL-79', 'KABEL LIGHTER-R', 0, '', 12, 1, 'Active', 0),
(568, 'GR-EL-80', 'KABEL MASA LAMPU SEN FR/LH', 0, '', 12, 1, 'Active', 0),
(569, 'GR-EL-81', 'KABEL RELAY EXTRAFAN RAD./R', 0, '', 12, 1, 'Active', 0),
(570, 'GR-EL-82', 'KABEL SWICTH OIL/R', 0, '', 12, 1, 'Active', 0),
(571, 'GR-EL-83', 'KABEL SWITCH KONTAK-REPAIR', 0, '', 12, 1, 'Active', 0),
(572, 'GR-EL-84', 'KABEL-KABEL REPAIR', 0, '', 12, 1, 'Active', 0),
(573, 'GR-EL-85', 'KEPEL LOWPRESSURE BK/PS', 0, '', 12, 1, 'Active', 0),
(574, 'GR-EL-86', 'KUNCI KONTAK-GANTI/REPAIR', 0, '', 12, 1, 'Active', 0),
(575, 'GR-EL-87', 'KURAS AIR ACCU', 0, '', 12, 1, 'Active', 0),
(576, 'GR-EL-88', 'LAMP DEPAN STEL/GT', 0, '', 12, 1, 'Active', 0),
(577, 'GR-EL-89', 'LAMPU BELAKANG-GANTI (1 PCS)', 0, '', 12, 1, 'Active', 0),
(578, 'GR-EL-90', 'LAMPU BELAKANG-GANTI (2 PCS)', 0, '', 12, 1, 'Active', 0),
(579, 'GR-EL-91', 'LAMPU BESAR-GT/STEL', 0, '', 12, 1, 'Active', 0),
(580, 'GR-EL-92', 'LAMPU DALAM-GANTI (1 PCS)', 0, '', 12, 1, 'Active', 0),
(581, 'GR-EL-93', 'LAMPU DALAM-GANTI (2 PCS)', 0, '', 12, 1, 'Active', 0),
(582, 'GR-EL-94', 'LAMPU HALOGEN & RELAY-MEROMBAK', 0, '', 12, 1, 'Active', 0),
(583, 'GR-EL-95', 'LAMPU INDICATOR BRAKE (R)', 0, '', 12, 1, 'Active', 0),
(584, 'GR-EL-96', 'LAMPU KABUT & RELAY-GANTI BARU', 0, '', 12, 1, 'Active', 0),
(585, 'GR-EL-97', 'LAMPU KECIL DEPAN/BLK-REPAIR (', 0, '', 12, 1, 'Active', 0),
(586, 'GR-EL-98', 'LAMPU KECIL DEPAN/BLK-REPAIR (', 0, '', 12, 1, 'Active', 0),
(587, 'GR-EL-99', 'LAMPU KECIL DEPAN/SAMPING-GANT', 0, '', 12, 1, 'Active', 0),
(588, 'GR-EL-100', 'LAMPU KECIL DEPAN/SAMPING-GANT', 0, '', 12, 1, 'Active', 0),
(589, 'GR-EL-101', 'LAMPU R.TAPE-REP', 0, '', 12, 1, 'Active', 0),
(590, 'GR-EL-102', 'LIGHTER-GANTI', 0, '', 12, 1, 'Active', 0),
(591, 'GR-EL-103', 'LOCK ASSY-GANTI', 0, '', 12, 1, 'Active', 0),
(592, 'GR-EL-104', 'METER-2 (COMBINATION)-GANTI', 0, '', 12, 1, 'Active', 0),
(593, 'GR-EL-105', 'MIKA LAMP FR /RR-GT', 0, '', 12, 1, 'Active', 0),
(594, 'GR-EL-106', 'MOTOR BLOWER AC-GANTI/REPAIR', 0, '', 12, 1, 'Active', 0),
(595, 'GR-EL-107', 'MOTOR EXTRA FAN AC-GT', 0, '', 12, 1, 'Active', 0),
(596, 'GR-EL-108', 'MOTOR LOCK RELAY-GANTI', 0, '', 12, 1, 'Active', 0),
(597, 'GR-EL-109', 'MOTOR LOCK SWITCH-GANTI', 0, '', 12, 1, 'Active', 0),
(598, 'GR-EL-110', 'MOTOR LOCK-GANTI (1 PINTU)', 0, '', 12, 1, 'Active', 0),
(599, 'GR-EL-111', 'MOTOR LOCK-GANTI (2 PINTU)', 0, '', 12, 1, 'Active', 0),
(600, 'GR-EL-112', 'MOTOR LOCK-GANTI (3 PINTU)', 0, '', 12, 1, 'Active', 0),
(601, 'GR-EL-113', 'MOTOR LOCK-GANTI (4 PINTU)', 0, '', 12, 1, 'Active', 0),
(602, 'GR-EL-114', 'MOTOR STATER-BK/PS', 0, '', 12, 1, 'Active', 0),
(603, 'GR-EL-115', 'ODOMETER-STEL', 0, '', 12, 1, 'Active', 0),
(604, 'GR-EL-116', 'OIL PRESSURE SWITCH-GANTI', 0, '', 12, 1, 'Active', 0),
(605, 'GR-EL-117', 'PLUG BODY BAG.FR/LH', 0, '', 12, 1, 'Active', 0),
(606, 'GR-EL-118', 'POOL ACCU BERSIHKAN/GT', 0, '', 12, 1, 'Active', 0),
(607, 'GR-EL-119', 'POWER WINDOW MOTOR-GANTI (1 PI', 0, '', 12, 1, 'Active', 0),
(608, 'GR-EL-120', 'POWER WINDOW MOTOR-GANTI (2 PI', 0, '', 12, 1, 'Active', 0),
(609, 'GR-EL-121', 'POWER WINDOW MOTOR-GANTI (3 PI', 0, '', 12, 1, 'Active', 0),
(610, 'GR-EL-122', 'POWER WINDOW MOTOR-GANTI (4 PI', 0, '', 12, 1, 'Active', 0),
(611, 'GR-EL-123', 'POWER WINDOW MT. RELAY-GANTI', 0, '', 12, 1, 'Active', 0),
(612, 'GR-EL-124', 'POWER WINDOW MT. SWITCH-GANTI', 0, '', 12, 1, 'Active', 0),
(613, 'GR-EL-125', 'RADIO TAPE SERVICE', 0, '', 12, 1, 'Active', 0),
(614, 'GR-EL-126', 'RADIO TAPE-GANTI', 0, '', 12, 1, 'Active', 0),
(615, 'GR-EL-127', 'RELAY HEAD LAMP-REPAIR/GT', 0, '', 12, 1, 'Active', 0),
(616, 'GR-EL-128', 'RELAY HORN R/GT', 0, '', 12, 1, 'Active', 0),
(617, 'GR-EL-129', 'RELAY/SWITCH (ACCESORIS)-GANTI', 0, '', 12, 1, 'Active', 0),
(618, 'GR-EL-130', 'REPAIR HORNESS RELAY FOG LAMP', 0, '', 12, 1, 'Active', 0),
(619, 'GR-EL-131', 'RPM-STEL', 0, '', 12, 1, 'Active', 0),
(620, 'GR-EL-132', 'SILER LAMP FR/LH', 0, '', 12, 1, 'Active', 0),
(621, 'GR-EL-133', 'SLANG INLET-GT', 0, '', 12, 1, 'Active', 0),
(622, 'GR-EL-134', 'SOCKET-SOCKET-REPAIR', 0, '', 12, 1, 'Active', 0),
(623, 'GR-EL-135', 'SPEAKER RADIO-GANTI', 0, '', 12, 1, 'Active', 0),
(624, 'GR-EL-136', 'STATER MOTOR ASSY-GANTI', 0, '', 12, 1, 'Active', 0),
(625, 'GR-EL-137', 'STATER MOTOR RELAY-GANTI', 0, '', 12, 1, 'Active', 0),
(626, 'GR-EL-138', 'STATER MOTOR SWITCH-GANTI', 0, '', 12, 1, 'Active', 0),
(627, 'GR-EL-139', 'STATER MOTOR-OVERHAUL', 0, '', 12, 1, 'Active', 0),
(628, 'GR-EL-140', 'STICKER PASANG', 0, '', 12, 1, 'Active', 0),
(629, 'GR-EL-141', 'STOPER BAN SEREP (4PC)', 0, '', 12, 1, 'Active', 0),
(630, 'GR-EL-142', 'STOPER CUP ENGINE-GT', 0, '', 12, 1, 'Active', 0),
(631, 'GR-EL-143', 'SUPORT RAD. UPER/ASSY-CAT/GT', 0, '', 12, 1, 'Active', 0),
(632, 'GR-EL-144', 'SUPORT RADIATOR R/L CAT GT', 0, '', 12, 1, 'Active', 0),
(633, 'GR-EL-145', 'SWICHT TEMP.ENGINE/OIL-GT', 0, '', 12, 1, 'Active', 0),
(634, 'GR-EL-146', 'SWITCH LAMP STOP-GANTI', 0, '', 12, 1, 'Active', 0),
(635, 'GR-EL-147', 'SWITCH POWER WINDOW-R(GT)', 0, '', 12, 1, 'Active', 0),
(636, 'GR-EL-148', 'TEMPERATUR SWITCH-GANTI', 0, '', 12, 1, 'Active', 0),
(637, 'GR-EL-149', 'TENANAN BAN', 0, '', 12, 1, 'Active', 0),
(638, 'GR-EL-150', 'TENSIONER AC BEARING-GANTI/REP', 0, '', 12, 1, 'Active', 0),
(639, 'GR-EL-151', 'TURN SIGNAL SWITCH ASSY-GANTI', 0, '', 12, 1, 'Active', 0),
(640, 'GR-EL-152', 'TURN SIGNAL SWITCH-OVERHAUL', 0, '', 12, 1, 'Active', 0),
(641, 'GR-EL-153', 'TURUN MESIN + REPAIR CHASIS', 0, '', 12, 1, 'Active', 0),
(642, 'GR-EL-154', 'TUTUP BENSIN-REP', 0, '', 12, 1, 'Active', 0),
(643, 'GR-EL-155', 'VOLTAGE REGULATOR-GANTI/STEL', 0, '', 12, 1, 'Active', 0),
(644, 'GR-EL-156', 'VSV IDLE UP AC-REPAIR', 0, '', 12, 1, 'Active', 0),
(645, 'GR-EL-157', 'WIFER BLADE/ARM-GT (2PC)', 0, '', 12, 1, 'Active', 0),
(646, 'GR-EL-158', 'WIPER BLADE/ARM-GANTI', 0, '', 12, 1, 'Active', 0),
(647, 'GR-EL-159', 'WIPER LINK-GANTI/STEL (1PC)', 0, '', 12, 1, 'Active', 0),
(648, 'GR-EL-160', 'WIPER MOTOR (F/R)-OVERHAUL', 0, '', 12, 1, 'Active', 0),
(649, 'GR-EL-161', 'WIPER MOTOR ASSY (F/R)-GANTI', 0, '', 12, 1, 'Active', 0),
(650, 'GR-EL-162', 'WIPER MOTOR PUMP (F/R)-GANTI', 0, '', 12, 1, 'Active', 0),
(651, 'GR-EL-163', 'WIPER MOTOR RELAY-GANTI', 0, '', 12, 1, 'Active', 0),
(652, 'GR-EL-164', 'WIPER NOZZLE (F/R)-GANTI', 0, '', 12, 1, 'Active', 0),
(653, 'GR-EL-165', 'WIPER NOZZLE-STEL', 0, '', 12, 1, 'Active', 0),
(654, 'GR-EL-166', 'WIRING HARNES FRONT-GANTI', 0, '', 12, 1, 'Active', 0),
(655, 'GR-EL-167', 'WIRING HARNES REAR-GANTI', 0, '', 12, 1, 'Active', 0),
(656, 'GR-EN-1', '(FOR PISTON PIN, ALL) R&R', 0, '', 13, 1, 'Active', 0),
(657, 'GR-EN-2', 'ADD:AIR CONDITIONING ', 0, '', 13, 1, 'Active', 0),
(658, 'GR-EN-3', 'ADD:POWER STEERING ', 0, '', 13, 1, 'Active', 0),
(659, 'GR-EN-4', 'AIR CLEANER ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(660, 'GR-EN-5', 'AIR CLEANER CAP SUBASSEMBLY R&', 0, '', 13, 1, 'Active', 0),
(661, 'GR-EN-6', 'AIR CLEANER FILTER ELEMENT R&R', 0, '', 13, 1, 'Active', 0),
(662, 'GR-EN-7', 'AIR CLEANER-CHECK/GANTI', 0, '', 13, 1, 'Active', 0),
(663, 'GR-EN-8', 'ALTERNATOR ASSEMBLY OH', 0, '', 13, 1, 'Active', 0),
(664, 'GR-EN-9', 'ALTERNATOR ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(665, 'GR-EN-10', 'ALTERNATOR BEARING R&R', 0, '', 13, 1, 'Active', 0),
(666, 'GR-EN-11', 'BATTERY CHARGE', 0, '', 13, 1, 'Active', 0),
(667, 'GR-EN-12', 'BATTERY R&R', 0, '', 13, 1, 'Active', 0),
(668, 'GR-EN-13', 'BATTERY TO GROUND CABLE R&R', 0, '', 13, 1, 'Active', 0),
(669, 'GR-EN-14', 'BATTERY TO STARTER CABLE R&R', 0, '', 13, 1, 'Active', 0),
(670, 'GR-EN-15', 'BRAKET OIL FILTER GASKET-GANTI', 0, '', 13, 1, 'Active', 0),
(671, 'GR-EN-16', 'BUSI-CHECK/GANTI', 0, '', 13, 1, 'Active', 0),
(672, 'GR-EN-17', 'CAM POSITION SENSOR R&R', 0, '', 13, 1, 'Active', 0),
(673, 'GR-EN-18', 'CAM SHAFT SEAL-GANTI', 0, '', 13, 1, 'Active', 0),
(674, 'GR-EN-19', 'CAM SHAFT-GANTI', 0, '', 13, 1, 'Active', 0),
(675, 'GR-EN-20', 'CAMSHAFT (ALL) R&R', 0, '', 13, 1, 'Active', 0),
(676, 'GR-EN-21', 'CAMSHAFT TIMING GEAR R&R', 0, '', 13, 1, 'Active', 0),
(677, 'GR-EN-22', 'CARBURATOR ASSY-GANTI', 0, '', 13, 1, 'Active', 0),
(678, 'GR-EN-23', 'CARBURATOR-OVERHAUL/INJECTION-', 0, '', 13, 1, 'Active', 0),
(679, 'GR-EN-24', 'CARTER GASKET-GANTI', 0, '', 13, 1, 'Active', 0),
(680, 'GR-EN-25', 'ChainNo1 OrBeltTensionerAssy R', 0, '', 13, 1, 'Active', 0),
(681, 'GR-EN-26', 'CHARCOAL CANISTER R&R', 0, '', 13, 1, 'Active', 0),
(682, 'GR-EN-27', 'COMB:BATTERY TEST', 0, '', 13, 1, 'Active', 0),
(683, 'GR-EN-28', 'COMB:REUSED PISTON CLEAN', 0, '', 13, 1, 'Active', 0),
(684, 'GR-EN-29', 'COMB:STARTER BUSHING ', 0, '', 13, 1, 'Active', 0),
(685, 'GR-EN-30', 'COMB:STARTER BUSHING R&R', 0, '', 13, 1, 'Active', 0),
(686, 'GR-EN-31', 'COMB:STARTER CLUTCH SUBASSY ', 0, '', 13, 1, 'Active', 0),
(687, 'GR-EN-32', 'COMB:STARTER FIELD COIL ', 0, '', 13, 1, 'Active', 0),
(688, 'GR-EN-33', 'CONNECTING ROD BEARING (ALL) R', 0, '', 13, 1, 'Active', 0),
(689, 'GR-EN-34', 'COOLING SYSTEM-CHECK', 0, '', 13, 1, 'Active', 0),
(690, 'GR-EN-35', 'COOLINGFAN MTR AND/OR SHROUD R', 0, '', 13, 1, 'Active', 0),
(691, 'GR-EN-36', 'COVER TIMING BELT-GT', 0, '', 13, 1, 'Active', 0),
(692, 'GR-EN-37', 'CRANK SHAFT SEAL FRONT-GANTI', 0, '', 13, 1, 'Active', 0),
(693, 'GR-EN-38', 'CRANK SHAFT SEAL REAR-GANTI', 0, '', 13, 1, 'Active', 0),
(694, 'GR-EN-39', 'CRANKCASE VENTILATION VALVE R&', 0, '', 13, 1, 'Active', 0),
(695, 'GR-EN-40', 'CRANKSHAFT AND BEARING R&R', 0, '', 13, 1, 'Active', 0);
INSERT INTO `rims_service` (`id`, `code`, `name`, `price`, `description`, `service_category_id`, `service_type_id`, `status`, `difficulty_level`) VALUES
(696, 'GR-EN-41', 'CRANKSHAFT BEARING R&R', 0, '', 13, 1, 'Active', 0),
(697, 'GR-EN-42', 'CRANKSHAFT FRONT OIL SEAL R&R', 0, '', 13, 1, 'Active', 0),
(698, 'GR-EN-43', 'CRANKSHAFT PULLEY R&R', 0, '', 13, 1, 'Active', 0),
(699, 'GR-EN-44', 'CRANKSHAFT Rr OIL SEAL (ATM) R', 0, '', 13, 1, 'Active', 0),
(700, 'GR-EN-45', 'CRANKSHAFT Rr OIL SEAL (MTM) R', 0, '', 13, 1, 'Active', 0),
(701, 'GR-EN-46', 'CRANKSHAFT TIMING GEAR R&R', 0, '', 13, 1, 'Active', 0),
(702, 'GR-EN-47', 'CYLD. COMPRESION-CHECK', 0, '', 13, 1, 'Active', 0),
(703, 'GR-EN-48', 'CYLD. HEAD GASKET-GANTI', 0, '', 13, 1, 'Active', 0),
(704, 'GR-EN-49', 'CYLD. HEAD-OVERHAUL (TOP O.H.)', 0, '', 13, 1, 'Active', 0),
(705, 'GR-EN-50', 'CYLINDER BLOCK SUBASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(706, 'GR-EN-51', 'CYLINDER HEAD COVER ASSEMBLY R', 0, '', 13, 1, 'Active', 0),
(707, 'GR-EN-52', 'CYLINDER HEAD COVER GASKET R&R', 0, '', 13, 1, 'Active', 0),
(708, 'GR-EN-53', 'CYLINDER HEAD GASKET R&R', 0, '', 13, 1, 'Active', 0),
(709, 'GR-EN-54', 'CYLINDER HEAD SUBASSY R&R', 0, '', 13, 1, 'Active', 0),
(710, 'GR-EN-55', 'CYLINDER HEAD-BONGKAR', 0, '', 13, 1, 'Active', 0),
(711, 'GR-EN-56', 'CYLINDER HEAD-GANTI', 0, '', 13, 1, 'Active', 0),
(712, 'GR-EN-57', 'DECK COMPRESOR /R', 0, '', 13, 1, 'Active', 0),
(713, 'GR-EN-58', 'DIST.HOUSING/SEAL-GANTI', 0, '', 13, 1, 'Active', 0),
(714, 'GR-EN-59', 'DISTRIBUTOR ASSY-GANTI', 0, '', 13, 1, 'Active', 0),
(715, 'GR-EN-60', 'DISTRIBUTOR CUP/CORD SET-GANTI', 0, '', 13, 1, 'Active', 0),
(716, 'GR-EN-61', 'DISTRIBUTOR-OVERHAUL', 0, '', 13, 1, 'Active', 0),
(717, 'GR-EN-62', 'DRIVE PLATE FOR A/T R&R', 0, '', 13, 1, 'Active', 0),
(718, 'GR-EN-63', 'ECU-GANTI/REPAIR', 0, '', 13, 1, 'Active', 0),
(719, 'GR-EN-64', 'ELECTRICAL FUEL PUMP ASSY R&R', 0, '', 13, 1, 'Active', 0),
(720, 'GR-EN-65', 'ENGINE ANALYSA', 0, '', 13, 1, 'Active', 0),
(721, 'GR-EN-66', 'ENGINE ASSEMBLY WITH CLUTCH OH', 0, '', 13, 1, 'Active', 0),
(722, 'GR-EN-67', 'ENGINE ASSEMBLY WITH CLUTCH R&', 0, '', 13, 1, 'Active', 0),
(723, 'GR-EN-68', 'ENGINE ASSY-GANTI', 0, '', 13, 1, 'Active', 0),
(724, 'GR-EN-69', 'ENGINE MOUNTING-GANTI 1 PCS', 0, '', 13, 1, 'Active', 0),
(725, 'GR-EN-70', 'ENGINE MOUNTING-GANTI 2 PCS', 0, '', 13, 1, 'Active', 0),
(726, 'GR-EN-71', 'ENGINE SHORT BLOCK-GANTI', 0, '', 13, 1, 'Active', 0),
(727, 'GR-EN-72', 'ENGINE TUNE UP', 0, '', 13, 1, 'Active', 0),
(728, 'GR-EN-73', 'ENGINE TUNE UP (KECIL)', 0, '', 13, 1, 'Active', 0),
(729, 'GR-EN-74', 'ENGINE TUNE UP (PAKET)', 0, '', 13, 1, 'Active', 0),
(730, 'GR-EN-75', 'ENGINE-BK/PS', 0, '', 13, 1, 'Active', 0),
(731, 'GR-EN-76', 'ENGINE-OVERHAUL', 0, '', 13, 1, 'Active', 0),
(732, 'GR-EN-77', 'EXHAUST FRONT PIPE SUBASSY R&R', 0, '', 13, 1, 'Active', 0),
(733, 'GR-EN-78', 'EXHAUST MANIFOLD HEAT INSR R&R', 0, '', 13, 1, 'Active', 0),
(734, 'GR-EN-79', 'EXHAUST PIPE GASKET R&R', 0, '', 13, 1, 'Active', 0),
(735, 'GR-EN-80', 'EXHAUST PIPE-GANTI', 0, '', 13, 1, 'Active', 0),
(736, 'GR-EN-81', 'ExhaustManifoldAssy(RightSd) R', 0, '', 13, 1, 'Active', 0),
(737, 'GR-EN-82', 'FAN (FOR MOTOR DRIVE) R&R', 0, '', 13, 1, 'Active', 0),
(738, 'GR-EN-83', 'FLY WHEEL GEAR-GANTI', 0, '', 13, 1, 'Active', 0),
(739, 'GR-EN-84', 'FLY WHEEL-GANTI', 0, '', 13, 1, 'Active', 0),
(740, 'GR-EN-85', 'FLYWHEEL R&R', 0, '', 13, 1, 'Active', 0),
(741, 'GR-EN-86', 'FOR DLI ', 0, '', 13, 1, 'Active', 0),
(742, 'GR-EN-87', 'FOR TWO PIECES TYPE OIL PAN ', 0, '', 13, 1, 'Active', 0),
(743, 'GR-EN-88', 'FOR TWO PIECES TYPE OIL PAN OH', 0, '', 13, 1, 'Active', 0),
(744, 'GR-EN-89', 'FOR TWO PIECES TYPE OIL PAN R&', 0, '', 13, 1, 'Active', 0),
(745, 'GR-EN-90', 'FRONT ENGINE MOUNTING R&R', 0, '', 13, 1, 'Active', 0),
(746, 'GR-EN-91', 'FUEL FILLER OPENING LID ASSY R', 0, '', 13, 1, 'Active', 0),
(747, 'GR-EN-92', 'FUEL FILTER ASSY AND SUPPORT R', 0, '', 13, 1, 'Active', 0),
(748, 'GR-EN-93', 'FUEL FILTER-CHECK/GANTI', 0, '', 13, 1, 'Active', 0),
(749, 'GR-EN-94', 'FUEL SYSTEM-BLEEDING', 0, '', 13, 1, 'Active', 0),
(750, 'GR-EN-95', 'FUEL TANK CAP ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(751, 'GR-EN-96', 'FUEL TANK SUBASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(752, 'GR-EN-97', 'GASKET EXHAUST MANIFOLD R&R', 0, '', 13, 1, 'Active', 0),
(753, 'GR-EN-98', 'GASKET FILTER OIL (GT)', 0, '', 13, 1, 'Active', 0),
(754, 'GR-EN-99', 'GLOW PLUG INDICATOR-GANTI', 0, '', 13, 1, 'Active', 0),
(755, 'GR-EN-100', 'GLOW PLUG RELAY-GANTI', 0, '', 13, 1, 'Active', 0),
(756, 'GR-EN-101', 'GLOW PLUG-GANTI', 0, '', 13, 1, 'Active', 0),
(757, 'GR-EN-102', 'HOLDER WITH RECTIFIER/BRUSH R&', 0, '', 13, 1, 'Active', 0),
(758, 'GR-EN-103', 'Hose(RadiatorReservoirTank) R&', 0, '', 13, 1, 'Active', 0),
(759, 'GR-EN-104', 'IGNATION COIL-GANTI', 0, '', 13, 1, 'Active', 0),
(760, 'GR-EN-105', 'IGNITER R&R', 0, '', 13, 1, 'Active', 0),
(761, 'GR-EN-106', 'IGNITION COIL R&R', 0, '', 13, 1, 'Active', 0),
(762, 'GR-EN-107', 'INSULATOR ENGINE-GT', 0, '', 13, 1, 'Active', 0),
(763, 'GR-EN-108', 'INTAKE MANIFOLD GASKET R&R', 0, '', 13, 1, 'Active', 0),
(764, 'GR-EN-109', 'INTAKE OR MANIFOLD ASSY R&R', 0, '', 13, 1, 'Active', 0),
(765, 'GR-EN-110', 'KABEL BUSI/CORD SET-REPAIR', 0, '', 13, 1, 'Active', 0),
(766, 'GR-EN-111', 'KOPLING-CHECK & STEL', 0, '', 13, 1, 'Active', 0),
(767, 'GR-EN-112', 'LIFTER VALVE-GANTI', 0, '', 13, 1, 'Active', 0),
(768, 'GR-EN-113', 'MANIFOLD GASKET (IN/EX)-GANTI', 0, '', 13, 1, 'Active', 0),
(769, 'GR-EN-114', 'MANIFOLD GASKET ES-GANTI', 0, '', 13, 1, 'Active', 0),
(770, 'GR-EN-115', 'MUFFLER AND/OR TAIL PIPE R&R', 0, '', 13, 1, 'Active', 0),
(771, 'GR-EN-116', 'MUFFLER ASSY-GANTI', 0, '', 13, 1, 'Active', 0),
(772, 'GR-EN-117', 'MUFFLER CENTER/FRONT-GANTI', 0, '', 13, 1, 'Active', 0),
(773, 'GR-EN-118', 'MUFFLER GASKET-GANTI', 0, '', 13, 1, 'Active', 0),
(774, 'GR-EN-119', 'MUFFLER MOUNTING/BRACKET-GANTI', 0, '', 13, 1, 'Active', 0),
(775, 'GR-EN-120', 'MUFFLER REAR-GANTI', 0, '', 13, 1, 'Active', 0),
(776, 'GR-EN-121', 'O-RING OR SUPPORT (ALL) R&R', 0, '', 13, 1, 'Active', 0),
(777, 'GR-EN-122', 'OIL DIPSTICK R&R', 0, '', 13, 1, 'Active', 0),
(778, 'GR-EN-123', 'OIL ENGINE-CHECK', 0, '', 13, 1, 'Active', 0),
(779, 'GR-EN-124', 'OIL FILLER CAP R&R', 0, '', 13, 1, 'Active', 0),
(780, 'GR-EN-125', 'OIL FILTER ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(781, 'GR-EN-126', 'OIL FILTER BRACKET SUBASSY R&R', 0, '', 13, 1, 'Active', 0),
(782, 'GR-EN-127', 'OIL PAN GASKET R&R', 0, '', 13, 1, 'Active', 0),
(783, 'GR-EN-128', 'OIL PAN SUBASSEMBLY (NO 1) R&R', 0, '', 13, 1, 'Active', 0),
(784, 'GR-EN-129', 'OIL PAN SUBASSEMBLY (NO 2) R&R', 0, '', 13, 1, 'Active', 0),
(785, 'GR-EN-130', 'OIL PUMP ASSEMBLY (OH)', 0, '', 13, 1, 'Active', 0),
(786, 'GR-EN-131', 'OIL PUMP ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(787, 'GR-EN-132', 'OIL PUMP/GASKET-GANTI/REPAIR', 0, '', 13, 1, 'Active', 0),
(788, 'GR-EN-133', 'OIL SEAL/RETAINER LOCK(ALL) R&', 0, '', 13, 1, 'Active', 0),
(789, 'GR-EN-134', 'PARTIAL ENGINE ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(790, 'GR-EN-135', 'PISTON RING SET (ALL) R&R', 0, '', 13, 1, 'Active', 0),
(791, 'GR-EN-136', 'PISTON SUBASSY WITH PIN(ALL) R', 0, '', 13, 1, 'Active', 0),
(792, 'GR-EN-137', 'PISTON/RING-GANTI TANPA O.H.', 0, '', 13, 1, 'Active', 0),
(793, 'GR-EN-138', 'PLATINA & COND.-CHECK/GANTI', 0, '', 13, 1, 'Active', 0),
(794, 'GR-EN-139', 'PLUG ENGINE PADA CYL.HEAD R/GT', 0, '', 13, 1, 'Active', 0),
(795, 'GR-EN-140', 'PLUG ENGINE-REPAIR', 0, '', 13, 1, 'Active', 0),
(796, 'GR-EN-141', 'PLUG TRANMISI (GT/R)', 0, '', 13, 1, 'Active', 0),
(797, 'GR-EN-142', 'POLE & AIR ACCU-CHECK', 0, '', 13, 1, 'Active', 0),
(798, 'GR-EN-143', 'PRESURE SENSOR-GANTI/REPAIR', 0, '', 13, 1, 'Active', 0),
(799, 'GR-EN-144', 'PULLEY CRANK SHAFT-GANTI', 0, '', 13, 1, 'Active', 0),
(800, 'GR-EN-145', 'PUSH ROAD (ALL)-GANTI', 0, '', 13, 1, 'Active', 0),
(801, 'GR-EN-146', 'RADIATOR ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(802, 'GR-EN-147', 'RADIATOR FAN RELAY R&R', 0, '', 13, 1, 'Active', 0),
(803, 'GR-EN-148', 'RADIATOR HOSE R&R', 0, '', 13, 1, 'Active', 0),
(804, 'GR-EN-149', 'RADIATOR HOSE R&R', 0, '', 13, 1, 'Active', 0),
(805, 'GR-EN-150', 'RADIATOR NO.3 HOSE R&R', 0, '', 13, 1, 'Active', 0),
(806, 'GR-EN-151', 'RADIATOR NO.4 HOSE R&R', 0, '', 13, 1, 'Active', 0),
(807, 'GR-EN-152', 'RADIATOR RESERVE TANK ASSY R&R', 0, '', 13, 1, 'Active', 0),
(808, 'GR-EN-153', 'ROCKER ARM/SHAFT-GANTI', 0, '', 13, 1, 'Active', 0),
(809, 'GR-EN-154', 'SEAL WASHER (HEAD COVER,ALL) R', 0, '', 13, 1, 'Active', 0),
(810, 'GR-EN-155', 'SERVICE CYILENDER HEAD', 0, '', 13, 1, 'Active', 0),
(811, 'GR-EN-156', 'SHORT BLOCK ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(812, 'GR-EN-157', 'SPARK PLUG (ALL) R&R', 0, '', 13, 1, 'Active', 0),
(813, 'GR-EN-158', 'STARTER ASSEMBLY OH', 0, '', 13, 1, 'Active', 0),
(814, 'GR-EN-159', 'STARTER ASSEMBLY OH', 0, '', 13, 1, 'Active', 0),
(815, 'GR-EN-160', 'STARTER ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(816, 'GR-EN-161', 'STARTER ASSEMBLY R&R', 0, '', 13, 1, 'Active', 0),
(817, 'GR-EN-162', 'STARTER BRUSH HOLDER ASSY R&R', 0, '', 13, 1, 'Active', 0),
(818, 'GR-EN-163', 'STARTER BRUSH HOLDER ASSY R&R', 0, '', 13, 1, 'Active', 0),
(819, 'GR-EN-164', 'STARTER MAGNETIC SWITCH ASSY R', 0, '', 13, 1, 'Active', 0),
(820, 'GR-EN-165', 'STARTER MAGNETIC SWITCH ASSY R', 0, '', 13, 1, 'Active', 0),
(821, 'GR-EN-166', 'SWITCH HEAD LAMP-R (GT)', 0, '', 13, 1, 'Active', 0),
(822, 'GR-EN-167', 'TENSIONER-GANTI', 0, '', 13, 1, 'Active', 0),
(823, 'GR-EN-168', 'THERMOSTAT R&R', 0, '', 13, 1, 'Active', 0),
(824, 'GR-EN-169', 'THROTTLE BODY ASSY R&R', 0, '', 13, 1, 'Active', 0),
(825, 'GR-EN-170', 'TIMING BELT IDLER R&R', 0, '', 13, 1, 'Active', 0),
(826, 'GR-EN-171', 'TIMING BELT R&R', 0, '', 13, 1, 'Active', 0),
(827, 'GR-EN-172', 'TIMING CHAIN R&R', 0, '', 13, 1, 'Active', 0),
(828, 'GR-EN-173', 'TIMING CHAIN/BELT-GANTI', 0, '', 13, 1, 'Active', 0),
(829, 'GR-EN-174', 'TIMING COVER GASKET-GANTI', 0, '', 13, 1, 'Active', 0),
(830, 'GR-EN-175', 'TIMING GEAR COVER R&R', 0, '', 13, 1, 'Active', 0),
(831, 'GR-EN-176', 'TIMING GEAR/CASE-GANTI', 0, '', 13, 1, 'Active', 0),
(832, 'GR-EN-177', 'TIMING IDLE GEAR-GANTI', 0, '', 13, 1, 'Active', 0),
(833, 'GR-EN-178', 'TIMMING-STEL/R', 0, '', 13, 1, 'Active', 0),
(834, 'GR-EN-179', 'TOP.OH ENGINE GT.PISTON & RING', 0, '', 13, 1, 'Active', 0),
(835, 'GR-EN-180', 'V BELT R&R', 0, '', 13, 1, 'Active', 0),
(836, 'GR-EN-181', 'V BELT-CHECK/STEL', 0, '', 13, 1, 'Active', 0),
(837, 'GR-EN-182', 'V BELT-CHECK/STEL', 0, '', 13, 1, 'Active', 0),
(838, 'GR-EN-183', 'V BELT-GANTI', 0, '', 13, 1, 'Active', 0),
(839, 'GR-EN-184', 'V BELT-GANTI', 0, '', 13, 1, 'Active', 0),
(840, 'GR-EN-185', 'V. BELT ALTENATOR-GT/R/STEL', 0, '', 13, 1, 'Active', 0),
(841, 'GR-EN-186', 'V.BELT AC/PWR STEER STEL/GT.', 0, '', 13, 1, 'Active', 0),
(842, 'GR-EN-187', 'VACUM CARBURATOR/R', 0, '', 13, 1, 'Active', 0),
(843, 'GR-EN-188', 'VACUUM HOSE R&R', 0, '', 13, 1, 'Active', 0),
(844, 'GR-EN-189', 'VACUUM SWITCHING VALVE R&R', 0, '', 13, 1, 'Active', 0),
(845, 'GR-EN-190', 'VALVE AND GUIDE BUSHING R&R', 0, '', 13, 1, 'Active', 0),
(846, 'GR-EN-191', 'VALVE COVER GASKET-GANTI', 0, '', 13, 1, 'Active', 0),
(847, 'GR-EN-192', 'VALVE LIFTER (ALL) R&R', 0, '', 13, 1, 'Active', 0),
(848, 'GR-EN-193', 'VALVE SEAL-GANTI (TANPA O.H)', 0, '', 13, 1, 'Active', 0),
(849, 'GR-EN-194', 'VALVE-STEL', 0, '', 13, 1, 'Active', 0),
(850, 'GR-EN-195', 'WATER BY-PASS NO.1 HOSE R&R', 0, '', 13, 1, 'Active', 0),
(851, 'GR-EN-196', 'WATER OUTLET AND/OR GASKET R&R', 0, '', 13, 1, 'Active', 0),
(852, 'GR-EN-197', 'WaterByPassHose AND/OR CLAMP R', 0, '', 13, 1, 'Active', 0),
(853, 'GR-EN-198', 'WATERPUMP ASSY AND/OR GASKET R', 0, '', 13, 1, 'Active', 0),
(854, 'GR-FS-1', 'CABLE CHOOKE-GANTI', 0, '', 14, 1, 'Active', 0),
(855, 'GR-FS-2', 'CABLE GAS-GANTI', 0, '', 14, 1, 'Active', 0),
(856, 'GR-FS-3', 'ENGINE STOP CABLE-GANTI', 0, '', 14, 1, 'Active', 0),
(857, 'GR-FS-4', 'FEED PUMP-GANTI', 0, '', 14, 1, 'Active', 0),
(858, 'GR-FS-5', 'FLY WHEEL BK/PS', 0, '', 14, 1, 'Active', 0),
(859, 'GR-FS-6', 'FUEL FILTER-GANTI/BERSIHKAN', 0, '', 14, 1, 'Active', 0),
(860, 'GR-FS-7', 'FUEL GAUGE-REPAIR/GT', 0, '', 14, 1, 'Active', 0),
(861, 'GR-FS-8', 'FUEL METER-GANTI/REPAIR', 0, '', 14, 1, 'Active', 0),
(862, 'GR-FS-9', 'FUEL MOTOR CONTROL ASSY-GANTI', 0, '', 14, 1, 'Active', 0),
(863, 'GR-FS-10', 'FUEL MOTOR CONTROL RELAY-GANTI', 0, '', 14, 1, 'Active', 0),
(864, 'GR-FS-11', 'FUEL PUMP-GANTI/REPAIR', 0, '', 14, 1, 'Active', 0),
(865, 'GR-FS-12', 'FUEL SENDER-GANTI/REPAIR', 0, '', 14, 1, 'Active', 0),
(866, 'GR-FS-13', 'FUEL SYSTEM-OVERHAUL', 0, '', 14, 1, 'Active', 0),
(867, 'GR-FS-14', 'FUEL TANK HOSE-GANTI/REPAIR', 0, '', 14, 1, 'Active', 0),
(868, 'GR-FS-15', 'FUEL TANK-GANTI/KURAS', 0, '', 14, 1, 'Active', 0),
(869, 'GR-FS-16', 'IDLING CONTROL CABLE-GANTI', 0, '', 14, 1, 'Active', 0),
(870, 'GR-FS-17', 'INJECT PUMP SERVICE', 0, '', 14, 1, 'Active', 0),
(871, 'GR-FS-18', 'INJECTION PUMP DIAPHRAGMA-GANT', 0, '', 14, 1, 'Active', 0),
(872, 'GR-FS-19', 'INJECTION PUMP SOCKET-REPAIR', 0, '', 14, 1, 'Active', 0),
(873, 'GR-FS-20', 'INJECTION PUMP/PRIMING-STEL', 0, '', 14, 1, 'Active', 0),
(874, 'GR-FS-21', 'INJECTION PUMP-GANTI', 0, '', 14, 1, 'Active', 0),
(875, 'GR-FS-22', 'INJECTOR NOZZLE-GANTI', 0, '', 14, 1, 'Active', 0),
(876, 'GR-FS-23', 'INJECTOR NOZZLE-STEL', 0, '', 14, 1, 'Active', 0),
(877, 'GR-FS-24', 'INJEKTION PUMP-BK/PS', 0, '', 14, 1, 'Active', 0),
(878, 'GR-FS-25', 'O-RING DISTRIBUTOR-GT', 0, '', 14, 1, 'Active', 0),
(879, 'GR-FS-26', 'PIPA BAHAN BAKAR/GT/R', 0, '', 14, 1, 'Active', 0),
(880, 'GR-FS-27', 'PIPA INJEKTION PUMP-R', 0, '', 14, 1, 'Active', 0),
(881, 'GR-FS-28', 'RESERVOIR TANK-GT', 0, '', 14, 1, 'Active', 0),
(882, 'GR-FS-29', 'SLANG TANGKI BENSIN-REPAIR', 0, '', 14, 1, 'Active', 0),
(883, 'GR-FS-30', 'SLANG VACUM CARBULATOR (R)', 0, '', 14, 1, 'Active', 0),
(884, 'GR-FS-31', 'TANGKI BAHAN BAKAR-BK/PS', 0, '', 14, 1, 'Active', 0),
(885, 'GR-MT-1', 'CHECKING I (1.000 KM)', 0, '', 15, 1, 'Active', 0),
(886, 'GR-MT-2', 'CHECKING II (5.000 KM)', 0, '', 15, 1, 'Active', 0),
(887, 'GR-MT-3', 'CHECKING 10.000', 0, '', 15, 1, 'Active', 0),
(888, 'GR-MT-4', 'CHECKING 30.000', 0, '', 15, 1, 'Active', 0),
(889, 'GR-MT-5', 'CHECKING 50.000', 0, '', 15, 1, 'Active', 0),
(890, 'GR-MT-6', 'CHECKING 70.000', 0, '', 15, 1, 'Active', 0),
(891, 'GR-MT-7', 'CHECKING 90.000', 0, '', 15, 1, 'Active', 0),
(892, 'GR-MT-8', 'CHECKING 110,130,150 dst', 0, '', 15, 1, 'Active', 0),
(893, 'GR-MT-9', 'CHECKING 15.000', 0, '', 15, 1, 'Active', 0),
(894, 'GR-MT-10', 'CHECKING 25.000', 0, '', 15, 1, 'Active', 0),
(895, 'GR-MT-11', 'CHECKING 35.000', 0, '', 15, 1, 'Active', 0),
(896, 'GR-MT-12', 'CHECKING 45.000', 0, '', 15, 1, 'Active', 0),
(897, 'GR-MT-13', 'CHECKING 55.000', 0, '', 15, 1, 'Active', 0),
(898, 'GR-MT-14', 'CHECKING 65.000', 0, '', 15, 1, 'Active', 0),
(899, 'GR-MT-15', 'CHECKING 75.000', 0, '', 15, 1, 'Active', 0),
(900, 'GR-MT-16', 'CHECKING 85.000', 0, '', 15, 1, 'Active', 0),
(901, 'GR-MT-17', 'CHECKING 95.000', 0, '', 15, 1, 'Active', 0),
(902, 'GR-MT-18', 'CHECKING 105,115,125 dst', 0, '', 15, 1, 'Active', 0),
(903, 'GR-MT-19', 'CHECKING 20.000', 0, '', 15, 1, 'Active', 0),
(904, 'GR-MT-20', 'CHECKING 60.000', 0, '', 15, 1, 'Active', 0),
(905, 'GR-MT-21', 'CHECKING 100.000', 0, '', 15, 1, 'Active', 0),
(906, 'GR-MT-22', 'CHECKING 140,180,220 dst', 0, '', 15, 1, 'Active', 0),
(907, 'GR-MT-23', 'CHECKING 40.000', 0, '', 15, 1, 'Active', 0),
(908, 'GR-MT-24', 'CHECKING 120,200,280 dst', 0, '', 15, 1, 'Active', 0),
(909, 'GR-MT-25', 'CHECKING 80.000', 0, '', 15, 1, 'Active', 0),
(910, 'GR-MT-26', 'CHECKING 160,240,320 dst', 0, '', 15, 1, 'Active', 0),
(911, 'GR-MT-27', 'CHECKING 200.000', 0, '', 15, 1, 'Active', 0),
(912, 'GR-MT-28', 'CHECKING 400.000', 0, '', 15, 1, 'Active', 0),
(913, 'GR-MT-29', 'CHECKING 120.000', 0, '', 15, 1, 'Active', 0),
(914, 'GR-PS-1', 'AS RODA RR LH/RH', 0, '', 16, 1, 'Active', 0),
(915, 'GR-PS-2', 'AXLE SHAFT FRONT-KANAN GANTI', 0, '', 16, 1, 'Active', 0),
(916, 'GR-PS-3', 'AXLE SHAFT FRONT-KIRI GANTI', 0, '', 16, 1, 'Active', 0),
(917, 'GR-PS-4', 'AXLE SHAFT REAR-KANAN GANTI', 0, '', 16, 1, 'Active', 0),
(918, 'GR-PS-5', 'AXLE SHAFT REAR-KIRI GANTI', 0, '', 16, 1, 'Active', 0),
(919, 'GR-PS-6', 'AXLE SHAFT SEAL (R)-GANTI (1 P', 0, '', 16, 1, 'Active', 0),
(920, 'GR-PS-7', 'AXLE SHAFT SEAL (R)-GANTI (2 P', 0, '', 16, 1, 'Active', 0),
(921, 'GR-PS-8', 'CROSS JOINT/SPIDER KIT 1 (GT)', 0, '', 16, 1, 'Active', 0),
(922, 'GR-PS-9', 'CROSS JOINT/SPIDER KIT 2 (GT)', 0, '', 16, 1, 'Active', 0),
(923, 'GR-PS-10', 'CROSS JOINT/SPIDER KIT 3 (GT)', 0, '', 16, 1, 'Active', 0),
(924, 'GR-PS-11', 'CROSS JOINT/SPIDER KIT 4 (GT)', 0, '', 16, 1, 'Active', 0),
(925, 'GR-PS-12', 'DRIVE SHAFT BOOT FR RH', 0, '', 16, 1, 'Active', 0),
(926, 'GR-PS-13', 'DRIVE SHAFT BOOTH-GANTI (1 PCS', 0, '', 16, 1, 'Active', 0),
(927, 'GR-PS-14', 'DRIVE SHAFT BOOTH-GANTI (2 PCS', 0, '', 16, 1, 'Active', 0),
(928, 'GR-PS-15', 'DRIVE SHAFT SEAL-GANTI (1 PCS)', 0, '', 16, 1, 'Active', 0),
(929, 'GR-PS-16', 'DRIVE SHAFT SEAL-GANTI (2 PCS)', 0, '', 16, 1, 'Active', 0),
(930, 'GR-PS-17', 'DRIVE SHAFT-GANTI (1 PCS)', 0, '', 16, 1, 'Active', 0),
(931, 'GR-PS-18', 'DRIVE SHAFT-GANTI (2 PCS)', 0, '', 16, 1, 'Active', 0),
(932, 'GR-PS-19', 'ENGSEL PINTU SLEDING LH-GT', 0, '', 16, 1, 'Active', 0),
(933, 'GR-PS-20', 'FLAUGE PROPPELER SHAFT-R', 0, '', 16, 1, 'Active', 0),
(934, 'GR-PS-21', 'GREASE PROPELER SHAFT', 0, '', 16, 1, 'Active', 0),
(935, 'GR-PS-22', 'PROP. SHAFT CENTER BEARING-GAN', 0, '', 16, 1, 'Active', 0),
(936, 'GR-PS-23', 'PROPELER SHAFT ASSY DPN & BLK-', 0, '', 16, 1, 'Active', 0),
(937, 'GR-PS-24', 'PROPELER SHAFT ASSY-GANTI', 0, '', 16, 1, 'Active', 0),
(938, 'GR-PS-25', 'PROPELER SHAFT JOINT BLK-GANTI', 0, '', 16, 1, 'Active', 0),
(939, 'GR-PS-26', 'PROPELER SHAFT JOINT DPN-GANTI', 0, '', 16, 1, 'Active', 0),
(940, 'GR-PS-27', 'PROPELER SHAFT SAJA-GANTI', 0, '', 16, 1, 'Active', 0),
(941, 'GR-PS-28', 'PROPELER SHAFT SAJA-GANTI (2 P', 0, '', 16, 1, 'Active', 0),
(942, 'GR-PS-29', 'PROPELLER SHAFT-LURUSKAN', 0, '', 16, 1, 'Active', 0),
(943, 'GR-PS-30', 'SHAFT JOINT STER (REPAIR)', 0, '', 16, 1, 'Active', 0),
(944, 'GR-SV-1', 'AIR HORN GT/R', 0, '', 18, 1, 'Active', 0),
(945, 'GR-SV-2', 'AIR WIPER REP', 0, '', 18, 1, 'Active', 0),
(946, 'GR-SV-3', 'ALLOY WHEEL-GANTI/REPAIR', 0, '', 18, 1, 'Active', 0),
(947, 'GR-SV-4', 'ALTERNATOR-BK/PS', 0, '', 18, 1, 'Active', 0),
(948, 'GR-SV-5', 'AXLE 4 X 4-PASANG', 0, '', 18, 1, 'Active', 0),
(949, 'GR-SV-6', 'BACK STEP ASSY GANTI', 0, '', 18, 1, 'Active', 0),
(950, 'GR-SV-7', 'BACKING PLAT REM RR (R)', 0, '', 18, 1, 'Active', 0),
(951, 'GR-SV-8', 'BANGKU RR/LH-REPAIR', 0, '', 18, 1, 'Active', 0),
(952, 'GR-SV-9', 'BAUT BRAKET KNALPOT /R', 0, '', 18, 1, 'Active', 0),
(953, 'GR-SV-10', 'BAUT BUMPER-(R) KERASKAN', 0, '', 18, 1, 'Active', 0),
(954, 'GR-SV-11', 'BAUT COVER VALVE (R)', 0, '', 18, 1, 'Active', 0),
(955, 'GR-SV-12', 'BAUT DASHBOARD-KERASKAN', 0, '', 18, 1, 'Active', 0),
(956, 'GR-SV-13', 'BAUT DUDUKAN BAN SEREP-R', 0, '', 18, 1, 'Active', 0),
(957, 'GR-SV-14', 'BAUT FORK (REPAIR)', 0, '', 18, 1, 'Active', 0),
(958, 'GR-SV-15', 'BAUT KERASKAN OUT PHUT SHAF', 0, '', 18, 1, 'Active', 0),
(959, 'GR-SV-16', 'BAUT KUNCI KONTAK/R', 0, '', 18, 1, 'Active', 0),
(960, 'GR-SV-17', 'BAUT LEAF SPRING KERASKAN', 0, '', 18, 1, 'Active', 0),
(961, 'GR-SV-18', 'BAUT POWER STERING-R', 0, '', 18, 1, 'Active', 0),
(962, 'GR-SV-19', 'BAUT PROPELER SHAFT-GT', 0, '', 18, 1, 'Active', 0),
(963, 'GR-SV-20', 'BAUT RODA REP/GT', 0, '', 18, 1, 'Active', 0),
(964, 'GR-SV-21', 'BAUT STERING RACK-REPAIR', 0, '', 18, 1, 'Active', 0),
(965, 'GR-SV-22', 'BAUT TANKI-R/GT', 0, '', 18, 1, 'Active', 0),
(966, 'GR-SV-23', 'BAUT TUTUP CENTRAL LOCK/R', 0, '', 18, 1, 'Active', 0),
(967, 'GR-SV-24', 'BEARING STATER CLUTC-GT', 0, '', 18, 1, 'Active', 0),
(968, 'GR-SV-25', 'BERSIHKAN KACA LAMPU FR', 0, '', 18, 1, 'Active', 0),
(969, 'GR-SV-26', 'BERSIHKAN TERMO STATER', 0, '', 18, 1, 'Active', 0),
(970, 'GR-SV-27', 'BOLP INSTRUMEN AC (GT)', 0, '', 18, 1, 'Active', 0),
(971, 'GR-SV-28', 'BOLP LAMP GT-3 (PC)', 0, '', 18, 1, 'Active', 0),
(972, 'GR-SV-29', 'BOOSTER OVERHOULE', 0, '', 18, 1, 'Active', 0),
(973, 'GR-SV-30', 'BOSTER KIT REM', 0, '', 18, 1, 'Active', 0),
(974, 'GR-SV-31', 'BOTOM PINTU PS/GT', 0, '', 18, 1, 'Active', 0),
(975, 'GR-SV-32', 'BRACKET BAN SEREP (R)', 0, '', 18, 1, 'Active', 0),
(976, 'GR-SV-33', 'BRACKET CHASIS LAS', 0, '', 18, 1, 'Active', 0),
(977, 'GR-SV-34', 'BRAKE-OVERHAUL 1 RODA', 0, '', 18, 1, 'Active', 0),
(978, 'GR-SV-35', 'BRAKET DASBOAD FR-GT', 0, '', 18, 1, 'Active', 0),
(979, 'GR-SV-36', 'BRAKET HOUSING ALTERNATOR', 0, '', 18, 1, 'Active', 0),
(980, 'GR-SV-37', 'BRAKET RESEVOIR RADIATOR', 0, '', 18, 1, 'Active', 0),
(981, 'GR-SV-38', 'BRAKET STABILIZER-GT', 0, '', 18, 1, 'Active', 0),
(982, 'GR-SV-39', 'BRAKET STERING RACK-R', 0, '', 18, 1, 'Active', 0),
(983, 'GR-SV-40', 'BRUSH HOLDER-GT', 0, '', 18, 1, 'Active', 0),
(984, 'GR-SV-41', 'BUBUT DISC BRAKE', 0, '', 18, 1, 'Active', 0),
(985, 'GR-SV-42', 'BUBUT TROMOL', 0, '', 18, 1, 'Active', 0),
(986, 'GR-SV-43', 'BUMPER GUARD-GANTI/REPAIR', 0, '', 18, 1, 'Active', 0),
(987, 'GR-SV-44', 'BUSHING BODY FR RH/LH-GT', 0, '', 18, 1, 'Active', 0),
(988, 'GR-SV-45', 'BUSHING JOK-GT/R', 0, '', 18, 1, 'Active', 0),
(989, 'GR-SV-46', 'BUSHING SHAKEL-GT (2PC)', 0, '', 18, 1, 'Active', 0),
(990, 'GR-SV-47', 'BUSHING STERING COLOUMB (GT)', 0, '', 18, 1, 'Active', 0),
(991, 'GR-SV-48', 'BUSHING STRUTBAR-GT', 0, '', 18, 1, 'Active', 0),
(992, 'GR-SV-49', 'CABLE AC/REPEIR', 0, '', 18, 1, 'Active', 0),
(993, 'GR-SV-50', 'CABLE TEMP GAUGE (R)', 0, '', 18, 1, 'Active', 0),
(994, 'GR-SV-51', 'CANESTER-REPAIR/GT', 0, '', 18, 1, 'Active', 0),
(995, 'GR-SV-52', 'CD CHANGER PIONEER-GANTI/REPAI', 0, '', 18, 1, 'Active', 0),
(996, 'GR-SV-53', 'CENTRE BEARING (GT)', 0, '', 18, 1, 'Active', 0),
(997, 'GR-SV-54', 'CHOKE TOMBOL-GT/R', 0, '', 18, 1, 'Active', 0),
(998, 'GR-SV-55', 'CLOCK-GANTI/REPAIR', 0, '', 18, 1, 'Active', 0),
(999, 'GR-SV-56', 'COMPANEMEN GLOW-GT', 0, '', 18, 1, 'Active', 0),
(1000, 'GR-SV-57', 'CONDENSOR AC + FREON', 0, '', 18, 1, 'Active', 0),
(1001, 'GR-SV-58', 'CONSUL BOX-GT/PS', 0, '', 18, 1, 'Active', 0),
(1002, 'GR-SV-59', 'CONTAK POINT DISTRIBUTOR-STEL', 0, '', 18, 1, 'Active', 0),
(1003, 'GR-SV-60', 'COVER STEER/R', 0, '', 18, 1, 'Active', 0),
(1004, 'GR-SV-61', 'COVER TUTUP BENSIN/R', 0, '', 18, 1, 'Active', 0),
(1005, 'GR-SV-62', 'COVER VENDER-GT/R', 0, '', 18, 1, 'Active', 0),
(1006, 'GR-SV-63', 'CRANK SHAFT PULLY (GT)', 0, '', 18, 1, 'Active', 0),
(1007, 'GR-SV-64', 'CRANK SHAFT-BK/PS', 0, '', 18, 1, 'Active', 0),
(1008, 'GR-SV-65', 'CROS RODA (4 BAN)', 0, '', 18, 1, 'Active', 0),
(1009, 'GR-SV-66', 'CROSS RODA (1 BAN)', 0, '', 18, 1, 'Active', 0),
(1010, 'GR-SV-67', 'CROSS RODA (4 BAN)', 0, '', 18, 1, 'Active', 0),
(1011, 'GR-SV-68', 'CSX BODY STRIPE SET-GANTI/RAPI', 0, '', 18, 1, 'Active', 0),
(1012, 'GR-SV-69', 'CUCI ALL BODY & ENGINE', 0, '', 18, 1, 'Active', 0),
(1013, 'GR-SV-70', 'CUCI BODY', 0, '', 18, 1, 'Active', 0),
(1014, 'GR-SV-71', 'CUSHION STRUT-GT (2)', 0, '', 18, 1, 'Active', 0),
(1015, 'GR-SV-72', 'DASBOARD ASSY-(BK) (PS)', 0, '', 18, 1, 'Active', 0),
(1016, 'GR-SV-73', 'DASHBOARD INSTRUMENT-GT/R', 0, '', 18, 1, 'Active', 0),
(1017, 'GR-SV-74', 'DOOR TRIM PINTU-GT/REPAIR', 0, '', 18, 1, 'Active', 0),
(1018, 'GR-SV-75', 'DOP BEARING RODA RR/R', 0, '', 18, 1, 'Active', 0),
(1019, 'GR-SV-76', 'DUDUKAN BAN-REPAIR', 0, '', 18, 1, 'Active', 0),
(1020, 'GR-SV-77', 'DUDUKAN RADIATOR', 0, '', 18, 1, 'Active', 0),
(1021, 'GR-SV-78', 'ELECTRIC MIRROR-GANTI/REPAIR', 0, '', 18, 1, 'Active', 0),
(1022, 'GR-SV-79', 'EMBLEM FEROZA', 0, '', 18, 1, 'Active', 0),
(1023, 'GR-SV-80', 'ENGSEL PINTU 1PCS-GT', 0, '', 18, 1, 'Active', 0),
(1024, 'GR-SV-81', 'ENGSEL PINTU 2 PCS-GT', 0, '', 18, 1, 'Active', 0),
(1025, 'GR-SV-82', 'ENGSEL PINTU FR GT', 0, '', 18, 1, 'Active', 0),
(1026, 'GR-SV-83', 'EX ENGINE OVERHAUL (1000 KM)', 0, '', 18, 1, 'Active', 0),
(1027, 'GR-SV-84', 'FAN SRUTT-GT (R)', 0, '', 18, 1, 'Active', 0),
(1028, 'GR-SV-85', 'FLANK-YORK (GT/R)', 0, '', 18, 1, 'Active', 0),
(1029, 'GR-SV-86', 'FLEXIBLE STEER-GT', 0, '', 18, 1, 'Active', 0),
(1030, 'GR-SV-87', 'FLEXIBLE VACUM ALT-GT', 0, '', 18, 1, 'Active', 0),
(1031, 'GR-SV-88', 'FLOATHER (GT/R)', 0, '', 18, 1, 'Active', 0),
(1032, 'GR-SV-89', 'FOG LAMP (BOLP)', 0, '', 18, 1, 'Active', 0),
(1033, 'GR-SV-90', 'FOG LAMP GT/REP', 0, '', 18, 1, 'Active', 0),
(1034, 'GR-SV-91', 'FOG LAMP SET (SILVER ONLY)-GAN', 0, '', 18, 1, 'Active', 0),
(1035, 'GR-SV-92', 'FOOT STEEP LH CAT', 0, '', 18, 1, 'Active', 0),
(1036, 'GR-SV-93', 'FOOT STEP ENGINE', 0, '', 18, 1, 'Active', 0),
(1037, 'GR-SV-94', 'FOOT STEP LH/RH PS', 0, '', 18, 1, 'Active', 0),
(1038, 'GR-SV-95', 'FOOT STEP-GT', 0, '', 18, 1, 'Active', 0),
(1039, 'GR-SV-96', 'FOOT STEP-GT (1PC)', 0, '', 18, 1, 'Active', 0),
(1040, 'GR-SV-97', 'FRONT BUMPER GUARD EMBOSS-GANT', 0, '', 18, 1, 'Active', 0),
(1041, 'GR-SV-98', 'GANTI BAN-1 PCS', 0, '', 18, 1, 'Active', 0),
(1042, 'GR-SV-99', 'GANTUNGAN BAN SEREP-R/GT', 0, '', 18, 1, 'Active', 0),
(1043, 'GR-SV-100', 'GASKET OIL PUMP-GT', 0, '', 18, 1, 'Active', 0),
(1044, 'GR-SV-101', 'GASKET SWICTH OIL-R', 0, '', 18, 1, 'Active', 0),
(1045, 'GR-SV-102', 'GEAR BOX BK', 0, '', 18, 1, 'Active', 0),
(1046, 'GR-SV-103', 'GENERAL CHEK UP', 0, '', 18, 1, 'Active', 0),
(1047, 'GR-SV-104', 'GRAFIR KACA/GLASS SIGN', 0, '', 18, 1, 'Active', 0),
(1048, 'GR-SV-105', 'GREASE BOOTH DRIVE SHAFT 1 PC', 0, '', 18, 1, 'Active', 0),
(1049, 'GR-SV-106', 'GREASE BOOTH DRIVE SHAFT 2PS', 0, '', 18, 1, 'Active', 0),
(1050, 'GR-SV-107', 'GREASE BUSHING S KNUCLE', 0, '', 18, 1, 'Active', 0),
(1051, 'GR-SV-108', 'GREASE HANDLE PINTU', 0, '', 18, 1, 'Active', 0),
(1052, 'GR-SV-109', 'GREASING', 0, '', 18, 1, 'Active', 0),
(1053, 'GR-SV-110', 'GRILL KLIP/GT', 0, '', 18, 1, 'Active', 0),
(1054, 'GR-SV-111', 'GRIP/PEGANGAN TANGAN-GT', 0, '', 18, 1, 'Active', 0),
(1055, 'GR-SV-112', 'HANDLE PANEL VENTILASI-REPAIR', 0, '', 18, 1, 'Active', 0),
(1056, 'GR-SV-113', 'HANDREST JOK RR-REPAIR', 0, '', 18, 1, 'Active', 0),
(1057, 'GR-SV-114', 'HINE SLEIDING-R/GT', 0, '', 18, 1, 'Active', 0),
(1058, 'GR-SV-115', 'HOSE AC REPAIR', 0, '', 18, 1, 'Active', 0),
(1059, 'GR-SV-116', 'HOSE AIR CLENER-GT', 0, '', 18, 1, 'Active', 0),
(1060, 'GR-SV-117', 'HOSE BY PASS (GT)', 0, '', 18, 1, 'Active', 0),
(1061, 'GR-SV-118', 'HOSE EXSHAUS MANIPOL-GT/R', 0, '', 18, 1, 'Active', 0),
(1062, 'GR-SV-119', 'HOSE FLEXIBLE FR-GT', 0, '', 18, 1, 'Active', 0),
(1063, 'GR-SV-120', 'HOSE LAMP RR-R', 0, '', 18, 1, 'Active', 0),
(1064, 'GR-SV-121', 'HOSE OIL RESERVOIR (GT)', 0, '', 18, 1, 'Active', 0),
(1065, 'GR-SV-122', 'HOT DUC-GT', 0, '', 18, 1, 'Active', 0),
(1066, 'GR-SV-123', 'HOUSING GARDAN-BK/PS', 0, '', 18, 1, 'Active', 0),
(1067, 'GR-SV-124', 'HOUSING INJECT. PUMP-GT', 0, '', 18, 1, 'Active', 0),
(1068, 'GR-SV-125', 'HOUSING OIL-GT', 0, '', 18, 1, 'Active', 0),
(1069, 'GR-SV-126', 'HOUSING PROPELER SHAFT-GT', 0, '', 18, 1, 'Active', 0),
(1070, 'GR-SV-127', 'HUB FRNT AXLE LH/GT', 0, '', 18, 1, 'Active', 0),
(1071, 'GR-SV-128', 'IDLE UP AC RPM-STEL', 0, '', 18, 1, 'Active', 0),
(1072, 'GR-SV-129', 'JAM & COVER-GT', 0, '', 18, 1, 'Active', 0),
(1073, 'GR-SV-130', 'JOINT STER-GT/STEL', 0, '', 18, 1, 'Active', 0),
(1074, 'GR-SV-131', 'JOK REPAIR/GANTI', 0, '', 18, 1, 'Active', 0),
(1075, 'GR-SV-132', 'KABEL SLEDING-GT (1PC)', 0, '', 18, 1, 'Active', 0),
(1076, 'GR-SV-133', 'KABEL TURN SIGNAL (R)', 0, '', 18, 1, 'Active', 0),
(1077, 'GR-SV-134', 'KACA FR B/P', 0, '', 18, 1, 'Active', 0),
(1078, 'GR-SV-135', 'KARET BODY RR-GT', 0, '', 18, 1, 'Active', 0),
(1079, 'GR-SV-136', 'KARET CUP MESIN-GT', 0, '', 18, 1, 'Active', 0),
(1080, 'GR-SV-137', 'KARET KACA PINTU RR/RH-GT', 0, '', 18, 1, 'Active', 0),
(1081, 'GR-SV-138', 'KARET KACA SEGITIGA RR GT', 0, '', 18, 1, 'Active', 0),
(1082, 'GR-SV-139', 'KARET LUMPUR-(GT) 1PC', 0, '', 18, 1, 'Active', 0),
(1083, 'GR-SV-140', 'KARET LUMPUR-GT 2 PCS', 0, '', 18, 1, 'Active', 0),
(1084, 'GR-SV-141', 'KARET PANEL PNT TENGAH (2)', 0, '', 18, 1, 'Active', 0),
(1085, 'GR-SV-142', 'KARET PINTU FR RH REP/GT', 0, '', 18, 1, 'Active', 0),
(1086, 'GR-SV-143', 'KARET PINTU RR GT', 0, '', 18, 1, 'Active', 0),
(1087, 'GR-SV-144', 'KARET SUPPORT KNALPOT-GT', 0, '', 18, 1, 'Active', 0),
(1088, 'GR-SV-145', 'KARET TUTUP TIMING-GT/R', 0, '', 18, 1, 'Active', 0),
(1089, 'GR-SV-146', 'KARPET & INTERIOR BERSIHKAN', 0, '', 18, 1, 'Active', 0),
(1090, 'GR-SV-147', 'KEBOCORAN OIL MESIN CH', 0, '', 18, 1, 'Active', 0),
(1091, 'GR-SV-148', 'KILOMETER NOL', 0, '', 18, 1, 'Active', 0),
(1092, 'GR-SV-149', 'KISI AC-GT/R', 0, '', 18, 1, 'Active', 0),
(1093, 'GR-SV-150', 'KLIP TUTUP BENSIN-GT', 0, '', 18, 1, 'Active', 0),
(1094, 'GR-SV-151', 'KUNCI BAGASI-GT', 0, '', 18, 1, 'Active', 0),
(1095, 'GR-SV-152', 'KUNCI PINTU FR RH/LH', 0, '', 18, 1, 'Active', 0),
(1096, 'GR-SV-153', 'KUNCI PINTU REP/GT 1 PCS', 0, '', 18, 1, 'Active', 0),
(1097, 'GR-SV-154', 'KURAS MINYAK PW.STEERING', 0, '', 18, 1, 'Active', 0),
(1098, 'GR-SV-155', 'LAMP FLAFON-REPAIR', 0, '', 18, 1, 'Active', 0),
(1099, 'GR-SV-156', 'LAMPU BELAKANG ATAS-PS', 0, '', 18, 1, 'Active', 0),
(1100, 'GR-SV-157', 'LAS FLY WHEEL', 0, '', 18, 1, 'Active', 0),
(1101, 'GR-SV-158', 'LAS GEAR BOX BRAKET', 0, '', 18, 1, 'Active', 0),
(1102, 'GR-SV-159', 'LAS JOK', 0, '', 18, 1, 'Active', 0),
(1103, 'GR-SV-160', 'LAS KING PIN', 0, '', 18, 1, 'Active', 0),
(1104, 'GR-SV-161', 'LAS KNALPOT', 0, '', 18, 1, 'Active', 0),
(1105, 'GR-SV-162', 'LAS LOWER ARM', 0, '', 18, 1, 'Active', 0),
(1106, 'GR-SV-163', 'LEAF SPRING RR/FR (R/TAMBAH)', 0, '', 18, 1, 'Active', 0),
(1107, 'GR-SV-164', 'LEM PLUG PUM OIL', 0, '', 18, 1, 'Active', 0),
(1108, 'GR-SV-165', 'LEPAS ALARAM', 0, '', 18, 1, 'Active', 0),
(1109, 'GR-SV-166', 'LEPAS BRAKET TANDUK', 0, '', 18, 1, 'Active', 0),
(1110, 'GR-SV-167', 'LEVER SHIFT-PS', 0, '', 18, 1, 'Active', 0),
(1111, 'GR-SV-168', 'LINK PINTU FR/RR 1 PCS-REP', 0, '', 18, 1, 'Active', 0),
(1112, 'GR-SV-169', 'LIST KACA FR-GT', 0, '', 18, 1, 'Active', 0),
(1113, 'GR-SV-170', 'LIST KARET FENDER-PS/GT', 0, '', 18, 1, 'Active', 0),
(1114, 'GR-SV-171', 'LIST PINTU LH-CAT', 0, '', 18, 1, 'Active', 0),
(1115, 'GR-SV-172', 'LOCK JOK RR/RH', 0, '', 18, 1, 'Active', 0),
(1116, 'GR-SV-173', 'LOCK PINTU FR RH/LH', 0, '', 18, 1, 'Active', 0),
(1117, 'GR-SV-174', 'LONG TIE ROD-(GT)', 0, '', 18, 1, 'Active', 0),
(1118, 'GR-SV-175', 'MASTER KOPLING ATAS-OH', 0, '', 18, 1, 'Active', 0),
(1119, 'GR-SV-176', 'MASTER KOPLING BAWAH O H', 0, '', 18, 1, 'Active', 0),
(1120, 'GR-SV-177', 'MODIFIKASI DUDUKAN JOK', 0, '', 18, 1, 'Active', 0),
(1121, 'GR-SV-178', 'MOTOR WASHER-GT', 0, '', 18, 1, 'Active', 0),
(1122, 'GR-SV-179', 'MUFFLER BK/PS', 0, '', 18, 1, 'Active', 0),
(1123, 'GR-SV-180', 'NEPEL PIPA REM-REPAIR', 0, '', 18, 1, 'Active', 0),
(1124, 'GR-SV-181', 'NEPEL PREPORTINAL VALVE-R', 0, '', 18, 1, 'Active', 0),
(1125, 'GR-SV-182', 'NOZLE-STEEL', 0, '', 18, 1, 'Active', 0),
(1126, 'GR-SV-183', 'NOZZLE + WASHER NOZZLE', 0, '', 18, 1, 'Active', 0),
(1127, 'GR-SV-184', 'NOZZLE OIL (GT)', 0, '', 18, 1, 'Active', 0),
(1128, 'GR-SV-185', 'OH/M EDIC.', 0, '', 18, 1, 'Active', 0),
(1129, 'GR-SV-186', 'OIL FILTER-GANTI', 0, '', 18, 1, 'Active', 0),
(1130, 'GR-SV-187', 'OLI TRANSMISI TAMBAH', 0, '', 18, 1, 'Active', 0),
(1131, 'GR-SV-188', 'P.D.I. (PRE DELEVERY INSPECTIO', 0, '', 18, 1, 'Active', 0),
(1132, 'GR-SV-189', 'PAD HORN GT', 0, '', 18, 1, 'Active', 0),
(1133, 'GR-SV-190', 'PAKET AUTO SEAL', 0, '', 18, 1, 'Active', 0),
(1134, 'GR-SV-191', 'PAKING OIL COOLER-GT', 0, '', 18, 1, 'Active', 0),
(1135, 'GR-SV-192', 'PASANG PLASTIK JOK ALL', 0, '', 18, 1, 'Active', 0),
(1136, 'GR-SV-193', 'PEMANAS KACA RR/R', 0, '', 18, 1, 'Active', 0),
(1137, 'GR-SV-194', 'PEMASANG SEGEL TAPE (20 PC)', 0, '', 18, 1, 'Active', 0),
(1138, 'GR-SV-195', 'PEMERIKSAAN 21 ITEM', 0, '', 18, 1, 'Active', 0),
(1139, 'GR-SV-196', 'PINTU RH/LH CAT', 0, '', 18, 1, 'Active', 0),
(1140, 'GR-SV-197', 'PINTU RR-CAT', 0, '', 18, 1, 'Active', 0),
(1141, 'GR-SV-198', 'PIPA MINYAK REM-REPAIR/GT', 0, '', 18, 1, 'Active', 0),
(1142, 'GR-SV-199', 'PIPA RADIATOR BAWAH-GT', 0, '', 18, 1, 'Active', 0),
(1143, 'GR-SV-200', 'PIPA STICK OLI-GT/R', 0, '', 18, 1, 'Active', 0),
(1144, 'GR-SV-201', 'PIPA TREE WAY-GT (1)', 0, '', 18, 1, 'Active', 0),
(1145, 'GR-SV-202', 'PITMAN ARM-GT', 0, '', 18, 1, 'Active', 0),
(1146, 'GR-SV-203', 'PLAFON-GANTI/REP.', 0, '', 18, 1, 'Active', 0),
(1147, 'GR-SV-204', 'PLATE BACKDOOR LOCK (PS)', 0, '', 18, 1, 'Active', 0),
(1148, 'GR-SV-205', 'PLUG DUDUKAN JOK-R', 0, '', 18, 1, 'Active', 0),
(1149, 'GR-SV-206', 'PLUG TANKI BENSIN (R)', 0, '', 18, 1, 'Active', 0),
(1150, 'GR-SV-207', 'PRESS LEAF SPRING FR/RH', 0, '', 18, 1, 'Active', 0),
(1151, 'GR-SV-208', 'PRESS PER + B/P', 0, '', 18, 1, 'Active', 0),
(1152, 'GR-SV-209', 'PRIMING PUMP-GT /R', 0, '', 18, 1, 'Active', 0),
(1153, 'GR-SV-210', 'PS ACESORIES FL-FX', 0, '', 18, 1, 'Active', 0),
(1154, 'GR-SV-211', 'PULLY KIPAS/WATER PUMP (GT)', 0, '', 18, 1, 'Active', 0),
(1155, 'GR-SV-212', 'PULLY PUMP P STERING-GT', 0, '', 18, 1, 'Active', 0),
(1156, 'GR-SV-213', 'PUMP VANE OH/GT', 0, '', 18, 1, 'Active', 0),
(1157, 'GR-SV-214', 'R WIRE COWL & SLANG WIPER', 0, '', 18, 1, 'Active', 0),
(1158, 'GR-SV-215', 'RAPIHKAN KARET PINTU RR/RH', 0, '', 18, 1, 'Active', 0),
(1159, 'GR-SV-216', 'REAR GARNISH ILLUMINATION KIT-', 0, '', 18, 1, 'Active', 0),
(1160, 'GR-SV-217', 'REGULATOR KACA-GANTI/REPAIR (1', 0, '', 18, 1, 'Active', 0),
(1161, 'GR-SV-218', 'REGULATOR KACA-GANTI/REPAIR (1', 0, '', 18, 1, 'Active', 0),
(1162, 'GR-SV-219', 'REGULATOR KACA-GANTI/REPAIR (2', 0, '', 18, 1, 'Active', 0),
(1163, 'GR-SV-220', 'REGULATOR KACA-GANTI/REPAIR (2', 0, '', 18, 1, 'Active', 0),
(1164, 'GR-SV-221', 'REGULATOR KACA-GANTI/REPAIR (3', 0, '', 18, 1, 'Active', 0),
(1165, 'GR-SV-222', 'REGULATOR KACA-GANTI/REPAIR (3', 0, '', 18, 1, 'Active', 0),
(1166, 'GR-SV-223', 'REGULATOR KACA-GANTI/REPAIR (4', 0, '', 18, 1, 'Active', 0),
(1167, 'GR-SV-224', 'REGULATOR KACA-GANTI/REPAIR (4', 0, '', 18, 1, 'Active', 0),
(1168, 'GR-SV-225', 'REGULATOR TENGAH RH (1)-GT', 0, '', 18, 1, 'Active', 0),
(1169, 'GR-SV-226', 'REKCLENING JOK-R', 0, '', 18, 1, 'Active', 0),
(1170, 'GR-SV-227', 'RELAY RUMAH-GT', 0, '', 18, 1, 'Active', 0),
(1171, 'GR-SV-228', 'RELAY WINDSHILD WIPER-GT.', 0, '', 18, 1, 'Active', 0),
(1172, 'GR-SV-229', 'REPAIR BRACKET RADIATOR', 0, '', 18, 1, 'Active', 0),
(1173, 'GR-SV-230', 'REPAIR SWITCH FOG LAMP', 0, '', 18, 1, 'Active', 0),
(1174, 'GR-SV-231', 'RESERVOIR RADIATOR-GT', 0, '', 18, 1, 'Active', 0),
(1175, 'GR-SV-232', 'RESERVOIR WIFER-GT', 0, '', 18, 1, 'Active', 0),
(1176, 'GR-SV-233', 'RESISTEN BLOWER-R', 0, '', 18, 1, 'Active', 0),
(1177, 'GR-SV-234', 'ROOF AND SPOILER-GANTI/REPAIR', 0, '', 18, 1, 'Active', 0),
(1178, 'GR-SV-235', 'ROOF RACK PASANG', 0, '', 18, 1, 'Active', 0),
(1179, 'GR-SV-236', 'ROOF RACK SET-GANTI REPAIR', 0, '', 18, 1, 'Active', 0),
(1180, 'GR-SV-237', 'RUMAH STICK OLI-GT', 0, '', 18, 1, 'Active', 0),
(1181, 'GR-SV-238', 'SAFETY BELT-GANTI/PASANG/REP', 0, '', 18, 1, 'Active', 0),
(1182, 'GR-SV-239', 'SAKEL LEAFSPRING-RR/GT (2)', 0, '', 18, 1, 'Active', 0),
(1183, 'GR-SV-240', 'SEAL BODY VALVE-GT', 0, '', 18, 1, 'Active', 0),
(1184, 'GR-SV-241', 'SEAL SHAFT GEAR BOX FR-GT', 0, '', 18, 1, 'Active', 0),
(1185, 'GR-SV-242', 'SEAL SPEDOMETER (GT)', 0, '', 18, 1, 'Active', 0),
(1186, 'GR-SV-243', 'SEALER DISTR.', 0, '', 18, 1, 'Active', 0),
(1187, 'GR-SV-244', 'SELANG BAHAN BAKAR-R', 0, '', 18, 1, 'Active', 0),
(1188, 'GR-SV-245', 'SELANG PW STEERING-GT/R', 0, '', 18, 1, 'Active', 0),
(1189, 'GR-SV-246', 'SEPARATOR AC-REPAIR', 0, '', 18, 1, 'Active', 0),
(1190, 'GR-SV-247', 'SERVICE BESAR + OIL FILTER', 0, '', 18, 1, 'Active', 0),
(1191, 'GR-SV-248', 'SERVICE KECIL', 0, '', 18, 1, 'Active', 0),
(1192, 'GR-SV-249', 'SIDE STEP SET-GANTI/REPEIR', 0, '', 18, 1, 'Active', 0),
(1193, 'GR-SV-250', 'SILER FENDER FR RH', 0, '', 18, 1, 'Active', 0),
(1194, 'GR-SV-251', 'SILER KACA FR', 0, '', 18, 1, 'Active', 0),
(1195, 'GR-SV-252', 'SLANG NEPEL P.S-REPAIR', 0, '', 18, 1, 'Active', 0),
(1196, 'GR-SV-253', 'SLANG OIL COOLER', 0, '', 18, 1, 'Active', 0),
(1197, 'GR-SV-254', 'SLANG WIFER-R/GT', 0, '', 18, 1, 'Active', 0),
(1198, 'GR-SV-255', 'SLYP CYLINDER HEAD', 0, '', 18, 1, 'Active', 0),
(1199, 'GR-SV-256', 'SOLENOID MOTOR STATER-GT', 0, '', 18, 1, 'Active', 0),
(1200, 'GR-SV-257', 'SPEDO METER TURUNKAN-R', 0, '', 18, 1, 'Active', 0),
(1201, 'GR-SV-258', 'SPEDOMETER SEAL-GT', 0, '', 18, 1, 'Active', 0),
(1202, 'GR-SV-259', 'SPERATOR CANESTER-GT', 0, '', 18, 1, 'Active', 0),
(1203, 'GR-SV-260', 'SPIDER KIT 2 PCS', 0, '', 18, 1, 'Active', 0),
(1204, 'GR-SV-261', 'SPIDER KIT-1 PC/GT', 0, '', 18, 1, 'Active', 0),
(1205, 'GR-SV-262', 'SPOILER-PS', 0, '', 18, 1, 'Active', 0),
(1206, 'GR-SV-263', 'STAY DUMFER RR LH/RH-GT', 0, '', 18, 1, 'Active', 0),
(1207, 'GR-SV-264', 'STEALTH GUARD-PS', 0, '', 18, 1, 'Active', 0),
(1208, 'GR-SV-265', 'STIKER BODY-GT', 0, '', 18, 1, 'Active', 0),
(1209, 'GR-SV-266', 'STOPER LEAF SPRING-GT', 0, '', 18, 1, 'Active', 0),
(1210, 'GR-SV-267', 'STRUT BAR BUSH (GT)', 0, '', 18, 1, 'Active', 0),
(1211, 'GR-SV-268', 'SUNVISOR-PS', 0, '', 18, 1, 'Active', 0),
(1212, 'GR-SV-269', 'SUPPORT KNALPOT-GT', 0, '', 18, 1, 'Active', 0),
(1213, 'GR-SV-270', 'SWICHT KUNCI KONTAK-R', 0, '', 18, 1, 'Active', 0),
(1214, 'GR-SV-271', 'SWICTH LAMP RR/MUNDUR-GT/R', 0, '', 18, 1, 'Active', 0),
(1215, 'GR-SV-272', 'SWITCH BLOWER-REPAIR/GT', 0, '', 18, 1, 'Active', 0),
(1216, 'GR-SV-273', 'SWITCH IDIKATOR HAND BRAKE-R', 0, '', 18, 1, 'Active', 0),
(1217, 'GR-SV-274', 'SWITCH RADIATOR (GT)', 0, '', 18, 1, 'Active', 0),
(1218, 'GR-SV-275', 'TACHO METER (SPEEDOMETER)-GT', 0, '', 18, 1, 'Active', 0),
(1219, 'GR-SV-276', 'TALANG AIR-GT', 0, '', 18, 1, 'Active', 0),
(1220, 'GR-SV-277', 'TANKI AIR WIFER-GT/REPAIR', 0, '', 18, 1, 'Active', 0),
(1221, 'GR-SV-278', 'TANKI FLOTHER-(R)', 0, '', 18, 1, 'Active', 0),
(1222, 'GR-SV-279', 'TANKI RADIATOR ATAS-GT', 0, '', 18, 1, 'Active', 0),
(1223, 'GR-SV-280', 'TEMPERATUR GAUGE-R/GT', 0, '', 18, 1, 'Active', 0),
(1224, 'GR-SV-281', 'TENSIONER BEARING P STERING', 0, '', 18, 1, 'Active', 0),
(1225, 'GR-SV-282', 'TIE ROD FR-GT', 0, '', 18, 1, 'Active', 0),
(1226, 'GR-SV-283', 'TORSI KEPALA CLYNDER', 0, '', 18, 1, 'Active', 0),
(1227, 'GR-SV-284', 'TREE WAY (GT)', 0, '', 18, 1, 'Active', 0),
(1228, 'GR-SV-285', 'TROMOL-RR /GT/BONGKAR PSG', 0, '', 18, 1, 'Active', 0),
(1229, 'GR-SV-286', 'TURUN TRANMISI', 0, '', 18, 1, 'Active', 0),
(1230, 'GR-SV-287', 'TUTUP STICK TRANSMISI-GT', 0, '', 18, 1, 'Active', 0),
(1231, 'GR-SV-288', 'UNDERSTEL', 0, '', 18, 1, 'Active', 0),
(1232, 'GR-SV-289', 'VACUM ADVANCER (GT)', 0, '', 18, 1, 'Active', 0),
(1233, 'GR-SV-290', 'VALVE AIR CONTROL-GT', 0, '', 18, 1, 'Active', 0),
(1234, 'GR-SV-291', 'VENTILASI (R)', 0, '', 18, 1, 'Active', 0),
(1235, 'GR-SV-292', 'VENTILASI UDARA/INSTRUMEN AC', 0, '', 18, 1, 'Active', 0),
(1236, 'GR-SV-293', 'VOLT METER-(GT)', 0, '', 18, 1, 'Active', 0),
(1237, 'GR-SV-294', 'WASHER WIFER-GT', 0, '', 18, 1, 'Active', 0),
(1238, 'GR-SV-295', 'WATER STRIP 1 PCS', 0, '', 18, 1, 'Active', 0),
(1239, 'GR-SV-296', 'WHEEL BEARING KNUCLE(GREASE)', 0, '', 18, 1, 'Active', 0),
(1240, 'GR-SS-1', 'ALARM REP', 0, '', 19, 1, 'Active', 0),
(1241, 'GR-SS-2', 'ALARM SET-PS', 0, '', 19, 1, 'Active', 0),
(1242, 'GR-SS-3', 'AS RODA-GT 1PCS', 0, '', 19, 1, 'Active', 0),
(1243, 'TBA-SS-1', 'BALANCE 1 RODA', 0, '', 23, 3, 'Active', 0),
(1244, 'TBA-SS-2', 'BALANCE 3 (RODA)', 0, '', 23, 3, 'Active', 0),
(1245, 'TBA-SS-3', 'BALANCE RODA-2 RODA', 0, '', 23, 3, 'Active', 0),
(1246, 'TBA-SS-4', 'BALANCE RODA-4 RODA', 0, '', 23, 3, 'Active', 0),
(1247, 'TBA-SS-5', 'BAN LUAR-GT 1PCS', 0, '', 23, 3, 'Active', 0),
(1248, 'GR-SS-4', 'BAUT CUP ENGINE GT/REP', 0, '', 19, 1, 'Active', 0),
(1249, 'GR-SS-5', 'BAUT JOK REP', 0, '', 19, 1, 'Active', 0),
(1250, 'GR-SS-6', 'BAUT STABILIZER-REP', 0, '', 19, 1, 'Active', 0),
(1251, 'GR-SS-7', 'BEARING (FOR DRIVE PINION) R&R', 0, '', 19, 1, 'Active', 0),
(1252, 'GR-SS-8', 'BEARING(FOR DISC BRAKE,1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1253, 'GR-SS-9', 'BOOTH STEER-GANTI (1 PCS)', 0, '', 19, 1, 'Active', 0),
(1254, 'GR-SS-10', 'BOOTH STEER-GANTI (2 PCS)', 0, '', 19, 1, 'Active', 0),
(1255, 'GR-SS-11', 'BRACKET BUMPER FR CAT/REP', 0, '', 19, 1, 'Active', 0),
(1256, 'GR-SS-12', 'BRACKET GEAR BOX LAS', 0, '', 19, 1, 'Active', 0),
(1257, 'GR-SS-13', 'BRACKET STEERING RACK-R', 0, '', 19, 1, 'Active', 0),
(1258, 'GR-SS-14', 'BRAKET BAN-GT/REP', 0, '', 19, 1, 'Active', 0),
(1259, 'GR-SS-15', 'BRAKET STEERING PUMP-R', 0, '', 19, 1, 'Active', 0),
(1260, 'GR-SS-16', 'BUSHING BODY ALL', 0, '', 19, 1, 'Active', 0),
(1261, 'GR-SS-17', 'BUSHING BUSI REP/GT', 0, '', 19, 1, 'Active', 0),
(1262, 'GR-SS-18', 'BUSHING PER 2 PCS GT', 0, '', 19, 1, 'Active', 0),
(1263, 'GR-SS-19', 'BUSHING PER 4 PCS GT', 0, '', 19, 1, 'Active', 0),
(1264, 'GR-SS-20', 'BUSHING STER-GANTI', 0, '', 19, 1, 'Active', 0),
(1265, 'GR-SS-21', 'BUSHING STERING COLOUMB-GT', 0, '', 19, 1, 'Active', 0),
(1266, 'GR-SS-22', 'CABLE RELAY GT/REP', 0, '', 19, 1, 'Active', 0),
(1267, 'GR-SS-23', 'CAMPAIGN LOWER ARM (ADM)', 0, '', 19, 1, 'Active', 0),
(1268, 'GR-SS-24', 'CARBURATOR STEL', 0, '', 19, 1, 'Active', 0),
(1269, 'GR-SS-25', 'CD CHANGER PS/GT', 0, '', 19, 1, 'Active', 0),
(1270, 'GR-SS-26', 'COMB:EACH ADDITIONAL WHEEL ', 0, '', 19, 1, 'Active', 0),
(1271, 'GR-SS-27', 'COMB:OPPOSITE SIDE ', 0, '', 19, 1, 'Active', 0),
(1272, 'GR-SS-28', 'COMB:TOE-IN ADJUST', 0, '', 19, 1, 'Active', 0),
(1273, 'GR-SS-29', 'CONTROL VALVE STEERING-OVERHAU', 0, '', 19, 1, 'Active', 0),
(1274, 'GR-SS-30', 'COVER LAMPU PLAT NOMOR GT/REP', 0, '', 19, 1, 'Active', 0),
(1275, 'GR-SS-31', 'COVER WHEEL-GT', 0, '', 19, 1, 'Active', 0),
(1276, 'GR-SS-32', 'CROOS RODA FR-LH', 0, '', 19, 1, 'Active', 0),
(1277, 'GR-SS-33', 'CROSS PEDAL REM', 0, '', 19, 1, 'Active', 0),
(1278, 'GR-SS-34', 'CUP MOTOR (BAWAH)-CAT', 0, '', 19, 1, 'Active', 0),
(1279, 'GR-SS-35', 'CUP MOTOR CABLE GT/REP', 0, '', 19, 1, 'Active', 0),
(1280, 'GR-SS-36', 'Diff RingGearSet & SideGear R&', 0, '', 19, 1, 'Active', 0),
(1281, 'GR-SS-37', 'DIFFERENTIAL CARRIER ASSY OH', 0, '', 19, 1, 'Active', 0),
(1282, 'GR-SS-38', 'DIFFERENTIAL CARRIER ASSY R&R', 0, '', 19, 1, 'Active', 0),
(1283, 'GR-SS-39', 'DIFFERENTIAL CARRIER SUBASSY R', 0, '', 19, 1, 'Active', 0),
(1284, 'GR-SS-40', 'DIFFERENTIAL CASE SUBASSY R&R', 0, '', 19, 1, 'Active', 0),
(1285, 'GR-SS-41', 'DifRingGearAndDrivePinionKit R', 0, '', 19, 1, 'Active', 0),
(1286, 'GR-SS-42', 'DOOR TRIM/SPIKER-GT', 0, '', 19, 1, 'Active', 0),
(1287, 'GR-SS-43', 'DRAG LINK STEER-GANTI', 0, '', 19, 1, 'Active', 0),
(1288, 'GR-SS-44', 'DRAG LINK STEER-STEL', 0, '', 19, 1, 'Active', 0),
(1289, 'GR-SS-45', 'DRIVE SHAFT BOOT (ONE SIDE) R&', 0, '', 19, 1, 'Active', 0),
(1290, 'GR-SS-46', 'ENGINE B/P,H.GARDAN,SUSPENSI', 0, '', 19, 1, 'Active', 0),
(1291, 'GR-SS-47', 'FISCO FAN-GT', 0, '', 19, 1, 'Active', 0),
(1292, 'GR-SS-48', 'Fr DRIVE SHAFT ASSY(1 SIDE) R&', 0, '', 19, 1, 'Active', 0),
(1293, 'GR-SS-49', 'Fr SHOCK ABSORBER ASSY(1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1294, 'GR-SS-50', 'Fr STABILIZER BAR BUSH(1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1295, 'GR-SS-51', 'FRAME ENGINE-GT', 0, '', 19, 1, 'Active', 0),
(1296, 'GR-SS-52', 'FrAxleHub(ForDiscBrake,1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1297, 'GR-SS-53', 'FRONT COIL SPRING (ONE SIDE) R', 0, '', 19, 1, 'Active', 0),
(1298, 'GR-SS-54', 'FRONT STABILIZER BAR R&R', 0, '', 19, 1, 'Active', 0),
(1299, 'GR-SS-55', 'FrSuspensionSupportAssy(1Sd) R', 0, '', 19, 1, 'Active', 0),
(1300, 'GR-SS-56', 'FUEL SENSOR-R/GT', 0, '', 19, 1, 'Active', 0),
(1301, 'GR-SS-57', 'FUSE-GT (REP)', 0, '', 19, 1, 'Active', 0),
(1302, 'GR-SS-58', 'HAND GRIP-REPAIR/GT', 0, '', 19, 1, 'Active', 0),
(1303, 'GR-SS-59', 'HANDLE PINTU-GT 1 PCS', 0, '', 19, 1, 'Active', 0),
(1304, 'GR-SS-60', 'HAZARD-R/GT', 0, '', 19, 1, 'Active', 0),
(1305, 'GR-SS-61', 'HORN BUTTON ASSEMBLY R&R', 0, '', 19, 1, 'Active', 0),
(1306, 'GR-SS-62', 'HOSE HIGH PRESURE-GT', 0, '', 19, 1, 'Active', 0),
(1307, 'GR-SS-63', 'HUB BOLT (ONE SIDE) R&R', 0, '', 19, 1, 'Active', 0),
(1308, 'GR-SS-64', 'HubBolts(ForDiscBrake, 1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1309, 'GR-SS-65', 'INER FENDER-GT 1 PCS', 0, '', 19, 1, 'Active', 0),
(1310, 'GR-SS-66', 'INER QUARTER RH/LH-GT', 0, '', 19, 1, 'Active', 0),
(1311, 'GR-SS-67', 'JET CLEAN/BERSIHKAN R BAKAR', 0, '', 19, 1, 'Active', 0),
(1312, 'GR-SS-68', 'KABEL LAMPU RR REP/GT', 0, '', 19, 1, 'Active', 0),
(1313, 'GR-SS-69', 'KARET FOOT STEP-GT (1PC)', 0, '', 19, 1, 'Active', 0),
(1314, 'GR-SS-70', 'KARET FOOT STEP-GT (2PC)', 0, '', 19, 1, 'Active', 0),
(1315, 'GR-SS-71', 'KARET FOOT STEP-REP', 0, '', 19, 1, 'Active', 0),
(1316, 'GR-SS-72', 'KARPET DALAM-BK/PS', 0, '', 19, 1, 'Active', 0),
(1317, 'GR-SS-73', 'KEY LOCK STEER-GANTI', 0, '', 19, 1, 'Active', 0),
(1318, 'GR-SS-74', 'KEY SET + CYLINDER-GT', 0, '', 19, 1, 'Active', 0),
(1319, 'GR-SS-75', 'KING PIN-OVERHAUL', 0, '', 19, 1, 'Active', 0),
(1320, 'GR-SS-76', 'KING PIN/R', 0, '', 19, 1, 'Active', 0),
(1321, 'GR-SS-77', 'KNUCKLE FR-GT', 0, '', 19, 1, 'Active', 0),
(1322, 'GR-SS-78', 'KNUCKLE-GT 1 PCS', 0, '', 19, 1, 'Active', 0),
(1323, 'GR-SS-79', 'KUNCI KONTAK SET-GT', 0, '', 19, 1, 'Active', 0),
(1324, 'GR-SS-80', 'LAMPU BELAKANG-GT', 0, '', 19, 1, 'Active', 0),
(1325, 'GR-SS-81', 'LAMPU DEPAN LH GT', 0, '', 19, 1, 'Active', 0),
(1326, 'GR-SS-82', 'LAMPU MUNDUR GT', 0, '', 19, 1, 'Active', 0),
(1327, 'GR-SS-83', 'LAMPU SIGN-2 PCS GT', 0, '', 19, 1, 'Active', 0),
(1328, 'GR-SS-84', 'LAS CHASIS', 0, '', 19, 1, 'Active', 0),
(1329, 'GR-SS-85', 'LAS DUDUKAN SPRING', 0, '', 19, 1, 'Active', 0),
(1330, 'GR-SS-86', 'LAS LINK PINTU', 0, '', 19, 1, 'Active', 0),
(1331, 'GR-SS-87', 'LATERAL-GT', 0, '', 19, 1, 'Active', 0),
(1332, 'GR-SS-88', 'LINER FENDER-GT 1PCS', 0, '', 19, 1, 'Active', 0),
(1333, 'GR-SS-89', 'LINER SPAKBOARD-PS', 0, '', 19, 1, 'Active', 0),
(1334, 'GR-SS-90', 'LIST KACA RR RH/LH GT', 0, '', 19, 1, 'Active', 0),
(1335, 'GR-SS-91', 'LOCK LACI REP/GANTI', 0, '', 19, 1, 'Active', 0),
(1336, 'GR-SS-92', 'LOCK PINTU TGH L/R-REP', 0, '', 19, 1, 'Active', 0),
(1337, 'GR-SS-93', 'LOWER ARM FR 1 PCS-GT', 0, '', 19, 1, 'Active', 0),
(1338, 'GR-SS-94', 'LOWER CONTROL ARM ASSY(1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1339, 'GR-SS-95', 'MOULDING PINTU FR-RR LH CAT', 0, '', 19, 1, 'Active', 0),
(1340, 'GR-SS-96', 'OIL SEAL DIFFERENTIAL R&R', 0, '', 19, 1, 'Active', 0),
(1341, 'GR-SS-97', 'OUTLET PIPA', 0, '', 19, 1, 'Active', 0),
(1342, 'GR-SS-98', 'P. STERING PUMP OVERHAUL', 0, '', 19, 1, 'Active', 0),
(1343, 'GR-SS-99', 'P/S RACK END SUBASSY(1 Sd) R&R', 0, '', 19, 1, 'Active', 0),
(1344, 'GR-SS-100', 'PACKING CARBURATOR-GT', 0, '', 19, 1, 'Active', 0),
(1345, 'GR-SS-101', 'PACKING KNALPOT-GT', 0, '', 19, 1, 'Active', 0),
(1346, 'GR-SS-102', 'PER + BUSHING 1 PCS GANTI', 0, '', 19, 1, 'Active', 0),
(1347, 'GR-SS-103', 'PER 2 PCS PRES/GT', 0, '', 19, 1, 'Active', 0),
(1348, 'GR-SS-104', 'PER FR LH GT/REP', 0, '', 19, 1, 'Active', 0),
(1349, 'GR-SS-105', 'PINTU RR LH/RH-CAT/GT', 0, '', 19, 1, 'Active', 0),
(1350, 'GR-SS-106', 'PIPA POWER STERING', 0, '', 19, 1, 'Active', 0),
(1351, 'GR-SS-107', 'PIPIH FR LH CAT', 0, '', 19, 1, 'Active', 0),
(1352, 'GR-SS-108', 'POWER ST. OIL TANK-GANTI', 0, '', 19, 1, 'Active', 0),
(1353, 'GR-SS-109', 'POWER ST. OIL-GANTI/KURAS', 0, '', 19, 1, 'Active', 0),
(1354, 'GR-SS-110', 'POWER STEERING GEAR ASSEMBLY O', 0, '', 19, 1, 'Active', 0),
(1355, 'GR-SS-111', 'POWER STEERING GEAR ASSEMBLY R', 0, '', 19, 1, 'Active', 0),
(1356, 'GR-SS-112', 'POWER STEERING HOSE-GANTI (1 P', 0, '', 19, 1, 'Active', 0),
(1357, 'GR-SS-113', 'POWER STEERING HOSE-GANTI (2 P', 0, '', 19, 1, 'Active', 0),
(1358, 'GR-SS-114', 'POWER STEERING PUMP ASSY-GANTI', 0, '', 19, 1, 'Active', 0),
(1359, 'GR-SS-115', 'POWER STEERING PUMP-OVERHAUL', 0, '', 19, 1, 'Active', 0),
(1360, 'GR-SS-116', 'PRESSURE FEED HOSE FOR RHD R&R', 0, '', 19, 1, 'Active', 0),
(1361, 'GR-SS-117', 'Pwr STEERING RACK BOOT(1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1362, 'GR-SS-118', 'RACK END-GANTI (1PC)', 0, '', 19, 1, 'Active', 0),
(1363, 'GR-SS-119', 'RACK END-GT (2PC)', 0, '', 19, 1, 'Active', 0),
(1364, 'GR-SS-120', 'REAR AXLE HOUSING ASSEMBLY R&R', 0, '', 19, 1, 'Active', 0),
(1365, 'GR-SS-121', 'REAR AXLE SHAFT (ONE SIDE) R&R', 0, '', 19, 1, 'Active', 0),
(1366, 'GR-SS-122', 'REAR COIL SPRING (ONE SIDE) R&', 0, '', 19, 1, 'Active', 0),
(1367, 'GR-SS-123', 'REAR SPRING ASSY (ONE SIDE) R&', 0, '', 19, 1, 'Active', 0),
(1368, 'GR-SS-124', 'REFLECTOR/GARNIS-GT', 0, '', 19, 1, 'Active', 0),
(1369, 'GR-SS-125', 'RELAY LAMPU REP/GT', 0, '', 19, 1, 'Active', 0),
(1370, 'GR-SS-126', 'RETURN HOSE R&R', 0, '', 19, 1, 'Active', 0),
(1371, 'GR-SS-127', 'ROD ASSY.STEERING RELAY', 0, '', 19, 1, 'Active', 0),
(1372, 'GR-SS-128', 'ROTASI BAN', 0, '', 19, 1, 'Active', 0),
(1373, 'GR-SS-129', 'Rr SHOCK ABSORBER ASSY(1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1374, 'GR-SS-130', 'Rr SHOCK ABSORBER ASSY(1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1375, 'GR-SS-131', 'RrAxle SHAFT BEARING(1 SIDE) R', 0, '', 19, 1, 'Active', 0),
(1376, 'GR-SS-132', 'SEAL KING PIN GT', 0, '', 19, 1, 'Active', 0),
(1377, 'GR-SS-133', 'SEAL POMPA POWER STEER-GT', 0, '', 19, 1, 'Active', 0),
(1378, 'GR-SS-134', 'SILER CUP DISTRIBUTOR', 0, '', 19, 1, 'Active', 0),
(1379, 'GR-SS-135', 'SILER LIST KACA', 0, '', 19, 1, 'Active', 0),
(1380, 'GR-SS-136', 'SILER PANEL COWEL', 0, '', 19, 1, 'Active', 0),
(1381, 'GR-SS-137', 'SPELING STER-STEL', 0, '', 19, 1, 'Active', 0),
(1382, 'GR-SS-138', 'SPION 1 PCS-GT', 0, '', 19, 1, 'Active', 0),
(1383, 'GR-SS-139', 'SPION LH-CAT', 0, '', 19, 1, 'Active', 0),
(1384, 'GR-SS-140', 'SPIRAL CABLE R&R', 0, '', 19, 1, 'Active', 0),
(1385, 'TBA-SS-6', 'SPOORING/BALANCING', 0, '', 23, 3, 'Active', 0),
(1386, 'GR-SS-141', 'SPRING NO.2 SHACKLE SUBASSY R&', 0, '', 19, 1, 'Active', 0),
(1387, 'GR-SS-142', 'STEERING BOX/GEAR ASSY-GANTI', 0, '', 19, 1, 'Active', 0),
(1388, 'GR-SS-143', 'STEERING BOX/GEAR-OVERHAUL', 0, '', 19, 1, 'Active', 0),
(1389, 'GR-SS-144', 'STEERING BOX/GEAR-STEL', 0, '', 19, 1, 'Active', 0),
(1390, 'GR-SS-145', 'STEERING COLOUMB-REPAIR/GANTI', 0, '', 19, 1, 'Active', 0),
(1391, 'GR-SS-146', 'STEERING COLUM UPPER BRACKET R', 0, '', 19, 1, 'Active', 0),
(1392, 'GR-SS-147', 'STEERING COLUMN ASSEMBLY R&R', 0, '', 19, 1, 'Active', 0),
(1393, 'GR-SS-148', 'STEERING DUMPER-GANTI', 0, '', 19, 1, 'Active', 0),
(1394, 'GR-SS-149', 'STEERING GEAR ASSEMBLY R&R', 0, '', 19, 1, 'Active', 0),
(1395, 'GR-SS-150', 'STEERING HOUSING SUBASSY R&R', 0, '', 19, 1, 'Active', 0),
(1396, 'GR-SS-151', 'STEERING JOINT SHAFT-GANTI', 0, '', 19, 1, 'Active', 0),
(1397, 'GR-SS-152', 'STEERING KNUCKLE BUSH-GANTI', 0, '', 19, 1, 'Active', 0),
(1398, 'GR-SS-153', 'STEERING KNUCKLE-GANTI', 0, '', 19, 1, 'Active', 0),
(1399, 'GR-SS-154', 'STEERING KNUCKLE(1 Sd) R&R', 0, '', 19, 1, 'Active', 0),
(1400, 'GR-SS-155', 'STEERING MAIN SHAFT ASSY R&R', 0, '', 19, 1, 'Active', 0),
(1401, 'GR-SS-156', 'STEERING PINION BEARING R&R', 0, '', 19, 1, 'Active', 0),
(1402, 'GR-SS-157', 'STEERING PINION R&R', 0, '', 19, 1, 'Active', 0),
(1403, 'GR-SS-158', 'STEERING PLAY-STEL', 0, '', 19, 1, 'Active', 0);
INSERT INTO `rims_service` (`id`, `code`, `name`, `price`, `description`, `service_category_id`, `service_type_id`, `status`, `difficulty_level`) VALUES
(1404, 'GR-SS-159', 'STEERING RACK ASSY-GANTI', 0, '', 19, 1, 'Active', 0),
(1405, 'GR-SS-160', 'STEERING RACK BOOT(ONE SIDE) R', 0, '', 19, 1, 'Active', 0),
(1406, 'GR-SS-161', 'STEERING RACK BUSH-GANTI', 0, '', 19, 1, 'Active', 0),
(1407, 'GR-SS-162', 'STEERING RACK HOUSINGSUBASSY R', 0, '', 19, 1, 'Active', 0),
(1408, 'GR-SS-163', 'STEERING RACK R&R', 0, '', 19, 1, 'Active', 0),
(1409, 'GR-SS-164', 'STEERING RACK-OVERHAUL', 0, '', 19, 1, 'Active', 0),
(1410, 'GR-SS-165', 'STEERING RACK-STEL', 0, '', 19, 1, 'Active', 0),
(1411, 'GR-SS-166', 'STEERING SHAFT-OVERHAUL', 0, '', 19, 1, 'Active', 0),
(1412, 'GR-SS-167', 'STEERING WHEEL ORNAMENT R&R', 0, '', 19, 1, 'Active', 0),
(1413, 'GR-SS-168', 'STEERING WHEEL SUBASSEMBLY R&R', 0, '', 19, 1, 'Active', 0),
(1414, 'GR-SS-169', 'STEERING WHEEL-GANTI', 0, '', 19, 1, 'Active', 0),
(1415, 'GR-SS-170', 'SteeringRackEndSubassy(1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1416, 'GR-SS-171', 'STEL CO', 0, '', 19, 1, 'Active', 0),
(1417, 'GR-SS-172', 'STER LURUSKAN', 0, '', 19, 1, 'Active', 0),
(1418, 'GR-SS-173', 'STERING BEVEL-GT/R', 0, '', 19, 1, 'Active', 0),
(1419, 'GR-SS-174', 'STERING COLOUMB-OVERHAUL', 0, '', 19, 1, 'Active', 0),
(1420, 'GR-SS-175', 'STOP LAMP-GT 2 PCS', 0, '', 19, 1, 'Active', 0),
(1421, 'GR-SS-176', 'STOPPER PINTU-GT', 0, '', 19, 1, 'Active', 0),
(1422, 'GR-SS-177', 'SuspentionLowerArmAssy(1 Sd) R', 0, '', 19, 1, 'Active', 0),
(1423, 'GR-SS-178', 'TAPERED ROLLER BEARING R&R', 0, '', 19, 1, 'Active', 0),
(1424, 'GR-SS-179', 'TIE ROD END/LONG TIE ROD-GANTI', 0, '', 19, 1, 'Active', 0),
(1425, 'GR-SS-180', 'TIE ROD-STEL', 0, '', 19, 1, 'Active', 0),
(1426, 'GR-SS-181', 'TIEROD END SUBASSY(ONE SIDE) R', 0, '', 19, 1, 'Active', 0),
(1427, 'GR-SS-182', 'TIRE ROTATION(ALL) R&R', 0, '', 19, 1, 'Active', 0),
(1428, 'GR-SS-183', 'TOE-IN', 0, '', 19, 1, 'Active', 0),
(1429, 'GR-SS-184', 'TROMOL RR 1 PCS GT', 0, '', 19, 1, 'Active', 0),
(1430, 'GR-SS-185', 'TYPE T OIL SEAL (ONE SIDE) R&R', 0, '', 19, 1, 'Active', 0),
(1431, 'GR-SS-186', 'TYPE T OIL SEAL R&R', 0, '', 19, 1, 'Active', 0),
(1432, 'GR-SS-187', 'UNIVERSAL JOINT FLANGE R&R', 0, '', 19, 1, 'Active', 0),
(1433, 'GR-SS-188', 'V BELT PUMP-GANTI', 0, '', 19, 1, 'Active', 0),
(1434, 'GR-SS-189', 'V-BELT R&R', 0, '', 19, 1, 'Active', 0),
(1435, 'GR-SS-190', 'VANE PUMP R&R', 0, '', 19, 1, 'Active', 0),
(1436, 'GR-SS-191', 'VELG 1 PCS-GT', 0, '', 19, 1, 'Active', 0),
(1437, 'GR-SS-192', 'WHEEL ALIGNMENT SYSTEM-STEL', 0, '', 19, 1, 'Active', 0),
(1438, 'GR-SS-193', 'WHEEL BALANCING R&R', 0, '', 19, 1, 'Active', 0),
(1439, 'GR-SS-194', 'WHEEL CAP (ALL) R&R', 0, '', 19, 1, 'Active', 0),
(1440, 'GR-SS-195', 'WINCH-PS', 0, '', 19, 1, 'Active', 0),
(1441, 'GR-SU-1', 'ANTING PER RR/RH-GT', 0, '', 20, 1, 'Active', 0),
(1442, 'GR-SU-2', 'BAUT PLUG TANKI (R)', 0, '', 20, 1, 'Active', 0),
(1443, 'GR-SU-3', 'BAUT REGULATOR-(R)', 0, '', 20, 1, 'Active', 0),
(1444, 'GR-SU-4', 'BAUT SUSPENSI-PERBAIKI/PASANG', 0, '', 20, 1, 'Active', 0),
(1445, 'GR-SU-5', 'BOLL JOINT LOWER-GANTI (1 PCS)', 0, '', 20, 1, 'Active', 0),
(1446, 'GR-SU-6', 'BOLL JOINT LOWER-GANTI (2 PCS)', 0, '', 20, 1, 'Active', 0),
(1447, 'GR-SU-7', 'BRACE SUB ASSY/R-GT', 0, '', 20, 1, 'Active', 0),
(1448, 'GR-SU-8', 'BRAKET LOWER ARM-REPAIR', 0, '', 20, 1, 'Active', 0),
(1449, 'GR-SU-9', 'BRUSH MOTOR STATER', 0, '', 20, 1, 'Active', 0),
(1450, 'GR-SU-10', 'CASTER ROD BUSH-GANTI (1 PCS)', 0, '', 20, 1, 'Active', 0),
(1451, 'GR-SU-11', 'CASTER ROD BUSH-GANTI (2 PCS)', 0, '', 20, 1, 'Active', 0),
(1452, 'GR-SU-12', 'COIL SPRING FRONT-GANTI (1 PCS', 0, '', 20, 1, 'Active', 0),
(1453, 'GR-SU-13', 'COIL SPRING FRONT-GANTI (2 PCS', 0, '', 20, 1, 'Active', 0),
(1454, 'GR-SU-14', 'COIL SPRING REAR-GANTI (1 PCS)', 0, '', 20, 1, 'Active', 0),
(1455, 'GR-SU-15', 'COIL SPRING REAR-GANTI (2 PCS)', 0, '', 20, 1, 'Active', 0),
(1456, 'GR-SU-16', 'CROSMEMBER-REPAIR', 0, '', 20, 1, 'Active', 0),
(1457, 'GR-SU-17', 'KARET COIL SPRING GT', 0, '', 20, 1, 'Active', 0),
(1458, 'GR-SU-18', 'LAS CROSMEMBER', 0, '', 20, 1, 'Active', 0),
(1459, 'GR-SU-19', 'LATERAL ROD/BUSH-GANTI (1 PCS', 0, '', 20, 1, 'Active', 0),
(1460, 'GR-SU-20', 'LATERAL ROD/BUSH-GANTI (2 PCS', 0, '', 20, 1, 'Active', 0),
(1461, 'GR-SU-21', 'LEAF SPRING BUSH-GANTI (1 SISI', 0, '', 20, 1, 'Active', 0),
(1462, 'GR-SU-22', 'LEAF SPRING BUSH-GANTI (2 SISI', 0, '', 20, 1, 'Active', 0),
(1463, 'GR-SU-23', 'LEAF SPRING BUSH-GANTI (3 SISI', 0, '', 20, 1, 'Active', 0),
(1464, 'GR-SU-24', 'LEAF SPRING BUSH-GANTI (4 SISI', 0, '', 20, 1, 'Active', 0),
(1465, 'GR-SU-25', 'LEAF SPRING FR L/R-OH', 0, '', 20, 1, 'Active', 0),
(1466, 'GR-SU-26', 'LEAF SPRING FR LH/OH', 0, '', 20, 1, 'Active', 0),
(1467, 'GR-SU-27', 'LEAF SPRING FRONT-GANTI (1 PCS', 0, '', 20, 1, 'Active', 0),
(1468, 'GR-SU-28', 'LEAF SPRING FRONT-GANTI (2 PCS', 0, '', 20, 1, 'Active', 0),
(1469, 'GR-SU-29', 'LEAF SPRING REAR-GANTI (1 PCS)', 0, '', 20, 1, 'Active', 0),
(1470, 'GR-SU-30', 'LEAF SPRING REAR-GANTI (2 PCS)', 0, '', 20, 1, 'Active', 0),
(1471, 'GR-SU-31', 'LOWER ARM BUSH FRONT-GANTI (1 ', 0, '', 20, 1, 'Active', 0),
(1472, 'GR-SU-32', 'LOWER ARM BUSH FRONT-GANTI (1 ', 0, '', 20, 1, 'Active', 0),
(1473, 'GR-SU-33', 'LOWER ARM BUSH FRONT-GANTI (2 ', 0, '', 20, 1, 'Active', 0),
(1474, 'GR-SU-34', 'LOWER ARM BUSH FRONT-GANTI (2 ', 0, '', 20, 1, 'Active', 0),
(1475, 'GR-SU-35', 'LOWER ARM-GT (2PCS)', 0, '', 20, 1, 'Active', 0),
(1476, 'GR-SU-36', 'PITMAN ARM BUSHING-REPAIR/GANT', 0, '', 20, 1, 'Active', 0),
(1477, 'GR-SU-37', 'PITMAN ARM BUSHING-REPAIR/GANT', 0, '', 20, 1, 'Active', 0),
(1478, 'GR-SU-38', 'REAR ARM BUSH-GANTI (1 PCS)', 0, '', 20, 1, 'Active', 0),
(1479, 'GR-SU-39', 'REAR ARM BUSH-GANTI (2 PCS)', 0, '', 20, 1, 'Active', 0),
(1480, 'GR-SU-40', 'SEPARATOR FUEL GT', 0, '', 20, 1, 'Active', 0),
(1481, 'GR-SU-41', 'SHOCK ABS. BAGASI-GANTI/REPAIR', 0, '', 20, 1, 'Active', 0),
(1482, 'GR-SU-42', 'SHOCK ABS. BAGASI-GANTI/REPAIR', 0, '', 20, 1, 'Active', 0),
(1483, 'GR-SU-43', 'SHOCK ABS. BUSHING-GANTI/REPAI', 0, '', 20, 1, 'Active', 0),
(1484, 'GR-SU-44', 'SHOCK ABS. BUSHING-GANTI/REPAI', 0, '', 20, 1, 'Active', 0),
(1485, 'GR-SU-45', 'SHOCK ABS. COVER-GANTI/REPAIR ', 0, '', 20, 1, 'Active', 0),
(1486, 'GR-SU-46', 'SHOCK ABS. COVER-GANTI/REPAIR ', 0, '', 20, 1, 'Active', 0),
(1487, 'GR-SU-47', 'SHOCK ABS. FRONT-GANTI/O.H (1 ', 0, '', 20, 1, 'Active', 0),
(1488, 'GR-SU-48', 'SHOCK ABS. FRONT-GANTI/O.H (2 ', 0, '', 20, 1, 'Active', 0),
(1489, 'GR-SU-49', 'SHOCK ABS. REAR-GANTI (1 PCS)', 0, '', 20, 1, 'Active', 0),
(1490, 'GR-SU-50', 'SHOCK ABS. REAR-GANTI (2 PCS)', 0, '', 20, 1, 'Active', 0),
(1491, 'GR-SU-51', 'SHOCK ABS.BAGASI-GANTI/REPAIR ', 0, '', 20, 1, 'Active', 0),
(1492, 'GR-SU-52', 'SHOCK ABS.BAGASI-GANTI/REPAIR ', 0, '', 20, 1, 'Active', 0),
(1493, 'GR-SU-53', 'SHOCK ABS.BUSHING-GANTI/REPAIR', 0, '', 20, 1, 'Active', 0),
(1494, 'GR-SU-54', 'SHOCK ABS.BUSHING-GANTI/REPAIR', 0, '', 20, 1, 'Active', 0),
(1495, 'GR-SU-55', 'SHOCK ABS.COVER-GANTI/REPAIR (', 0, '', 20, 1, 'Active', 0),
(1496, 'GR-SU-56', 'SHOCK ABS.COVER-GANTI/REPAIR (', 0, '', 20, 1, 'Active', 0),
(1497, 'GR-SU-57', 'SHOCK ABSOBER SEAL FR-GT', 0, '', 20, 1, 'Active', 0),
(1498, 'GR-SU-58', 'SPRING DUMPER-GT', 0, '', 20, 1, 'Active', 0),
(1499, 'GR-SU-59', 'STABILIZER BUSHING/ASSY-GANTI', 0, '', 20, 1, 'Active', 0),
(1500, 'GR-SU-60', 'SUPPORT SHOKABSOBER-GT/R', 0, '', 20, 1, 'Active', 0),
(1501, 'GR-SU-61', 'TRAILING ARM BUSH-GANTI (1 PCS', 0, '', 20, 1, 'Active', 0),
(1502, 'GR-SU-62', 'TRAILING ARM BUSH-GANTI (2 PCS', 0, '', 20, 1, 'Active', 0),
(1503, 'GR-SU-63', 'U BOLT-GANTI 1 SISI', 0, '', 20, 1, 'Active', 0),
(1504, 'GR-SU-64', 'U BOLT-GANTI 2 SISI', 0, '', 20, 1, 'Active', 0),
(1505, 'GR-SU-65', 'U BOLT-GANTI 3 SISI', 0, '', 20, 1, 'Active', 0),
(1506, 'GR-SU-66', 'U BOLT-GANTI 4 SISI', 0, '', 20, 1, 'Active', 0),
(1507, 'GR-SU-67', 'UPPER ARM LH-R', 0, '', 20, 1, 'Active', 0),
(1508, 'GR-TR-1', 'BACK UP SWITCH-GANTI', 0, '', 21, 1, 'Active', 0),
(1509, 'GR-TR-2', 'BOOTH STICK TRANSMISI-GT', 0, '', 21, 1, 'Active', 0),
(1510, 'GR-TR-3', 'CABLE TRANSFER REP/GT', 0, '', 21, 1, 'Active', 0),
(1511, 'GR-TR-4', 'CASE GASKET REAR-GANTI', 0, '', 21, 1, 'Active', 0),
(1512, 'GR-TR-5', 'DRIVE GEAR SPEEDOMETER-GANTI', 0, '', 21, 1, 'Active', 0),
(1513, 'GR-TR-6', 'GEAR SPEDOMETER-GT', 0, '', 21, 1, 'Active', 0),
(1514, 'GR-TR-7', 'HAND CROME PINTU', 0, '', 21, 1, 'Active', 0),
(1515, 'GR-TR-8', 'INPUT SHAFT BEARING-GT', 0, '', 21, 1, 'Active', 0),
(1516, 'GR-TR-9', 'INPUT SHAFT SEAL/BUSHING-GANTI', 0, '', 21, 1, 'Active', 0),
(1517, 'GR-TR-10', 'INTAKE MANIFOLD ASSY-GT/BKPS', 0, '', 21, 1, 'Active', 0),
(1518, 'GR-TR-11', 'OUTPUT SHAFT SEAL-GANTI (1 PCS', 0, '', 21, 1, 'Active', 0),
(1519, 'GR-TR-12', 'PACKING GARDAN FR-GT', 0, '', 21, 1, 'Active', 0),
(1520, 'GR-TR-13', 'SPEEDOMETER CABLE-GANTI', 0, '', 21, 1, 'Active', 0),
(1521, 'GR-TR-14', 'SPEEDOMETER-REPAIR', 0, '', 21, 1, 'Active', 0),
(1522, 'GR-TR-15', 'STICK TRANMISI BUSH-R/GT/LAS', 0, '', 21, 1, 'Active', 0),
(1523, 'GR-TR-16', 'STIK TRANSMISI BK/PS', 0, '', 21, 1, 'Active', 0),
(1524, 'GR-TR-17', 'STOPER R-GANTI', 0, '', 21, 1, 'Active', 0),
(1525, 'GR-TR-18', 'TRANSFFER-OVERHAUL', 0, '', 21, 1, 'Active', 0),
(1526, 'GR-TR-19', 'TRANSMISI BONGKAR/PASANG', 0, '', 21, 1, 'Active', 0),
(1527, 'GR-TR-20', 'TRANSMISION ASSY-GANTI', 0, '', 21, 1, 'Active', 0),
(1528, 'GR-TR-21', 'TRANSMISION CABLE/LINK-GANTI/R', 0, '', 21, 1, 'Active', 0),
(1529, 'GR-TR-22', 'TRANSMISION FORK/COVER-REPAIR', 0, '', 21, 1, 'Active', 0),
(1530, 'GR-TR-23', 'TRANSMISION GASKET-GANTI/SEALE', 0, '', 21, 1, 'Active', 0),
(1531, 'GR-TR-24', 'TRANSMISION MOUNTING-GANTI', 0, '', 21, 1, 'Active', 0),
(1532, 'GR-TR-25', 'TRANSMISION STICK-REPAIR/STEL/', 0, '', 21, 1, 'Active', 0),
(1533, 'GR-TR-26', 'TRANSMISION-OVERHAUL', 0, '', 21, 1, 'Active', 0),
(1534, 'TBA-WH-1', 'BALANCE 5 RODA', 0, '', 24, 3, 'Active', 0),
(1535, 'GR-WH-1', 'BEARING KNUCKLE/KING PIN-GT-1', 0, '', 22, 1, 'Active', 0),
(1536, 'GR-WH-2', 'BEARING KNUCKLE/KING PIN-GT-2', 0, '', 22, 1, 'Active', 0),
(1537, 'GR-WH-3', 'CROSS RODA (2 BAN)', 0, '', 22, 1, 'Active', 0),
(1538, 'GR-WH-4', 'GREASE BEARING RODA FR', 0, '', 22, 1, 'Active', 0),
(1539, 'GR-WH-5', 'OUTPUT SHAFT BEARING-GT', 0, '', 22, 1, 'Active', 0),
(1540, 'GR-WH-6', 'POWER WINDOW REP', 0, '', 22, 1, 'Active', 0),
(1541, 'GR-WH-7', 'RELIES BEARING-(GT)', 0, '', 22, 1, 'Active', 0),
(1542, 'GR-WH-8', 'SEAL AS RODA-GT', 0, '', 22, 1, 'Active', 0),
(1543, 'GR-WH-9', 'SEAL RODA BLK.-GANTI (1 PCS)', 0, '', 22, 1, 'Active', 0),
(1544, 'GR-WH-10', 'SEAL RODA BLK.-GANTI (2 PCS)', 0, '', 22, 1, 'Active', 0),
(1545, 'GR-WH-11', 'SEAL RODA FRONT RH REP/GT', 0, '', 22, 1, 'Active', 0),
(1546, 'GR-WH-12', 'STERING WHELL LURUSKAN', 0, '', 22, 1, 'Active', 0),
(1547, 'GR-WH-13', 'TENSIONER BEARING-GT', 0, '', 22, 1, 'Active', 0),
(1548, 'GR-WH-14', 'TIE ROD FR RH GT', 0, '', 22, 1, 'Active', 0),
(1549, 'GR-WH-15', 'WHEEL BEARING FRONT-STEL (1 PC', 0, '', 22, 1, 'Active', 0),
(1550, 'GR-WH-16', 'WHEEL BEARING FRONT-STEL (2 PC', 0, '', 22, 1, 'Active', 0),
(1551, 'GR-WH-17', 'WHEEL BEARING FRONT-STEL 1PCS', 0, '', 22, 1, 'Active', 0),
(1552, 'GR-WH-18', 'WHEEL BEARING REAR-GANTI (1 PC', 0, '', 22, 1, 'Active', 0),
(1553, 'GR-WH-19', 'WHEEL BEARING REAR-GANTI (2 PC', 0, '', 22, 1, 'Active', 0),
(1554, 'GR-WH-20', 'WHEEL BEARING REAR-STEL (1 PCS', 0, '', 22, 1, 'Active', 0),
(1555, 'GR-WH-21', 'WHEEL BEARING REAR-STEL (2 PCS', 0, '', 22, 1, 'Active', 0),
(1556, 'GR-WH-22', 'WHEEL BEARING/SEAL FRONT-GANTI', 0, '', 22, 1, 'Active', 0),
(1557, 'GR-WH-23', 'WHEEL HUB FRONT-GANTI (1 PCS)', 0, '', 22, 1, 'Active', 0),
(1558, 'GR-WH-24', 'WHEEL HUB FRONT-GANTI (2 PCS)', 0, '', 22, 1, 'Active', 0),
(1559, 'GR-WH-25', 'WHEEL HUB REAR-GANTI (1 PCS)', 0, '', 22, 1, 'Active', 0),
(1560, 'GR-WH-26', 'WHEEL HUB REAR-GANTI (2 PCS)', 0, '', 22, 1, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rims_service_category`
--

CREATE TABLE IF NOT EXISTS `rims_service_category` (
`id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `service_number` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `service_type_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `rims_service_category`
--

INSERT INTO `rims_service_category` (`id`, `code`, `service_number`, `name`, `status`, `service_type_id`) VALUES
(1, ' AC ', 0, ' ACCESSORIES ', 'Active', 1),
(2, ' BE ', 0, ' BODY ELECTRICAL ', 'Active', 2),
(3, ' BX ', 0, ' BODY EXTERIOR ', 'Active', 2),
(4, ' BI ', 0, ' BODY INTERIOR ', 'Active', 2),
(5, ' BP ', 0, ' BODY PARTS ', 'Active', 2),
(6, ' BS ', 0, ' BRAKE SYSTEM ', 'Active', 1),
(7, ' CP ', 0, ' CHANGE & PAINT BODY ', 'Active', 2),
(8, ' CL ', 0, ' CLUTCH SYSTEM ', 'Active', 1),
(9, ' CS ', 0, ' COOLING SYSTEM ', 'Active', 1),
(10, ' DF ', 0, ' DIFFERENTIAL ', 'Active', 1),
(11, ' EF ', 0, ' EFI ', 'Active', 1),
(12, ' EL ', 0, ' ELECTRICAL ', 'Active', 1),
(13, ' EN ', 0, ' ENGINE ', 'Active', 1),
(14, ' FS ', 0, ' FUEL SYSTEM ', 'Active', 1),
(15, ' MT ', 0, ' MAINTENANCE ', 'Active', 1),
(16, ' PS ', 0, ' PROPELER SHAFT ', 'Active', 1),
(17, ' RP ', 0, ' REPAIR & PAINT BODY ', 'Active', 2),
(18, ' SV ', 0, ' SERVICE ', 'Active', 1),
(19, ' SS ', 0, ' STEERING SYSTEM ', 'Active', 1),
(20, ' SU ', 0, ' SUSPENSION ', 'Active', 1),
(21, ' TR ', 0, ' TRANSMISSION ', 'Active', 1),
(22, ' WH ', 0, ' WHEEL ', 'Active', 1),
(23, 'SS', 1, 'STEERING SYSTEM', 'Active', 3),
(24, 'WH', 1, 'WHEEL', 'Active', 3);

-- --------------------------------------------------------

--
-- Table structure for table `rims_service_equipment`
--

CREATE TABLE IF NOT EXISTS `rims_service_equipment` (
`id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_service_material_usage`
--

CREATE TABLE IF NOT EXISTS `rims_service_material_usage` (
`id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_service_product`
--

CREATE TABLE IF NOT EXISTS `rims_service_product` (
`id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_service_type`
--

CREATE TABLE IF NOT EXISTS `rims_service_type` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rims_service_type`
--

INSERT INTO `rims_service_type` (`id`, `name`, `status`, `code`) VALUES
(1, 'General Repair', 'Active', 'GR'),
(2, 'Body Repair', 'Active', 'BR'),
(3, 'TBA (Tire Balancing Accessorie', 'Active', 'TBA'),
(4, 'Oil', 'Active', 'O'),
(5, 'Car Wash', 'Active', 'W');

-- --------------------------------------------------------

--
-- Table structure for table `rims_sub_brand`
--

CREATE TABLE IF NOT EXISTS `rims_sub_brand` (
`id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rims_sub_brand`
--

INSERT INTO `rims_sub_brand` (`id`, `brand_id`, `name`) VALUES
(1, 2, 'Premium');

-- --------------------------------------------------------

--
-- Table structure for table `rims_sub_brand_series`
--

CREATE TABLE IF NOT EXISTS `rims_sub_brand_series` (
`id` int(11) NOT NULL,
  `sub_brand_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rims_sub_brand_series`
--

INSERT INTO `rims_sub_brand_series` (`id`, `sub_brand_id`, `name`) VALUES
(1, 1, 'NS40');

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
  `tenor` int(11) NOT NULL,
  `company_attribute` varchar(10) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rims_supplier`
--

INSERT INTO `rims_supplier` (`id`, `date`, `code`, `name`, `company`, `position`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email_personal`, `email_company`, `npwp`, `description`, `tenor`, `company_attribute`) VALUES
(1, '2015-10-13', 'S-01', 'Supplier1', 'PT. Astra Internasional', 'Anything', 'Gading', 12, 42, '32121', '02198321212', 'supplier1@gmail.com', 'supplier1@astra.com', '123123123132132131', 'Testing', 30, NULL),
(2, '2015-10-15', 'S-02', 'Supplier 2', 'PT. ABCDEFEGESDFS', 'Marketing', 'JL 123450943402', 12, 40, '32121', '0219832121', 'supplier2@gmail.com', 'supplier2@abcdefghijklm.com', '123878983231', 'Testing2', 30, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `rims_supplier_bank`
--

INSERT INTO `rims_supplier_bank` (`id`, `bank_id`, `supplier_id`, `account_no`, `account_name`, `status`) VALUES
(2, 9, 2, '9231232131', 'Test', 'Active'),
(10, 4, 1, '132', 'Supplier1', 'Active'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rims_supplier_pic`
--

INSERT INTO `rims_supplier_pic` (`id`, `supplier_id`, `date`, `code`, `name`, `company`, `position`, `address`, `province_id`, `city_id`, `zipcode`, `fax`, `email_personal`, `email_company`, `npwp`, `description`, `status`) VALUES
(1, 1, '2015-10-28', 'pic 1', 'pic 1234', 'PT. Astra International', 'Purchasing', 'Testing', 12, 39, '11340', '02198321212', 'pic@gmail.com', 'pic@astra.com', '323138912313', 'Testing12345', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_pic_mobile`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_pic_mobile` (
`id` int(11) NOT NULL,
  `supplier_pic_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_supplier_pic_phone`
--

CREATE TABLE IF NOT EXISTS `rims_supplier_pic_phone` (
`id` int(11) NOT NULL,
  `supplier_pic_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_unit`
--

CREATE TABLE IF NOT EXISTS `rims_unit` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle_car_make`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle_car_make` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `rims_vehicle_car_make`
--

INSERT INTO `rims_vehicle_car_make` (`id`, `name`, `status`) VALUES
(1, 'Mercedes Benz', 'Active'),
(2, 'BMW', 'Active'),
(3, 'Audi', 'Active'),
(4, 'Honda', 'Active'),
(5, 'Toyota', 'Active'),
(6, 'Daihatsu', 'Active'),
(7, 'Nissan', 'Active'),
(8, 'Chevrolet', 'Active'),
(9, 'Isuzu', 'Active'),
(10, 'Mitsubishi', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle_car_model`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle_car_model` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(60) DEFAULT NULL,
  `car_make_id` int(11) NOT NULL COMMENT 'foreign key from vehicle brand table',
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `rims_vehicle_car_model`
--

INSERT INTO `rims_vehicle_car_model` (`id`, `name`, `description`, `car_make_id`, `status`) VALUES
(1, 'A-Class', NULL, 1, 'Active'),
(2, 'AMG-GT', NULL, 1, 'Active'),
(3, 'B-Class', NULL, 1, 'Active'),
(4, 'C-Class', NULL, 1, 'Active'),
(5, 'CLA-Class', NULL, 1, 'Active'),
(6, 'CLS-Class', NULL, 1, 'Active'),
(7, 'E-Class', NULL, 1, 'Active'),
(8, 'G-Class', NULL, 1, 'Active'),
(9, 'GLA-Class', NULL, 1, 'Active'),
(10, 'GL-Class', NULL, 1, 'Active'),
(11, 'GLK-Class', NULL, 1, 'Active'),
(12, 'M-Class', NULL, 1, 'Active'),
(13, 'S-Class', NULL, 1, 'Active'),
(14, 'SL-Class', NULL, 1, 'Active'),
(15, 'SLK-Class', NULL, 1, 'Active'),
(16, 'V-Class', NULL, 1, 'Active'),
(17, '1 Series', NULL, 2, 'Active'),
(18, '3 Series', NULL, 2, 'Active'),
(19, '5 Series', NULL, 2, 'Active'),
(20, '6 Series', NULL, 2, 'Active'),
(21, '7 Series', NULL, 2, 'Active'),
(22, 'X1', NULL, 2, 'Active'),
(23, 'X3', NULL, 2, 'Active'),
(24, 'X5', NULL, 2, 'Active'),
(25, 'X6', NULL, 2, 'Active'),
(26, 'Z4', NULL, 2, 'Active'),
(27, 'A1', NULL, 3, 'Active'),
(28, 'A3', NULL, 3, 'Active'),
(29, 'A4', NULL, 3, 'Active'),
(30, 'A5', NULL, 3, 'Active'),
(31, 'A6', NULL, 3, 'Active'),
(32, 'A7', NULL, 3, 'Active'),
(33, 'A8', NULL, 3, 'Active'),
(34, 'Q3', NULL, 3, 'Active'),
(35, 'Q5', NULL, 3, 'Active'),
(36, 'Q7', NULL, 3, 'Active'),
(37, 'R3', NULL, 3, 'Active'),
(38, 'R8', NULL, 3, 'Active'),
(39, 'RS3', NULL, 3, 'Active'),
(40, 'S3', NULL, 3, 'Active'),
(41, 'TT', NULL, 3, 'Active'),
(42, 'Accord', NULL, 4, 'Active'),
(43, 'Brio', NULL, 4, 'Active'),
(44, 'City', NULL, 4, 'Active'),
(45, 'Civic', NULL, 4, 'Active'),
(46, 'CR-V', NULL, 4, 'Active'),
(47, 'Freed', NULL, 4, 'Active'),
(48, 'Jazz', NULL, 4, 'Active'),
(49, 'Mobilio', NULL, 4, 'Active'),
(50, 'Odssey', NULL, 4, 'Active'),
(51, 'Stream', NULL, 4, 'Active'),
(52, '86', NULL, 5, 'Active'),
(53, 'Agya', NULL, 5, 'Active'),
(54, 'Alphard', NULL, 5, 'Active'),
(55, 'Avanza', NULL, 5, 'Active'),
(56, 'Camry', NULL, 5, 'Active'),
(57, 'Camry Hybrid', NULL, 5, 'Active'),
(58, 'Corolla', NULL, 5, 'Active'),
(59, 'Corolla Altis', NULL, 5, 'Active'),
(60, 'Crown', NULL, 5, 'Active'),
(61, 'Dyna', NULL, 5, 'Active'),
(62, 'Etios Valco', NULL, 5, 'Active'),
(63, 'Fortuner', NULL, 5, 'Active'),
(64, 'Hiace', NULL, 5, 'Active'),
(65, 'Hilux D-Cab', NULL, 5, 'Active'),
(66, 'Hilux S-Cab', NULL, 5, 'Active'),
(67, 'Innova', NULL, 5, 'Active'),
(68, 'Land Cruiser', NULL, 5, 'Active'),
(69, 'NAV1', NULL, 5, 'Active'),
(70, 'Prius Hybrid', NULL, 5, 'Active'),
(71, 'RAV4', NULL, 5, 'Active'),
(72, 'Rush', NULL, 5, 'Active'),
(73, 'Vios', NULL, 5, 'Active'),
(74, 'Wish', NULL, 5, 'Active'),
(75, 'Yaris', NULL, 5, 'Active'),
(76, 'Gran Max', NULL, 6, 'Active'),
(77, 'Hijet', NULL, 6, 'Active'),
(78, 'Kancil', NULL, 6, 'Active'),
(79, 'Luxio', NULL, 6, 'Active'),
(80, 'Sirion', NULL, 6, 'Active'),
(81, 'Taruna', NULL, 6, 'Active'),
(82, 'Terios', NULL, 6, 'Active'),
(83, 'Xenia', NULL, 6, 'Active'),
(84, 'Zebra', NULL, 6, 'Active'),
(85, 'Elgrand', NULL, 7, 'Active'),
(86, 'Evalia', NULL, 7, 'Active'),
(87, 'Frontier', NULL, 7, 'Active'),
(88, 'Grand Livina', NULL, 7, 'Active'),
(89, 'Juke', NULL, 7, 'Active'),
(90, 'Livina X-Gear', NULL, 7, 'Active'),
(91, 'March', NULL, 7, 'Active'),
(92, 'Serena', NULL, 7, 'Active'),
(93, 'Teana', NULL, 7, 'Active'),
(94, 'Terrano', NULL, 7, 'Active'),
(95, 'X-Trail', NULL, 7, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rims_vehicle_car_sub_detail`
--

CREATE TABLE IF NOT EXISTS `rims_vehicle_car_sub_detail` (
`id` int(11) NOT NULL,
  `car_make_id` int(11) NOT NULL,
  `car_model_id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `chasis_code` varchar(10) DEFAULT NULL,
  `assembly_year_start` varchar(10) NOT NULL,
  `assembly_year_end` varchar(10) NOT NULL,
  `transmission` varchar(30) NOT NULL,
  `fuel_type` varchar(20) NOT NULL,
  `power` int(11) NOT NULL,
  `drivetrain` varchar(10) NOT NULL,
  `description` text,
  `status` varchar(10) NOT NULL,
  `luxury_value` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=931 ;

--
-- Dumping data for table `rims_vehicle_car_sub_detail`
--

INSERT INTO `rims_vehicle_car_sub_detail` (`id`, `car_make_id`, `car_model_id`, `name`, `chasis_code`, `assembly_year_start`, `assembly_year_end`, `transmission`, `fuel_type`, `power`, `drivetrain`, `description`, `status`, `luxury_value`) VALUES
(1, 1, 1, 'A 150', 'W169', '2004', '2012', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(2, 1, 1, 'A 170', 'W169', '2004', '2012', 'Manual', 'Gasoline', 1700, '2WD', NULL, 'Active', NULL),
(3, 1, 1, 'A 200', 'W169', '2004', '2012', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(4, 1, 1, 'A 200 Turb', 'W169', '2004', '2012', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(5, 1, 1, 'A 160 CDI', 'W169', '2004', '2012', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(6, 1, 1, 'A 180 CDI', 'W169', '2004', '2012', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(7, 1, 1, 'A 200 CDI', 'W169', '2004', '2012', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(8, 1, 1, 'A 180 ', 'W176', '2012', 'present', 'Manual', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(9, 1, 1, 'A 200', 'W176', '2012', 'present', 'Manual', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(10, 1, 1, 'A 250', 'W176', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(11, 1, 1, 'A 250 4MAT', 'W176', '2013', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(12, 1, 1, 'A 250 Spor', 'W176', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(13, 1, 1, 'A 45 AMG', 'W176', '2013', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(14, 1, 1, 'A 160 CDI', 'W176', '2013', 'present', 'Manual', 'Diesel', 1500, '2WD', NULL, 'Active', NULL),
(15, 1, 1, 'A 180 CDI', 'W176', '2012', 'present', 'Manual', 'Diesel', 1500, '2WD', NULL, 'Active', NULL),
(16, 1, 1, 'A 180 CDI', 'W176', '2012', '2014', 'Automatic', 'Diesel', 1800, '2WD', NULL, 'Active', NULL),
(17, 1, 1, 'A 200 CDI', 'W176', '2012', '2014', 'Manual', 'Diesel', 1800, '2WD', NULL, 'Active', NULL),
(18, 1, 1, 'A 200 CDI', 'W176', '2014', 'present', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(19, 1, 1, 'A 220 CDI', 'W176', '2012', '2014', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(20, 1, 1, 'A 220 CDI', 'W176', '2014', 'present', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(21, 1, 3, 'B 160', 'W245', '2005', '2011', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(22, 1, 3, 'B 180', 'W245', '2005', '2011', 'Manual', 'Gasoline', 1700, '2WD', NULL, 'Active', NULL),
(23, 1, 3, 'B 200', 'W245', '2005', '2011', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(24, 1, 3, 'B 200 Turb', 'W245', '2005', '2011', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(25, 1, 3, 'B 180 CDI', 'W245', '2005', '2011', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(26, 1, 3, 'B 200 CDI', 'W245', '2005', '2011', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(27, 1, 3, 'B 170 NGT', 'W245', '2005', '2011', 'Manual', 'Gas', 2000, '2WD', NULL, 'Active', NULL),
(28, 1, 3, 'B 180', 'W246', '2011', 'present', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(29, 1, 3, 'B 200', 'W246', '2011', 'present', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(30, 1, 3, 'B 200', 'W246', '2013', 'present', 'Manual / Automatic', 'Gas', 2000, '2WD', NULL, 'Active', NULL),
(31, 1, 3, 'B 220 4MAT', 'W246', '2013', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(32, 1, 3, 'B 220 4MAT', 'W246', '2013', 'present', 'Manual / Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(33, 1, 3, 'B 250', 'W246', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(34, 1, 3, 'B 160 CDI', 'W246', '2013', 'present', 'Manual', 'Diesel', 1500, '2WD', NULL, 'Active', NULL),
(35, 1, 3, 'B 180 CDI', 'W246', '2013', 'present', 'Manual', 'Diesel', 1500, '2WD', NULL, 'Active', NULL),
(36, 1, 3, 'B 180 CDI', 'W246', '2013', 'present', 'Automatic', 'Diesel', 1800, '2WD', NULL, 'Active', NULL),
(37, 1, 3, 'B 180 CDI', 'W246', '2011', 'present', 'Manual / Automatic', 'Diesel', 1800, '2WD', NULL, 'Active', NULL),
(38, 1, 3, 'B 180 CDI', 'W246', '2013', 'present', 'Manual', 'Diesel', 1500, '2WD', NULL, 'Active', NULL),
(39, 1, 3, 'B 200 CDI', 'W246', '2011', 'present', 'Manual / Automatic', 'Diesel', 1800, '2WD', NULL, 'Active', NULL),
(40, 1, 3, 'B 220 CDI', 'W246', '2014', 'present', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(41, 1, 3, 'B 220 CDI', 'W246', '2012', 'present', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(42, 1, 4, 'C 180', 'W202', '1993', '2000', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(43, 1, 4, 'C 200', 'W202', '1993', '2000', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(44, 1, 4, 'C 220', 'W202', '1993', '2000', 'Automatic', 'Gasoline', 2200, '2WD', NULL, 'Active', NULL),
(45, 1, 4, 'C 200', 'W 203', '2000', '2007', 'Manual', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(46, 1, 4, 'C 240 ', 'W 203', '2000', '2007', 'Manual', 'Gasoline', 2600, '2WD', NULL, 'Active', NULL),
(47, 1, 4, ' C 200 CDI', 'W 203', '2000', '2007', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(48, 1, 4, 'C 180 Komp', 'W203', '2000', '2007', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(49, 1, 4, 'C 200 Komp', 'W203', '2000', '2007', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(50, 1, 4, 'C 240', 'W203', '2000', '2007', 'Automatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(51, 1, 4, 'C 280', 'W203', '2000', '2007', 'Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(52, 1, 4, 'C 320', 'W203', '2000', '2007', 'Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(53, 1, 4, 'C 350', 'W203', '2000', '2007', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(54, 1, 4, 'C 180 K', 'W204', '2007', '2014', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(55, 1, 4, 'C 200 K', 'W204', '2007', '2014', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(56, 1, 4, 'C 230', 'W204', '2007', '2014', 'Automatic', 'Gasoline', 2300, '2WD', NULL, 'Active', NULL),
(57, 1, 4, 'C 280', 'W204', '2007', '2014', 'Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(58, 1, 4, 'C 350', 'W204', '2007', '2014', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(59, 1, 4, 'C 200 CDI', 'W204', '2007', '2014', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(60, 1, 4, 'C 220 CDI', 'W204', '2007', '2014', 'Automatic', 'Gasoline', 2200, '2WD', NULL, 'Active', NULL),
(61, 1, 4, 'C 320 CDI', 'W204', '2007', '2014', 'Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(62, 1, 4, 'C 250', 'W205', '2014', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(63, 1, 5, 'CLA 180', 'C117', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(64, 1, 5, 'CLA 180 ', 'C117', '2013', 'present', 'Manual', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(65, 1, 5, 'CLA 200', 'C117', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(66, 1, 5, 'CLA 250', 'C117', '2013', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(67, 1, 5, 'CLA 250 4M', 'C117', '2013', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(68, 1, 5, 'CLA 45 AMG', 'C117', '2013', 'present', 'Sports', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(69, 1, 5, 'CLA 200 CD', 'C117', '2013', 'present', 'Manual / Automatic', 'Diesel', 1800, '2WD', NULL, 'Active', NULL),
(70, 1, 5, 'CLA 220 CD', 'C117', '2013', 'present', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(71, 1, 6, 'CLS 350', 'W219', '2004', '2010', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(72, 1, 6, 'CLS 350 CG', 'W219', '2004', '2010', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(73, 1, 6, 'CLS 500 ', 'W219', '2006', '2010', 'Automatic', 'Gasoline', 5000, '2WD', NULL, 'Active', NULL),
(74, 1, 6, 'CLS 550', 'W219', '2004', '2010', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(75, 1, 6, 'CLS 500 ', 'W219', '2007', '2010', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(76, 1, 6, 'CLS 55?AMG', 'W219', '2006', '2010', 'Automatic', 'Gasoline', 5400, '2WD', NULL, 'Active', NULL),
(77, 1, 6, 'CLS 63?AMG', 'W219', '2004', '2010', 'Automatic', 'Gasoline', 6200, '2WD', NULL, 'Active', NULL),
(78, 1, 6, 'CLS 250 CD', 'W219', '2004', '2010', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(79, 1, 6, 'CLS 320 CD', 'W219', '2004', '2010', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(80, 1, 6, 'CLS 350 CD', 'W219', '2004', '2010', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(81, 1, 6, 'CLS 350', 'S218', '2011', 'present', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(82, 1, 6, 'CLS 500', 'S218', '2011', 'present', 'Automatic', 'Gasoline', 5000, '2WD', NULL, 'Active', NULL),
(83, 1, 6, 'CLS 500 4M', 'S218', '2011', 'present', 'Automatic', 'Gasoline', 5000, '4WD', NULL, 'Active', NULL),
(84, 1, 6, 'CLS 63 AMG', 'S218', '2011', 'present', 'Sports', 'Gasoline', 5000, '2WD', NULL, 'Active', NULL),
(85, 1, 6, 'CLS 63 AMG', 'S218', '2011', 'present', 'Sports', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(86, 1, 6, 'CLS 63 AMG', 'S218', '2012', 'present', 'Sports', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(87, 1, 6, 'CLS 63 AMG', 'S218', '2013', 'present', 'Sports', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(88, 1, 6, 'CLS 63 AMG', 'S218', '2013', 'present', 'Sports', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(89, 1, 6, 'CLS 63 AMG', 'S218', '2013', 'present', 'Sports', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(90, 1, 6, 'CLS 250 CD', 'S218', '2011', 'present', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(91, 1, 6, 'CLS 320 CD', 'S218', '2011', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(92, 1, 6, 'CLS 350 CD', 'S218', '2011', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(93, 1, 6, 'CLS 350 CD', 'S218', '2011', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(94, 1, 7, 'E 200 CDI', 'W211', '2002', '2009', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(95, 1, 7, 'E 220 CDI', 'W211', '2002', '2009', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(96, 1, 7, 'E 280 CDI', 'W211', '2002', '2009', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(97, 1, 7, 'E 300 ', 'W211', '2002', '2009', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(98, 1, 7, 'E 320', 'W211', '2002', '2009', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(99, 1, 7, 'E 320 CDI ', 'W211', '2005', '2009', 'Automatic', 'Diesel', 3200, '2WD', NULL, 'Active', NULL),
(100, 1, 7, 'E 320 CDI', 'W211', '2002', '2009', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(101, 1, 7, 'E 420 CDI', 'W211', '2002', '2009', 'Automatic', 'Diesel', 4000, '2WD', NULL, 'Active', NULL),
(102, 1, 7, 'E 200 NGT', 'W211', '2002', '2009', 'Automatic', 'Gas', 1800, '2WD', NULL, 'Active', NULL),
(103, 1, 7, 'E 200 KOMP', 'W211', '2003', '2007', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(104, 1, 7, 'E 200 KOMP', 'W211', '2007', '2009', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(105, 1, 7, 'E 230', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(106, 1, 7, 'E 240', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 2600, '2WD', NULL, 'Active', NULL),
(107, 1, 7, 'E 280', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(108, 1, 7, 'E 320', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(109, 1, 7, 'E 350', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(110, 1, 7, 'E 350 CGI', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(111, 1, 7, 'E 500', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 5000, '2WD', NULL, 'Active', NULL),
(112, 1, 7, 'E 550', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(113, 1, 7, 'E 55 AMG', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(114, 1, 7, 'E 63 AMG', 'W211', '2002', '2009', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(115, 1, 7, 'E 200 CGI', 'W212', '2009', 'present', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(116, 1, 7, 'E 250 CGI', 'W212', '2009', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(117, 1, 7, 'E 300', 'W212', '2009', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(118, 1, 7, 'E 350 CGI', 'W212', '2009', 'present', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(119, 1, 7, 'E 350 4MAT', 'W212', '2009', 'present', 'Automatic', 'Gasoline', 3500, '4WD', NULL, 'Active', NULL),
(120, 1, 7, 'E 500 4MAT', 'W212', '2009', 'present', 'Automatic', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(121, 1, 7, 'E 63 AMG', 'W212', '2009', 'present', 'SPEEDSHIFT MCT 7-speed', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(122, 1, 7, 'E 200 CDI', 'W212', '2009', 'present', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(123, 1, 7, 'E 220 CDI', 'W212', '2009', 'present', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(124, 1, 7, 'E 250 CDI', 'W212', '2009', 'present', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(125, 1, 7, 'E 300 CDI', 'W212', '2009', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(126, 1, 7, 'E 350 CDI', 'W212', '2009', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(127, 1, 7, 'E 350', 'W212', '2009', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(128, 1, 7, 'E 350', 'W212', '2009', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(129, 1, 7, 'E 350 CDI ', 'W212', '2009', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(130, 1, 8, 'G 500', '463', '2006', 'present', 'Automatic', 'Gasoline', 5000, '4WD', NULL, 'Active', NULL),
(131, 1, 8, 'G 55 AMG', '463', '2006', '2012', 'Automatic', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(132, 1, 8, 'G 320 CDI', '463', '2006', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(133, 1, 8, 'G 500 Cabr', '464', '2012', '2013', 'Automatic', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(134, 1, 8, 'G 63 AMG', '464', '2012', 'present', 'Automatic', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(135, 1, 8, 'G 65 AMG', '464', '2012', 'present', 'Automatic', 'Gasoline', 6000, '4WD', NULL, 'Active', NULL),
(136, 1, 8, 'G 300 CDI ', '464', '2012', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(137, 1, 8, 'G 300 CDI ', '464', '2013', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(138, 1, 8, 'G 350', '464', '2012', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(139, 1, 10, 'GL 350', 'X164', '2007', '2012', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(140, 1, 10, 'GL 450', 'X164', '2007', '2012', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(141, 1, 10, 'GL 550', 'X164', '2007', '2012', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(142, 1, 10, 'GL 350', 'X166', '2012', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(143, 1, 10, 'GL 450', 'X166', '2012', 'present', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(144, 1, 10, 'GL 500', 'X166', '2012', 'present', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(145, 1, 10, 'GL 550', 'X166', '2012', 'present', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(146, 1, 10, 'GL 63 AMG', 'X166', '2012', 'present', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(147, 1, 9, 'GLA 180', '?', '2014', 'present', 'Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(148, 1, 9, 'GLA 200', '?', '2014', 'present', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(149, 1, 9, 'GLA 250', '?', '2014', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(150, 1, 9, 'GLA 250 4M', '?', '2014', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(151, 1, 9, 'GLA 45 AMG', '?', '2014', 'present', 'Sports', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(152, 1, 9, 'GLA 180 CD', '?', '2014', 'present', 'Manual / Automatic', 'Diesel', 1500, '2WD', NULL, 'Active', NULL),
(153, 1, 9, 'GLA 200 CD', '?', '2014', 'present', 'Manual / Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(154, 1, 9, 'GLA 200 CD', '?', '2014', 'present', 'Automatic', 'Diesel', 2200, '4WD', NULL, 'Active', NULL),
(155, 1, 9, 'GLA 220 CD', '?', '2014', 'present', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(156, 1, 9, 'GLA 220 CD', '?', '2014', 'present', 'Automatic', 'Diesel', 2200, '4WD', NULL, 'Active', NULL),
(157, 1, 11, 'GLK 280 4M', 'X204', '2008', '2009', 'Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(158, 1, 11, 'GLK 300 4M', 'X204', '2009', '2011', 'Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(159, 1, 11, 'GLK 350 4M', 'X204', '2008', '2011', 'Automatic', 'Gasoline', 3500, '4WD', NULL, 'Active', NULL),
(160, 1, 11, 'GLK 200 CD', 'X204', '2010', 'present', 'Manual / Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(161, 1, 11, 'GLK 220 CD', 'X204', '2009', 'present', 'Manual / Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(162, 1, 11, 'GLK 220 CD', 'X204', '2009', 'present', 'Automatic', 'Diesel', 2200, '4WD', NULL, 'Active', NULL),
(163, 1, 11, 'GLK 250 CD', 'X204', '2009', '2012', 'Automatic', 'Diesel', 2200, '4WD', NULL, 'Active', NULL),
(164, 1, 11, 'GLK 320 CD', 'X204', '2008', '2009', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(165, 1, 11, 'GLK 350 CD', 'X204', '2009', '2010', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(166, 1, 11, 'GLK 350 CD', 'X204', '2010', '2012', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(167, 1, 12, 'ML 300 CDI', 'W164', '2005', '2011', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(168, 1, 12, 'ML 350 CDI', 'W164', '2005', '2011', 'Automatic', 'Diesel', 3500, '2WD', NULL, 'Active', NULL),
(169, 1, 12, 'ML 420 CDI', 'W164', '2005', '2011', 'Automatic', 'Diesel', 4200, '2WD', NULL, 'Active', NULL),
(170, 1, 12, 'ML 450 CDI', 'W164', '2005', '2011', 'Automatic', 'Diesel', 4500, '2WD', NULL, 'Active', NULL),
(171, 1, 12, 'ML 350 4MA', 'W166', '2011', 'present', 'Automatic', 'Gasoline', 3500, '4WD', NULL, 'Active', NULL),
(172, 1, 12, 'ML 550 4MA', 'W166', '2011', 'present', 'Automatic', 'Gasoline', 4700, '4WD', NULL, 'Active', NULL),
(173, 1, 12, 'ML 63 AMG ', 'W166', '2011', 'present', 'Automatic', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(174, 1, 12, 'ML 250 4MA', 'W167', '2012', 'present', 'Automatic', 'Diesel', 5500, '4WD', NULL, 'Active', NULL),
(175, 1, 12, 'ML 350 4MA', 'W168', '2013', 'present', 'Automatic', 'Diesel', 5500, '4WD', NULL, 'Active', NULL),
(176, 1, 13, 'S 280 ', 'W221', '2007', '2013', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(177, 1, 13, 'S 300', 'W221', '2007', '2013', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(178, 1, 13, 'S 350', 'W221', '2005', '2009', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(179, 1, 13, 'S 350', 'W221', '2010', '2013', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(180, 1, 13, 'S 350 4MAT', 'W221', '2007', '2013', 'Automatic', 'Gasoline', 3500, '4WD', NULL, 'Active', NULL),
(181, 1, 13, 'S 400 HYBR', 'W221', '2009', '2013', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(182, 1, 13, 'S 450', 'W221', '2006', '2013', 'Automatic', 'Gasoline', 4700, '4WD', NULL, 'Active', NULL),
(183, 1, 13, ' S 450 4MA', 'W221', '2006', '2013', 'Automatic', 'Gasoline', 4700, '4WD', NULL, 'Active', NULL),
(184, 1, 13, 'S 500', 'W221', '2005', '2010', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(185, 1, 13, 'S 550', 'W221', '2005', '2010', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(186, 1, 13, 'S 500', 'W221', '2011', 'present', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(187, 1, 13, 'S 550', 'W221', '2011', 'present', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(188, 1, 13, 'S 500', 'W221', '2006', '2013', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(189, 1, 13, 'S 550 4MAT', 'W221', '2006', '2013', 'Automatic', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(190, 1, 13, 'S 600', 'W221', '2006', '2013', 'Automatic', 'Gasoline', 5600, '2WD', NULL, 'Active', NULL),
(191, 1, 13, 'S 600 Guar', 'W221', '2006', '2013', 'Automatic', 'Gasoline', 5600, '2WD', NULL, 'Active', NULL),
(192, 1, 13, 'S 600 Guar', 'W221', '2008', '2013', 'Automatic', 'Gasoline', 5600, '2WD', NULL, 'Active', NULL),
(193, 1, 13, 'S 63 AMG', 'W221', '2006', '2013', 'Automatic', 'Gasoline', 6300, '2WD', NULL, 'Active', NULL),
(194, 1, 13, 'S 65 AMG', 'W221', '2006', '2013', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(195, 1, 13, 'S 250 CDI', 'W221', '2009', '2013', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(196, 1, 13, 'S 300 HYBR', 'W221', '2009', '2010', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(197, 1, 13, 'S 320 CDI', 'W221', '2006', '2008', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(198, 1, 13, 'S 320 CDI ', 'W221', '2006', '2008', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(199, 1, 13, 'S 320 CDI ', 'W221', '2008', '2009', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(200, 1, 13, 'S 350 CDI', 'W221', '2009', '2013', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(201, 1, 13, 'S 350 CDI ', 'W221', '2012', '2013', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(202, 1, 13, 'S 350 4MAT', 'W221', '2012', '2013', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(203, 1, 13, 'S 420 CDI', 'W221', '2006', '2009', 'Automatic', 'Diesel', 4000, '2WD', NULL, 'Active', NULL),
(204, 1, 13, 'S 450 CDI', 'W221', '2009', '2011', 'Automatic', 'Diesel', 4000, '2WD', NULL, 'Active', NULL),
(205, 1, 13, 'S 320 L', 'W222', '2014', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(206, 1, 13, 'S 400 L', 'W222', '2013', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(207, 1, 13, 'S 400 HYBR', 'W222', '2013', 'present', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(208, 1, 13, 'S 500', 'W222', '2013', 'present', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(209, 1, 13, 'S 500 4Mat', 'W222', '2013', 'present', 'Automatic', 'Gasoline', 4700, '4WD', NULL, 'Active', NULL),
(210, 1, 13, 'S 500 HYBR', 'W222', '2014', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(211, 1, 13, 'S 500', 'W222', '2014', 'present', 'Automatic', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(212, 1, 13, 'S 600', 'W222', '2014', 'present', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(213, 1, 13, 'S 63 AMG', 'W222', '2013', 'present', 'Sports', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(214, 1, 13, 'S 63 AMG 4', 'W222', '2013', 'present', 'Sports', 'Gasoline', 5500, '4WD', NULL, 'Active', NULL),
(215, 1, 13, 'S 65 AMG', 'W222', '2013', 'present', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(216, 1, 13, 'S 300?HYBR', 'W222', '2013', 'present', 'Automatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(217, 1, 13, 'S 350?', 'W222', '2013', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(218, 1, 13, 'S 350?4Mat', 'W222', '2013', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(219, 1, 14, 'SL 350', 'R230', '2003', '2006', 'Automatic', 'Gasoline', 3800, '2WD', NULL, 'Active', NULL),
(220, 1, 14, 'SL 500', 'R230', '2003', '2006', 'Automatic', 'Gasoline', 5000, '2WD', NULL, 'Active', NULL),
(221, 1, 14, 'SL 55 AMG', 'R230', '2003', '2006', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(222, 1, 14, 'SL 600', 'R230', '2003', '2006', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(223, 1, 14, 'SL 65 AMG', 'R230', '2004', '2011', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(224, 1, 14, 'SL 280', 'R230', '2008', '2009', 'Sports', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(225, 1, 14, 'SL 300', 'R230', '2009', '2011', 'Sports', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(226, 1, 14, 'SL 350', 'R230', '2008', '2011', 'Sports', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(227, 1, 14, 'SL 500', 'R230', '2006', '2011', 'Sports', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(228, 1, 14, 'SL 550', 'R230', '2006', '2011', 'Sports', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(229, 1, 14, 'SL 63 AMG', 'R230', '2008', '2011', 'Sports', 'Gasoline', 6300, '2WD', NULL, 'Active', NULL),
(230, 1, 14, 'SL 600', 'R230', '2006', '2009', 'Sports', 'Gasoline', 5600, '2WD', NULL, 'Active', NULL),
(231, 1, 14, 'SL 65 AMG', 'R230', '2004', '2011', 'Sports', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(232, 1, 14, 'SL 65 AMG ', 'R230', '2008', '2011', 'Sports', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(233, 1, 14, 'SL 350 ', 'R231', '2012', 'present', 'Sports', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(234, 1, 14, 'SL 500', 'R231', '2012', 'present', 'Sports', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(235, 1, 14, 'SL 550', 'R231', '2012', 'present', 'Sports', 'Gasoline', 4700, '2WD', NULL, 'Active', NULL),
(236, 1, 14, 'SL 63 AMG', 'R231', '2012', 'present', 'Sports', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(237, 1, 14, 'SL 65 AMG', 'R231', '2012', 'present', 'Sports', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(238, 1, 15, 'SLK 200 KO', 'R171', '2004', '2008', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(239, 1, 15, 'SLK 280', 'R171', '2005', '2009', 'Manual / Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(240, 1, 15, 'SLK 300', 'R171', '2004', '2011', 'Manual / Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(241, 1, 15, 'SLK 350', 'R171', '2004', '2011', 'Manual / Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(242, 1, 15, 'SLK 55 AMG', 'R171', '2004', '2011', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(243, 1, 15, 'SLK 55 AMG', 'R171', '2006', '2008', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(244, 1, 15, 'SLK 200', 'R172', '2011', 'present', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(245, 1, 15, 'SLK 250', 'R172', '2011', 'present', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(246, 1, 15, 'SLK 350', 'R172', '2011', 'present', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(247, 1, 15, 'SLK 55 AMG', 'R172', '2011', 'present', 'Automatic', 'Gasoline', 5500, '2WD', NULL, 'Active', NULL),
(248, 1, 16, 'Viano 2.0 ', 'W639', '2004', '2007', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(249, 1, 16, 'Viano 2.0 ', 'W639', '2004', '2007', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(250, 1, 16, 'Viano 2.0 ', 'W639', '2007', '2010', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(251, 1, 16, 'Viano 2.0 ', 'W639', '2007', '2010', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(252, 1, 16, 'Viano 2.2 ', 'W639', '2004', '2010', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(253, 1, 16, 'Viano 2.2 ', 'W639', '2004', '2010', 'Manual', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(254, 1, 16, 'Viano 3.0 ', 'W639', '2006', '2010', 'Manual', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(255, 1, 16, 'Viano 3.0 ', 'W639', '2003', 'present', 'Manual', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(256, 1, 16, 'Viano 3.2 ', 'W639', '2003', 'present', 'Manual', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(257, 1, 16, 'Viano 3.7 ', 'W639', '2004', '2007', 'Manual', 'Gasoline', 2700, '2WD', NULL, 'Active', NULL),
(258, 1, 16, 'Viano 3.5 ', 'W639', '2003', 'present', 'Manual', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(259, 1, 16, 'Viano 4.4 ', 'W639', '2003', 'present', 'Manual', 'Gasoline', 4300, '2WD', NULL, 'Active', NULL),
(260, 1, 16, 'Viano 6.1 ', 'W639', '2003', 'present', 'Manual', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(261, 1, 2, 'AMG-GT', '', '2014', 'present', 'Sports', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(262, 1, 2, 'AMG-GT-S', '', '2014', 'present', 'Sports', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(263, 2, 18, '316ti', 'E46', '2000', '2004', 'Manual / Auomatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(264, 2, 18, '318ti', 'E46', '2000', '2004', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(265, 2, 18, '325ti', 'E46', '2000', '2004', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(266, 2, 18, '318td', 'E46', '2000', '2004', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(267, 2, 18, '320td', 'E46', '2000', '2004', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(268, 2, 21, '730i', 'E65-E68', '2002', '2008', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(269, 2, 21, '730Li', 'E65', '2002', '2008', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(270, 2, 21, '740i', 'E65', '2004', '2008', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(271, 2, 21, '740Li', 'E65', '2004', '2008', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(272, 2, 21, '750i', 'E65', '2004', '2008', 'Automatic', 'Gasoline', 4800, '2WD', NULL, 'Active', NULL),
(273, 2, 21, '750Li', 'E65', '2004', '2008', 'Automatic', 'Gasoline', 4800, '2WD', NULL, 'Active', NULL),
(274, 2, 21, '760i', 'E65', '2003', '2008', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(275, 2, 21, '760Li', 'E65', '2003', '2008', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(276, 2, 21, '730d*', 'E65', '2002', '2008', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(277, 2, 21, '730Ld*', 'E65', '2005', '2008', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(278, 2, 21, '745d**', 'E65', '2004', '2008', 'Automatic', 'Diesel', 4500, '2WD', NULL, 'Active', NULL),
(279, 2, 26, '2.2i', 'E85', '2003', '2005', 'Manual / Auomatic', 'Gasoline', 2200, '2WD', NULL, 'Active', NULL),
(280, 2, 26, '2.5i', 'E85', '2003', '2005', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(281, 2, 26, '2.5i', 'E85', '2006', '2008', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(282, 2, 26, '2.5si', 'E85', '2006', '2008', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(283, 2, 26, '3.0i', 'E85', '2002', '2005', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(284, 2, 26, '3.0i', 'E85', '2006', '2008', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(285, 2, 26, '3.0si', 'E85', '2006', '2008', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(286, 2, 26, 'M', 'E85', '2006', '2008', 'Manual / Auomatic', 'Gasoline', 3300, '2WD', NULL, 'Active', NULL),
(287, 2, 23, '2.0i', 'E83', '2004', '2010', 'Manual / Auomatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(288, 2, 23, '2.5i', 'E83', '2004', '2006', 'Manual / Auomatic', 'Gasoline', 2500, '2WD/4WD', NULL, 'Active', NULL),
(289, 2, 23, '2.5si', 'E83', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 2500, '2WD/4WD', NULL, 'Active', NULL),
(290, 2, 23, '3.0i', 'E83', '2004', '2006', 'Manual / Auomatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(291, 2, 23, '3.0si', 'E83', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(292, 2, 23, 'xDrive18d', 'E83', '2009', '2010', 'Manual / Auomatic', 'Diesel', 1800, '2WD/4WD', NULL, 'Active', NULL),
(293, 2, 23, '2.0d/ xDri', 'E83', '2005', '2007', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(294, 2, 23, 'X3 3.0d/ x', 'E83', '2003', '2004', 'Manual / Auomatic', 'Diesel', 3000, '2WD/4WD', NULL, 'Active', NULL),
(295, 2, 23, '3.0sd/ xDr', 'E83', '2007', '2010', 'Manual / Auomatic', 'Diesel', 3500, '2WD/4WD', NULL, 'Active', NULL),
(296, 2, 19, '520i', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(297, 2, 19, '523i', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 2500, '2WD/4WD', NULL, 'Active', NULL),
(298, 2, 19, '525i', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 2500, '2WD/4WD', NULL, 'Active', NULL),
(299, 2, 19, '525xi', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 2500, '2WD/4WD', NULL, 'Active', NULL),
(300, 2, 19, '530i', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(301, 2, 19, '530xi', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(302, 2, 19, '530i Secur', 'E60', '2008', 'present', 'Automatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(303, 2, 19, '535i', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(304, 2, 19, '540i', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 4000, '2WD/4WD', NULL, 'Active', NULL),
(305, 2, 19, '545i', 'E60', '2003', '2005', 'Manual / Auomatic', 'Gasoline', 4400, '2WD/4WD', NULL, 'Active', NULL),
(306, 2, 19, '550i', 'E60', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 4800, '2WD/4WD', NULL, 'Active', NULL),
(307, 2, 19, '550i Secur', 'E60', '2008', 'present', 'Automatic', 'Gasoline', 4800, '2WD/4WD', NULL, 'Active', NULL),
(308, 2, 19, 'M5', 'E60', '2007', '2010', 'Manual', 'Gasoline', 5000, '2WD/4WD', NULL, 'Active', NULL),
(309, 2, 19, 'ALPINA B5 ', 'E60', '2007', '2010', 'Sport', 'Gasoline', 4400, '2WD/4WD', NULL, 'Active', NULL),
(310, 2, 19, '520d', 'E60', '2007', '2010', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(311, 2, 19, '520d Editi', 'E60', '2007', '2010', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(312, 2, 19, '525d', 'E60', '2007', '2010', 'Manual / Auomatic', 'Diesel', 3000, '2WD/4WD', NULL, 'Active', NULL),
(313, 2, 19, '525xd', 'E60', '2007', '2010', 'Manual / Auomatic', 'Diesel', 3000, '2WD/4WD', NULL, 'Active', NULL),
(314, 2, 19, '530d', 'E60', '2007', '2010', 'Manual / Auomatic', 'Diesel', 3000, '2WD/4WD', NULL, 'Active', NULL),
(315, 2, 19, '530xd', 'E60', '2007', '2010', 'Manual / Auomatic', 'Diesel', 3000, '2WD/4WD', NULL, 'Active', NULL),
(316, 2, 19, '535d', 'E60', '2007', '2010', 'Automatic', 'Diesel', 3000, '2WD/4WD', NULL, 'Active', NULL),
(317, 2, 20, '630Ci', 'E63', '2005', '2007', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(318, 2, 20, '630i', 'E63', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(319, 2, 20, '635d', 'E63', '2007', '2010', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(320, 2, 20, '645Ci', 'E63', '2004', '2005', 'Manual / Auomatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(321, 2, 20, '650i', 'E63', '2006', '2010', 'Manual / Auomatic', 'Gasoline', 4800, '2WD', NULL, 'Active', NULL),
(322, 2, 24, '3.0si', 'E70', '2007', '2008', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(323, 2, 24, 'xDrive30i', 'E70', '2009', '2010', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(324, 2, 24, 'xDrive35i', 'E70', '2011', '2013', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(325, 2, 24, '4.8i', 'E70', '2007', '2008', 'Automatic', 'Gasoline', 4800, '2WD', NULL, 'Active', NULL),
(326, 2, 24, 'xDrive48i', 'E70', '2009', '2010', 'Automatic', 'Gasoline', 4800, '2WD', NULL, 'Active', NULL),
(327, 2, 24, 'xDrive50i', 'E70', '2011', '2013', 'Automatic', 'Gasoline', 5000, '2WD', NULL, 'Active', NULL),
(328, 2, 24, 'M', 'E70', '2010', '2013', 'Automatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(329, 2, 24, '3.0d', 'E70', '2007', '2008', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(330, 2, 24, 'xDrive30d', 'E70', '2009', '2010', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(331, 2, 24, 'xDrive30d', 'E70', '2011', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(332, 2, 24, '3.0sd', 'E70', '2007', '2008', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(333, 2, 24, 'xDrive35d', 'E70', '2009', '2013', 'Automatic', 'Diesel', 3500, '2WD', NULL, 'Active', NULL),
(334, 2, 25, 'xDrive35i ', 'E71', '2007', 'present', 'Automatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(335, 2, 25, 'xDrive35i ', 'E71', '2007', 'present', 'Automatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(336, 2, 25, 'xDrive50i', 'E71', '2007', 'present', 'Automatic', 'Gasoline', 4400, '2WD/4WD', NULL, 'Active', NULL),
(337, 2, 25, 'X6 M', 'E71', '2009', 'present', 'Automatic', 'Gasoline', 4400, '2WD/4WD', NULL, 'Active', NULL),
(338, 2, 25, 'ActiveHybr', 'E71', '2009', 'present', 'Automatic', 'Gasoline', 4400, '2WD/4WD', NULL, 'Active', NULL),
(339, 2, 17, '116i', 'E87', '2004', '2009', 'Manual / Auomatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(340, 2, 17, '118i', 'E87', '2005', '2011', 'Manual / Auomatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(341, 2, 17, '120i', 'E87', '2004', '2011', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(342, 2, 17, '125i', 'E87', '2008', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(343, 2, 17, '128i', 'E87', '2008', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(344, 2, 17, '130i', 'E87', '2006', '2012', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(345, 2, 17, '135i', 'E87', '2006', '2013', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(346, 2, 17, '116d', 'E87', '2009', '2011', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(347, 2, 17, '118d', 'E87', '2004', '2013', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(348, 2, 17, '120d', 'E87', '2004', '2013', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(349, 2, 17, '123d', 'E87', '2007', '2013', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(350, 2, 17, '114i', 'F20', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(351, 2, 17, '116i', 'F20', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(352, 2, 17, '118i', 'F20', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(353, 2, 17, '125i', 'F20', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(354, 2, 17, 'M135i', 'F20', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(355, 2, 17, 'M135i Xdri', 'F21', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(356, 2, 17, '114d', 'F20', '2011', 'present', 'Manual / Auomatic', 'Diesel', 1600, '2WD', NULL, 'Active', NULL),
(357, 2, 17, '116d', 'F20', '2011', 'present', 'Manual / Auomatic', 'Diesel', 1600, '2WD', NULL, 'Active', NULL),
(358, 2, 17, '116d Effic', 'F20', '2011', 'present', 'Manual / Auomatic', 'Diesel', 1600, '2WD', NULL, 'Active', NULL),
(359, 2, 17, '118d', 'F20', '2011', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(360, 2, 17, '120d', 'F20', '2011', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(361, 2, 17, '120d Xdriv', 'F21', '2012', 'present', 'Manual / Auomatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(362, 2, 17, '125d', 'F20', '2011', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(363, 2, 22, 'sDrive18i', 'E84', '2010', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(364, 2, 22, 'xDrive18i', 'E84', '2010', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(365, 2, 22, 'sDrive20i', 'E84', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(366, 2, 22, 'xDrive20i', 'E84', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(367, 2, 22, 'xDrive25i', 'E84', '2010', '2011', 'Automatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(368, 2, 22, 'xDrive28i', 'E84', '2009', '2011', 'Automatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(369, 2, 22, 'xDrive28i', 'E84', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(370, 2, 22, 'sDrive28i', 'E84', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(371, 2, 22, 'xDrive35i', 'E84', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(372, 2, 22, 'sDrive16d', 'E84', '2012', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(373, 2, 22, 'sDrive18d', 'E84', '2009', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(374, 2, 22, 'xDrive18d', 'E84', '2009', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(375, 2, 22, 'sDrive20d', 'E84', '2009', '2011', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(376, 2, 22, 'xDrive20d', 'E84', '2009', '2011', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(377, 2, 22, 'xDrive20d', 'E84', '2011', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(378, 2, 22, 'sDrive20d', 'E84', '2011', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(379, 2, 22, 'sDrive20d', 'E84', '2011', 'present', 'Manual', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(380, 2, 22, 'xDrive23d', 'E84', '2009', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(381, 2, 22, 'xDrive25d', 'E84', '2012', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD/4WD', NULL, 'Active', NULL),
(382, 2, 18, '316i', 'E90 - E93', '2006', '2011', 'Manual / Auomatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(383, 2, 18, '318i', 'E90 - E93', '2005', '2007', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(384, 2, 18, '318i', 'E90 - E93', '2007', '2011', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(385, 2, 18, '320i', 'E90 - E93', '2005', '2007', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(386, 2, 18, '320si', 'E90 - E93', '2006', '2011', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(387, 2, 18, '323i', 'E90 - E93', '2005', '2006', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(388, 2, 18, '323i', 'E90 - E93', '2007', '2011', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(389, 2, 18, '325i', 'E90 - E93', '2005', '2007', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(390, 2, 18, '325i xDriv', 'E90 - E93', '2006', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(391, 2, 18, '328i', 'E90 - E93', '2007', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(392, 2, 18, '328i xDriv', 'E90 - E93', '2007', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(393, 2, 18, '330i', 'E90 - E93', '2005', '2007', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(394, 2, 18, '330i xDriv', 'E90 - E93', '2007', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(395, 2, 18, '335i', 'E90 - E93', '2007', '2010', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(396, 2, 18, '335i xDriv', 'E90 - E93', '2011', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(397, 2, 18, '335is', 'E90 - E93', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(398, 2, 18, 'M3', 'E90 - E93', '2007', '2011', 'Manual / Auomatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(399, 2, 18, 'M3 GTS', 'E90 - E93', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(400, 2, 18, '316d', 'E90 - E93', '2009', '2011', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(401, 2, 18, '318d', 'E90 - E93', '2005', '2007', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(402, 2, 18, '318d', 'E90 - E93', '2007', '2011', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(403, 2, 18, '320d', 'E90 - E93', '2005', '2007', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(404, 2, 18, '320d', 'E90 - E93', '2007', '2010', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(405, 2, 18, '320d xDriv', 'E90 - E93', '2010', '2011', 'Manual / Auomatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(406, 2, 18, '320d Effic', 'E90 - E93', '2010', '2011', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(407, 2, 18, '325d', 'E90 - E93', '2006', '2010', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(408, 2, 18, '325d', 'E90 - E93', '2010', '2011', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(409, 2, 18, '330d', 'E90 - E93', '2005', '2011', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(410, 2, 18, '330d xDriv', 'E90 - E93', '2010', '2011', 'Manual / Auomatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(411, 2, 18, '335d BlueP', 'E90 - E93', '2009', '2011', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(412, 2, 18, '335d', 'E90 - E93', '2006', '2011', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(413, 2, 21, '730Li', 'F01', '2009', '2011', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(414, 2, 21, '740i/Li', 'F01', '2008', '2012', 'Automatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(415, 2, 21, '750i/Li', 'F01', '2008', '2012', 'Automatic', 'Gasoline', 3000, '2WD/4WD', NULL, 'Active', NULL),
(416, 2, 21, '750i/Li xD', 'F01', '2009', '2012', 'Automatic', 'Gasoline', 4500, '4WD', NULL, 'Active', NULL),
(417, 2, 21, '750Li High', 'F01', '2009', '2011', 'Automatic', 'Gasoline', 4500, '2WD', NULL, 'Active', NULL),
(418, 2, 21, '760i/Li', 'F01', '2009', '2011', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(419, 2, 21, '760Li High', 'F01', '2009', '2011', 'Automatic', 'Gasoline', 4500, '2WD', NULL, 'Active', NULL),
(420, 2, 21, 'ActiveHybr', 'F01', '2009', '2011', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(421, 2, 21, 'ActiveHybr', 'F01', '2010', '2011', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(422, 2, 21, 'ALPINA B7', 'F01', '2010', '2011', 'Automatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(423, 2, 21, 'ALPINA B7 ', 'F01', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 4400, '4WD', NULL, 'Active', NULL),
(424, 2, 21, '730d', 'F01', '2008', '2012', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(425, 2, 21, '730Ld', 'F01', '2009', '2012', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(426, 2, 21, '740d', 'F01', '2009', '2012', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(427, 2, 21, '740d xDriv', 'F01', '2010', '2012', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(428, 2, 21, '730i/Li', '', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(429, 2, 21, '740i/Li', '', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(430, 2, 21, '740Li xDri', '', '2012', 'present', 'Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(431, 2, 21, '750i', '', '2012', 'present', 'Automatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(432, 2, 21, '750Li', '', '2012', 'present', 'Automatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(433, 2, 21, '750i/Li xD', '', '2012', 'present', 'Automatic', 'Gasoline', 4400, '4WD', NULL, 'Active', NULL),
(434, 2, 21, '760i/Li', '', '2012', 'present', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(435, 2, 21, 'ActiveHybr', '', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(436, 2, 21, 'ALPINA B7 ', '', '2012', 'present', 'Automatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(437, 2, 21, 'ALPINA B7 ', '', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 4400, '4WD', NULL, 'Active', NULL),
(438, 2, 21, '730d/Ld', '', '2012', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(439, 2, 21, '730d xDriv', '', '2012', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(440, 2, 21, '740d', '', '2012', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(441, 2, 21, '740d xDriv', '', '2012', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(442, 2, 21, '750d/Ld xD', '', '2012', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(443, 2, 26, 'sDrive18i', 'E89', '2013', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(444, 2, 26, 'sDrive20i', 'E89', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(445, 2, 26, 'sDrive23i', 'E89', '2009', '2011', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(446, 2, 26, 'sDrive28i', 'E89', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(447, 2, 26, 'sDrive30i', 'E89', '2009', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(448, 2, 26, 'sDrive35i', 'E89', '2009', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(449, 2, 26, 'sDrive35is', 'E89', '2010', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(450, 2, 19, '523i', '', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(451, 2, 19, '523Li', '', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(452, 2, 19, '528i ', '', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(453, 2, 19, '535i', '', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL);
INSERT INTO `rims_vehicle_car_sub_detail` (`id`, `car_make_id`, `car_model_id`, `name`, `chasis_code`, `assembly_year_start`, `assembly_year_end`, `transmission`, `fuel_type`, `power`, `drivetrain`, `description`, `status`, `luxury_value`) VALUES
(454, 2, 19, '535i xDriv', '', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(455, 2, 19, '535Li', '', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(456, 2, 19, '550i', '', '2010', '2013', 'Manual / Auomatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(457, 2, 19, '550i xDriv', '', '2010', '2011', 'Manual / Auomatic', 'Gasoline', 4400, '4WD', NULL, 'Active', NULL),
(458, 2, 19, '518d', '', '2010', '2011', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(459, 2, 19, '520d', '', '2010', '2011', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(460, 2, 19, '525d', '', '2010', '2011', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(461, 2, 19, '530d', '', '2010', '2011', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(462, 2, 19, '530d xDriv', '', '2010', '2011', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(463, 2, 19, '535d', '', '2010', '2011', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(464, 2, 19, '520i', '', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(465, 2, 19, '528i', '', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(466, 2, 19, '528i xDriv', '', '2011', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(467, 2, 19, '530i', '', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(468, 2, 19, '535i', '', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(469, 2, 19, '535i xDriv', '', '2011', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(470, 2, 19, '550i', '', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(471, 2, 19, '550i xDriv', '', '2011', 'present', 'Automatic', 'Gasoline', 4400, '4WD', NULL, 'Active', NULL),
(472, 2, 19, 'M5', '', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(473, 2, 19, 'ALPINA B5 ', '', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(474, 2, 19, 'ActiveHybr', '', '2011', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(475, 2, 19, '520d', '', '2011', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(476, 2, 19, '525d', '', '2011', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(477, 2, 19, '525d xDriv', '', '2011', 'present', 'Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(478, 2, 19, '530d', '', '2011', 'present', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(479, 2, 19, '530d xDriv', '', '2011', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(480, 2, 19, '535d', '', '2011', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(481, 2, 19, '535d xDriv', '', '2011', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(482, 2, 19, 'M550d xDri', '', '2012', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(483, 2, 19, 'ALPINA D5 ', '', '2011', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(484, 2, 20, '640i', '', '2011', 'present', 'Automatic', 'Gasoline', 0, '2WD', NULL, 'Active', NULL),
(485, 2, 20, '640i xDriv', '', '2013', 'present', 'Automatic', 'Gasoline', 0, '4WD', NULL, 'Active', NULL),
(486, 2, 20, '650i', '', '2011', '2012', 'Automatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(487, 2, 20, '650i', '', '2012', 'present', 'Automatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(488, 2, 20, 'M6', '', '2012', 'present', 'Automatic', 'Gasoline', 4400, '2WD', NULL, 'Active', NULL),
(489, 2, 20, '640d', '', '2012', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(490, 2, 20, '640d xDriv', '', '2012', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(491, 2, 23, 'xDrive20i', '', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(492, 2, 23, 'xDrive28i', '', '2010', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(493, 2, 23, 'xDrive35i', '', '2010', 'present', 'Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(494, 2, 23, 'sDrive18d', '', '2012', 'present', 'Manual / Auomatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(495, 2, 23, 'xDrive20d', '', '2010', 'present', 'Manual / Auomatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(496, 2, 23, 'xDrive30d', '', '2011', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(497, 2, 23, 'xDrive35d', '', '2011', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(498, 2, 18, '316i', 'F30', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(499, 2, 18, '320i', 'F30', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(500, 2, 18, '320i Effic', 'F30', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(501, 2, 18, '320i xDriv', 'F30', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(502, 2, 18, '328i', 'F30', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(503, 2, 18, '328i xDriv', 'F30', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(504, 2, 18, '335i', 'F30', '2011', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(505, 2, 18, '335i xDriv', 'F30', '2012', 'present', 'Manual / Auomatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(506, 2, 18, 'ALPINA B3 ', 'F30', '2013', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(507, 2, 18, 'ALPINA B3 ', 'F30', '2013', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(508, 2, 18, 'ActiveHybr', 'F30', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(509, 2, 18, '316d', 'F30', '2012', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(510, 2, 18, '318d', 'F30', '2012', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(511, 2, 18, '320d', 'F30', '2011', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(512, 2, 18, '320d xDriv', 'F30', '2012', 'present', 'Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(513, 2, 18, '325d', 'F30', '2013', 'present', 'Manual / Auomatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(514, 2, 18, '330d', 'F30', '2012', 'present', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(515, 2, 18, '330d xDriv', 'F30', '2013', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(516, 2, 18, '335d', 'F30', '2013', 'present', 'Manual / Auomatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(517, 2, 18, '335d xDriv', 'F30', '2013', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(518, 2, 24, 'xDrive35i', 'F15', '2013', 'present', 'Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(519, 2, 24, 'xDrive50i', 'F15', '2013', 'present', 'Automatic', 'Gasoline', 4400, '4WD', NULL, 'Active', NULL),
(520, 2, 24, 'sDrive25d', 'F15', '2013', 'present', 'Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(521, 2, 24, 'xDrive25d', 'F15', '2013', 'present', 'Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(522, 2, 24, 'xDrive30d', 'F15', '2013', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(523, 2, 24, 'xDrive40d', 'F15', '2013', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(524, 2, 24, 'M50d', 'F15', '2013', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(525, 3, 27, 'A1 1.2 TFS', '', '2010', 'present', 'Manual', 'Gasoline', 1200, '2WD', NULL, 'Active', NULL),
(526, 3, 27, 'A1 1.4 TFS', '', '2010', 'present', 'Manual / Automatic', 'Gasoline', 1400, '2WD', NULL, 'Active', NULL),
(527, 3, 27, 'A1 1.4 TFS', '', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1400, '2WD', NULL, 'Active', NULL),
(528, 3, 27, 'A1 1.4 TFS', '', '2010', 'present', 'Automatic', 'Gasoline', 1400, '2WD', NULL, 'Active', NULL),
(529, 3, 27, 'A1 quattro', '', '2012', 'present', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(530, 3, 27, 'A1 1.6 TDI', '', '2011', 'present', 'Manual / Automatic', 'Diesel', 1600, '2WD', NULL, 'Active', NULL),
(531, 3, 27, 'A1 1.6 TDI', '', '2010', 'present', 'Manual', 'Diesel', 1600, '2WD', NULL, 'Active', NULL),
(532, 3, 27, 'A1 2.0 TDI', '', '2011', 'present', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(533, 3, 28, '1.2 TFSI', '8P', '2010', '2013', 'Manual / Automatic', 'Gasoline', 1200, '2WD', NULL, 'Active', NULL),
(534, 3, 28, '1.4 TFSI', '8P', '2007', '2013', 'Manual / Automatic', 'Gasoline', 1400, '2WD', NULL, 'Active', NULL),
(535, 3, 28, '1.6', '8P', '2003', '2010', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(536, 3, 28, '1.6 FSI', '8P', '2003', '2007', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(537, 3, 28, '1.8 TFSI', '8P', '2007', '2013', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(538, 3, 28, '2.0 FSI', '8P', '2003', '2007', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(539, 3, 37, '2.0 TFSI', '8P', '2004', '2013', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(540, 3, 39, '2.5 TFSI', '8P', '2011', '2013', 'Automatic', 'Gasoline', 2500, '4WD', NULL, 'Active', NULL),
(541, 3, 28, '3.2 FSI', '8P', '2003', '2009', 'Manual / Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(542, 3, 28, '1.6 TDI', '8P', '2009', '2013', 'Manual / Automatic', 'Diesel', 1600, '2WD', NULL, 'Active', NULL),
(543, 3, 28, '1.9 TDI', '8P', '2003', '2009', 'Manual / Automatic', 'Diesel', 1900, '2WD', NULL, 'Active', NULL),
(544, 3, 28, '2.0 TDI', '8P', '2003', '2013', 'Manual / Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(545, 3, 28, '1.2 TFSI', '8V', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1200, '2WD', NULL, 'Active', NULL),
(546, 3, 28, '1.4 TFSI', '8V', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1400, '2WD', NULL, 'Active', NULL),
(547, 3, 28, '1.4 TFSI', '8V', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1400, '2WD', NULL, 'Active', NULL),
(548, 3, 28, '1.8 TFSI', '8V', '2013', 'present', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(549, 3, 28, '2.0 TFSI', '8V', '2013', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(550, 3, 40, '2.0 TFSI', '8V', '2013', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(551, 3, 28, '1.6 TDI', '8V', '2013', 'present', 'Manual / Automatic', 'Diesel', 1600, '2WD', NULL, 'Active', NULL),
(552, 3, 28, '2.0 TDI', '8V', '2013', 'present', 'Manual / Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(553, 3, 29, '1.6', 'B6', '2000', '2006', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(554, 3, 29, '2.0?20v', 'B6', '2000', '2006', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(555, 3, 29, '2.0?FSI', 'B6', '2000', '2006', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(556, 3, 29, '1.8T 20v', 'B6', '2000', '2006', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(557, 3, 29, '1.8T 20v ''', 'B6', '2000', '2006', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(558, 3, 29, '2.4 V6 30v', 'B6', '2000', '2006', 'Manual / Automatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(559, 3, 29, '3.0 V6 30v', 'B6', '2000', '2006', 'Manual / Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(560, 3, 29, '1.9 TDI', 'B6', '2000', '2006', 'Manual / Automatic', 'Diesel', 1900, '2WD', NULL, 'Active', NULL),
(561, 3, 29, '2.5 V6 TDI', 'B6', '2000', '2006', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(562, 3, 29, '1.6', 'B7', '2004', '2008', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(563, 3, 29, '1.8?T', 'B7', '2004', '2008', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(564, 3, 29, '1.8 T?quat', 'B7', '2004', '2008', 'Manual / Automatic', 'Gasoline', 1800, '4WD', NULL, 'Active', NULL),
(565, 3, 29, '2', 'B7', '2004', '2008', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(566, 3, 29, '2.0 TFSI', 'B7', '2004', '2008', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(567, 3, 29, '2.0 TFSI q', 'B7', '2004', '2008', 'Manual / Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(568, 3, 29, '3.2?V6?FSI', 'B7', '2004', '2008', 'Manual / Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(569, 3, 29, '3.2 V6 FSI', 'B7', '2004', '2008', 'Manual / Automatic', 'Gasoline', 3200, '4WD', NULL, 'Active', NULL),
(570, 3, 29, '1.9 TDI', 'B7', '2004', '2008', 'Manual / Automatic', 'Diesel', 1900, '2WD', NULL, 'Active', NULL),
(571, 3, 29, '2.0 TDI', 'B7', '2004', '2008', 'Manual / Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(572, 3, 29, '2.0 TDI?qu', 'B7', '2004', '2008', 'Manual / Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(573, 3, 29, '2.5?V6?TDI', 'B7', '2004', '2008', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(574, 3, 29, '2.7 V6 TDI', 'B7', '2004', '2008', 'Manual / Automatic', 'Diesel', 2700, '2WD', NULL, 'Active', NULL),
(575, 3, 29, '3.0 V6 TDI', 'B7', '2004', '2008', 'Manual / Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(576, 3, 29, '3.0 V6 TDI', 'B7', '2004', '2008', 'Manual / Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(577, 3, 29, '1.8 TFSI', 'B8', '2008', 'present', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(578, 3, 29, '1.8 TFSI q', 'B8', '2008', 'present', 'Manual / Automatic', 'Gasoline', 1800, '4WD', NULL, 'Active', NULL),
(579, 3, 29, '2.0 TFSI', 'B8', '2008', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(580, 3, 29, '2.0 TFSI q', 'B8', '2008', 'present', 'Manual / Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(581, 3, 29, '3.2 FSI', 'B8', '2008', 'present', 'Manual / Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(582, 3, 29, '3.2 FSI qu', 'B8', '2008', 'present', 'Manual / Automatic', 'Gasoline', 3200, '4WD', NULL, 'Active', NULL),
(583, 3, 29, 'S4 quattro', 'B8', '2008', 'present', 'Manual / Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(584, 3, 29, '2.0 TDI', 'B8', '2008', 'present', 'Manual / Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(585, 3, 29, '2.0 TDI e', 'B8', '2009', 'present', 'Manual / Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(586, 3, 29, '2.0 TDI qu', 'B8', '2007', 'present', 'Manual / Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(587, 3, 29, '2.0 TDI qu', 'B8', '2008', 'present', 'Manual / Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(588, 3, 29, '2.7 TDI', 'B8', '2007', 'present', 'Manual / Automatic', 'Diesel', 2700, '2WD', NULL, 'Active', NULL),
(589, 3, 29, '3.0 TDI qu', 'B8', '2007', 'present', 'Manual / Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(590, 3, 30, '1.8 TFSI C', '', '2007', '2008', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(591, 3, 30, '1.8 TFSI', '', '2009', 'present', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(592, 3, 30, '2.0 TFSI', '', '2008', '2011', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(593, 3, 30, '2.0 TFSI q', '', '2008', 'present', 'Manual / Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(594, 3, 30, '3.0 TFSI,', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(595, 3, 30, '3.0 TFSI q', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(596, 3, 30, '3.2 FSI', '', '2007', '2011', 'Manual / Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(597, 3, 30, '3.2 FSI qu', '', '2007', '2011', 'Manual / Automatic', 'Gasoline', 3200, '4WD', NULL, 'Active', NULL),
(598, 3, 30, 'S5 3.0 TFS', '', '2009', 'present', 'Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(599, 3, 30, 'S5 4.2 FSI', '', '2007', '2012', 'Manual / Automatic', 'Gasoline', 4200, '4WD', NULL, 'Active', NULL),
(600, 3, 30, 'RS5 4.2 FS', '', '2010', 'present', 'Automatic', 'Gasoline', 4200, '4WD', NULL, 'Active', NULL),
(601, 3, 30, '2.0 TDIe S', '', '2011', 'present', 'Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(602, 3, 30, '2.0 TDI Sp', '', '2009', 'present', 'Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(603, 3, 30, '2.0 TDI', '', '2008', '2011', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(604, 3, 30, '2.0 TDI qu', '', '2008', '2011', 'Manual', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(605, 3, 30, '2.0 TDI', '', '2011', 'present', 'Manual / Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(606, 3, 30, '2.7 TDI', '', '2007', '2011', 'Manual / Automatic', 'Diesel', 2700, '2WD', NULL, 'Active', NULL),
(607, 3, 30, '3.0 TDI qu', '', '2007', '2011', 'Manual / Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(608, 3, 31, '2.0  TFSI', 'C6', '2004', '2011', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(609, 3, 31, '2.4', 'C6', '2004', '2011', 'Manual / Automatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(610, 3, 31, '2.8 FSI', 'C6', '2004', '2011', 'Manual / Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(611, 3, 31, '3', 'C6', '2004', '2011', 'Manual / Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(612, 3, 31, '3.2 FSI', 'C6', '2004', '2011', 'Manual / Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(613, 3, 31, '4.2', 'C6', '2004', '2011', 'Manual / Automatic', 'Gasoline', 4200, '2WD', NULL, 'Active', NULL),
(614, 3, 31, '2.0 TDI', 'C6', '2004', '2011', 'Manual / Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(615, 3, 31, '2.7 TDI', 'C6', '2004', '2011', 'Manual / Automatic', 'Diesel', 2700, '2WD', NULL, 'Active', NULL),
(616, 3, 31, '3.0 TDI ', 'C6', '2004', '2011', 'Manual / Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(617, 3, 31, 'Hybrid', 'C7', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(618, 3, 31, '2.0 TFSI', 'C7', '2011', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(619, 3, 31, '2.0 TFSI', 'C7', '2011', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(620, 3, 31, '2.8 FSI', 'C7', '2011', 'present', 'Manual / Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(621, 3, 31, 'RS 6 4.0 F', 'C7', '2011', 'present', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(622, 3, 31, '2.5 FSI', 'C7', '2012', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(623, 3, 31, '3.0 TFSI', 'C7', '2011', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(624, 3, 31, '3.0 TFSI', 'C7', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(625, 3, 31, '2.8 35 FSI', 'C7', '2012', 'present', 'Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(626, 3, 31, '2.8 35 FSI', 'C7', '2012', 'present', 'Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(627, 3, 31, '3.0 50 TFS', 'C7', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(628, 3, 31, 'S6 4.0 TFS', 'C7', '2012', 'present', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(629, 3, 31, 'RS 6 4.0 T', 'C7', '2012', 'present', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(630, 3, 31, '2.0 TDI', 'C7', '2011', 'present', 'Manual / Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(631, 3, 31, '3.0 TDI ', 'C7', '2011', 'present', 'Manual / Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(632, 3, 31, '3.0 TDI cl', 'C7', '2011', 'present', 'Manual / Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(633, 3, 32, '2.8 FSI', '', '2010', 'present', 'Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(634, 3, 32, '2.8 FSI ', '', '2012', 'present', 'Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(635, 3, 32, '3.0 TFSI ', '', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(636, 3, 32, '3.0 TFSI', '', '2012', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(637, 3, 32, 'S7 4.0 TFS', '', '2012', 'present', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(638, 3, 32, 'RS 7 4.0 T', '', '2013', 'present', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(639, 3, 32, '3.0 TDI', '', '2010', 'present', 'Manual / Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(640, 3, 33, '2.8', 'D3', '2002', '2009', 'Automatic', 'Gasoline', 2800, '2WD', NULL, 'Active', NULL),
(641, 3, 33, '3', 'D3', '2002', '2009', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(642, 3, 33, '3.2', 'D3', '2002', '2009', 'Automatic', 'Gasoline', 3200, '2WD', NULL, 'Active', NULL),
(643, 3, 33, '3.7', 'D3', '2002', '2009', 'Automatic', 'Gasoline', 3700, '2WD', NULL, 'Active', NULL),
(644, 3, 33, '4.2', 'D3', '2002', '2009', 'Automatic', 'Gasoline', 4200, '2WD', NULL, 'Active', NULL),
(645, 3, 33, '5.2', 'D3', '2002', '2009', 'Automatic', 'Gasoline', 5200, '2WD', NULL, 'Active', NULL),
(646, 3, 33, '6', 'D3', '2002', '2009', 'Automatic', 'Gasoline', 6000, '2WD', NULL, 'Active', NULL),
(647, 3, 33, '3.0 TDI', 'D3', '2002', '2009', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(648, 3, 33, '4.0 TDI', 'D3', '2002', '2009', 'Automatic', 'Diesel', 4000, '2WD', NULL, 'Active', NULL),
(649, 3, 33, '4.2 TDI', 'D3', '2002', '2009', 'Automatic', 'Diesel', 4200, '2WD', NULL, 'Active', NULL),
(650, 3, 33, '2.0 TFSI h', 'D4', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(651, 3, 33, '3.0 TFSI', 'D4', '2010', 'present', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(652, 3, 33, '4.0 TFSI', 'D4', '2012', 'present', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(653, 3, 33, '4.2 FSI', 'D4', '2010', 'present', 'Automatic', 'Gasoline', 4200, '2WD', NULL, 'Active', NULL),
(654, 3, 33, '6.3 Securi', 'D4', '2010', 'present', 'Automatic', 'Gasoline', 6300, '2WD', NULL, 'Active', NULL),
(655, 3, 33, 'S8 4.0 TFS', 'D4', '2012', 'present', 'Automatic', 'Gasoline', 4000, '2WD', NULL, 'Active', NULL),
(656, 3, 33, '3.0 TDI', '', '2011', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(657, 3, 33, '3.0 TDI cl', '', '2010', 'present', 'Automatic', 'Diesel', 3000, '2WD', NULL, 'Active', NULL),
(658, 3, 33, '4.2 TDI', '', '2010', 'present', 'Automatic', 'Diesel', 4200, '2WD', NULL, 'Active', NULL),
(659, 3, 33, '4.2 TDI cl', '', '2013', 'present', 'Automatic', 'Diesel', 4200, '2WD', NULL, 'Active', NULL),
(660, 3, 41, '1.8 T', '8N', '1998', '2006', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(661, 3, 41, '1.8 quattr', '8N', '1998', '2006', 'Manual / Automatic', 'Gasoline', 1800, '4WD', NULL, 'Active', NULL),
(662, 3, 41, '1.8 T quat', '8N', '1998', '2006', 'Manual / Automatic', 'Gasoline', 1800, '4WD', NULL, 'Active', NULL),
(663, 3, 41, '3.2 V6 qua', '8N', '1998', '2006', 'Manual / Automatic', 'Gasoline', 3200, '4WD', NULL, 'Active', NULL),
(664, 3, 41, '1.8 TFSI', '8J', '2007', '2014', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(665, 3, 41, '2.0 TFSI', '8J', '2006', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD/4WD', NULL, 'Active', NULL),
(666, 3, 41, '3.2 V6?qua', '8J', '2006', '2010', 'Manual / Automatic', 'Gasoline', 3200, '4WD', NULL, 'Active', NULL),
(667, 3, 41, '2.0 TFSI T', '8J', '2008', 'present', 'Manual / Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(668, 3, 41, '2.5 R5 TFS', '8J', '2009', 'present', 'Manual / Automatic', 'Gasoline', 2500, '4WD', NULL, 'Active', NULL),
(669, 3, 41, '2.5 R5 TFS', '8J', '2012', 'present', 'Manual / Automatic', 'Gasoline', 2500, '4WD', NULL, 'Active', NULL),
(670, 3, 41, '2.0 TDI qu', '8J', '2008', 'present', 'Manual / Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(671, 3, 38, 'Coup? 4.2 ', '', '2006', 'present', 'Manual / Automatic', 'Gasoline', 4200, '4WD', NULL, 'Active', NULL),
(672, 3, 38, 'Spyder 4.2', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 4200, '4WD', NULL, 'Active', NULL),
(673, 3, 38, 'Coup? 5.2 ', '', '2008', 'present', 'Manual / Automatic', 'Gasoline', 5200, '4WD', NULL, 'Active', NULL),
(674, 3, 38, 'Spyder 5.2', '', '2009', 'present', 'Manual / Automatic', 'Gasoline', 5200, '4WD', NULL, 'Active', NULL),
(675, 3, 38, 'GT', '', '2010', '2013', 'Manual / Automatic', 'Gasoline', 5200, '2WD', NULL, 'Active', NULL),
(676, 3, 38, 'GT Spyder', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 5200, '2WD', NULL, 'Active', NULL),
(677, 3, 38, 'LMS ', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 5200, '2WD', NULL, 'Active', NULL),
(678, 3, 38, 'LMS ultra ', '', '2012', 'present', 'Manual / Automatic', 'Gasoline', 5200, '2WD', NULL, 'Active', NULL),
(679, 3, 38, 'GRAND-AM ', '', '2012', 'present', 'Manual / Automatic', 'Gasoline', 5200, '2WD', NULL, 'Active', NULL),
(680, 3, 34, '1.4 TFSI', '8U', '2014', 'present', 'Manual / Automatic', 'Gasoline', 1400, '2WD', NULL, 'Active', NULL),
(681, 3, 34, '2.0 TFSI q', '8U', '2011', 'present', 'Manual / Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(682, 3, 34, '2.0 TFSI q', '8U', '2011', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(683, 3, 34, '2.5 TFSI', '8U', '2012', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(684, 3, 34, '35 TFSI ', '8U', '2013', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(685, 3, 34, '35 TFSI qu', '8U', '2013', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(686, 3, 34, '40 TFSI qu', '8U', '2013', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(687, 3, 34, 'RS 2.5 TFS', '8U', '2012', 'present', 'Automatic', 'Gasoline', 2500, '4WD', NULL, 'Active', NULL),
(688, 3, 34, '2.0 TDI ', '8U', '2011', 'present', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(689, 3, 34, '2.0 TDI qu', '8U', '2012', 'present', 'Manual', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(690, 3, 34, '2.0 TDI qu', '8U', '2011', 'present', 'Automatic', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(691, 3, 35, '2.0 TFSI h', '8R', '2011', 'present', 'Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(692, 3, 35, '2.0 TFSI q', '8R', '2009', '2012', 'Manual', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(693, 3, 35, '2.0 TFSI q', '8R', '2008', '2012', 'Manual / Automatic', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(694, 3, 35, '2.0 TFSI q', '8R', '2011', 'present', 'Manual', 'Gasoline', 2000, '4WD', NULL, 'Active', NULL),
(695, 3, 35, '3.2 FSI qu', '8R', '2009', '2012', 'Automatic', 'Gasoline', 3200, '4WD', NULL, 'Active', NULL),
(696, 3, 35, '2.0 TDI ', '', '2009', 'present', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(697, 3, 35, '2.0 TDI qu', '', '2008', '2012', 'Manual', 'Diesel', 2000, '4WD', NULL, 'Active', NULL),
(698, 3, 35, '3.0 TDI qu', '', '2008', '2012', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(699, 3, 36, '3.6 FSI', '', '2008', '2009', 'Automatic', 'Gasoline', 3600, '4WD', NULL, 'Active', NULL),
(700, 3, 36, '4.2 FSI', '', '2008', '2009', 'Automatic', 'Gasoline', 4200, '4WD', NULL, 'Active', NULL),
(701, 3, 36, '3.0 TFSI', '', '2009', 'present', 'Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(702, 3, 36, '3.0 TFSI S', '', '2009', 'present', 'Automatic', 'Gasoline', 3000, '4WD', NULL, 'Active', NULL),
(703, 3, 36, '3.0 TDI', '', '2005', '2007', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(704, 3, 36, '3.0 TDI', '', '2007', '2009', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(705, 3, 36, '3.0 TDI cl', '', '2009', 'present', 'Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(706, 3, 36, '4.2 TDI', '', '2007', '2009', 'Automatic', 'Diesel', 4200, '4WD', NULL, 'Active', NULL),
(707, 3, 36, '6.0 TDI', '', '2008', 'present', 'Automatic', 'Diesel', 6000, '4WD', NULL, 'Active', NULL),
(708, 4, 42, '2.0 i V-TE', 'K20', '2003', '2007', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(709, 4, 42, '2.4 i V-TE', 'K20', '2003', '2007', 'Manual', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(710, 4, 42, '2.2 i-CDTi', 'K20', '2003', '2007', 'Manual', 'Gasoline', 2200, '2WD', NULL, 'Active', NULL),
(711, 4, 42, '2.0 i V-TE', '', '2008', '2012', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(712, 4, 42, '2.4 i V-TE', '', '2008', '2012', 'Manual', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(713, 4, 42, '2.2 i-CDTi', '', '2008', '2012', 'Manual', 'Gasoline', 2200, '2WD', NULL, 'Active', NULL),
(714, 4, 42, '2.0 L', '', '2012', 'present', 'Manual / auotmatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(715, 4, 42, '2.4 L', '', '2012', 'present', 'Manual / auotmatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(716, 4, 42, '3.5 L', '', '2012', 'present', 'Manual / auotmatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(717, 4, 42, 'Plug In Hy', '', '2012', 'present', 'Manual / auotmatic', 'Hybrid', 2000, '2WD', NULL, 'Active', NULL),
(718, 4, 43, '1.2 L', '', '2011', 'present', 'Manual / auotmatic', 'Gasoline', 1200, '2WD', NULL, 'Active', NULL),
(719, 4, 43, '1.3 L', '', '2011', 'present', 'Manual / auotmatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(720, 4, 44, '1.3?L L13A', '', '2002', '2007', 'Manual / auotmatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(721, 4, 44, '1.3?L L13A', '', '2002', '2007', 'Manual / auotmatic', 'Gasoline', 1300, '4WD', NULL, 'Active', NULL),
(722, 4, 44, '1.5?L L15A', '', '2002', '2007', 'Manual / auotmatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(723, 4, 44, '1.5?L L15A', '', '2002', '2007', 'Manual / auotmatic', 'Gasoline', 1500, '4WD', NULL, 'Active', NULL),
(724, 4, 44, '1.3 L i - ', '', '2008', '2014', 'Manual / auotmatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(725, 4, 44, '1.5 L i - ', '', '2008', '2014', 'Manual / auotmatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(726, 4, 44, '1.8 L i- V', '', '2008', '2014', 'Manual / auotmatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(727, 4, 44, '1.5 L i - ', '', '2013', 'present', 'Manual / auotmatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(728, 4, 45, '1.8', '', '2005', '2011', 'Manual / auotmatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(729, 4, 45, '2', '', '2005', '2011', 'Manual / auotmatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(730, 4, 45, '1.8', '', '2011', 'present', 'Manual / auotmatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(731, 4, 45, '2', '', '2011', 'present', 'Manual / auotmatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(732, 4, 46, '2', 'RD4-RD7', '2002', '2006', 'Manual / auotmatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(733, 4, 46, '2.2', 'RD4-RD7', '2002', '2006', 'Manual / auotmatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(734, 4, 46, '2.4', 'RD4-RD7', '2002', '2006', 'Manual / auotmatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(735, 4, 46, '2', 'RE1-RE5/RE', '2007', '2011', 'Manual / auotmatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(736, 4, 46, '2.2', 'RE1-RE5/RE', '2007', '2011', 'Manual / auotmatic', 'Diesel', 2200, '2WD', NULL, 'Active', NULL),
(737, 4, 46, '2.4', 'RE1-RE5/RE', '2007', '2011', 'Manual / auotmatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(738, 4, 46, '2', 'RM1/RM3/RM', '2011', 'present', 'Manual / auotmatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(739, 4, 46, '2.4', 'RM1/RM3/RM', '2011', 'present', 'Manual / auotmatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(740, 4, 47, '1.5 L', '', '2008', 'present', 'Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(741, 4, 48, '1.5 L i - ', 'GD3', '2001', '2008', 'Manual / auotmatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(742, 4, 48, '1.3 L', '', '2007', '2014', 'Manual / auotmatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(743, 4, 48, '13 G', '', '2014', 'present', 'Manual / auotmatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(744, 4, 48, '15 X', '', '2014', 'present', 'Manual / auotmatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(745, 4, 48, 'RS', '', '2014', 'present', 'Manual / auotmatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(746, 4, 49, '1.5 L?L15A', 'DD4', '2014', 'present', 'Manual / auotmatic', 'Diesel', 1500, '2WD', NULL, 'Active', NULL),
(747, 4, 49, '1.5 L?L15Z', 'DD4', '2014', 'present', 'Manual / auotmatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(748, 4, 49, 'RS', '', '2014', 'present', 'Manual / auotmatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(749, 4, 50, '2.4 L', 'RB1-RB2', '2003', '2008', 'Automatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(750, 4, 50, '2.4 L', 'RB1-RB2', '2003', '2008', 'Automatic', 'Gasoline', 2400, '4WD', NULL, 'Active', NULL),
(751, 4, 50, '2.4 L', 'RB3-RB4', '2008', 'present', 'Automatic', 'Gasoline', 2400, '2WD', NULL, 'Active', NULL),
(752, 4, 51, '1.7 L', 'RN1-RN5', '2000', '2006', 'Automatic', 'Gasoline', 1700, '2WD', NULL, 'Active', NULL),
(753, 4, 51, '2.0 L', 'RN1-RN5', '2000', '2006', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(754, 4, 51, '1.8 L ', 'RN6-RN8', '2006', 'present', 'Manual / auotmatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(755, 4, 51, '2.0 L', 'RN6-RN8', '2006', 'present', 'Manual / auotmatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(756, 5, 54, '2.4 L', '', '2002', '2008', 'Automatic', 'Gasoline', 2400, '2WD / 4WD', NULL, 'Active', NULL),
(757, 5, 54, '3.0 L', '', '2002', '2008', 'Automatic', 'Gasoline', 3000, '2WD / 4WD', NULL, 'Active', NULL),
(758, 5, 54, '2.4 L', '', '2008', 'present', 'Automatic', 'Gasoline', 2400, '2WD / 4WD', NULL, 'Active', NULL),
(759, 5, 54, '3.5 L', '', '2008', 'present', 'Automatic', 'Gasoline', 3500, '2WD / 4WD', NULL, 'Active', NULL),
(760, 5, 55, '1.3 E', '', '2003', '2011', 'Manual', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(761, 5, 55, '1.3 G', '', '2003', '2011', 'Manual', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(762, 5, 55, '1.5 S', '', '2006', '2011', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(763, 5, 55, '1.5 L', '', '2006', '2011', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(764, 5, 55, '1.3 E', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(765, 5, 55, '1.3 L', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(766, 5, 55, '1.5 L', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(767, 5, 55, 'Veloz', '', '2011', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(768, 5, 56, '2.4', 'XV30', '2001', '2006', 'Manual / Automatic', 'Gasoline', 2400, '2WD / 4WD', NULL, 'Active', NULL),
(769, 5, 56, '3', 'XV30', '2001', '2006', 'Manual / Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(770, 5, 56, '3.3', 'XV30', '2001', '2006', 'Manual / Automatic', 'Gasoline', 3300, '2WD', NULL, 'Active', NULL),
(771, 5, 56, '2.4', 'XV40', '2006', '2010', 'Manual / Automatic', 'Gasoline', 2400, '2WD / 4WD', NULL, 'Active', NULL),
(772, 5, 56, '2.5', 'XV40', '2006', '2010', 'Manual / Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(773, 5, 56, '3.5', 'XV40', '2006', '2010', 'Manual / Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(774, 5, 56, '2.5 G', '', '2011', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(775, 5, 56, '2.5 V', '', '2011', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(776, 5, 57, '2.5 LE', '', '2011', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(777, 5, 57, '2.5 XLE', '', '2011', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(778, 5, 58, '1.6 L', 'E120', '2000', '2006', 'Manual / Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(779, 5, 58, '1.8 L', 'E120/E130', '2000', '2006', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(780, 5, 59, '1.8 J', 'E140/E150', '2008', '2010', 'Manual', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(781, 5, 59, '1.8 E', 'E140/E150', '2006', '2013', 'Manual', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(782, 5, 59, '1.8 G', 'E140/E150', '2006', '2013', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(783, 5, 59, '2.0 V', 'E140/E150', '2006', '2013', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(784, 5, 59, '1.8 L', 'E170', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(785, 5, 60, '2.5 L', 'S180', '2003', '2008', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(786, 5, 60, '3.0 L', 'S180', '2003', '2008', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(787, 5, 60, '3.5 L', 'S180', '2003', '2008', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(788, 5, 60, '2.5 L', 'S200', '2008', '2012', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(789, 5, 60, '3.0 L', 'S200', '2008', '2012', 'Automatic', 'Gasoline', 3000, '2WD', NULL, 'Active', NULL),
(790, 5, 60, '3.5 L', 'S200', '2008', '2012', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(791, 5, 60, '4.6 L', 'S200', '2008', '2012', 'Automatic', 'Gasoline', 4600, '2WD', NULL, 'Active', NULL),
(792, 5, 60, '2.5 L', 'S210', '2012', 'present', 'Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(793, 5, 60, '3.5 L', 'S210', '2012', 'present', 'Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(794, 5, 60, '4.6 L', 'S210', '2012', 'present', 'Automatic', 'Gasoline', 4600, '2WD', NULL, 'Active', NULL),
(795, 5, 61, '1-1.5 tonn', 'U300-U400', '2000', 'present', 'Manual', 'Diesel', 3400, '2WD', NULL, 'Active', NULL),
(796, 5, 61, '2-3 tonner', 'U300-U500', '2000', 'present', 'Manual', 'Diesel', 3700, '2WD', NULL, 'Active', NULL),
(797, 5, 61, '1-1.5 tonn', 'U600-U800', '2011', 'present', 'Manual', 'Diesel', 3400, '2WD', NULL, 'Active', NULL),
(798, 5, 61, '2-3 tonner', 'U600-U800', '2011', 'present', 'Manual', 'Diesel', 3700, '2WD', NULL, 'Active', NULL),
(799, 5, 63, '2.5 L', '', '2005', 'present', 'Manual', 'Diesel', 2500, '4WD', NULL, 'Active', NULL),
(800, 5, 63, '2.5 G', '', '2005', 'present', 'Manual', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(801, 5, 63, '2.7 L', '', '2005', 'present', 'Manual / Automatic', 'Gasoline', 2700, '2WD', NULL, 'Active', NULL),
(802, 5, 63, '2.7 G', '', '2005', 'present', 'Manual / Automatic', 'Diesel', 2700, '2WD', NULL, 'Active', NULL),
(803, 5, 63, '2.7 V', '', '2005', 'present', 'Manual / Automatic', 'Diesel', 2700, '4WD', NULL, 'Active', NULL),
(804, 5, 63, '3.0 L', '', '2005', 'present', 'Manual / Automatic', 'Diesel', 3000, '4WD', NULL, 'Active', NULL),
(805, 5, 65, '2.5 G', '', '2005', 'present', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(806, 5, 65, '2.5 V', '', '2005', 'present', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(807, 5, 65, '2.5 E', '', '2005', 'present', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(808, 5, 66, '2.0 L', '', '2005', 'present', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(809, 5, 66, '2.0 L', '', '2005', 'present', 'Manual', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(810, 5, 66, '2.5 S', '', '2005', 'present', 'Manual', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(811, 5, 67, '2.0 J', '', '2004', 'present', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(812, 5, 67, '2.0 E', '', '2004', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(813, 5, 67, '2.0 G', '', '2004', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(814, 5, 67, '2.0 G Lux', '', '2004', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(815, 5, 67, '2.0 V', '', '2004', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(816, 5, 67, '2.0 V Lux', '', '2004', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(817, 5, 67, '2.7 V', '', '2004', 'present', 'Automatic', 'Gasoline', 2700, '2WD', NULL, 'Active', NULL),
(818, 5, 67, '2.5 J', '', '2004', 'present', 'Manual', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(819, 5, 67, '2.5 E', '', '2004', 'present', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(820, 5, 67, '2.5 G', '', '2004', 'present', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(821, 5, 67, '2.5 G Lux', '', '2004', 'present', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(822, 5, 67, '2.5 V', '', '2004', 'present', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(823, 5, 67, '2.5 V Lux', '', '2004', 'present', 'Manual / Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(824, 5, 68, '4.7 L', 'J100', '1998', '2007', 'Manual / Automatic', 'Gasoline', 4700, '2WD / 4WD', NULL, 'Active', NULL),
(825, 5, 68, '4.2 L', 'J100', '1998', '2007', 'Manual / Automatic', 'Diesel', 4200, '2WD / 4WD', NULL, 'Active', NULL),
(826, 5, 68, '4.5 L', 'J100', '1998', '2007', 'Manual / Automatic', 'Diesel', 4500, '2WD / 4WD', NULL, 'Active', NULL),
(827, 5, 68, '4.0 L', 'J200', '2007', 'present', 'Manual / Automatic', 'Gasoline', 4000, '2WD / 4WD', NULL, 'Active', NULL),
(828, 5, 68, '4.6 L', 'J200', '2007', 'present', 'Manual / Automatic', 'Gasoline', 4600, '2WD / 4WD', NULL, 'Active', NULL),
(829, 5, 68, '4.7 L', 'J200', '2007', 'present', 'Manual / Automatic', 'Gasoline', 4700, '2WD / 4WD', NULL, 'Active', NULL),
(830, 5, 68, '5.7 L', 'J200', '2007', 'present', 'Manual / Automatic', 'Gasoline', 5700, '2WD / 4WD', NULL, 'Active', NULL),
(831, 5, 68, '4.5 L', 'J200', '2007', 'present', 'Manual / Automatic', 'Diesel', 4500, '2WD / 4WD', NULL, 'Active', NULL),
(832, 5, 72, '1.5 TS', '', '2006', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(833, 5, 72, '1.5 TS Ext', '', '2007', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(834, 5, 72, '1.5 TX', '', '2008', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(835, 5, 73, '1.5 L', 'XP 40', '2002', '2007', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(836, 5, 73, '1.5 E', 'NCP 93', '2007', '2013', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(837, 5, 73, '1.5 G', 'NCP 93', '2007', '2013', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(838, 5, 73, '1.5 E', 'XP 150', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(839, 5, 73, '1.5 G', 'XP 150', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(840, 5, 75, '1.5 E', 'XP 90', '2006', '2013', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(841, 5, 75, '1.5 S', 'XP 90', '2006', '2013', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(842, 5, 75, '1.5 S Limi', 'XP 90', '2006', '2013', 'Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(843, 5, 75, '1.5 J', 'XP 90', '2009', '2013', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(844, 5, 75, '1.5 TRD Sp', 'XP 90', '2009', '2013', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(845, 5, 75, '1.5 E', 'XP 130', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(846, 5, 75, '1.5 G', 'XP 130', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(847, 5, 75, '1.5 TRD S', 'XP 130', '2013', 'present', 'Manual / Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(848, 5, 62, '1.2 G', 'NGK 10', '2011', 'present', 'Manual', 'Gasoline', 1200, '2WD', NULL, 'Active', NULL),
(849, 5, 62, '1.2 E', 'NGK 10', '2011', 'present', 'Manual', 'Gasoline', 1200, '2WD', NULL, 'Active', NULL),
(850, 5, 62, '1.2 JX', 'NGK 10', '2011', 'present', 'Manual', 'Gasoline', 1200, '2WD', NULL, 'Active', NULL),
(851, 5, 53, '1.0 E', '', '2012', 'present', 'Manual / Automatic', 'Gasoline', 1000, '2WD', NULL, 'Active', NULL),
(852, 5, 53, '1.0 G', '', '2012', 'present', 'Manual / Automatic', 'Gasoline', 1000, '2WD', NULL, 'Active', NULL),
(853, 5, 53, '1.0 TRD S', '', '2012', 'present', 'Manual / Automatic', 'Gasoline', 1000, '2WD', NULL, 'Active', NULL),
(854, 5, 69, '2.0 G', '', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(855, 5, 69, '2.0 V', '', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(856, 5, 71, '2.0 G', 'XA 40', '2013', 'present', 'Manual', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(857, 5, 64, 'High Grade', '', '2004', 'present', 'Manual', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(858, 5, 64, 'High Grade', '', '2004', 'present', 'Manual', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(859, 5, 52, '2.0 V', '', '2012', 'present', 'Manual / Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(860, 5, 52, '2.0 AERO', '', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(861, 5, 52, '2.0 TRD', '', '2012', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(862, 5, 70, 'Gen-3', '', '2013', 'present', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(863, 5, 74, '1.8 L', 'ZNE 10', '2003', '2009', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(864, 5, 74, '2.0 L', 'ZNE 10', '2003', '2009', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(865, 5, 74, '1.8 L', 'ZGE 20', '2009', 'present', 'Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(866, 5, 74, '2.0 L', 'ZGE 20', '2009', 'present', 'Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(867, 6, 78, '660EX', '', '1994', '2009', 'Manual', 'Gasoline', 660, '2WD', NULL, 'Active', NULL),
(868, 6, 78, '850EX', '', '1994', '2009', 'Manual', 'Gasoline', 850, '2WD', NULL, 'Active', NULL),
(869, 6, 78, '850EZi', '', '1994', '2009', 'Automatic', 'Gasoline', 850, '2WD', NULL, 'Active', NULL),
(870, 6, 77, '55 Wide', 'S60', '1977', '1981', 'Manual', 'Gasoline', 550, '2WD', NULL, 'Active', NULL),
(871, 6, 77, 'AB20/50?I2', 'S65', '1981', '1986', 'Manual', 'Gasoline', 550, '2WD', NULL, 'Active', NULL),
(872, 6, 77, 'AB55?turbo', 'S65', '1981', '1986', 'Manual', 'Gasoline', 550, '2WD', NULL, 'Active', NULL),
(873, 6, 77, 'CD?I3', 'S65', '1981', '1986', 'Manual', 'Gasoline', 850, '2WD', NULL, 'Active', NULL),
(874, 6, 77, 'CB?I3', 'S65', '1981', '1986', 'Manual', 'Gasoline', 1000, '2WD', NULL, 'Active', NULL),
(875, 6, 77, 'S 100', '', '1993', '1999', 'Manual', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(876, 6, 77, 'S 110', '', '1993', '1999', 'Manual', 'Gasoline', 1300, '4WD', NULL, 'Active', NULL),
(877, 6, 84, '1.0 L', '', '1999', '2002', 'Manual', 'Gasoline', 1000, '2WD', NULL, 'Active', NULL),
(878, 6, 84, '1.3 L', '', '1999', '2002', 'Manual', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(879, 6, 84, '1.6 L', '', '1999', '2002', 'Manual', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(880, 6, 84, '1.5 L', '', '2002', '2007', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(881, 6, 76, '1. 3 L ', '', '2007', 'present', 'Manual', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(882, 6, 76, '1.5 L', '', '2007', 'present', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(883, 6, 76, '1. 3 L pic', '', '2007', 'present', 'Manual', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(884, 6, 76, '1.5 L pick', '', '2007', 'present', 'Manual', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(885, 6, 79, '1.5 L', '', '2009', 'present', 'Manual/Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(886, 6, 80, '1.0 L', '', '2011', 'present', 'Manual/Automatic', 'Gasoline', 1000, '2WD', NULL, 'Active', NULL),
(887, 6, 80, '1.3 L', '', '2011', 'present', 'Manual/Automatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(888, 6, 81, 'OXXY', '', '2005', '2006', 'Manual/Automatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(889, 6, 82, '1.5 L', '', '2006', 'present', 'Manual/Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(890, 6, 83, '1.0 L', '', '2003', 'present', 'Manual/Automatic', 'Gasoline', 1000, '2WD', NULL, 'Active', NULL),
(891, 6, 83, '1.3 L', '', '2006', 'present', 'Manual/Automatic', 'Gasoline', 1300, '2WD', NULL, 'Active', NULL),
(892, 7, 86, '1.5 L', '', '2012', 'present', 'Manual/Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(893, 7, 86, '1.6 L', '', '2012', 'present', 'Manual/Automatic', 'Gasoline', 1600, '2WD', NULL, 'Active', NULL),
(894, 7, 86, '2.0 L', '', '2012', 'present', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(895, 7, 88, '1.5 L', 'L10', '2006', '2013', 'Manual/Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(896, 7, 88, '1.8 L', 'L10', '2006', '2013', 'Manual/Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(897, 7, 90, '1.5 L', 'L10', '2008', '2013', 'Manual/Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(898, 7, 88, '1.5 L', 'L11', '2013', 'present', 'Manual/Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(899, 7, 90, '1.5 L', 'L11', '2013', 'present', 'Manual/Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL),
(900, 7, 90, '1.8 L', 'L11', '2013', 'present', 'Manual/Automatic', 'Gasoline', 1800, '2WD', NULL, 'Active', NULL),
(901, 7, 91, '1.2 L', '', '2010', 'present', 'Manual/Automatic', 'Gasoline', 1200, '2WD', NULL, 'Active', NULL),
(902, 7, 91, '1.5 L', '', '2010', 'present', 'Manual/Automatic', 'Gasoline', 1500, '2WD', NULL, 'Active', NULL);
INSERT INTO `rims_vehicle_car_sub_detail` (`id`, `car_make_id`, `car_model_id`, `name`, `chasis_code`, `assembly_year_start`, `assembly_year_end`, `transmission`, `fuel_type`, `power`, `drivetrain`, `description`, `status`, `luxury_value`) VALUES
(903, 7, 95, '2.0 L', '', '2000', '2007', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(904, 7, 95, '2.2 L', '', '2000', '2007', 'Manual/Automatic', 'Gasoline', 2200, '2WD', NULL, 'Active', NULL),
(905, 7, 95, '2.5L', '', '2000', '2007', 'Manual/Automatic', 'Diesel', 2500, '2WD', NULL, 'Active', NULL),
(906, 7, 95, '2.0 L', '', '2007', '2013', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(907, 7, 95, '2.5 L', '', '2007', '2013', 'Manual/Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(908, 7, 95, '2.0 L', '', '2007', '2013', 'Manual/Automatic', 'Diesel', 2000, '2WD', NULL, 'Active', NULL),
(909, 7, 95, '2.0 L', '', '2013', 'present', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(910, 7, 95, '2.5 L', '', '2013', 'present', 'Manual/Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(911, 7, 95, '1.6 L', '', '2013', 'present', 'Manual/Automatic', 'Diesel', 1600, '2WD', NULL, 'Active', NULL),
(912, 7, 89, '1.6 L', '', '2010', '2013', 'Manual/Automatic', 'Gasoline', 1600, '2WD/4WD', NULL, 'Active', NULL),
(913, 7, 89, '1.6 L', '', '2013', 'present', 'Manual/Automatic', 'Gasoline', 1600, '2WD/4WD', NULL, 'Active', NULL),
(914, 7, 92, '2.0 L ', 'MKII C24', '2003', '2012', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(915, 7, 92, '2.0 L ', 'MKII C25', '2005', '2012', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(916, 7, 92, '2.0 L ', 'MKII C26', '2010', 'present', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(917, 7, 93, '2.0 L', 'J31', '2002', '2008', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(918, 7, 93, '2.5 L', 'J31', '2002', '2008', 'Manual/Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(919, 7, 93, '3.5 L', 'J31', '2002', '2008', 'Manual/Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(920, 7, 93, '2.5 L', 'J32', '2009', '2013', 'Manual/Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(921, 7, 93, '3.5 L', 'J32', '2009', '2013', 'Manual/Automatic', 'Gasoline', 3500, '2WD', NULL, 'Active', NULL),
(922, 7, 93, '2.0 L', 'J33', '2013', 'present', 'Manual/Automatic', 'Gasoline', 2000, '2WD', NULL, 'Active', NULL),
(923, 7, 93, '2.5 L', 'J33', '2013', 'present', 'Manual/Automatic', 'Gasoline', 2500, '2WD', NULL, 'Active', NULL),
(924, 7, 94, '3.3 L', 'R50', '1995', '2005', 'Manual/Automatic', 'Gasoline', 3300, '2WD/4WD', NULL, 'Active', NULL),
(925, 7, 94, '3.5 L', 'R50', '1995', '2005', 'Manual/Automatic', 'Gasoline', 3500, '2WD/4WD', NULL, 'Active', NULL),
(926, 7, 94, '2.7 L', 'R50', '1995', '2005', 'Manual/Automatic', 'Diesel', 2700, '2WD/4WD', NULL, 'Active', NULL),
(927, 7, 94, '3.0 L', 'R50', '1995', '2005', 'Manual/Automatic', 'Diesel', 3000, '2WD/4WD', NULL, 'Active', NULL),
(928, 7, 94, '3.2 L', 'R50', '1995', '2005', 'Manual/Automatic', 'Diesel', 3200, '2WD/4WD', NULL, 'Active', NULL),
(929, 7, 85, '2.5 L', 'E52', '2011', 'present', 'Manual/Automatic', 'Gasoline', 2500, '2WD/4WD', NULL, 'Active', NULL),
(930, 7, 85, '3.5 L', 'E52', '2012', 'present', 'Manual/Automatic', 'Gasoline', 3500, '2WD/4WD', NULL, 'Active', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rims_warehouse_division`
--

INSERT INTO `rims_warehouse_division` (`id`, `warehouse_id`, `division_id`) VALUES
(3, 1, 4),
(4, 1, 5),
(1, 5, 1),
(5, 6, 1),
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
-- Indexes for table `rims_brand`
--
ALTER TABLE `rims_brand`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_chasis_code`
--
ALTER TABLE `rims_chasis_code`
 ADD PRIMARY KEY (`id`), ADD KEY `car_make_id` (`car_make_id`), ADD KEY `car_model_id` (`car_model_id`);

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
 ADD PRIMARY KEY (`id`), ADD KEY `customer_id` (`customer_id`), ADD KEY `service_id` (`service_id`);

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
-- Indexes for table `rims_employee_branch_division_position_level`
--
ALTER TABLE `rims_employee_branch_division_position_level`
 ADD PRIMARY KEY (`id`), ADD KEY `employee_id` (`employee_id`), ADD KEY `division_id` (`division_id`), ADD KEY `position_id` (`position_id`), ADD KEY `level_id` (`level_id`), ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `rims_employee_deductions`
--
ALTER TABLE `rims_employee_deductions`
 ADD PRIMARY KEY (`id`), ADD KEY `employee_id` (`employee_id`), ADD KEY `deduction_id` (`deduction_id`);

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
-- Indexes for table `rims_equipment`
--
ALTER TABLE `rims_equipment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_equipments`
--
ALTER TABLE `rims_equipments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_equipment_branch`
--
ALTER TABLE `rims_equipment_branch`
 ADD PRIMARY KEY (`id`), ADD KEY `equipment_id` (`equipment_id`), ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `rims_equipment_maintenance`
--
ALTER TABLE `rims_equipment_maintenance`
 ADD PRIMARY KEY (`id`), ADD KEY `equipment_id` (`equipment_id`), ADD KEY `equipment_task_id` (`equipment_task_id`), ADD KEY `equipment_branch_id` (`equipment_branch_id`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `rims_equipment_task`
--
ALTER TABLE `rims_equipment_task`
 ADD PRIMARY KEY (`id`), ADD KEY `equipment_id` (`equipment_id`), ADD KEY `equipment_id_2` (`equipment_id`);

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
 ADD PRIMARY KEY (`id`), ADD KEY `product_master_category_id` (`product_master_category_id`), ADD KEY `product_sub_master_category_id` (`product_sub_master_category_id`), ADD KEY `product_sub_category_id` (`product_sub_category_id`), ADD KEY `product_specification_type_id` (`product_specification_type_id`), ADD KEY `vehicle_car_make_id` (`vehicle_car_make_id`), ADD KEY `vehicle_car_model_id` (`vehicle_car_model_id`), ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `rims_product_master_category`
--
ALTER TABLE `rims_product_master_category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_product_specification_battery`
--
ALTER TABLE `rims_product_specification_battery`
 ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`), ADD KEY `sub_brand_id` (`sub_brand_id`), ADD KEY `sub_brand_series_id` (`sub_brand_series_id`);

--
-- Indexes for table `rims_product_specification_info`
--
ALTER TABLE `rims_product_specification_info`
 ADD PRIMARY KEY (`id`), ADD KEY `product_specification_type_id` (`product_specification_type_id`);

--
-- Indexes for table `rims_product_specification_oil`
--
ALTER TABLE `rims_product_specification_oil`
 ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`), ADD KEY `oil_sub_brand_id` (`sub_brand_id`), ADD KEY `oil_sub_brand_series_id` (`sub_brand_series_id`);

--
-- Indexes for table `rims_product_specification_tire`
--
ALTER TABLE `rims_product_specification_tire`
 ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`), ADD KEY `sub_brand_id` (`sub_brand_id`), ADD KEY `sub_brand_series_id` (`sub_brand_series_id`);

--
-- Indexes for table `rims_product_specification_type`
--
ALTER TABLE `rims_product_specification_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_product_sub_category`
--
ALTER TABLE `rims_product_sub_category`
 ADD PRIMARY KEY (`id`), ADD KEY `product_sub_master_category_id` (`product_sub_master_category_id`), ADD KEY `product_master_category` (`product_master_category_id`);

--
-- Indexes for table `rims_product_sub_master_category`
--
ALTER TABLE `rims_product_sub_master_category`
 ADD PRIMARY KEY (`id`), ADD KEY `product_category_id` (`product_master_category_id`);

--
-- Indexes for table `rims_product_vehicle`
--
ALTER TABLE `rims_product_vehicle`
 ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`), ADD KEY `vehicle_car_make_id` (`vehicle_car_make_id`), ADD KEY `vehicle_car_model_id` (`vehicle_car_model_id`);

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
-- Indexes for table `rims_service`
--
ALTER TABLE `rims_service`
 ADD PRIMARY KEY (`id`), ADD KEY `service_category_id` (`service_category_id`), ADD KEY `service_type_id` (`service_type_id`);

--
-- Indexes for table `rims_service_category`
--
ALTER TABLE `rims_service_category`
 ADD PRIMARY KEY (`id`), ADD KEY `service_type_id` (`service_type_id`);

--
-- Indexes for table `rims_service_equipment`
--
ALTER TABLE `rims_service_equipment`
 ADD PRIMARY KEY (`id`), ADD KEY `service_id` (`service_id`), ADD KEY `equipment_id` (`equipment_id`);

--
-- Indexes for table `rims_service_material_usage`
--
ALTER TABLE `rims_service_material_usage`
 ADD PRIMARY KEY (`id`), ADD KEY `service_id` (`service_id`), ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `rims_service_product`
--
ALTER TABLE `rims_service_product`
 ADD PRIMARY KEY (`id`), ADD KEY `service_id` (`service_id`), ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `rims_service_type`
--
ALTER TABLE `rims_service_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rims_sub_brand`
--
ALTER TABLE `rims_sub_brand`
 ADD PRIMARY KEY (`id`), ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `rims_sub_brand_series`
--
ALTER TABLE `rims_sub_brand_series`
 ADD PRIMARY KEY (`id`), ADD KEY `sub_brand_id` (`sub_brand_id`);

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
 ADD PRIMARY KEY (`id`), ADD KEY `customer_id` (`customer_id`), ADD KEY `customer_pic_id` (`customer_pic_id`), ADD KEY `car_make_id` (`car_make_id`), ADD KEY `car_model_id` (`car_model_id`), ADD KEY `car_sub_model_id` (`car_sub_model_id`), ADD KEY `color_id` (`color_id`);

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
 ADD PRIMARY KEY (`id`), ADD KEY `car_make_id` (`car_make_id`), ADD KEY `car_model_id` (`car_model_id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `rims_branch_fax`
--
ALTER TABLE `rims_branch_fax`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_branch_phone`
--
ALTER TABLE `rims_branch_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_branch_warehouse`
--
ALTER TABLE `rims_branch_warehouse`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `rims_brand`
--
ALTER TABLE `rims_brand`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `rims_customer_mobile`
--
ALTER TABLE `rims_customer_mobile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_customer_phone`
--
ALTER TABLE `rims_customer_phone`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rims_customer_pic`
--
ALTER TABLE `rims_customer_pic`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `rims_division_position`
--
ALTER TABLE `rims_division_position`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rims_employee`
--
ALTER TABLE `rims_employee`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `rims_employee_bank`
--
ALTER TABLE `rims_employee_bank`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rims_employee_branch_division_position_level`
--
ALTER TABLE `rims_employee_branch_division_position_level`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_employee_deductions`
--
ALTER TABLE `rims_employee_deductions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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
-- AUTO_INCREMENT for table `rims_equipment`
--
ALTER TABLE `rims_equipment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_equipments`
--
ALTER TABLE `rims_equipments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_equipment_branch`
--
ALTER TABLE `rims_equipment_branch`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_equipment_maintenance`
--
ALTER TABLE `rims_equipment_maintenance`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rims_equipment_task`
--
ALTER TABLE `rims_equipment_task`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `rims_product_specification_battery`
--
ALTER TABLE `rims_product_specification_battery`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_product_specification_info`
--
ALTER TABLE `rims_product_specification_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_product_specification_oil`
--
ALTER TABLE `rims_product_specification_oil`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_product_specification_tire`
--
ALTER TABLE `rims_product_specification_tire`
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1115;
--
-- AUTO_INCREMENT for table `rims_product_sub_master_category`
--
ALTER TABLE `rims_product_sub_master_category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `rims_product_vehicle`
--
ALTER TABLE `rims_product_vehicle`
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
-- AUTO_INCREMENT for table `rims_service`
--
ALTER TABLE `rims_service`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1561;
--
-- AUTO_INCREMENT for table `rims_service_category`
--
ALTER TABLE `rims_service_category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `rims_service_equipment`
--
ALTER TABLE `rims_service_equipment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_service_material_usage`
--
ALTER TABLE `rims_service_material_usage`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_service_product`
--
ALTER TABLE `rims_service_product`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_service_type`
--
ALTER TABLE `rims_service_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rims_sub_brand`
--
ALTER TABLE `rims_sub_brand`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rims_sub_brand_series`
--
ALTER TABLE `rims_sub_brand_series`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_make`
--
ALTER TABLE `rims_vehicle_car_make`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_model`
--
ALTER TABLE `rims_vehicle_car_model`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `rims_vehicle_car_sub_detail`
--
ALTER TABLE `rims_vehicle_car_sub_detail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=931;
--
-- AUTO_INCREMENT for table `rims_warehouse`
--
ALTER TABLE `rims_warehouse`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `rims_warehouse_division`
--
ALTER TABLE `rims_warehouse_division`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
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
-- Constraints for table `rims_chasis_code`
--
ALTER TABLE `rims_chasis_code`
ADD CONSTRAINT `rims_chasis_code_ibfk_1` FOREIGN KEY (`car_make_id`) REFERENCES `rims_vehicle_car_make` (`id`),
ADD CONSTRAINT `rims_chasis_code_ibfk_2` FOREIGN KEY (`car_model_id`) REFERENCES `rims_vehicle_car_model` (`id`);

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
-- Constraints for table `rims_customer_service_rate`
--
ALTER TABLE `rims_customer_service_rate`
ADD CONSTRAINT `rims_customer_service_rate_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `rims_customer` (`id`),
ADD CONSTRAINT `rims_customer_service_rate_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `rims_service` (`id`);

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
-- Constraints for table `rims_employee_branch_division_position_level`
--
ALTER TABLE `rims_employee_branch_division_position_level`
ADD CONSTRAINT `rims_employee_branch_division_position_level_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`),
ADD CONSTRAINT `rims_employee_branch_division_position_level_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `rims_division` (`id`),
ADD CONSTRAINT `rims_employee_branch_division_position_level_ibfk_3` FOREIGN KEY (`position_id`) REFERENCES `rims_position` (`id`),
ADD CONSTRAINT `rims_employee_branch_division_position_level_ibfk_4` FOREIGN KEY (`level_id`) REFERENCES `rims_level` (`id`),
ADD CONSTRAINT `rims_employee_branch_division_position_level_ibfk_5` FOREIGN KEY (`branch_id`) REFERENCES `rims_branch` (`id`);

--
-- Constraints for table `rims_employee_deductions`
--
ALTER TABLE `rims_employee_deductions`
ADD CONSTRAINT `rims_employee_deductions_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`),
ADD CONSTRAINT `rims_employee_deductions_ibfk_2` FOREIGN KEY (`deduction_id`) REFERENCES `rims_deduction` (`id`);

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
-- Constraints for table `rims_equipment_branch`
--
ALTER TABLE `rims_equipment_branch`
ADD CONSTRAINT `rims_equipment_branch_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `rims_equipments` (`id`),
ADD CONSTRAINT `rims_equipment_branch_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `rims_branch` (`id`);

--
-- Constraints for table `rims_equipment_maintenance`
--
ALTER TABLE `rims_equipment_maintenance`
ADD CONSTRAINT `rims_equipment_maintenance_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `rims_equipments` (`id`),
ADD CONSTRAINT `rims_equipment_maintenance_ibfk_2` FOREIGN KEY (`equipment_task_id`) REFERENCES `rims_equipment_task` (`id`),
ADD CONSTRAINT `rims_equipment_maintenance_ibfk_3` FOREIGN KEY (`equipment_branch_id`) REFERENCES `rims_equipment_branch` (`id`),
ADD CONSTRAINT `rims_equipment_maintenance_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `rims_employee` (`id`);

--
-- Constraints for table `rims_equipment_task`
--
ALTER TABLE `rims_equipment_task`
ADD CONSTRAINT `rims_equipment_task_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `rims_equipments` (`id`);

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
ADD CONSTRAINT `rims_product_ibfk_6` FOREIGN KEY (`vehicle_car_model_id`) REFERENCES `rims_vehicle_car_model` (`id`),
ADD CONSTRAINT `rims_product_ibfk_7` FOREIGN KEY (`brand_id`) REFERENCES `rims_brand` (`id`);

--
-- Constraints for table `rims_product_specification_battery`
--
ALTER TABLE `rims_product_specification_battery`
ADD CONSTRAINT `rims_product_specification_battery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `rims_product` (`id`),
ADD CONSTRAINT `rims_product_specification_battery_ibfk_2` FOREIGN KEY (`sub_brand_id`) REFERENCES `rims_sub_brand` (`id`),
ADD CONSTRAINT `rims_product_specification_battery_ibfk_3` FOREIGN KEY (`sub_brand_series_id`) REFERENCES `rims_sub_brand_series` (`id`);

--
-- Constraints for table `rims_product_specification_info`
--
ALTER TABLE `rims_product_specification_info`
ADD CONSTRAINT `rims_product_specification_info_ibfk_1` FOREIGN KEY (`product_specification_type_id`) REFERENCES `rims_product_specification_type` (`id`);

--
-- Constraints for table `rims_product_specification_oil`
--
ALTER TABLE `rims_product_specification_oil`
ADD CONSTRAINT `rims_product_specification_oil_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `rims_product` (`id`),
ADD CONSTRAINT `rims_product_specification_oil_ibfk_2` FOREIGN KEY (`sub_brand_id`) REFERENCES `rims_sub_brand` (`id`),
ADD CONSTRAINT `rims_product_specification_oil_ibfk_3` FOREIGN KEY (`sub_brand_series_id`) REFERENCES `rims_sub_brand_series` (`id`);

--
-- Constraints for table `rims_product_specification_tire`
--
ALTER TABLE `rims_product_specification_tire`
ADD CONSTRAINT `rims_product_specification_tire_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `rims_product` (`id`),
ADD CONSTRAINT `rims_product_specification_tire_ibfk_2` FOREIGN KEY (`sub_brand_id`) REFERENCES `rims_sub_brand` (`id`),
ADD CONSTRAINT `rims_product_specification_tire_ibfk_3` FOREIGN KEY (`sub_brand_series_id`) REFERENCES `rims_sub_brand_series` (`id`);

--
-- Constraints for table `rims_product_sub_category`
--
ALTER TABLE `rims_product_sub_category`
ADD CONSTRAINT `rims_product_sub_category_ibfk_1` FOREIGN KEY (`product_sub_master_category_id`) REFERENCES `rims_product_sub_master_category` (`id`);

--
-- Constraints for table `rims_product_sub_master_category`
--
ALTER TABLE `rims_product_sub_master_category`
ADD CONSTRAINT `rims_product_sub_master_category_ibfk_1` FOREIGN KEY (`product_master_category_id`) REFERENCES `rims_product_master_category` (`id`);

--
-- Constraints for table `rims_product_vehicle`
--
ALTER TABLE `rims_product_vehicle`
ADD CONSTRAINT `rims_product_vehicle_ibfk_2` FOREIGN KEY (`vehicle_car_make_id`) REFERENCES `rims_vehicle_car_make` (`id`),
ADD CONSTRAINT `rims_product_vehicle_ibfk_3` FOREIGN KEY (`vehicle_car_model_id`) REFERENCES `rims_vehicle_car_model` (`id`),
ADD CONSTRAINT `rims_product_vehicle_ibfk_4` FOREIGN KEY (`product_id`) REFERENCES `rims_product` (`id`);

--
-- Constraints for table `rims_service`
--
ALTER TABLE `rims_service`
ADD CONSTRAINT `rims_service_ibfk_1` FOREIGN KEY (`service_category_id`) REFERENCES `rims_service_category` (`id`),
ADD CONSTRAINT `rims_service_ibfk_2` FOREIGN KEY (`service_type_id`) REFERENCES `rims_service_type` (`id`);

--
-- Constraints for table `rims_service_category`
--
ALTER TABLE `rims_service_category`
ADD CONSTRAINT `rims_service_category_ibfk_1` FOREIGN KEY (`service_type_id`) REFERENCES `rims_service_type` (`id`);

--
-- Constraints for table `rims_service_equipment`
--
ALTER TABLE `rims_service_equipment`
ADD CONSTRAINT `rims_service_equipment_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `rims_service` (`id`),
ADD CONSTRAINT `rims_service_equipment_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `rims_equipment` (`id`);

--
-- Constraints for table `rims_service_material_usage`
--
ALTER TABLE `rims_service_material_usage`
ADD CONSTRAINT `rims_service_material_usage_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `rims_service` (`id`),
ADD CONSTRAINT `rims_service_material_usage_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `rims_product` (`id`);

--
-- Constraints for table `rims_service_product`
--
ALTER TABLE `rims_service_product`
ADD CONSTRAINT `rims_service_product_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `rims_service` (`id`),
ADD CONSTRAINT `rims_service_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `rims_product` (`id`);

--
-- Constraints for table `rims_sub_brand`
--
ALTER TABLE `rims_sub_brand`
ADD CONSTRAINT `rims_sub_brand_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `rims_brand` (`id`);

--
-- Constraints for table `rims_sub_brand_series`
--
ALTER TABLE `rims_sub_brand_series`
ADD CONSTRAINT `rims_sub_brand_series_ibfk_1` FOREIGN KEY (`sub_brand_id`) REFERENCES `rims_sub_brand` (`id`);

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
ADD CONSTRAINT `rims_vehicle_ibfk_6` FOREIGN KEY (`color_id`) REFERENCES `rims_colors` (`id`),
ADD CONSTRAINT `rims_vehicle_ibfk_7` FOREIGN KEY (`car_sub_model_id`) REFERENCES `rims_vehicle_car_sub_detail` (`id`);

--
-- Constraints for table `rims_vehicle_car_model`
--
ALTER TABLE `rims_vehicle_car_model`
ADD CONSTRAINT `rims_vehicle_car_model_ibfk_1` FOREIGN KEY (`car_make_id`) REFERENCES `rims_vehicle_car_make` (`id`);

--
-- Constraints for table `rims_vehicle_car_sub_detail`
--
ALTER TABLE `rims_vehicle_car_sub_detail`
ADD CONSTRAINT `rims_vehicle_car_sub_detail_ibfk_1` FOREIGN KEY (`car_make_id`) REFERENCES `rims_vehicle_car_make` (`id`),
ADD CONSTRAINT `rims_vehicle_car_sub_detail_ibfk_2` FOREIGN KEY (`car_model_id`) REFERENCES `rims_vehicle_car_model` (`id`);

--
-- Constraints for table `rims_warehouse_division`
--
ALTER TABLE `rims_warehouse_division`
ADD CONSTRAINT `rims_warehouse_division_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `rims_warehouse` (`id`),
ADD CONSTRAINT `rims_warehouse_division_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `rims_division` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
