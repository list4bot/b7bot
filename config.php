<?php
ob_start();
$TOKEN = $_ENV["API_TOKEN"];
$Channel = $_ENV["BOT_CHANNEL"];
$UserNameBot = $_ENV["BOT_USER"];


$Host = $_ENV["DB_HOST"];
$UserName = $_ENV["DB_USERNAME"];//username db
$PassWord = $_ENV["DB_PASSWORD"];//password db
$DBName = $_ENV["DB_DATABASE"];//name db

//---------------------
date_default_timezone_set("Asia/Baghdad");