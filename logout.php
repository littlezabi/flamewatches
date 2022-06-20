<?php require_once './head.php' ?>
<?php
if (isset($_GET['logout'])) {
    // $slug = $_SESSION['user']['slug'] ?? '';
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    if (isset($_COOKIE[$cookies_name])) {
        // if ($slug == '') $slug = $_COOKIE[$cookies_name] ?? '';
        setcookie($cookies_name, '', time() - (60 * 60 * 24 * 30));
    }
    // Logout($slug);
    header('Location: ./login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Logout</title>

    <link rel="stylesheet" href="static/style.css" />
</head>


<body>

    <?php require_once './headers.php' ?>
    <div class="login-container">
        <div class="login-buttons">
            <h2>Logout</h2>
            <a href="./logout.php?logout=1">Logout as current user</a>
        </div>
    </div>
    <?php require_once './footer.php' ?>
</body>

</html>