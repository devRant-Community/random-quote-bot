<?php

// This file is just for the cronjob to call everyday

include("main.php");

$bot = new Bot();
$quote = $bot->getQuote();
$bot->post($quote);

?>
