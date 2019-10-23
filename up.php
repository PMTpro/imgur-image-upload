<?php

if (!isset($_COOKIE['login'])) exit('Not Access');

define('ITek', 1);

include 'system/app.php';

$title = 'Upload Ảnh';
include 'system/head.php';

echo '<div class="menu">Upload Ảnh</div>';

if (isset($_POST['submit'])) {
    if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
        header('Location: up.php');
        exit;
    }

    $img = $_FILES['img'];
    $link = isset($_POST['link']) ? trim($_POST['link']) : '';

    if (!empty($img['name'])){
        $tmp = $img['tmp_name'];
        $temp = fopen($tmp, "r");
        $data = fread($temp, filesize($tmp));
        $pvars = array('image' => base64_encode($data));
    } elseif (!empty($link) && $link != 'http://' && $link != 'https://'){
        $img2 = grab($link);
        $pvars = array('image' => base64_encode($img2));
    } else {
        echo '<div class="content">Chưa chọn hình!</div>';
    }

    if (!empty($pvars)) {
        $client_id = '1bdd22723dc59a8';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID '. $client_id));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);

        $out = curl_exec($curl);
        curl_close ($curl);

        $pms = json_decode($out, true);


        if (!empty($pms['data']['link'])) {
            $url = $pms['data']['link'];
            $size = intval($pms['data']['size']);
            $width = intval($pms['data']['width']);
            $height = intval($pms['data']['height']);

            $db->prepare("INSERT INTO `img` SET
                `url` = ?,
                `time` = ?,
                `size` = ?,
                `width` = ?,
                `height` = ?
            ")->execute([
                $url,
                time(),
                $size,
                $width,
                $height
            ]);

            $id = $db->lastInsertId();

            header('Location: index.php?id=' . $id);
            exit;
        } else {
            echo '<div class="content">Ảnh lỗi</div>';
        }
    }
}

$token = time();
$_SESSION['token'] = $token;

echo '<div class="content center">
    <form enctype="multipart/form-data" method="post">
    Chọn File:<br /><input name="img" type="file" /><br />
    Import:<br /><input name="link" type="text" /><br />
    <input type="hidden" name="token" value="'. $token .'" />
    <input type="submit" name="submit" value="Upload" />
    </form>
    </div>';

include 'system/foot.php';
