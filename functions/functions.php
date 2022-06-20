<?php
function RStrings($limit = 25)
{
    $str = 'abcdefg1234567890abcdefg';
    // $str = strtoupper($str);
    $k = 0;
    $final = '';
    $grp = '';
    while ($k < $limit) {
        $k++;
        $index = random_int(0, (strlen($str) - 1));
        $grp .= $str[$index];
        if (strlen($grp) >= 5) {
            $final .= $grp . '-';
            $grp = '';
        }
    }
    if ($final[(strlen($final) - 1)] == '-') {
        $final = substr_replace($final, "", -1);
    }
    return $final;
}

function printArr($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
// echo get_client_ip();
