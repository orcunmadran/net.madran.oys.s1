<?php require_once('../../Connections/iysconn.php'); ?>
<?php require_once('../../Connections/iysconn.php'); ?>
<?php
//MX Table Sort Functions
require_once('../../includes/MXTableSort/MXTableSort_functions.inc.php'); 
?>
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
$currentPage = $_SERVER["PHP_SELF"];

$colname_gka = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_gka = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_gka = sprintf("SELECT * FROM kullanici WHERE kadi = '%s'", $colname_gka);
$gka = mysql_query($query_gka, $iysconn) or die(mysql_error());
$row_gka = mysql_fetch_assoc($gka);
$totalRows_gka = mysql_num_rows($gka);

$maxRows_tamliste = 10;
$pageNum_tamliste = 0;
if (isset($_GET['pageNum_tamliste'])) {
  $pageNum_tamliste = $_GET['pageNum_tamliste'];
}
$startRow_tamliste = $pageNum_tamliste * $maxRows_tamliste;

$orderParam_tamliste = "ad";
if (isset($_GET['order_tamliste'])) {
  $orderParam_tamliste = (get_magic_quotes_gpc()) ? $_GET['order_tamliste'] : addslashes($_GET['order_tamliste']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_tamliste = sprintf("SELECT * FROM kullanici ORDER BY %s", $orderParam_tamliste);
$query_limit_tamliste = sprintf("%s LIMIT %d, %d", $query_tamliste, $startRow_tamliste, $maxRows_tamliste);
$tamliste = mysql_query($query_limit_tamliste, $iysconn) or die(mysql_error());
$row_tamliste = mysql_fetch_assoc($tamliste);

if (isset($_GET['totalRows_tamliste'])) {
  $totalRows_tamliste = $_GET['totalRows_tamliste'];
} else {
  $all_tamliste = mysql_query($query_tamliste);
  $totalRows_tamliste = mysql_num_rows($all_tamliste);
}
$totalPages_tamliste = ceil($totalRows_tamliste/$maxRows_tamliste)-1;

$queryString_tamliste = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_tamliste") == false && 
        stristr($param, "totalRows_tamliste") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_tamliste = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_tamliste = sprintf("&totalRows_tamliste=%d%s", $totalRows_tamliste, $queryString_tamliste);

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
<body bgcolor="#666666" onLoad="MM_preloadImages('../fw_admin/admin_r2_c1_f2.gif','../fw_admin/admin_r2_c4_f2.gif','../fw_admin/admin_r2_c6_f2.gif','../fw_admin/admin_r2_c8_f2.gif','../fw_admin/admin_r2_c10_f2.gif','../fw_admin/admin_r2_c12_f2.gif','../fw_admin/admin_r2_c15_f2.gif','../../Library/listehareket/listehareket_r1_c1_f2.gif','../../Library/listehareket/listehareket_r1_c2_f2.gif','../../Library/listehareket/listehareket_r1_c4_f2.gif','../../Library/listehareket/listehareket_r1_c5_f2.gif')">
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
         <td colspan="7" class="arabaslik">Tam Liste</td>
        </tr>
       <tr>
         <td colspan="7" class="altbaslik">Toplam <strong><?php echo $totalRows_tamliste ?></strong> kullan�c�. (<strong><?php echo ($startRow_tamliste + 1) ?></strong> - <strong><?php echo min($startRow_tamliste + $maxRows_tamliste, $totalRows_tamliste) ?></strong> aras� g�steriliyor.)</td>
        </tr>
       <tr>
         <td width="13%" class="icyazi"><strong><a href="<?php echo getSortLink('tamliste','ad'); ?>">Ad� </a><?php echo getSortIcon('tamliste','ad'); ?></strong></td>
         <td width="12%" class="icyazi"><strong><a href="<?php echo getSortLink('tamliste','soyad'); ?>">Soyad� </a><?php echo getSortIcon('tamliste','soyad'); ?></strong></td>
         <td width="16%" class="icyazi"><strong><a href="<?php echo getSortLink('tamliste','kadi'); ?>">Kullan�c� Ad� </a><?php echo getSortIcon('tamliste','kadi'); ?></strong></td>
         <td width="12%" class="icyazi"><strong><a href="<?php echo getSortLink('tamliste','sifre'); ?>">�ifre</a> <?php echo getSortIcon('tamliste','sifre'); ?></strong></td>
         <td width="15%"><span class="icyazi"><strong><a href="<?php echo getSortLink('tamliste','kategori'); ?>">Kategori</a> <?php echo getSortIcon('tamliste','kategori'); ?></strong></span></td>
         <td width="26%"><span class="icyazi"><strong><a href="<?php echo getSortLink('tamliste','eposta'); ?>">E - Posta </a><?php echo getSortIcon('tamliste','eposta'); ?></strong></span></td>
         <td width="6%" class="icyazi"><strong>Postala</strong></td>
       </tr>
       <?php do { ?>
       <tr>
          <td class="icyazi"><?php echo $row_tamliste['ad']; ?></td>
          <td class="icyazi"><?php echo $row_tamliste['soyad']; ?></td>
          <td class="icyazi"><a href="listeayr.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."kadi=".urlencode($row_tamliste['kadi']) ?>"><?php echo $row_tamliste['kadi']; ?></a></td>
          <td class="icyazi"><?php echo $row_tamliste['sifre']; ?></td>
          <td><span class="icyazi"><?php echo $row_tamliste['kategori']; ?></span></td>
          <td><span class="icyazi"><a href="mailto:<?php echo $row_tamliste['eposta']; ?>"><?php echo $row_tamliste['eposta']; ?></a></span></td>
           <td><div align="center"><a href="bilgipostala.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."kadi=".urlencode($row_tamliste['kadi']) ?>"><img src="../../mesajlar/m_imaj/m0.gif" width="13" height="11" border="0"></a></div></td>
       </tr>
       <?php } while ($row_tamliste = mysql_fetch_assoc($tamliste)); ?>
       <tr>
         <td colspan="6" class="icyazi"><!--Fireworks MX Dreamweaver LBI target.  Created -->
           <table width="128" border="0" align="center" cellpadding="0" cellspacing="0">
             <!-- fwtable fwsrc="listehareket.png" fwbase="listehareket.gif" -->
             <tr>
               <!-- Shim row, height 1. -->
               <td><img src="../../Library/listehareket/spacer.gif" width="30" height="1" border="0"></td>
               <td><img src="../../Library/listehareket/spacer.gif" width="25" height="1" border="0"></td>
               <td><img src="../../Library/listehareket/spacer.gif" width="16" height="1" border="0"></td>
               <td><img src="../../Library/listehareket/spacer.gif" width="25" height="1" border="0"></td>
               <td><img src="../../Library/listehareket/spacer.gif" width="32" height="1" border="0"></td>
               <td><img src="../../Library/listehareket/spacer.gif" width="1" height="1" border="0"></td>
             </tr>
             <tr>
               <!-- row 1 -->
               <td><a href="<?php printf("%s?pageNum_tamliste=%d%s", $currentPage, 0, $queryString_tamliste); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c1','','../../Library/listehareket/listehareket_r1_c1_f2.gif',1)" >
                 <?php if ($pageNum_tamliste > 0) { // Show if not first page ?>
                 <img src="../../Library/listehareket/listehareket_r1_c1.gif" alt="�lk" name="listehareket_r1_c1" width="30" height="22" border="0">
                 <?php } // Show if not first page ?>
               </a></td>
               <td><a href="<?php printf("%s?pageNum_tamliste=%d%s", $currentPage, max(0, $pageNum_tamliste - 1), $queryString_tamliste); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c2','','../../Library/listehareket/listehareket_r1_c2_f2.gif',1)" >
                 <?php if ($pageNum_tamliste > 0) { // Show if not first page ?>
                 <img src="../../Library/listehareket/listehareket_r1_c2.gif" alt="�nceki" name="listehareket_r1_c2" width="25" height="22" border="0">
                 <?php } // Show if not first page ?>
               </a></td>
               <td><img name="listehareket_r1_c3" src="../../Library/listehareket/listehareket_r1_c3.gif" width="16" height="22" border="0"></td>
               <td><a href="<?php printf("%s?pageNum_tamliste=%d%s", $currentPage, min($totalPages_tamliste, $pageNum_tamliste + 1), $queryString_tamliste); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c4','','../../Library/listehareket/listehareket_r1_c4_f2.gif',1)" >
                 <?php if ($pageNum_tamliste < $totalPages_tamliste) { // Show if not last page ?>
                 <img src="../../Library/listehareket/listehareket_r1_c4.gif" alt="Sonraki" name="listehareket_r1_c4" width="25" height="22" border="0">
                 <?php } // Show if not last page ?>
               </a></td>
               <td><a href="<?php printf("%s?pageNum_tamliste=%d%s", $currentPage, $totalPages_tamliste, $queryString_tamliste); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c5','','../../Library/listehareket/listehareket_r1_c5_f2.gif',1)" >
                 <?php if ($pageNum_tamliste < $totalPages_tamliste) { // Show if not last page ?>
                 <img src="../../Library/listehareket/listehareket_r1_c5.gif" alt="Son" name="listehareket_r1_c5" width="32" height="22" border="0">
                 <?php } // Show if not last page ?>
               </a></td>
               <td><img src="../../Library/listehareket/spacer.gif" width="1" height="22" border="0"></td>
             </tr>
           </table></td>
         <td>&nbsp;</td>
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

mysql_free_result($tamliste);
?>
