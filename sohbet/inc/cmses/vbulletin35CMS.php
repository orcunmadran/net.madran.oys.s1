<?php
/*

Version 2.59

By Paul M - this CMS file is For vBulletin 3.5 and Flashchat 4.5.3 (or above).

Recent changes ;
2.53 - Support for customer role added.
2.54 - GetUser caching added.
2.55 - Lastactivity update added, caching altered to match main flashchat code method.
2.56 - Support for 4.5.x photo feature added with choice of avatar or profile picture (note: not supported if you use file storage method in vbulletin).
2.57 - Session cookie cleared on logout.
2.58 - Security fix: Integrated login code altered to cut out the use of userid cookie.
2.59 - GetUser caching re-enabled, Port fix for pre RC3 versions of config.php, tidy up.

*/

class vBulletinCMS
{
		// Initialise CMS
        function vBulletinCMS()
        {
                $this->loginStmt =
                new Statement("SELECT userid AS id, password, salt FROM {$GLOBALS['vbulletin']['prefix']}user WHERE username=?");
                $this->getUserStmt =
                new Statement("SELECT userid AS id, username AS login, usergroupid, membergroupids FROM {$GLOBALS['vbulletin']['prefix']}user WHERE userid=?");
                $this->getUsersStmt =
                new Statement("SELECT userid AS id, username AS login, usergroupid FROM {$GLOBALS['vbulletin']['prefix']}user");
                $this->getUserForSession =
                new Statement("SELECT * FROM {$GLOBALS['vbulletin']['prefix']}session WHERE sessionhash=? ORDER BY lastactivity DESC");
                $this->updateLastactivityForUser =
                new Statement("UPDATE {$GLOBALS['vbulletin']['prefix']}user SET lastactivity=? WHERE userid=?");
                $this->updateSessionForUser =
                new Statement("UPDATE {$GLOBALS['vbulletin']['prefix']}session SET lastactivity=?, location='$_SERVER[REQUEST_URI]' WHERE userid=?");
                   $this->getAvatar =
                new Statement("SELECT * FROM {$GLOBALS['vbulletin']['prefix']}customavatar WHERE userid = ? AND visible = 1");
                   $this->getPicture =
                new Statement("SELECT * FROM {$GLOBALS['vbulletin']['prefix']}customprofilepic WHERE userid = ? AND visible = 1");

				$this->session = $_COOKIE[$GLOBALS['vbulletin']['cookie'] . 'sessionhash'];
                if($_SESSION['fc_users_cache']['sessionhashid'] != $this->session)
				{
	                $rs = $this->getUserForSession->process($this->session);
    	            if($rec = $rs->next()) 
					{
						$this->userid = intval($rec['userid']);
						$_SESSION['fc_users_cache']['sessionuserid'] = $this->userid;
						$_SESSION['fc_users_cache']['sessionhashid'] = $this->session;
					}
				}
				else
				{
					$this->userid = $_SESSION['fc_users_cache']['sessionuserid'];
				}

                if($_POST['t'] AND $GLOBALS['vbulletin']['spkupdate'] AND intval($this->userid) > 0)
                {
                        $ru = $this->updateSessionForUser->process(time(),$this->userid);
                        $ru = $this->updateLastactivityForUser->process(time(),$this->userid);
                }  
        }

//      Auto Login
        function isLoggedIn()
        {
                if($this->userid > 0 AND $GLOBALS['vbulletin']['logupdate'])
                {
                        $ru = $this->updateSessionForUser->process(time(),$this->userid);
                        $ru = $this->updateLastactivityForUser->process(time(),$this->userid);
                }
                return $this->userid;
        }

//      Manual Login
        function login($login, $password)
        {
                $rv = NULL;
				$login = utf8_to_entities($login);
				$rs = $this->loginStmt->process(utf8_decode($login));
                $rec = $rs->next();
                if($rs)
                {
					$password = utf8_to_entities($password);
					if(($rec['password'] == md5(md5(utf8_decode($password)) . $rec['salt']))) $rv = $rec['id'];
                }
                if($rv > 0 AND $GLOBALS['vbulletin']['logupdate'])
                {
                        $ru = $this->updateSessionForUser->process(time(),$rv);
                        $ru = $this->updateLastactivityForUser->process(time(),$rv);
                }
                return $rv;
        }

//      Logout
        function logout()
        {
				$_SESSION['fc_users_cache']['sessionhashid'] = '#';
                if($this->userid > 0 AND $GLOBALS['vbulletin']['logupdate'])
                {
                        $ru = $this->updateSessionForUser->process(time(),$this->userid);
                        $ru = $this->updateLastactivityForUser->process(time(),$this->userid);
                }
                return NULL;
        }

		// Assign chat role
        function getRoles($usergroupid)
        {
                $groups = explode(',',$usergroupid);
                $userrole = ROLE_NOBODY ; // Set default access
                foreach ($GLOBALS['vbulletin']['users'] as $group) if (in_array($group,$groups)) $userrole = ROLE_USER; // Check Allowed groups
                if ($GLOBALS['fc_config']['liveSupportMode']) {  // Live support mode ?
                        foreach ($GLOBALS['vbulletin']['customer'] as $group) if (in_array($group,$groups)) $userrole = ROLE_CUSTOMER; // Check Customer groups
                }
                foreach ($GLOBALS['vbulletin']['mods'] as $group) if (in_array($group,$groups)) $userrole = ROLE_MODERATOR; // Check Moderator groups
                foreach ($GLOBALS['vbulletin']['admin'] as $group) if (in_array($group,$groups)) $userrole = ROLE_ADMIN; // Check Admin groups
                foreach ($GLOBALS['vbulletin']['banned'] as $group) if (in_array($group,$groups)) $userrole = ROLE_NOBODY; // Check Banned groups
                return $userrole;
        }

		//	Get user details
        function getUser($userid)
        {
            if($_SESSION['fc_users_cache'][$userid]['userid'] == $userid)
            {
//              Use cached details if they exist.
            	return $_SESSION['fc_users_cache'][$userid];
            }
            if(($rs = $this->getUserStmt->process($userid)) && ($rec = $rs->next()))
            {
                $rec['usergroupid'] .= ",".$rec['membergroupids'] ;
                $rec['roles'] = $this->getRoles($rec['usergroupid']);
				$tagencoded = entities_to_utf8($rec['login']);
				if(strlen($rec['login']) > strlen($tagencoded)) $rec['login'] = $tagencoded;
				else $rec['login'] = utf8_encode($rec['login']);
				$_SESSION['fc_users_cache'][$userid] = $rec; // Cache not currently set in ChatServer //
                return $rec;
            }
            return null;
        }

//      Return all existing users
        function getUsers()
        {
                return $this->getUsersStmt->process();
        }

//      Returns URL of user profile page for such user id or null if user not found
        function getUserProfile($userid)
        {
                return ($this->userid == $userid) ? "../profile.php?do=editprofile" : "../member.php?u=$userid";
        }

//		Check if user is in a specific role
        function userInRole($userid, $role)
        {
                $user = $this->getUser($userid) ;
                if($role == $user['roles']) return true;
                return false;
        }

//		Get male or female
        function getGender($user)
        {
                return NULL;
        }

//      Debug logging function
        function fclog($arg)
        {
                $path = INC_DIR."flashlog.txt" ;
                $crlf = "\r\n" ;
                $dts = date("d/m/Y H:i:s : ") ;
                $file = @fopen( $path, "a" );
                $arg = $dts.$arg.$crlf ;
                $res = @fwrite($file, $arg);
                @fflush($file);
                @fclose($file);
        }

//      Get current profile picture or avatar
        function getPhoto($userid)
        {
                if($_SESSION['fc_users_cache'][$userid]['pid'] == $userid)
                {
//	                Use cached details if they exist.
		            return $_SESSION['fc_users_cache'][$userid]['fpath'];
                }
                if($GLOBALS['vbulletin']['useavatar'])
                {
                        $rs = $this->getAvatar->process($userid);
                }
                else
                {
                        $rs = $this->getPicture->process($userid);
                }
                if(($rec = $rs->next()) == null) return '';
                $fparts = explode('.', $rec['filename']);
                $fname  = strtolower('$'.substr('000000'.$userid,-6).'$'.$rec['dateline'].'.'.$fparts[count($fparts)-1]);
                $fpath  = './images/cust_img/'.$fname;
                if(!file_exists($fpath))
                {
                        $fp = fopen($fpath, 'wb');
                        fwrite($fp, $rec['filedata']);
                        fflush($fp);
                        fclose($fp);
                }
                $_SESSION['fc_users_cache'][$userid]['pid'] = $userid;
                $_SESSION['fc_users_cache'][$userid]['fpath'] = $fpath;
                return $fpath;
        }
}

// Get vb config.php
$vbpath = realpath(dirname(__FILE__));
require_once $vbpath . '/../../../includes/config.php';

// Clear 'if moderator' message 
foreach($GLOBALS['fc_config']['languages'] as $k => $v)
{
        $GLOBALS['fc_config']['languages'][$k]['dialog']['login']['moderator'] = '';
}

// Get settings from vbulletin config settings
$GLOBALS['fc_config']['db'] = array(
        'base' => $config['Database']['dbname'],
        'user' => $config['MasterServer']['username'],
        'pass' => $config['MasterServer']['password'],
        'pref' => $GLOBALS['fc_config']['db']['pref'],
        'host' => $config['MasterServer']['servername'],
);

//	Add tcp port if specified
if($config['MasterServer']['port'])
{
	$GLOBALS['fc_config']['db']['host'] .= ':'.$config['MasterServer']['port'];
}

// vbulletin specific settings
$GLOBALS['vbulletin'] = array(
        'cookie' => $config['Misc']['cookieprefix'],
        'prefix' => $config['Database']['tableprefix'],

        'spkupdate' => true, // Update vBulletin when user speaks.
        'logupdate' => true, // Update vBulletin when user logs in/out.
        'useavatar' => true, // True = use custom avatar for flashchat photo feature, False = use custom profile picture.

        'users' => array( 2,9 ) , // vBulletin usergroups allowed standard access to chat.
        'mods' => array( 5,7 ) , // vBulletin usergroups allowed access as chat moderators.
        'admin' => array( 6 ) , // vBulletin usergroups allowed access as chat administrators.
        'banned' => array( 1,8 ) , // vBulletin usergroups banned from accessing the chat.
        'customer' => array( 0 ) , // vBulletin usergroups allowed access as customers (Live support mode only).
);

// Initiate class
$GLOBALS['fc_config']['cms'] = new vBulletinCMS();

?>
