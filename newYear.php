<?php

// This file is just for the cronjob to call everyday

include("newYearBot.php");

$bot = new newYearBot("-", "-"); // username: "-", password: "-"
$bot->run();

?>
