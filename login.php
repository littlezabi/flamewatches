<?php require_once './head.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Login</title>

    <link rel="stylesheet" href="static/style.css" />
</head>


<body>

    <?php require_once './glogin/client.php' ?>
    <?php require_once './headers.php' ?>
    <div class="login-container fade">
        <div class="login-buttons">
            <h2>Login</h2>
            <a href="<?php echo $client->createAuthUrl(); ?>"><i class='fab fa-google-plus-square gmail'></i>Login with google</a>
        </div>
    </div>
    <?php require_once './footer.php' ?>
</body>

</html>