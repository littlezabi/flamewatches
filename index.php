<?php require_once __DIR__ . '/head.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <title>HOME </title>
  <link rel="stylesheet" href="static/style.css" />
</head>

<body>
  <div class="container">
    <?php require_once __DIR__ . '/headers.php' ?>
    <main class="main fading">
      <div class="modal fade">
        <div class="modal-add-new">
          <div class="form fade">
            <h3>Add Your Video URL</h3>
            <input type="text" placeholder="Add video url here..." id="vid-link">
            <div class="watch-counter">
              <button onclick="setWatchCounter(0)" class="btns">-</button>
              <input type="number" value="10" min="10" />
              <button onclick="setWatchCounter(1)" class="btns">+</button>
            </div>
            <div class="counter-multiplier"><span class="counter">10</span> X <span>60</span> = <span class="coins">600</span></div>
            <div class="counter-multiplier"><span class="counter">Your current coins is <span id="coins-view"><?php echo $points ?></span></span></div>
            <button class='add-btn' onclick="addVideo()">Add</button>
            <button class='add-btn close' onclick="document.querySelector('.modal').style.display = 'none'">Close</button>
            <span class="message" id="message" style="padding: 5px"><?php echo $userStatus == 0 ? 'Login to add your points and videos!<br/><a href="./login.php">Login now</a>' : '' ?> </span>
          </div>
        </div>
      </div>
      <div>
        <div id="AD-box">
        </div>
        <div class="full-flex">
          <div id="AD-box">
          </div>
          <div>

            <div class="controls">
              <div class="tab">
                <span class="btn-title">autoplay</span>
                <button onclick="buttonAction(this, 'autoplay', <?php echo $autoPlay; ?>)" class="autoPlayBtn <?php echo $autoPlay == 1 ? 'active' : '' ?>">
                  <span class="button-state"></span>
                </button>
              </div>
             <!-- <div class="tab">
                <span class="btn-title">Mute Sound</span>
                <button onclick="buttonAction(this, 'mutesound', <?php echo $muteSound; ?>)" class="autoPlayBtn <?php echo $muteSound == 1 ? 'active' : '' ?>">
                  <span class="button-state"></span>
                </button>
              </div> -->
            </div>
            <div class="frame">
              <div class="overlay-subs"></div>
              <div class="overlay-vid"></div>
              <div id="mainframe" class="fade"></div>
            </div>
            <br>
            <?php if ($userStatus == 0) { ?><center><button class="add-new-vid" onclick="window.location.href='/login.php';">Login Now to Play</button></center><?php } ?>
            <br>
          </div>
          <div id="AD-box">
          </div>
        </div>
        <div class="loading-bar fade">
          <div class="load-cont">
            <div class="filler"></div>
          </div>
          <span class="timer"> <span class="seconds">0</span> Seconds </span>
          <div style="display: flex">
            <button class="add-new-vid" onclick="playNext()">Play next</button>
            <button class="add-new-vid" style="margin-left: 5px" onclick="showModal('add-new-vid')">Add Your video</button>

          </div>
          <div class="views-table">
            <?php
            if ($slug != '') {
              $sql = "SELECT * FROM `vidList` WHERE `user` = '$slug'";
              $query = $con->query($sql);
              if ($query->num_rows > 0) {
                while ($row = $query->fetch_assoc()) {
            ?>
                  <div class="item">
                    <img src="https://i.ytimg.com/vi/<?php echo $row['url']; ?>/hqdefault.jpg" alt="">
                    <div class="item-details">
                      <span><a style="color:#3f51b5" target="blank_" href="<?php echo $row['full_url']; ?>"><?php echo $row['full_url']; ?></a></span>
                      <div class="inner-item">
                        <div class="inner-item-k">
                          <span>Uploaded on:
                            <?php
                            $date = date_create($row['createdAt']);
                            echo date_format($date, "d M Y");
                            ?>
                          </span>
                          <span>Views: <?php echo $row['totalWatch']; ?></span>
                          <span>Complete: <?php echo $row['complete'] == 1 ? '<i class="fa fa-check" style="color:dodgerblue;padding:0 5px;"></i>' : '<i><small>Waiting</small></i>' ?></span>
                        </div>
                        <div class="inner-item-btn">

                          <button onclick="handleDelete(<?php echo $row['id']; ?>, this)">Delete</button>
                          <button class="<?php echo $row['active'] == 0 ? 'active' : 'disable' ?>" onclick="handleStatus(<?php echo $row['id']; ?>, <?php echo $row['active']; ?>, this)"><?php echo $row['active'] == 0 ? 'Active' : 'Disable' ?></button>
                        </div>
                      </div>
                    </div>
                    <div>
                    </div>
                  </div>
            <?php }
              }
            } ?>
          </div>

          <!-- <button class="add-new-vid" onclick="setPoints(10)">Add Your video</button> -->
          <span class="message inlineMsg error"><?php echo $userStatus == 0 ? 'Login to add your points and videos!<br/>
          <a href="./login.php">Login now</a>
          ' : '' ?></span>
        </div>
        <div id="AD-box">
        </div>
      </div>

    </main>
    <?php require_once __DIR__ . '/footer.php' ?>
  </div>
</body>

</html>
<?php

echo '<script>

  let RawVidList = ' . $data . ';
  let userLogged = ' . $userStatus . ';
  let autoplay = ' . $autoPlay . ';
  let muteVideo = ' . $muteSound . ';
  
  
</script>';

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js"></script>
<script src="./static/variables.js"></script>
<script src="./static/requests.js"></script>
<script src="./static/main.js"></script>