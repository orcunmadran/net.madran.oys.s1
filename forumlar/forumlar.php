<?php require_once('../Connections/iysconn.php'); ?>
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
$query_df = "SELECT * FROM tg_forumlar WHERE tip = 'Ders Forumu' AND aktif = 'Evet' ORDER BY adi ASC";
$df = mysql_query($query_df, $iysconn) or die(mysql_error());
$row_df = mysql_fetch_assoc($df);
$totalRows_df = mysql_num_rows($df);

mysql_select_db($database_iysconn, $iysconn);
$query_sk = "SELECT * FROM tg_forumlar WHERE tip = 'Serbest K�rs�' AND aktif = 'Evet' ORDER BY adi ASC";
$sk = mysql_query($query_sk, $iysconn) or die(mysql_error());
$row_sk = mysql_fetch_assoc($sk);
$totalRows_sk = mysql_num_rows($sk);

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
<title>Sanal Kamp�s - Ba�kent �niversitesi E�itim Fak�ltesi</title>
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
   <td><a href="../dersler/dersler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c4','','../fw_iys/sb_r2_c4_f2.gif',1)"><img name="sb_r2_c4" src="../fw_iys/sb_r2_c4.gif" width="59" height="25" border="0" alt="Y�klendi�in dersleri g�r�nt�le"></a></td>
   <td><img name="sb_r2_c5" src="../fw_iys/sb_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../mesajlar/mesajlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c6','','../fw_iys/sb_r2_c6_f2.gif',1)"><img name="sb_r2_c6" src="../fw_iys/sb_r2_c6.gif" width="51" height="25" border="0" alt="Mesaj al�p g�nder"></a></td>
   <td><img name="sb_r2_c7" src="../fw_iys/sb_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../sohbet.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c8','','../fw_iys/sb_r2_c8_f2.gif',1)"><img src="../fw_iys/sb_r2_c8.gif" alt="Sohbet odalar�na giri� yap" name="sb_r2_c8" width="58" height="25" border="0"></a></td>
   <td><img name="sb_r2_c9" src="../fw_iys/sb_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="forumlar.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c10','','../fw_iys/sb_r2_c10_f2.gif',1)"><img name="sb_r2_c10" src="../fw_iys/sb_r2_c10.gif" width="71" height="25" border="0" alt="Tart��ma gruplar�na kat�l"></a></td>
   <td><img name="sb_r2_c11" src="../fw_iys/sb_r2_c11.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../kisiselbilgiler.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c12','','../fw_iys/sb_r2_c12_f2.gif',1)"><img name="sb_r2_c12" src="../fw_iys/sb_r2_c12.gif" width="104" height="25" border="0" alt="Ki�isel bilgilerinizi g�r�nt�le ya da g�ncelle"></a></td>
   <td><img name="sb_r2_c13" src="../fw_iys/sb_r2_c13.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../iletisim.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c14','','../fw_iys/sb_r2_c14_f2.gif',1)"><img name="sb_r2_c14" src="../fw_iys/sb_r2_c14.gif" width="60" height="25" border="0" alt="Akademik ve Teknik birimlerle ileti�ime ge�"></a></td>
   <td><img name="sb_r2_c15" src="../fw_iys/sb_r2_c15.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="../yardim.php" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c16','','../fw_iys/sb_r2_c16_f2.gif',1)"><img name="sb_r2_c16" src="../fw_iys/sb_r2_c16.gif" width="62" height="25" border="0" alt="Yard�m konular�n� g�r�nt�le"></a></td>
   <td><a href="../admin/anasayfa.php"><img name="sb_r2_c17" src="../resimler/gecis.gif" width="15" height="25" border="0" alt="Y�netim paneline ge�i� yap (Y�netici ve ��retim Eleman�)"></a></td>
   <td bgcolor="#000000"><div align="center" class="kimlik"><?php echo $row_gk['kadi']; ?></div></td>
   <td colspan="2"><a href="<?php echo $logoutAction ?>"><img src="../fw_iys/sb_r2_c19.gif" alt="" name="sb_r2_c19" width="132" height="25" border="0" onMouseOver="MM_swapImage('sb_r2_c19','','../fw_iys/sb_r2_c19_f2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
   <td><img src="../fw_iys/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td background="../fw_iys/sb_r3_c1.gif"><img name="sb_r3_c1" src="../fw_iys/sb_r3_c1.gif" width="5" height="489" border="0" alt=""></td>
   <td colspan="18" valign="top" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="icerik" -->
     <table width="100%"  border="0" cellspacing="5" cellpadding="5">
       <tr>
         <td width="67%" class="icyazi"><span class="baslik">Tart��ma Gruplar�na Ho�geldin</span></td>
         <td width="3%" class="icyazi"><p class="baslik">&nbsp;</p></td>
         <td width="30%" class="icyazi">&nbsp;</td>
       </tr>
       <tr>
         <td><span class="altbaslik">Sanal Kamp�s'te iki farkl� tart��ma grubumuz var. Bu gruplar;</span> <span class="arabaslik">&quot;Ders Forumlar�&quot;</span> <span class="altbaslik">ve</span> <span class="arabaslik">&quot;Serbest K�rs�&quot;</span><span class="altbaslik">'d�r.
           </span>
           <p class="icyazi">Ders Forumlar�'nda ders ile ilgili olarak ders sorumlusu taraf�ndan olu�turulmu� forum ba�l�klar� alt�nda konular� tart��abiliyoruz.</p>
          <p class="icyazi">Serbest K�rs�'de ise &quot;Tart��ma Gruplar�&quot; kurallar� �er�evesinde istedi�imiz konu hakk�nda kullan�c�lar ile fikir ve bilgi al��veri�inde bulunabiliyoruz.</p></td>
         <td><p class="arabaslik">&nbsp;</p>
          </td>
         <td rowspan="3" valign="top" class="icyazi"><div align="center">
           <p align="left" class="arabaslik"><strong>Tart��ma Gruplar� Genel Kurallar� </strong></p>
           <p align="left" class=formaciklama>Tart��ma gruplar�nda yer alan forumlara yaz�lan yorumlar�n t�m sorumlulu�u yazar�na aittir. Tart��ma gruplar�n�n genel ama�lar� d���nda, kamu d�zenini bozucu, genel ahlaka ayk�r� yaz�lar Sanal Kamp�s y�neticileri taraf�ndan silinecektir.</p>
           <p align="left" class=formaciklama>Tart��ma gruplar� genelinde bu t�r davran��lardan ka��n�lmal�, kar��la��ld��� takdirde Sanal Kamp�s y�neticiler bilgilendirilmelidir.</p>
           <p align="left" class=formaciklama><strong>Sanal Kamp�s Y�neticisi </strong></p>
         </div></td>
       </tr>
       <tr>
         <td><hr></td>
         <td>&nbsp;</td>
        </tr>
       <tr>
         <td bgcolor="#999999"><p><span class="arabasfpB">Ders Forumlar�</span></p>
           <table width="100%"  border="0" cellpadding="0" cellspacing="5" bgcolor="#CCCCCC">
           <tr class="icyazi">
             <td width="27%"><strong>Ders Kodu </strong></td>
             <td width="42%"><strong>A��klama</strong></td>
             <td width="31%"><strong>Forum Y�neticisi </strong></td>
           </tr>
           <tr class="icyazi">
             <td colspan="3" class="icyazi"><?php if ($totalRows_df == 0) { // Show if recordset empty ?>
Aktif durumda herhangi bir forum bulunmamakta
<?php } // Show if recordset empty ?></td>
             </tr>
           <?php do { ?>
           <tr class="icyazi">
             <td><?php echo $row_df['adi']; ?></td>
             <td><a href="basliklar.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."girisno=".urlencode($row_df['girisno']) ?>"><?php echo $row_df['aciklama']; ?></a></td>
             <td><?php echo $row_df['yaratan']; ?></td>
           </tr>
           <?php } while ($row_df = mysql_fetch_assoc($df)); ?>
         </table>
          <P class=icyazi><span class="arabasfpB">Serbest K�rs�</span></P>           
          <table width="100%"  border="0" cellpadding="0" cellspacing="5" bgcolor="#CCCCCC">
            <tr class="icyazi">
              <td width="27%"><strong>Konu</strong></td>
              <td width="42%"><strong>A��klama</strong></td>
              <td width="31%"><strong>Forum Y�neticisi </strong></td>
            </tr>
            <tr class="icyazi">
              <td colspan="3"><?php if ($totalRows_sk == 0) { // Show if recordset empty ?>
Aktif durumda herhangi bir forum bulunmamakta
<?php } // Show if recordset empty ?></td>
              </tr>
            <?php do { ?>
            <tr class="icyazi">
              <td><?php echo $row_sk['adi']; ?></td>
              <td><a href="basliklar.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."girisno=".urlencode($row_sk['girisno']) ?>"><?php echo $row_sk['aciklama']; ?></a></td>
              <td><?php echo $row_sk['yaratan']; ?></td>
            </tr>
            <?php } while ($row_sk = mysql_fetch_assoc($sk)); ?>
          </table>
          <P class=icyazi>&nbsp;</P>
          </td>
         <td>&nbsp;</td>
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
<p align="center" class="copyright">&copy; 2006 - Bilgisayar ve ��retim Teknolojileri E�itimi B�l�m�</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($gk);

mysql_free_result($df);

mysql_free_result($sk);
?>
