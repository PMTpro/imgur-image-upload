<?php

    if (isset($_COOKIE['login'])) {
        header('Location: index.php');
        exit;
    }

    const ITek = 1;


    include 'system/app.php';

    $title = 'Đăng nhập';
    include 'system/head.php';

    echo '<div class="menu">Đăng nhập</div>';

    if (isset($_POST['ok'])) {
        $tk = trim($_POST['tk']);
        $mk = trim($_POST['mk']);

        if ($tk === AD_USER && $mk === AD_PASS) {
            setcookie('login', 1, time() + 3600 * 24 * 30);
            header('Location: index.php');
            exit;
        } else {
            echo '<div class="content">Sai tài khoản hoặc mật khẩu!</div>';
        }
    }


    echo '<div class="content">
        <form method="post">
        Tài khoản:<br /><input type="text" name="tk" value="" /><br />
        Mật khẩu:<br /><input type="password" name="mk" value="" /><br />
        <input type="submit" name="ok" value="Đăng nhập" />
        </form>
        </div>';

    include 'system/foot.php';
