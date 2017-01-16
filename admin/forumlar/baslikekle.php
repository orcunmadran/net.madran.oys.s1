<?php require_once('../../Connections/iysconn.php'); ?>
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
$MM_authorizedUsers = "yonetici,ogretime";
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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "ekle")) {
  $insertSQL = sprintf("INSERT INTO tg_basliklar (girisno, baslik, yazar, aktif) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['girisno'], "int"),
                       GetSQLValueString($_POST['baslik'], "text"),
                       GetSQLValueString($_POST['yazar'], "text"),
                       GetSQLValueString($_POST['aktif'], "text"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($insertSQL, $iysconn) or die(mysql_error());

  $insertGoTo = "baslikekle.php?bilgi= > Forum baþlýðý baþarýyla eklendi";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_gka = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_gka = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_gka = sprintf("SELECT * FROM kullanici WHERE kadi = '%s'", $colname_gka);
$gka = mysql_query($query_gka, $iysconn) or die(mysql_error());
$row_gka = mysql_fetch_assoc($gka);
$totalRows_gka = mysql_num_rows($gka);

mysql_select_db($database_iysconn, $iysconn);
$query_forumadi = "SELECT girisno, adi FROM tg_forumlar WHERE aktif = 'Evet' ORDER BY girisno DESC";
$forumadi = mysql_query($query_forumadi, $iysconn) or die(mysql_error());
$row_forumadi = mysql_fetch_assoc($forumadi);
$totalRows_forumadi = mysql_num_rows($forumadi);

$maxRows_basliklar = 5;
$pageNum_basliklar = 0;
if (isset($_GET['pageNum_basliklar'])) {
  $pageNum_basliklar = $_GET['pageNum_basliklar'];
}
$startRow_basliklar = $pageNum_basliklar * $maxRows_basliklar;

mysql_select_db($database_iysconn, $iysconn);
$query_basliklar = "SELECT F.adi, B.*, DATE_FORMAT(B.tarih, '%d.%m.%y') AS trh FROM tg_forumlar F, tg_basliklar B WHERE F.girisno = B.girisno ORDER BY B.girisno DESC";
$query_limit_basliklar = sprintf("%s LIMIT %d, %d", $query_basliklar, $startRow_basliklar, $maxRows_basliklar);
$basliklar = mysql_query($query_limit_basliklar, $iysconn) or die(mysql_error());
$row_basliklar = mysql_fetch_assoc($basliklar);

if (isset($_GET['totalRows_basliklar'])) {
  $totalRows_basliklar = $_GET['totalRows_basliklar'];
} else {
  $all_basliklar = mysql_query($query_basliklar);
  $totalRows_basliklar = mysql_num_rows($all_basliklar);
}
$totalPages_basliklar = ceil($totalRows_basliklar/$maxRows_basliklar)-1;

$queryString_basliklar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_basliklar") == false && 
        stristr($param, "totalRows_basliklar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_basliklar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_basliklar = sprintf("&totalRows_basliklar=%d%s", $totalRows_basliklar, $queryString_basliklar);
?>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Yönetim Paneli - Baþkent Üniversitesi Eðitim Fakültesi</title>
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
   <td colspan="2"><a href="../kullanicilar/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c1','','../fw_admin/admin_r2_c1_f2.gif',1)"><img name="admin_r2_c1" src="../fw_admin/admin_r2_c1.gif" width="94" height="25" border="0" alt="Kullanýcý iþlemlerini yürüt"></a></td>
   <td><img name="admin_r2_c3" src="../fw_admin/admin_r2_c3.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../dersler/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c4','','../fw_admin/admin_r2_c4_f2.gif',1)"><img name="admin_r2_c4" src="../fw_admin/admin_r2_c4.gif" width="63" height="25" border="0" alt="Dersleri yönet"></a></td>
   <td><img name="admin_r2_c5" src="../fw_admin/admin_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../mesajlar/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c6','','../fw_admin/admin_r2_c6_f2.gif',1)"><img name="admin_r2_c6" src="../fw_admin/admin_r2_c6.gif" width="73" height="25" border="0" alt="Mesajlarý denetle"></a></td>
   <td><img name="admin_r2_c7" src="../fw_admin/admin_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../../sohbet/admin/index.php" target="_blank" onMouseOver="MM_swapImage('admin_r2_c8','','../fw_admin/admin_r2_c8_f2.gif',1)" onMouseOut="MM_swapImgRestore();"><img name="admin_r2_c8" src="../fw_admin/admin_r2_c8.gif" width="118" height="25" border="0" alt="Sohbet odalarýný yönet"></a></td>
   <td><img name="admin_r2_c9" src="../fw_admin/admin_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c10','','../fw_admin/admin_r2_c10_f2.gif',1)"><img name="admin_r2_c10" src="../fw_admin/admin_r2_c10.gif" width="139" height="25" border="0" alt="Tartýþma gruplarýný yönet"></a></td>
   <td><img name="admin_r2_c11" src="../fw_admin/admin_r2_c11.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../duyurular/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c12','','../fw_admin/admin_r2_c12_f2.gif',1)"><img name="admin_r2_c12" src="../fw_admin/admin_r2_c12.gif" width="86" height="25" border="0" alt="Duyuru yayýnla"></a></td>
   <td><a href="../../anasayfa.php"><img name="admin_r2_c13" src="../../resimler/gecis.gif" width="15" height="25" border="0" alt="Sanal Kampüse geçiþ yap"></a></td>
   <td bgcolor="#000000"><div align="center" class="kimlik"><?php echo $row_gka['kadi']; ?></div></td>
   <td colspan="2"><a href="<?php echo $logoutAction ?>" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c15','','../fw_admin/admin_r2_c15_f2.gif',1)"><img name="admin_r2_c15" src="../fw_admin/admin_r2_c15.gif" width="132" height="25" border="0" alt="Yönetim panelinden güvenli çýkýþ yap"></a></td>
   <td><img src="../fw_admin/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td background="../fw_admin/admin_r3_c1.gif"><img name="admin_r3_c1" src="../fw_admin/admin_r3_c1.gif" width="5" height="489" border="0" alt=""></td>
   <td colspan="14" valign="top" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="icerik" -->
     <table width="100%"  border="0" cellspacing="5" cellpadding="5">
       <tr>
         <td width="19%" class="baslik"><div align="right">Foruma Baþlýk Ekle</div></td>
         <td width="51%"><span class="arabaslikuyari"><?php echo $_GET['bilgi']; ?></span></td>
         <td width="30%">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2"><form action="<?php echo $editFormAction; ?>" method="POST" name="ekle" id="ekle">
           <table width="100%"  border="0" cellspacing="5" cellpadding="5">
             <tr class="icyazi">
               <td width="24%"><div align="right"><strong>Forum Adý </strong></div></td>
               <td width="4%"><div align="center"><strong>:</strong></div></td>
               <td width="72%"><select name="girisno" class="icyazi" id="girisno">
                 <?php
do {  
?>
                 <option value="<?php echo $row_forumadi['girisno']?>"><?php echo $row_forumadi['adi']?></option>
                 <?php
} while ($row_forumadi = mysql_fetch_assoc($forumadi));
  $rows = mysql_num_rows($forumadi);
  if($rows > 0) {
      mysql_data_seek($forumadi, 0);
	  $row_forumadi = mysql_fetch_assoc($forumadi);
  }
?>
               </select></td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Baþlýk</strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><input name="baslik" type="text" class="icyazi" id="baslik" size="50" maxlength="100">
                 <span class="baslik">*</span></td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Aktif</strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><select name="aktif" class="icyazi" id="aktif">
                 <option value="Evet" selected>Evet</option>
                 <option value="Hayýr">Hayýr</option>
               </select></td>
             </tr>
             <tr>
               <td><div align="right">
                 <input name="yazar" type="hidden" id="yazar" value="<?php echo $row_gka['kadi']; ?>">
               </div></td>
               <td>&nbsp;</td>
               <td><input name="Submit" type="submit" class="butongiris" value="Baþlýk Ekle"></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td class="baslik">*</td>
               <td class="altbaslik">Alanýn doldurulmasý zorunludur </td>
             </tr>
           </table>
           <input type="hidden" name="MM_insert" value="ekle">
         </form>
         </td>
         <td valign="top"><p class="altbaslik">Yeni bir baþlýk yaratacaksanýz:</p>
           <p class="icyazi">Aþaðýda yer alan baþlýk listesinden yaratmak istediðiniz baþlýðýn daha önceden oluþturulup oluþturulmadýðýna bakabilirsiniz. </p>
           <p class="altbaslik">Yeni bir baþlýk yarattýysanýz:</p>
          <p class="icyazi">Bu baþlýk altýna yorum ekleyebilmek için &quot;<a href="../../forumlar/forumlar.php">Sanal Kampüs</a>&quot;'e geçiþ yapmanýz gerekmektedir. </p></td>
       </tr>
       <tr>
         <td colspan="2" class="arabaslik">Þu an forumlarda<span class="arabaslikuyari"> <?php echo $totalRows_basliklar ?></span> adet baþlýk var.</td>
         <td valign="top"><div align="center">
           <!--Fireworks MX Dreamweaver LBI target.  Created -->
           <table border="0" cellpadding="0" cellspacing="0" width="128">
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
               <td><a href="<?php printf("%s?pageNum_basliklar=%d%s", $currentPage, 0, $queryString_basliklar); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c1','','../../Library/listehareket/listehareket_r1_c1_f2.gif',1)" >
                 <?php if ($pageNum_basliklar > 0) { // Show if not first page ?>
                 <img src="../../Library/listehareket/listehareket_r1_c1.gif" alt="Ýlk" name="listehareket_r1_c1" width="30" height="22" border="0">
                 <?php } // Show if not first page ?>
               </a></td>
               <td><a href="<?php printf("%s?pageNum_basliklar=%d%s", $currentPage, max(0, $pageNum_basliklar - 1), $queryString_basliklar); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c2','','../../Library/listehareket/listehareket_r1_c2_f2.gif',1)" >
                 <?php if ($pageNum_basliklar > 0) { // Show if not first page ?>
                 <img src="../../Library/listehareket/listehareket_r1_c2.gif" alt="Önceki" name="listehareket_r1_c2" width="25" height="22" border="0">
                 <?php } // Show if not first page ?>
               </a></td>
               <td><img src="../../Library/listehareket/listehareket_r1_c3.gif" alt="Liste Kontrol Paneli" name="listehareket_r1_c3" width="16" height="22" border="0"></td>
               <td><a href="<?php printf("%s?pageNum_basliklar=%d%s", $currentPage, min($totalPages_basliklar, $pageNum_basliklar + 1), $queryString_basliklar); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c4','','../../Library/listehareket/listehareket_r1_c4_f2.gif',1)" >
                 <?php if ($pageNum_basliklar < $totalPages_basliklar) { // Show if not last page ?>
                 <img src="../../Library/listehareket/listehareket_r1_c4.gif" alt="Sonraki" name="listehareket_r1_c4" width="25" height="22" border="0">
                 <?php } // Show if not last page ?>
               </a></td>
               <td><a href="<?php printf("%s?pageNum_basliklar=%d%s", $currentPage, $totalPages_basliklar, $queryString_basliklar); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c5','','../../Library/listehareket/listehareket_r1_c5_f2.gif',1)" >
                 <?php if ($pageNum_basliklar < $totalPages_basliklar) { // Show if not last page ?>
                 <img src="../../Library/listehareket/listehareket_r1_c5.gif" alt="Son" name="listehareket_r1_c5" width="32" height="22" border="0">
                 <?php } // Show if not last page ?>
               </a></td>
               <td><img src="../../Library/listehareket/spacer.gif" width="1" height="22" border="0"></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td colspan="3"><table width="100%"  border="0" cellspacing="5" cellpadding="0">
           <tr class="icyazi">
             <td width="17%"><strong>Forum Adý </strong></td>
             <td width="36%"><strong>Baþlýk</strong></td>
             <td width="23%"><strong>Yazar</strong></td>
             <td width="13%"><strong>Tarih</strong></td>
             <td width="11%"><strong>Aktif</strong></td>
           </tr>
           <?php do { ?>
           <tr valign="top" class="icyazi">
               <td><?php echo $row_basliklar['adi']; ?></td>
               <td><?php echo $row_basliklar['baslik']; ?></td>
               <td><?php echo $row_basliklar['yazar']; ?></td>
               <td><?php echo $row_basliklar['trh']; ?></td>
               <td><?php echo $row_basliklar['aktif']; ?></td>
           </tr>
           <?php } while ($row_basliklar = mysql_fetch_assoc($basliklar)); ?>
         </table></td>
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
<p align="center"><span class="copyright">&copy; 2006 - Bilgisayar ve Öðretim Teknolojileri Eðitimi Bölümü</span></p>
<p align="center">
  <map name="admin_r1_c1Map">
    <area shape="rect" coords="3,2,126,27" href="../anasayfa.php" alt="Yönetim Paneli anasayfasýna git">
  </map>
</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($gka);

mysql_free_result($forumadi);

mysql_free_result($basliklar);
?>
