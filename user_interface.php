<?php require_once('Connections/eniyisi.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "1,2,3";
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

$MM_restrictGoTo = "yetkisiz.php";
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
$colname_id = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_id = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_eniyisi, $eniyisi);
$query_id = sprintf("SELECT * FROM kullanici WHERE kimlik = '%s'", $colname_id);
$id = mysql_query($query_id, $eniyisi) or die(mysql_error());
$row_id = mysql_fetch_assoc($id);
$totalRows_id = mysql_num_rows($id);

$colname_ogrenci = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_ogrenci = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_eniyisi, $eniyisi);
$query_ogrenci = sprintf("SELECT kimlik FROM kullanici WHERE kimlik = '%s' AND yetki = 3", $colname_ogrenci);
$ogrenci = mysql_query($query_ogrenci, $eniyisi) or die(mysql_error());
$row_ogrenci = mysql_fetch_assoc($ogrenci);
$totalRows_ogrenci = mysql_num_rows($ogrenci);

$colname_ogretim = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_ogretim = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_eniyisi, $eniyisi);
$query_ogretim = sprintf("SELECT kimlik FROM kullanici WHERE kimlik = '%s' AND yetki = 2", $colname_ogretim);
$ogretim = mysql_query($query_ogretim, $eniyisi) or die(mysql_error());
$row_ogretim = mysql_fetch_assoc($ogretim);
$totalRows_ogretim = mysql_num_rows($ogretim);

$colname_yonetim = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_yonetim = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_eniyisi, $eniyisi);
$query_yonetim = sprintf("SELECT kimlik FROM kullanici WHERE kimlik = '%s' AND yetki = 1", $colname_yonetim);
$yonetim = mysql_query($query_yonetim, $eniyisi) or die(mysql_error());
$row_yonetim = mysql_fetch_assoc($yonetim);
$totalRows_yonetim = mysql_num_rows($yonetim);
?>
<html><!-- InstanceBegin template="file:///C|/Program Files/xampp/htdocs/eniyisi/Templates/sistem.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

<!-- InstanceBeginEditable name="doctitle" -->
<title>:: ENÝYÝSÝ e-öðrenmede içerik yönetim sistemi ::</title>
<!-- InstanceEndEditable -->
<meta http-equiv="content-language" content="TR">
<meta http-equiv="content-type" content="text/html; charset=windows-1254"> 
<meta http-equiv="content-type" content="text/html; charset=iso-8859-9">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Mon Mar 06 22:24:07 GMT+0200 (GTB Standard Time) 2006-->
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
<link href="file:///C|/Program%20Files/xampp/htdocs/eniyisi/eniyisi.css" rel="stylesheet" type="text/css">
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
<body bgcolor="#ffffff" onLoad="MM_preloadImages('file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r1_c11_f2.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c6_f2.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f3.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c8_f2.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f4.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c10_f2.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f5.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c13_f2.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f6.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c15_f2.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f7.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c17_f2.jpg','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f8.jpg')">
<!--The following section is an HTML table which reassembles the sliced image in a browser.-->
<!--Copy the table section including the opening and closing table tags, and paste the data where-->
<!--you want the reassembled image to appear in the destination document. -->
<!--======================== BEGIN COPYING THE HTML HERE ==========================-->
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="eniyisi.png" fwbase="eniyisi.jpg" fwstyle="Dreamweaver" fwdocid = "43888482" fwnested="0" -->
  <tr>
<!-- Shim row, height 1. -->
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="306" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="18" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="199" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="31" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="3" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="27" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="6" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="27" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="7" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="9" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="18" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="6" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="27" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="7" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="27" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="7" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="27" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="8" height="1" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr><!-- row 1 -->
   <td rowspan="8"><img name="eniyisi_r1_c1" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r1_c1.jpg" width="306" height="100" border="0" alt=""></td>
   <td rowspan="6"><img name="eniyisi_r1_c2" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r1_c2.jpg" width="18" height="66" border="0" alt=""></td>
   <td rowspan="2"><img name="eniyisi_r1_c3" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r1_c3.jpg" width="199" height="25" border="0" alt=""></td>
   <td rowspan="6"><img name="eniyisi_r1_c4" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r1_c4.jpg" width="31" height="66" border="0" alt=""></td>
   <td colspan="6"><img name="eniyisi_r1_c5" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r1_c5.jpg" width="79" height="20" border="0" alt=""></td>
   <td colspan="8"><a href="file:///C|/Program%20Files/xampp/htdocs/eniyisi/cikis.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('eniyisi_r1_c11','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r1_c11_f2.jpg',1)"><img name="eniyisi_r1_c11" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r1_c11.jpg" width="127" height="20" border="0" alt=""></a></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="20" border="0" alt=""></td>
  </tr>
  <tr><!-- row 2 -->
   <td rowspan="2" colspan="14"><img name="eniyisi_r2_c5" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r2_c5.jpg" width="206" height="16" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="5" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td rowspan="3" bgcolor="#999999"><div align="center" class="kimlik"><?php echo $row_id['ad']; ?> <?php echo $row_id['soyad']; ?></div></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="11" border="0" alt=""></td>
  </tr>
  <tr><!-- row 4 -->
   <td colspan="14"><img name="eniyisi_r4_c5" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r4_c5.jpg" width="206" height="17" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="17" border="0" alt=""></td>
  </tr>
  <tr><!-- row 5 -->
   <td rowspan="3"><img name="eniyisi_r5_c5" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c5.jpg" width="3" height="27" border="0" alt=""></td>
   <td rowspan="3"><a href="file:///C|/Program%20Files/xampp/htdocs/eniyisi/anasayfa.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('eniyisi_r5_c6','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c6_f2.jpg','eniyisi_r7_c2','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f3.jpg',1)"><img name="eniyisi_r5_c6" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c6.jpg" width="27" height="27" border="0" alt=""></a></td>
   <td rowspan="3"><img name="eniyisi_r5_c7" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c7.jpg" width="6" height="27" border="0" alt=""></td>
   <td rowspan="3"><a href="file:///C|/Program%20Files/xampp/htdocs/eniyisi/benimalanim/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('eniyisi_r5_c8','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c8_f2.jpg','eniyisi_r7_c2','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f4.jpg',1)"><img name="eniyisi_r5_c8" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c8.jpg" width="27" height="27" border="0" alt=""></a></td>
   <td rowspan="3"><img name="eniyisi_r5_c9" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c9.jpg" width="7" height="27" border="0" alt=""></td>
   <td rowspan="3" colspan="2"><a href="file:///C|/Program%20Files/xampp/htdocs/eniyisi/topluluklar/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('eniyisi_r5_c10','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c10_f2.jpg','eniyisi_r7_c2','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f5.jpg',1)"><img name="eniyisi_r5_c10" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c10.jpg" width="27" height="27" border="0" alt=""></a></td>
   <td rowspan="3"><img name="eniyisi_r5_c12" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c12.jpg" width="6" height="27" border="0" alt=""></td>
   <td rowspan="3"><a href="file:///C|/Program%20Files/xampp/htdocs/eniyisi/iletisim/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('eniyisi_r5_c13','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c13_f2.jpg','eniyisi_r7_c2','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f6.jpg',1)"><img name="eniyisi_r5_c13" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c13.jpg" width="27" height="27" border="0" alt=""></a></td>
   <td rowspan="3"><img name="eniyisi_r5_c14" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c14.jpg" width="7" height="27" border="0" alt=""></td>
   <td rowspan="3"><a href="file:///C|/Program%20Files/xampp/htdocs/eniyisi/arama/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('eniyisi_r5_c15','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c15_f2.jpg','eniyisi_r7_c2','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f7.jpg',1)"><img name="eniyisi_r5_c15" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c15.jpg" width="27" height="27" border="0" alt=""></a></td>
   <td rowspan="3"><img name="eniyisi_r5_c16" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c16.jpg" width="7" height="27" border="0" alt=""></td>
   <td rowspan="3"><a href="file:///C|/Program%20Files/xampp/htdocs/eniyisi/yonetim/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('eniyisi_r5_c17','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c17_f2.jpg','eniyisi_r7_c2','','file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2_f8.jpg',1)"><img name="eniyisi_r5_c17" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c17.jpg" width="27" height="27" border="0" alt=""></a></td>
   <td rowspan="3"><img name="eniyisi_r5_c18" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r5_c18.jpg" width="8" height="27" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="3" border="0" alt=""></td>
  </tr>
  <tr><!-- row 6 -->
   <td><img name="eniyisi_r6_c3" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r6_c3.jpg" width="199" height="10" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="10" border="0" alt=""></td>
  </tr>
  <tr><!-- row 7 -->
   <td rowspan="2" colspan="3"><img name="eniyisi_r7_c2" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r7_c2.jpg" width="248" height="34" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="14" border="0" alt=""></td>
  </tr>
  <tr><!-- row 8 -->
   <td colspan="14"><img name="eniyisi_r8_c5" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r8_c5.jpg" width="206" height="20" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="20" border="0" alt=""></td>
  </tr>
  <tr><!-- row 9 -->
   <td colspan="18" valign="top"><!-- InstanceBeginEditable name="icerik" -->
     <table width="100%"  border="0" cellspacing="5" cellpadding="5">
       <tr>
         <td>&nbsp;</td>
       </tr>
     </table>
   <!-- InstanceEndEditable --></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="355" border="0" alt=""></td>
  </tr>
  <tr><!-- row 10 -->
   <td colspan="18"><img name="eniyisi_r10_c1" src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/eniyisi_r10_c1.jpg" width="760" height="25" border="0" alt=""></td>
   <td><img src="file:///C|/Program%20Files/xampp/htdocs/eniyisi/fw_imaj/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
<!--   This table was automatically created with Macromedia Fireworks   -->
<!--   http://www.macromedia.com   -->
</table>
<!--========================= STOP COPYING THE HTML HERE =========================-->
<p align="center" class="copyright">&copy; 2006 ENÝYÝSÝ Proje Grubu</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($id);

mysql_free_result($ogrenci);

mysql_free_result($ogretim);

mysql_free_result($yonetim);
?>
