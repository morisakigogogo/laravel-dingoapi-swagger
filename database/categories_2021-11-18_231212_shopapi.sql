/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
DROP TABLE IF EXISTS categories;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'カテゴリ名',
  `pid` int NOT NULL DEFAULT '0' COMMENT '親ラベル',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT 'ステータス：0オフ　１オン',
  `level` tinyint NOT NULL DEFAULT '1' COMMENT '分類レベル 1 2 3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO categories(id,name,pid,status,level,created_at,updated_at) VALUES(1,'アパレル',0,1,1,'2021-10-29 10:44:40','2021-10-29 10:44:40'),(2,'デジタル商品',0,1,3,'2021-10-29 10:46:53','2021-10-29 12:03:08'),(3,'携帯電話',1,1,2,'2021-10-29 10:47:52','2021-10-29 10:47:52'),(4,'パソコン',1,1,2,'2021-10-29 10:48:00','2021-10-29 10:48:00'),(5,'男装',2,0,2,'2021-10-29 10:48:19','2021-10-29 12:17:00'),(6,'婦人服',2,1,2,'2021-10-29 11:02:51','2021-10-29 11:02:51'),(7,'NEC',3,1,2,'2021-10-29 15:23:29','2021-10-29 15:23:29'),(8,'富士通',3,1,3,'2021-10-29 15:28:28','2021-10-29 15:28:28'),(9,'ドコモ',3,1,3,'2021-10-29 15:29:01','2021-10-29 15:29:01'),(10,'AU',3,1,3,'2021-10-29 15:29:07','2021-10-29 15:29:07'),(11,'ソフトバンク',3,1,3,'2021-10-29 15:29:13','2021-10-29 15:29:13'),(12,'DELL',4,1,3,'2021-10-29 15:29:46','2021-10-29 15:29:46');