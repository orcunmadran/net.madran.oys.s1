<?php
/*

Version 1.10 

By Paul M - this CMS file is For vBulletin 3.0 and Flashchat 4.4.x (or above).

Recent changes ;
1.10 - First updated release for vb 3.0.12

*/

class vBulletinCMS {

  function vBulletinCMS() 
  {
    $this->loginStmt = 
	new Statement("SELECT userid AS id, password, salt FROM {$GLOBALS['vbulletin']['prefix']}user WHERE username=? OR username=? OR username=? LIMIT 1");
    $this->getUserStmt = 
	new Statement("SELECT userid AS id, username AS login, usergroupid, membergroupids FROM {$GLOBALS['vbulletin']['prefix']}user WHERE userid=? LIMIT 1");
    $this->getUsersStmt = 
	new Statement("SELECT userid AS id, username AS login, usergroupid FROM {$GLOBALS['vbulletin']['prefix']}user");
	$this->getUserForSession = 
	new Statement("SELECT userid FROM {$GLOBALS['vbulletin']['prefix']}session WHERE sessionhash=? ORDER BY lastactivity DESC LIMIT 1");
	$this->getAvatar = 
	new Statement("SELECT * FROM {$GLOBALS['vbulletin']['prefix']}customavatar WHERE userid = ? AND visible = 1"); 
	$this->getPicture = 
	new Statement("SELECT * FROM {$GLOBALS['vbulletin']['prefix']}customprofilepic WHERE userid = ? AND visible = 1"); 

	$this->userid = intval($_COOKIE[$GLOBALS['vbulletin']['cookie'] . 'flashuserid']);
	if($this->userid == 0)
	{ 
		$this->userid = intval($_COOKIE[$GLOBALS['vbulletin']['cookie'] . 'userid']);
		if($this->userid == 0)
		{ 
			$rs = $this->getUserForSession->process($_COOKIE[$GLOBALS['vbulletin']['cookie'] . 'sessionhash']); 
			if($rec = $rs->next()) 
			{
				$this->userid = intval($rec['userid']);
				setcookie($GLOBALS['vbulletin']['cookie'] . 'flashuserid', $this->userid);
			}
		}
		else
		{
			setcookie($GLOBALS['vbulletin']['cookie'] . 'flashuserid', $this->userid);
		}
	}
	if($this->userid == 0) $this->userid == NULL; 
  }

//	Auto Login
	function isLoggedIn() 
	{
		return $this->userid;
	}

//	Manual Login
    function login($login, $password) 
	{
	    $rs = $this->loginStmt->process($login, utf8_to_entities($login), utf8_decode($login));
    	$rec = $rs->next();
	    $rv = NULL;
	    if($rs) {
    	  if(($rec['password'] == md5(md5(utf8_to_entities($password)) . $rec['salt'])) ||
	  		 ($rec['password'] == md5(md5(utf8_decode($password)) . $rec['salt'])) ||
			 ($rec['password'] == md5(md5(($password)) . $rec['salt']))
	    	)
		  {
		    $rv = $rec['id'];
	      }
	    }
	    return $rv;
	}

  // Logout
	function logout() 
	{ 
		return NULL;
	}

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

	function getUser($userid) 
	{
   		if($_SESSION['fc_users_cache'][$userid]['userid'] == $userid) 
		{
            return $_SESSION['fc_users_cache'][$userid];         
		}
		if(($rs = $this->getUserStmt->process($userid)) && ($rec = $rs->next())) 
		{
			$rec['usergroupid'] .= ",".$rec['membergroupids'] ; 
			$rec['roles'] = $this->getRoles($rec['usergroupid']); 
			$tagencoded = entities_to_utf8($rec['login']);
			if(strlen($rec['login']) > strlen($tagencoded)) $rec['login'] = $tagencoded;
			else $rec['login'] = utf8_encode($rec['login']);
			$_SESSION['fc_users_cache'][$userid] = $rec;
			return $rec;
		}
		return null;
	}

  // returns an object of vBulletinUsersRS class - an iterator on all existing users/admins
	function getUsers() 
	{
		return $this->getUsersStmt->process();
	}
  
  // returns URL of user profile page for such user id or null if user not found
	function getUserProfile($userid) 
	{
		return ($this->userid == $userid) ? "../profile.php?do=editprofile" : "../member.php?u=$userid";
	}

	function userInRole($userid, $role) 
	{
		$user = $this->getUser($userid) ;
		if($role == $user['roles']) return true;
		return false;
	}
  
	function getGender($user) 
	{
		return NULL;        
	}

	// Debug logging function
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

	// Get current profile picture or avatar
	function getPhoto($userid)
	{
   		if($_SESSION['fc_users_cache'][$userid]['pid'] == $userid) 
		{
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

$vbpath = realpath(dirname(__FILE__));
require_once $vbpath . '/../../../includes/config.php';

$GLOBALS['fc_config']['db'] = array(
    'host' => $GLOBALS['servername'],
    'user' => $GLOBALS['dbusername'],
    'pass' => $GLOBALS['dbpassword'],
    'base' => $GLOBALS['dbname'],
    'pref' => $GLOBALS['tableprefix'] . "_fc_"
);

$GLOBALS['vbulletin'] = array(
	'cookie' => $GLOBALS['cookieprefix'],
	'prefix' => $GLOBALS['tableprefix'],

	'users' => array( 2,9 ) , // vBulletin usergroups allowed standard access to chat.
	'mods' => array( 5,7 ) , // vBulletin usergroups allowed access as chat moderators.
	'admin' => array( 6 ) , // vBulletin usergroups allowed access as chat administrators.
	'banned' => array( 1,8 ) , // vBulletin usergroups banned from accessing the chat.
	'customer' => array( 0 ) , // vBulletin usergroups allowed access as customers (Live support mode only).
	'useavatar' => true, // True = use custom avatar for flashchat photo feature, False = use custom profile picture.
);

$GLOBALS['fc_config']['cms'] = new vBulletinCMS();

//clear 'if moderator' message
foreach($GLOBALS['fc_config']['languages'] as $k => $v) {
  $GLOBALS['fc_config']['languages'][$k]['dialog']['login']['moderator'] = '';
}
?>