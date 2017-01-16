<?php require_once('Connections/iysconn.php'); ?>
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
	
  $logoutGoTo = "index.php";
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

$MM_restrictGoTo = "giris_yetki_yok.php";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "guncelle")) {
  $updateSQL = sprintf("UPDATE kullanici SET ad=%s, soyad=%s, eposta=%s, webadres=%s, evadres=%s, evtel=%s, isadres=%s, istel=%s, mobiltel=%s WHERE kadi=%s",
                       GetSQLValueString($_POST['ad'], "text"),
                       GetSQLValueString($_POST['soyad'], "text"),
                       GetSQLValueString($_POST['eposta'], "text"),
                       GetSQLValueString($_POST['webadres'], "text"),
                       GetSQLValueString($_POST['evadres'], "text"),
                       GetSQLValueString($_POST['evtel'], "text"),
                       GetSQLValueString($_POST['isadres'], "text"),
                       GetSQLValueString($_POST['istel'], "text"),
                       GetSQLValueString($_POST['mobiltel'], "text"),
                       GetSQLValueString($_POST['kadi'], "text"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($updateSQL, $iysconn) or die(mysql_error());

  $updateGoTo = "kisiselbilgiler.php?bilgi=> Bilgiler güncellendi";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "sifred")) {
  $updateSQL = sprintf("UPDATE kullanici SET sifre=%s WHERE kadi=%s",
                       GetSQLValueString($_POST['sifre'], "text"),
                       GetSQLValueString($_POST['kadi'], "text"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($updateSQL, $iysconn) or die(mysql_error());

  $updateGoTo = "kisiselbilgiler.php?bilgis=Þifre deðiþtirildi";
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

$colname_guncelle = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_guncelle = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_guncelle = sprintf("SELECT * FROM kullanici WHERE kadi = '%s'", $colname_guncelle);
$guncelle = mysql_query($query_guncelle, $iysconn) or die(mysql_error());
$row_guncelle = mysql_fetch_assoc($guncelle);
$totalRows_guncelle = mysql_num_rows($guncelle);
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
<link href="iys.css" rel="stylesheet" type="text/css">
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

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' alanýna geçerli bir e-posta adresi giriniz.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' alaný gerekli.\n'; }
  } if (errors) alert('Aþaðýdaki hata / hatalarla karþýlaþýldý:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<!-- InstanceEndEditable -->
</head>
<body bgcolor="#666666" onLoad="MM_preloadImages('fw_iys/sb_r2_c1_f2.gif','fw_iys/sb_r2_c4_f2.gif','fw_iys/sb_r2_c6_f2.gif','fw_iys/sb_r2_c8_f2.gif','fw_iys/sb_r2_c10_f2.gif','fw_iys/sb_r2_c12_f2.gif','fw_iys/sb_r2_c14_f2.gif','fw_iys/sb_r2_c16_f2.gif','fw_iys/sb_r2_c19_f2.gif')">
<!--The following section is an HTML table which reassembles the sliced image in a browser.-->
<!--Copy the table section including the opening and closing table tags, and paste the data where-->
<!--you want the reassembled image to appear in the destination document. -->
<!--======================== BEGIN COPYING THE HTML HERE ==========================-->
<table width="955" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="sb.png" fwbase="sb.gif" fwstyle="Dreamweaver" fwdocid = "1301164485" fwnested="0" -->
  <tr>
<!-- Shim row, height 1. -->
   <td><img src="fw_iys/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="73" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="59" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="51" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="58" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="71" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="104" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="60" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="62" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="160" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="127" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr><!-- row 1 -->
   <td colspan="20"><img src="fw_iys/sb_r1_c1.gif" name="sb_r1_c1" width="955" height="31" border="0"></td>
   <td><img src="fw_iys/spacer.gif" width="1" height="31" border="0" alt=""></td>
  </tr>
  <tr><!-- row 2 -->
   <td colspan="2"><a href="anasayfa.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c1','','fw_iys/sb_r2_c1_f2.gif',1)"><img name="sb_r2_c1" src="fw_iys/sb_r2_c1.gif" width="78" height="25" border="0" alt="Anasayfa"></a></td>
   <td><img name="sb_r2_c3" src="fw_iys/sb_r2_c3.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="dersler/dersler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c4','','fw_iys/sb_r2_c4_f2.gif',1)"><img name="sb_r2_c4" src="fw_iys/sb_r2_c4.gif" width="59" height="25" border="0" alt="Yüklendiðin dersleri görüntüle"></a></td>
   <td><img name="sb_r2_c5" src="fw_iys/sb_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="mesajlar/mesajlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c6','','fw_iys/sb_r2_c6_f2.gif',1)"><img name="sb_r2_c6" src="fw_iys/sb_r2_c6.gif" width="51" height="25" border="0" alt="Mesaj alýp gönder"></a></td>
   <td><img name="sb_r2_c7" src="fw_iys/sb_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="sohbet.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c8','','fw_iys/sb_r2_c8_f2.gif',1)"><img src="fw_iys/sb_r2_c8.gif" alt="Sohbet odalarýna giriþ yap" name="sb_r2_c8" width="58" height="25" border="0"></a></td>
   <td><img name="sb_r2_c9" src="fw_iys/sb_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="forumlar/forumlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c10','','fw_iys/sb_r2_c10_f2.gif',1)"><img name="sb_r2_c10" src="fw_iys/sb_r2_c10.gif" width="71" height="25" border="0" alt="Tartýþma gruplarýna katýl"></a></td>
   <td><img name="sb_r2_c11" src="fw_iys/sb_r2_c11.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="kisiselbilgiler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c12','','fw_iys/sb_r2_c12_f2.gif',1)"><img name="sb_r2_c12" src="fw_iys/sb_r2_c12.gif" width="104" height="25" border="0" alt="Kiþisel bilgilerinizi görüntüle ya da güncelle"></a></td>
   <td><img name="sb_r2_c13" src="fw_iys/sb_r2_c13.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="iletisim.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c14','','fw_iys/sb_r2_c14_f2.gif',1)"><img name="sb_r2_c14" src="fw_iys/sb_r2_c14.gif" width="60" height="25" border="0" alt="Akademik ve Teknik birimlerle iletiþime geç"></a></td>
   <td><img name="sb_r2_c15" src="fw_iys/sb_r2_c15.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="yardim.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c16','','fw_iys/sb_r2_c16_f2.gif',1)"><img name="sb_r2_c16" src="fw_iys/sb_r2_c16.gif" width="62" height="25" border="0" alt="Yardým konularýný görüntüle"></a></td>
   <td><a href="admin/anasayfa.php"><img name="sb_r2_c17" src="resimler/gecis.gif" width="15" height="25" border="0" alt="Yönetim paneline geçiþ yap (Yönetici ve Öðretim Elemaný)"></a></td>
   <td bgcolor="#000000"><div align="center" class="kimlik"><?php echo $row_gk['kadi']; ?></div></td>
   <td colspan="2"><a href="<?php echo $logoutAction ?>"><img src="fw_iys/sb_r2_c19.gif" alt="" name="sb_r2_c19" width="132" height="25" border="0" onMouseOver="MM_swapImage('sb_r2_c19','','fw_iys/sb_r2_c19_f2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
   <td><img src="fw_iys/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td background="fw_iys/sb_r3_c1.gif"><img name="sb_r3_c1" src="fw_iys/sb_r3_c1.gif" width="5" height="489" border="0" alt=""></td>
   <td colspan="18" valign="top" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="icerik" -->
     <table width="100%"  border="0" cellspacing="5" cellpadding="5">
       <tr>
         <td colspan="2" class="arabaslik"><span class="baslik">Kiþisel Bilgiler</span></td>
         <td width="34%" class="icyazi">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2" class="arabaslik">Kiþisel bilgilerini bu bölümden güncelleyebilirsin.</td>
         <td class="icyazi">&nbsp;</td>
       </tr>
       <tr>
         <td width="17%" height="32" class="altbaslik"><div align="right">Bilgi Formu</div></td>
         <td width="49%" class="altbaslik"><span class="arabaslik"><span class="arabaslikuyari"><?php echo $_GET['bilgi'] ?></span></span></td>
         <td class="altbaslik"><div align="center">Þifre Deðiþtirme Formu</div></td>
       </tr>
       <tr>
         <td height="32" colspan="2" class="altbaslik"><form action="<?php echo $editFormAction; ?>" method="POST" name="guncelle" id="guncelle">
           <table width="98%"  border="0" cellspacing="5" cellpadding="0">
             <tr>
               <td width="24%" valign="top" class="icyazi"><div align="right"><strong>Adýnýz</strong></div></td>
               <td width="3%" valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td width="73%" valign="top"><input name="ad" type="text" class="icyazi" id="ad" value="<?php echo $row_guncelle['ad']; ?>" size="30" maxlength="30">
                   <span class="baslik">*</span> </td>
             </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Soyadýnýz</strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="soyad" type="text" class="icyazi" id="soyad" value="<?php echo $row_guncelle['soyad']; ?>" size="30" maxlength="30">
                   <span class="baslik"> *</span></td>
             </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>E - Posta Adresiniz</strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="eposta" type="text" class="icyazi" id="eposta" value="<?php echo $row_guncelle['eposta']; ?>" size="50" maxlength="100">
                   <span class="baslik">*</span></td>
             </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Web Adresiniz </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="webadres" type="text" class="icyazi" id="webadres" value="<?php echo $row_guncelle['webadres']; ?>" size="50" maxlength="100"></td>
             </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Ev Adresiniz </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><textarea name="evadres" cols="50" rows="5" class="icyazi" id="evadres"><?php echo $row_guncelle['evadres']; ?></textarea></td>
             </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Ev Telefonunuz </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="evtel" type="text" class="icyazi" id="evtel" value="<?php echo $row_guncelle['evtel']; ?>" size="25" maxlength="25">
                   <span class="formaciklama">(999) 999 99 99</span> </td>
             </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Ýþ Adresiniz </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><textarea name="isadres" cols="50" rows="5" class="icyazi" id="isadres"><?php echo $row_guncelle['isadres']; ?></textarea></td>
             </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Ýþ Telefonunuz </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="istel" type="text" class="icyazi" id="istel" value="<?php echo $row_guncelle['istel']; ?>" size="25" maxlength="25">
                   <span class="formaciklama">(999) 999 99 99 / 9999 </span></td>
             </tr>
             <tr>
               <td valign="top" class="icyazi"><div align="right"><strong>Mobil Telefonunuz </strong></div></td>
               <td valign="top" class="icyazi"><div align="center"><strong>:</strong></div></td>
               <td valign="top"><input name="mobiltel" type="text" class="icyazi" id="mobiltel" value="<?php echo $row_guncelle['mobiltel']; ?>" size="25" maxlength="25">
                   <span class="formaciklama">(999) 999 99 99</span></td>
             </tr>
             <tr>
               <td><div align="right">
                   <input name="kadi" type="hidden" id="kadi" value="<?php echo $row_guncelle['kadi']; ?>">
               </div></td>
               <td>&nbsp;</td>
               <td><input name="Submit" type="submit" class="butongiris" onClick="MM_validateForm('ad','','R','soyad','','R','eposta','','RisEmail');return document.MM_returnValue" value="Kayýt Güncelle"></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><span class="baslik">*</span></td>
               <td class="altbaslik">Alanlar boþ býrakýlamaz </td>
             </tr>
           </table>
           <input type="hidden" name="MM_update" value="guncelle">
         </form>
          </td>
         <td valign="top" class="icyazi"><form action="<?php echo $editFormAction; ?>" method="POST" name="sifred" id="sifred">
           <table width="100%"  border="0" cellspacing="5" cellpadding="0">
             <tr valign="top" class="icyazi">
               <td width="49%"><div align="right"><strong>Eski Þifreniz </strong></div></td>
               <td width="5%"><div align="center"><strong>:</strong></div></td>
               <td width="46%"><input name="eskisifre2" type="password" class="icyazi" id="eskisifre2" size="15" maxlength="15"></td>
             </tr>
             <tr valign="top" class="icyazi">
               <td><div align="right"><strong>Yeni Þifreniz </strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><input name="sifre" type="password" class="icyazi" id="sifre" size="15" maxlength="15"></td>
             </tr>
             <tr valign="top" class="icyazi">
               <td><div align="right"><strong>Yeni Þifreniz tekrar </strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><input name="sifre2" type="password" class="icyazi" id="sifre2" size="15" maxlength="15"></td>
             </tr>
             <tr valign="top" class="icyazi">
               <td><div align="right">
                   <input name="kadi" type="hidden" id="kadi" value="<?php echo $row_guncelle['kadi']; ?>">
                   <input name="eskisifre" type="hidden" id="eskisifre" value="<?php echo $row_guncelle['sifre']; ?>">
               </div></td>
               <td>&nbsp;</td>
               <td><input name="Submit" type="submit" class="butongiris" onClick="YY_checkform('sifred','eskisifre2','#eskisifre','6','Lütfen eski þifrenizi doðru olarak giriniz.','sifre','#q','0','Lütfen yeni bir þifre giriniz.','sifre2','#sifre','6','Yeni þifrenizi doðru bir þekilde yeniden giriniz.');return document.MM_returnValue" value="Deðiþtir"></td>
             </tr>
             <tr valign="top" class="icyaziuyari">
               <td colspan="3"><div align="center"><?php echo $_GET['bilgis'] ?></div></td>
               </tr>
           </table>
             <input type="hidden" name="MM_update" value="sifred">
         </form>
           <p><span class="icyaziuyari">ÖNEMLÝ</span>: Belirlediðiniz þifrelerde lütfen türkçe karakter kullanmayýnýz.</p></td>
       </tr>
     </table>
   <!-- InstanceEndEditable --></td>
   <td background="fw_iys/sb_r3_c20.gif"><img name="sb_r3_c20" src="fw_iys/sb_r3_c20.gif" width="5" height="489" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="1" height="489" border="0" alt=""></td>
  </tr>
  <tr><!-- row 4 -->
   <td colspan="20"><img name="sb_r4_c1" src="fw_iys/sb_r4_c1.gif" width="955" height="5" border="0" alt=""></td>
   <td><img src="fw_iys/spacer.gif" width="1" height="5" border="0" alt=""></td>
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

mysql_free_result($guncelle);
?>
