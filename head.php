<?php
require_once 'functions/action.php';
require_once 'functions/functions.php';
session_start();
setConfiguration();
$userStatus = 0;
$cookies_name = 'firewatch';
$slug = '';
if (isset($_SESSION['user']) && $_SESSION['user']['slug'] != '') {
    $slug = $_SESSION['user']['slug'];
    $userStatus = 1;
    if (!isset($_COOKIE[$cookies_name])) {
        $k = setcookie($cookies_name, $slug, time() + (60 * 60 * 24 * 30), '/');
        $userStatus = setUser($slug);
    } else {
        $userStatus = setUser($slug);
    }
} else {
    if (isset($_COOKIE[$cookies_name])) {
        $slug = $_COOKIE[$cookies_name];
        $userStatus = setUser($_COOKIE[$cookies_name]);
    } else $userStatus = 0;
}
checkUserLoggens($slug, get_client_ip());

$image = '';
$username = '';
$points = 0;
$autoPlay = 0;
$muteSound = 0;
if (isset($_COOKIE['fireAutoPlay']) || isset($_COOKIE['fireMuteSound'])) {
    $autoPlay = $_COOKIE['fireAutoPlay'] ?? 0;
    $muteSound = $_COOKIE['fireMuteSound'] ?? 0;
    if ($autoPlay == 'true') $autoPlay  = 1;
    else $autoPlay = 0;
    if ($muteSound == 'true') $muteSound  = 1;
    else $muteSound  = 0;
}
if (isset($_SESSION['user']['data'])) {
    $data = $_SESSION['user']['data'];
    $image = $data['picture'] ?? $data['profile_picture'] ?? '';
    $username = $data['fullname'] ?? $data['name'];
    $points = $data['points'] ?? 0;
}
$data = getVidList();
// printArr(json_decode($data));
