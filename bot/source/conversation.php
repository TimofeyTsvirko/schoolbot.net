<?php 

// 
// BOT CONVERSATIONS
// 


function bot_createConversation($user_id, $type, $testing=false){
	global $dbc;
	$query = "INSERT INTO conversation (id,type) VALUES($user_id,'$type')";
	$result = @mysqli_query($dbc,$query);
	if(!($result)){
		bot_handleError($user_id,'mysql','bot_createConversation',$testing);
		echo mysqli_error($dbc);
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

function bot_handleMessageConversation($user_id,$msg,$testing=false){
	global $dbc;
	$query = "SELECT type from conversation where id=$user_id";
	$result = @mysqli_query($dbc,$query);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		switch ($row['type']) {
			case 'accept_data_processing':
				bot_convDataProcess($user_id,$msg,$testing);
				break;
			case 'accept_mailing':
				bot_convMailing($user_id,$msg,$testing);
				break;
			case 'add_grade':
				bot_convAddGrade($user_id,$msg,$testing);
				break;
			default:
				# code...
				break;
		}

	}else{
		bot_handleError($user_id,'mysql','bot_handleMessageConversation',$testing);
	}
}

function bot_convDataProcess($user_id,$msg,$testing=false){
	global $dbc;
	switch ($msg) {
		case 'согласен(-на)':
			bot_removeConversation($user_id,$testing);
			$query = "INSERT INTO users (id, city, school, accepted_data_processing) VALUES ($user_id, 'Кемь', 'МБОУСОШ1', 1)";
			$result = @mysqli_query($dbc,$query);
			if($result){
				$msg = 'Как я писал ранее, я могу делать новостные рассылки от школы, чтобы вы были в курсе всех событий, которые будут происходить в ближайшее время.';
				bot_sendMessage($user_id,$msg,$testing);

				$msg = 'Вы согласны получать рассылку?';
				$keyboard = bot_createKeyboard($user_id, 'mailing', $testing);
				bot_createConversation($user_id, 'accept_mailing',$testing);
				bot_sendMessage($user_id,$msg,$testing,$keyboard);
			}else{
				bot_handleError($user_id,'mysql','bot_convDataProcess',$testing);
			}
			break;
		case 'не согласен(-на)':
		default:
			$msg = 'Чтобы пользоваться далее ботом, необходимо ваше согласие:';
			$keyboard = bot_createKeyboard($user_id, 'accept_data_processing', $testing);
			bot_sendMessage($user_id,$msg,$testing,$keyboard);
			break;
	}
}

function bot_convMailing($user_id,$msg,$testing=false){
	global $dbc;
	switch ($msg) {
		case 'согласен(-на)':
			bot_removeConversation($user_id,$testing);

			$query = "UPDATE users SET accepted_mailing=1 where id=$user_id";
			$result = @mysqli_query($dbc, $query);
			
			if($result){
				$msg = 'Хорошо, я вас понял - вы будете получать рассылку';
				$keyboard = bot_createKeyboard($user_id, 'menu', $testing);
				bot_sendMessage($user_id,$msg,$testing,$keyboard);
			}else{
				bot_handleError($user_id,'mysql','bot_convMailing',$testing);
			}
			break;
		case 'не согласен(-на)':
			bot_removeConversation($user_id,$testing);

			$msg = 'Хорошо, я вас понял - не будет рассылки';
			$keyboard = bot_createKeyboard($user_id, 'menu', $testing);
			bot_sendMessage($user_id,$msg,$testing,$keyboard);
			break;
		default:
			$msg = 'Я вас не понял :( Вы соглашаетесь на рассылку?';
			$keyboard = bot_createKeyboard($user_id, 'mailing', $testing);
			bot_sendMessage($user_id, $msg, $testing,$keyboard);
			break;
	}
}

function bot_convAddGrade($user_id,$msg,$testing=false){
	global $dbc;
	$query = "SELECT * FROM users where id=$user_id";
	$result = @mysqli_query($dbc,$query);
	if($result){
		// ---------here----------
	}else{
		bot_handleError($user_id,'mysql','bot_convAddGrade',$testing);
	}
}