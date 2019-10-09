<?php 	

require_once '../config.php';

require_once 'global.php';

require_once 'source/callback.php';
require_once 'source/vk_api.php';
require_once 'source/bot.php';

if(isset($_POST)){
	bot_handleMessage($_POST['text'],true);
}else{
	if(!isset($_REQUEST)){exit;}
	callback_handleEvent();
}


mysqli_close($dbc);