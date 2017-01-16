<?php require_once('../Connections/iysconn.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "oku")) {
  $updateSQL = sprintf("UPDATE mesajlar SET okundu=%s WHERE mesajno=%s",
                       GetSQLValueString($_POST['okundu'], "int"),
                       GetSQLValueString($_POST['mesajno'], "int"));

  mysql_select_db($database_iysconn, $iysconn);
  $Result1 = mysql_query($updateSQL, $iysconn) or die(mysql_error());

  $updateGoTo = "mesaj.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_oku = "-1";
if (isset($_GET['mesajno'])) {
  $colname_oku = (get_magic_quotes_gpc()) ? $_GET['mesajno'] : addslashes($_GET['mesajno']);
}
mysql_select_db($database_iysconn, $iysconn);
$query_oku = sprintf("SELECT * FROM mesajlar WHERE mesajno = %s", $colname_oku);
$oku = mysql_query($query_oku, $iysconn) or die(mysql_error());
$row_oku = mysql_fetch_assoc($oku);
$totalRows_oku = mysql_num_rows($oku);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-language" content="TR">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Sanal Kampüs - Baþkent Üniversitesi Eðitim Fakültesi</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<style type="text/css">
<!--
body {
	background-color: #666666;
}
-->
</style></head>

<body onactivate="MM_callJS('document.oku.submit()')">
<form action="<?php echo $editFormAction; ?>" method="POST" name="oku" id="oku">
  <input name="mesajno" type="hidden" id="mesajno" value="<?php echo $row_oku['mesajno']; ?>">
  <input name="okundu" type="hidden" id="okundu" value="1">
  <input type="hidden" name="MM_update" value="oku">
</form>
</body>
</html>
<?php
mysql_free_result($oku);
?>
