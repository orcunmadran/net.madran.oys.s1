<?php /* Smarty version 2.6.10, created on 2006-09-07 16:31:38
         compiled from top.tpl */ ?>
<html>
	<head>
		<title>FlashChat Admin Panel - <?php echo $this->_tpl_vars['title']; ?>
</title>
		<meta http-equiv=Content-Type content="text/html;  charset=UTF-8">
		<script language="javascript" src="funcs.js"></script>
	</head>

	<?php echo '
	<style type=text/css>
		<!--
		BODY {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 11px;
		}
		TD {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 11px;
		}
		TH {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 11px;
			font-weight: bold;
		}
		INPUT {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 11px;
		}
		SELECT {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 11px;
		}
		A {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			color: #0000FF;
		}
		A:hover {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			color: #FF0000;
		}
		-->
	</style>
	'; ?>

<body>
		<center>
			<a href="index.php?<?php echo $this->_tpl_vars['rand']; ?>
">Home</a> |
			<a href="msglist.php?<?php echo $this->_tpl_vars['rand']; ?>
">Messages</a> |
			<a href="chatlist.php?<?php echo $this->_tpl_vars['rand']; ?>
">Chats</a> |
			<a href="usrlist.php?<?php echo $this->_tpl_vars['rand']; ?>
">Users</a> | 
			<a href="roomlist.php?<?php echo $this->_tpl_vars['rand']; ?>
">Rooms</a> |
			<a href="connlist.php?<?php echo $this->_tpl_vars['rand']; ?>
">Connections</a> |
			<a href="banlist.php?<?php echo $this->_tpl_vars['rand']; ?>
">Bans</a> |
			<a href="ignorelist.php?<?php echo $this->_tpl_vars['rand']; ?>
">Ignores</a> |
			<a href="botlist.php?<?php echo $this->_tpl_vars['rand']; ?>
">Bots</a> |
			<a href="uninstall.php?<?php echo $this->_tpl_vars['rand']; ?>
">Un-install</a> |
			<a href="logout.php?<?php echo $this->_tpl_vars['rand']; ?>
">Logout</a>
		</center>
		<hr>