<header class="fading">
    <nav>
        <ul>
            <a href="/">
                <h3 class="head-logo">FlameWatch</h3>
            </a>
        </ul>
        <ul class="last-ul">
            <div class="more-ul">
                <span class="more-ul-title">More <i class="fa fa-caret-down"> </i></span>
                <ul>
                    <li><a href="/" style="color: dodgerblue"><i class="fa fa-home"></i></a></li>
                    <li><a href="/about.php">about</a></li>
                    <li><a href="/contact.php">contact</a></li>
                    <li><a href="/policy.php">privacy policy</a></li>
                </ul>
            </div>
            <span class="points-tab">
                <small id="points"> <?php echo $points ?? 0; ?> </small>
                <i class="fa fa-gem"></i>
            </span>
            <span class="user-profile">

                <?php
                if ($userStatus) {
                    if ($image != '') {
                        echo '<a href="./logout.php" title="' . $username . '">
                 <img id="profile-img" src=' .  $image . ' alt="..."/><span class="username">' . explode(' ', $username)[0] . '</span>
                </a>';
                    }
                ?>
                <?php
                } else {
                ?>
                    <a href="./login.php">
                        <i style='z-index: 1;' class="fa fa-user"></i>
                    </a>
                <?php

                }
                ?>
                <span class="online-status active"></span>
            </span>
        </ul>
    </nav>
</header>