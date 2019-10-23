<?php

if (!defined('ITek')) exit('Not Access');

error_reporting(-1);

session_start();

ob_start();

date_default_timezone_set('Asia/Ho_Chi_Minh');

/** Url */
define('HOME', 'http://localhost:8000/imgur');
define('CSS', HOME . '/asset/css');
define('IMG', HOME . '/asset/images');

/** Database */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_NAME', 'imgur');
define('DB_PASS', '');

/** Account */
define('AD_USER', 'pmtpro');
define('AD_PASS', '@@@@@');
