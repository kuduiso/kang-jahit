-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 5.7.33 - MySQL Community Server (GPL)
-- OS Server:                    Win64
-- HeidiSQL Versi:               11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk db_kangjahit
CREATE DATABASE IF NOT EXISTS `db_kangjahit` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_kangjahit`;

-- membuang struktur untuk table db_kangjahit.data_order
CREATE TABLE IF NOT EXISTS `data_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_jadi` date NOT NULL,
  `referensi` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_kangjahit.data_order: ~3 rows (lebih kurang)
/*!40000 ALTER TABLE `data_order` DISABLE KEYS */;
INSERT INTO `data_order` (`id`, `nama`, `keterangan`, `tgl_masuk`, `tgl_jadi`, `referensi`) VALUES
	(38, 'Anton', 'Kemeja lengan panjang', '2020-12-03', '2020-12-19', '1608683466.jpg'),
	(39, 'Ali', 'Celana Panjang Kain', '2020-12-23', '2020-12-30', '1608683519.jpg'),
	(40, 'Ridho', 'Kemeja Panjang', '2020-12-24', '2020-12-31', '1608685800.jpg');
/*!40000 ALTER TABLE `data_order` ENABLE KEYS */;

-- membuang struktur untuk table db_kangjahit.tbl_barang
CREATE TABLE IF NOT EXISTS `tbl_barang` (
  `kd_barang` char(10) NOT NULL,
  `nm_barang` varchar(255) NOT NULL,
  `hrg_beli` int(11) NOT NULL,
  `hrg_jual` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`kd_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_kangjahit.tbl_barang: ~4 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_barang` DISABLE KEYS */;
INSERT INTO `tbl_barang` (`kd_barang`, `nm_barang`, `hrg_beli`, `hrg_jual`, `qty`) VALUES
	('122', 'Minyak Goreng', 10000, 15000, 25),
	('124', 'Indomie', 2500, 3000, 4),
	('125', 'Pepsodent Mint', 12000, 15000, 12),
	('1332', 'Lampu Philips', 12000, 15000, 2);
/*!40000 ALTER TABLE `tbl_barang` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
