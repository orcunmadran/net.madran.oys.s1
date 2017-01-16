<?php

$rooms = $_POST['rooms'] ? $_POST['rooms'] : CHAT_ROOMS;

$errmsg = '';

if( $_POST['conf_msgRequestInterval'] != '' )
{
	if( ! is_numeric($_POST['conf_msgRequestInterval']) || strpos($_POST['conf_msgRequestInterval'],'.') !== false ) $errmsg = 'Incorrect <b>Request interval</b> value';
}

$useCMS = false;
if( isset($cmss[$GLOBALS['fc_config']['CMSsystem']]) )
{
	$useCMS = true;
}


if( $_POST['submit'] && $errmsg == '')
{

	//save rooms
	$rms = split(',\W*', $rooms);
	$dbpref = '';
	$errmsg = connectToDB('','','','', $dbpref);

	if($errmsg == '')
	{
		for($i = 0; $i < sizeof($rms); $i++)
		{
				$rms[$i] = trim($rms[$i]);

				//check if room exists
				$res = mysql_query("SELECT * FROM {$dbpref}rooms WHERE name='{$rms[$i]}'");
				if( mysql_num_rows($res) ) continue;
				//---

				if(!mysql_query("INSERT INTO {$dbpref}rooms (created, name, ispublic, ispermanent) VALUES (NOW(), '{$rms[$i]}', 'y', '" . ($i + 1) . "')"))
				{
					$errmsg = "<b>Could not create room '{$rms[$i]}'<br>" . mysql_error() . "</b><br>";
					break;
				}
		}
	}
	//---

	//change config.php
	$repl['liveSupportMode']    = $_POST['conf_liveSupportMode']?'true':'false';
	$repl['defaultLanguage']    = "'{$_POST['conf_defaultLanguage']}'";
	$repl['msgRequestInterval'] = $_POST['conf_msgRequestInterval'];
	$repl['loginUTF8decode']    = $_POST['login_utf'];

	if( ! $useCMS ) $repl['CMSsystem'] = "''";

	$conf = getConfigData();
	$conf = changeConfigVariables($conf,$repl);
	//store languages
	$all_lang = $GLOBALS['fc_config']['languages'];
	//---
	writeConfig($conf);
	include './inc/config.php';
	$GLOBALS['fc_config']['languages'] = $all_lang;


	//finish step
	$step = 6;

	//change CMS
	if( $_POST['cms'] == 'defaultCMS' )
	{
		$step = 4;
	}

	if( $useCMS )
	{
		$step = 6;
	}

	if( $errmsg == '' )
	{
		//redirect_inst to step 3
		redirect_inst("install.php?step=$step");
	}
}

include INST_DIR . 'header.php';
?>



<TR>
	<TD colspan="2"></TD>
</TR>
<TR>
	<TD colspan="2" class="subtitle">Step 3: Chat Configuration</TD>
</TR>
<TR>
	<TD colspan="2" class="normal">	To help you configure FlashChat for the first time, input some information about how you would like the chat to operate. This step will write some configuration data to the /inc/config.php file.
	</TD>
</TR>


<tr><td colspan=2 class="error_border"><font color="red"><?php echo @$errmsg; ?></font></td></tr>

<FORM action="install.php?step=3" method="post" align="center" name="installInfo">
	<TR>
		<TD colspan="2">
			<TABLE width="100%" class="body_table" cellspacing="10">
			<?php if( !$useCMS ) { ?>
				<TR>
					<TD width="30%" align="right" valign=top>
						How would you like to use FlashChat?
					</td>
					<td>

					<table width="100%" class="normal">
					<tr>
						<td valign="top"><INPUT type="radio" name="cms" value="statelessCMS" CHECKED></td>
						<td>As a free-for-all chatroom, where users can chat without registering or creating a profile (so-called "stateless CMS")</td>
					</tr>
					<tr>
						<td valign="top"><INPUT type="radio" name="cms" value="defaultCMS"></td>
						<td>As a registered users-only chatroom. Users must register and create a profile before being allowed to chat (so-called "default CMS")</td>
					</tr>
					<!--
					<tr>
						<td valign="top"><INPUT type="radio" name="cms" value=""></td>
						<td>I have a content-management system (CMS), like phpNuke, Mambo, phpBB, or other system, that I want to integrate with FlashChat</td>
					</tr>
					-->
					</table>

					</TD>

				</TR>

				<TR>
					<TD width="30%" align="right">Room List (comma delimited):
					</TD>
					<TD>
						<INPUT type="text"  size="100%" name="rooms" value="<?php echo $rooms ?>">
					</TD>
				</TR>

			<?php }	?>


				<TR>
					<TD colspan=2>Some systems use UTF-8 encoding for user names. If you are using a system with non-English character sets, you may need to enable UTF-8 decoding for user names. Would you like to enable it now?:
					</TD>
				</TR>
				<TR>
					<td></td>
					<TD>
						<table width="100%" class="normal" border=0>
							<tr>
								<td valign="top" width="2"><INPUT type="radio" name="login_utf" value="false" CHECKED></td>
								<td>No, do not enable UTF-8 at this time.</td>
							</tr>
							<tr>
								<td valign="top" width="2"><INPUT type="radio" name="login_utf" value="true"></td>
								<td>Yes, please enable UTF-8</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan=2>
								If you discover that UTF-8 conversions are needed, you can enable it later by setting the loginUTF8decode value in /inc/config.php to true.
					</td>
				</TR>

				<TR>
					<TD align="right">Live support mode:
					</TD>
					<TD>
						<INPUT type="checkbox" name="conf_liveSupportMode" value="1"
						<?php echo $_POST['conf_liveSupportMode']?'CHECKED': ($GLOBALS['fc_config']['liveSupportMode']?'CHECKED':'');
						?>> Check here to use FlashChat as a customer support system.
					</TD>
				</TR>


				<TR>
					<TD align="right" nowrap>Default language:
					</TD>
					<TD valign="top">
						<SELECT name="conf_defaultLanguage">
						<?php
							foreach($GLOBALS['fc_config']['languages'] as $k=>$v)
							{
								if($GLOBALS['fc_config']['defaultLanguage'] == $k)$sel = 'SELECTED';
								else $sel = '';

								echo "<option value=\"$k\" $sel>{$v['name']}";
							}
						?>
						</SELECT>
					</TD>
				</TR>

				<TR>
					<TD width="30%" align="right">Request interval:
					</TD>
					<TD>
						<INPUT type="text" size="5" name="conf_msgRequestInterval" value="<?php echo $_POST['conf_msgRequestInterval']?$_POST['conf_msgRequestInterval']:$GLOBALS['fc_config']['msgRequestInterval']; ?>">(seconds)
					</TD>
				</TR>
		</TD>
	</TR>
</TABLE>
	<TR>
		<TD>&nbsp;</TD>
		<TD align="right">
			<INPUT type="submit" name="submit" value="Continue >>" onClick="javascript:return fieldsAreValid();">
		</TD>
	</TR>
</FORM>


	<tr>
	<td colspan="2">

	<p class="subtitle">More About Configuring FlashChat</p>

The options listed above are to help you get started with FlashChat. When you click Continue, some of the options in config.php will be set for you. However, you may change many more options after installation by directly editing the PHP files that come with FlashChat. Here are a few tips...

<p>
<b> Language Settings </b><br>
To disable or re-order a language, edit the /inc/config.php file. To change the text of a language, edit the appropriate langauge file in /inc/langs/
</p>

<p>
<b>Interface Layout </b><br>
To disable or re-arrange elements of the FlashChat interface, edit the /inc/layouts/ files. Use 'users.php' for general chatters, and admin.php for moderators.
</p>

<p>
<b>Colors and Themes</b><br>
To change the colors of FlashChat's 'themes', edit the files in /inc/themes. To change the background image for any theme, edit the appropriate JPG file in the /images folder. Be sure to use only non-progressive JPG files.
</p>

<p>
<b>Sounds</b><br>
You may use your own MP3 files with FlashChat by replacing any MP3 file in the /sounds folder. To set the default sound configuration, edit the appropriate options in /inc/config.php
</p>

<p>
<b>Integrating with your Database</b><br>
If you have a database of users that you would like to use with FlashChat, or if you are having difficult integrating FlashChat with an existing system like phpBB or Mambo, you may wish to edit the appropriate PHP file in the /inc/cmses folder.
</p>

<p>
<b>Other Options</b><br>
The best thing to do is simply open the /inc/config.php file and browse through the various options that are available to you. There are a lot! You will see that FlashChat is the most versatile and flexible chat room around. Be careful that you do not introduce any PHP errors when editing these PHP files.
</p>
	</td>
	</tr>



<?php
include INST_DIR . 'footer.php';
?>