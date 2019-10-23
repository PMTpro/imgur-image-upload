<?php

if (!isset($_COOKIE['login'])) exit('Not Access');

define('ITek', 1);

include 'system/app.php';

if (isset($_POST['ok'])){
    setcookie('login', null, 0);
    session_destroy();

    header('Location: index.php');
    exit;
}


$title = 'Đăng xuất';
include 'system/head.php';

echo '<div class="menu">Đăng xuất</div>';
echo '<div class="content">
    <form method="post">
    Xác nhận thoát!<br />
    <input type="submit" name="ok" value="OK" />
    </form>
    </div>';

include 'system/foot.php';
