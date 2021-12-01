<!-- Main navbar -->
<nav>
    <!-- The inner container of navigation. -->
    <div class="navbar-inside-container">
        <!-- Navbar brand -->
        <a href="./index.php" class="navbar-brand">Chat App</a>

        <!-- List holding navigation links. -->
        <ul class="navbar-nav">
            <li>
                <a href="./index.php">Anasayfa</a>
            </li>
            <li>
                <a href="./blog.php">Blog</a>
            </li>
            <li>
                <a href="./about.php">Hakkında</a>
            </li>
            <li>
                <a href="https://github.com/nazimcanislam/chat-app" target="_blank">
                    <i class="fab fa-github"></i>
                </a>
            </li>

            <!-- Nav separator -->
            <li class="navbar-deliv"></li>

            <?php
            /**
             * If the user is logged in, show user specific links, user picture in navigation.
             * If not, show login and register keys.
             */
            ?>
            <?php if (isset($_SESSION['user'])) : ?>
                <li class="user-profile">
                    <a href="./profile.php?user=<?php echo $_SESSION['user']['username'] ?>">
                        <?php if ($_SESSION['user']['profile_image'] != null) : ?>
                            <img src="<?php echo './public_images/' . $_SESSION['user']['profile_image'] ?>" />
                        <?php else : ?>
                            <img src="./public_images/default_profile_image.jpg" />
                        <?php endif; ?>
                        <span>
                            <?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']; ?>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="./new_post.php">Yeni Gönderi</a>
                </li>
                <li>
                    <a href="./chat.php">Chat</a>
                </li>
                <li>
                    <a href="./settings.php">Ayarlar</a>
                </li>
                <li>
                    <a href="./web/logout.php">Çıkış</a>
                </li>
            <?php else : ?>
                <li>
                    <a href="./login.php">Giriş</a>
                </li>
                <li>
                    <a href="./signup.php">Kayıt</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>