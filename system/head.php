<?php

if(!defined('ITek')) exit('Not Access');

$title = isset($title) ? htmlspecialchars($title) : 'Upload ảnh';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/style.css" media="all,handheld" />
<title><?php echo $title; ?></title>
</head>
<body>

<div class="logo">
<a href="<?php echo HOME; ?>"><img src="<?php echo IMG; ?>/logo.png" /></a><br />
</div>

<div class="nav">
<table width="100%">
<tr>
<td width="50%" class="center"><a href="<?php echo HOME; ?>">HOME</a></td>
<td width="50%" class="center"><a href="up.php">Upload</a></td>
</tr>
</table>
</div>

<div class="content">
<img src="<?php echo IMG; ?>/icon/o.png" />
<?php echo (!isset($_COOKIE['login']) ? '<a href="' . HOME . '/login.php">Đăng nhập</a>' : '<a href="' . HOME . '/exit.php">Đăng xuất</a>'); ?>
</div>
