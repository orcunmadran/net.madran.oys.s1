<?php
			$this->sendBack(new Message('lout', null, null, (isset($msg))?$msg:'login'));
			$this->sendToAll(new Message('rmu', $this->userid));
		
			ChatServer::logout();
			$this->userid = null;
			$this->roomid = $this->getAvailableRoom($GLOBALS['fc_config']['defaultRoom']);

			$this->save();
?>