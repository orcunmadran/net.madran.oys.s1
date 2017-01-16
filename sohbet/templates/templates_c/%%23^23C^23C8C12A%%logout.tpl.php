<?php /* Smarty version 2.6.10, created on 2006-09-07 16:32:29
         compiled from logout.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['installed']): ?>
<center>
	<h4>FlashChat Admin Panel Logout</h4>
	You've been logged out. <a href="index.php?<?php echo $this->_tpl_vars['rand']; ?>
">Click here to login</a>
</center>

<?php if (! $this->_tpl_vars['manageUsers']): ?>
	<p align=center>If you are using FlashChat integrated with a custom CMS (content management system), then you may still be logged in, depending on how your system stores user data.</p>
<?php endif; ?>
<?php else: ?>
<center>
	<font color="red">FlashChat is not installed.</font>
</center>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>