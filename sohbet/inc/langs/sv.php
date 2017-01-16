<?php
	$GLOBALS['fc_config']['languages']['sv'] = array(
		'name' => "Svenska",

		'messages' => array(
			'ignored' => "'USER_LABEL' ignorerar dina meddelanden.",
			'banned' => "Du har blivit bannad",
			'login' => 'V�nligen logga in p� chatten',
			'wrongPass' => 'Felaktigt anv�ndarnamn eller l�senord. F�rs�k igen.',
			'anotherlogin' => 'En annan anv�ndare �r inloggad med detta anv�ndarnamnet. F�rs�k igen.',
			'expiredlogin' => 'Tiden har g�tt ut f�r din anslutning. V�nligen logga in igen.',
			'enterroom' => '[ROOM_LABEL]: USER_LABEL har g�tt in i rummet TIMESTAMP',
			'leaveroom' => '[ROOM_LABEL]: USER_LABEL har l�mnat rummet TIMESTAMP',
			'selfenterroom' => 'V�lkommen! Du har g�tt in i [ROOM_LABEL] TIMESTAMP',
			'bellrang' => 'USER_LABEL ringde p� klockan',
			'chatfull' => 'Chatten �r full. F�rs�k igen senare.',
			'iplimit' => 'Du chattar redan.'
		),

		'usermenu' => array(
			'profile' => 'Profil',
			'unban' => 'Ta bort ban',
			'ban' => 'Ban',
			'unignore' => 'Sluta ignorera',
			'fileshare' => 'Dela fil',
			'ignore' => 'Ignorera',
			'invite' => 'Bjud in',
			'privatemessage' => 'Privat meddelande',
		),

		'status' => array(
			'away' => 'Borta',
			'busy' => 'Upptagen',
			'here' => 'Tillg�nglig',
			'brb'  => 'BRB',
		),

		'dialog' => array(
			'misc' => array(
				'roomnotfound' => "Rummet 'ROOM_LABEL' ej hittat",
				'usernotfound' => "Anv�ndaren 'USER_LABEL' ej hittad",
				'unbanned' => "Du blev un-bannad av anv�ndaren 'USER_LABEL'",
				'banned' => "Du blev bannad av anv�ndaren 'USER_LABEL'",
				'unignored' => "Anv�ndaren  'USER_LABEL' tog bort ignorering p� dig",
				'ignored' => "Du har blivit ignorerad av anv�ndaren 'USER_LABEL'",
				'invitationdeclined' => "Anv�ndaren 'USER_LABEL' nekade din inbjudan till  'ROOM_LABEL'",
				'invitationaccepted' => "Anv�ndaren 'USER_LABEL' accepterade din inbjudan till 'ROOM_LABEL'",
				'roomnotcreated' => 'Rummet ej skapat',
				'roomisfull' => '[ROOM_LABEL] �r full. V�lj ett annat rum.',
				'alert' => '<b>ALERT!</b><br><br>',
				'chatalert' => '<b>ALERT!</b><br><br>',
				'gag' => "<b>Du har blivit d�mpat f�r DURATION minute(r)!</b><br><br>Du f�r observera samtal i rummet, men f�r ej bidra ".
						 "till samtalet, f�r n�rvarande.",
				'ungagged' => "Du blev un-d�mpat av anv�ndaren 'USER_LABEL'",
				'gagconfirm' => 'USER_LABEL �r d�mpad f�r MINUTES minute(r).',
				'alertconfirm' => 'USER_LABEL har l�st alertet.',
				'file_declined' => 'Din fil har nekats av USER_LABEL.',
				'file_accepted' => 'Din fil accepterades av USER_LABEL.',
			),

			'unignore' => array(
				'unignoreBtn' => 'St�ng av ignorering',
				'unignoretext' => 'V�lj av-ignoreringstext',
			),

			'unban' => array(
				'unbanBtn' => 'Ta bort ban',
				'unbantext' => 'V�lj un-ban text',
			),

			'tablabels' => array(
				'themes' => 'Teman',
				'sounds' => 'Ljud',
				'text'  => 'Text',
				'effects'  => 'Effekter',
				'admin'  => 'Admin',
				'about' => "�ver",
			),

			'text' => array(
				'itemChange' => 'Del att �ndra',
				'fontSize' => 'Fontstorlek',
				'fontFamily' => 'Fontfamilj',
				'language' => 'Spr�k',
				'mainChat' => 'Huvud chat',
				'interfaceElements' => 'Gr�nssnittsdel',
				'title' => 'Titel',
				'mytextcolor' => 'Änv�nd min text f�rg f�r alla mottagna meddelande.',
			),

			'effects' => array(
				'avatars' => 'Avatars',
				'mainchat' => 'Main chat',
				'roomlist' => 'Chatrum lista',
				'background' => 'Bakgrund',
				'custom' => 'Anpassad',
				'showBackgroundImages' => 'Visa bakgrund',
				'splashWindow' => 'Fokusera f�nster vid nytt meddelande',
				'uiAlpha' => 'genomsynlighet',
			),

			'sound' => array(
				'sampleBtn' => 'Exempel',
				'testBtn' => 'Testa',
				'muteall' => 'St�ng av ljudet',
				'submitmessage' => 'Skicka meddelande',
				'reveivemessage' => 'Ta emot meddelande',
				'enterroom' => 'G� in i rum',
				'leaveroom' => 'L�mna rum',
				'pan' => 'Pan',
				'volume' => 'Ljudvolum',
				'initiallogin' => 'F�rsta inloggningen',
				'logout' => 'Logga ut',
				'privatemessagereceived' => 'Tog emot privat meddelande',
				'invitationreceived' => 'Tog emot inbjudan',
				'combolistopenclose' => '�ppna/st�ng combo lista',
				'userbannedbooted' => 'Anv�ndare bannad eller utsl�ngd',
				'usermenumouseover' => 'Anv�ndarmeny mouse over',
				'roomopenclose' => '�ppna/st�ng rumsdel',
				'popupwindowopen' => 'Popup-f�nster �ppnas',
				'popupwindowclosemin' => 'Popup-f�nster st�ngs',
				'pressbutton' => 'Tangent nertryckt',
				'otheruserenters' => 'Annan anv�ndare g�r in i rummet'
			),

			'skin' => array(
				'inputBoxBackground' => 'Input box bakgrund',
				'privateLogBackground' => 'Privat logg bakgrund',
				'publicLogBackground' => 'Publik logg bakgrund',
				'enterRoomNotify' => 'G� in i rum notifiering',
				'roomText' => 'Text i rum',
				'room' => 'Bakgrund i rum',
				'userListBackground' => 'Anv�ndarlista bakgrund',
				'dialogTitle' => 'Titel p� dialogruta',
				'dialog' => 'Dialogruta bakgrund',
				'buttonText' => 'Knappar text',
				'button' => 'Knappar bakgrund',
				'bodyText' => 'Body text',
				'background' => 'Huvudbakgrund',
				'borderColor' => 'Border f�rrg',
				'selectskin' => 'V�lj f�rgschema...',
				'buttonBorder' => 'Knapp border',
				'selectBigSkin' => 'V�lj skal...',
				'titleText' => 'Titeltext'
			),

			'privateBox' => array(
				'sendBtn' => 'Skicka',
				'toUser' => 'Konversation med USER_LABEL:',
			),

			'login' => array(
				'loginBtn' => 'Logga in',
				'language' => 'Spr�k:',
				'moderator' => '(om moderator)',
				'password' => 'L�senord:',
				'username' => 'Anv�ndarnamn:',
			),

			'invitenotify' => array(
				'declineBtn' => 'Neka',
				'acceptBtn' => 'Acceptera',
				'userinvited' => "Anv�ndaren 'USER_LABEL' bj�d in dig till rummet 'ROOM_LABEL'",
			),

			'invite' => array(
				'sendBtn' => 'Skicka',
				'includemessage' => 'Skicka med detta meddelande tillsammans med din inbjudan:',
				'inviteto' => 'Bjud in anv�ndare till:',
			),

			'ignore' => array(
				'ignoreBtn' => 'Ignorera',
				'ignoretext' => 'Ange ignoreringstext',
			),

			'createroom' => array(
				'createBtn' => 'Skapa',
				'private' => 'Privat',
				'public' => 'Publik',
				'entername' => 'Ange namn p� rummet',
			),

			'ban' => array(
				'banBtn' => 'Banna',
				'byIP' => 'efter IP',
				'fromChat' => 'fr�n chat',
				'fromRoom' => 'fr�n rum',
				'banText' => 'Ange ban text',
			),

			'common' => array(
				'cancelBtn' => 'Avbryt',
				'okBtn' => 'OK',

				'win_choose'         => 'V�lj en fil att ladda upp:',
				'win_upl_btn'        => '  Ladda  ',
				'upl_error'          => 'Fel vid uppladdning',
				'pls_select_file'    => 'V�lj en fil att ladda upp',
				'ext_not_allowed'    => 'Filtypen FILE_EXT �r ej till�tat. Var v�nlig v�lj en fil av typ: ALLOWED_EXT',
				'size_too_big'       => 'Filen som du vill dela �r f�r stor. F�rs�k igen.',
			),

			'sharefile' => array(
				'chat_users'=> '[ Dela med Chatten ]',
				'all_users' => '[ Dela med Rummet ]',
				'file_info_size'  => '<br>Filstorleken f�r vara maximal MAX_SIZE .',
				'file_info_ext' => ' Till�tna filer: ALLOWED_EXT',
				'win_share_only'=>'Dela med',
				'usr_message' => '<b>USER_LABEL vill dela en fil med dig</b><br><br>Fil namn: F_NAME<br>Fil storlek: F_SIZE',
			),

			'loadavatarbg' => array(
				'win_title'  => 'Custom Bakgrund',
				'file_info'  => 'Din fil m�ste vara en ej-progressiv JPG bild, eller en Flash SWF fil.',
				'use_label'  => 'Anv�nd dilen f�r:',
				'rb_mainchat_avatar' => 'Endast Main chat avatar',
				'rb_roomlist_avatar' => 'Endast Room list avatar',
				'rb_mc_rl_avatar'    => 'S�v�l Main Chat som rumslista avatars',
				'rb_this_theme'      => 'Background f�r det h�r temat',
				'rb_all_themes'      => 'Background for alla teman',
			),


		),

		'desktop' => array(
			'invalidsettings' => 'Felaktiga inst�llningar',
			'selectsmile' => 'Smilies',
			'sendBtn' => 'Skicka',
			'saveBtn' => 'Spara',
			'clearBtn' => 'Rensa',
			'skinBtn' => 'Val',
			'addRoomBtn' => 'L�gg till',
			'myStatus' => 'Min status',
			'room' => 'Rum',
			'welcome' => 'V�lkommen USER_LABEL',
			'ringTheBell' => 'Inget svar? Ring i klockan:',
			'logOffBtn' => 'x',
			'helpBtn' => '?',
			'adminSign' => '',
		)
	);
?>
