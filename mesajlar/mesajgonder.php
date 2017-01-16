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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "yolla")) {
  $insertSQL = sprintf("INSERT INTO mesajlar (gonderen, alici, konu, icerik) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['gonderen'], "text"),
                       GetSQLValueString($_POST['alici'], "text"),
                       GetSQLValueString($_POST['konu'], "text"),
                       GetSQLValueString($_POST['icerik'], "text"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($insertSQL, $iysconn) or die(mysql_error());

  $insertGoTo = "mesajgonderilmis.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

mysql_select_db($database_iysconn, $iysconn);
$query_tamliste = "SELECT kadi FROM kullanici ORDER BY kadi ASC";
$tamliste = mysql_query($query_tamliste, $iysconn) or die(mysql_error());
$row_tamliste = mysql_fetch_assoc($tamliste);
$totalRows_tamliste = mysql_num_rows($tamliste);
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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
function kisiekle(){
	document.yolla.alici.value = document.kontaklar.kisiler.value;
}
</script>
<!-- InstanceEndEditable -->
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
         <td width="70%" class="icyazi"><p class="baslik">Mesaj Gönder  </p></td>
         <td width="30%" rowspan="2" valign="bottom" class="icyazi"><form action="" method="post" name="kontaklar" id="kontaklar">
           <table width="100%"  border="0" cellspacing="5" cellpadding="0">
             <tr>
               <td width="59%"><div align="left"></div>
                   <div align="center" class="arabaslik">
                     <div align="left">Kontaklar</div>
                 </div></td>
               <td width="41%"><div align="right">
                 <input name="Button" type="button" class="butongiris" onClick="MM_callJS('kisiekle()')" value="Kiþi Ekle">
               </div></td>
             </tr>
             <tr>
               <td colspan="2"><select name="kisiler" size="22" class="metinkutusu" id="kisiler">
                 <option value="">Tüm Kullanýcýlar (A - Z Alfabetik)</option>
                 <option value="">-------------------------------------------------</option>
                 <?php
do {  
?>
                 <option value="<?php echo $row_tamliste['kadi']?>"><?php echo $row_tamliste['kadi']?></option>
                 <?php
} while ($row_tamliste = mysql_fetch_assoc($tamliste));
  $rows = mysql_num_rows($tamliste);
  if($rows > 0) {
      mysql_data_seek($tamliste, 0);
	  $row_tamliste = mysql_fetch_assoc($tamliste);
  }
?>
               </select></td>
             </tr>
           </table>
         </form>
          </td>
       </tr>
       <tr>
         <td class="icyazi"><form action="<?php echo $editFormAction; ?>" method="POST" name="yolla" id="yolla">
           <table width="100%"  border="0" cellspacing="5" cellpadding="0">
             <tr valign="top" class="icyazi">
               <td width="11%"><div align="right"><strong>Kimden</strong></div></td>
               <td width="2%"><strong>:</strong></td>
               <td width="87%"><?php echo $row_gk['kadi']; ?> <input name="gonderen" type="hidden" id="gonderen" value="<?php echo $row_gk['kadi']; ?>"></td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Kime</strong></div></td>
               <td><strong>:</strong></td>
               <td><input name="alici" type="text" class="icyazi" id="alici" size="25" maxlength="60">                 
               <span class="formaciklama">Mesajý gönreceðiniz kiþiyi kontaklardan seçebilirsiniz.</span></td>
             </tr>
             <tr class="icyazi">
               <td><div align="right"><strong>Konu</strong></div></td>
               <td><strong>:</strong></td>
               <td><input name="konu" type="text" class="icyazi" id="konu" size="75" maxlength="100"></td>
             </tr>
             <tr>
               <td colspan="3"><hr size="1"></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td><textarea name="icerik" cols="75" rows="15" class="icyazi" id="icerik"></textarea></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td><input name="Submit" type="submit" class="butongiris" onClick="YY_checkform('yolla','alici','#q','0','Lütfen mesajý kime yollayacaðýnýzý belirtiniz.','konu','#q','0','Lütfen mesajýnýzýn konusunu belirtiniz.');return document.MM_returnValue" value="Mesajý Yolla"></td>
             </tr>
           </table>
             <input type="hidden" name="MM_insert" value="yolla">
         </form>
          </td>
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

mysql_free_result($tamliste);
?>
