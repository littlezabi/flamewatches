<?php

include(__DIR__ . '/../db.php');

function checkUserLoggens($slug, $ip)
{

    if ($slug == '') return 1;
    global $con;
    $sql = "SELECT `ip_address` FROM users WHERE slug = '$slug'";
    $query = $con->query($sql);
    if ($query->num_rows > 0) {
        $prevIP = $query->fetch_assoc();
        if ($prevIP['ip_address'] != $ip) {
            logOut();
        } else return 1;
    } else {
        logOut();
    }
}
function logOut($redirect = true)
{
    $cookies_name = 'firewatch';
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    if (isset($_COOKIE[$cookies_name])) {
        setcookie($cookies_name, '', time() - (60 * 60 * 24 * 30));
    }
    if ($redirect) header('Location: ./login.php');
}
function setConfiguration()
{
    global $con;
    $sql = "SELECT * FROM `config` where id = 1";
    $data  = $con->query($sql);
    $data = $data->fetch_assoc();
    $_SESSION['CONFIG'] = $data;
    return $data;
}

function checkUserLog()
{
    session_start();
    if (isset($_SESSION['user']['slug'])) {
        return $_SESSION['user']['slug'];
    }
    if (isset($_SESSION['user']['data'])) {
        return $_SESSION['user']['data']['slug'];
    } else return 0;
}
$pointsDataJson = file_get_contents('php://input');
$pointsDataObj = json_decode($pointsDataJson);
$pointsData = $pointsDataObj->setPoints ?? 0;
if ($pointsData != 0) {
    $slug = checkUserLog();
    if ($slug != '' || $slug != 0) {
        $points = $pointsDataObj->points;
        $sql = "UPDATE `users` SET `points` = `points` + $points WHERE `slug` = '$slug'";
        $query = $con->query($sql);
        $sql = "SELECT `points` FROM `users` WHERE `slug` = '$slug'";
        $query = $con->query($sql);
        $total = $query->fetch_all(MYSQLI_ASSOC);
        exit($total[0]['points']);
    } else {
        exit('userNotLogged');
    }
}
if (isset($_GET['setVideoWatch'])) {
    session_start();
    $url = $_GET['video'];
    $sql = "UPDATE `vidList` SET `totalWatch` = `totalWatch` + 1 WHERE `url` = '$url' AND `complete` = 0";
    $query = $con->query($sql);
    $sql = "SELECT `totalWatch`, `watchLimit` FROM `vidList` WHERE `url` = '$url' AND `complete` = 0";
    $query = $con->query($sql);
    $total = $query->fetch_assoc();
    $watchLimit = $total['watchLimit'];
    $watchTotal = $total['totalWatch'];
    if ($watchTotal >= $watchLimit) {
        $sql = "UPDATE `vidList` SET `complete` = 1 WHERE `url` = '$url' AND `complete` = 0";
        $con->query($sql);
    }
    exit();
}
if (isset($_GET['delVideo'])) {
    $slug = checkUserLog();
    if ($slug != '' || $slug != 0) {
        $id = $_GET['video'];
        $sql = "DELETE FROM `vidList` WHERE `id` = '$id' AND `user` = '$slug'";
        $query = $con->query($sql);
        $sql = "UPDATE `users` SET `total_links`  = `total_links` - 1 WHERE `slug` = '$slug'";
        $query = $con->query($sql);
        exit('success');
    } else {
        exit('UserNotLogged');
    }
}
if (isset($_GET['vidStatus'])) {
    $slug = checkUserLog();
    if ($slug)
        $status = $_GET['status'] == 1 ? 0 : 1;
    $id = $_GET['id'];
    if ($slug != '' || $slug != 0) {
        $sql = "UPDATE `vidList` SET `active` = $status WHERE `id` = $id AND `user` = '$slug'";
        $query = $con->query($sql);
        exit('success');
    }
}
if (isset($_GET['updatePoints'])) {
    $slug = checkUserLog();
    if ($slug != '' || $slug != 0) {
        $sql = "SELECT `points` FROM `users` WHERE `slug` = '$slug'";
        $query = $con->query($sql);
        $total = $query->fetch_all(MYSQLI_ASSOC);
        exit($total[0]['points']);
    }
}
function setUser($slug)
{
    global $con;
    $slug = $con->real_escape_string($slug);
    $sql = "SELECT * FROM `users` WHERE `slug` = '$slug'";
    $query = $con->query($sql);
    if ($query->num_rows > 0) {
        $data = $query->fetch_assoc();
        $_SESSION['user']['data'] = $data;
        $_SESSION['user']['slug'] = $data['slug'];
        $_SESSION['user']['provider'] = $data['oauth_provider'];
        $_SESSION['user']['fullname'] = $data['name'];
        $_SESSION['user']['email'] = $data['email'];
        $_SESSION['user']['locale'] = $data['locale'];
        $_SESSION['user']['profile_pic'] = $data['picture'];
        return 1;
    } else {
        if (isset($_SESSION['user'])) unset($_SESSION['user']);
        return 0;
    }
}
if (isset($_GET['addVid'])) {
    $watches = $con->real_escape_string($_GET['watches']);
    $watches = base64_decode($watches);

    $url = $con->real_escape_string($_GET['url']);
    $url = base64_decode($url);
    $full_url = $con->real_escape_string($_GET['full_url']);
    $full_url = base64_decode($full_url);
    $slug = checkUserLog();
    if ($slug != "" || $slug != 0) {
        $sql = "SELECT * FROM `vidList` WHERE url = '$url' AND `complete` = 0";
        $query = $con->query($sql);
        if ($query->num_rows > 0) exit('urlAlreadyExist');
        else {
            $sql = "SELECT `points`,`total_links` FROM `users` WHERE `slug` = '$slug'";
            $query = $con->query($sql);
            $data = $query->fetch_assoc();
            $points = $data['points'];
            $total_links = $data['total_links'];
            $totalPointRed = (int)$_SESSION['CONFIG']['deductPointsPerWatch'] * $watches;
            if ($points < $totalPointRed) exit('lessPoints');
            $tasks = (int)$_SESSION['CONFIG']['allowTaskForLocalUser'];
            if ($total_links >= $tasks) exit('tasksReached');
            $sql = "INSERT INTO `vidList` (`url`, `user`, `full_url`, `watchLimit`) VALUES('$url', '$slug', '$full_url', $watches)";
            $con->query($sql);
            $sql = "UPDATE `users` SET `total_links` = `total_links`+1, `points` = `points` - $totalPointRed  WHERE `slug` = '$slug' ";
            $con->query($sql);
            exit('success');
        }
    } else {
        exit('UserNotLogged');
    }
}
function getVidList()
{
    global $con;
    $data = [];
    $sql = "SELECT COUNT(id) as `total_vids` FROM `vidList` WHERE `active` = 1 AND `complete` = 0";
    $count = $con->query($sql);
    $OFFSET = 25;
    if ($count->num_rows > 0) {
        $count = $count->fetch_assoc();
        $total = $count['total_vids'];
        if ($total > 25) {
            $OFFSET = rand(0, $total - 3);
        } else {
            $OFFSET = 0;
        }
    }
    $sql = "SELECT * FROM vidList WHERE `active` = 1 AND `complete` = 0 LIMIT $OFFSET, 25";
    $query = $con->query($sql);
    if ($query->num_rows > 0) {
        $data = $query->fetch_all(MYSQLI_ASSOC);
    }
    return json_encode($data);
}
if (isset($_GET['vidList'])) {
    exit(getVidList());
}

if (isset($_GET['setConfig'])) {
    $type = $_GET['type'];
    $state = $_GET['state'];
    if ($type == 'autoplay') {
        setcookie('fireAutoPlay', $state, time() + (60 * 60 * 24 * 365), '/');
    }

    exit('success');
}

function my_ip()
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

if (isset($_GET['checkLoginStatus'])) {
    $ip = my_ip();
    $slug = checkUserLog();
    if ($slug != '' || $slug != 0) {
        $sql  = "SELECT `ip_address` FROM `users` WHERE `slug` = '$slug'";
        $query = $con->query($sql);
        if ($query->num_rows > 0) {
            $user_ip = $query->fetch_assoc();
            if ($user_ip['ip_address'] == $ip) {
                exit('logged');
            } else {
                logOut($redirect = false);
                exit('userNotLogged');
            }
        } else {
            logOut($redirect = false);
            exit('userNotLogged');
        }
    } else {
        logOut($redirect = false);
        exit('userNotLogged');
    }
}
