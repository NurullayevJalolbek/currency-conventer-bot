<?php

declare(strict_types=1);

$update = json_decode(file_get_contents('php://input'));

require "vendor/autoload.php";


if (isset($update)) {
    require 'bot.php';
    return;
}

