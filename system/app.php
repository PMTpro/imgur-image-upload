<?php

    if (!defined('ITek')) exit('Not Access');

    include 'config.php';

    $act   = isset($_GET['act']) ? trim($_GET['act']) : '';
    $kmess = 12;
    $page  = isset($_GET['p']) && $_GET['p'] > 0 ? intval($_GET['p']) : 1;
    $start = $page * $kmess - $kmess;


    /** Connect Database */

    try {
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            PDO::MYSQL_ATTR_INIT_COMMAND       => "SET NAMES 'utf8mb4'"
        ]);
    } catch (PDOException $e) {
        echo '<br /> Config lại đi bạn! :( <br />';
        exit;
    }


    /** Function */

    function paging($url, $start, $total, $kmess)
    {
        $neighbors = 2;
        if ($start >= $total)
            $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
        else
            $start = max(0, (int)$start - ((int)$start % (int)$kmess));

        $base_link = '<a class="paging" href="' . strtr($url, ['%' => '%%']) . 'p=%d' . '">%s</a>';
        $out[]     = $start == 0 ? '' : sprintf($base_link, $start / $kmess, '&lt;&lt;');

        if ($start > $kmess * $neighbors)
            $out[] = sprintf($base_link, 1, '1');

        if ($start > $kmess * ($neighbors + 1))
            $out[] = '<span style="font-weight:bold">...</span>';

        for ($nCont = $neighbors; $nCont >= 1; $nCont--) {
            if ($start >= $kmess * $nCont) {
                $tmpStart = $start - $kmess * $nCont;
                $out[]    = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
            }
        }

        $out[]       = '<b>' . ($start / $kmess + 1) . '</b>';
        $tmpMaxPages = (int)(($total - 1) / $kmess) * $kmess;

        for ($nCont = 1; $nCont <= $neighbors; $nCont++) {
            if ($start + $kmess * $nCont <= $tmpMaxPages) {
                $tmpStart = $start + $kmess * $nCont;
                $out[]    = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
            }
        }

        if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages)
            $out[] = '<span style="font-weight:bold">...</span>';

        if ($start + $kmess * $neighbors < $tmpMaxPages)
            $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);

        if ($start + $kmess < $total) {
            $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
            $out[]        = sprintf($base_link, $display_page, '&gt;&gt;');
        }

        return implode(' ', $out);
    }


    function getSize($size)
    {
        $size = intval($size);

        if ($size < 1024) return $size . ' B';
        elseif ($size < 1048576) return round($size / 1024, 2) . ' KB';
        elseif ($size < 1073741824) return round($size / 1048576, 2) . ' MB';
        elseif ($size < 1099511627776) return round($size / 1073741824, 2) . ' GB';
        elseif ($size < 1125899906842624) return round($size / 1099511627776, 2) . ' TB';
        elseif ($size < 1152921504606846976) return round($size / 1125899906842624, 2) . ' PB';
        elseif ($size < 1180591620717411303424) return round($size / 1152921504606846976, 2) . ' EB';
        elseif ($size < 1208925819614629174706176) return round($size / 1180591620717411303424, 2) . ' ZB';
        else return round($size / 1208925819614629174706176, 2) . ' YB';
    }


    function grab($url)
    {
        $uag = $_SERVER['HTTP_USER_AGENT'];
        $ch  = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $uag);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding: gzip,deflate,sdch',
            'Accept-Language: vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'Connection: keep-alive',
            'Keep-Alive: 300'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Expect:'
        ));

        $kq = curl_exec($ch);
        curl_close($ch);

        return $kq;
    }
