<?php

// This file is just for the cronjob to call everyday

include("main.php");

$bot = new Bot(0, "-", 0); // token_id: 0, token_key: "", user_id: 0   ---> No login data for you :)
$bot->run();

?>
