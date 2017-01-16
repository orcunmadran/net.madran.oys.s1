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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "yayinla")) {
  $insertSQL = sprintf("INSERT INTO dersler_snvtar (subeno, sinavtipi, sinavyeri, baslamatarih, bitistarih, sinavsaat, aciklama) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['subeno'], "int"),
                       GetSQLValueString($_POST['sinavtipi'], "text"),
                       GetSQLValueString($_POST['sinavyeri'], "text"),
                       GetSQLValueString($_POST['baslamatarih'], "date"),
                       GetSQLValueString($_POST['bitistarih'], "date"),
                       GetSQLValueString($_POST['sinavsaat'], "text"),
                       GetSQLValueString($_POST['aciklama'], "text"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($insertSQL, $iysconn) or die(mysql_error());

  $insertGoTo = "dersler_snb.php?bilgi= > Sýnav Tarihi baþarýyla yayýnlandý.";
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

$degerbir_ders = "-1";
if (isset($_SESSION['MM_Username'])) {
  $degerbir_ders = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
$degeriki_ders = "-1";
if (isset($_GET['subeno'])) {
  $degeriki_ders = (get_magic_quotes_gpc()) ? $_GET['subeno'] : addslashes($_GET['subeno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_ders = sprintf("SELECT DISTINCT  CONCAT(DE.derskodu,  ' - ', SU.subekodu) AS desu, DE.dersadi, SU.sorumlu, SU.subeno FROM dersler DE, subeler SU WHERE DE.dersno = SU.dersno AND SU.sorumlu = '%s' AND SU.subeno = '%s'", $degerbir_ders,$degeriki_ders);
$ders = mysql_query($query_ders, $iysconn) or die(mysql_error());
$row_ders = mysql_fetch_assoc($ders);
$totalRows_ders = mysql_num_rows($ders);

$colname_sinav = "-1";
if (isset($_GET['subeno'])) {
  $colname_sinav = (get_magic_quotes_gpc()) ? $_GET['subeno'] : addslashes($_GET['subeno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_sinav = sprintf("SELECT *, DATE_FORMAT(baslamatarih, '%%d.%%m.%%y') AS bast, DATE_FORMAT(bitistarih, '%%d.%%m.%%y') AS bitt FROM dersler_snvtar WHERE subeno = %s ORDER BY baslamatarih", $colname_sinav);
$sinav = mysql_query($query_sinav, $iysconn) or die(mysql_error());
$row_sinav = mysql_fetch_assoc($sinav);
$totalRows_sinav = mysql_num_rows($sinav);

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
//-->
</script>
<script language="javascript" type="text/javascript" src="../../dyncal/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="../../dyncal/dynCalendar.js"></script>
<link href="../../dyncal/dynCalendar.css" rel="stylesheet" type="text/css">
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
   <td colspan="2"><a href="../kullanicilar/index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c1','','../fw_admin/admin_r2_c1_f2.gif',1)"><img name="admin_r2_c1" src="../fw_admin/admin_r2_c1.gif" width="94" height="25" border="0" alt="Kullanýcý iþlemlerini yürüt"></a></td>
   <td><img name="admin_r2_c3" src="../fw_admin/admin_r2_c3.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="index.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('admin_r2_c4','','../fw_admin/admin_r2_c4_f2.gif',1)"><img name="admin_r2_c4" src="../fw_admin/admin_r2_c4.gif" width="63" height="25" border="0" alt="Dersleri yönet"></a></td>
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
         <td width="77%" class="baslik"><a href="dersler.php"><?php echo $row_ders['desu']; ?></a> Sýnav Tarihi Belirle <span class="baslikuyari"><?php echo $_GET['bilgi']; ?></span></td>
         <td width="23%">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2"><form action="<?php echo $editFormAction; ?>" method="POST" name="yayinla" id="yayinla">
           <table width="100%"  border="0" cellspacing="5" cellpadding="5">
             <tr class="icyazi">
               <td width="18%"><div align="right"><strong>Sýnav Tipi </strong></div></td>
               <td width="2%"><div align="center"><strong>:</strong></div></td>
               <td width="80%"><select name="sinavtipi" class="icyazi" id="sinavtipi">
                 <option>Deneme Sýnavý</option>
                 <option>Mini Test</option>
                 <option>Arasýnav</option>
                 <option>Final Sýnavý</option>
                                                            </select></td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Sýnav Yeri </strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td>                 <select name="sinavyeri" class="icyazi" id="sinavyeri">
                 <option selected>Ýnternet Üzerinden</option>
                 <option>Merkezde Yüzyüze</option>
                                               </select> 
                 </td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Baþlama Tarihi </strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><input name="baslamatarih" type="text" class="icyazi" id="baslamatarih" size="15">                 
                 <strong>
                 <script language="JavaScript" type="text/javascript">
        		function calendar1Callback(date, month, year)
        			{
            		document.yayinla.baslamatarih.value = year + '-' + month + '-' + date;
        			}
        			calendar1 = new dynCalendar('calendar1', 'calendar1Callback');
    			 
                 </script> 
                 </strong></td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Bitiþ Tarihi </strong></div></td>
               <td><div align="center"><strong>:</strong></div></td>
               <td><input name="bitistarih" type="text" class="icyazi" id="bitistarih" size="15">
                 <script language="JavaScript" type="text/javascript">
        		function calendar2Callback(date, month, year)
        			{
            		document.yayinla.bitistarih.value = year + '-' + month + '-' + date;
        			}
        			calendar2 = new dynCalendar('calendar2', 'calendar2Callback');
    			 
                 </script>                                  </td>
             </tr>
             <tr class="icyazi">
               <td valign="top"><div align="right"><strong>Sýnav Saati </strong></div></td>
               <td valign="top"><div align="center"><strong>:</strong></div></td>
               <td><select name="sinavsaat" class="icyazi" id="sinavsaat">
                 <option value=" " selected></option>
                 <option>09:00</option>
                 <option>09:30</option>
                 <option>10:00</option>
                 <option>10:30</option>
                 <option>11:00</option>
                 <option>11:30</option>
                 <option>12:00</option>
                 <option>12:30</option>
                 <option>13:00</option>
                 <option>13:30</option>
                 <option>14:00</option>
                 <option>14:30</option>
                 <option>15:00</option>
                 <option>15:30</option>
                 <option>16:00</option>
                 <option>16:30</option>
                 <option>17:00</option>
                 <option>17:30</option>
                 <option>18:00</option>
                 <option>18:30</option>
                 <option>19:00</option>
                 <option>19:30</option>
                 <option>20:00</option>
                 <option>20:30</option>
                 <option>21:00</option>
                 <option>21:30</option>
                 <option>22:00</option>
                                                                                          </select>
                 <span class="formaciklama">                 Sadece Merkezde Yüzyüze yapýlan sýnavlarda saat belirtiniz.</span></td>
             </tr>
             <tr class="icyazi">
               <td valign="top"><div align="right"><strong>Açýklama</strong></div></td>
               <td valign="top"><div align="center"><strong>:</strong></div></td>
               <td><textarea name="aciklama" cols="50" rows="5" class="icyazi" id="aciklama"></textarea></td>
             </tr>
             <tr class="icyazi">
               <td valign="top"><div align="right">
                 <input name="subeno" type="hidden" id="subeno" value="<?php echo $row_ders['subeno']; ?>">
               </div></td>
               <td valign="top">&nbsp;</td>
               <td><input name="Submit" type="submit" class="butongiris" onClick="YY_checkform('form1','baslamatarih','#q','0','Sohbet saatlerinin baþlama tarihini giriniz.','bitistarih','#q','0','Sohbet saatlerinin bitiþ tarihini giriniz.');return document.MM_returnValue" value="Sýnav Tarihi Yayýnla"></td>
             </tr>
           </table>
           
           <input type="hidden" name="MM_insert" value="yayinla">
         </form></td>
        </tr>
       <tr>
         <td colspan="2"><?php if ($totalRows_sinav > 0) { // Show if recordset not empty ?>
           <table width="100%"  border="0" cellspacing="5" cellpadding="5">
             <tr class="icyazi">
                <td><div align="center"><strong>Sýnav Tipi </strong></div></td>
                <td><div align="center"><strong>Sýnav Yeri </strong></div></td>
                <td><div align="center"><strong>Tarih Aralýðý </strong></div></td>
                <td><div align="center"><strong>Sýnav Saati </strong></div></td>
                <td><div align="center"><strong>Güncelle</strong></div></td>
                <td><div align="center"><strong>Sil</strong></div></td>
             </tr>
             <?php do { ?>
             <tr class="icyazi">
                <td><div align="center"><?php echo $row_sinav['sinavtipi']; ?></div></td>
                <td><div align="center"><?php echo $row_sinav['sinavyeri']; ?></div></td>
                <td><div align="center"><?php echo $row_sinav['bast']; ?> - <?php echo $row_sinav['bitt']; ?> </div></td>
                <td><div align="center"><?php echo $row_sinav['sinavsaat']; ?></div></td>
                <td><div align="center"> <a href="dersler_sng.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."snvtrhno=".urlencode($row_sinav['snvtrhno']) ?>"> <img src="../../resimler/guncelle.gif" width="16" height="16" border="0"> </a> </div></td>
                <td><div align="center"> <a href="dersler_sns.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."snvtrhno=".urlencode($row_sinav['snvtrhno']) ?>"> <img src="../../mesajlar/m_imaj/sil.gif" width="16" height="14" border="0"> </a> </div></td>
             </tr>
             <?php } while ($row_sinav = mysql_fetch_assoc($sinav)); ?>
           </table>
           <?php } // Show if recordset not empty ?></td>
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

mysql_free_result($ders);

mysql_free_result($sinav);
?>
