<?php
require '../db.php';
require '../functions/functions.php';

session_start();
if (isset($_SESSION['login_id'])) {
    header('Location: home.php');
    exit;
}

require_once './client.php';


if (isset($_GET['code'])) :

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token["error"])) {

        $client->setAccessToken($token['access_token']);

        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
       
        $id = mysqli_real_escape_string($con, $google_account_info->id);
        $full_name = mysqli_real_escape_string($con, trim($google_account_info->name));
        $email = mysqli_real_escape_string($con, $google_account_info->email);
        $locale = mysqli_real_escape_string($con, $google_account_info->locale);
        $profile_pic = mysqli_real_escape_string($con, $google_account_info->picture);
        // Storing data into database

        // checking user already exists or not
        $get_user = mysqli_query($con, "SELECT * FROM `users` WHERE `oauth_uid`='$id'");
        $ip = get_client_ip() ?? '::1';
        if (mysqli_num_rows($get_user) > 0) {
            $row = $get_user->fetch_assoc();
            $slug = $row['slug'];
            $_SESSION['user']['data'] = $row;
            $_SESSION['user']['slug'] = $slug;
            $sql = "UPDATE `users` SET `ip_address` = '$ip' WHERE `slug` = '$slug'";
            $sql = $con->query($sql);
            header('Location: /');
            exit();
        } else {
            $defPoints = 600;
            $sql = "SELECT `config`.`bonusPoints` as `bp` FROM `config` WHERE `config`.`id` = 1";
            $sql = $con->query($sql);
            if ($sql->num_rows > 0) {
                $bpoints = $sql->fetch_assoc();
                $defPoints = $bpoints['bp'];
            }
            // if user not exists we will insert the user
            $slug = RStrings($limit = 25);
            $sql = "INSERT INTO `users`(`oauth_provider`, `oauth_uid`, `name`, `email`,  `locale`, `picture`, `slug`, `points`,`ip_address`) VALUES  ('google',$id,'$full_name','$email','$locale','$profile_pic', '$slug', $defPoints, '$ip')";
           
            $insert = $con->query($sql);
            
            if ($insert) {
                $_SESSION['user']['data'] = ['points' => 0, 'slug' => $slug, 'fullname' => $full_name, 'email' => $email, 'locale' => $locale, 'picture' => $profile_pic];
                $_SESSION['user']['slug'] = $slug;
                $_SESSION['user']['fullname'] = $full_name;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['locale'] = $locale;
                $_SESSION['user']['picture'] = $profile_pic;
                header('Location: /');
                exit();
            } else {
                $_SESSION['msg']['text'] = "Sign up failed! (Something went wrong).";
                $_SESSION['type']['type'] = 'error';
                header('Location: /');
            }
        }
    } else {
        header('Location: login.php');
        exit();
    }
else : 
    // Google Login Url = $client->createAuthUrl(); 
?>

<?php endif; ?>