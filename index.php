<?php

define('ITek', 1);

include 'system/app.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


if ($act == 'del') {
    if (!isset($_COOKIE['login'])) exit('Not Access');

    //Delete IMG

    $title = 'Xóa Ảnh';
    include 'system/head.php';

    echo '<div class="menu">Xóa ảnh</div>';

    $check = $db->query("SELECT COUNT(*) FROM `img` WHERE `id` = '$id'")->fetchColumn();

    if (!$check) {
        echo '<div class="content">File ảnh không tồn tại!</div>';
    } else {
        if (isset($_POST['ok'])) {
            $db->exec("DELETE FROM `img` WHERE `id` = '$id'");
            header('Location: index.php');
            exit;
        }

        echo '<div class="content">
        <form method="post">
        Xác nhận xoá!<br />
        <input type="submit" name="ok" value="Xoá" />
        </form>
        </div>';
    }
} else {
    if (isset($_GET['id'])) {
        //Info IMG

        $title = 'Thông tin ảnh';
        include 'system/head.php';

        echo '<div class="menu">Thông tin</div>';

        $stmt = $db->query("SELECT * FROM `img` WHERE `id` = '$id'");

        if (!$stmt->rowCount()) {
            echo '<div class="content">File ảnh không tồn tại hoặc đã bị xóa!</div>';
        } else {
            $res = $stmt->fetch();

            echo '<div class="content">
                <center>
                <br />
                <img src="' . $res['url'] . '" /><br /><br />
                <a href="' . $res['url'] . '"><div class="button" style="background-color:green">Tải Xuống (' . getSize($res['size']) . ')</div></a>
                </center><br />

                &bull; Ngày Upload: ' . date('d/m/Y', $res['time']) . '<hr />
                &bull; Kích thước: ' . getSize($res['size']) . '<hr />
                &bull; Độ phân giải: ' . $res['width'] . ' x ' . $res['height'];

            if (isset($_COOKIE['login']))
                echo '<hr /><a href="index.php?act=del&id=' . $res['id'] . '"><div class="button">Xóa</div></a>';

            echo '</div>';
            echo '<div class="menu">Chia sẻ:</div>
                <div class="content">
                URL:<br /><input type="text" value="' . $res['url'] . '" /><br />
                BBCODE:<br /><input type="text" value="[img]' . $res['url'] . '[/img]" />
                </div>';
        }
    } else {
        //Index IMG

        $title = 'Upload Ảnh';
        include 'system/head.php';

        $total = $db->query("SELECT COUNT(*) FROM `img`")->fetchColumn();
        echo '<div class="menu">Thư viện ảnh (<b>' . $total . '</b>)</div>';

        if (!$total) {
            echo '<div class="content">Không có gì!</div>';
        } else {
            $reg = $db->query("SELECT * FROM `img` ORDER BY `time` DESC LIMIT $start, $kmess");
            echo '<div class="content">';

            while ($res = $reg->fetch()) {
                echo '<a href="index.php?id=' . $res['id'] . '">
                <img src="' . $res['url'] .'" width="75px" height="75px" style="margin:4px; padding:4px; border:1px solid #ddd;" />
                </a>';
            }

            echo '</div>';

            if ($total > $kmess) echo '<div class="content center" style="margin-top: 4px">' . paging('index.php?' , $start , $total , $kmess) . '</div>';
        }
    }
}

include 'system/foot.php';
