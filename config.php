<?php 

define(VK_API_ACCESS_TOKEN, '12ea529bd7f6795d227fb6de1c88df4bf658bf2a61f8fd33efcb9c4b74c77f58e1290c1860658c3319e43');
define(CALLBACK_API_SECRET_KEY, 'dgfhYTHFGJHutfgfchg6543ess54ws');
define(CALLBACK_API_CONFIRMATION_TOKEN, '184e8a82');

define(DB_HOST,'schoolbot.net');
define(DB_DATABASE,'schoolbot');
define(DB_USERNAME,'root');
define(DB_PASSWORD,'');

$dbc = @mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE)
OR die('Could not connect to MySQL' . mysqli_connect_error());
