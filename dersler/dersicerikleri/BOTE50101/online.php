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

$MM_restrictGoTo = "../../../giris_yetki_yok.php";
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0061)http://www.enocta.com.tr/tr/DemoCourses/KPGE_PROCOZ/start.htm -->
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-1254">
<META content="MSHTML 6.00.2900.2722" name=GENERATOR><title>Sanal Kampüs - Baþkent Üniversitesi Eðitim Fakültesi</title></HEAD>
<BODY text=#000000 bgColor=#000000 leftMargin=0 topMargin=0 scroll=no 
onunload="if (top.window.opener) top.window.opener.history.go(0);" 
marginheight="0" marginwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD align=middle>
      <SCRIPT language=JavaScript1.1>
	<!--
	      // Name the variables
	      flName = "online.swf"
	      flColor = "#FFFFFF"
	      flHeight = "600"
	      flWidth = "800"
	      // This portion of the script is a modified version of Colin Moock's
	      // flash cookie importer, query string version script.
	      // Slight modifications have been made to
	      // work with the get cookies script.

		document.write("<table width=" + flWidth + " cellpadding=0 cellspacing=0><tr><td valign=top height="+flHeight+" bgcolor=#FFFFFF>");
		//document.write("<div id=player style='width:100%;height:400;overflow:hidden'>");
		document.write(
			'<OBJECT '
			+  'classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'
			+ ' codebase="http://active.macromedia.com/flash2/'
			+ 'cabs/swflash.cab#version=5,0,0,0"'
			+ ' ID="Egiteam"'
			+ ' WIDTH=' + flWidth
			+ ' HEIGHT=' + flHeight + '>'
			+ '<PARAM NAME=movie VALUE="' + flName + '">'
			+ '<PARAM NAME=quality VALUE=high>'
			+ '<PARAM NAME=menu VALUE=false>'
			+ '<PARAM NAME=bgcolor VALUE=' + flColor + '>'
			//+ '<PARAM NAME=FlashVars VALUE=' + cookString.substr(1) + '>'
			//+ '<PARAM NAME=wmode VALUE=transparent>'
			+ '<EMBED src="online.swf' + '"'
			+ ' name="flash"'
			+ ' quality=high bgcolor=' + flColor
			+ ' WIDTH=' + flWidth
			+ ' HEIGHT=' + flHeight
			+ ' TYPE="application/x-shockwave-flash"'
			+ ' PLUGINSPAGE="http://www.macromedia.com/shockwave/'
			+ 'download/index.cgi?P1_Prod_Version=ShockwaveFlash">'
			+ '</EMBED></OBJECT>'
		);
		//document.write("</div>");
		document.write("</td></tr></table>");
	// -->
	</SCRIPT>
      <SCRIPT language=JavaScript>
	function ActualizateWindow()
	{
		x = (screen.width-flWidth)/2;
		y = (screen.height-flHeight)/2;
		top.window.resizeTo(flWidth, flHeight);
		top.window.moveTo(x, y);
	}
	function ActualizateWindow2()
	{
		x = (screen.width);
		y = (screen.height);
		top.window.moveTo(0, 0);
		top.window.resizeTo(x, y);
	}
	
	</SCRIPT>
    </TD></TR></TBODY></TABLE></BODY></HTML>
