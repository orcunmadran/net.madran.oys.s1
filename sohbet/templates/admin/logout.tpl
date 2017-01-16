{include file=top.tpl}

{if $installed}
<center>
	<h4>FlashChat Admin Panel Logout</h4>
	You've been logged out. <a href="index.php?{$rand}">Click here to login</a>
</center>

{if !$manageUsers}
	<p align=center>If you are using FlashChat integrated with a custom CMS (content management system), then you may still be logged in, depending on how your system stores user data.</p>
{/if}
{else}
<center>
	<font color="red">FlashChat is not installed.</font>
</center>
{/if}
{include file=bottom.tpl}
