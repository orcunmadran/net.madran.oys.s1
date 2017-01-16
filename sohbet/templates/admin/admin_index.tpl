{assign var=title value=Home}
{include file=top.tpl}
<center>
<h4>FlashChat Administration Panel</h4>
</center>
<p>This tool is designed to give FlashChat administrators multiple ways to view the chat logs, reset the chat logs, and add/edit/remove rooms. There are 

{if $manageUsers}
	{$usrnumb} registered users, and 
{/if}

{$msgnumb} logged messages. Configuration options for the chat can be set in the inc/config.php file, which comes with the FlashChat distribution.</p>

{include file=bottom.tpl}
