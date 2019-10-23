<?php 
require_once 'keyboard.php';
require_once 'conversation.php';
// 
// HANDLING MESSAGES
// 
mb_internal_encoding('UTF-8');
function bot_handleMessage($data,$testing=false){
	if ($testing) {
		$message = mb_strtolower($data);
		$user_id = 432657432;
	}else{
		$user_id = $data['from_id'];
		$message = mb_strtolower($data['text']);
	}
	if(bot_checkAvailableConversation($user_id,$testing)){
		switch ($message) {
			case 'отменить':
				bot_removeConversation($user_id,$testing);
				$keyboard = bot_createKeyboard($user_id, 'menu', $testing);
				bot_sendMessage($user_id, 'Хорошо, отменено',$testing,$keyboard);
				break;
			
			default:
				bot_handleMessageConversation($user_id,$message,$testing);
				break;
		}
	}else{
		switch ($message) {
	 		case 'start':
	 			bot_handleHello($data,$testing);
	 			break;
	 		case 'расписание':
	 			bot_handleSchedule($data,$testing);
	 			break;
	 		default:
	 			bot_unknownCommand($user_id,$testing);
	 			break;
		}
	}
}

function bot_unknownCommand($user_id,$testing=false){
	$msg = "Я не понял, что вы имели ввиду :(";
	$keyboard = bot_createKeyboard($user_id, 'menu', $testing);
	bot_sendMessage($user_id,$msg,$testing,$keyboard);
}

function bot_handleHello($data,$testing=false){
	global $dbc;
	if ($testing) {
		$user_id = 432657432;
	}else{
		$user_id = $data['from_id'];
	}	
	$query = "SELECT * FROM users where id=$user_id";
	$result = @mysqli_query($dbc, $query);
	if($result){
		$i=0;
		while($row = mysqli_fetch_array($result)){
			$i++;
		}
		if ($i==0){
			$msg = 'Привет! Вижу, ты новенький здесь. Меня зовут Вася, я - чатбот, специально предназначенный для того, чтобы помогать различным школам.';
			bot_sendMessage($user_id,$msg,$testing);

			$msg = 'На данный момент я могу давать расписание и делать объявления как отдельно для классов, так и для всей школы, но вскоре, может быть, смогу делать и другие полезные вещи...';
			bot_sendMessage($user_id,$msg,$testing);

			$keyboard = bot_createKeyboard($user_id, 'accept_data_processing',$testing);
			$msg = 'Перед тем, как вы будете пользоваться моими функциями, дайте согласие на обработку ваших данных (я обрабатываю только то, что вы пишите сюда):';
			bot_sendMessage($user_id,$msg,$testing,$keyboard);
			bot_createConversation($user_id, 'accept_data_processing',$testing);
		}else{
			bot_sendMessage($user_id,'Привет!',$testing);
		}
	}else{
		bot_handleError($user_id,'mysql','',$testing);
	}
}

function bot_handleSchedule($data,$testing = false){
	global $dbc;
	if ($testing){
		$user_id = 432657432;
	}else{
		$user_id = $data['from_id'];
	}
	$query = "SELECT * FROM users where id=$user_id";
	$result = @mysqli_query($dbc, $query);
	if($result){
		if($result->num_rows == 0){
			$msg = 'Вас нет в базе данных - скорее всего, произошла какая-то ошибка. Попробуйте авторизоваться каким-либо способом';
			bot_sendMessage($user_id,$msg,$testing);
		}else{
			$row = mysqli_fetch_assoc($result);
			if (!$row['grade']){
				$msg = 'Укажите свой класс (Пример: "10а","6в"):';

				bot_sendMessage($user_id,$msg,$testing,'none');
				bot_createConversation($user_id, 'add_grade', $testing);
			}
		}
	}
}

// 
// BOT SENDING MESSAGES
// 

function bot_sendMessage($user_id,$msg,$testing=false,$keyboard=false){
	if (!$keyboard) {
		$keyboard = bot_createKeyboard($user_id,'menu',$testing);
	}else if ($keyboard == 'none'){
		$kbd = array('one_time' => true, 'buttons' => array());
    	$keyboard = json_encode($kbd,JSON_UNESCAPED_UNICODE);
	}
	if($testing){
		echo $msg;
		echo $keyboard;

		echo '<br>';
		echo '<br>';
	}else{
		vkApi_messagesSend($user_id, $msg, $keyboard);
	}
}




// 
// BOT HANDLE ERROR 
//

function bot_handleError($user_id, $error_type='',$error_message='',$testing=false){
	switch ($error_type) {
		case 'mysql':
			$msg = 'Ошибка в работе с данными: '. $error_message;
			bot_sendMessage($user_id,$msg,$testing);
			break;
		case 'rows_0':
			$msg = 'Выдало 0 rows: '. $error_message;
			bot_sendMessage($user_id,$msg,$testing);
			break;
		case 'program':
			$msg = 'Программная ошибка: '. $error_message;
			bot_sendMessage($user_id,$msg,$testing);			
			break;
		case 'kbd_type':
			$msg = 'Нет подходящего типа клавиатуры: '. $error_message;
			bot_sendMessage($user_id,$msg,$testing);			
			break;
		default:
			$msg = 'Неизвестная ошибка: ' . $error_message;
			bot_sendMessage($user_id,$msg,$testing);
			break;
	}
}


