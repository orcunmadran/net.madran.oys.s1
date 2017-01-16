{include file=top.tpl}
<center>

{if $error}
<font color="red">{$error}</font>
{/if}
{if $installed}
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
{/if}
</center>

{include file=bottom.tpl}
