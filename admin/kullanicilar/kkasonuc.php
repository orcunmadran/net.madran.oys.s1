<?php require_once('../../Connections/iysconn.php'); ?>
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
$MM_authorizedUsers = "yonetici";
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
$colname_gka = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_gka = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_gka = sprintf("SELECT * FROM kullanici WHERE kadi = '%s'", $colname_gka);
$gka = mysql_query($query_gka, $iysconn) or die(mysql_error());
$row_gka = mysql_fetch_assoc($gka);
$totalRows_gka = mysql_num_rows($gka);

$colname_sonuc = "-1";
if (isset($_GET['kadi'])) {
  $colname_sonuc = (get_magic_quotes_gpc()) ? $_GET['kadi'] : addslashes($_GET['kadi']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_sonuc = sprintf("SELECT *, DATE_FORMAT(giriszaman, '%%d.%%m.%%y - %%H:%%i') AS gzf FROM kullanici WHERE kadi LIKE '%%%s%%'", $colname_sonuc);
$sonuc = mysql_query($query_sonuc, $iysconn) or die(mysql_error());
$row_sonuc = mysql_fetch_assoc($sonuc);
$totalRows_sonuc = mysql_num_rows($sonuc);

$MM_paramName = ""; 

// *** Go To Record and Move To Record: create strings for maintaining URL and Form parameters
// create the list of parameters which should not be maintained
$MM_removeList = "&index=";
if ($MM_paramName != "") $MM_removeList .= "&".strtolower($MM_paramName)."=";
$MM_keepURL="";
$MM_keepForm="";
$MM_keepBoth="";
$MM_keepNone="";
// add the URL parameters to the MM_keepURL string
reset ($HTTP_GET_VARS);
while (list ($key, $val) = each ($HTTP_GET_VARS)) {
	$nextItem = "&".strtolower($key)."=";
	if (!stristr($MM_removeList, $nextItem)) {
		$MM_keepURL .= "&".$key."=".urlencode($val);
	}
}
// add the Form parameters to the MM_keepURL string
if(isset($HTTP_POST_VARS)){
	reset ($HTTP_POST_VARS);
	while (list ($key, $val) = each ($HTTP_POST_VARS)) {
		$nextItem = "&".strtolower($key)."=";
		if (!stristr($MM_removeList, $nextItem)) {
			$MM_keepForm .= "&".$key."=".urlencode($val);
		}
	}
}
// create the Form + URL string and remove the intial '&' from each of the strings
$MM_keepBoth = $MM_keepURL."&".$MM_keepForm;
if (strlen($MM_keepBoth) > 0) $MM_keepBoth = substr($MM_keepBoth, 1);
if (strlen($MM_keepURL) > 0)  $MM_keepURL = substr($MM_keepURL, 1);
if (strlen($MM_keepForm) > 0) $MM_keepForm = substr($MM_keepForm, 1);
?>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Y�netim Paneli - Ba�kent �niversitesi E�itim Fak�ltesi</title>
<!-- InstanceEndEditable --><meta http-equiv="content-language" content="TR">
<meta http-equiv="content-type" content="text/html; charset=windows-1254">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<meta name="description" content="FW MX 2004 DW MX 2004 HTML">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Fri Jan 27 00:06:11 GMT+0200 (GTB Standard Time) 2006-->
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
<link href="../../iys.css" rel="stylesheet" type="text/css">
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
<body bgcolor="#666666" onLoad="MM_preloadImages('../fw_admin/admin_r2_c1_f2.gif','../fw_admin/admin_r2_c4_f2.gif','../fw_admin/admin_r2_c6_f2.gif','../fw_admin/admin_r2_c8_f2.gif','../fw_admin/admin_r2_c10_f2.gif','../fw_admin/admin_r2_c12_f2.gif','../fw_admin/admin_r2_c15_f2.gif')">
<!--The following section is an HTML table which reassembles the sliced image in a browser.-->
<!--Copy the table section including the opening and closing table tags, and paste the data where-->
<!--you want the reassembled image to appear in the destination document. -->
<!--======================== BEGIN COPYING THE HTML HERE ==========================-->
<div align="right">
</div>
<div align="center"></div>
<table width="955" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="admin.png" fwbase="admin.gif" fwstyle="Dreamweaver" fwdocid = "1301164485" fwnested="0" -->
  <tr>
<!-- Shim row, height 1. -->
   <td><img src="../fw_admin/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="89" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="63" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="73" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="118" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="139" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="86" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="160" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="127" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr><!-- row 1 -->
   <td colspan="16"><img src="../fw_admin/admin_r1_c1.gif" alt="" name="admin_r1_c1" width="955" height="31" border="0" usemap="#admin_r1_c1Map"></td>
   <td><img src="../fw_admin/spacer.gif" width="1" height="31" border="0" alt=""></td>
  </tr>
  <tr><!-- row 2 -->
   <td colspan="2"><a href="index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c1','','../fw_admin/admin_r2_c1_f2.gif',1)"><img name="admin_r2_c1" src="../fw_admin/admin_r2_c1.gif" width="94" height="25" border="0" alt="Kullan�c� i�lemlerini y�r�t"></a></td>
   <td><img name="admin_r2_c3" src="../fw_admin/admin_r2_c3.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../dersler/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c4','','../fw_admin/admin_r2_c4_f2.gif',1)"><img name="admin_r2_c4" src="../fw_admin/admin_r2_c4.gif" width="63" height="25" border="0" alt="Dersleri y�net"></a></td>
   <td><img name="admin_r2_c5" src="../fw_admin/admin_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../mesajlar/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c6','','../fw_admin/admin_r2_c6_f2.gif',1)"><img name="admin_r2_c6" src="../fw_admin/admin_r2_c6.gif" width="73" height="25" border="0" alt="Mesajlar� denetle"></a></td>
   <td><img name="admin_r2_c7" src="../fw_admin/admin_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../../sohbet/admin/index.php" target="_blank" onMouseOver="MM_swapImage('admin_r2_c8','','../fw_admin/admin_r2_c8_f2.gif',1)" onMouseOut="MM_swapImgRestore();"><img name="admin_r2_c8" src="../fw_admin/admin_r2_c8.gif" width="118" height="25" border="0" alt="Sohbet odalar�n� y�net"></a></td>
   <td><img name="admin_r2_c9" src="../fw_admin/admin_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../forumlar/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c10','','../fw_admin/admin_r2_c10_f2.gif',1)"><img name="admin_r2_c10" src="../fw_admin/admin_r2_c10.gif" width="139" height="25" border="0" alt="Tart��ma gruplar�n� y�net"></a></td>
   <td><img name="admin_r2_c11" src="../fw_admin/admin_r2_c11.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../duyurular/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c12','','../fw_admin/admin_r2_c12_f2.gif',1)"><img name="admin_r2_c12" src="../fw_admin/admin_r2_c12.gif" width="86" height="25" border="0" alt="Duyuru yay�nla"></a></td>
   <td><a href="../../anasayfa.php"><img name="admin_r2_c13" src="../../resimler/gecis.gif" width="15" height="25" border="0" alt="Sanal Kamp�se ge�i� yap"></a></td>
   <td bgcolor="#000000"><div align="center" class="kimlik"><?php echo $row_gka['kadi']; ?></div></td>
   <td colspan="2"><a href="<?php echo $logoutAction ?>" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c15','','../fw_admin/admin_r2_c15_f2.gif',1)"><img name="admin_r2_c15" src="../fw_admin/admin_r2_c15.gif" width="132" height="25" border="0" alt="Y�netim panelinden g�venli ��k�� yap"></a></td>
   <td><img src="../fw_admin/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td background="../fw_admin/admin_r3_c1.gif"><img name="admin_r3_c1" src="../fw_admin/admin_r3_c1.gif" width="5" height="489" border="0" alt=""></td>
   <td colspan="14" valign="top" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="icerik" -->
    <table width="100%"  border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td colspan="3" class="arabaslik">Kullan�c� Detay Bilgileri </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="22%" valign="top" class="icyazi"><div align="right"><strong>Ad�</strong></div></td>
        <td width="2%" valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td width="46%" valign="top" class="icyazi"><?php echo $row_sonuc['ad']; ?></td>
        <td width="30%"><div align="center" class="arabaslik">
            <div align="left">Bu kayd�:</div>
        </div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>Soyad�</strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['soyad']; ?></td>
        <td class="icyazi"><div align="left"><a href="guncelleb.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."kadi=".urlencode($row_sonuc['kadi']) ?>">G�ncellemek istiyorum</a></div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>Kullan�c� Ad� </strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['kadi']; ?></td>
        <td class="icyazi"><div align="left"><a href="silb.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."kadi=".urlencode($row_sonuc['kadi']) ?>">Silmek istiyorum</a></div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>�ifre</strong></div></td>
        <td valign="top" class="icyazi">:</td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['sifre']; ?></td>
        <td class="icyazi"><div align="left">Ald��� dersleri g�r </div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>Kategori</strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['kategori']; ?></td>
        <td class="icyazi"><div align="left"><a href="../mesajlar/mesajlaratilan.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."kadi=".urlencode($row_sonuc['kadi']) ?>">Att��� mesajlar� g�r</a> </div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>E - Posta</strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><a href="mailto:<?php echo $row_sonuc['eposta']; ?>"><?php echo $row_sonuc['eposta']; ?></a></td>
        <td><a href="../mesajlar/mesajlaralinan.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."kadi=".urlencode($row_sonuc['kadi']) ?>" class="icyazi"> Ald��� mesajlar� g�r </a></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>Web Adres </strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><a href="<?php echo $row_sonuc['webadres']; ?>" target="_blank"><?php echo $row_sonuc['webadres']; ?></a></td>
        <td><div align="left" class="icyazi"><a href="../mesajlar/mesajlaraa.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."kadi=".urlencode($row_sonuc['kadi']) ?>">Att��� ve ald��� mesajlar� birlikte g�r</a> </div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>Ev Adres </strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['evadres']; ?></td>
        <td><div align="left"><span class="icyazi">Tart��ma gruplar�ndaki mesajlar�n� g�r </span></div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>Ev Tel </strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['evtel']; ?></td>
        <td><div align="left"></div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>�� Adres </strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['isadres']; ?></td>
        <td><div align="left"></div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>�s Tel </strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['istel']; ?></td>
        <td><div align="left"></div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>Mobil</strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['mobiltel']; ?></td>
        <td><div align="left"></div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>A��klama</strong></div></td>
        <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
        <td valign="top" class="icyazi"><?php echo $row_sonuc['aciklama']; ?></td>
        <td><div align="left">
          <hr>
        </div></td>
      </tr>
      <tr>
        <td valign="top" class="icyazi"><div align="right"><strong>Sisteme Kay�t Tarihi </strong></div></td>
        <td valign="top" class="icyazi"><strong>:</strong></td>
        <td valign="top" class="icyazi">
		<?php echo $row_sonuc['gzf'];?>
		</td>
        <td><a href="javascript:history.back()" class="icyazi">Kolay aramaya d�nmek istiyorum </a></td>
      </tr>
    </table>
   <!-- InstanceEndEditable --></td>
   <td background="../fw_admin/admin_r3_c16.gif"><img name="admin_r3_c16" src="../fw_admin/admin_r3_c16.gif" width="5" height="489" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="1" height="489" border="0" alt=""></td>
  </tr>
  <tr><!-- row 4 -->
   <td colspan="16"><img name="admin_r4_c1" src="../fw_admin/admin_r4_c1.gif" width="955" height="5" border="0" alt=""></td>
   <td><img src="../fw_admin/spacer.gif" width="1" height="5" border="0" alt=""></td>
  </tr>
<!--   This table was automatically created with Macromedia Fireworks   -->
<!--   http://www.macromedia.com   -->
</table>
<!--========================= STOP COPYING THE HTML HERE =========================-->
<p align="center"><span class="copyright">&copy; 2006 - Bilgisayar ve ��retim Teknolojileri E�itimi B�l�m�</span></p>
<p align="center">
  <map name="admin_r1_c1Map">
    <area shape="rect" coords="3,2,126,27" href="../anasayfa.php" alt="Y�netim Paneli anasayfas�na git">
  </map>
</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($gka);

mysql_free_result($sonuc);
?>
