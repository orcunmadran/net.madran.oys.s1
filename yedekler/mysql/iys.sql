-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Sunucu: localhost
-- Çıktı Tarihi: Şubat 21, 2006 at 12:38 PM
-- Server sürümü: 5.0.15
-- PHP Sürümü: 5.0.5
-- 
-- Veritabanı: `iys`
-- 

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `dersler`
-- 

CREATE TABLE `dersler` (
  `dersno` int(11) NOT NULL auto_increment,
  `derskodu` varchar(25) NOT NULL,
  `dersadi` varchar(100) NOT NULL,
  PRIMARY KEY  (`dersno`),
  UNIQUE KEY `derskodu` (`derskodu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Dersler' AUTO_INCREMENT=9 ;

-- 
-- Tablo döküm verisi `dersler`
-- 

INSERT INTO `dersler` VALUES (6, 'ÖTÖ 305', 'PC Ortamında Yazarlık Dilleri');
INSERT INTO `dersler` VALUES (5, 'ÖTÖ 450', 'Eğitimde Bilgisayar Alanındaki Son Gelişmeler');
INSERT INTO `dersler` VALUES (7, 'ÖTÖ 304', 'İnternet Ortamında Yazarlık Dilleri');
INSERT INTO `dersler` VALUES (8, 'ÖTÖ 999', 'Deneme Dersi');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `dersler_plan`
-- 

CREATE TABLE `dersler_plan` (
  `subeno` int(11) NOT NULL,
  `tanimamac` text NOT NULL,
  `degerlendirme` text NOT NULL,
  `kaynakca` text NOT NULL,
  `kapsamicerik` text NOT NULL,
  `egitimicerigi` varchar(100) NOT NULL,
  PRIMARY KEY  (`subeno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Ders Planı';

-- 
-- Tablo döküm verisi `dersler_plan`
-- 

INSERT INTO `dersler_plan` VALUES (5, 'Ders; PC ortamında uygun programlama dilleri ile eğitimsel programların tasarlanması ve geliştirilmesi için gerekli algoritma ve kavramlar ve bunların doğrultusunda mikro düzeyde eğitim amaçlı yazılım geliştirilmesini hedeflemektedir.\r\n', 'Ara sınav: %30\r\nDers içi çalışmalar, devam ve kanaat: %20\r\nFinal sınavı: %50 \r\n', 'deHaan, Jen. 2004 Flash MX 2004: Kaynağından Eğitim. Çev. Aslı Aytar ve Hatice Cesur. İstanbul: Medyasoft Yayınları.\r\n \r\nFranklin, Deker ve Makar, Jobe. 2004 Flash MX 2004 ActionScript 2.0 . Çev. Tuba Uğraş. İstanbul: Medyasoft Yayınları\r\n \r\n', '1. Hafta\r\n\r\n - Macromedia Flash programının genel tanıtımı \r\n - Program menü yapılarının ve çizim araçlarının kullanımı \r\n - Flash içerisinde animasyon kavramı \r\n - Shape Tweening animasyon tekniği\r\n\r\n2. Hafta\r\n\r\n - Temel Tasarım Teknikleri\r\n\r\n3. Hafta\r\n\r\n - Temel Animasyon Teknikleri', 'dersicerikleri/oto305/online.php');
INSERT INTO `dersler_plan` VALUES (6, 'Internet ortamında web sayfası yayınlama', 'proje', 'gülbahar :-)', 'html css javascript', 'dersicerikleri/oto30401/online.php');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `dersler_snvtar`
-- 

CREATE TABLE `dersler_snvtar` (
  `snvtrhno` int(11) NOT NULL auto_increment,
  `subeno` int(11) NOT NULL,
  `sinavtipi` varchar(20) NOT NULL,
  `sinavyeri` varchar(20) NOT NULL,
  `baslamatarih` date NOT NULL,
  `bitistarih` date NOT NULL,
  `sinavsaat` varchar(5) default NULL,
  `aciklama` text,
  PRIMARY KEY  (`snvtrhno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Sınav Tarihleri' AUTO_INCREMENT=6 ;

-- 
-- Tablo döküm verisi `dersler_snvtar`
-- 

INSERT INTO `dersler_snvtar` VALUES (3, 5, 'Deneme', 'İnternet Üzerinden', '2006-02-20', '2006-02-21', ' ', NULL);
INSERT INTO `dersler_snvtar` VALUES (4, 5, 'Mini Test', 'İnternet Üzerinden', '2006-02-28', '2006-02-28', ' ', NULL);
INSERT INTO `dersler_snvtar` VALUES (5, 6, 'Deneme Sınavı', 'İnternet Üzerinden', '2006-02-15', '2006-02-16', ' ', '1. ara sınav');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `dersler_sohbet`
-- 

CREATE TABLE `dersler_sohbet` (
  `sohbetno` int(11) NOT NULL auto_increment,
  `subeno` int(11) NOT NULL,
  `sohbetgun` varchar(10) NOT NULL,
  `sohbetsaat` varchar(5) NOT NULL,
  `baslamatarih` date NOT NULL,
  `bitistarih` date NOT NULL,
  `aciklama` text,
  PRIMARY KEY  (`sohbetno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Sohbet Saatleri' AUTO_INCREMENT=12 ;

-- 
-- Tablo döküm verisi `dersler_sohbet`
-- 

INSERT INTO `dersler_sohbet` VALUES (9, 5, 'Perşembe', '10:00', '2006-02-20', '2006-02-28', 'Ders süresi 1 saattir.');
INSERT INTO `dersler_sohbet` VALUES (10, 5, 'Cumartesi', '13:00', '2006-02-20', '2006-06-02', 'Ders süresi 2 saattir.');
INSERT INTO `dersler_sohbet` VALUES (11, 6, 'Çarşamba', '15:00', '2006-02-27', '2006-05-26', 'Katılımın %100 olması beklenmektedir!');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `duyurular`
-- 

CREATE TABLE `duyurular` (
  `duyuruno` int(11) NOT NULL auto_increment,
  `yazar` varchar(60) NOT NULL,
  `dtip` varchar(25) NOT NULL,
  `dbaslik` varchar(100) NOT NULL,
  `dicerik` text NOT NULL,
  `dbastrh` date NOT NULL,
  `dbittrh` date NOT NULL,
  `gtarih` varchar(100) default NULL,
  PRIMARY KEY  (`duyuruno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Duyuru yayınlama' AUTO_INCREMENT=8 ;

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
  `kayitno` int(11) NOT NULL auto_increment,
  `kadi` varchar(60) NOT NULL,
  `eylem` varchar(5) NOT NULL,
  `tarih` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`kayitno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Kullanıcı Giriş - Çıkış Kayıtları' AUTO_INCREMENT=263 ;

-- 
-- Tablo döküm verisi `giriscikis`
-- 

INSERT INTO `giriscikis` VALUES (262, 'Örnek Öğrenci', 'Giriş', '2006-02-21 12:26:56');
INSERT INTO `giriscikis` VALUES (261, 'Örnek Öğrenci', 'Giriş', '2006-02-21 12:21:08');
INSERT INTO `giriscikis` VALUES (260, 'sy', 'Giriş', '2006-02-21 12:17:18');
INSERT INTO `giriscikis` VALUES (259, 'Orçun Madran', 'Giriş', '2006-02-21 12:16:34');
INSERT INTO `giriscikis` VALUES (258, 'Orçun Madran', 'Giriş', '2006-02-21 12:12:39');
INSERT INTO `giriscikis` VALUES (257, 'sy', 'Giriş', '2006-02-21 11:39:39');
INSERT INTO `giriscikis` VALUES (256, 'Orçun Madran', 'Giriş', '2006-02-21 11:19:42');
INSERT INTO `giriscikis` VALUES (255, 'Örnek Öğrenci', 'Giriş', '2006-02-20 16:09:09');
INSERT INTO `giriscikis` VALUES (254, 'Örnek Öğrenci', 'Giriş', '2006-02-20 12:41:14');
INSERT INTO `giriscikis` VALUES (253, 'Orçun Madran', 'Giriş', '2006-02-20 10:49:57');
INSERT INTO `giriscikis` VALUES (252, 'Örnek Öğrenci', 'Giriş', '2006-02-20 09:56:13');
INSERT INTO `giriscikis` VALUES (251, 'Örnek Öğrenci', 'Giriş', '2006-02-19 20:33:41');
INSERT INTO `giriscikis` VALUES (250, 'Örnek Öğrenci', 'Giriş', '2006-02-19 18:27:19');
INSERT INTO `giriscikis` VALUES (249, 'Örnek Öğrenci', 'Giriş', '2006-02-19 13:13:40');

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
  `giriszaman` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`kadi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Kullanıcı tablosu';

-- 
-- Tablo döküm verisi `kullanici`
-- 

INSERT INTO `kullanici` VALUES ('s', 'y', 'sy', 'q', 'yonetici', 'bote@baskent.edu.tr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2006-01-29 17:43:46');
INSERT INTO `kullanici` VALUES ('Orçun', 'Madran', 'Orçun Madran', '9360673', 'ogretime', 'omadran@baskent.edu.tr', 'http://www.baskent.edu.tr/~omadran', 'Venüskent', NULL, 'Başkent', NULL, NULL, NULL, '2006-01-29 17:46:01');
INSERT INTO `kullanici` VALUES ('Savaş', 'Özbek', 'Savaş Özbek', '123456', 'ogrenci', 'savas@ozbek.com', 'http://', NULL, NULL, NULL, NULL, NULL, NULL, '2006-02-19 11:48:53');
INSERT INTO `kullanici` VALUES ('Burçak', 'Madran', 'Burçak Madran', '123456', 'ogretime', 'burcak@madran.net', 'http://', NULL, NULL, NULL, NULL, NULL, NULL, '2006-02-13 20:34:58');
INSERT INTO `kullanici` VALUES ('Oktay', 'Bağcı', 'Oktay Bağcı', '123456', 'ogrenci', 'oktaybagci@ttnet.net.tr', 'http://', NULL, NULL, NULL, NULL, NULL, NULL, '2006-02-19 11:47:35');
INSERT INTO `kullanici` VALUES ('Hakan', 'Ars', 'Hakan Ars', '123456', 'ogrenci', 'hakan@ars.com', 'http://', NULL, NULL, NULL, NULL, NULL, NULL, '2006-02-19 11:48:06');
INSERT INTO `kullanici` VALUES ('Örnek', 'Öğrenci', 'Örnek Öğrenci', '123456', 'ogrenci', 'ornek@ogrenci.com', 'http://', NULL, NULL, NULL, NULL, NULL, NULL, '2006-01-29 18:00:44');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `mesajlar`
-- 

CREATE TABLE `mesajlar` (
  `mesajno` int(11) NOT NULL auto_increment,
  `tarihsaat` timestamp NULL default CURRENT_TIMESTAMP,
  `gonderen` varchar(60) NOT NULL,
  `alici` varchar(60) NOT NULL,
  `konu` varchar(100) NOT NULL,
  `icerik` text NOT NULL,
  `okundu` binary(1) NOT NULL default '0',
  `silindi` binary(1) NOT NULL default '0',
  PRIMARY KEY  (`mesajno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Mesajlaşma Sistemi' AUTO_INCREMENT=24 ;

-- 
-- Tablo döküm verisi `mesajlar`
-- 

INSERT INTO `mesajlar` VALUES (23, '2006-02-13 22:42:24', 'sy', 'Burçak Madran', 'deneme', '123', 0x30, 0x30);
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
  `girisno` int(11) NOT NULL auto_increment,
  `subeno` int(11) NOT NULL,
  `kadi` varchar(60) NOT NULL,
  `giriskontrol` varchar(75) NOT NULL,
  PRIMARY KEY  (`girisno`),
  UNIQUE KEY `giriskontrol` (`giriskontrol`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Sınıflar' AUTO_INCREMENT=11 ;

-- 
-- Tablo döküm verisi `siniflar`
-- 

INSERT INTO `siniflar` VALUES (4, 4, 'Örnek Öğrenci', 'Örnek Öğrenci4');
INSERT INTO `siniflar` VALUES (3, 3, 'Örnek Öğrenci', 'Örnek Öğrenci3');
INSERT INTO `siniflar` VALUES (5, 5, 'Hakan Ars', 'Hakan Ars5');
INSERT INTO `siniflar` VALUES (6, 5, 'Oktay Bağcı', 'Oktay Bağcı5');
INSERT INTO `siniflar` VALUES (7, 5, 'Örnek Öğrenci', 'Örnek Öğrenci5');
INSERT INTO `siniflar` VALUES (8, 5, 'Savaş Özbek', 'Savaş Özbek5');
INSERT INTO `siniflar` VALUES (9, 6, 'Örnek Öğrenci', 'Örnek Öğrenci6');
INSERT INTO `siniflar` VALUES (10, 7, 'Örnek Öğrenci', 'Örnek Öğrenci7');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_bans`
-- 

CREATE TABLE `sohbet_bans` (
  `ID` int(11) NOT NULL auto_increment,
  `banned_by` varchar(255) NOT NULL default '0',
  `ban_type` enum('username','ip') NOT NULL default 'username',
  `ban_from` enum('room','login') NOT NULL default 'room',
  `username` varchar(255) NOT NULL default '',
  `room_id` int(11) NOT NULL default '0',
  `ip` varchar(255) NOT NULL default '',
  `ban_start_at` int(14) default NULL,
  PRIMARY KEY  (`ID`),
  KEY `ban_start_at` (`ban_start_at`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `sohbet_bans`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_chat_messages`
-- 

CREATE TABLE `sohbet_chat_messages` (
  `ID` int(11) NOT NULL auto_increment,
  `room` int(11) NOT NULL default '0',
  `from_user` varchar(255) NOT NULL default '',
  `to_user` varchar(255) NOT NULL default '',
  `message` text character set utf8 collate utf8_turkish_ci NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ID`),
  KEY `room` (`room`),
  KEY `to_user` (`to_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 AUTO_INCREMENT=147 ;

-- 
-- Tablo döküm verisi `sohbet_chat_messages`
-- 

INSERT INTO `sohbet_chat_messages` VALUES (145, 3, 'orcun madran', 'all', '[txtColor]ff9900[/txtColor]<b>orcun madran %#%says%#% </b>deneme1', 0, '2006-02-21 11:56:47');
INSERT INTO `sohbet_chat_messages` VALUES (143, 3, 'orcun madran', 'all', '[txtColor]ff9900[/txtColor]<b>orcun madran %#%says%#% </b>:rolleyes:', 0, '2006-02-21 11:56:31');
INSERT INTO `sohbet_chat_messages` VALUES (141, 3, 'orcun madran', 'all', '<b>[Teknik Destek]:</b> orcun madran %#%entered%#% 11:56 am|orcun madran', 2, '2006-02-21 11:56:03');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_groups`
-- 

CREATE TABLE `sohbet_groups` (
  `ID` int(11) NOT NULL auto_increment,
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
) ENGINE=MyISAM DEFAULT CHARSET=latin5 AUTO_INCREMENT=5 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

-- 
-- Tablo döküm verisi `sohbet_pvt_rooms_users`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_rooms`
-- 

CREATE TABLE `sohbet_rooms` (
  `ID` int(11) NOT NULL auto_increment,
  `room_name` varchar(255) character set utf8 collate utf8_turkish_ci NOT NULL,
  `created` date NOT NULL default '0000-00-00',
  `room_description` varchar(255) character set utf8 collate utf8_turkish_ci NOT NULL default 'No description',
  `room_type` varchar(255) NOT NULL default '',
  `permanent` enum('1','0') NOT NULL default '0',
  `empty_start` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `empty_start` (`empty_start`),
  KEY `room_name` (`room_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 AUTO_INCREMENT=5 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

-- 
-- Tablo döküm verisi `sohbet_sessions`
-- 

INSERT INTO `sohbet_sessions` VALUES ('b198d1e77d2061d1e550241921c4840c', 1140516248, '', '', 0, '2006-02-21 12:02:08', '0', '', 1, '10.0.6.209');
INSERT INTO `sohbet_sessions` VALUES ('a365081dcdfd73ebfd70f1941aef213d', 1140516273, 'banpriv|s:3:"all";username|s:12:"orcun madran";invisible|s:1:"0";', 'orcun madran', 3, '2006-02-21 11:54:13', '0', '0', 1, '10.0.6.209');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_system`
-- 

CREATE TABLE `sohbet_system` (
  `status` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

-- 
-- Tablo döküm verisi `sohbet_system`
-- 

INSERT INTO `sohbet_system` VALUES ('1');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `sohbet_users`
-- 

CREATE TABLE `sohbet_users` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '0',
  `password` varchar(255) NOT NULL default '0',
  `groupid` tinyint(5) NOT NULL default '0',
  `enable` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 AUTO_INCREMENT=21 ;

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
  `subeno` int(11) NOT NULL auto_increment,
  `dersno` int(11) NOT NULL,
  `subekodu` varchar(30) NOT NULL,
  `sube` varchar(25) NOT NULL,
  `sorumlu` varchar(60) NOT NULL,
  PRIMARY KEY  (`subeno`),
  UNIQUE KEY `sube` (`sube`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Şubeler' AUTO_INCREMENT=8 ;

-- 
-- Tablo döküm verisi `subeler`
-- 

INSERT INTO `subeler` VALUES (3, 5, '01', '5 - 01', 'Orçun Madran');
INSERT INTO `subeler` VALUES (4, 5, '02', '5 - 02', 'Burçak Madran');
INSERT INTO `subeler` VALUES (5, 6, '01', '6 - 01', 'Orçun Madran');
INSERT INTO `subeler` VALUES (6, 7, '01', '7 - 01', 'Orçun Madran');
INSERT INTO `subeler` VALUES (7, 8, '01', '8 - 01', 'Orçun Madran');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `tg_basliklar`
-- 

CREATE TABLE `tg_basliklar` (
  `baslikno` int(11) NOT NULL auto_increment,
  `girisno` int(11) NOT NULL,
  `baslik` varchar(100) NOT NULL,
  `yazar` varchar(60) NOT NULL,
  `tarih` timestamp NULL default CURRENT_TIMESTAMP,
  `aktif` varchar(5) NOT NULL default 'Evet',
  PRIMARY KEY  (`baslikno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Forum Başlıkları' AUTO_INCREMENT=18 ;

-- 
-- Tablo döküm verisi `tg_basliklar`
-- 

INSERT INTO `tg_basliklar` VALUES (17, 24, '1. Proje Hakkında', 'Orçun Madran', '2006-02-21 11:48:30', 'Evet');
INSERT INTO `tg_basliklar` VALUES (16, 23, 'Tarihçesi hakkında söyleyebileceklerimiz', 'sy', '2006-02-19 13:04:17', 'Evet');
INSERT INTO `tg_basliklar` VALUES (15, 21, 'deneme', 'sy', '2006-02-13 21:57:54', 'Evet');
INSERT INTO `tg_basliklar` VALUES (14, 21, 'Ders ile ilgili düşünce ve görüşleriniz', 'Orçun Madran', '2006-02-09 16:43:24', 'Evet');
INSERT INTO `tg_basliklar` VALUES (13, 20, 'Sanal Kütüphaneler', 'Orçun Madran', '2006-02-05 02:39:24', 'Evet');
INSERT INTO `tg_basliklar` VALUES (12, 19, 'Ders ile ilgili düşünce ve görüşleriniz', 'Orçun Madran', '2006-02-04 22:12:31', 'Evet');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `tg_forumlar`
-- 

CREATE TABLE `tg_forumlar` (
  `girisno` int(11) NOT NULL auto_increment,
  `adi` varchar(25) NOT NULL,
  `aciklama` varchar(100) NOT NULL,
  `tip` varchar(20) NOT NULL,
  `yaratan` varchar(60) NOT NULL,
  `tarih` timestamp NULL default CURRENT_TIMESTAMP,
  `aktif` varchar(5) NOT NULL default 'Evet',
  PRIMARY KEY  (`girisno`),
  UNIQUE KEY `adi` (`adi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Tatışma Gruplar' AUTO_INCREMENT=25 ;

-- 
-- Tablo döküm verisi `tg_forumlar`
-- 

INSERT INTO `tg_forumlar` VALUES (24, 'ÖTÖ 304 - 01', 'Web', 'Ders Forumu', 'Orçun Madran', '2006-02-21 11:48:09', 'Evet');
INSERT INTO `tg_forumlar` VALUES (23, 'Uzaktan Eğitim', 'e-öğrenme üzerine söyleşiler', 'Serbest Kürsü', 'sy', '2006-02-19 13:03:55', 'Evet');
INSERT INTO `tg_forumlar` VALUES (21, 'ÖTÖ 309', 'Ötö 309 ders forumu', 'Ders Forumu', 'Orçun Madran', '2006-02-09 16:43:14', 'Evet');
INSERT INTO `tg_forumlar` VALUES (22, 'ÖTÖ 305 - 01', 'ders forumudur bu', 'Ders Forumu', 'sy', '2006-02-19 12:51:58', 'Evet');
INSERT INTO `tg_forumlar` VALUES (20, 'Sanal Bilgi Kaynakları', 'Elektronik ortamda yer alan sanal kaynaklar', 'Serbest Kürsü', 'Orçun Madran', '2006-02-05 02:39:06', 'Evet');
INSERT INTO `tg_forumlar` VALUES (19, 'ÖTÖ 001', 'Uzaktan Eğitimin Temelleri ders forumu', 'Ders Forumu', 'Orçun Madran', '2006-02-04 22:11:53', 'Evet');

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `tg_yorumlar`
-- 

CREATE TABLE `tg_yorumlar` (
  `baslikno` int(11) NOT NULL,
  `yorumno` int(11) NOT NULL auto_increment,
  `yorum` text NOT NULL,
  `yazar` varchar(60) NOT NULL,
  `tarih` timestamp NULL default CURRENT_TIMESTAMP,
  `guncellendi` varchar(30) NOT NULL default '../resimler/tg_yg_hayir.gif',
  `uyarialdi` varchar(30) NOT NULL default '../resimler/tg_yu_hayir.gif',
  `gtarih` varchar(50) default NULL,
  PRIMARY KEY  (`yorumno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Tartışma Grup Yorumları' AUTO_INCREMENT=19 ;

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
INSERT INTO `tg_yorumlar` VALUES (16, 16, 'Bu yorum işi de pek güzel canım.\r\n\r\nMaaşallah. Çok hoş çok...', 'sy', '2006-02-19 13:05:01', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', 'Bu yorum 19.02.2006 - 13:05 tarihinde güncellendi');
INSERT INTO `tg_yorumlar` VALUES (15, 17, 'deneme', 'sy', '2006-02-19 13:08:59', '../resimler/tg_yg_hayir.gif', '../resimler/tg_yu_hayir.gif', NULL);
INSERT INTO `tg_yorumlar` VALUES (17, 18, 'ilk proje çok zor \r\ndeğilmiş :-)', 'Orçun Madran', '2006-02-21 11:48:52', '../resimler/tg_yg_evet.gif', '../resimler/tg_yu_hayir.gif', 'Bu yorum 21.02.2006 - 11:48 tarihinde güncellendi');
