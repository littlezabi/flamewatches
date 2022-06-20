<?php require_once __DIR__ . '/head.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Contact</title>
    <link rel="stylesheet" href="static/style.css" />
</head>

<body>
    <div class="container">
        <?php require_once __DIR__ . '/headers.php' ?>
        <main class="main">
            <div style="display: none">
                <div id="mainframe"></div>
                <div class="watch-counter"><input type="text"></div>
            </div>
            <div class="about">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80" alt="">
                    <div>

                        <h3>
                            Privacy Policy
                        </h3>
                        <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat officiis excepturi dignissimos nobis sunt eligendi consequuntur, perspiciatis tempore suscipit ratione? Recusandae dolor vero nulla aperiam, totam quaerat ex esse cumque!
                            Quis expedita eos voluptatum, dolor in voluptas nobis maiores, amet voluptates praesentium qui deserunt esse! Optio pariatur ea dicta delectus rem necessitatibus? Voluptatibus asperiores eum reprehenderit error modi doloremque similique.
                            Expedita, ab! Vitae delectus qui quas, esse iure accusamus omnis facere cum quo saepe iusto, eveniet alias dolorem accusantium dignissimos deserunt, quis dolor a expedita. Tenetur vel quis ex officiis.</span>
                        <br>
                        <h3>
                            Terms
                        </h3>
                        <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat officiis excepturi dignissimos nobis sunt eligendi consequuntur, perspiciatis tempore suscipit ratione? Recusandae dolor vero nulla aperiam, totam quaerat ex esse cumque!
                            Quis expedita eos voluptatum, dolor in voluptas nobis maiores, amet voluptates praesentium qui deserunt esse! Optio pariatur ea dicta delectus rem necessitatibus? Voluptatibus asperiores eum reprehenderit error modi doloremque similique.
                            Expedita, ab! Vitae delectus qui quas, esse iure accusamus omnis facere cum quo saepe iusto, eveniet alias dolorem accusantium dignissimos deserunt, quis dolor a expedita. Tenetur vel quis ex officiis.</span>
                        <br>
                        <h3>
                            Conditions
                        </h3>
                        <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat officiis excepturi dignissimos nobis sunt eligendi consequuntur, perspiciatis tempore suscipit ratione? Recusandae dolor vero nulla aperiam, totam quaerat ex esse cumque!
                            Quis expedita eos voluptatum, dolor in voluptas nobis maiores, amet voluptates praesentium qui deserunt esse! Optio pariatur ea dicta delectus rem necessitatibus? Voluptatibus asperiores eum reprehenderit error modi doloremque similique.
                            Expedita, ab! Vitae delectus qui quas, esse iure accusamus omnis facere cum quo saepe iusto, eveniet alias dolorem accusantium dignissimos deserunt, quis dolor a expedita. Tenetur vel quis ex officiis.</span>
                        <br>

                    </div>
                </div>
                <div class="common">
                    <h3>
                        About Developer <i style="font-size: 22px" class="fa fa-feather"></i>
                    </h3>
                    <p>
                        Hey I'am M. Zohaib "AKA the LittleZabi". I am a professional developer with 8 years of experience. I Developed this site by my own codes and terms there is no copy of other sites and apps.
                        Today Date is SUNDAY 19 JUNE 2022 I started work on this project about 1 week before and now it's completed and this is my final touch.
                        I have claim rights by any breaking rules and condtions.
                    </p>
                </div>
            </div>


        </main>
        <?php require_once __DIR__ . '/footer.php' ?>
    </div>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js"></script>
<script>
    let autoplay = 0
    let muteVideo = 0
    let userLogged = 0
    let RawVidList = []
</script>
<script src="./static/variables.js"></script>
<script src="./static/requests.js"></script>
<script src="./static/main.js"></script>