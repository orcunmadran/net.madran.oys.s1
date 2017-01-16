<?php

error_reporting( E_ALL ^ E_NOTICE  );

include './install_files/consts.php'; 	// Constants
include './install_files/funcs.php';	// Needed functions
include './inc/config.php';				// FlashChat config

//error_reporting(0);

$step = $_GET['step'];

if( ! $step || $step<0 || $step>8) 
{
	$step = 1;
}

include "./install_files/step_$step.php";

?>