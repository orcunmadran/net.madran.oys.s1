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
$currentPage = $_SERVER["PHP_SELF"];

$colname_gk = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_gk = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_gk = sprintf("SELECT * FROM kullanici WHERE kadi = '%s'", $colname_gk);
$gk = mysql_query($query_gk, $iysconn) or die(mysql_error());
$row_gk = mysql_fetch_assoc($gk);
$totalRows_gk = mysql_num_rows($gk);

$maxRows_yorumoku = 10;
$pageNum_yorumoku = 0;
if (isset($_GET['pageNum_yorumoku'])) {
  $pageNum_yorumoku = $_GET['pageNum_yorumoku'];
}
$startRow_yorumoku = $pageNum_yorumoku * $maxRows_yorumoku;

$degerbir_yorumoku = "-1";
if (isset($_GET['baslikno'])) {
  $degerbir_yorumoku = (get_magic_quotes_gpc()) ? $_GET['baslikno'] : addslashes($_GET['baslikno']);
}
$degeriki_yorumoku = "-1";
if (isset($_GET['girisno'])) {
  $degeriki_yorumoku = (get_magic_quotes_gpc()) ? $_GET['girisno'] : addslashes($_GET['girisno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_yorumoku = sprintf("SELECT F.adi, B.baslik, B.baslikno, Y.*, DATE_FORMAT(Y.tarih, '%%d.%%m.%%y - %%H:%%i') AS trh FROM tg_forumlar F, tg_basliklar B, tg_yorumlar Y WHERE B.baslikno = Y.baslikno AND B.baslikno = %s AND F.girisno = %s ORDER BY Y.yorumno DESC", $degerbir_yorumoku,$degeriki_yorumoku);
$query_limit_yorumoku = sprintf("%s LIMIT %d, %d", $query_yorumoku, $startRow_yorumoku, $maxRows_yorumoku);
$yorumoku = mysql_query($query_limit_yorumoku, $iysconn) or die(mysql_error());
$row_yorumoku = mysql_fetch_assoc($yorumoku);

if (isset($_GET['totalRows_yorumoku'])) {
  $totalRows_yorumoku = $_GET['totalRows_yorumoku'];
} else {
  $all_yorumoku = mysql_query($query_yorumoku);
  $totalRows_yorumoku = mysql_num_rows($all_yorumoku);
}
$totalPages_yorumoku = ceil($totalRows_yorumoku/$maxRows_yorumoku)-1;

$queryString_yorumoku = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_yorumoku") == false && 
        stristr($param, "totalRows_yorumoku") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_yorumoku = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_yorumoku = sprintf("&totalRows_yorumoku=%d%s", $totalRows_yorumoku, $queryString_yorumoku);

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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>
<body bgcolor="#666666" onLoad="MM_preloadImages('../fw_iys/sb_r2_c1_f2.gif','../fw_iys/sb_r2_c4_f2.gif','../fw_iys/sb_r2_c6_f2.gif','../fw_iys/sb_r2_c8_f2.gif','../fw_iys/sb_r2_c10_f2.gif','../fw_iys/sb_r2_c12_f2.gif','../fw_iys/sb_r2_c14_f2.gif','../fw_iys/sb_r2_c16_f2.gif','../fw_iys/sb_r2_c19_f2.gif','../Library/listehareket/listehareket_r1_c1_f2.gif','../Library/listehareket/listehareket_r1_c2_f2.gif','../Library/listehareket/listehareket_r1_c4_f2.gif','../Library/listehareket/listehareket_r1_c5_f2.gif')">
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
   <td><a href="../dersler/dersler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c4','','../fw_iys/sb_r2_c4_f2.gif',1)"><img name="sb_r2_c4" src="../fw_iys/sb_r2_c4.gif" width="59" height="25" border="0" alt="Yüklendiðin dersleri görüntüle"></a></td>
   <td><img name="sb_r2_c5" src="../fw_iys/sb_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../mesajlar/mesajlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c6','','../fw_iys/sb_r2_c6_f2.gif',1)"><img name="sb_r2_c6" src="../fw_iys/sb_r2_c6.gif" width="51" height="25" border="0" alt="Mesaj alýp gönder"></a></td>
   <td><img name="sb_r2_c7" src="../fw_iys/sb_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../sohbet.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c8','','../fw_iys/sb_r2_c8_f2.gif',1)"><img src="../fw_iys/sb_r2_c8.gif" alt="Sohbet odalarýna giriþ yap" name="sb_r2_c8" width="58" height="25" border="0"></a></td>
   <td><img name="sb_r2_c9" src="../fw_iys/sb_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="forumlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c10','','../fw_iys/sb_r2_c10_f2.gif',1)"><img name="sb_r2_c10" src="../fw_iys/sb_r2_c10.gif" width="71" height="25" border="0" alt="Tartýþma gruplarýna katýl"></a></td>
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
         <td width="70%" class="icyazi"><p class="baslik">Yorumlar (<span class="baslikuyari"><?php echo $totalRows_yorumoku ?></span>)</p></td>
         <td colspan="2" class="icyazi">&nbsp;</td>
       </tr>
       <tr>
         <td class="arabaslik"><a href="forumlar.php">Forumlar</a> &gt; <a href="basliklar.php?<?php echo $MM_keepURL; ?>"><?php echo $row_yorumoku['adi']; ?></a>  &gt; <?php echo $row_yorumoku['baslik']; ?></td>
         <td width="26%" class="icyazi"><div align="right" class="arabaslik">YORUM EKLE </div></td>
         <td width="4%" class="icyazi"><a href="yorumekle.php?<?php echo $MM_keepURL; ?>"><img src="../resimler/ekle.gif" alt="Yorum ekle" width="26" height="26" border="0"></a></td>
       </tr>
       <tr>
         <td colspan="3" class="icyazi"><table width="100%"  border="0" cellpadding="8" cellspacing="2" bgcolor="#8093B3">
           <tr bgcolor="#CCCCCC" class="icyazi">
             <td width="20%"><strong>Yazar</strong></td>
             <td width="50%"><strong>Yorum</strong></td>
             <td width="18%"><div align="center"><strong>Yorum Tarihi</strong></div></td>
             <td width="6%"><div align="center"><strong>G</strong></div></td>
             <td width="6%"><div align="center"><strong>U</strong></div></td>
           </tr>
           <tr bgcolor="#FFFFFF" class="icyazi">
             <td colspan="5"><?php if ($totalRows_yorumoku == 0) { // Show if recordset empty ?>
               Bu baþlýk altýnda henüz bir yorum bulunmamaktadýr.
               <?php } // Show if recordset empty ?></td>
             </tr>
           <?php do { ?>
           <tr valign="top" bgcolor="#FFFFFF" class="icyazi">
               <td><?php echo $row_yorumoku['yazar']; ?></td>
               <td><p><?php echo str_replace("\n","<br>", $row_yorumoku['yorum']); ?></p>
                 <p class="forumaciklama"><?php echo $row_yorumoku['gtarih']; ?></p></td>
               <td><div align="center"><?php echo $row_yorumoku['trh']; ?></div></td>
               <td><div align="center">
                 <?php if ($totalRows_yorumoku > 0) { // Show if recordset not empty ?>
                 <a href="yorumguncelle.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."yorumno=".urlencode($row_yorumoku['yorumno']) ?>"><img src="<?php echo $row_yorumoku['guncellendi']; ?>" alt="Yorumu Güncelle" name="guncellendi" border="0" id="guncellendi"></a>
                 <?php } // Show if recordset not empty ?>
               </div></td>
               <td><div align="center">
                 <?php if ($totalRows_yorumoku > 0) { // Show if recordset not empty ?>
                 <img src="<?php echo $row_yorumoku['uyarialdi']; ?>" alt="Uyarý bilgisi" name="uyarialdi" id="uyarialdi">
                 <?php } // Show if recordset not empty ?>
               </div></td>
           </tr>
           <?php } while ($row_yorumoku = mysql_fetch_assoc($yorumoku)); ?>
         </table></td>
        </tr>
       <tr>
         <td colspan="3" class="icyazi"><div align="center">
           <!--Fireworks MX Dreamweaver LBI target.  Created -->
           <table border="0" cellpadding="0" cellspacing="0" width="128">
             <!-- fwtable fwsrc="listehareket.png" fwbase="listehareket.gif" -->
             <tr>
               <!-- Shim row, height 1. -->
               <td><img src="../Library/listehareket/spacer.gif" width="30" height="1" border="0"></td>
               <td><img src="../Library/listehareket/spacer.gif" width="25" height="1" border="0"></td>
               <td><img src="../Library/listehareket/spacer.gif" width="16" height="1" border="0"></td>
               <td><img src="../Library/listehareket/spacer.gif" width="25" height="1" border="0"></td>
               <td><img src="../Library/listehareket/spacer.gif" width="32" height="1" border="0"></td>
               <td><img src="../Library/listehareket/spacer.gif" width="1" height="1" border="0"></td>
             </tr>
             <tr>
               <!-- row 1 -->
               <td><a href="<?php printf("%s?pageNum_yorumoku=%d%s", $currentPage, 0, $queryString_yorumoku); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c1','','../Library/listehareket/listehareket_r1_c1_f2.gif',1)" >
                 <?php if ($pageNum_yorumoku > 0) { // Show if not first page ?>
                 <img src="../Library/listehareket/listehareket_r1_c1.gif" alt="Ýlk" name="listehareket_r1_c1" width="30" height="22" border="0">
                 <?php } // Show if not first page ?>
               </a></td>
               <td><a href="<?php printf("%s?pageNum_yorumoku=%d%s", $currentPage, max(0, $pageNum_yorumoku - 1), $queryString_yorumoku); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c2','','../Library/listehareket/listehareket_r1_c2_f2.gif',1)" >
                 <?php if ($pageNum_yorumoku > 0) { // Show if not first page ?>
                 <img src="../Library/listehareket/listehareket_r1_c2.gif" alt="Önceki" name="listehareket_r1_c2" width="25" height="22" border="0">
                 <?php } // Show if not first page ?>
               </a></td>
               <td><img name="listehareket_r1_c3" src="../Library/listehareket/listehareket_r1_c3.gif" width="16" height="22" border="0"></td>
               <td><a href="<?php printf("%s?pageNum_yorumoku=%d%s", $currentPage, min($totalPages_yorumoku, $pageNum_yorumoku + 1), $queryString_yorumoku); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c4','','../Library/listehareket/listehareket_r1_c4_f2.gif',1)" >
                 <?php if ($pageNum_yorumoku < $totalPages_yorumoku) { // Show if not last page ?>
                 <img src="../Library/listehareket/listehareket_r1_c4.gif" alt="Sonraki" name="listehareket_r1_c4" width="25" height="22" border="0">
                 <?php } // Show if not last page ?>
               </a></td>
               <td><a href="<?php printf("%s?pageNum_yorumoku=%d%s", $currentPage, $totalPages_yorumoku, $queryString_yorumoku); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c5','','../Library/listehareket/listehareket_r1_c5_f2.gif',1)" >
                 <?php if ($pageNum_yorumoku < $totalPages_yorumoku) { // Show if not last page ?>
                 <img src="../Library/listehareket/listehareket_r1_c5.gif" alt="Son" name="listehareket_r1_c5" width="32" height="22" border="0">
                 <?php } // Show if not last page ?>
               </a></td>
               <td><img src="../Library/listehareket/spacer.gif" width="1" height="22" border="0"></td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td colspan="3" class="icyazi"><table  border="0" align="center" cellpadding="0" cellspacing="5">
           <tr class="icyazi">
             <td><strong>Forum iþaretleri: </strong></td>
             <td><img src="../resimler/tg_yg_hayir.gif" width="15" height="15"></td>
             <td>Güncelle</td>
             <td><img src="../resimler/tg_yg_evet.gif" width="15" height="15"></td>
             <td>Yorum güncellendi </td>
             <td><img src="../resimler/tg_yu_hayir.gif" width="15" height="15"></td>
             <td>Uyarý yok </td>
             <td><img src="../resimler/tg_yu_evet.gif" width="15" height="15"></td>
             <td>Uyarý var </td>
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
mysql_free_result($yorumoku);

mysql_free_result($gk);
?>