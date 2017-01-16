<?php

if($_POST['useCMS'])
{
	//redirect_inst to step 3
	redirect_inst('install.php?step=1.6');
}

require_once './inc/config.srv.php';

$useCMS = isset($_GET['forcms']) ? $_GET['forcms'] : $_POST['forcms'];

if( $useCMS )
{
	include('./inc/common.php');
	chatServer::loadCMSclass();
}
else
{
	$repl['CMSsystem'] = "''";
	$conf = getConfigData();
	$conf = changeConfigVariables($conf,$repl);
	writeConfig($conf);
}

error_reporting( E_ALL ^ E_NOTICE );

$dbname = $_POST['name'] ? $_POST['name'] : $GLOBALS['fc_config']['db']['base'];
$dbuser = $_POST['user'] ? $_POST['user'] : $GLOBALS['fc_config']['db']['user'];
$dbpass = $_POST['password'] ? $_POST['password'] : $GLOBALS['fc_config']['db']['pass'];
$dbhost = $_POST['host'] ? $_POST['host'] : ($GLOBALS['fc_config']['db']['host'] ? $GLOBALS['fc_config']['db']['host'] :(!$useCMS ? 'localhost' : ''));
$dbpref = $_POST['dbPrefix'] ? $_POST['dbPrefix'] : ($GLOBALS['fc_config']['db']['pref'] ? $GLOBALS['fc_config']['db']['pref'] : 'flashchat_');

$errmsg = '';

$rooms = $_POST['rooms'] ? $_POST['rooms'] : CHAT_ROOMS;

$cmsError = false;
if( $useCMS )
{
	if( $dbname == '' || $dbuser == '' || $dbhost == '' ) $cmsError = true;
}

if( $_POST['submit_no_update'] )
{
	redirect_inst('install.php?step=1');
	exit;
}

if( $_POST['submit_update'] )
{
	$errmsg = createTables(true);

	if($useCMS && $errmsg == '')
	{
		//create
		$errmsg = createRooms();
		//---		
	}
	
	//---ROOMS UPDATE
	@mysql_query("ALTER TABLE `{$dbpref}rooms` ADD `password` VARCHAR(32)  NOT NULL AFTER name");
	//---	
}


if( $_POST['submit'] )
{

	//---check for existing tables
	$res = checkForUpdate();

	if( is_string( $res ) ) $errmsg = $res;
	elseif( is_array($res) && sizeof($res) != 0)
	{
		$duplicated_tables = $res;
		$show_update = true;
	}
	else
	{
		$errmsg = createTables();

		if($useCMS && $errmsg == '')
		{
			//create
			$errmsg = createRooms();
			//---
		}

	}
	//---

}

function checkForUpdate()
{
	global $dbname, $dbuser, $dbpass, $dbhost, $dbpref, $useCMS, $db_tables;

	$errMsg = connectToDB($dbname, $dbuser, $dbpass, $dbhost, $dbpref);
	if($errMsg != '') return $errMsg;

	$tables = db_get_array('SHOW TABLE STATUS', 'Name');

	$res_tables = array();

	foreach( $db_tables as $k=>$v )
	{
		$tables2[$dbpref . $k] = $v;
		if( isset( $tables[$dbpref . $k] ) ) $res_tables[] = $dbpref . $k;
	}

	return $res_tables;

}

function createTables($update=false)
{
	global $dbname, $dbuser, $dbpass, $dbhost, $dbpref, $useCMS, $db_tables;

	$errMsg = connectToDB($dbname, $dbuser, $dbpass, $dbhost, $dbpref);
	if($errMsg != '') return $errMsg;

		//Write the system configuration
		$filename = './inc/config.srv.php';
		if($handle = fopen($filename, 'w+')) {
			$str  = "<?php\n";
			$str .= "\t\$GLOBALS['fc_config']['db'] = array(\n";
			$str .= "\t\t'host' => '$dbhost',\n";
			$str .= "\t\t'user' => '$dbuser',\n";
			$str .= "\t\t'pass' => '$dbpass',\n";
			$str .= "\t\t'base' => '$dbname',\n";
			$str .= "\t\t'pref' => '$dbpref',\n";
			$str .= "\t);\n";
			$str .= "?>";

			if(fwrite($handle, $str)) {
				fclose($handle);
			} else {
				return "<b>Could not write to '$filename' file</b>";
			}
		} else {
			return "<b>Could not open '$filename' file for writing</b>";
		}


		foreach($db_tables as $k=>$str)
		{
			if ( $useCMS && $k == "users" )//skip this table
				continue;

			$str = str_replace('{dbpref}', $dbpref, $str);

			if(@mysql_query($str) === false && $update != true)
			{
				return "<b>Could not create DB table '{$dbpref}$k' </b><br>" . mysql_error();
			}

		}

	 return '';
}

function createRooms()
{
	global $dbpref, $rooms;
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
					return "<b>Could not create room '{$rms[$i]}'</b><br>";
					break;
				}
		}
	}

	return $errmsg;

}


if( ($_POST['submit'] || $_POST['submit_update']) && $errmsg=='' && $useCMS && !$show_update)
{
		//redirect_inst to step 3
		redirect_inst('install.php?step=3');
}

if( ($_POST['submit'] || $_POST['submit_update']) && $errmsg=='' && !$show_update)
{
		//redirect_inst to step 3
		redirect_inst('install.php?step=3');
}

include INST_DIR . 'header.php';

?>


<TR>
	<TD colspan="2">
	</TD>
</TR>
<TR>
	<TD colspan="2" class="subtitle">Step 2: Database Configuration
	</TD>
</TR>
<TR>
	<TD colspan="2" class="normal">The FlashChat installer needs some information about your database to finish the installation. If you do not know this information, then please contact your website host or administrator. Please note that this is probably NOT the same as your FTP login information!

	<?php
	if( $useCMS )
	{
	?>
	<p>
	You have indicated that you wish to integrate FlashChat with <b><?php echo $cmss[$useCMS];?></b>. Please refer to the full integration instructions located
	in the <a href="http://www.tufat.com/wiki/" target="_blank">TUFaT.com Wiki</a>. There are additional steps to complete after this installer is finished.
	</p>

	<?php if( ! $cmsError ) { ?>

	<p>
	The correct login values for your MySQL server should be auto-entered into the form below. If they are not, then you should check to ensure that FlashChat
	is uploaded to the correct location on your server, and that you are using a supported version of the CMS system or bulletin board.
	</p>

	<?php } else { ?>

	<p>
	<FONT color="#FF0000">
		<b>Configuration Error!</b><br><br>
		FlashChat was unable to detect your MySQL login setting from the <b><?php echo $cmss[$useCMS];?></b> configuration file. You must correct this before FlashChat can finish its installation.
		Please refer to the integration Instructions in the <a href="http://www.tufat.com/wiki/" target="_blank">TUFaT.com Wiki</a> to ensure that the FlashChat files were correctly uploaded to your server.
		<br><br>
		Possible Reasons for this error may include:<br><br>

		1) FlashChat was uploaded to an incorrect server location.<br>
		2) The CMS system that you are using is unsupported by FlashChat.<br>
		3) Your server has incompatible settings which may have been undetected in Step 1 of the FlashChat installer. For example, specific security restrictions which are not typical of most PHP/MySQL setups.
	</FONT>
	</p>

	<?php
		}
	}
	?>
	</TD>
</TR>


<tr><td colspan=2 class="error_border"><font color="red"><?php echo @$errmsg; ?></font></td></tr>

<FORM action="install.php?step=2" method="post" align="center" name="installInfo">

	<?php if($show_update){ ?>
	<tr>
		<td colspan="2">
			<TABLE width="100%" class="body_table" cellspacing="10">
			<TR><TD>
			<p>The FlashChat installer has detected that the following database tables already exist.<br>
			Based on the information that you inputted, these are likely to be FlashChat tables.
			</p>
			<p>
			<font color="blue">
				<?php  foreach($duplicated_tables as $v) echo $v . '<br>'; ?>
			</font>
			</p>
			<p>
			Would you like to upgrade your current FlashChat installation? This action will add fields that are missing from the the existing tables, and
			add any missing tables. Tables and fields are not removed during this process, and existing data is not removed. Thus, your current chat rooms,
			users, bots, and messages will be preserved.
			</p>
			<p>
			If you are unsure whether these tables are related to FlashChat, then you are advised to check with your website administrator, or use a MySQL access
			tool like phpFlashMyadmin to backup the table contents before continuing.
			</p>

			<INPUT type="submit" name="submit_update" <?php if($cmsError) echo 'disabled'; ?> value="Yes, Continue" onClick="javascript:return fieldsAreValid('password dbPrefix');">
			&nbsp;&nbsp;&nbsp;<INPUT type="submit" name="submit_no_update" value="No, Do Not Continue" >

			</TD>
			</tr>
			</table>

		</td>
	</tr>

	<?php } ?>
	<TR>
		<TD colspan="2">
			<TABLE width="100%" class="body_table" cellspacing="10">

				<TR>
					<TD width="30%" align="right">Database Name:
					</TD>
					<TD>
						<INPUT type="text" size="40" name="name" value="<?php echo $dbname ?>" <?php if($useCMS) echo 'disabled';?>>
					</TD>
				</TR>
				<TR>
					<TD align="right">						Database User:
					</TD>
					<TD>
						<INPUT type="text" size="40" name="user" value="<?php echo $dbuser ?>" <?php if($useCMS) echo 'disabled';?>>
					</TD>
				</TR>
				<TR>
					<TD nowrap align="right">						Database Password:
					</TD>
					<TD valign="top">
						<INPUT type="password" size="40" name="password" value="<?php echo $dbpass ?>" <?php if($useCMS) echo 'disabled';?>>
					</TD>
				</TR>
				<TR>
					<TD align="right">						Database Host:
					</TD>
					<TD>
						<INPUT type="text" size="40" name="host" value="<?php echo $dbhost ?>" <?php if($useCMS) echo 'disabled';?>>
					</TD>
				</TR>

				<TR>
					<TD align="right">						Table Prefix:
					</TD>
					<TD valign="top">
						<INPUT type="text" size="40" name="dbPrefix" value="<?php echo $dbpref ?>" <?php if($useCMS) echo 'disabled';?>>
					</TD>
				</TR>
				<TR>
					<TD colspan="2">This prefix will be prepended to any table names that the FlashChat installer creates. <?php if(! $useCMS ){?> You may leave this blank if desired. <?php }?>
					</TD>
				</TR>

				<?php if( $useCMS ){?>

				<TR>
					<TD align="right">	Room List (separated by commas):
					</TD>
					<TD valign="top">
						<INPUT type="text"  size="80" name="rooms" value="<?php echo $rooms ?>">
					</TD>
				</TR>

				<?php }?>

		</TD>
	</TR>
</TABLE>
	<TR>
		<TD>			&nbsp;
		</TD>
		<TD align="right">
			<INPUT type="submit" name="submit" <?php if($cmsError) echo 'disabled'; ?> value="Continue >>" onClick="javascript:return fieldsAreValid('password dbPrefix');">
			<INPUT type="hidden" name="forcms" value="<?php echo $useCMS;?>">
		</TD>
	</TR>
</FORM>

<?php
include INST_DIR . 'footer.php';
?>
