/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_locked` tinyint NOT NULL DEFAULT '0' COMMENT '会員ロック状態: 0通常 1ロック',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO users(id,name,email,is_locked,email_verified_at,password,remember_token,created_at,updated_at) VALUES(1,'user5','user5@mytest.com',0,NULL,'$2y$10$cxd6wXsnDaob6In/SN4gM.xM0ws5W85gNg/otjQy/vDHvjLNsmEHW',NULL,'2021-10-29 00:35:20','2021-10-29 00:35:20'),(2,'demo2','demo2@demo.cc',0,NULL,'$2y$10$8MnVtF7ynUU5XsYGdaywBeAlaJ4ATe4RuOlSYncGt0TQG490n5bky',NULL,'2021-10-29 10:58:51','2021-10-29 10:58:51');