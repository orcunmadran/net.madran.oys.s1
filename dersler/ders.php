<?php require_once('../Connections/iysconn.php'); ?>
<?php
//initialize the session
session_start();

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  session_unregister('MM_Username');
  session_unregister('MM_UserGroup');
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
session_start();
$MM_authorizedUsers = "yonetici,ogretime,ogrenci";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../giris_yetki_yok.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$colname_gk = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_gk = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_gk = sprintf("SELECT * FROM kullanici WHERE kadi = '%s'", $colname_gk);
$gk = mysql_query($query_gk, $iysconn) or die(mysql_error());
$row_gk = mysql_fetch_assoc($gk);
$totalRows_gk = mysql_num_rows($gk);

$sn_ders = "-1";
if (isset($_GET['subeno'])) {
  $sn_ders = (get_magic_quotes_gpc()) ? $_GET['subeno'] : addslashes($_GET['subeno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_ders = sprintf("SELECT DE.derskodu, DE.dersadi, SU.subekodu, SU.sorumlu, SU.subeno FROM dersler DE, subeler SU WHERE SU.subeno = '%s' AND DE.dersno = SU.dersno", $sn_ders);
$ders = mysql_query($query_ders, $iysconn) or die(mysql_error());
$row_ders = mysql_fetch_assoc($ders);
$totalRows_ders = mysql_num_rows($ders);

$colname_dersplani = "-1";
if (isset($_GET['subeno'])) {
  $colname_dersplani = (get_magic_quotes_gpc()) ? $_GET['subeno'] : addslashes($_GET['subeno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_dersplani = sprintf("SELECT * FROM dersler_plan WHERE subeno = %s", $colname_dersplani);
$dersplani = mysql_query($query_dersplani, $iysconn) or die(mysql_error());
$row_dersplani = mysql_fetch_assoc($dersplani);
$totalRows_dersplani = mysql_num_rows($dersplani);

$colname_sohbet = "-1";
if (isset($_GET['subeno'])) {
  $colname_sohbet = (get_magic_quotes_gpc()) ? $_GET['subeno'] : addslashes($_GET['subeno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_sohbet = sprintf("SELECT *, DATE_FORMAT(baslamatarih, '%%d.%%m.%%y') AS bast, DATE_FORMAT(bitistarih, '%%d.%%m.%%y') AS bitt FROM dersler_sohbet WHERE subeno = %s", $colname_sohbet);
$sohbet = mysql_query($query_sohbet, $iysconn) or die(mysql_error());
$row_sohbet = mysql_fetch_assoc($sohbet);
$totalRows_sohbet = mysql_num_rows($sohbet);

$colname_snvtrh = "-1";
if (isset($_GET['subeno'])) {
  $colname_snvtrh = (get_magic_quotes_gpc()) ? $_GET['subeno'] : addslashes($_GET['subeno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_snvtrh = sprintf("SELECT *, DATE_FORMAT(baslamatarih, '%%d.%%m.%%y') AS bast, DATE_FORMAT(bitistarih, '%%d.%%m.%%y') AS bitt FROM dersler_snvtar WHERE subeno = %s", $colname_snvtrh);
$snvtrh = mysql_query($query_snvtrh, $iysconn) or die(mysql_error());
$row_snvtrh = mysql_fetch_assoc($snvtrh);
$totalRows_snvtrh = mysql_num_rows($snvtrh);

$colname_odev = "-1";
if (isset($_GET['subeno'])) {
  $colname_odev = (get_magic_quotes_gpc()) ? $_GET['subeno'] : addslashes($_GET['subeno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_odev = sprintf("SELECT *, DATE_FORMAT(ttarihi, '%%d.%%m.%%y') AS tt FROM dersler_op WHERE subeno = %s AND optipi = 'odev' ORDER BY ttarihi ASC", $colname_odev);
$odev = mysql_query($query_odev, $iysconn) or die(mysql_error());
$row_odev = mysql_fetch_assoc($odev);
$totalRows_odev = mysql_num_rows($odev);

$colname_proje = "-1";
if (isset($_GET['subeno'])) {
  $colname_proje = (get_magic_quotes_gpc()) ? $_GET['subeno'] : addslashes($_GET['subeno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_proje = sprintf("SELECT *, DATE_FORMAT(ttarihi, '%%d.%%m.%%y') AS tt FROM dersler_op WHERE subeno = %s AND optipi = 'proje' ORDER BY ttarihi ASC", $colname_proje);
$proje = mysql_query($query_proje, $iysconn) or die(mysql_error());
$row_proje = mysql_fetch_assoc($proje);
$totalRows_proje = mysql_num_rows($proje);
?>
<html><!-- InstanceBegin template="/Templates/iys.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sanal Kampüs - Baþkent Üniversitesi Eðitim Fakültesi</title>
<!-- InstanceEndEditable --><meta http-equiv="content-language" content="TR">
<meta http-equiv="content-type" content="text/html; charset=windows-1254">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<meta name="description" content="FW MX 2004 DW MX 2004 HTML">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Thu Jan 26 19:42:24 GMT+0200 (GTB Standard Time) 2006-->
<script language="JavaScript">
<!--

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
/* Functions that swaps images. */
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

/* Functions that handle preload. */
function MM_preloadImages() { //v3.0
 var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
   var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
   if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<link href="../iys.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link {
	color: #0000FF;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #0000FF;
}
a:hover {
	text-decoration: underline;
	color: #CC0000;
}
a:active {
	text-decoration: none;
	color: #CC0000;
}
-->
</style>
<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<!-- InstanceEndEditable -->
</head>
<body bgcolor="#666666" onLoad="MM_preloadImages('../fw_iys/sb_r2_c1_f2.gif','../fw_iys/sb_r2_c4_f2.gif','../fw_iys/sb_r2_c6_f2.gif','../fw_iys/sb_r2_c8_f2.gif','../fw_iys/sb_r2_c10_f2.gif','../fw_iys/sb_r2_c12_f2.gif','../fw_iys/sb_r2_c14_f2.gif','../fw_iys/sb_r2_c16_f2.gif','../fw_iys/sb_r2_c19_f2.gif')">
<!--The following section is an HTML table which reassembles the sliced image in a browser.-->
<!--Copy the table section including the opening and closing table tags, and paste the data where-->
<!--you want the reassembled image to appear in the destination document. -->
<!--======================== BEGIN COPYING THE HTML HERE ==========================-->
<table width="955" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="sb.png" fwbase="sb.gif" fwstyle="Dreamweaver" fwdocid = "1301164485" fwnested="0" -->
  <tr>
<!-- Shim row, height 1. -->
   <td><img src="../fw_iys/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="73" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="59" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="51" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="58" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="71" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="104" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="60" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="62" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="160" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="127" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr><!-- row 1 -->
   <td colspan="20"><img src="../fw_iys/sb_r1_c1.gif" name="sb_r1_c1" width="955" height="31" border="0"></td>
   <td><img src="../fw_iys/spacer.gif" width="1" height="31" border="0" alt=""></td>
  </tr>
  <tr><!-- row 2 -->
   <td colspan="2"><a href="../anasayfa.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c1','','../fw_iys/sb_r2_c1_f2.gif',1)"><img name="sb_r2_c1" src="../fw_iys/sb_r2_c1.gif" width="78" height="25" border="0" alt="Anasayfa"></a></td>
   <td><img name="sb_r2_c3" src="../fw_iys/sb_r2_c3.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="dersler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c4','','../fw_iys/sb_r2_c4_f2.gif',1)"><img name="sb_r2_c4" src="../fw_iys/sb_r2_c4.gif" width="59" height="25" border="0" alt="Yüklendiðin dersleri görüntüle"></a></td>
   <td><img name="sb_r2_c5" src="../fw_iys/sb_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../mesajlar/mesajlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c6','','../fw_iys/sb_r2_c6_f2.gif',1)"><img name="sb_r2_c6" src="../fw_iys/sb_r2_c6.gif" width="51" height="25" border="0" alt="Mesaj alýp gönder"></a></td>
   <td><img name="sb_r2_c7" src="../fw_iys/sb_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../sohbet.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c8','','../fw_iys/sb_r2_c8_f2.gif',1)"><img src="../fw_iys/sb_r2_c8.gif" alt="Sohbet odalarýna giriþ yap" name="sb_r2_c8" width="58" height="25" border="0"></a></td>
   <td><img name="sb_r2_c9" src="../fw_iys/sb_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../forumlar/forumlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c10','','../fw_iys/sb_r2_c10_f2.gif',1)"><img name="sb_r2_c10" src="../fw_iys/sb_r2_c10.gif" width="71" height="25" border="0" alt="Tartýþma gruplarýna katýl"></a></td>
   <td><img name="sb_r2_c11" src="../fw_iys/sb_r2_c11.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../kisiselbilgiler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c12','','../fw_iys/sb_r2_c12_f2.gif',1)"><img name="sb_r2_c12" src="../fw_iys/sb_r2_c12.gif" width="104" height="25" border="0" alt="Kiþisel bilgilerinizi görüntüle ya da güncelle"></a></td>
   <td><img name="sb_r2_c13" src="../fw_iys/sb_r2_c13.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../iletisim.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c14','','../fw_iys/sb_r2_c14_f2.gif',1)"><img name="sb_r2_c14" src="../fw_iys/sb_r2_c14.gif" width="60" height="25" border="0" alt="Akademik ve Teknik birimlerle iletiþime geç"></a></td>
   <td><img name="sb_r2_c15" src="../fw_iys/sb_r2_c15.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../yardim.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c16','','../fw_iys/sb_r2_c16_f2.gif',1)"><img name="sb_r2_c16" src="../fw_iys/sb_r2_c16.gif" width="62" height="25" border="0" alt="Yardým konularýný görüntüle"></a></td>
   <td><a href="../admin/anasayfa.php"><img name="sb_r2_c17" src="../resimler/gecis.gif" width="15" height="25" border="0" alt="Yönetim paneline geçiþ yap (Yönetici ve Öðretim Elemaný)"></a></td>
   <td bgcolor="#000000"><div align="center" class="kimlik"><?php echo $row_gk['kadi']; ?></div></td>
   <td colspan="2"><a href="<?php echo $logoutAction ?>"><img src="../fw_iys/sb_r2_c19.gif" alt="" name="sb_r2_c19" width="132" height="25" border="0" onMouseOver="MM_swapImage('sb_r2_c19','','../fw_iys/sb_r2_c19_f2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
   <td><img src="../fw_iys/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td background="../fw_iys/sb_r3_c1.gif"><img name="sb_r3_c1" src="../fw_iys/sb_r3_c1.gif" width="5" height="489" border="0" alt=""></td>
   <td colspan="18" valign="top" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="icerik" -->
     <table width="100%"  border="0" cellspacing="5" cellpadding="5">
       <tr>
         <td colspan="2" class="altbaslik"><div align="left"><span class="baslik"><?php echo $row_ders['derskodu']; ?> - <?php echo $row_ders['subekodu']; ?> <?php echo $row_ders['dersadi']; ?></span> </div></td>
         <td width="26%" class="altbaslik"><div align="right"><a href="#"><img src="../resimler/dersibaslat.jpg" border="0" onClick="MM_openBrWindow('<?php echo $row_dersplani['egitimicerigi']; ?>','SK','resizable=yes,width=860,height=640')"></a></div></td>
       </tr>
       <tr>
         <td width="50%" valign="top"><table width="100%"  border="0" cellspacing="5" cellpadding="0">
             <tr>
               <td rowspan="2" valign="top"><div align="center"><img name="" src="../resimler/tanimiamaci.jpg" width="75" height="75" alt=""></div></td>
               <td width="76%"><span class="arabaslik">Dersin Tanýmý ve Amacý</span></td>
             </tr>
             <tr>
               <td valign="top"><p class="icyaziblok"><?php echo str_replace("\n","<br>", $row_dersplani['tanimamac']);?></p>
                </td>
             </tr>
             <tr>
               <td colspan="2">&nbsp;</td>
             </tr>
             <tr>
               <td rowspan="2" valign="top"><div align="center"><img name="" src="../resimler/degerlendirme.jpg" width="75" height="75" alt=""></div></td>
               <td><span class="icyazi"><span class="arabaslik">Deðerlendirme Koþullarý</span></span></td>
             </tr>
             <tr>
               <td valign="top"><p class="icyaziblok"><?php echo str_replace("\n","<br>", $row_dersplani['degerlendirme']);?></p></td>
             </tr>
             <tr>
               <td colspan="2">&nbsp;</td>
             </tr>
             <tr>
               <td rowspan="2" valign="top"><div align="center"><img name="" src="../resimler/kaynakca.jpg" width="75" height="75" alt=""></div></td>
               <td><span class="icyazi"><span class="arabaslik">Kaynakça</span></span></td>
             </tr>
             <tr>
               <td valign="top"><p class="icyaziblok"><?php echo str_replace("\n","<br>", $row_dersplani['kaynakca']);?></p></td>
             </tr>
             <tr>
               <td colspan="2">&nbsp;</td>
             </tr>
             <tr>
               <td rowspan="2" valign="top"><div align="center"><img src="../resimler/sohbet.jpg" width="75" height="65"></div></td>
               <td><span class="arabaslik">Sohbet Saatleri </span></td>
             </tr>
             <tr>
               <td valign="top" class="icyaziblok"><?php if ($totalRows_sohbet == 0) { // Show if recordset empty ?>
Bu ders için henüz sohbet saati belirlenmemiþtir.
<?php } // Show if recordset empty ?>
                 <?php if ($totalRows_sohbet > 0) { // Show if recordset not empty ?>
                 <table width="100%"  border="0" cellspacing="3" cellpadding="0">
                   <?php do { ?>
                   <tr>
                     <td class="altbaslik">
					 <?php
					 $sayilar = array("0", "1", "2", "3", "4", "5", "6");
					 $gunler = array("Pazar", "Pazartesi", "Salý", "Çarþamba", "Perþembe", "Cuma", "Cumartesi");
					 $veriler = $row_sohbet['sohbetgun'];
					 echo str_replace($sayilar, $gunler, $veriler);
					 ?>,
					 <?php echo $row_sohbet['sohbetsaat'];?>
					 </td>
                   </tr>
                   <tr>
                     <td class="icyazi">Ýlk sohbet: <?php echo $row_sohbet['bast']; ?> - Son Sohbet: <?php echo $row_sohbet['bitt']; ?></td>
                   </tr>
                   <tr>
                     <td class="formaciklama"><?php echo $row_sohbet['aciklama']; ?></td>
                   </tr>
                   <tr>
                     <td class="icyazi">&nbsp;</td>
                   </tr>
                   <?php } while ($row_sohbet = mysql_fetch_assoc($sohbet)); ?>
                 </table>
                 <?php } // Show if recordset not empty ?></td>
             </tr>
             <tr>
               <td colspan="2">&nbsp;</td>
             </tr>
             <tr>
               <td rowspan="2" valign="top"><div align="center"><img src="../resimler/sinav.jpg" width="75" height="75" alt=""></div></td>
               <td class="arabaslik">Sýnav Tarihleri</td>
             </tr>
             <tr>
               <td valign="top" class="icyaziblok">
                 <?php if ($totalRows_snvtrh == 0) { // Show if recordset empty ?>
                 <p>Bu dersin sýnav tarihleri henüz belirlenmemiþtir.</p>
                 <?php } // Show if recordset empty ?>
                 <?php if ($totalRows_snvtrh > 0) { // Show if recordset not empty ?>
                 <table width="100%"  border="0" cellspacing="3" cellpadding="0">
                    <tr>
                      <td class="icyazi"></td>
                    </tr>
                    <?php do { ?>
                    <tr>
                      <td class="altbaslik"><?php echo $row_snvtrh['sinavyeri']; ?> <?php echo $row_snvtrh['sinavtipi']; ?></td>
                    </tr>
                    <tr>
                      <td class="icyaziuyari"><?php echo $row_snvtrh['bast']; ?> <span class="icyazi">-</span> <?php echo $row_snvtrh['bitt']; ?> <?php echo $row_snvtrh['sinavsaat']; ?> </td>
                    </tr>
                    <tr>
                      <td class="icyazi"><strong>Açýklama:</strong> <?php echo $row_snvtrh['aciklama']; ?></td>
                    </tr>
                    <tr>
                      <td class="icyazi">&nbsp;</td>
                    </tr>
                    <?php } while ($row_snvtrh = mysql_fetch_assoc($snvtrh)); ?>
                 </table>
                 <?php } // Show if recordset not empty ?></td>
             </tr>
             <tr>
               <td colspan="2">&nbsp;</td>
             </tr>
             <tr>
               <td rowspan="2" valign="top"><div align="center"><img src="../resimler/odev.jpg" width="75" height="65" alt=""></div></td>
               <td class="arabaslik">Ödev</td>
             </tr>
             <tr>
               <td valign="top" class="icyaziblok"><?php if ($totalRows_odev == 0) { // Show if recordset empty ?>
                 <p>Ders kapsamýnda yapman gereken ödev yok.</p>
                 <?php } // Show if recordset empty ?>
                 <?php do { ?>
                 <?php if ($totalRows_odev > 0) { // Show if recordset not empty ?>
                 <table width="100%"  border="0" cellspacing="3" cellpadding="0">
                   <tr>
                     <td class="altbaslik"><?php echo $row_odev['opadi']; ?></td>
                   </tr>
                   <tr>
                     <td class="icyazi"><span class="icyaziblok"><strong>Açýklama:</strong> <?php echo str_replace("\n","<br>", $row_odev['aciklama']);?></span></td>
                   </tr>
                   <tr>
                     <td class="icyazi"><strong>Teslim Tarihi:</strong> <span class="icyaziuyari"><?php echo $row_odev['tt']; ?></span></td>
                   </tr>
                   <tr>
                     <td class="icyazi">&nbsp;</td>
                   </tr>
                 </table>
                 <?php } // Show if recordset not empty ?>
                 <?php } while ($row_odev = mysql_fetch_assoc($odev)); ?></td>
             </tr>
             <tr>
               <td colspan="2">&nbsp;</td>
             </tr>
             <tr>
               <td rowspan="2" valign="top"><div align="center"><img name="" src="../resimler/proje.jpg" width="75" height="75" alt=""></div></td>
               <td class="arabaslik">Proje</td>
             </tr>
             <tr>
               <td valign="top"><?php if ($totalRows_proje == 0) { // Show if recordset empty ?>
                 <p class="icyaziblok">Ders kapsamýnda yapman gereken proje yok. </p>
                 <?php } // Show if recordset empty ?>
                 <?php do { ?>
                 <?php if ($totalRows_proje > 0) { // Show if recordset not empty ?>
                 <table width="100%"  border="0" cellspacing="3" cellpadding="0">
                   <tr>
                     <td class="altbaslik"><?php echo $row_proje['opadi']; ?></td>
                   </tr>
                   <tr>
                     <td class="icyazi"><strong>Açýklama:</strong> <?php echo str_replace("\n","<br>", $row_proje['aciklama']);?></td>
                   </tr>
                   <tr>
                     <td class="icyazi"><strong>Teslim Tarihi:</strong> <span class="icyaziuyari"><?php echo $row_proje['tt']; ?></span></td>
                   </tr>
                   <tr>
                     <td class="icyazi">&nbsp;</td>
                   </tr>
                 </table>
                 <?php } // Show if recordset not empty ?>
                 <?php } while ($row_proje = mysql_fetch_assoc($proje)); ?></td>
             </tr>
         </table></td>
         <td colspan="2" valign="top" class="icyazi"><table width="100%"  border="0" cellspacing="5" cellpadding="0">
             <tr>
               <td width="24%" rowspan="2" valign="top"><div align="center"><img src="../resimler/kapsamicerik.jpg" width="75" height="75"></div></td>
               <td width="76%"><span class="arabaslik">Kapsam ve Ýçerik</span></td>
             </tr>
             <tr>
               <td valign="top"><p class="icyazi"><?php echo str_replace("\n","<br>", $row_dersplani['kapsamicerik']);?></p></td>
             </tr>
         </table></td>
       </tr>
     </table>
    <!-- InstanceEndEditable --></td>
   <td background="../fw_iys/sb_r3_c20.gif"><img name="sb_r3_c20" src="../fw_iys/sb_r3_c20.gif" width="5" height="489" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="1" height="489" border="0" alt=""></td>
  </tr>
  <tr><!-- row 4 -->
   <td colspan="20"><img name="sb_r4_c1" src="../fw_iys/sb_r4_c1.gif" width="955" height="5" border="0" alt=""></td>
   <td><img src="../fw_iys/spacer.gif" width="1" height="5" border="0" alt=""></td>
  </tr>
<!--   This table was automatically created with Macromedia Fireworks   -->
<!--   http://www.macromedia.com   -->
</table>
<!--========================= STOP COPYING THE HTML HERE =========================-->
<p align="center" class="copyright">&copy; 2006 - Bilgisayar ve Öðretim Teknolojileri Eðitimi Bölümü</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($gk);

mysql_free_result($ders);

mysql_free_result($dersplani);

mysql_free_result($sohbet);

mysql_free_result($snvtrh);

mysql_free_result($odev);

mysql_free_result($proje);
?>
