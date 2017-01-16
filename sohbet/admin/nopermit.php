<?php
require_once('init.php');

global $tabName;

//Assign Smarty variables and load the admin template
$smarty->assign('title', $tabName); 
$smarty->display('nopermit.tpl');
?>