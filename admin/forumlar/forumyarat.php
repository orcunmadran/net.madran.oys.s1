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
// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="forumyarat.php?bilgi= > Bu isimde zaten bir forum var";
  $loginUsername = $_POST['adi'];
  $LoginRS__query = "SELECT adi FROM tg_forumlar WHERE adi='" . $loginUsername . "'";
  mysql_select_db($database_iysconn, $iysconn);
  $LoginRS=mysql_query($LoginRS__query, $iysconn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "yarat")) {
  $insertSQL = sprintf("INSERT INTO tg_forumlar (adi, aciklama, tip, yaratan, aktif) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['adi'], "text"),
                       GetSQLValueString($_POST['aciklama'], "text"),
                       GetSQLValueString($_POST['tip'], "text"),
                       GetSQLValueString($_POST['yaratan'], "text"),
                       GetSQLValueString($_POST['aktif'], "text"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($insertSQL, $iysconn) or die(mysql_error());

  $insertGoTo = "forumyarat.php?bilgi= > Forum Baþarýyla Yaratýldý";
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

$maxRows_mcvtforumlar = 5;
$pageNum_mcvtforumlar = 0;
if (isset($_GET['pageNum_mcvtforumlar'])) {
  $pageNum_mcvtforumlar = $_GET['pageNum_mcvtforumlar'];
}
$startRow_mcvtforumlar = $pageNum_mcvtforumlar * $maxRows_mcvtforumlar;

mysql_select_db($database_iysconn, $iysconn);
$query_mcvtforumlar = "SELECT *, DATE_FORMAT(tarih, '%d.%m.%y') AS trh FROM tg_forumlar ORDER BY girisno DESC";
$query_limit_mcvtforumlar = sprintf("%s LIMIT %d, %d", $query_mcvtforumlar, $startRow_mcvtforumlar, $maxRows_mcvtforumlar);
$mcvtforumlar = mysql_query($query_limit_mcvtforumlar, $iysconn) or die(mysql_error());
$row_mcvtforumlar = mysql_fetch_assoc($mcvtforumlar);

if (isset($_GET['totalRows_mcvtforumlar'])) {
  $totalRows_mcvtforumlar = $_GET['totalRows_mcvtforumlar'];
} else {
  $all_mcvtforumlar = mysql_query($query_mcvtforumlar);
  $totalRows_mcvtforumlar = mysql_num_rows($all_mcvtforumlar);
}
$totalPages_mcvtforumlar = ceil($totalRows_mcvtforumlar/$maxRows_mcvtforumlar)-1;

mysql_select_db($database_iysconn, $iysconn);
$query_dersler = "SELECT CONCAT(D.derskodu, ' - ', S.subekodu) AS fliste FROM dersler D, subeler S WHERE D.dersno = S.dersno ORDER BY fliste";
$dersler = mysql_query($query_dersler, $iysconn) or die(mysql_error());
$row_dersler = mysql_fetch_assoc($dersler);
$totalRows_dersler = mysql_num_rows($dersler);

$queryString_mcvtforumlar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_mcvtforumlar") == false && 
        stristr($param, "totalRows_mcvtforumlar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_mcvtforumlar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_mcvtforumlar = sprintf("&totalRows_mcvtforumlar=%d%s", $totalRows_mcvtforumlar, $queryString_mcvtforumlar);
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
<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/JavaScript">
<!--
function YY_checkform() { //v4.66
//copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('Aþaðýdaki hata / hatalarla karþýlaþýldý:\t\t\t\t\t\n\n'+myErr)}
  document.MM_returnValue = (myErr=='');
}
function derssec(){
	document.yarat.adi.value = document.yarat.liste.value 
}
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<!-- InstanceEndEditable -->
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
         <td width="21%" class="baslik"><div align="right">Yeni Forum Yarat</div></td>
         <td width="49%" class="baslik"><span class="arabaslikuyari"><?php echo $_GET['bilgi'];?></span>&nbsp; </td>
         <td width="30%"><div align="center">
          </div></td>
       </tr>
       <tr>
         <td colspan="2" valign="top"><form action="<?php echo $editFormAction; ?>" method="POST" name="yarat" id="yarat">
           <table width="100%"  border="0" cellspacing="5" cellpadding="5">
             <tr class="icyazi">
               <td><div align="right"><strong>Forum Tipi</strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><select name="tip" id="tip">
                 <option value="Hata" selected>Seçiniz</option>
                 <option value="Ders Forumu">Ders Forumu</option>
                 <option value="Serbest Kürsü">Serbest Kürsü</option>
               </select></td>
             </tr>
             <tr class="icyazi">
               <td width="29%"><div align="right"><strong>Forum Adý </strong></div></td>
               <td width="3%"><div align="center"><strong>:</strong></div></td>
               <td width="68%"><input name="adi" type="text" class="icyazi" id="adi" size="25" maxlength="25">                 <span class="baslik">*</span>                 <select name="liste" class="icyazi" id="liste" onChange="MM_callJS('derssec()')">
                 <option selected value="">Ders Forumu ise seçiniz</option>
                 <?php
do {  
?>
                 <option value="<?php echo $row_dersler['fliste']?>"><?php echo $row_dersler['fliste']?></option>
                 <?php
} while ($row_dersler = mysql_fetch_assoc($dersler));
  $rows = mysql_num_rows($dersler);
  if($rows > 0) {
      mysql_data_seek($dersler, 0);
	  $row_dersler = mysql_fetch_assoc($dersler);
  }
?>
                 </select>                  </td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Açýklama</strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><input name="aciklama" type="text" id="aciklama" size="50" maxlength="100"> 
                 <span class="baslik">* </span></td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Aktif</strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><select name="aktif" id="aktif">
                 <option value="Evet" selected>Evet</option>
                 <option value="Hayýr">Hayýr</option>
               </select></td>
             </tr>
             <tr>
               <td><div align="right">
                 <input name="yaratan" type="hidden" id="yaratan" value="<?php echo $row_gka['kadi']; ?>">
               </div></td>
               <td>&nbsp;</td>
               <td><input name="Submit" type="submit" class="butongiris" onClick="YY_checkform('yarat','adi','#q','0','Forum adý boþ býrakýlmaz','aciklama','#q','0','Açýklama boþ býrakýlmaz','tip','#q','1','Geçerli bir forum tipi seçiniz');return document.MM_returnValue" value="Forumu Yarat"></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div align="center" class="baslik">*</div></td>
               <td class="altbaslik">Alanlarýn girilmesi zorunludur</td>
             </tr>
           </table>
           <input type="hidden" name="MM_insert" value="yarat">
         </form>
          </td>
         <td valign="top"><p class="altbaslik">Yeni bir forum yaratacaksanýz:</p>
           <p class="icyazi">Aþaðýda yer alan forum listesinden yaratmak istediðiniz forumun daha önceden oluþturulup oluþturulmadýðýna bakabilirsiniz. </p>
           <p class="altbaslik">Yeni bir forum yarattýysanýz:</p>
          <p class="altbaslik"><span class="icyazi">Bir sonraki aþama olan &quot;<a href="baslikekle.php">Foruma Baþlýk Ekleme</a>&quot; bölümüne geçebilirsiniz.</span></p></td>
       </tr>
       <tr>
         <td height="33" colspan="2" valign="middle"><div align="right" class="arabaslik">
           <div align="left">Þu an tartýþma grubunda <span class="arabaslikuyari"><?php echo $totalRows_mcvtforumlar ?></span> adet forum var. <!--Fireworks MX Dreamweaver LBI target.  Created -->
           </div>
         </div></td>
         <td valign="top"><table width="128" border="0" align="center" cellpadding="0" cellspacing="0">
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
             <td><?php if ($pageNum_mcvtforumlar > 0) { // Show if not first page ?>
               <a href="<?php printf("%s?pageNum_mcvtforumlar=%d%s", $currentPage, 0, $queryString_mcvtforumlar); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c1','','../../Library/listehareket/listehareket_r1_c1_f2.gif',1)" ><img src="../../Library/listehareket/listehareket_r1_c1.gif" alt="Ýlk" name="listehareket_r1_c1" width="30" height="22" border="0"></a>
               <?php } // Show if not first page ?></td>
             <td><?php if ($pageNum_mcvtforumlar > 0) { // Show if not first page ?>
               <a href="<?php printf("%s?pageNum_mcvtforumlar=%d%s", $currentPage, max(0, $pageNum_mcvtforumlar - 1), $queryString_mcvtforumlar); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c2','','../../Library/listehareket/listehareket_r1_c2_f2.gif',1)" ><img src="../../Library/listehareket/listehareket_r1_c2.gif" alt="Önceki" name="listehareket_r1_c2" width="25" height="22" border="0"></a>
               <?php } // Show if not first page ?></td>
             <td><img src="../../Library/listehareket/listehareket_r1_c3.gif" alt="Liste Kontrol Paneli" name="listehareket_r1_c3" width="16" height="22" border="0"></td>
             <td><a href="<?php printf("%s?pageNum_mcvtforumlar=%d%s", $currentPage, min($totalPages_mcvtforumlar, $pageNum_mcvtforumlar + 1), $queryString_mcvtforumlar); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c4','','../../Library/listehareket/listehareket_r1_c4_f2.gif',1)" >
               <?php if ($pageNum_mcvtforumlar < $totalPages_mcvtforumlar) { // Show if not last page ?>
               <img src="../../Library/listehareket/listehareket_r1_c4.gif" alt="Sonraki" name="listehareket_r1_c4" width="25" height="22" border="0">
               <?php } // Show if not last page ?>
             </a></td>
             <td><?php if ($pageNum_mcvtforumlar < $totalPages_mcvtforumlar) { // Show if not last page ?>
               <a href="<?php printf("%s?pageNum_mcvtforumlar=%d%s", $currentPage, $totalPages_mcvtforumlar, $queryString_mcvtforumlar); ?>" onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('listehareket_r1_c5','','../../Library/listehareket/listehareket_r1_c5_f2.gif',1)" ><img src="../../Library/listehareket/listehareket_r1_c5.gif" alt="Son" name="listehareket_r1_c5" width="32" height="22" border="0"></a>
               <?php } // Show if not last page ?></td>
             <td><img src="../../Library/listehareket/spacer.gif" width="1" height="22" border="0"></td>
           </tr>
         </table>
          <div align="center"></div></td>
       </tr>
       <tr class="icyazi">
         <td height="27" colspan="3" valign="top"><table width="100%"  border="0" cellspacing="5" cellpadding="0">
           <tr class="icyazi">
             <td width="17%"><strong>Forum Adý</strong></td>
             <td width="36%"><strong>Açýklama</strong></td>
             <td width="15%"><strong>Forum Tipi </strong></td>
             <td width="13%"><strong>Yaratan</strong></td>
             <td width="10%"><strong>Tarih</strong></td>
             <td width="4%"><strong>Aktif</strong></td>
           </tr>
           <?php do { ?>
           <tr class="icyazi">
               <td valign="top"><?php echo $row_mcvtforumlar['adi']; ?></td>
               <td valign="top"><?php echo $row_mcvtforumlar['aciklama']; ?></td>
               <td valign="top"><?php echo $row_mcvtforumlar['tip']; ?></td>
               <td valign="top"><?php echo $row_mcvtforumlar['yaratan']; ?></td>
               <td valign="top"><?php echo $row_mcvtforumlar['trh']; ?></td>
               <td valign="top"><?php echo $row_mcvtforumlar['aktif']; ?></td>
           </tr>
           <?php } while ($row_mcvtforumlar = mysql_fetch_assoc($mcvtforumlar)); ?>
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

mysql_free_result($mcvtforumlar);

mysql_free_result($dersler);
?>
