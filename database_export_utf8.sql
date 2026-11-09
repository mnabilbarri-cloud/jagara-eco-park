-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: jagara_framework_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','$2y$10$hkQGH8GJbIHdbvorWnReQOri7R7Dc0KK1NGQF4RlzLSBKtOkbqWLq');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fasilitas`
--

DROP TABLE IF EXISTS `fasilitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fasilitas` (
  `id_fasilitas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_fasilitas` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `harga` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `gambar2` varchar(255) DEFAULT NULL,
  `gambar3` varchar(255) DEFAULT NULL,
  `tipe` enum('reservasi','umum') NOT NULL DEFAULT 'reservasi',
  `kapasitas` int(11) NOT NULL DEFAULT 50,
  PRIMARY KEY (`id_fasilitas`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fasilitas`
--

LOCK TABLES `fasilitas` WRITE;
/*!40000 ALTER TABLE `fasilitas` DISABLE KEYS */;
INSERT INTO `fasilitas` VALUES (1,'Resto Jagara','Tempat makan dengan suasana alam.',10000,'resto_1.jpeg','resto_2.jpeg','resto_3.jpeg','reservasi',50),(2,'Area Indoor','Cocok untuk acara keluarga dan meeting.',15000,'indor_1.jpeg','indor_2.jpeg','indor_3.jpeg','reservasi',50),(3,'Area Outdoor','Area terbuka untuk keluarga dan komunitas.',10000,'outdor_1.jpeg','outdor_2.jpeg','outdor_3.jpeg','reservasi',50),(4,'ATV Adventure','Wahana petualangan penuh tantangan.',40000,'ATV_1.jpeg','ATV_2.jpeg','ATV_3.jpeg','reservasi',50),(5,'Mini Gokart','Wahana balap mini untuk semua umur.',30000,'gokart_1.jpeg','gokart_2.jpeg','gokart_3.jpeg','reservasi',50),(6,'Fun Slide','Seluncuran seru untuk keluarga.',35000,'funslide_1.jpeg','funslide_2.jpeg','funslide_3.jpeg','reservasi',50),(7,'Cabin Teras Bumi','Penginapan bernuansa alam.',80000,'cabin_1.jpeg','cabin_2.jpeg','cabin_3.jpeg','reservasi',50),(8,'Istana Balon','Wahana bermain anak-anak.',20000,'istana_1.jpeg','istana_2.jpeg','istana_3.jpeg','reservasi',50),(9,'Mushola','Fasilitas ibadah yang nyaman.',0,'musola_1.jpeg','musola_2.jpeg','musola_3.jpeg','umum',50);
/*!40000 ALTER TABLE `fasilitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadiah_loyalty`
--

DROP TABLE IF EXISTS `hadiah_loyalty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadiah_loyalty` (
  `id_hadiah` int(11) NOT NULL AUTO_INCREMENT,
  `nama_hadiah` varchar(100) NOT NULL,
  `minimal_reservasi` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_hadiah`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadiah_loyalty`
--

LOCK TABLES `hadiah_loyalty` WRITE;
/*!40000 ALTER TABLE `hadiah_loyalty` DISABLE KEYS */;
INSERT INTO `hadiah_loyalty` VALUES (1,'kaos jagara eco park',7,100,'2026-07-10 01:24:49','2026-07-10 01:59:09'),(3,'Tumbler Jagara Eco Park',5,130,'2026-07-10 01:58:30',NULL),(4,'Kipas Angin Portable Mini',10,80,'2026-07-10 02:01:25','2026-07-10 02:04:58'),(5,'Jas Hujan Gravity Raincoat',15,100,'2026-07-10 02:04:13',NULL),(6,'Payung Lipat',12,90,'2026-07-10 02:07:35','2026-07-10 02:08:06'),(7,'sepatu',18,90,'2026-07-11 09:10:54',NULL);
/*!40000 ALTER TABLE `hadiah_loyalty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_06_01_124158_create_admin_table',1),(6,'2026_06_01_124259_create_fasilitas_table',1),(7,'2026_06_01_124327_create_reservasi_table',1),(8,'2026_07_03_000001_add_user_id_to_reservasi_table',2),(9,'2026_07_03_000002_add_is_permanent_and_discount_tier_to_users_table',2),(10,'2026_07_08_234143_add_gambar2_and_gambar3_to_fasilitas_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `id_fasilitas` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_petugas`),
  KEY `fk_petugas_fasilitas` (`id_fasilitas`),
  CONSTRAINT `fk_petugas_fasilitas` FOREIGN KEY (`id_fasilitas`) REFERENCES `fasilitas` (`id_fasilitas`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
/*!40000 ALTER TABLE `petugas` DISABLE KEYS */;
INSERT INTO `petugas` VALUES (1,'Budi','Pelayan','081901922377',2,'2026-07-10 01:01:24','2026-07-10 08:20:20'),(2,'Sania','Petugas','089887456231',6,'2026-07-10 01:03:05','2026-07-10 08:20:29'),(3,'Toto','Pelayan','081199892123',7,'2026-07-10 02:10:27',NULL),(4,'Yayat','Petugas','089934556192',4,'2026-07-10 08:21:37','2026-07-10 08:22:04'),(5,'Ajeng','Petugas','081188937655',8,'2026-07-10 08:23:21',NULL);
/*!40000 ALTER TABLE `petugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservasi`
--

DROP TABLE IF EXISTS `reservasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservasi` (
  `id_reservasi` int(11) NOT NULL AUTO_INCREMENT,
  `kode_reservasi` varchar(20) DEFAULT NULL,
  `nama_pengunjung` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `tanggal_kunjungan` date DEFAULT NULL,
  `id_fasilitas` int(11) DEFAULT NULL,
  `jumlah_tiket` int(11) NOT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `status` enum('Menunggu','Diterima','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_reservasi`),
  UNIQUE KEY `reservasi_kode_reservasi_unique` (`kode_reservasi`),
  KEY `idx_capacity_check` (`id_fasilitas`,`tanggal_kunjungan`,`status`),
  KEY `reservasi_no_hp_index` (`no_hp`),
  KEY `reservasi_tanggal_kunjungan_index` (`tanggal_kunjungan`),
  KEY `reservasi_status_index` (`status`),
  KEY `reservasi_created_at_index` (`created_at`),
  KEY `reservasi_user_id_foreign` (`user_id`),
  CONSTRAINT `reservasi_id_fasilitas_foreign` FOREIGN KEY (`id_fasilitas`) REFERENCES `fasilitas` (`id_fasilitas`) ON DELETE CASCADE,
  CONSTRAINT `reservasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservasi`
--

LOCK TABLES `reservasi` WRITE;
/*!40000 ALTER TABLE `reservasi` DISABLE KEYS */;
INSERT INTO `reservasi` VALUES (32,'JG202607082350218851','Maman','0817638293729','2026-07-10',2,3,45000,'Diterima','BUKTI_JG202607082350218851_1783529439.jpg',NULL,4,'2026-07-08 09:50:21'),(33,'JG202607082353131338','zulfa','0897280981122','2026-07-22',6,4,140000,'Diterima','BUKTI_JG202607082353131338_1783529604.jpg',NULL,5,'2026-07-08 09:53:13'),(35,'JG202607082356389289','azib','081234785980','2026-07-28',4,5,200000,'Diterima','BUKTI_JG202607082356389289_1783529820.jpg',NULL,7,'2026-07-08 09:56:38'),(38,'JG202607100812303999','Yani','0856712881125','2026-07-17',4,3,120000,'Ditolak',NULL,NULL,8,'2026-07-10 01:12:30'),(39,'JG202607100814109520','putri','082301929334','2026-07-22',1,2,20000,'Diterima','BUKTI_JG202607100814109520_1783646064.jpg',NULL,6,'2026-07-10 01:14:10'),(40,'JG202607100816325763','elma','081092998444','2026-07-30',8,5,100000,'Ditolak',NULL,NULL,10,'2026-07-10 01:16:32'),(41,'JG202607100818048445','fauzan','089932117888','2026-07-12',5,4,120000,'Ditolak',NULL,NULL,11,'2026-07-10 01:18:04'),(42,'JG202607100821149619','fahmi','082776198099','2026-07-14',2,3,45000,'Diterima','BUKTI_JG202607100821149619_1783646485.jpg',NULL,12,'2026-07-10 01:21:14'),(43,'JG202607100822458190','sipa','081073455672','2026-07-19',1,2,20000,'Ditolak',NULL,NULL,13,'2026-07-10 01:22:45'),(46,'JG202607111548078784','nabil','085795798560','2026-07-13',7,4,320000,'Diterima','BUKTI_JG202607111548078784_1783759864.jpg',NULL,15,'2026-07-11 08:48:07');
/*!40000 ALTER TABLE `reservasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimoni`
--

DROP TABLE IF EXISTS `testimoni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimoni` (
  `id_testimoni` int(11) NOT NULL AUTO_INCREMENT,
  `id_reservasi` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_testimoni`),
  KEY `fk_testimoni_reservasi` (`id_reservasi`),
  CONSTRAINT `fk_testimoni_reservasi` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimoni`
--

LOCK TABLES `testimoni` WRITE;
/*!40000 ALTER TABLE `testimoni` DISABLE KEYS */;
INSERT INTO `testimoni` VALUES (3,46,5,'suasana nya enak','2026-07-11 09:08:48');
/*!40000 ALTER TABLE `testimoni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `discount_tier` int(11) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Maman','Maman@gmail.com',NULL,0,0,'$2y$12$0WSrb/POKHyo35O7mmGPj.wVg.IHQ5A3DKHv9e3Wa65gMXANVRhKC',NULL,'2026-07-08 16:48:51','2026-07-08 16:48:51'),(5,'zulfa','zulfa@gmail.com',NULL,0,0,'$2y$12$QcqulKZFUd8VzsyhJuOQr.2Jzcx9YZk2f4FbXJJxOkXNlSWmNuyu6',NULL,'2026-07-08 16:52:28','2026-07-08 16:52:28'),(6,'putri','putri@gmail.com',NULL,0,0,'$2y$12$2GZMt9RN8VoH.6RU.hVYfuqngT4tPLKHD.jlldu7FIil6CWniIl1W',NULL,'2026-07-08 16:54:15','2026-07-08 16:54:15'),(7,'azib','azib@gmail.com',NULL,0,0,'$2y$12$lDxW5uP9tEc33bG7uEui.uOGzDNMhrQ.R1qYrlbtdbwBhs8n/lVOG',NULL,'2026-07-08 16:56:06','2026-07-08 16:56:06'),(8,'yani','yani@gmail.com',NULL,0,0,'$2y$12$4paWIYzKo1DThl48BYednunjT2osTiEUuxmf3z2fNu3V395fechR.',NULL,'2026-07-08 16:57:28','2026-07-08 16:57:28'),(10,'elma','elma@gmail.com',NULL,0,0,'$2y$12$h3aYpyg5uDd8JQuRAXIdY.83jaPuOmf/QXXlywjtDGuV67SKIxiRm',NULL,'2026-07-10 01:15:24','2026-07-10 01:15:24'),(11,'fauzan','fauzan@gmail.com',NULL,0,0,'$2y$12$RcQtUfjBihiD473d2E0G4.gfL0OARr40ScFTvXmRj.81a8mADscpa',NULL,'2026-07-10 01:17:20','2026-07-10 01:17:20'),(12,'fahmi','fahmi@gmail.com',NULL,0,0,'$2y$12$BbEvi.QvDIMZ7iY1XeIRs.ZSzi7HR7G3TaRKG0t6XQsTfLjVuZeQO',NULL,'2026-07-10 01:18:49','2026-07-10 01:18:49'),(13,'sipa','sipa@gmail.com',NULL,0,0,'$2y$12$V8NO7Mhem9E2bF8IiKFjVOxZb63/79WKd/2bVices6HSNr/2u/JgK',NULL,'2026-07-10 01:22:08','2026-07-10 01:22:08'),(15,'Nabil','20240810002@uniku.ac.id',NULL,0,0,'$2y$12$BFwSO00WeobaT3h/lkD/Te9N50jr1vkQ2LtVyh9//16iU/EgD37gu',NULL,'2026-07-11 08:44:19','2026-07-11 08:44:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-08 15:36:50
