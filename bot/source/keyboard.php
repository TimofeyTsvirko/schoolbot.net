<?php 

// 
// BOT KEYBOARD
// 

function bot_createKeyboard($user_id, $type, $testing){
	global $dbc;
	$query = "SELECT * FROM users where id=$user_id";
	$result = @mysqli_query($dbc, $query);
	if($result){
		if($result->num_rows == 0){
			$user_role = 'user';
		}else{
			$user_data = mysqli_fetch_array($result);
			$user_role = $user_data['role'];
		}
		switch ($type) {
			case 'menu':
				$keyboard = bot_createMenuKeyboard($user_role,$testing);
				break;
			case 'accept_data_processing':
			case 'mailing':
				$keyboard = bot_createAcceptKbd();
				break;
			default:
				bot_handleError($user_id, 'kbd_type', 'bot_createKeyboard',$testing);
				break;
		}
		return $keyboard;
	}else{
		bot_handleError($user_id,'mysql','bot_createKeyboard',$testing);
	}
}

function bot_createMenuKeyboard($user_role, $testing){
	// keyboard object
	$keyboard = array();
	$keyboard['one_time'] = true;
	// buttons object (array of arrays)
	$buttons = array();
	// first row
	$buttons[] = array();
	
	// schedule button
	$schedule = array('color' => 'primary', 
					'action' => array('type' => 'text', 'label' => 'Расписание', 'payload' => '{"button": "schedule"}'));
	$buttons[0][] = $schedule;

	switch ($user_role) {
		case 'user':
			
			break;
		case 'worker':
			# code...
			break;
		case 'worker+':
		case 'admin':
			# code...
			break;
		default:
			bot_handleError($user_id,'program','bot_createMenuKeyboard',$testing);
			break;
	}
	$keyboard['buttons'] = $buttons;
	return json_encode($keyboard, JSON_UNESCAPED_UNICODE
	);
}

function bot_createAcceptKbd(){
	// keyboard object
	$keyboard = array();
	$keyboard['one_time'] = true;
	// buttons object (array of arrays)
	$keyboard['buttons'] = array();
	// first row
	$keyboard['buttons'][] = array();

	$accept = array('color' => 'positive',
					'action' => array('type'=>'text', 'label'=>'Согласен(-на)'));
	$decline = array('color' => 'negative',
					'action' => array('type'=>'text', 'label'=>'Не согласен(-на)'));
	$keyboard['buttons'][0][] = $accept;
	$keyboard['buttons'][0][] = $decline;
	return json_encode($keyboard, JSON_UNESCAPED_UNICODE);
}