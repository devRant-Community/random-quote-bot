<?php

// This file is just for the cronjob to call everyday

include("randomQuoteBot.php");

$bot = new RandomQuoteBot("-", "-"); // username: "-", password: "-"
$bot->run();

?>
