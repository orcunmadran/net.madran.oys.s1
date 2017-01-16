<?php /* Smarty version 2.6.10, created on 2006-09-07 16:31:43
         compiled from admin_index.tpl */ ?>
<?php $this->assign('title', 'Home');  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<center>
<h4>FlashChat Administration Panel</h4>
</center>
<p>This tool is designed to give FlashChat administrators multiple ways to view the chat logs, reset the chat logs, and add/edit/remove rooms. There are 

<?php if ($this->_tpl_vars['manageUsers']): ?>
	<?php echo $this->_tpl_vars['usrnumb']; ?>
 registered users, and 
<?php endif; ?>

<?php echo $this->_tpl_vars['msgnumb']; ?>
 logged messages. Configuration options for the chat can be set in the inc/config.php file, which comes with the FlashChat distribution.</p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>