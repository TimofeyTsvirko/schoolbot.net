<?php 
// 
// HANDLING MESSAGES
// 

function bot_handleMessage($data,$testing=false){
	if ($testing) {
		$message = $data;
		$user_id = 228322;
	}else{
		$user_id = $data['from_id'];
		$message = strtolower($data['text']);
	}
	if(bot_checkAvailableConversation($user_id,$testing)){
		switch ($message) {
			case 'отменить':
				bot_removeConversation($user_id,$testing);
				break;
			
			default:
				# code...
				break;
		}
	}else{
		switch ($message) {
	 	case 'привет':
	 		bot_handleHello($data,$testing);
	 		break;
	 	default:
	 		bot_unknownCommand($user_id,$testing);
	 		break;
		}
	}
}

function bot_unknownCommand($user_id,$testing=false){
	$msg = "Я не понял, что вы имели ввиду :(";
	bot_sendMessage($user_id,$msg,$testing);
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
			$msg = 'Привет! Вижу, ты новенький здесь. Меня зовут Вася, я - чатбот, специально предназначенный для школ.';
			bot_sendMessage($user_id,$msg,$testing);
			$msg = 'На данный момент я могу давать расписание и делать объявления как отдельно для классов, так и для всей школы, но вскоре я, может быть, смогу делать и другие полезные вещи...';
			bot_sendMessage($user_id,$msg,$testing);
			
		}else{
			bot_sendMessage($user_id,'Привет!',$testing);
		}
	}else{
		bot_handleError($user_id,'mysql','',$testing);
	}
}


// 
// BOT SENDING MESSAGES
// 

function bot_sendMessage($user_id,$msg,$testing=false){
	if($testing){
		echo $msg;
	}else{
		vkApi_messagesSend($user_id, $msg);
	}
}

// 
// BOT CONVERSATIONS
// 


function bot_createConversation($user_id, $type, $testing=false){
	global $dbc;
	$query = "INSERT INTO conversation (id,type) VALUES($user_id,$type)";
	$result = @mysqli_query($dbc,$query);
	if(!($result)){
		bot_handleError($user_id,'mysql','',$testing);
	}
}


function bot_addMessageToConversation($user_id, $msg, $testing=false){
	global $dbc;

	$query = "SELECT messages FROM conversation where id=$user_id";
	$result = @mysqli_query($dbc,$query);

	if ($result) {
		if($result->num_rows == 1){
			while ($row = mysqli_fetch_array($result)){
				$conversation = explode(';', $row['messages']);
				$conversation[] = $msg;
			}
			$conversation = implode(';', $conversation);
			$query = "UPDATE conversation set messages=$conversation where id=$user_id";
			$result = @mysqli_query($dbc,$query);
			if(!($result)){
				bot_handleError($user_id,'mysql','bot_addMessageToConversation',$testing);
			}
		}else{
			bot_handleError($user_id,'rows_0','bot_addMessageToConversation',$testing);
		}
	}else{
		bot_handleError($user_id,'mysql','bot_addMessageToConversation',$testing);
	}
}

function bot_checkAvailableConversation($user_id,$testing=false){
	global $dbc;
	$query = "SELECT id from conversation where id=$user_id";
	$result = @mysqli_query($dbc, $query);
	if($result){
		if ($result->num_rows == 1){
			return true;
		}else{
			return false;
		}
	}else{
		bot_handleError($user_id,'mysql','bot_checkAvailableConversation',$testing);
	}
}

function bot_removeConversation($user_id,$testing=false){
	global $dbc;
	if (bot_checkAvailableConversation($user_id,$testing)){
		$query = "DELETE FROM conversation where id=$user_id";
		$result = @mysqli_query($dbc,$query);
		if (!($result)){
			bot_handleError($user_id,'mysql','bot_removeConversation',$testing);
		}
	}else{
		
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
		default:
			$msg = 'Неизвестная ошибка: ' . $error_message;
			bot_sendMessage($user_id,$msg,$testing);
			break;
	}
}


