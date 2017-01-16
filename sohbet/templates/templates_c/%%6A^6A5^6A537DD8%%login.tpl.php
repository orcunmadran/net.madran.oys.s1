<?php /* Smarty version 2.6.10, created on 2006-09-07 16:31:38
         compiled from login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<center>

<?php if ($this->_tpl_vars['error']): ?>
<font color="red"><?php echo $this->_tpl_vars['error']; ?>
</font>
<?php endif;  if ($this->_tpl_vars['installed']): ?>
<h4>FlashChat Admin Panel Login</h4>
<form name="login" action="login.php" method="post">
<table border="0">
	<tr>
		<td align="right">login</td>
		<td><input type="text" name="login" value=""></td>
	</tr>
	<tr>
		<td align="right">password</td>
		<td><input type="password" name="password" value=""></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="do" value="Login"></td>
	</tr>
</table>
</form>
<?php endif; ?>
</center>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>