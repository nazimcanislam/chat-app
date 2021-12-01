<?php

session_start();
ob_start();

define('database', true);

require_once './web/database.php';



print_r($opponent_user);

