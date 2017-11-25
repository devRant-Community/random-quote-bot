<?php

// This file is just for the cronjob to call everyday

include("main.php");

$bot = new Bot("-", "-"); // username: "-", password: "-"
$bot->run();

?>
