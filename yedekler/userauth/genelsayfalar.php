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
	
  $logoutGoTo = "../../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
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
?>
<html>
<head>
<title>Sanal Kamp�s - Ba�kent �niversitesi E�itim Fak�ltesi</title>
<meta http-equiv="content-language" content="TR">
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
</style></head>
<body bgcolor="#666666" onLoad="MM_preloadImages('../../fw_iys/sb_r2_c1_f2.gif','../../fw_iys/sb_r2_c4_f2.gif','../../fw_iys/sb_r2_c6_f2.gif','../../fw_iys/sb_r2_c8_f2.gif','../../fw_iys/sb_r2_c10_f2.gif','../../fw_iys/sb_r2_c12_f2.gif','../../fw_iys/sb_r2_c14_f2.gif','../../fw_iys/sb_r2_c16_f2.gif')">
<!--The following section is an HTML table which reassembles the sliced image in a browser.-->
<!--Copy the table section including the opening and closing table tags, and paste the data where-->
<!--you want the reassembled image to appear in the destination document. -->
<!--======================== BEGIN COPYING THE HTML HERE ==========================-->
<table width="955" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="sb.png" fwbase="sb.gif" fwstyle="Dreamweaver" fwdocid = "1301164485" fwnested="0" -->
  <tr>
<!-- Shim row, height 1. -->
   <td><img src="../../fw_iys/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="73" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="59" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="51" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="58" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="71" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="104" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="60" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="62" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="15" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="160" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="127" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="5" height="1" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr><!-- row 1 -->
   <td colspan="20"><img name="sb_r1_c1" src="../../fw_iys/sb_r1_c1.gif" width="955" height="31" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="1" height="31" border="0" alt=""></td>
  </tr>
  <tr><!-- row 2 -->
   <td colspan="2"><a href="#" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c1','','../../fw_iys/sb_r2_c1_f2.gif',1)"><img name="sb_r2_c1" src="../../fw_iys/sb_r2_c1.gif" width="78" height="25" border="0" alt="Anasayfa"></a></td>
   <td><img name="sb_r2_c3" src="../../fw_iys/sb_r2_c3.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="#" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c4','','../../fw_iys/sb_r2_c4_f2.gif',1)"><img name="sb_r2_c4" src="../../fw_iys/sb_r2_c4.gif" width="59" height="25" border="0" alt="Y�klendi�iniz dersleri g�r�nt�leyin"></a></td>
   <td><img name="sb_r2_c5" src="../../fw_iys/sb_r2_c5.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="#" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c6','','../../fw_iys/sb_r2_c6_f2.gif',1)"><img name="sb_r2_c6" src="../../fw_iys/sb_r2_c6.gif" width="51" height="25" border="0" alt="Mesaj al�p g�nderin"></a></td>
   <td><img name="sb_r2_c7" src="../../fw_iys/sb_r2_c7.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="#" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c8','','../../fw_iys/sb_r2_c8_f2.gif',1)"><img name="sb_r2_c8" src="../../fw_iys/sb_r2_c8.gif" width="58" height="25" border="0" alt="Sohbet odalar�na giri� yap�n"></a></td>
   <td><img name="sb_r2_c9" src="../../fw_iys/sb_r2_c9.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="#" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c10','','../../fw_iys/sb_r2_c10_f2.gif',1)"><img name="sb_r2_c10" src="../../fw_iys/sb_r2_c10.gif" width="71" height="25" border="0" alt="Tart��ma gruplar�na kat�l�n"></a></td>
   <td><img name="sb_r2_c11" src="../../fw_iys/sb_r2_c11.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="#" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c12','','../../fw_iys/sb_r2_c12_f2.gif',1)"><img name="sb_r2_c12" src="../../fw_iys/sb_r2_c12.gif" width="104" height="25" border="0" alt="Ki�isel bilgilerinizi g�r�nt�leyin ya da g�ncelleyin"></a></td>
   <td><img name="sb_r2_c13" src="../../fw_iys/sb_r2_c13.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="#" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c14','','../../fw_iys/sb_r2_c14_f2.gif',1)"><img name="sb_r2_c14" src="../../fw_iys/sb_r2_c14.gif" width="60" height="25" border="0" alt="Akademik ve Teknik birimlerle ileti�ime ge�in"></a></td>
   <td><img name="sb_r2_c15" src="../../fw_iys/sb_r2_c15.gif" width="15" height="25" border="0" alt=""></td>
   <td><a href="#" onMouseOut="MM_swapImgRestore();" onMouseOver="MM_swapImage('sb_r2_c16','','../../fw_iys/sb_r2_c16_f2.gif',1)"><img name="sb_r2_c16" src="../../fw_iys/sb_r2_c16.gif" width="62" height="25" border="0" alt="Yard�m al�n"></a></td>
   <td><img name="sb_r2_c17" src="../../fw_iys/sb_r2_c17.gif" width="15" height="25" border="0" alt=""></td>
   <td bgcolor="#000000"><div align="center" class="kimlik"><?php echo $row_gk['ad']; ?> <?php echo $row_gk['soyad']; ?></div></td>
   <td colspan="2"><a href="<?php echo $logoutAction ?>"><img name="sb_r2_c19" src="../../fw_iys/sb_r2_c19.gif" width="132" height="25" border="0" alt=""></a></td>
   <td><img src="../../fw_iys/spacer.gif" width="1" height="25" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td background="../../fw_iys/sb_r3_c1.gif"><img name="sb_r3_c1" src="../../fw_iys/sb_r3_c1.gif" width="5" height="489" border="0" alt=""></td>
   <td colspan="18" valign="top" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="5" cellpadding="5">
     <tr>
       <td class="icyazi"><p><a href="../../deneme.php">deneme</a></p>
         </td>
     </tr>
   </table>     <p>&nbsp;</p>
    </td>
   <td background="../../fw_iys/sb_r3_c20.gif"><img name="sb_r3_c20" src="../../fw_iys/sb_r3_c20.gif" width="5" height="489" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="1" height="489" border="0" alt=""></td>
  </tr>
  <tr><!-- row 4 -->
   <td colspan="20"><img name="sb_r4_c1" src="../../fw_iys/sb_r4_c1.gif" width="955" height="5" border="0" alt=""></td>
   <td><img src="../../fw_iys/spacer.gif" width="1" height="5" border="0" alt=""></td>
  </tr>
<!--   This table was automatically created with Macromedia Fireworks   -->
<!--   http://www.macromedia.com   -->
</table>
<!--========================= STOP COPYING THE HTML HERE =========================-->
<p align="center" class="copyright">&copy; 2006 - Bilgisayar ve ��retim Teknolojileri E�itimi B�l�m�</p>
</body>
</html>
<?php
mysql_free_result($gk);
?>
