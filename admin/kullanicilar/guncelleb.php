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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "ekle")) {
  $updateSQL = sprintf("UPDATE kullanici SET ad=%s, soyad=%s, sifre=%s, kategori=%s, eposta=%s, webadres=%s, evadres=%s, evtel=%s, isadres=%s, istel=%s, mobiltel=%s, aciklama=%s WHERE kadi=%s",
                       GetSQLValueString($_POST['ad'], "text"),
                       GetSQLValueString($_POST['soyad'], "text"),
                       GetSQLValueString($_POST['sifre'], "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['eposta'], "text"),
                       GetSQLValueString($_POST['webadres'], "text"),
                       GetSQLValueString($_POST['evadres'], "text"),
                       GetSQLValueString($_POST['evtel'], "text"),
                       GetSQLValueString($_POST['isadres'], "text"),
                       GetSQLValueString($_POST['istel'], "text"),
                       GetSQLValueString($_POST['mobiltel'], "text"),
                       GetSQLValueString($_POST['aciklama'], "text"),
                       GetSQLValueString($_POST['kadi'], "text"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($updateSQL, $iysconn) or die(mysql_error());

  $updateGoTo = "guncelleb.php?bilgi= > Kayýt baþarýyla güncellenmiþtir";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

$colname_guncelle = "-1";
if (isset($_GET['kadi'])) {
  $colname_guncelle = (get_magic_quotes_gpc()) ? $_GET['kadi'] : addslashes($_GET['kadi']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_guncelle = sprintf("SELECT * FROM kullanici WHERE kadi = '%s'", $colname_guncelle);
$guncelle = mysql_query($query_guncelle, $iysconn) or die(mysql_error());
$row_guncelle = mysql_fetch_assoc($guncelle);
$totalRows_guncelle = mysql_num_rows($guncelle);
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

/*function kaolustur(){
	var adi = document.ekle.ad.value;
	var soyadi = document.ekle.soyad.value;
	document.ekle.kadi.value=adi+ " " +soyadi;
	}
	
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
*/
//-->
</script>
<!-- InstanceEndEditable -->
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
   <td colspan="2"><a href="index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c1','','../fw_admin/admin_r2_c1_f2.gif',1)"><img name="admin_r2_c1" src="../fw_admin/admin_r2_c1.gif" width="94" height="25" border="0" alt="Kullanýcý iþlemlerini yürüt"></a></td>
   <td><img name="admin_r2_c3" src="../fw_admin/admin_r2_c3.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../dersler/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c4','','../fw_admin/admin_r2_c4_f2.gif',1)"><img name="admin_r2_c4" src="../fw_admin/admin_r2_c4.gif" width="63" height="25" border="0" alt="Dersleri yönet"></a></td>
   <td><img name="admin_r2_c5" src="../fw_admin/admin_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../mesajlar/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c6','','../fw_admin/admin_r2_c6_f2.gif',1)"><img name="admin_r2_c6" src="../fw_admin/admin_r2_c6.gif" width="73" height="25" border="0" alt="Mesajlarý denetle"></a></td>
   <td><img name="admin_r2_c7" src="../fw_admin/admin_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../../sohbet/admin/index.php" target="_blank" onMouseOver="MM_swapImage('admin_r2_c8','','../fw_admin/admin_r2_c8_f2.gif',1)" onMouseOut="MM_swapImgRestore();"><img name="admin_r2_c8" src="../fw_admin/admin_r2_c8.gif" width="118" height="25" border="0" alt="Sohbet odalarýný yönet"></a></td>
   <td><img name="admin_r2_c9" src="../fw_admin/admin_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../forumlar/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c10','','../fw_admin/admin_r2_c10_f2.gif',1)"><img name="admin_r2_c10" src="../fw_admin/admin_r2_c10.gif" width="139" height="25" border="0" alt="Tartýþma gruplarýný yönet"></a></td>
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
         <td width="70%" class="arabaslik">Bilgileri Güncelle <span class="arabaslikuyari"><?php echo $_GET['bilgi'] ?></span></td>
         <td width="30%">&nbsp;</td>
       </tr>
       <tr>
         <td><form action="<?php echo $editFormAction; ?>" method="POST" name="ekle" id="ekle">
           <table width="100%"  border="0" cellspacing="5" cellpadding="0">
             <tr>
               <td width="24%" valign="top" class="icyazi"><div align="right"><strong>Adý</strong></div></td>
               <td width="3%" valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td width="73%" valign="top"><input name="ad" type="text" class="icyazi" id="ad" value="<?php echo $row_guncelle['ad']; ?>" size="30" maxlength="30"> 
                 <span class="baslik">*</span> </td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Soyadý</strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="soyad" type="text" class="icyazi" id="soyad" value="<?php echo $row_guncelle['soyad']; ?>" size="30" maxlength="30">
                 <span class="baslik"> *</span></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Kullanýcý Adý </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"> <input name="kadi" type="hidden" id="kadi" value="<?php echo $row_guncelle['kadi']; ?>"> 
                 <span class="icyazi"><?php echo $row_guncelle['kadi']; ?> </span><span class="formaciklama">(Kullanýcý adý deðiþtirilemez)</span> </td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Þifre</strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="sifre" type="text" class="icyazi" id="sifre" value="<?php echo $row_guncelle['sifre']; ?>" size="15" maxlength="15"> 
                 <span class="formaciklama"> <span class="baslik">*</span> Maksimum 15 karakter</span></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Kategori</strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><select name="kategori" class="icyazi" id="kategori">
                 <option value="<?php echo $row_guncelle['kategori']; ?>">Deðiþiklik Yok</option>
                 <option value="yonetici">Yönetici</option>
                 <option value="ogretime">Öðretim Elemaný</option>
                 <option value="ogrenci">Öðrenci</option>
               </select>                 
                 <span class="baslik">* </span><span class="icyazi">Mevcut Kategori:</span><span class="formaciklama"> <?php echo $row_guncelle['kategori']; ?></span></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>E - Posta </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="eposta" type="text" class="icyazi" id="eposta" value="<?php echo $row_guncelle['eposta']; ?>" size="50" maxlength="100"> 
               <span class="baslik">*</span></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Web Adresi </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="webadres" type="text" class="icyazi" id="webadres" value="<?php echo $row_guncelle['webadres']; ?>" size="50" maxlength="100"></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Ev Adresi </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><textarea name="evadres" cols="50" rows="5" class="icyazi" id="evadres"><?php echo $row_guncelle['evadres']; ?></textarea></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Ev Tel </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="evtel" type="text" class="icyazi" id="evtel" value="<?php echo $row_guncelle['evtel']; ?>" size="25" maxlength="25"> 
                 <span class="formaciklama">(999) 999 99 99</span> </td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Ýþ Adresi </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><textarea name="isadres" cols="50" rows="5" class="icyazi" id="isadres"><?php echo $row_guncelle['isadres']; ?></textarea></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Ýþ Tel </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="istel" type="text" class="icyazi" id="istel" value="<?php echo $row_guncelle['istel']; ?>" size="25" maxlength="25">
                 <span class="formaciklama">(999) 999 99 99 / 9999 </span></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Mobil</strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="mobiltel" type="text" class="icyazi" id="mobiltel" value="<?php echo $row_guncelle['mobiltel']; ?>" size="25" maxlength="25">
                 <span class="formaciklama">(999) 999 99 99</span></td>
               </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Açýklama</strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><textarea name="aciklama" cols="50" rows="5" class="icyazi" id="aciklama"><?php echo $row_guncelle['aciklama']; ?></textarea></td>
               </tr>
             <tr>
               <td><div align="right"></div></td>
               <td>&nbsp;</td>
               <td><input name="Submit" type="submit" class="butongiris" onClick="YY_checkform('ekle','ad','#q','0','Ad alaný boþ býrakýlamaz','soyad','#q','0','Soyad alaný boþ býrakýlamaz','kadi','#q','0','Kullanýcý adýný tanýmlayýnýz','sifre','#q','0','Þifre oluþturunuz','eposta','#S','2','E - Posta adresi giriniz');return document.MM_returnValue" value="Kayýt Güncelle"></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td><span class="baslik">*</span></td>
               <td class="altbaslik">Alanlarýn girilmesi zorunludur.</td>
               </tr>
           </table>
             
           <input type="hidden" name="MM_update" value="ekle">
         </form>
          </td>
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

mysql_free_result($guncelle);
?>
