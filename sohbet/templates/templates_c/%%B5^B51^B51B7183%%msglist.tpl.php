<?php /* Smarty version 2.6.10, created on 2006-09-07 16:31:56
         compiled from msglist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'msglist.tpl', 12, false),)), $this); ?>
<?php $this->assign('title', 'Messages');  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<center>
	<h4>Messages</h4>
	<form name="msglist" id="msglist" action="msglist.php" method="post">
	<table border="0">
		<tr>
			<td align="right">in this room:</td>
			<td>
				<select name="roomid">
				<option value="0">[ Any room ]
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['rooms'],'selected' => $_REQUEST['roomid']), $this);?>

				</select>
			</td>
		</tr>
		<tr>
			<td align="right">between these dates:</td>
			<td><input type="text" name="from" value="<?php echo $_REQUEST['from']; ?>
" size="19">  and <input type="text" name="to" value="<?php echo $_REQUEST['to']; ?>
" size="19">(YYYY-MM-DD hh:mm:ss)</td>
		</tr>
		<tr>
			<td align="right">from the past X days:</td>
			<td><input type="text" name="days" value="<?php echo $_REQUEST['days']; ?>
" size="8"></td>
		</tr>
		<tr>
			<td align="right">by this user:</td>
			<td>
				<select name="userid">
				<option value="0">[ Any user ]
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['users'],'selected' => $_REQUEST['userid']), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td align="right" width="200">containing this keyword:</td>
				<td><input type="text" name="keyword" value="<?php echo $_REQUEST['keyword']; ?>
" size="32"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" name="apply" value="Show messages">
					<input type="submit" name="clear" value="Clear filter">
					<input type="hidden" id="sort" name="sort" value="none">
					<!--<input type="submit" name="remove" value="Remove messages">-->
				</td>
			</tr>
		</table>
	</form>

<?php if ($this->_tpl_vars['messages']): ?>

<table border="1">
	<tr>
		<th><a href="javascript:my_getbyid('sort').value = 'id'; my_getbyid('msglist').submit()">id</a></th>
		<th><a href="javascript:my_getbyid('sort').value = 'sent'; my_getbyid('msglist').submit()">sent</a></th>
		<th><a href="javascript:my_getbyid('sort').value = 'user'; my_getbyid('msglist').submit()">from user</a></th>
		<th><a href="javascript:my_getbyid('sort').value = 'toroom'; my_getbyid('msglist').submit()">to room</a></th>
		<th><a href="javascript:my_getbyid('sort').value = 'touser'; my_getbyid('msglist').submit()">to user</a></th>
		<th>txt</th>
	</tr>

<?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>
	<tr>
		<td><?php echo $this->_tpl_vars['message']['id']; ?>
</td>
		<td><?php echo $this->_tpl_vars['message']['sent']; ?>
</td>
		<td>
		<?php echo $this->_tpl_vars['message']['user']; ?>

		</td>
		<td><a href="room.php?id=<?php echo $this->_tpl_vars['message']['toroomid']; ?>
"><?php echo $this->_tpl_vars['message']['toroom']; ?>
</a></td>
		<td>
		<?php echo $this->_tpl_vars['message']['touser']; ?>

		</td>
		<td><?php echo $this->_tpl_vars['message']['txt']; ?>
</td>
	</tr>
<?php endforeach; endif; unset($_from);  else: ?>
	No messages found
<?php endif; ?>

</center>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>