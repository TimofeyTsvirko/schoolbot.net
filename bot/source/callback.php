<?php 

function callback_handleEvent() {
  $event = _callback_getEvent();
  try {
    switch ($event['type']) {
      case 'confirmation':
        _callback_handleConfirmation();
        break;
      case 'message_new':
        _callback_handleMessageNew($event['object']);
        break;
      default:
        _callback_response('Unsupported event');
        break;
    }
  } catch (Exception $e) {
    log_error($e);
  }
  _callback_response('ok');
}

function _callback_getEvent() {
  return json_decode(file_get_contents('php://input'), true);
}

function _callback_handleConfirmation() {
  _callback_response(CALLBACK_API_CONFIRMATION_TOKEN);
}

function _callback_handleMessageNew($data) {
  bot_handleMessage($data);
  _callback_response('ok');
}

function _callback_response($data) {
  echo $data;
  exit();
}