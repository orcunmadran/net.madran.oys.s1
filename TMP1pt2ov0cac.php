<?php ?>
<?php
// *** Validate request to login to this site.
session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
  session_register('PrevUrl');
}

if (isset($_POST['kadi'])) {
  $loginUsername=$_POST['kadi'];
  $password=$_POST['sifre'];
  $MM_fldUserAuthorization = "kategori";
  $MM_redirectLoginSuccess = "giris.php";
  $MM_redirectLoginFailed = "giris_hata.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db("iys", mysql_pconnect("localhost","root","9360673"));
  	
  $LoginRS__query=sprintf("SELECT kadi, sifre, kategori FROM kullanici WHERE kadi='%s' AND sifre='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, mysql_pconnect("localhost","root","9360673")) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'kategori');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;     

    //register the session variables
    session_register("MM_Username");
    session_register("MM_UserGroup");

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<html>
<head>
<title>Sanal Kampüs - Baþkent Üniversitesi Eðitim Fakültesi</title>
<meta http-equiv="content-language" content="TR">
<meta http-equiv="content-type" content="text/html; charset=windows-1254">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<meta name="description" content="FW MX 2004 DW MX 2004 HTML">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Thu Jan 26 14:22:46 GMT+0200 (GTB Standard Time) 2006-->
<link href="iys.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #666666;
}
-->
</style></head>
<body>
<!--The following section is an HTML table which reassembles the sliced image in a browser.-->
<!--Copy the table section including the opening and closing table tags, and paste the data where-->
<!--you want the reassembled image to appear in the destination document. -->
<!--======================== BEGIN COPYING THE HTML HERE ==========================-->
<br>
<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="giris.png" fwbase="index.gif" fwstyle="Dreamweaver" fwdocid = "2077649383" fwnested="0" -->
  <tr>
<!-- Shim row, height 1. -->
   <td><img src="fw_giris/spacer.gif" width="128" height="1" border="0" alt=""></td>
   <td><img src="fw_giris/spacer.gif" width="384" height="1" border="0" alt=""></td>
   <td><img src="fw_giris/spacer.gif" width="128" height="1" border="0" alt=""></td>
   <td><img src="fw_giris/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr><!-- row 1 -->
   <td colspan="3"><img name="index_r1_c1" src="fw_giris/index_r1_c1.gif" width="640" height="30" border="0" alt=""></td>
   <td><img src="fw_giris/spacer.gif" width="1" height="30" border="0" alt=""></td>
  </tr>
  <tr><!-- row 2 -->
   <td colspan="3"><img name="index_r2_c1" src="fw_giris/index_r2_c1.gif" width="640" height="66" border="0" alt=""></td>
   <td><img src="fw_giris/spacer.gif" width="1" height="66" border="0" alt=""></td>
  </tr>
  <tr><!-- row 3 -->
   <td><img name="index_r3_c1" src="fw_giris/index_r3_c1.gif" width="128" height="288" border="0" alt=""></td>
   <td bgcolor="#FFFFFF"><form action="<?php echo $loginFormAction; ?>" method="POST" name="giris" id="giris">
     <table width="100%"  border="0" cellspacing="5" cellpadding="0">
       <tr>
         <td colspan="3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="3"><div align="center" class="baslik">SANAL KAMPÜS GÝRÝÞÝ </div></td>
         </tr>
       <tr>
         <td colspan="3"><div align="center" class="gorunmez">_</div></td>
         </tr>
       <tr>
         <td width="36%" class="arabaslik"><div align="right">Kullanýcý Adý </div></td>
         <td width="3%" class="arabaslik">:</td>
         <td width="61%"><input name="kadi" type="text" id="kadi" size="25" maxlength="60"></td>
       </tr>
       <tr>
         <td class="arabaslik"><div align="right">Þifre</div></td>
         <td class="arabaslik">:</td>
         <td><input name="sifre" type="password" id="sifre" size="20" maxlength="15"></td>
       </tr>
       <tr>
         <td colspan="3">
           <div align="center" class="gorunmez">_</div></td>
         </tr>
       <tr>
         <td colspan="3"><div align="center">
           <input name="Submit" type="submit" class="butongiris" value="Sisteme Giriþ">
         </div></td>
         </tr>
       <tr>
         <td colspan="3">&nbsp;</td>
       </tr>
     </table>
   </form>
    </td>
   <td><img name="index_r3_c3" src="fw_giris/index_r3_c3.gif" width="128" height="288" border="0" alt=""></td>
   <td><img src="fw_giris/spacer.gif" width="1" height="288" border="0" alt=""></td>
  </tr>
  <tr><!-- row 4 -->
   <td colspan="3"><img name="index_r4_c1" src="fw_giris/index_r4_c1.gif" width="640" height="96" border="0" alt=""></td>
   <td><img src="fw_giris/spacer.gif" width="1" height="96" border="0" alt=""></td>
  </tr>
<!--   This table was automatically created with Macromedia Fireworks   -->
<!--   http://www.macromedia.com   -->
</table>
<!--========================= STOP COPYING THE HTML HERE =========================-->
<p align="center"><span class="copyright">&copy; 2006 - Bilgisayar ve Öðretim Teknolojileri Eðitimi Bölümü</span></p>
</body>
</html>
