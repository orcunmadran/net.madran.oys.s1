<?php /* Smarty version 2.6.10, created on 2006-09-07 16:32:13
         compiled from user.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'user.tpl', 24, false),)), $this); ?>
<?php $this->assign('title', 'User'); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<center>
	
<?php if ($this->_tpl_vars['error']): ?>
<font color="red"><?php echo $this->_tpl_vars['error']; ?>
</font>
<?php endif; ?>
<?php if ($this->_tpl_vars['notice']): ?>
<font color="green"><?php echo $this->_tpl_vars['notice']; ?>
</font>
<?php endif; ?>
<?php if ($this->_tpl_vars['manageUsers']): ?>
	<div align="center"><br>This option is not available when FlashChat is integrated with a custom CMS (content management system).<br> Please use the user administration tools which come with your system to add, edit, or remove users.</div>
<?php else: ?>
<h4>user</h4>
<form name="user" action="user.php" method="post">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['_REQUEST']['id']; ?>
">
	<table border="0">
		<tr><td align="right">login</td><td><input type="text" name="login" value="<?php echo $this->_tpl_vars['_REQUEST']['login']; ?>
"></td></tr>
		<tr><td align="right">password</td><td><input type="text" name="password" value="<?php echo $this->_tpl_vars['_REQUEST']['password']; ?>
" ></td></tr>
		<tr>
			<td align="right">role</td>
			<td>
				<select name="roles">
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['roles'],'selected' => $this->_tpl_vars['_REQUEST']['roles']), $this);?>

				</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" name="add" value="Add new user">
					<input type="submit" name="set" value="Update user"
<?php if (! $this->_tpl_vars['_REQUEST']['id']): ?>
					disabled
<?php endif; ?>
					>
					<input type="submit" name="del" value="Remove user"
<?php if (! $this->_tpl_vars['_REQUEST']['id']): ?>
					disabled
<?php endif; ?>
					>
				</td>
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