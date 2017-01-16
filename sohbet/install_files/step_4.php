<?php

if( $_POST['submit'] )
{
		$step = 6;
		
		//default cms		
		$new_val = 'defaultCMS';
		//---
		
		if( $_POST['cms'] == 'user')
		{	//existing table
			$step = 5;			
			$new_val = 'defaultUsrExtCMS';
		}				 
		
		//default CMS			
		$repl['CMSsystem']   = "'$new_val'";
		$repl['encryptPass'] = $_POST['enc_pass'];
		
		$conf = getConfigData();		
		$conf = changeConfigVariables($conf,$repl);	
		$res = writeConfig($conf);
		if(!$res) $errmsg = "<b>Could not write to '/inc/config.php' file</b>";
		//---		
		
		if( $errmsg == '' )
		{
			//redirect_inst to step 3
			echo '<script language="JavaScript" type="text/javascript">
				<!--// redirect_inst
		  			window.location.href = "install.php?step='. $step .'";
				//-->
			    </script>
			';
	
			die;	
		}	
}


//get tables prefix
require_once './inc/config.srv.php';
$dbpref = $GLOBALS['fc_config']['db']['pref'];
//---	

include INST_DIR . 'header.php';


?>

<TR>
	<TD colspan="2"></TD>
</TR>
<TR>
	<TD colspan="2" class="subtitle">Step 4: DefaultCMS</TD>
</TR>
<TR>
	<TD colspan="2" class="normal">
	<p>
	You have chosen the "defaultCMS" option for using FlashChat. This means that some existing table in your database will be used to store user information. FlashChat comes with its own "users" table, but you may override this choice by using your own user table.
	</p>
	<p>
	If you choose to use your own table, then you must also have your own profile viewing and user registration pages, since the fields may differ from those in FlashChat's user table.
	</p>

	</TD>
</TR>


<tr><td colspan=2 class="error_border"><font color="red"><?php echo @$errmsg; ?></font></td></tr>

<FORM action="install.php?step=4" method="post" align="center" name="installInfo">
	<TR>
		<TD colspan="2">
			<TABLE width="100%" class="body_table" border="0">
			<tr><td>
			<TABLE width="80%" class="normal" border="0" align="center" cellpadding="5" cellspacing="0">
				<TR>					
					<TD align="right" valign="top"><INPUT type="radio" name="cms" value="default" CHECKED></td>
					<td>I want to use FlashChat's users table, <?php echo($dbpref); ?>users. When users register, a new record will be added to this table. FlashChat's profile.php file will be used to view user profiles.
						<table class="normal" border=0>
						<tr><td>Encrypt Passwords in the Database?</td></tr>
						<tr >
							
							<td nowrap valign="top" ><INPUT type="radio" name="enc_pass" value="1" CHECKED> Yes, use encryption <INPUT type="radio" name="enc_pass" value="0"> No, do not use encryption</td>
							
						</tr>						
						</table>
					</td>						
				</TR>
				
				<tr>
					<td align="right" valign="top"><INPUT type="radio" name="cms" value="user"></TD>
					<td>I have an existing table which I want to use with FlashChat. Users must exist in this table before they can login. Also, I have my own registration and profile PHP files, which should be used instead of FlashChat's files.
</td>
				</tr>
				</TABLE>
				</td></tr>
			</TABLE>
		</td>	
		</tr>
	<TR>
		<TD>&nbsp;</TD>
		<TD align="right">
			<INPUT type="submit" name="submit" value="Continue >>">
		</TD>
	</TR>
</FORM>		
	<tr>
	<td colspan="2">
	
	</td>
	</tr>
	


<?php 
include INST_DIR . 'footer.php';
?>