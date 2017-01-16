-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 26 Ocak 2010 saat 14:08:33
-- Sunucu sürümü: 5.0.67
-- PHP Sürümü: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `lms_v1`
--

-- --------------------------------------------------------

--
-- Tablo yapısı: `akildefterim`
--

CREATE TABLE IF NOT EXISTS `akildefterim` (
  `adno` int(11) NOT NULL auto_increment,
  `kadi` varchar(60) NOT NULL,
  `not` text NOT NULL,
  `giristarih` varchar(50) default NULL,
  `hatirlat` date default NULL,
  PRIMARY KEY  (`adno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Akıl Defterim' AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `akildefterim`
--


-- --------------------------------------------------------

--
-- Tablo yapısı: `dersler`
--

CREATE TABLE IF NOT EXISTS `dersler` (
  `dersno` int(11) NOT NULL auto_increment,
  `derskodu` varchar(25) NOT NULL,
  `dersadi` varchar(100) NOT NULL,
  PRIMARY KEY  (`dersno`),
  UNIQUE KEY `derskodu` (`derskodu`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Dersler' AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `dersler`
--

INSERT INTO `dersler` (`dersno`, `derskodu`, `dersadi`) VALUES
(1, 'BÖTE 501', 'E - Öğrenme''de Araç ve Teknolojiler');

-- --------------------------------------------------------

--
-- Tablo yapısı: `dersler_op`
--

CREATE TABLE IF NOT EXISTS `dersler_op` (
  `opno` int(11) NOT NULL auto_increment,
  `subeno` int(11) NOT NULL,
  `optipi` varchar(5) NOT NULL,
  `opadi` varchar(255) NOT NULL,
  `aciklama` text,
  `ttarihi` date NOT NULL,
  PRIMARY KEY  (`opno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Ödevler ve Projeler' AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `dersler_op`
--

INSERT INTO `dersler_op` (`opno`, `subeno`, `optipi`, `opadi`, `aciklama`, `ttarihi`) VALUES
(1, 1, 'odev', 'E - Öğrenme Etkinlikleri', 'E - öğrenmede kullanılabilecek etkinlikleri araştırarak raporlaştırınız.', '2007-03-23'),
(2, 1, 'proje', 'E - Öğrenme Portalı', 'Eğitim içeriklerinin Web üzerinden yayınlanmasına olanak sağlayacak bir e - öğrenme portalı tasarlayınız.', '2007-05-23');

-- --------------------------------------------------------

--
-- Tablo yapısı: `dersler_plan`
--

CREATE TABLE IF NOT EXISTS `dersler_plan` (
  `subeno` int(11) NOT NULL,
  `tanimamac` text,
  `degerlendirme` text,
  `kaynakca` text,
  `kapsamicerik` text,
  `egitimicerigi` varchar(100) default NULL,
  PRIMARY KEY  (`subeno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Ders Planı';

--
-- Tablo döküm verisi `dersler_plan`
--

INSERT INTO `dersler_plan` (`subeno`, `tanimamac`, `degerlendirme`, `kaynakca`, `kapsamicerik`, `egitimicerigi`) VALUES
(1, 'Ders, e-öğrenme''de kullanılan araç ve teknolojileri genel anlamda tanıtarak öğrencinin bu konudaki bilgi düzeyini arttırmayı amaçlamaktadır.', 'Devam ve Kanaat: %10 \r\nAra Sınav: %30 \r\nFinal Sınavı: %60', 'Moore, M. G. & Kearsley, G. (2004). Distance Education: A Systems View (2nd Ed.). USA: Wadsworth Publishing. Çalışma Rehberi: http://ouln.org/deguide.htm \r\n\r\nRudestam, K. E. (Ed.) & Schoenholtz-Read, J. (Ed.). (2002). Handbook of Online Learning : Innovations in Higher Education and Corporate Training. Sage Publications, USA. \r\n\r\nGarrison, D. R. & Anderson, T. (2003). E-Learning in the 21st Century. USA: RoutledgeFalmer. \r\n\r\nSloman, M. (2001). The E-Learning Rrevolution: From propositions to action. Great Britain: Chartered Institute of Personnel and Development.', '<b>1. Hafta: E-öğrenme İçin Araç ve Teknolojiler</b>\r\n\r\nKonumuz E-öğrenme için Araç ve Teknolojiler. Görevimiz ise bilgi ve becerileri herkese, her yerden ve her zaman erişilebilir yapmak. Peki nasıl?\r\n\r\n<b>2. Hafta: E-öğrenme Türleri ve Gerekli Teknolojiler</b>\r\n\r\nE-öğrenme genel olarak "web ve Internet teknolojilerinin, öğrenme deneyimleri oluşturmak için kullanılması" şeklinde tanımlanabilir. E-öğrenme daha detaylı düşündüğümüzde farklı biçimlerde karşımıza çıkabilir. \r\n\r\n<b>3. Hafta: Araçların Sınıflandırılması</b>\r\n\r\nYanıtlanması en zor sorulardan biri "e-öğrenme için hangi aracı kullanmalıyım" sorusudur. E-öğrenme ortamında bütün ihtiyaçları karşılayabilecek tek bir araç bulunmamaktadır. \r\n\r\n<b>4. Hafta: Donanım ve Ağlar</b>\r\n\r\nBilgisayar donanımı ve ağlar, e-öğrenme ortamının temelini oluşturur. Yazılım ve içerik için alt yapı oluşturur. Bir kere alındıktan ve kurulduktan sonra değiştirilmesi en zor olan teknoloji bileşenleridir.\r\n\r\n<b>5. Hafta: E-öğrenme ve ağ yapıları</b>\r\n\r\nE-öğrenme içeriği ağlar üzerinde seyahat eder. Ağlar olmadan bir sunucudaki dosyayı okumak, grup arkadaşları ile dosyayı paylaşmak, e-posta ile haberleşmek ve Internet üzerindeki kaynaklardan yararlanmak olanaksızdır. \r\n\r\n<b>6. Hafta: E-öğrenme İçeriğine</b>\r\n\r\nÖğrenciler içeriğe erişemezlerse öğrenme gerçekleşemez. Öğrenme, içeriği bulma, gezinme, görüntüleme ve etkileşim gibi işlemler sonucunda gerçekleşir. Bu nedenle, güvenilir, kolay kullanılabilen ve içeriği doğru görüntüleyebilen araçlar gerekir. \r\n\r\n<b>7. Hafta: Değerlendirme</b>', 'dersicerikleri/BOTE50101/online.php');

-- --------------------------------------------------------

--
-- Tablo yapısı: `dersler_snvtar`
--

CREATE TABLE IF NOT EXISTS `dersler_snvtar` (
  `snvtrhno` int(11) NOT NULL auto_increment,
  `subeno` int(11) NOT NULL,
  `sinavtipi` varchar(20) NOT NULL,
  `sinavyeri` varchar(20) NOT NULL,
  `baslamatarih` date NOT NULL,
  `bitistarih` date NOT NULL,
  `sinavsaat` varchar(5) default NULL,
  `aciklama` text,
  PRIMARY KEY  (`snvtrhno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Sınav Tarihleri' AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `dersler_snvtar`
--

INSERT INTO `dersler_snvtar` (`snvtrhno`, `subeno`, `sinavtipi`, `sinavyeri`, `baslamatarih`, `bitistarih`, `sinavsaat`, `aciklama`) VALUES
(1, 1, 'Arasınav', 'Merkezde Yüzyüze', '2007-03-23', '2007-03-23', '16:00', 'Sınav yeri Eğitim Fakültesi A 106 nolu lab.'),
(2, 1, 'Final Sınavı', 'Merkezde Yüzyüze', '2007-06-06', '2007-06-06', '10:00', 'Sınav yeri: G - 305');

-- --------------------------------------------------------

--
-- Tablo yapısı: `dersler_sohbet`
--

CREATE TABLE IF NOT EXISTS `dersler_sohbet` (
  `sohbetno` int(11) NOT NULL auto_increment,
  `subeno` int(11) NOT NULL,
  `sohbetgun` varchar(10) NOT NULL,
  `sohbetsaat` varchar(5) NOT NULL,
  `baslamatarih` date NOT NULL,
  `bitistarih` date NOT NULL,
  `aciklama` text,
  PRIMARY KEY  (`sohbetno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Sohbet Saatleri' AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `dersler_sohbet`
--

INSERT INTO `dersler_sohbet` (`sohbetno`, `subeno`, `sohbetgun`, `sohbetsaat`, `baslamatarih`, `bitistarih`, `aciklama`) VALUES
(1, 1, '3', '12:00', '2007-02-01', '2007-06-01', 'Sohbet süresi 1 saattir.'),
(2, 1, '5', '20:00', '2007-02-01', '2007-06-01', 'Sohbet süresi 2 saattir.');

-- --------------------------------------------------------

--
-- Tablo yapısı: `duyurular`
--

CREATE TABLE IF NOT EXISTS `duyurular` (
  `duyuruno` int(11) NOT NULL auto_increment,
  `yazar` varchar(60) NOT NULL,
  `dtip` varchar(25) NOT NULL,
  `dbaslik` varchar(100) NOT NULL,
  `dicerik` text,
  `dbastrh` date NOT NULL,
  `dbittrh` date NOT NULL,
  `gtarih` varchar(100) default NULL,
  PRIMARY KEY  (`duyuruno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 COMMENT='Duyuru yayınlama' AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `duyurular`
--


-- --------------------------------------------------------

--
-- Tablo yapısı: `giriscikis`
--

CREATE TABLE IF NOT EXISTS `giriscikis` (
  `kayitno` int(11) NOT NULL auto_increment,
  `kadi` varchar(60) NOT NULL,
  `eylem` varchar(5) NOT NULL,
  `tarih` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`kayitno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Kullanıcı Giriş - Çıkış Kayıtları' AUTO_INCREMENT=17 ;

--
-- Tablo döküm verisi `giriscikis`
--

INSERT INTO `giriscikis` (`kayitno`, `kadi`, `eylem`, `tarih`) VALUES
(1, 'admin', 'Giriş', '2007-03-23 11:49:13'),
(2, 'Örnek Öğrenci', 'Giriş', '2007-03-23 11:55:37'),
(3, 'Örnek Öğrenci', 'Giriş', '2007-03-23 12:16:07'),
(4, 'Orçun Madran', 'Giriş', '2007-03-23 13:22:57'),
(5, 'Orçun Madran', 'Giriş', '2007-03-23 13:40:01'),
(6, 'Örnek Öğrenci', 'Giriş', '2007-03-23 13:51:28'),
(7, 'admin', 'Giriş', '2007-03-23 13:52:41'),
(8, 'Örnek Öğrenci', 'Giriş', '2007-03-23 13:54:54'),
(9, 'Orçun Madran', 'Giriş', '2007-05-09 17:31:17'),
(10, 'Orçun Madran', 'Giriş', '2007-05-25 14:00:37'),
(11, 'Orçun Madran', 'Giriş', '2007-06-01 20:30:58'),
(12, 'Orçun Madran', 'Giriş', '2007-06-04 09:57:34'),
(13, 'Orçun Madran', 'Giriş', '2007-08-01 15:19:53'),
(14, 'admin', 'Giriş', '2008-12-23 16:45:17'),
(15, 'Orçun Madran', 'Giriş', '2009-03-08 16:27:27'),
(16, 'admin', 'Giriş', '2009-03-08 16:33:15');

-- --------------------------------------------------------

--
-- Tablo yapısı: `kullanici`
--

CREATE TABLE IF NOT EXISTS `kullanici` (
  `id` int(11) NOT NULL auto_increment,
  `ad` varchar(30) NOT NULL,
  `soyad` varchar(30) NOT NULL,
  `kadi` varchar(60) NOT NULL,
  `kadis` varchar(60) NOT NULL,
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
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Kullanıcı tablosu' AUTO_INCREMENT=9 ;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`id`, `ad`, `soyad`, `kadi`, `kadis`, `sifre`, `kategori`, `eposta`, `webadres`, `evadres`, `evtel`, `isadres`, `istel`, `mobiltel`, `aciklama`, `giriszaman`) VALUES
(1, 'Sistem', 'Yöneticisi', 'admin', 'admin', '9360673', 'yonetici', 'orcunmadran@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2006-09-07 16:52:44'),
(2, 'Orçun', 'Madran', 'madran', 'madran', '9360673', 'ogretime', 'omadran@baskent.edu.tr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2006-09-07 16:56:35'),
(8, 'Örnek', 'Öğrenci', 'ornekogrenci', 'ornekogrenci', '9360673', 'ogrenci', 'orcun@madran.net', 'http://', NULL, NULL, NULL, NULL, NULL, NULL, '2007-03-23 11:46:34');

-- --------------------------------------------------------

--
-- Tablo yapısı: `mesajlar`
--

CREATE TABLE IF NOT EXISTS `mesajlar` (
  `mesajno` int(11) NOT NULL auto_increment,
  `tarihsaat` timestamp NULL default CURRENT_TIMESTAMP,
  `gonderen` varchar(60) NOT NULL,
  `alici` varchar(60) NOT NULL,
  `konu` varchar(100) NOT NULL,
  `icerik` text,
  `okundu` binary(1) NOT NULL default '0',
  `silindi` binary(1) NOT NULL default '0',
  PRIMARY KEY  (`mesajno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Mesajlaşma Sistemi' AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`mesajno`, `tarihsaat`, `gonderen`, `alici`, `konu`, `icerik`, `okundu`, `silindi`) VALUES
(1, '2007-03-23 13:46:02', 'Orçun Madran', 'Örnek Öğrenci', 'Ödev Teslimi', 'DEneme mesajı...', '1', '0'),
(2, '2007-03-23 13:52:03', 'Örnek Öğrenci', 'Orçun Madran', 'Cevap: Ödev Teslimi', 'Mesaj alındı...\r\n\r\nOrjinal Mesaj\r\n-----------------\r\nKimden: Orçun Madran\r\nKime: Örnek Öğrenci\r\nTarih: 23.03.07 - 13:46\r\n\r\nDEneme mesajı...', '0', '0');

-- --------------------------------------------------------

--
-- Tablo yapısı: `siniflar`
--

CREATE TABLE IF NOT EXISTS `siniflar` (
  `girisno` int(11) NOT NULL auto_increment,
  `subeno` int(11) NOT NULL,
  `kadi` varchar(60) NOT NULL,
  `giriskontrol` varchar(75) NOT NULL,
  PRIMARY KEY  (`girisno`),
  UNIQUE KEY `giriskontrol` (`giriskontrol`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Sınıflar' AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `siniflar`
--

INSERT INTO `siniflar` (`girisno`, `subeno`, `kadi`, `giriskontrol`) VALUES
(1, 1, 'Örnek Öğrenci', 'Örnek Öğrenci1');

-- --------------------------------------------------------

--
-- Tablo yapısı: `sohbet_bans`
--

CREATE TABLE IF NOT EXISTS `sohbet_bans` (
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `userid` int(11) default NULL,
  `banneduserid` int(11) default NULL,
  `roomid` int(11) default NULL,
  `ip` varchar(16) character set utf8 collate utf8_turkish_ci default NULL,
  KEY `userid` (`userid`),
  KEY `created` (`created`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `sohbet_bans`
--


-- --------------------------------------------------------

--
-- Tablo yapısı: `sohbet_connections`
--

CREATE TABLE IF NOT EXISTS `sohbet_connections` (
  `id` varchar(32) character set utf8 collate utf8_turkish_ci NOT NULL,
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `userid` int(11) default NULL,
  `roomid` int(11) default NULL,
  `state` tinyint(4) NOT NULL default '1',
  `color` int(11) default NULL,
  `start` int(11) default NULL,
  `lang` char(2) character set utf8 collate utf8_turkish_ci default NULL,
  `ip` varchar(16) character set utf8 collate utf8_turkish_ci default NULL,
  `tzoffset` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `roomid` (`roomid`),
  KEY `updated` (`updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `sohbet_connections`
--

INSERT INTO `sohbet_connections` (`id`, `updated`, `created`, `userid`, `roomid`, `state`, `color`, `start`, `lang`, `ip`, `tzoffset`) VALUES
('f2909fd10ccb4d4777105bf70f264318', '2007-06-08 17:49:05', '2007-06-08 17:49:05', NULL, 1, 1, 16777215, 308, 'tr', '127.0.0.1', -180),
('fa8861ebb9b8518e021867e489dc6d17', '2007-06-08 17:50:04', '2007-06-08 17:47:42', NULL, 1, 1, 16777215, 295, 'tr', '127.0.0.1', -180),
('9bbe4bca8858cd94fcadd1503b37f86e', '2007-06-08 17:50:04', '2007-06-08 17:50:04', NULL, 1, 1, 16777215, 309, 'tr', '127.0.0.1', -180),
('4687ca04c018db6af872c6c028981fb1', '2007-06-08 17:50:36', '2007-06-08 17:50:09', NULL, 1, 1, 16777215, 313, 'tr', '127.0.0.1', -180);

-- --------------------------------------------------------

--
-- Tablo yapısı: `sohbet_ignors`
--

CREATE TABLE IF NOT EXISTS `sohbet_ignors` (
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `userid` int(11) default NULL,
  `ignoreduserid` int(11) default NULL,
  KEY `userid` (`userid`),
  KEY `ignoreduserid` (`ignoreduserid`),
  KEY `created` (`created`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `sohbet_ignors`
--


-- --------------------------------------------------------

--
-- Tablo yapısı: `sohbet_messages`
--

CREATE TABLE IF NOT EXISTS `sohbet_messages` (
  `id` int(11) NOT NULL auto_increment,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `toconnid` varchar(32) character set utf8 collate utf8_turkish_ci default NULL,
  `touserid` int(11) default NULL,
  `toroomid` int(11) default NULL,
  `command` varchar(255) character set utf8 collate utf8_turkish_ci NOT NULL,
  `userid` int(11) default NULL,
  `roomid` int(11) default NULL,
  `txt` text character set utf8 collate utf8_turkish_ci,
  PRIMARY KEY  (`id`),
  KEY `touserid` (`touserid`),
  KEY `toroomid` (`toroomid`),
  KEY `toconnid` (`toconnid`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 AUTO_INCREMENT=328 ;

--
-- Tablo döküm verisi `sohbet_messages`
--

INSERT INTO `sohbet_messages` (`id`, `created`, `toconnid`, `touserid`, `toroomid`, `command`, `userid`, `roomid`, `txt`) VALUES
(319, '2007-06-08 17:50:20', NULL, NULL, NULL, 'uclc', 2, NULL, '16777215'),
(320, '2007-06-08 17:50:20', NULL, NULL, NULL, 'ustc', 2, NULL, '1'),
(321, '2007-06-08 17:50:21', NULL, NULL, NULL, 'ravt', 2, NULL, ':mod:'),
(322, '2007-06-08 17:50:21', NULL, NULL, NULL, 'spht', 2, NULL, ''),
(323, '2007-06-08 17:50:21', NULL, NULL, NULL, 'uclc', 2, NULL, '16777215'),
(324, '2007-06-08 17:50:21', NULL, NULL, NULL, 'spht', 2, NULL, ''),
(325, '2007-06-08 17:50:24', NULL, NULL, NULL, 'mvu', 2, 2, NULL),
(326, '2007-06-08 17:50:36', '4687ca04c018db6af872c6c028981fb1', NULL, NULL, 'lout', NULL, NULL, 'login'),
(327, '2007-06-08 17:50:36', NULL, NULL, NULL, 'rmu', 2, NULL, NULL),
(296, '2007-06-08 17:48:12', 'fa8861ebb9b8518e021867e489dc6d17', NULL, NULL, 'lin', 2, 3, 'tr'),
(297, '2007-06-08 17:48:12', 'fa8861ebb9b8518e021867e489dc6d17', NULL, NULL, 'adr', NULL, 1, 'Lobi'),
(298, '2007-06-08 17:48:12', 'fa8861ebb9b8518e021867e489dc6d17', NULL, NULL, 'adr', NULL, 2, 'Konferans Salonu'),
(299, '2007-06-08 17:48:12', 'fa8861ebb9b8518e021867e489dc6d17', NULL, NULL, 'adr', NULL, 3, 'Ders'),
(300, '2007-06-08 17:48:12', NULL, NULL, NULL, 'adu', 2, 1, 'Orcun Madran'),
(301, '2007-06-08 17:48:12', NULL, NULL, NULL, 'uclc', 2, NULL, '16777215'),
(302, '2007-06-08 17:48:12', NULL, NULL, NULL, 'ustc', 2, NULL, '1'),
(303, '2007-06-08 17:48:13', NULL, NULL, NULL, 'ravt', 2, NULL, ':mod:'),
(304, '2007-06-08 17:48:13', NULL, NULL, NULL, 'spht', 2, NULL, ''),
(305, '2007-06-08 17:48:13', NULL, NULL, NULL, 'uclc', 2, NULL, '16777215'),
(306, '2007-06-08 17:48:13', NULL, NULL, NULL, 'spht', 2, NULL, ''),
(307, '2007-06-08 17:48:29', NULL, NULL, 1, 'msg', 2, 1, 'Merhaba'),
(308, '2007-06-08 17:49:05', 'f2909fd10ccb4d4777105bf70f264318', NULL, NULL, 'lout', NULL, NULL, 'login'),
(309, '2007-06-08 17:50:04', '9bbe4bca8858cd94fcadd1503b37f86e', NULL, NULL, 'lout', NULL, NULL, 'login'),
(310, '2007-06-08 17:50:04', 'fa8861ebb9b8518e021867e489dc6d17', NULL, NULL, 'lout', NULL, NULL, 'expiredlogin'),
(311, '2007-06-08 17:50:04', NULL, NULL, NULL, 'rmu', 2, NULL, NULL),
(312, '2007-06-08 17:50:09', '4687ca04c018db6af872c6c028981fb1', NULL, NULL, 'lout', NULL, NULL, 'login'),
(313, '2007-06-08 17:50:20', '4687ca04c018db6af872c6c028981fb1', NULL, NULL, 'lng', NULL, NULL, '<language loaded="1" id="tr" name="TÃ¼rkÃ§e"><messages  ignored="KullanÄ±cÄ± ''USER_LABEL'' mesajlarÄ±nÄ±zÄ± red ediyor" banned="YasaklandÄ±nÄ±z" login="Sohbete girmek iÃ§in lÃ¼tfen giriÅŸ yapÄ±nÄ±z" wrongPass="YanlÄ±ÅŸ kullanÄ±cÄ± ismi veya ÅŸifresi. LÃ¼tfen tekrar deneyin" anotherlogin="Bu kullanÄ±cÄ± ismi ile baÅŸka kullanÄ±cÄ± girmiÅŸ. LÃ¼tfen tekrar deneyin." expiredlogin="BaÄŸlantÄ±nÄ±z zaman aÅŸÄ±mÄ±na uÄŸradÄ±. LÃ¼tfen yeniden giriÅŸ yapÄ±n." enterroom="[ROOM_LABEL]: USER_LABEL odaya saat TIMESTAMP da girdi" leaveroom="[ROOM_LABEL]: USER_LABEL, odadan saat TIMESTAMP da Ã§Ä±ktÄ±" selfenterroom="HoÅŸgeldiniz! [ROOM_LABEL] odasÄ±na TIMESTAMP da giriÅŸ yaptÄ±nÄ±z" bellrang="USER_LABEL kullanÄ±cÄ±sÄ± zil Ã§aldÄ±" chatfull="Sohbet dolu. LÃ¼tfen daha sonra tekrar deneyiniz." iplimit="Zaten sohbettesiniz."/><desktop  invalidsettings="GeÃ§ersiz ayarlar" selectsmile="GÃ¼lenyÃ¼zler" sendBtn="Yolla" saveBtn="Kaydet" soundBtn="Ses" skinBtn="GÃ¶rÃ¼nÃ¼m" addRoomBtn="Ekle" myStatus="Durumum" room="Oda" welcome="HoÅŸgeldin USER_LABEL" ringTheBell="Cevap Yok? Zili Ã§al:" logOffBtn="X" helpBtn="?" adminSign="(M)"/><dialog id="misc"  roomnotfound="''ROOM_LABEL'' odasÄ± bulunamadÄ±" usernotfound="KullanÄ±cÄ± ''USER_LABEL'' bulunamadÄ±" unbanned="KullanÄ±cÄ± ''USER_LABEL'' tarafÄ±ndan yasaÄŸÄ±nÄ±z kaldÄ±rÄ±ldÄ±" banned="KullanÄ±cÄ± ''USER_LABEL'' tarafÄ±ndan yasaklandÄ±nÄ±z" unignored="KullanÄ±cÄ± ''USER_LABEL'' tarafÄ±ndan red listesinden Ã§Ä±kartÄ±ldÄ±nÄ±z" ignored="KullanÄ±cÄ± ''USER_LABEL'' tarafÄ±ndan red edildiniz" invitationdeclined="KullanÄ±cÄ± ''USER_LABEL'',''ROOM_LABEL'' odasÄ±na davetinizi kabul etmedi" invitationaccepted="KullanÄ±cÄ± ''USER_LABEL'',''ROOM_LABEL'' odasÄ±na davetinizi kabul etti" roomnotcreated="Oda yaratÄ±lmadÄ±" roomisfull="[ROOM_LABEL] odasÄ± dolu. LÃ¼tfen baÅŸka bir oda seÃ§iniz." alert="&lt;b&gt;UYARI!&lt;/b&gt;&lt;br&gt;&lt;br&gt;" chatalert="&lt;b&gt;UYARI!&lt;/b&gt;&lt;br&gt;&lt;br&gt;" gag="&lt;b&gt;DURATION dakika boyunca susturuldunuz!&lt;/b&gt;&lt;br&gt;&lt;br&gt;Bu odadaki mesajlarÄ± gÃ¶rebilirsiniz, ancak susturulma sÃ¼reniz sona erene kadar yeni mesaj gÃ¶nderemezsiniz." ungagged="''USER_LABEL'' tarafÄ±ndan susturulma cezanÄ±z iptal edildi." gagconfirm="USER_LABEL MINUTES dakika iÃ§in susturuldu." alertconfirm="USER_LABEL uyarÄ±yÄ± okudu." file_declined="DosyanÄ±z USER_LABEL tarafÄ±ndan reddedildi." file_accepted="DosyanÄ±z USER_LABEL tarafÄ±ndan kabul edildi."/><dialog id="unignore"  unignoreBtn="Red iptal" unignoretext="Red iptal metnini giriniz"/><dialog id="unban"  unbanBtn="Yasak iptal" unbantext="Yasak iptal metnini giriniz"/><dialog id="tablabels"  themes="Temalar" sounds="Sesler" text="Metin" effects="Efektler" admin="YÃ¶netici" about="HakkÄ±nda"/><dialog id="text"  itemChange="DeÄŸiÅŸtirilecek madde" fontSize="YazÄ± karakter bÃ¼yÃ¼klÃ¼ÄŸÃ¼" fontFamily="YazÄ± tipi" language="Dil" mainChat="Ana Sohbet" interfaceElements="Arabirim ElemanlarÄ±" title="BaÅŸlÄ±k" mytextcolor="AlÄ±nan mesajlarÄ±n hepsi iÃ§in benim metin rengimi kullan."/><dialog id="effects"  avatars="Avatarlar" mainchat="Ana sohbet" roomlist="Oda listesi" background="Arka plan" custom="DiÄŸer" showBackgroundImages="Arka planÄ± gÃ¶rÃ¼ntÃ¼le" splashWindow="Yeni mesaj geldiÄŸinde pencereyi gÃ¶ster" uiAlpha="ÅžeffaflÄ±k"/><dialog id="sound"  sampleBtn="Ã–rnek" testBtn="Test" muteall="Sessiz" submitmessage="Mesaj yolla" reveivemessage="Mesaj al" enterroom="Odaya gir" leaveroom="Odadan Ã§Ä±k" pan="Denge" volume="Ses" initiallogin="Ä°lk giriÅŸ" logout="Ã‡Ä±kÄ±ÅŸ" privatemessagereceived="Ã–zel mesaj al" invitationreceived="Davet al" combolistopenclose="SeÃ§enek listesini aÃ§/kapa" userbannedbooted="KullanÄ±cÄ± yasaklandÄ± veya Ã§Ä±kartÄ±ldÄ±" usermenumouseover="Fare kullanÄ±cÄ± menÃ¼sÃ¼ Ã¼zerinde" roomopenclose="Oda bÃ¶lÃ¼mÃ¼nÃ¼ aÃ§/kapa" popupwindowopen="Yeni pencere aÃ§Ä±lÄ±ÅŸÄ±" popupwindowclosemin="Yeni pencere kapanÄ±ÅŸÄ±" pressbutton="Buton basÄ±lmasÄ±" otheruserenters="DiÄŸer kullanÄ±cÄ± odaya girdi"/><dialog id="skin"  inputBoxBackground="GiriÅŸ kutusu arkaplan" privateLogBackground="Ã–zel log arkaplan" publicLogBackground="Genel log arkaplan" enterRoomNotify="Odaya giriÅŸ uyarÄ±sÄ±nÄ± girin" roomText="Oda metni" room="Oda arkaplan" userListBackground="KullanÄ±cÄ± listesi arkaplan" dialogTitle="Diyalog baÅŸlÄ±ÄŸÄ±" dialog="Diyalog arkaplan" buttonText="Buton yazÄ±sÄ±" button="Buton arkaplan" bodyText="GÃ¶vde metni" background="Ana arkaplan" borderColor="Buton rengi" selectskin="Renk tasarÄ±mÄ±nÄ± seÃ§in..." buttonBorder="Buton sÄ±nÄ±r rengi" selectBigSkin="GÃ¶rÃ¼ntÃ¼ tÃ¼rÃ¼ ÅŸeÃ§in..." titleText="BaÅŸlÄ±k metni"/><dialog id="privateBox"  sendBtn="GÃ¶nder" toUser="USER_LABEL ile konuÅŸuluyor:"/><dialog id="login"  loginBtn="GiriÅŸ" language="Dil:" moderator="" password="Åžifre:" username="KullanÄ±cÄ± ismi:"/><dialog id="invitenotify"  declineBtn="Reddet" acceptBtn="Kabul et" userinvited="KullanÄ±cÄ± ''USER_LABEL'', sizi ''ROOM_LABEL'' odasÄ±na davet etti"/><dialog id="invite"  sendBtn="GÃ¶nder" includemessage="Bu mesajÄ± davetinize ekleyin:" inviteto="KullanÄ±cÄ±yÄ± davet ettiÄŸiniz oda:"/><dialog id="ignore"  ignoreBtn="Red" ignoretext="Red metnini giriniz"/><dialog id="createroom"  createBtn="Yarat" private="Ã–zel" public="Genel" entername="Oda ismini girin"/><dialog id="ban"  banBtn="Yasakla" byIP="IP ile" fromChat="sohbetten" fromRoom="odadan" banText="Yasaklama metnini giriniz"/><dialog id="common"  cancelBtn="Ä°ptal" okBtn="Tamam" win_choose="GÃ¶nderilecek dosyayÄ± seÃ§iniz:" win_upl_btn="  GÃ¶nder  " upl_error="Dosya gÃ¶nderme hatasÄ±" pls_select_file="LÃ¼tfen gÃ¶nderilecek dosyayÄ± seÃ§iniz" ext_not_allowed="FILE_EXT uzantÄ±lÄ± dosyalara izin verilmemektedir. LÃ¼tfen bu uzantÄ±lardan birine sahip bir dosya seÃ§iniz: ALLOWED_EXT" size_too_big="PaylaÅŸmak istediÄŸiniz dosyanÄ±n boyutu izin verilen azami dosya boyutundan bÃ¼yÃ¼ktÃ¼r. LÃ¼tfen tekrar deneyiniz."/><dialog id="sharefile"  chat_users="[ Sohbet ile PaylaÅŸ ]" all_users="[ Oda ile PaylaÅŸ ]" file_info_size="&lt;br&gt;Bu dosya iÃ§in izin verilen azami boyut MAX_SIZE." file_info_ext=" Ä°zin Verilen Dosya TÃ¼rleri: ALLOWED_EXT" win_share_only="ile PaylaÅŸ" usr_message="&lt;b&gt;USER_LABEL sizinle bir dosya paylaÅŸmak istiyor&lt;/b&gt;&lt;br&gt;&lt;br&gt;Dosya adÄ±: F_NAME&lt;br&gt;Dosya boyutu: F_SIZE"/><dialog id="loadavatarbg"  win_title="Ã–zel Arka plan" file_info="DosyanÄ±z progresif olmayan bir JPG resmi veya bir Flash SWF dosyasÄ± olmalÄ±dÄ±r." use_label="Bu dosyayÄ± ÅŸunun iÃ§in kullan:" rb_mainchat_avatar="Sadece ana sohbet avatarÄ±" rb_roomlist_avatar="Sadece oda listesi avatarÄ±" rb_mc_rl_avatar="Hem ana sohbet hem de oda listesi avatarÄ±" rb_this_theme="Sadece bu tema iÃ§in arka plan" rb_all_themes="TÃ¼m temalar iÃ§in arka plan"/><status  away="Uzakta" busy="MeÅŸgul" here="Burada" brb="Hemen Gelecek"/><usermenu  profile="Profil" unban="Yasak iptali" ban="YasaklÄ±" unignore="Red iptali" fileshare="Dosya PaylaÅŸ" ignore="Red" invite="Davet" privatemessage="Ã–zel mesaj"/></language>'),
(295, '2007-06-08 17:48:12', 'fa8861ebb9b8518e021867e489dc6d17', NULL, NULL, 'lng', NULL, NULL, '<language loaded="1" id="tr" name="TÃ¼rkÃ§e"><messages  ignored="KullanÄ±cÄ± ''USER_LABEL'' mesajlarÄ±nÄ±zÄ± red ediyor" banned="YasaklandÄ±nÄ±z" login="Sohbete girmek iÃ§in lÃ¼tfen giriÅŸ yapÄ±nÄ±z" wrongPass="YanlÄ±ÅŸ kullanÄ±cÄ± ismi veya ÅŸifresi. LÃ¼tfen tekrar deneyin" anotherlogin="Bu kullanÄ±cÄ± ismi ile baÅŸka kullanÄ±cÄ± girmiÅŸ. LÃ¼tfen tekrar deneyin." expiredlogin="BaÄŸlantÄ±nÄ±z zaman aÅŸÄ±mÄ±na uÄŸradÄ±. LÃ¼tfen yeniden giriÅŸ yapÄ±n." enterroom="[ROOM_LABEL]: USER_LABEL odaya saat TIMESTAMP da girdi" leaveroom="[ROOM_LABEL]: USER_LABEL, odadan saat TIMESTAMP da Ã§Ä±ktÄ±" selfenterroom="HoÅŸgeldiniz! [ROOM_LABEL] odasÄ±na TIMESTAMP da giriÅŸ yaptÄ±nÄ±z" bellrang="USER_LABEL kullanÄ±cÄ±sÄ± zil Ã§aldÄ±" chatfull="Sohbet dolu. LÃ¼tfen daha sonra tekrar deneyiniz." iplimit="Zaten sohbettesiniz."/><desktop  invalidsettings="GeÃ§ersiz ayarlar" selectsmile="GÃ¼lenyÃ¼zler" sendBtn="Yolla" saveBtn="Kaydet" soundBtn="Ses" skinBtn="GÃ¶rÃ¼nÃ¼m" addRoomBtn="Ekle" myStatus="Durumum" room="Oda" welcome="HoÅŸgeldin USER_LABEL" ringTheBell="Cevap Yok? Zili Ã§al:" logOffBtn="X" helpBtn="?" adminSign="(M)"/><dialog id="misc"  roomnotfound="''ROOM_LABEL'' odasÄ± bulunamadÄ±" usernotfound="KullanÄ±cÄ± ''USER_LABEL'' bulunamadÄ±" unbanned="KullanÄ±cÄ± ''USER_LABEL'' tarafÄ±ndan yasaÄŸÄ±nÄ±z kaldÄ±rÄ±ldÄ±" banned="KullanÄ±cÄ± ''USER_LABEL'' tarafÄ±ndan yasaklandÄ±nÄ±z" unignored="KullanÄ±cÄ± ''USER_LABEL'' tarafÄ±ndan red listesinden Ã§Ä±kartÄ±ldÄ±nÄ±z" ignored="KullanÄ±cÄ± ''USER_LABEL'' tarafÄ±ndan red edildiniz" invitationdeclined="KullanÄ±cÄ± ''USER_LABEL'',''ROOM_LABEL'' odasÄ±na davetinizi kabul etmedi" invitationaccepted="KullanÄ±cÄ± ''USER_LABEL'',''ROOM_LABEL'' odasÄ±na davetinizi kabul etti" roomnotcreated="Oda yaratÄ±lmadÄ±" roomisfull="[ROOM_LABEL] odasÄ± dolu. LÃ¼tfen baÅŸka bir oda seÃ§iniz." alert="&lt;b&gt;UYARI!&lt;/b&gt;&lt;br&gt;&lt;br&gt;" chatalert="&lt;b&gt;UYARI!&lt;/b&gt;&lt;br&gt;&lt;br&gt;" gag="&lt;b&gt;DURATION dakika boyunca susturuldunuz!&lt;/b&gt;&lt;br&gt;&lt;br&gt;Bu odadaki mesajlarÄ± gÃ¶rebilirsiniz, ancak susturulma sÃ¼reniz sona erene kadar yeni mesaj gÃ¶nderemezsiniz." ungagged="''USER_LABEL'' tarafÄ±ndan susturulma cezanÄ±z iptal edildi." gagconfirm="USER_LABEL MINUTES dakika iÃ§in susturuldu." alertconfirm="USER_LABEL uyarÄ±yÄ± okudu." file_declined="DosyanÄ±z USER_LABEL tarafÄ±ndan reddedildi." file_accepted="DosyanÄ±z USER_LABEL tarafÄ±ndan kabul edildi."/><dialog id="unignore"  unignoreBtn="Red iptal" unignoretext="Red iptal metnini giriniz"/><dialog id="unban"  unbanBtn="Yasak iptal" unbantext="Yasak iptal metnini giriniz"/><dialog id="tablabels"  themes="Temalar" sounds="Sesler" text="Metin" effects="Efektler" admin="YÃ¶netici" about="HakkÄ±nda"/><dialog id="text"  itemChange="DeÄŸiÅŸtirilecek madde" fontSize="YazÄ± karakter bÃ¼yÃ¼klÃ¼ÄŸÃ¼" fontFamily="YazÄ± tipi" language="Dil" mainChat="Ana Sohbet" interfaceElements="Arabirim ElemanlarÄ±" title="BaÅŸlÄ±k" mytextcolor="AlÄ±nan mesajlarÄ±n hepsi iÃ§in benim metin rengimi kullan."/><dialog id="effects"  avatars="Avatarlar" mainchat="Ana sohbet" roomlist="Oda listesi" background="Arka plan" custom="DiÄŸer" showBackgroundImages="Arka planÄ± gÃ¶rÃ¼ntÃ¼le" splashWindow="Yeni mesaj geldiÄŸinde pencereyi gÃ¶ster" uiAlpha="ÅžeffaflÄ±k"/><dialog id="sound"  sampleBtn="Ã–rnek" testBtn="Test" muteall="Sessiz" submitmessage="Mesaj yolla" reveivemessage="Mesaj al" enterroom="Odaya gir" leaveroom="Odadan Ã§Ä±k" pan="Denge" volume="Ses" initiallogin="Ä°lk giriÅŸ" logout="Ã‡Ä±kÄ±ÅŸ" privatemessagereceived="Ã–zel mesaj al" invitationreceived="Davet al" combolistopenclose="SeÃ§enek listesini aÃ§/kapa" userbannedbooted="KullanÄ±cÄ± yasaklandÄ± veya Ã§Ä±kartÄ±ldÄ±" usermenumouseover="Fare kullanÄ±cÄ± menÃ¼sÃ¼ Ã¼zerinde" roomopenclose="Oda bÃ¶lÃ¼mÃ¼nÃ¼ aÃ§/kapa" popupwindowopen="Yeni pencere aÃ§Ä±lÄ±ÅŸÄ±" popupwindowclosemin="Yeni pencere kapanÄ±ÅŸÄ±" pressbutton="Buton basÄ±lmasÄ±" otheruserenters="DiÄŸer kullanÄ±cÄ± odaya girdi"/><dialog id="skin"  inputBoxBackground="GiriÅŸ kutusu arkaplan" privateLogBackground="Ã–zel log arkaplan" publicLogBackground="Genel log arkaplan" enterRoomNotify="Odaya giriÅŸ uyarÄ±sÄ±nÄ± girin" roomText="Oda metni" room="Oda arkaplan" userListBackground="KullanÄ±cÄ± listesi arkaplan" dialogTitle="Diyalog baÅŸlÄ±ÄŸÄ±" dialog="Diyalog arkaplan" buttonText="Buton yazÄ±sÄ±" button="Buton arkaplan" bodyText="GÃ¶vde metni" background="Ana arkaplan" borderColor="Buton rengi" selectskin="Renk tasarÄ±mÄ±nÄ± seÃ§in..." buttonBorder="Buton sÄ±nÄ±r rengi" selectBigSkin="GÃ¶rÃ¼ntÃ¼ tÃ¼rÃ¼ ÅŸeÃ§in..." titleText="BaÅŸlÄ±k metni"/><dialog id="privateBox"  sendBtn="GÃ¶nder" toUser="USER_LABEL ile konuÅŸuluyor:"/><dialog id="login"  loginBtn="GiriÅŸ" language="Dil:" moderator="" password="Åžifre:" username="KullanÄ±cÄ± ismi:"/><dialog id="invitenotify"  declineBtn="Reddet" acceptBtn="Kabul et" userinvited="KullanÄ±cÄ± ''USER_LABEL'', sizi ''ROOM_LABEL'' odasÄ±na davet etti"/><dialog id="invite"  sendBtn="GÃ¶nder" includemessage="Bu mesajÄ± davetinize ekleyin:" inviteto="KullanÄ±cÄ±yÄ± davet ettiÄŸiniz oda:"/><dialog id="ignore"  ignoreBtn="Red" ignoretext="Red metnini giriniz"/><dialog id="createroom"  createBtn="Yarat" private="Ã–zel" public="Genel" entername="Oda ismini girin"/><dialog id="ban"  banBtn="Yasakla" byIP="IP ile" fromChat="sohbetten" fromRoom="odadan" banText="Yasaklama metnini giriniz"/><dialog id="common"  cancelBtn="Ä°ptal" okBtn="Tamam" win_choose="GÃ¶nderilecek dosyayÄ± seÃ§iniz:" win_upl_btn="  GÃ¶nder  " upl_error="Dosya gÃ¶nderme hatasÄ±" pls_select_file="LÃ¼tfen gÃ¶nderilecek dosyayÄ± seÃ§iniz" ext_not_allowed="FILE_EXT uzantÄ±lÄ± dosyalara izin verilmemektedir. LÃ¼tfen bu uzantÄ±lardan birine sahip bir dosya seÃ§iniz: ALLOWED_EXT" size_too_big="PaylaÅŸmak istediÄŸiniz dosyanÄ±n boyutu izin verilen azami dosya boyutundan bÃ¼yÃ¼ktÃ¼r. LÃ¼tfen tekrar deneyiniz."/><dialog id="sharefile"  chat_users="[ Sohbet ile PaylaÅŸ ]" all_users="[ Oda ile PaylaÅŸ ]" file_info_size="&lt;br&gt;Bu dosya iÃ§in izin verilen azami boyut MAX_SIZE." file_info_ext=" Ä°zin Verilen Dosya TÃ¼rleri: ALLOWED_EXT" win_share_only="ile PaylaÅŸ" usr_message="&lt;b&gt;USER_LABEL sizinle bir dosya paylaÅŸmak istiyor&lt;/b&gt;&lt;br&gt;&lt;br&gt;Dosya adÄ±: F_NAME&lt;br&gt;Dosya boyutu: F_SIZE"/><dialog id="loadavatarbg"  win_title="Ã–zel Arka plan" file_info="DosyanÄ±z progresif olmayan bir JPG resmi veya bir Flash SWF dosyasÄ± olmalÄ±dÄ±r." use_label="Bu dosyayÄ± ÅŸunun iÃ§in kullan:" rb_mainchat_avatar="Sadece ana sohbet avatarÄ±" rb_roomlist_avatar="Sadece oda listesi avatarÄ±" rb_mc_rl_avatar="Hem ana sohbet hem de oda listesi avatarÄ±" rb_this_theme="Sadece bu tema iÃ§in arka plan" rb_all_themes="TÃ¼m temalar iÃ§in arka plan"/><status  away="Uzakta" busy="MeÅŸgul" here="Burada" brb="Hemen Gelecek"/><usermenu  profile="Profil" unban="Yasak iptali" ban="YasaklÄ±" unignore="Red iptali" fileshare="Dosya PaylaÅŸ" ignore="Red" invite="Davet" privatemessage="Ã–zel mesaj"/></language>'),
(294, '2007-06-08 17:47:42', 'fa8861ebb9b8518e021867e489dc6d17', NULL, NULL, 'lout', NULL, NULL, 'login'),
(314, '2007-06-08 17:50:20', '4687ca04c018db6af872c6c028981fb1', NULL, NULL, 'lin', 2, 3, 'tr'),
(315, '2007-06-08 17:50:20', '4687ca04c018db6af872c6c028981fb1', NULL, NULL, 'adr', NULL, 1, 'Lobi'),
(316, '2007-06-08 17:50:20', '4687ca04c018db6af872c6c028981fb1', NULL, NULL, 'adr', NULL, 2, 'Konferans Salonu'),
(317, '2007-06-08 17:50:20', '4687ca04c018db6af872c6c028981fb1', NULL, NULL, 'adr', NULL, 3, 'Ders'),
(318, '2007-06-08 17:50:20', NULL, NULL, NULL, 'adu', 2, 1, 'Orcun Madran');

-- --------------------------------------------------------

--
-- Tablo yapısı: `sohbet_rooms`
--

CREATE TABLE IF NOT EXISTS `sohbet_rooms` (
  `id` int(11) NOT NULL auto_increment,
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(64) character set utf8 collate utf8_turkish_ci NOT NULL,
  `password` varchar(32) character set utf8 collate utf8_turkish_ci NOT NULL,
  `ispublic` char(1) character set utf8 collate utf8_turkish_ci default NULL,
  `ispermanent` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `ispublic` (`ispublic`),
  KEY `ispermanent` (`ispermanent`),
  KEY `updated` (`updated`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `sohbet_rooms`
--

INSERT INTO `sohbet_rooms` (`id`, `updated`, `created`, `name`, `password`, `ispublic`, `ispermanent`) VALUES
(1, '2006-09-07 16:54:08', '2006-09-07 16:54:08', 'Lobi', '', 'y', 1),
(2, '2007-06-08 17:50:36', '2006-09-07 16:54:08', 'Konferans Salonu', '', 'y', 2),
(3, '2007-03-23 13:48:31', '2006-09-07 16:54:08', 'Ders', '', 'y', 3);

-- --------------------------------------------------------

--
-- Tablo yapısı: `sohbet_users`
--

CREATE TABLE IF NOT EXISTS `sohbet_users` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(200) character set utf8 collate utf8_turkish_ci NOT NULL,
  `password` varchar(32) character set utf8 collate utf8_turkish_ci NOT NULL,
  `roles` int(11) NOT NULL default '0',
  `profile` text character set utf8 collate utf8_turkish_ci,
  PRIMARY KEY  (`id`),
  KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `sohbet_users`
--


-- --------------------------------------------------------

--
-- Tablo yapısı: `subeler`
--

CREATE TABLE IF NOT EXISTS `subeler` (
  `subeno` int(11) NOT NULL auto_increment,
  `dersno` int(11) NOT NULL,
  `subekodu` varchar(30) NOT NULL,
  `sube` varchar(25) NOT NULL,
  `sorumlu` varchar(60) NOT NULL,
  PRIMARY KEY  (`subeno`),
  UNIQUE KEY `sube` (`sube`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Şubeler' AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `subeler`
--

INSERT INTO `subeler` (`subeno`, `dersno`, `subekodu`, `sube`, `sorumlu`) VALUES
(1, 1, '01', '1 - 01', 'Orçun Madran');

-- --------------------------------------------------------

--
-- Tablo yapısı: `tg_basliklar`
--

CREATE TABLE IF NOT EXISTS `tg_basliklar` (
  `baslikno` int(11) NOT NULL auto_increment,
  `girisno` int(11) NOT NULL,
  `baslik` varchar(100) NOT NULL,
  `yazar` varchar(60) NOT NULL,
  `tarih` timestamp NULL default CURRENT_TIMESTAMP,
  `aktif` varchar(5) NOT NULL default 'Evet',
  PRIMARY KEY  (`baslikno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Forum Başlıkları' AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `tg_basliklar`
--

INSERT INTO `tg_basliklar` (`baslikno`, `girisno`, `baslik`, `yazar`, `tarih`, `aktif`) VALUES
(1, 1, 'Açık Kaynak Kodlu LMS ve LCMS Projeleri', 'Orçun Madran', '2007-03-23 12:10:13', 'Evet');

-- --------------------------------------------------------

--
-- Tablo yapısı: `tg_forumlar`
--

CREATE TABLE IF NOT EXISTS `tg_forumlar` (
  `girisno` int(11) NOT NULL auto_increment,
  `adi` varchar(25) NOT NULL,
  `aciklama` varchar(100) NOT NULL,
  `tip` varchar(20) NOT NULL,
  `yaratan` varchar(60) NOT NULL,
  `tarih` timestamp NULL default CURRENT_TIMESTAMP,
  `aktif` varchar(5) NOT NULL default 'Evet',
  PRIMARY KEY  (`girisno`),
  UNIQUE KEY `adi` (`adi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Tatışma Gruplar' AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `tg_forumlar`
--

INSERT INTO `tg_forumlar` (`girisno`, `adi`, `aciklama`, `tip`, `yaratan`, `tarih`, `aktif`) VALUES
(1, 'BÖTE 501 - 01', 'E - Öğrenme Araç ve Teknolojileri', 'Ders Forumu', 'Orçun Madran', '2007-03-23 12:09:33', 'Evet');

-- --------------------------------------------------------

--
-- Tablo yapısı: `tg_yorumlar`
--

CREATE TABLE IF NOT EXISTS `tg_yorumlar` (
  `baslikno` int(11) NOT NULL,
  `yorumno` int(11) NOT NULL auto_increment,
  `yorum` text NOT NULL,
  `yazar` varchar(60) NOT NULL,
  `tarih` timestamp NULL default CURRENT_TIMESTAMP,
  `guncellendi` varchar(30) NOT NULL default '../resimler/tg_yg_hayir.gif',
  `uyarialdi` varchar(30) NOT NULL default '../resimler/tg_yu_hayir.gif',
  `gtarih` varchar(50) default NULL,
  PRIMARY KEY  (`yorumno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 COMMENT='Tartışma Grup Yorumları' AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `tg_yorumlar`
--

INSERT INTO `tg_yorumlar` (`baslikno`, `yorumno`, `yorum`, `yazar`, `tarih`, `guncellendi`, `uyarialdi`, `gtarih`) VALUES
(1, 1, 'Merhaba Arkadaşlar,\r\n\r\nAçık kaynak kodlu olarak geliştiricilerin hizmetine sunulmuş LMS ve LCMS projeleri ile ilgili bilgilerimizi bu başlık altında paylaşalım.\r\n\r\nAşağıda sizlerin öncelikli olarak araştırmanızı ve bilgi edinmenizi istediğim 2 farklı grup tarafından geliştirilen projeler ve ilgili web siteleri var. Bu projeleri inceleyip görüşlerinizi belirtiniz.\r\n\r\nMoodle  - http://www.moodle.org\r\n\r\nATutor  - http://www.atutor.ca', 'Orçun Madran', '2007-03-23 12:14:57', '../resimler/tg_yg_hayir.gif', '../resimler/tg_yu_hayir.gif', NULL),
(1, 2, 'Bu da örnek öğrenci yorumu', 'Örnek Öğrenci', '2007-03-23 13:52:20', '../resimler/tg_yg_hayir.gif', '../resimler/tg_yu_hayir.gif', NULL);
