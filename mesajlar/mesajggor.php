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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "islem")) {
  $updateSQL = sprintf("UPDATE mesajlar SET silindi=%s WHERE mesajno=%s",
                       GetSQLValueString($_POST['silindi'], "int"),
                       GetSQLValueString($_POST['mesajno'], "int"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($updateSQL, $iysconn) or die(mysql_error());

  $updateGoTo = "mesajlar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_gk = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_gk = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_gk = sprintf("SELECT * FROM kullanici WHERE kadi = '%s'", $colname_gk);
$gk = mysql_query($query_gk, $iysconn) or die(mysql_error());
$row_gk = mysql_fetch_assoc($gk);
$totalRows_gk = mysql_num_rows($gk);

$degerbir_mesaj = "-1";
if (isset($_SESSION['MM_Username'])) {
  $degerbir_mesaj = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
$degeriki_mesaj = "-1";
if (isset($_GET['mesajno'])) {
  $degeriki_mesaj = (get_magic_quotes_gpc()) ? $_GET['mesajno'] : addslashes($_GET['mesajno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_mesaj = sprintf("SELECT *, DATE_FORMAT(tarihsaat, '%%d.%%m.%%y - %%H:%%i') AS ts FROM mesajlar WHERE gonderen = '%s' AND mesajno = '%s'", $degerbir_mesaj,$degeriki_mesaj);
$mesaj = mysql_query($query_mesaj, $iysconn) or die(mysql_error());
$row_mesaj = mysql_fetch_assoc($mesaj);
$totalRows_mesaj = mysql_num_rows($mesaj);

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
   <td><a href="../dersler/dersler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c4','','../fw_iys/sb_r2_c4_f2.gif',1)"><img name="sb_r2_c4" src="../fw_iys/sb_r2_c4.gif" width="59" height="25" border="0" alt="Yüklendiðin dersleri görüntüle"></a></td>
   <td><img name="sb_r2_c5" src="../fw_iys/sb_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="mesajlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c6','','../fw_iys/sb_r2_c6_f2.gif',1)"><img name="sb_r2_c6" src="../fw_iys/sb_r2_c6.gif" width="51" height="25" border="0" alt="Mesaj alýp gönder"></a></td>
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
         <td width="70%" class="icyazi"><p class="baslik">Gönderilmiþ Mesaj </p></td>
         <td width="30%" class="icyazi">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top" class="icyazi"><form action="<?php echo $editFormAction; ?>" method="POST" name="islem" id="islem">
           <table width="100%"  border="0" cellspacing="5" cellpadding="0">
             <tr class="icyazi">
               <td width="51" class="icyazi"><div align="right"><strong>Kimden</strong></div></td>
               <td width="6" class="arabaslik"><div align="center">:</div></td>
               <td colspan="2" class="icyazi"><?php echo $row_mesaj['gonderen']; ?></td>
             </tr>
             <tr class="icyazi">
               <td class="icyazi"><div align="right"><strong>Kime</strong></div></td>
               <td class="arabaslik"><div align="center">:</div></td>
               <td colspan="2" class="icyazi"><?php echo $row_mesaj['alici']; ?></td>
             </tr>
             <tr class="icyazi">
               <td class="icyazi"><div align="right"><strong>Tarih</strong></div></td>
               <td class="arabaslik"><div align="center">:</div></td>
               <td colspan="2" class="icyazi"><?php echo $row_mesaj['ts']; ?></td>
             </tr>
             <tr class="icyazi">
               <td class="icyazi"><div align="right"><strong>Konu</strong></div></td>
               <td class="arabaslik"><div align="center">:</div></td>
               <td class="icyazi"><?php echo $row_mesaj['konu']; ?></td>
               <td width="16" class="icyazi"><a href="mesajilet.php?<?php echo $MM_keepURL; ?>"><img src="m_imaj/yonlendirme.gif" width="16" height="15" border="0"></a></td>
             </tr>
             <tr>
               <td colspan="4"><hr size="1"></td>
             </tr>
             <tr>
               <td class="icyazi"><div align="right">
                 <input name="mesajno" type="hidden" id="mesajno" value="<?php echo $row_mesaj['mesajno']; ?>">
                 <input name="silindi" type="hidden" id="silindi" value="1">
               </div></td>
               <td class="icyazi">&nbsp;</td>
               <td colspan="2" class="icyazi"><?php echo str_replace("\n","<br>", $row_mesaj['icerik']);?> </td>
             </tr>
           </table>
           <input type="hidden" name="MM_update" value="islem">
         </form>
         </td>
         <td valign="top" class="icyazi"><!-- #BeginLibraryItem "/Library/postamerkezi.lbi" --><!--Fireworks MX Dreamweaver LBI target.  Created -->

<table border="0" cellpadding="0" cellspacing="0" width="290">
<!-- fwtable fwsrc="postamerkezi.png" fwbase="postamerkezi.gif" -->
  <tr>
<!-- Shim row, height 1. -->
   <td><img src="../Library/postamerkezi/spacer.gif" width="209" height="1" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="81" height="1" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="1" border="0"></td>
  </tr>
  <tr><!-- row 1 -->
   <td colspan="2"><img name="postamerkezi_r1_c1" src="../Library/postamerkezi/postamerkezi_r1_c1.gif" width="290" height="58" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="58" border="0"></td>
  </tr>
  <tr><!-- row 2 -->
   <td><a href="mesajgonder.php"><img name="postamerkezi_r2_c1" src="../Library/postamerkezi/postamerkezi_r2_c1.gif" width="209" height="20" border="0"></a></td>
   <td rowspan="10"><img name="postamerkezi_r2_c2" src="../Library/postamerkezi/postamerkezi_r2_c2.gif" width="81" height="215" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="20" border="0"></td>
  </tr>
  <tr><!-- row 3 -->
   <td><img name="postamerkezi_r3_c1" src="../Library/postamerkezi/postamerkezi_r3_c1.gif" width="209" height="13" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="13" border="0"></td>
  </tr>
  <tr><!-- row 4 -->
   <td><a href="mesajlar.php"><img name="postamerkezi_r4_c1" src="../Library/postamerkezi/postamerkezi_r4_c1.gif" width="209" height="20" border="0"></a></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="20" border="0"></td>
  </tr>
  <tr><!-- row 5 -->
   <td><img name="postamerkezi_r5_c1" src="../Library/postamerkezi/postamerkezi_r5_c1.gif" width="209" height="14" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="14" border="0"></td>
  </tr>
  <tr><!-- row 6 -->
   <td><a href="mesajgonderilmis.php"><img name="postamerkezi_r6_c1" src="../Library/postamerkezi/postamerkezi_r6_c1.gif" width="209" height="20" border="0"></a></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="20" border="0"></td>
  </tr>
  <tr><!-- row 7 -->
   <td><img name="postamerkezi_r7_c1" src="../Library/postamerkezi/postamerkezi_r7_c1.gif" width="209" height="34" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="34" border="0"></td>
  </tr>
  <tr><!-- row 8 -->
   <td><a href="../duyurular/duyurular.php"><img name="postamerkezi_r8_c1" src="../Library/postamerkezi/postamerkezi_r8_c1.gif" width="209" height="20" border="0"></a></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="20" border="0"></td>
  </tr>
  <tr><!-- row 9 -->
   <td><img name="postamerkezi_r9_c1" src="../Library/postamerkezi/postamerkezi_r9_c1.gif" width="209" height="16" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="16" border="0"></td>
  </tr>
  <tr><!-- row 10 -->
   <td><a href="../duyurular/gecmisduyurular.php"><img name="postamerkezi_r10_c1" src="../Library/postamerkezi/postamerkezi_r10_c1.gif" width="209" height="20" border="0"></a></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="20" border="0"></td>
  </tr>
  <tr><!-- row 11 -->
   <td><img name="postamerkezi_r11_c1" src="../Library/postamerkezi/postamerkezi_r11_c1.gif" width="209" height="38" border="0"></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="38" border="0"></td>
  </tr>
  <tr><!-- row 12 -->
   <td colspan="2"><a href="mesajlar.php"><img name="postamerkezi_r12_c1" src="../Library/postamerkezi/postamerkezi_r12_c1.gif" width="290" height="50" border="0"></a></td>
   <td><img src="../Library/postamerkezi/spacer.gif" width="1" height="50" border="0"></td>
  </tr>
</table>
<!-- #EndLibraryItem --></td>
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

mysql_free_result($mesaj);
?>
