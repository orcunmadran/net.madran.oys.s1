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

$colname_mesajy = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_mesajy = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_mesajy = sprintf("SELECT * FROM mesajlar WHERE alici = '%s' AND okundu = '0'", $colname_mesajy);
$mesajy = mysql_query($query_mesajy, $iysconn) or die(mysql_error());
$row_mesajy = mysql_fetch_assoc($mesajy);
$totalRows_mesajy = mysql_num_rows($mesajy);

mysql_select_db($database_iysconn, $iysconn);
$query_duyuruy = "SELECT duyuruno FROM duyurular WHERE dbastrh <= now() AND dbittrh >= now()";
$duyuruy = mysql_query($query_duyuruy, $iysconn) or die(mysql_error());
$row_duyuruy = mysql_fetch_assoc($duyuruy);
$totalRows_duyuruy = mysql_num_rows($duyuruy);

$deger_sohbet = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_sohbet = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_sohbet = sprintf("SELECT DS.sohbetno FROM dersler_sohbet DS, siniflar S, subeler SU WHERE DS.baslamatarih <= now() AND DS.bitistarih >= now() AND  DS.subeno = S.subeno = SU.subeno AND S.kadi = '%s' AND DS.sohbetgun = DATE_FORMAT(CURDATE(), '%%w')", $deger_sohbet);
$sohbet = mysql_query($query_sohbet, $iysconn) or die(mysql_error());
$row_sohbet = mysql_fetch_assoc($sohbet);
$totalRows_sohbet = mysql_num_rows($sohbet);

$deger_sohbetoe = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_sohbetoe = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_sohbetoe = sprintf("SELECT DS.sohbetno FROM dersler_sohbet DS, subeler SU WHERE DS.baslamatarih <= now() AND DS.bitistarih >= now() AND  DS.subeno = SU.subeno AND SU.sorumlu = '%s' AND DS.sohbetgun = DATE_FORMAT(CURDATE(), '%%w')", $deger_sohbetoe);
$sohbetoe = mysql_query($query_sohbetoe, $iysconn) or die(mysql_error());
$row_sohbetoe = mysql_fetch_assoc($sohbetoe);
$totalRows_sohbetoe = mysql_num_rows($sohbetoe);

$deger_sinavlar = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_sinavlar = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_sinavlar = sprintf("SELECT DST.snvtrhno FROM siniflar S, dersler_snvtar DST WHERE S.subeno = DST.subeno AND S.kadi = '%s' AND DST.bitistarih = NOW()", $deger_sinavlar);
$sinavlar = mysql_query($query_sinavlar, $iysconn) or die(mysql_error());
$row_sinavlar = mysql_fetch_assoc($sinavlar);
$totalRows_sinavlar = mysql_num_rows($sinavlar);

$deger_sinavlaroe = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_sinavlaroe = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_sinavlaroe = sprintf("SELECT DST.snvtrhno FROM subeler SU, dersler_snvtar DST WHERE SU.subeno = DST.subeno AND SU.sorumlu = '%s' AND DST.bitistarih = NOW()", $deger_sinavlaroe);
$sinavlaroe = mysql_query($query_sinavlaroe, $iysconn) or die(mysql_error());
$row_sinavlaroe = mysql_fetch_assoc($sinavlaroe);
$totalRows_sinavlaroe = mysql_num_rows($sinavlaroe);

$deger_odevler = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_odevler = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_odevler = sprintf("SELECT DOP.opno FROM siniflar S, dersler_op DOP WHERE S.subeno = DOP.subeno  AND S.kadi = '%s'  AND DOP.ttarihi = NOW() AND optipi = 'odev'", $deger_odevler);
$odevler = mysql_query($query_odevler, $iysconn) or die(mysql_error());
$row_odevler = mysql_fetch_assoc($odevler);
$totalRows_odevler = mysql_num_rows($odevler);

$deger_projeler = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_projeler = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_projeler = sprintf("SELECT DOP.opno FROM siniflar S, dersler_op DOP WHERE S.subeno = DOP.subeno AND S.kadi = '%s'  AND DOP.ttarihi = NOW() AND optipi = 'proje'", $deger_projeler);
$projeler = mysql_query($query_projeler, $iysconn) or die(mysql_error());
$row_projeler = mysql_fetch_assoc($projeler);
$totalRows_projeler = mysql_num_rows($projeler);

$deger_odevleroe = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_odevleroe = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_odevleroe = sprintf("SELECT DOP.opno FROM subeler SU, dersler_op DOP WHERE SU.subeno = DOP.subeno  AND SU.sorumlu = '%s'  AND DOP.ttarihi = NOW() AND optipi = 'odev'", $deger_odevleroe);
$odevleroe = mysql_query($query_odevleroe, $iysconn) or die(mysql_error());
$row_odevleroe = mysql_fetch_assoc($odevleroe);
$totalRows_odevleroe = mysql_num_rows($odevleroe);

$deger_projeleroe = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_projeleroe = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_projeleroe = sprintf("SELECT DOP.opno FROM subeler SU, dersler_op DOP WHERE SU.subeno = DOP.subeno AND SU.sorumlu = '%s'  AND DOP.ttarihi = NOW() AND optipi = 'proje'", $deger_projeleroe);
$projeleroe = mysql_query($query_projeleroe, $iysconn) or die(mysql_error());
$row_projeleroe = mysql_fetch_assoc($projeleroe);
$totalRows_projeleroe = mysql_num_rows($projeleroe);

$colname_yapacaklarim = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_yapacaklarim = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_yapacaklarim = sprintf("SELECT adno FROM akildefterim WHERE kadi = '%s' AND hatirlat = NOW()", $colname_yapacaklarim);
$yapacaklarim = mysql_query($query_yapacaklarim, $iysconn) or die(mysql_error());
$row_yapacaklarim = mysql_fetch_assoc($yapacaklarim);
$totalRows_yapacaklarim = mysql_num_rows($yapacaklarim);

$deger_odevlerbugun = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_odevlerbugun = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_odevlerbugun = sprintf("SELECT D.derskodu, SU.subekodu, D.dersadi, DATE_FORMAT(DOP.ttarihi, '%%d.%%m.%%y') AS teslimt, DOP.* FROM dersler D, subeler SU, siniflar S, dersler_op DOP WHERE S.subeno = DOP.subeno AND SU.subeno = S.subeno AND D.dersno = SU.dersno  AND S.kadi = '%s' AND DOP.ttarihi = NOW() AND optipi = 'odev'", $deger_odevlerbugun);
$odevlerbugun = mysql_query($query_odevlerbugun, $iysconn) or die(mysql_error());
$row_odevlerbugun = mysql_fetch_assoc($odevlerbugun);
$totalRows_odevlerbugun = mysql_num_rows($odevlerbugun);

$deger_odevlerbugunoe = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_odevlerbugunoe = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_odevlerbugunoe = sprintf("SELECT D.derskodu, SU.subekodu, D.dersadi, DATE_FORMAT(DOP.ttarihi, '%%d.%%m.%%y') AS teslimt, DOP.* FROM dersler D, subeler SU, dersler_op DOP WHERE DOP.subeno = SU.subeno AND D.dersno = SU.dersno  AND SU.sorumlu = '%s' AND DOP.ttarihi = NOW() AND optipi = 'odev'", $deger_odevlerbugunoe);
$odevlerbugunoe = mysql_query($query_odevlerbugunoe, $iysconn) or die(mysql_error());
$row_odevlerbugunoe = mysql_fetch_assoc($odevlerbugunoe);
$totalRows_odevlerbugunoe = mysql_num_rows($odevlerbugunoe);

$maxRows_tumodevler = 10;
$pageNum_tumodevler = 0;
if (isset($_GET['pageNum_tumodevler'])) {
  $pageNum_tumodevler = $_GET['pageNum_tumodevler'];
}
$startRow_tumodevler = $pageNum_tumodevler * $maxRows_tumodevler;

$deger_tumodevler = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_tumodevler = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_tumodevler = sprintf("SELECT D.derskodu, SU.subekodu, D.dersadi, DATE_FORMAT(DOP.ttarihi, '%%d.%%m.%%y') AS teslimt, DOP.* FROM dersler D, subeler SU, siniflar S, dersler_op DOP WHERE S.subeno = DOP.subeno AND SU.subeno = S.subeno AND D.dersno = SU.dersno  AND S.kadi = '%s' AND DOP.ttarihi > NOW() AND optipi = 'odev'", $deger_tumodevler);
$query_limit_tumodevler = sprintf("%s LIMIT %d, %d", $query_tumodevler, $startRow_tumodevler, $maxRows_tumodevler);
$tumodevler = mysql_query($query_limit_tumodevler, $iysconn) or die(mysql_error());
$row_tumodevler = mysql_fetch_assoc($tumodevler);

if (isset($_GET['totalRows_tumodevler'])) {
  $totalRows_tumodevler = $_GET['totalRows_tumodevler'];
} else {
  $all_tumodevler = mysql_query($query_tumodevler);
  $totalRows_tumodevler = mysql_num_rows($all_tumodevler);
}
$totalPages_tumodevler = ceil($totalRows_tumodevler/$maxRows_tumodevler)-1;

$deger_tumodevleroe = "-1";
if (isset($_SESSION['MM_Username'])) {
  $deger_tumodevleroe = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_tumodevleroe = sprintf("SELECT D.derskodu, SU.subekodu, D.dersadi, DATE_FORMAT(DOP.ttarihi, '%%d.%%m.%%y') AS teslimt, DOP.* FROM dersler D, subeler SU, dersler_op DOP WHERE DOP.subeno = SU.subeno AND D.dersno = SU.dersno  AND SU.sorumlu = '%s' AND DOP.ttarihi > NOW() AND optipi = 'odev'", $deger_tumodevleroe);
$tumodevleroe = mysql_query($query_tumodevleroe, $iysconn) or die(mysql_error());
$row_tumodevleroe = mysql_fetch_assoc($tumodevleroe);
$totalRows_tumodevleroe = mysql_num_rows($tumodevleroe);
?>
<html><!-- InstanceBegin template="/Templates/iys.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sanal Kamp�s - Ba�kent �niversitesi E�itim Fak�ltesi</title>
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
   <td><a href="../dersler/dersler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c4','','../fw_iys/sb_r2_c4_f2.gif',1)"><img name="sb_r2_c4" src="../fw_iys/sb_r2_c4.gif" width="59" height="25" border="0" alt="Y�klendi�in dersleri g�r�nt�le"></a></td>
   <td><img name="sb_r2_c5" src="../fw_iys/sb_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../mesajlar/mesajlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c6','','../fw_iys/sb_r2_c6_f2.gif',1)"><img name="sb_r2_c6" src="../fw_iys/sb_r2_c6.gif" width="51" height="25" border="0" alt="Mesaj al�p g�nder"></a></td>
   <td><img name="sb_r2_c7" src="../fw_iys/sb_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../sohbet.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c8','','../fw_iys/sb_r2_c8_f2.gif',1)"><img src="../fw_iys/sb_r2_c8.gif" alt="Sohbet odalar�na giri� yap" name="sb_r2_c8" width="58" height="25" border="0"></a></td>
   <td><img name="sb_r2_c9" src="../fw_iys/sb_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../forumlar/forumlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c10','','../fw_iys/sb_r2_c10_f2.gif',1)"><img name="sb_r2_c10" src="../fw_iys/sb_r2_c10.gif" width="71" height="25" border="0" alt="Tart��ma gruplar�na kat�l"></a></td>
   <td><img name="sb_r2_c11" src="../fw_iys/sb_r2_c11.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../kisiselbilgiler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c12','','../fw_iys/sb_r2_c12_f2.gif',1)"><img name="sb_r2_c12" src="../fw_iys/sb_r2_c12.gif" width="104" height="25" border="0" alt="Ki�isel bilgilerinizi g�r�nt�le ya da g�ncelle"></a></td>
   <td><img name="sb_r2_c13" src="../fw_iys/sb_r2_c13.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../iletisim.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c14','','../fw_iys/sb_r2_c14_f2.gif',1)"><img name="sb_r2_c14" src="../fw_iys/sb_r2_c14.gif" width="60" height="25" border="0" alt="Akademik ve Teknik birimlerle ileti�ime ge�"></a></td>
   <td><img name="sb_r2_c15" src="../fw_iys/sb_r2_c15.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../yardim.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c16','','../fw_iys/sb_r2_c16_f2.gif',1)"><img name="sb_r2_c16" src="../fw_iys/sb_r2_c16.gif" width="62" height="25" border="0" alt="Yard�m konular�n� g�r�nt�le"></a></td>
   <td><a href="../admin/anasayfa.php"><img name="sb_r2_c17" src="../resimler/gecis.gif" width="15" height="25" border="0" alt="Y�netim paneline ge�i� yap (Y�netici ve ��retim Eleman�)"></a></td>
   <td bgcolor="#000000"><div align="center" class="kimlik"><?php echo $row_gk['kadi']; ?></div></td>
   <td colspan="2"><a href="<?php echo $logoutAction ?>"><img src="../fw_iys/sb_r2_c19.gif" alt="" name="sb_r2_c19" width="132" height="25" border="0" onMouseOver="MM_swapImage('sb_r2_c19','','../fw_iys/sb_r2_c19_f2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
   <td><img src="../fw_iys/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td background="../fw_iys/sb_r3_c1.gif"><img name="sb_r3_c1" src="../fw_iys/sb_r3_c1.gif" width="5" height="489" border="0" alt=""></td>
   <td colspan="18" valign="top" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="icerik" -->
     <table width="100%"  border="0" cellspacing="5" cellpadding="5">
       <tr>
         <td width="619" height="28" valign="top"><p class="baslik">Sanak Kamp�s'deki �devlerin:</p>
           <p class="arabaslik">Teslim edilmesi gereken �dev / �devler;</p>
           <table width="100%"  border="0" cellspacing="5" cellpadding="5">
             <?php do { ?>
             <?php if ($totalRows_odevlerbugun > 0) { // Show if recordset not empty ?>
             <tr>
               <td><ul>
                   <li class="icyazi"><span class="altbaslik"><?php echo $row_odevlerbugun['derskodu']; ?> - <?php echo $row_odevlerbugun['subekodu']; ?> <?php echo $row_odevlerbugun['dersadi']; ?></span><br>
                         <?php echo $row_odevlerbugun['aciklama']; ?></li>
               </ul></td>
             </tr>
             <?php } // Show if recordset not empty ?>
             <?php } while ($row_odevlerbugun = mysql_fetch_assoc($odevlerbugun)); ?>
             <?php do { ?>
             <?php if ($totalRows_odevlerbugunoe > 0) { // Show if recordset not empty ?>
             <tr>
               <td><ul>
                   <li><span class="icyazi"><span class="altbaslik"><?php echo $row_odevlerbugunoe['derskodu']; ?> - <?php echo $row_odevlerbugunoe['subekodu']; ?> <?php echo $row_odevlerbugunoe['dersadi']; ?></span><br>
                           <?php echo $row_odevlerbugunoe['aciklama']; ?></span></li>
               </ul></td>
             </tr>
             <?php } // Show if recordset not empty ?>
             <?php } while ($row_odevlerbugunoe = mysql_fetch_assoc($odevlerbugunoe)); ?>
           </table>
           <p class="arabaslik">�leri tarihli   �dev / �devler;</p>
           <table width="100%"  border="0" cellspacing="5" cellpadding="5">
             <?php do { ?>
             <?php if ($totalRows_tumodevler > 0) { // Show if recordset not empty ?>
             <tr>
               <td><ul>
                   <li><span class="icyazi"><span class="altbaslik"><?php echo $row_tumodevler['derskodu']; ?> - <?php echo $row_tumodevler['subekodu']; ?> <?php echo $row_tumodevler['dersadi']; ?></span><br>
                           <strong>Teslim Tarihi:</strong> <?php echo $row_tumodevler['teslimt']; ?><br>
                           <?php echo $row_tumodevler['aciklama']; ?></span></li>
               </ul></td>
             </tr>
             <?php } // Show if recordset not empty ?>
             <?php } while ($row_tumodevler = mysql_fetch_assoc($tumodevler)); ?>
             <?php do { ?>
             <?php if ($totalRows_tumodevleroe > 0) { // Show if recordset not empty ?>
             <tr>
               <td><ul>
                   <li><span class="icyazi"><span class="altbaslik"><?php echo $row_tumodevleroe['derskodu']; ?> - <?php echo $row_tumodevleroe['subekodu']; ?> <?php echo $row_tumodevleroe['dersadi']; ?></span><br>
                           <strong>Teslim Tarihi:</strong> <?php echo $row_tumodevleroe['teslimt']; ?><br>
                           <?php echo $row_tumodevleroe['aciklama']; ?></span></li>
               </ul></td>
             </tr>
             <?php } // Show if recordset not empty ?>
             <?php } while ($row_tumodevleroe = mysql_fetch_assoc($tumodevleroe)); ?>
           </table></td>
         <td width="291" valign="top"><div align="center">
           <!--Fireworks MX Dreamweaver LBI target.  Created -->
           <br>
           <!--Fireworks MX Dreamweaver LBI target.  Created -->
           <table border="0" cellpadding="0" cellspacing="0" width="290">
             <!-- fwtable fwsrc="anasayfasag.png" fwbase="anasayfasag.gif" -->
             <tr>
               <!-- Shim row, height 1. -->
               <td><img src="../Library/anasayfasag/spacer.gif" width="92" height="1" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="4" height="1" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="6" height="1" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="7" height="1" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="12" height="1" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="29" height="1" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="44" height="1" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="96" height="1" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="1" border="0"></td>
             </tr>
             <tr>
               <!-- row 1 -->
               <td colspan="7"><img name="anasayfasag_r1_c1" src="../Library/anasayfasag/anasayfasag_r1_c1.gif" width="194" height="42" border="0"></td>
               <td rowspan="16"><img name="anasayfasag_r1_c8" src="../Library/anasayfasag/anasayfasag_r1_c8.gif" width="96" height="367" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="42" border="0"></td>
             </tr>
             <tr>
               <!-- row 2 -->
               <td colspan="4"><a href="../mesajlar/mesajlar.php"><img name="anasayfasag_r2_c1" src="../Library/anasayfasag/anasayfasag_r2_c1.gif" width="109" height="25" border="0"></a></td>
               <td colspan="3" class="icyaziuyari"><?php if ($totalRows_mesajy > 0) { // Show if recordset not empty ?>
                 <span class="icyazi">(</span><?php echo $totalRows_mesajy?><span class="icyazi">)</span>
                 <?php } // Show if recordset not empty ?></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="25" border="0"></td>
             </tr>
             <tr>
               <!-- row 3 -->
               <td colspan="7"><img name="anasayfasag_r3_c1" src="../Library/anasayfasag/anasayfasag_r3_c1.gif" width="194" height="4" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="4" border="0"></td>
             </tr>
             <tr>
               <!-- row 4 -->
               <td colspan="5"><a href="../duyurular/duyurular.php"><img name="anasayfasag_r4_c1" src="../Library/anasayfasag/anasayfasag_r4_c1.gif" width="121" height="25" border="0"></a></td>
               <td colspan="2" class="icyaziuyari"><?php if ($totalRows_duyuruy > 0) { // Show if recordset not empty ?>
                 <span class="icyazi">(</span><span class="icyazi"><span class="icyazi"><?php echo $totalRows_duyuruy?></span>)</span>
                 <?php } // Show if recordset not empty ?></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="25" border="0"></td>
             </tr>
             <tr>
               <!-- row 5 -->
               <td colspan="7"><img name="anasayfasag_r5_c1" src="../Library/anasayfasag/anasayfasag_r5_c1.gif" width="194" height="51" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="51" border="0"></td>
             </tr>
             <tr>
               <!-- row 6 -->
               <td colspan="3"><a href="sohbet.php"><img name="anasayfasag_r6_c1" src="../Library/anasayfasag/anasayfasag_r6_c1.gif" width="102" height="25" border="0"></a></td>
               <td colspan="4" class="icyazi"><strong>
                 <?php if ($totalRows_sohbet > 0) { // Show if recordset not empty ?>
(<span class="icyaziuyari"><?php echo $totalRows_sohbet;?></span>)
<?php } // Show if recordset not empty ?>
                    <?php if ($totalRows_sohbetoe > 0) { // Show if recordset not empty ?>
(<span class="arabaslikuyari"></span><span class="icyaziuyari"><?php echo $totalRows_sohbetoe;?></span>)
<?php } // Show if recordset not empty ?>
                 </span> </strong><strong> </strong></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="25" border="0"></td>
             </tr>
             <tr>
               <!-- row 7 -->
               <td colspan="7"><img name="anasayfasag_r7_c1" src="../Library/anasayfasag/anasayfasag_r7_c1.gif" width="194" height="4" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="4" border="0"></td>
             </tr>
             <tr>
               <!-- row 8 -->
               <td colspan="4"><a href="sinavlar.php"><img name="anasayfasag_r8_c1" src="../Library/anasayfasag/anasayfasag_r8_c1.gif" width="109" height="25" border="0"></a></td>
               <td colspan="3"><?php if ($totalRows_sinavlar > 0) { // Show if recordset not empty ?>
                 <strong>(</strong><span class="icyazi"><strong><span class="icyaziuyari"><?php echo $totalRows_sinavlar;?></span></strong></span><strong>)</strong>
                 <?php } // Show if recordset not empty ?>
                 <?php if ($totalRows_sinavlaroe > 0) { // Show if recordset not empty ?>
                 <strong>(</strong><span class="icyazi"><strong><span class="icyaziuyari"><?php echo $totalRows_sinavlaroe;?></span></strong></span><strong>) </strong>
                 <?php } // Show if recordset not empty ?></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="25" border="0"></td>
             </tr>
             <tr>
               <!-- row 9 -->
               <td colspan="7"><img name="anasayfasag_r9_c1" src="../Library/anasayfasag/anasayfasag_r9_c1.gif" width="194" height="4" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="4" border="0"></td>
             </tr>
             <tr>
               <!-- row 10 -->
               <td colspan="2"><a href="odev.php"><img name="anasayfasag_r10_c1" src="../Library/anasayfasag/anasayfasag_r10_c1.gif" width="96" height="25" border="0"></a></td>
               <td colspan="5"><?php if ($totalRows_odevler > 0) { // Show if recordset not empty ?>
                 <strong>(</strong><span class="icyaziuyari"><?php echo $totalRows_odevler;?></span><strong>)</strong><span class="icyazi"> </span>
                 <?php } // Show if recordset not empty ?>
                 <?php if ($totalRows_odevleroe > 0) { // Show if recordset not empty ?>
                 <strong>(</strong><span class="icyaziuyari"><?php echo $totalRows_odevleroe;?></span><strong>)</strong>
                 <?php } // Show if recordset not empty ?></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="25" border="0"></td>
             </tr>
             <tr>
               <!-- row 11 -->
               <td colspan="7"><img name="anasayfasag_r11_c1" src="../Library/anasayfasag/anasayfasag_r11_c1.gif" width="194" height="4" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="4" border="0"></td>
             </tr>
             <tr>
               <!-- row 12 -->
               <td><a href="proje.php"><img name="anasayfasag_r12_c1" src="../Library/anasayfasag/anasayfasag_r12_c1.gif" width="92" height="25" border="0"></a></td>
               <td colspan="6"><?php if ($totalRows_projeler > 0) { // Show if recordset not empty ?>
                 <strong>(</strong><span class="icyaziuyari"><?php echo $totalRows_projeler;?></span><strong>)</strong><span class="icyazi"> </span>
                 <?php } // Show if recordset not empty ?>
                 <?php if ($totalRows_projeleroe > 0) { // Show if recordset not empty ?>
                 <strong>(</strong><span class="icyaziuyari"><?php echo $totalRows_projeleroe;?></span><strong>)</strong>
                 <?php } // Show if recordset not empty ?></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="25" border="0"></td>
             </tr>
             <tr>
               <!-- row 13 -->
               <td colspan="7"><img name="anasayfasag_r13_c1" src="../Library/anasayfasag/anasayfasag_r13_c1.gif" width="194" height="54" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="54" border="0"></td>
             </tr>
             <tr>
               <!-- row 14 -->
               <td colspan="6"><a href="../akildefterim/yapacaklarim.php"><img name="anasayfasag_r14_c1" src="../Library/anasayfasag/anasayfasag_r14_c1.gif" width="150" height="25" border="0"></a></td>
               <td><?php if ($totalRows_yapacaklarim > 0) { // Show if recordset not empty ?>
                 <strong>(<span class="icyaziuyari"><?php echo $totalRows_yapacaklarim;?></span>)</strong><span class="icyazi"></span>
                 <?php } // Show if recordset not empty ?></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="25" border="0"></td>
             </tr>
             <tr>
               <!-- row 15 -->
               <td colspan="7"><img name="anasayfasag_r15_c1" src="../Library/anasayfasag/anasayfasag_r15_c1.gif" width="194" height="4" border="0"></td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="4" border="0"></td>
             </tr>
             <tr>
               <!-- row 16 -->
               <td colspan="2"><a href="../akildefterim/notal.php"><img name="anasayfasag_r16_c1" src="../Library/anasayfasag/anasayfasag_r16_c1.gif" width="96" height="25" border="0"></a></td>
               <td colspan="5">&nbsp;</td>
               <td><img src="../Library/anasayfasag/spacer.gif" width="1" height="25" border="0"></td>
             </tr>
           </table>
           <div align="left"></div>
         </div></td>
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
<p align="center" class="copyright">&copy; 2006 - Bilgisayar ve ��retim Teknolojileri E�itimi B�l�m�</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($gk);

mysql_free_result($mesajy);

mysql_free_result($duyuruy);

mysql_free_result($sohbet);

mysql_free_result($sohbetoe);

mysql_free_result($sinavlar);

mysql_free_result($sinavlaroe);

mysql_free_result($odevler);

mysql_free_result($projeler);

mysql_free_result($odevleroe);

mysql_free_result($projeleroe);

mysql_free_result($yapacaklarim);

mysql_free_result($odevlerbugun);

mysql_free_result($odevlerbugunoe);

mysql_free_result($tumodevler);

mysql_free_result($tumodevleroe);
?>
