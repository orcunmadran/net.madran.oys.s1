<?php
foreach($_POST AS $key => $value) { ${$key} = $value; } 
foreach($_GET AS $key => $value) { ${$key} = $value; }

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_iysconn = "localhost";
$database_iysconn = "lms_v1";
$username_iysconn = "root";
$password_iysconn = "123456";
$iysconn = mysql_pconnect($hostname_iysconn, $username_iysconn, $password_iysconn) or trigger_error(mysql_error(),E_USER_ERROR);

//Türkçe Karakter 
setlocale(LC_ALL, "tr_TR");
mysql_select_db($database_iysconn, $iysconn);
$SQL1 = "SET CHARACTER SET latin5";
$SQL2 = "SET NAMES 'latin5'";
$isle = mysql_query($SQL1, $iysconn) or die(mysql_error());
$isle2 = mysql_query($SQL2, $iysconn) or die(mysql_error());
?>