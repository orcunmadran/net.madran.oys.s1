<?php
/************************************************************************/
//!!! IMPORTANT NOTE
//!!! FlashChat 4.4.0 and higher support a new user role: ROLE_MODERATOR
//!!! Please edit the getUser and getRoles function if you need use of
//!!! the new moderator role. This change has not yet been applied.
/************************************************************************/

$licenceNumber = 'L4359eb9'; // vbulletin license number

$vbpath = realpath(dirname(__FILE__) . '/../../../') . '/';

require_once $vbpath . '/includes/config.php';

class vBulletinCMS {
  var $userid;

  var $loginStmt;
  var $getUserStmt;
  var $getUsersStmt;
  var $getPhotoStmt;

  function vBulletinCMS() {
    $this->loginStmt = new Statement("SELECT userid AS id, password, salt FROM {$GLOBALS['tableprefix']}user WHERE username=? OR username=? OR username=? LIMIT 1");
    $this->getUserStmt = new Statement("SELECT userid AS id, username AS login, usergroupid FROM {$GLOBALS['tableprefix']}user WHERE userid=? LIMIT 1");
    $this->getUsersStmt = new Statement("SELECT userid AS id, username AS login, usergroupid FROM {$GLOBALS['tableprefix']}user");
	$this->getPhotoStmt = new Statement("SELECT avatardata, filename FROM {$GLOBALS['tableprefix']}customavatar WHERE userid = ? AND visible = 1");
    $this->userid = isset($_COOKIE[$GLOBALS['cookieprefix'] . 'userid']) ? $_COOKIE[$GLOBALS['cookieprefix'] . 'userid'] : NULL;
  }

  // returns actually logged in user id, otherwice returns null

  function isLoggedIn() {
    return $this->userid;
  }

  // performs user login using provided login and password, return logged in user id, otherwice returns null

  function login($login, $password) {
    global $cookieprefix, $licenceNumber;

    //decode to HTML &#XXXX; code
    //$login = utf8_to_entities($login);
    $rs = $this->loginStmt->process($login, utf8_to_entities($login), utf8_decode($login));
    $rec = $rs->next();

    $rv = NULL;

    if($rs) {
      //decode to HTML &#XXXX; code
      //$password = utf8_to_entities($password);

      if(($rec['password'] == md5(md5(utf8_to_entities($password)) . $rec['salt'])) ||
	  	 ($rec['password'] == md5(md5(utf8_decode($password)) . $rec['salt'])) ||
		 ($rec['password'] == md5(md5(($password)) . $rec['salt']))
	    )
	  {
	    $rv = $rec['id'];
	    setcookie($cookieprefix . 'userid', $rec['id'], time()+2592000, '/');
	    setcookie($cookieprefix . 'password', md5($rec['password'] . $licenceNumber), time()+2592000, '/');
      }
    }
    return $rv;
  }

  // performs logging out for actual user

  function logout() {
  }

  function getRoles($usergroupid) {
    switch($usergroupid) {
    case 2:
      return ROLE_USER;
    case 5:
    case 6:
    case 7:
      return ROLE_ADMIN;
    default:
      return 0;
    }
  }

  // returns used data for provided user id. User data is an array like:
  // array(
  //		'id' => <user id>,
  //		'login' => <user login>,
  //		'roles'=> ROLE_USER for users, ROLE_ADMIN for admins, or ROLE_USER | ROLE_ADMIN if user has both roles
  // );
  // ROLE_USER and ROLE_ADMIN are constants defined in inc/common.php
  // returns null if such user is not found

  function getUser($userid) {
    if(($rs = $this->getUserStmt->process($userid)) && ($rec = $rs->next())) {
      $rec['roles'] = $this->getRoles($rec['usergroupid']);
      $tagencoded = entities_to_utf8($rec['login']);
      if(strlen($rec['login']) > strlen($tagencoded))
	    $rec['login'] = $tagencoded;
      else
	    $rec['login'] = utf8_encode($rec['login']);
      return $rec;
    }
    return null;
  }


  // returns an object of vBulletinUsersRS class - an iterator on all existing users/admins

  function getUsers() {
    return $this->getUsersStmt->process();
  }


  // returns URL of user profile page for such user id or null if user not found

  function getUserProfile($userid) {
    return ($this->userid == $userid) ? "../profile.php?do=editprofile" : "../member.php?u=$userid";
  }


  // checks user role

	function userInRole($userid, $role) {
		if($user = $this->getUser($userid)) {
			return ($user['roles'] == $role);
		}
		return false;
	}

  function getGender($userid) {
    // 'M' for Male, 'F' for Female, NULL for undefined
    return NULL;
  }
  
  function getPhoto($userid)
  {
  	$rs = $this->getPhotoStmt->process($userid);
	if(($rec = $rs->next()) == null)
		return '';
	
	$fparts = explode('.', $rec['filename']);
	$fname  = md5($rec['filename'].$userid).'.'.$fparts[count($fparts)-1];
	$fpath  = './nick_image/'.$fname;
	
	if(!file_exists($fpath))
	{
		$fp = fopen($fpath, 'wb');
		fwrite($fp, $rec['avatardata']);
		fflush($fp);
		fclose($fp);
	}	
	
	return $fpath;
  }
}

$GLOBALS['fc_config']['db'] = array(
				    'host' => $GLOBALS['servername'],
				    'user' => $GLOBALS['dbusername'],
				    'pass' => $GLOBALS['dbpassword'],
				    'base' => $GLOBALS['dbname'],
				    'pref' => $GLOBALS['tableprefix'] . "_fc_"
				    );

$GLOBALS['fc_config']['cms'] = new vBulletinCMS();

//clear 'if moderator' message
foreach($GLOBALS['fc_config']['languages'] as $k => $v) {
  $GLOBALS['fc_config']['languages'][$k]['dialog']['login']['moderator'] = '';
}
?>

