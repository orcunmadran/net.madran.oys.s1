<?php /* Smarty version 2.6.10, created on 2006-09-07 16:31:46
         compiled from usrlist.tpl */ ?>
<?php $this->assign('title', 'Users');  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['manageUsers']): ?>
<div align="center"><br>This option is not available when FlashChat is integrated with a custom CMS (content management system).<br> Please use the user administration tools which come with your system to add, edit, or remove users.</div>
<?php else: ?>
<center>
	<form name="usrlist" id="usrlist" action="usrlist.php" method="post">
		<input type="hidden" id="sort" name="sort" value="none">
	</form>
	<h4>Users</h4>
	<a href="user.php">Add new user</a><br>
	<br>
<?php if ($this->_tpl_vars['users']): ?>
	<table border="1">
		<tr>
			<th><a href="javascript:my_getbyid('sort').value = 'id'; my_getbyid('usrlist').submit()">id</a></th>
			<th><a href="javascript:my_getbyid('sort').value = 'login'; my_getbyid('usrlist').submit()">login</a></th>
			<th><a href="javascript:my_getbyid('sort').value = 'password'; my_getbyid('usrlist').submit()">password</a></th>
			<th><a href="javascript:my_getbyid('sort').value = 'roles'; my_getbyid('usrlist').submit()">role</a></th>
		</tr>
	<?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
		<tr>
			<td><?php echo $this->_tpl_vars['user']['id']; ?>
</td>
			<td><a href="user.php?id=<?php echo $this->_tpl_vars['user']['id']; ?>
"><?php echo $this->_tpl_vars['user']['login']; ?>
</a></td>
			<td><?php echo $this->_tpl_vars['user']['password']; ?>
&nbsp;</td>
			<td><?php echo $this->_tpl_vars['user']['roles']; ?>
</td>
		</tr>
	<?php endforeach; endif; unset($_from);  else: ?>
	No users found
<?php endif; ?>
</center>
<?php endif;  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>