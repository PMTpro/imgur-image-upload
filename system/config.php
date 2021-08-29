<?php

    if (!defined('ITek')) exit('Not Access');

    error_reporting(-1);

    session_start();

    ob_start();

    date_default_timezone_set('Asia/Ho_Chi_Minh');

    /** Url */
    define('HOME', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME']);
    const CSS = HOME . '/asset/css';
    const IMG = HOME . '/asset/images';

    /** Database */
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_NAME = 'imgur';
    const DB_PASS = '';

    /** Account */
    const AD_USER = 'pmtpro';
    const AD_PASS = '@@@@@';
