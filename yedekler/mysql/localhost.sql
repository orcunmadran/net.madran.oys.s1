-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Sunucu: localhost
-- Çıktı Tarihi: Şubat 13, 2006 at 03:25 PM
-- Server sürümü: 5.0.15
-- PHP Sürümü: 5.0.5
-- 
-- Veritabanı: `iys`
-- 
CREATE DATABASE `iys` DEFAULT CHARACTER SET latin5 COLLATE latin5_turkish_ci;
USE iys;

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `dersler`
-- 

CREATE TABLE `dersler` (
  `dersno` int(11) NOT NULL,
  `derskodu` varchar(25) NOT NULL,
  `dersadi` varchar(100) NOT NULL,
  PRIMARY KEY  (`dersno`)
) TYPE=MyISAM COMMENT='Dersler' AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `dersler`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `duyurular`
-- 

CREATE TABLE `duyurular` (
  `duyuruno` int(11) NOT NULL,
  `yazar` varchar(60) NOT NULL,
  `dtip` varchar(25) NOT NULL,
  `dbaslik` varchar(100) NOT NULL,
  `dicerik` text NOT NULL,
  `dbastrh` date NOT NULL,
  `dbittrh` date NOT NULL,
  `gtarih` varchar(100) default NULL,
  PRIMARY KEY  (`duyuruno`)
) TYPE=MyISAM COMMENT='Duyuru yayınlama' AUTO_INCREMENT=8 ;

-- 
-- Tablo döküm verisi `duyurular`
-- 

INSERT INTO `duyurular` VALUES (7, 'Orçun Madran', 'Genel Duyuru', 'deneme', 'deneme', '2006-02-09', '2006-02-11', NULL);
INSERT INTO `duyurular` VALUES (6, 'Orçun Madran', 'Genel Duyuru', 'Bugünkü genel duyuru', 'Bakalım çalışacak mı koçari? Güncelliyorum...', '2006-02-08', '2006-02-09', 'Bu duyuru 08.02.2006 - 14:39 tarihinde Orçun Madran tarafından güncellendi.');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `giriscikis`
-- 

CREATE TABLE `giriscikis` (
  `kayitno` int(11) NOT NULL,
  `kadi` varchar(60) NOT NULL,
  `eylem` varchar(5) NOT NULL,
  `tarih` timestamp NULL,
  PRIMARY KEY  (`kayitno`)
) TYPE=MyISAM COMMENT='Kullanıcı Giriş - Çıkış Kayıtları' AUTO_INCREMENT=236 ;

-- 
-- Tablo döküm verisi `giriscikis`
-- 

INSERT INTO `giriscikis` VALUES (217, 'Orçun Madran', 'Giriş', '2006-02-13 12:19:34');
INSERT INTO `giriscikis` VALUES (216, 'Orçun Madran', 'Giriş', '2006-02-13 10:12:23');
INSERT INTO `giriscikis` VALUES (215, 'Orçun Madran', 'Giriş', '2006-02-11 01:37:57');
INSERT INTO `giriscikis` VALUES (214, 'Orçun Madran', 'Giriş', '2006-02-10 23:41:26');
INSERT INTO `giriscikis` VALUES (213, 'sy', 'Giriş', '2006-02-10 23:15:45');
INSERT INTO `giriscikis` VALUES (212, 'Orçun Madran', 'Giriş', '2006-02-10 20:27:41');
INSERT INTO `giriscikis` VALUES (211, 'Orçun Madran', 'Giriş', '2006-02-10 20:23:22');
INSERT INTO `giriscikis` VALUES (210, 'Örnek Öğrenci', 'Giriş', '2006-02-10 17:07:16');
INSERT INTO `giriscikis` VALUES (209, 'Örnek Öğrenci', 'Giriş', '2006-02-10 17:03:41');
INSERT INTO `giriscikis` VALUES (208, 'Örnek Öğrenci', 'Giriş', '2006-02-10 16:17:31');
INSERT INTO `giriscikis` VALUES (207, 'Örnek Öğrenci', 'Giriş', '2006-02-09 16:39:03');
INSERT INTO `giriscikis` VALUES (206, 'Orçun Madran', 'Giriş', '2006-02-09 16:38:24');
INSERT INTO `giriscikis` VALUES (205, 'Orçun Madran', 'Giriş', '2006-02-08 20:55:28');
INSERT INTO `giriscikis` VALUES (204, 'Örnek Öğrenci', 'Giriş', '2006-02-08 13:51:31');
INSERT INTO `giriscikis` VALUES (203, 'Örnek Öğrenci', 'Giriş', '2006-02-07 16:52:39');
INSERT INTO `giriscikis` VALUES (202, 'Örnek Öğrenci', 'Giriş', '2006-02-07 16:31:04');
INSERT INTO `giriscikis` VALUES (201, 'Örnek Öğrenci', 'Giriş', '2006-02-07 11:09:49');
INSERT INTO `giriscikis` VALUES (200, 'Orçun Madran', 'Giriş', '2006-02-06 16:18:57');
INSERT INTO `giriscikis` VALUES (199, 'Orçun Madran', 'Giriş', '2006-02-06 16:10:53');
INSERT INTO `giriscikis` VALUES (198, 'Örnek Öğrenci', 'Giriş', '2006-02-06 16:02:41');
INSERT INTO `giriscikis` VALUES (197, 'Örnek Öğrenci', 'Giriş', '2006-02-06 15:30:16');
INSERT INTO `giriscikis` VALUES (196, 'Örnek Öğrenci', 'Giriş', '2006-02-06 15:29:21');
INSERT INTO `giriscikis` VALUES (195, 'Örnek Öğrenci', 'Giriş', '2006-02-06 14:55:14');
INSERT INTO `giriscikis` VALUES (194, 'Orçun Madran', 'Giriş', '2006-02-06 14:17:49');
INSERT INTO `giriscikis` VALUES (193, 'Orçun Madran', 'Giriş', '2006-02-06 14:16:34');
INSERT INTO `giriscikis` VALUES (192, 'Orçun Madran', 'Giriş', '2006-02-06 12:26:04');
INSERT INTO `giriscikis` VALUES (191, 'üğiş çöı', 'Giriş', '2006-02-06 11:29:47');
INSERT INTO `giriscikis` VALUES (190, 'Orçun Madran', 'Giriş', '2006-02-06 11:11:49');
INSERT INTO `giriscikis` VALUES (189, 'Orçun Madran', 'Giriş', '2006-02-06 10:41:25');
INSERT INTO `giriscikis` VALUES (188, 'Orçun Madran', 'Giriş', '2006-02-05 16:28:24');
INSERT INTO `giriscikis` VALUES (187, 'Örnek Öğrenci', 'Giriş', '2006-02-05 13:46:15');
INSERT INTO `giriscikis` VALUES (186, 'Orçun Madran', 'Giriş', '2006-02-05 13:26:27');
INSERT INTO `giriscikis` VALUES (185, 'Orçun Madran', 'Giriş', '2006-02-05 13:19:12');
INSERT INTO `giriscikis` VALUES (184, 'Örnek Öğrenci', 'Giriş', '2006-02-05 13:11:41');
INSERT INTO `giriscikis` VALUES (183, 'sy', 'Giriş', '2006-02-05 03:00:20');
INSERT INTO `giriscikis` VALUES (182, 'Örnek Öğrenci', 'Giriş', '2006-02-05 02:36:25');
INSERT INTO `giriscikis` VALUES (181, 'Örnek Öğrenci', 'Giriş', '2006-02-05 01:41:14');
INSERT INTO `giriscikis` VALUES (180, 'Orçun Madran', 'Giriş', '2006-02-05 01:14:29');
INSERT INTO `giriscikis` VALUES (179, 'Örnek Öğrenci', 'Giriş', '2006-02-05 01:13:24');
INSERT INTO `giriscikis` VALUES (178, 'Orçun Madran', 'Giriş', '2006-02-05 01:06:28');
INSERT INTO `giriscikis` VALUES (177, 'Örnek Öğrenci', 'Giriş', '2006-02-05 01:03:55');
INSERT INTO `giriscikis` VALUES (176, 'Orçun Madran', 'Giriş', '2006-02-05 00:43:22');
INSERT INTO `giriscikis` VALUES (175, 'Örnek Öğrenci', 'Giriş', '2006-02-04 22:09:35');
INSERT INTO `giriscikis` VALUES (174, 'Orçun Madran', 'Giriş', '2006-02-04 22:09:07');
INSERT INTO `giriscikis` VALUES (173, 'Örnek Öğrenci', 'Giriş', '2006-02-04 20:34:09');
INSERT INTO `giriscikis` VALUES (172, 'Örnek Öğrenci', 'Giriş', '2006-02-04 19:31:38');
INSERT INTO `giriscikis` VALUES (171, 'Örnek Öğrenci', 'Giriş', '2006-02-04 16:42:02');
INSERT INTO `giriscikis` VALUES (170, 'Örnek Öğrenci', 'Giriş', '2006-02-03 16:22:24');
INSERT INTO `giriscikis` VALUES (169, 'Orçun Madran', 'Giriş', '2006-02-03 16:22:04');
INSERT INTO `giriscikis` VALUES (168, 'Orçun Madran', 'Giriş', '2006-02-03 14:46:50');
INSERT INTO `giriscikis` VALUES (167, 'Örnek Öğrenci', 'Giriş', '2006-02-03 14:31:56');
INSERT INTO `giriscikis` VALUES (166, 'Orçun Madran', 'Giriş', '2006-02-03 14:26:41');
INSERT INTO `giriscikis` VALUES (165, 'Örnek Öğrenci', 'Giriş', '2006-02-03 14:16:42');
INSERT INTO `giriscikis` VALUES (164, 'Örnek Öğrenci', 'Giriş', '2006-02-03 14:14:56');
INSERT INTO `giriscikis` VALUES (163, 'Orçun Madran', 'Giriş', '2006-02-03 10:32:24');
INSERT INTO `giriscikis` VALUES (162, 'Orçun Madran', 'Giriş', '2006-02-02 15:50:17');
INSERT INTO `giriscikis` VALUES (161, 'sy', 'Giriş', '2006-02-02 15:45:58');
INSERT INTO `giriscikis` VALUES (160, 'Örnek Öğrenci', 'Giriş', '2006-02-02 15:43:49');
INSERT INTO `giriscikis` VALUES (159, 'Orçun Madran', 'Giriş', '2006-02-02 15:40:50');
INSERT INTO `giriscikis` VALUES (218, 'Orçun Madran', 'Giriş', '2006-02-13 12:20:50');
INSERT INTO `giriscikis` VALUES (219, 'Orçun Madran', 'Giriş', '2006-02-13 12:26:04');
INSERT INTO `giriscikis` VALUES (220, 'Orçun Madran', 'Giriş', '2006-02-13 12:36:06');
INSERT INTO `giriscikis` VALUES (221, 'Orçun Madran', 'Giriş', '2006-02-13 12:49:31');
INSERT INTO `giriscikis` VALUES (222, 'Orçun Madran', 'Giriş', '2006-02-13 12:53:29');
INSERT INTO `giriscikis` VALUES (223, 'Örnek Öğrenci', 'Giriş', '2006-02-13 13:12:21');
INSERT INTO `giriscikis` VALUES (224, 'Orçun Madran', 'Giriş', '2006-02-13 13:12:58');
INSERT INTO `giriscikis` VALUES (225, 'Orçun Madran', 'Giriş', '2006-02-13 13:14:00');
INSERT INTO `giriscikis` VALUES (226, 'Orçun Madran', 'Giriş', '2006-02-13 13:14:26');
INSERT INTO `giriscikis` VALUES (227, 'Orçun Madran', 'Giriş', '2006-02-13 13:19:44');
INSERT INTO `giriscikis` VALUES (228, 'Orçun Madran', 'Giriş', '2006-02-13 13:21:45');
INSERT INTO `giriscikis` VALUES (229, 'Orçun Madran', 'Giriş', '2006-02-13 13:24:05');
INSERT INTO `giriscikis` VALUES (230, 'Orçun Madran', 'Giriş', '2006-02-13 13:25:17');
INSERT INTO `giriscikis` VALUES (231, 'Orçun Madran', 'Giriş', '2006-02-13 13:28:52');
INSERT INTO `giriscikis` VALUES (232, 'Örnek Öğrenci', 'Giriş', '2006-02-13 13:29:46');
INSERT INTO `giriscikis` VALUES (233, 'Örnek Öğrenci', 'Giriş', '2006-02-13 13:31:31');
INSERT INTO `giriscikis` VALUES (234, 'Orçun Madran', 'Giriş', '2006-02-13 13:35:38');
INSERT INTO `giriscikis` VALUES (235, 'Orçun Madran', 'Giriş', '2006-02-13 13:37:26');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `kullanici`
-- 

CREATE TABLE `kullanici` (
  `ad` varchar(30) NOT NULL,
  `soyad` varchar(30) NOT NULL,
  `kadi` varchar(60) NOT NULL,
  `sifre` varchar(15) NOT NULL,
  `kategori` varchar(15) NOT NULL,
  `eposta` varchar(100) NOT NULL,
  `webadres` varchar(100) default NULL,
  `evadres` text,
  `evtel` varchar(25) default NULL,
  `isadres` text,
  `istel` varchar(25) default NULL,
  `mobiltel` varchar(25) default NULL,
  `aciklama` text,
  `giriszaman` timestamp NOT NULL,
  PRIMARY KEY  (`kadi`)
) TYPE=MyISAM COMMENT='Kullanıcı tablosu';

-- 
-- Tablo döküm verisi `kullanici`
-- 

INSERT INTO `kullanici` VALUES ('s', 'y', 'sy', 'q', 'yonetici', 'bote@baskent.edu.tr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2006-01-29 17:43:46');
INSERT INTO `kullanici` VALUES ('Orçun', 'Madran', 'Orçun Madran', '9360673', 'ogretime', 'omadran@baskent.edu.tr', 'http://www.baskent.edu.tr/~omadran', 'Venüskent', NULL, 'Başkent', NULL, NULL, NULL, '2006-01-29 17:46:01');
INSERT INTO `kullanici` VALUES ('Örnek', 'Öğrenci', 'Örnek Öğrenci', '123456', 'ogrenci', 'ornek@ogrenci.com', 'http://', NULL, NULL, NULL, NULL, NULL, NULL, '2006-01-29 18:00:44');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `mesajlar`
-- 

CREATE TABLE `mesajlar` (
  `mesajno` int(11) NOT NULL,
  `tarihsaat` timestamp NULL,
  `gonderen` varchar(60) NOT NULL,
  `alici` varchar(60) NOT NULL,
  `konu` varchar(100) NOT NULL,
  `icerik` text NOT NULL,
  `okundu` binary(1) NOT NULL default '0',
  `silindi` binary(1) NOT NULL default '0',
  PRIMARY KEY  (`mesajno`)
) TYPE=MyISAM COMMENT='Mesajlaşma Sistemi' AUTO_INCREMENT=23 ;

-- 
-- Tablo döküm verisi `mesajlar`
-- 

INSERT INTO `mesajlar` VALUES (20, '2006-02-06 11:30:14', 'üğiş çöı', 'Orçun Madran', 'deneme', '123456', 0x31, 0x30);
INSERT INTO `mesajlar` VALUES (21, '2006-02-08 17:55:54', 'Orçun Madran', 'Örnek Öğrenci', 'deneme', 'bakalım anasayfada ne oluyor oluyor', 0x31, 0x30);
INSERT INTO `mesajlar` VALUES (22, '2006-02-09 16:39:27', 'Orçun Madran', 'Örnek Öğrenci', 'deneme', 'deneme', 0x31, 0x30);
INSERT INTO `mesajlar` VALUES (16, '2006-01-30 16:48:10', 'Orçun Madran', 'Örnek Öğrenci', 'Proje Teslimi ile ilgili...', 'Merhaba,\r\n\r\nÖTÖ 450 dersi kapsamında oluşturulan proje gruplarında sizin adınız görünmüyor. Lütfen konu olarak hakim olduğunuza inandığınız bir çalışma grubuna kendiniz kaydedin.\r\n\r\nGruba kaydolduğunuzda bilgi vermeyi unutmayınız.\r\n\r\nİyi çalışmalar,\r\n\r\nR. Orçun Madran', 0x31, 0x30);
INSERT INTO `mesajlar` VALUES (17, '2006-01-30 16:52:52', 'Örnek Öğrenci', 'Orçun Madran', 'Cevap: Proje Teslimi ile ilgili...', 'Hocam Merhaba,\r\n\r\nGecikmeden dolayı özür diliyorum. Proje grubu olarak "Yapay Zeka" grubuna kayıt oldum. \r\n\r\nSaygılarımala,\r\n\r\nÖrnek Öğrenci\r\n\r\nOrjinal Mesaj\r\n-----------------\r\nMerhaba,\r\n\r\nÖTÖ 450 dersi kapsamında oluşturulan proje gruplarında sizin adınız görünmüyor. Lütfen konu olarak hakim olduğunuza inandığınız bir çalışma grubuna kendiniz kaydedin.\r\n\r\nGruba kaydolduğunuzda bilgi vermeyi unutmayınız.\r\n\r\nİyi çalışmalar,\r\n\r\nR. Orçun Madran', 0x31, 0x30);
INSERT INTO `mesajlar` VALUES (18, '2006-01-30 16:53:57', 'Orçun Madran', 'Örnek Öğrenci', 'Cevap: Cevap: Proje Teslimi ile ilgili...', 'Tamam...\r\n\r\nOrjinal Mesaj\r\n-----------------\r\nHocam Merhaba,\r\n\r\nGecikmeden dolayı özür diliyorum. Proje grubu olarak "Yapay Zeka" grubuna kayıt oldum. \r\n\r\nSaygılarımala,\r\n\r\nÖrnek Öğrenci\r\n\r\nOrjinal Mesaj\r\n-----------------\r\nMerhaba,\r\n\r\nÖTÖ 450 dersi kapsamında oluşturulan proje gruplarında sizin adınız görünmüyor. Lütfen konu olarak hakim olduğunuza inandığınız bir çalışma grubuna kendiniz kaydedin.\r\n\r\nGruba kaydolduğunuzda bilgi vermeyi unutmayınız.\r\n\r\nİyi çalışmalar,\r\n\r\nR. Orçun Madran', 0x31, 0x31);
INSERT INTO `mesajlar` VALUES (19, '2006-02-05 02:59:58', 'Örnek Öğrenci', 'sy', 'Cevap: Proje Teslimi ile ilgili...', '-\r\n\r\nOrjinal Mesaj\r\n-----------------\r\nMerhaba,\r\n\r\nÖTÖ 450 dersi kapsamında oluşturulan proje gruplarında sizin adınız görünmüyor. Lütfen konu olarak hakim olduğunuza inandığınız bir çalışma grubuna kendiniz kaydedin.\r\n\r\nGruba kaydolduğunuzda bilgi vermeyi unutmayınız.\r\n\r\nİyi çalışmalar,\r\n\r\nR. Orçun Madran', 0x31, 0x30);

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `siniflar`
-- 

CREATE TABLE `siniflar` (
  `girisno` int(11) NOT NULL,
  `subeno` int(11) NOT NULL,
  `kadi` varchar(60) NOT NULL
) TYPE=MyISAM COMMENT='Sınıflar';

-- 
-- Tablo döküm verisi `siniflar`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_bans`
-- 

CREATE TABLE `sohbet_bans` (
  `ID` int(11) NOT NULL,
  `banned_by` varchar(255) NOT NULL default '0',
  `ban_type` enum('username','ip') NOT NULL default 'username',
  `ban_from` enum('room','login') NOT NULL default 'room',
  `username` varchar(255) NOT NULL default '',
  `room_id` int(11) NOT NULL default '0',
  `ip` varchar(255) NOT NULL default '',
  `ban_start_at` int(14) default NULL,
  PRIMARY KEY  (`ID`),
  KEY `ban_start_at` (`ban_start_at`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `sohbet_bans`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_chat_messages`
-- 

CREATE TABLE `sohbet_chat_messages` (
  `ID` int(11) NOT NULL,
  `room` int(11) NOT NULL default '0',
  `from_user` varchar(255) NOT NULL default '',
  `to_user` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ID`),
  KEY `room` (`room`),
  KEY `to_user` (`to_user`)
) TYPE=MyISAM AUTO_INCREMENT=132 ;

-- 
-- Tablo döküm verisi `sohbet_chat_messages`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_groups`
-- 

CREATE TABLE `sohbet_groups` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL default '0',
  `permanent` enum('1','0') NOT NULL default '0',
  `description` varchar(255) NOT NULL default '0',
  `created` date NOT NULL default '0000-00-00',
  `defaultroom` tinyint(5) NOT NULL default '0',
  `invisible_priv` enum('1','0') NOT NULL default '0',
  `banunban_priv` varchar(255) NOT NULL default '',
  `mngusers_priv` varchar(255) NOT NULL default '',
  `mnggroups_priv` enum('1','0') NOT NULL default '0',
  `mngsystem_priv` enum('1','0') NOT NULL default '0',
  `mngrooms_priv` enum('1','0') NOT NULL default '0',
  `adminarea_priv` enum('1','0') NOT NULL default '0',
  `logintochat_priv` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Tablo döküm verisi `sohbet_groups`
-- 

INSERT INTO `sohbet_groups` VALUES (1, 'admin', '1', 'for admin users', '0000-00-00', 1, '0', 'all', 'all', '1', '1', '1', '1', '1');
INSERT INTO `sohbet_groups` VALUES (2, 'spy', '1', 'for spies users', '0000-00-00', 1, '1', 'all', 'non', '0', '0', '0', '0', '1');
INSERT INTO `sohbet_groups` VALUES (3, 'users', '1', 'For registered chat users', '0000-00-00', 1, '0', 'all', 'non', '0', '0', '0', '0', '1');
INSERT INTO `sohbet_groups` VALUES (4, 'guests', '1', 'For none registered users (guests)loading only as a role and no password checked', '0000-00-00', 1, '0', 'non', 'non', '0', '0', '0', '0', '0');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_pvt_rooms_users`
-- 

CREATE TABLE `sohbet_pvt_rooms_users` (
  `username` varchar(255) NOT NULL default '',
  `room_id` int(11) NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Tablo döküm verisi `sohbet_pvt_rooms_users`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_rooms`
-- 

CREATE TABLE `sohbet_rooms` (
  `ID` int(11) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `created` date NOT NULL default '0000-00-00',
  `room_description` varchar(255) NOT NULL default 'No description',
  `room_type` varchar(255) NOT NULL default '',
  `permanent` enum('1','0') NOT NULL default '0',
  `empty_start` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `empty_start` (`empty_start`),
  KEY `room_name` (`room_name`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Tablo döküm verisi `sohbet_rooms`
-- 

INSERT INTO `sohbet_rooms` VALUES (1, 'Lobi', '0000-00-00', 'Sanal KampÃ¼s genel amaÃ§lÄ± sohbet odasÄ±', 'public', '1', 0);
INSERT INTO `sohbet_rooms` VALUES (2, 'Konferans Salonu', '2004-08-28', 'Sanal KampÃ¼s genel amaÃ§lÄ± konferans salonu', 'public', '1', 0);
INSERT INTO `sohbet_rooms` VALUES (3, 'Teknik Destek', '2004-07-11', 'Sanal KampÃ¼s Ã§evrimiÃ§i teknik destek odasÄ±', 'public', '1', 0);
INSERT INTO `sohbet_rooms` VALUES (4, 'Ã–TÃ– 001', '2004-01-01', 'Ã–rnek Ders sohbet odasÄ±', 'public', '1', 0);

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_sessions`
-- 

CREATE TABLE `sohbet_sessions` (
  `sesskey` varchar(32) NOT NULL default '',
  `expiry` int(11) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  `username` varchar(255) NOT NULL default '0',
  `room` int(11) NOT NULL default '0',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `ismoderator` enum('1','0') NOT NULL default '0',
  `isspy` enum('1','0') NOT NULL default '1',
  `status` tinyint(4) NOT NULL default '1',
  `ip` varchar(16) default NULL,
  PRIMARY KEY  (`sesskey`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM;

-- 
-- Tablo döküm verisi `sohbet_sessions`
-- 

INSERT INTO `sohbet_sessions` VALUES ('fae0fde27943c98a974a9668932bc267', 1139818479, '', '', 0, '2006-02-13 10:12:39', '0', '', 1, '127.0.0.1');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_system`
-- 

CREATE TABLE `sohbet_system` (
  `status` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`status`)
) TYPE=MyISAM;

-- 
-- Tablo döküm verisi `sohbet_system`
-- 

INSERT INTO `sohbet_system` VALUES ('1');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_users`
-- 

CREATE TABLE `sohbet_users` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '0',
  `password` varchar(255) NOT NULL default '0',
  `groupid` tinyint(5) NOT NULL default '0',
  `enable` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM AUTO_INCREMENT=21 ;

-- 
-- Tablo döküm verisi `sohbet_users`
-- 

INSERT INTO `sohbet_users` VALUES (20, '', 'Ornek Ogrenci', '123456', 3, '1');
INSERT INTO `sohbet_users` VALUES (19, '', 'Orcun Madran', '9360673', 1, '1');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `subeler`
-- 

CREATE TABLE `subeler` (
  `subeno` int(11) NOT NULL,
  `dersno` int(11) NOT NULL,
  `subekodu` varchar(30) NOT NULL,
  `sorumlu` varchar(60) NOT NULL,
  PRIMARY KEY  (`subeno`)
) TYPE=MyISAM COMMENT='Şubeler' AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `subeler`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `tg_basliklar`
-- 

CREATE TABLE `tg_basliklar` (
  `baslikno` int(11) NOT NULL,
  `girisno` int(11) NOT NULL,
  `baslik` varchar(100) NOT NULL,
  `yazar` varchar(60) NOT NULL,
  `tarih` timestamp NULL,
  `aktif` varchar(5) NOT NULL default 'Evet',
  PRIMARY KEY  (`baslikno`)
) TYPE=MyISAM COMMENT='Forum Başlıkları' AUTO_INCREMENT=15 ;

-- 
-- Tablo döküm verisi `tg_basliklar`
-- 

INSERT INTO `tg_basliklar` VALUES (14, 21, 'Ders ile ilgili düşünce ve görüşleriniz', 'Orçun Madran', '2006-02-09 16:43:24', 'Evet');
INSERT INTO `tg_basliklar` VALUES (13, 20, 'Sanal Kütüphaneler', 'Orçun Madran', '2006-02-05 02:39:24', 'Evet');
INSERT INTO `tg_basliklar` VALUES (12, 19, 'Ders ile ilgili düşünce ve görüşleriniz', 'Orçun Madran', '2006-02-04 22:12:31', 'Evet');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `tg_forumlar`
-- 

CREATE TABLE `tg_forumlar` (
  `girisno` int(11) NOT NULL,
  `adi` varchar(25) NOT NULL,
  `aciklama` varchar(100) NOT NULL,
  `tip` varchar(20) NOT NULL,
  `yaratan` varchar(60) NOT NULL,
  `tarih` timestamp NULL,
  `aktif` varchar(5) NOT NULL default 'Evet',
  PRIMARY KEY  (`girisno`),
  UNIQUE KEY `adi` (`adi`)
) TYPE=MyISAM COMMENT='Tatışma Gruplar' AUTO_INCREMENT=22 ;

-- 
-- Tablo döküm verisi `tg_forumlar`
-- 

INSERT INTO `tg_forumlar` VALUES (21, 'ÖTÖ 309', 'Ötö 309 ders forumu', 'Ders Forumu', 'Orçun Madran', '2006-02-09 16:43:14', 'Evet');
INSERT INTO `tg_forumlar` VALUES (20, 'Sanal Bilgi Kaynakları', 'Elektronik ortamda yer alan sanal kaynaklar', 'Serbest Kürsü', 'Orçun Madran', '2006-02-05 02:39:06', 'Evet');
INSERT INTO `tg_forumlar` VALUES (19, 'ÖTÖ 001', 'Uzaktan Eğitimin Temelleri ders forumu', 'Ders Forumu', 'Orçun Madran', '2006-02-04 22:11:53', 'Evet');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `tg_yorumlar`
-- 

CREATE TABLE `tg_yorumlar` (
  `baslikno` int(11) NOT NULL,
  `yorumno` int(11) NOT NULL,
  `yorum` text NOT NULL,
  `yazar` varchar(60) NOT NULL,
  `tarih` timestamp NULL,
  `guncellendi` varchar(30) NOT NULL default '../resimler/tg_yg_hayir.gif',
  `uyarialdi` varchar(30) NOT NULL default '../resimler/tg_yu_hayir.gif',
  `gtarih` varchar(50) default NULL,
  PRIMARY KEY  (`yorumno`)
) TYPE=MyISAM COMMENT='Tartışma Grup Yorumları' AUTO_INCREMENT=16 ;

-- 
-- Tablo döküm verisi `tg_yorumlar`
-- 

INSERT INTO `tg_yorumlar` VALUES (12, 4, 'Bu ilk görüş...', 'Orçun Madran', '2006-02-04 23:36:05', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', '');
INSERT INTO `tg_yorumlar` VALUES (12, 5, 'Aha da bu da ikinci', 'Orçun Madran', '2006-02-04 23:45:04', '../resimler/tg_yg_hayir.gif', '../resimler/tg_yu_hayir.gif', '');
INSERT INTO `tg_yorumlar` VALUES (12, 6, 'Ben daha bunlardan çok eklerim', 'Orçun Madran', '2006-02-04 23:45:18', '../resimler/tg_yg_hayir.gif', '../resimler/tg_yu_hayir.gif', '');
INSERT INTO `tg_yorumlar` VALUES (12, 7, 'Bu da biraz uzun bir görüş olacak. Aslında şu enter basma olayını da halledebilseydim pek bi güzel olacaktı. Ancak bu kanıyan bir yaradır. Birçok projede de aynı sıkıntıyı yaşamıştım. \r\n\r\nMesela entere bastım . Ama nafile....\r\n\r\nBirde söylemek istediğim bu aşamada sistemin tüm görselliği ile ilgili bir takım iyileştirmeler yapmalıyım. Buna kasılabilir bu akşam. Bu akşam bitti bitiyor....', 'Orçun Madran', '2006-02-04 23:47:12', '../resimler/tg_yg_hayir.gif', '../resimler/tg_yu_hayir.gif', '');
INSERT INTO `tg_yorumlar` VALUES (12, 8, 'Bu br taglarini bi koyabilsek rahatlayacağız aslında. <br>\r\nKoyunca ne hoş oldu değilmi...', 'Orçun Madran', '2006-02-04 23:58:17', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', '');
INSERT INTO `tg_yorumlar` VALUES (12, 9, 'Tüm html etiketlerinde çalışmakta bu arada. Mesela\r\n<br><br>\r\n<a href="http://www.madran.net", "_blank">Orçun Madran</a>\r\ngüncelleiyorjwslkfsa', 'Orçun Madran', '2006-02-05 00:00:39', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', 'Bu yorum 05.02.2006 - 01:52 tarihinde güncellendi');
INSERT INTO `tg_yorumlar` VALUES (12, 10, 'Benim düşüncem bu örnek öğrenci olaraktan....  guncelliyorum...  bide daha güncelledim...                          ', 'Örnek Öğrenci', '2006-02-05 01:41:34', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', 'Bu yorum 05.02.2006 - 01:46 tarihinde güncellendi');
INSERT INTO `tg_yorumlar` VALUES (12, 11, 'yeni bir yorumdur bu ', 'Örnek Öğrenci', '2006-02-05 01:49:55', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', 'Bu yorum 05.02.2006 - 01:50 tarihinde güncellendi');
INSERT INTO `tg_yorumlar` VALUES (12, 12, 'Ben ördek öğrenci.eh eh eh Örnek öğrenci olacaktı...', 'Örnek Öğrenci', '2006-02-05 02:33:38', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', 'Bu yorum 05.02.2006 - 02:33 tarihinde güncellendi');
INSERT INTO `tg_yorumlar` VALUES (13, 13, 'Sanal kütüphaneler özellikle İnternetin ve telekominikasyon altyapısının gelişmesiyle hız kazanmıştır.', 'Orçun Madran', '2006-02-05 02:40:08', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', 'Bu yorum 05.02.2006 - 02:47 tarihinde güncellendi');
INSERT INTO `tg_yorumlar` VALUES (13, 14, 'Orçun Hocam. Dediklerinize tamamen katılıyorum. Günümüzde elektronik dergi ve kitapların kütüphane koleksiyonları içerisinde hatırı sayılır bir yere sahip olduğu görülmekte.', 'Örnek Öğrenci', '2006-02-05 02:41:22', '../resimler/tg_yg_hayir.gif', '../resimler/tg_yu_hayir.gif', NULL);
INSERT INTO `tg_yorumlar` VALUES (12, 15, 'yeni yorum zsdfhs ', 'Örnek Öğrenci', '2006-02-09 16:41:43', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', 'Bu yorum 09.02.2006 - 16:48 tarihinde güncellendi');
