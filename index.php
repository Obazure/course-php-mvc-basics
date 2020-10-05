<?php
session_start();

if (function_exists('date_default_timezone_set'))
	date_default_timezone_set('Asia/Almaty');

	#ini_set('display_errors', 1);

	
require_once 'app/bootstrap.php';
