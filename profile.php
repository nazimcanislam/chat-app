<?php

// Start session processes.
session_start();
ob_start();

// Start database operations.
define("database", true);
require_once './web/database.php';

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <!-- Page title -->
    <title>Chat App | Blog</title>

    <!-- Important meta tags -->
    <meta charset="utf-8" />
    <meta name="author" content="Nazımcan İslam" />
    <meta name="description" content="Hızlı, güvenli web tabanlı mesajlaşma uygulaması." />
    <meta name="keywords" content="chat, chat app, mesajlaşma" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Includes Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />

    <!-- Include custom CSS -->
    <link rel="stylesheet" href="./assets/master.css" />
    <link rel="stylesheet" href="./assets/index.css" />

    <!-- Include Font Awesome 5 from CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <!-- Load favicon files -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon_io/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon_io/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon_io/favicon-16x16.png" />
    <link rel="manifest" href="./assets/favicon_io/site.webmanifest" />

    <style>
        .user-profile-container {
            margin: 32px auto;
            background-color: #ecf0f1;
            max-width: 100%;
            width: 1024px;
            padding: 84px;
            box-shadow: 0 1px 3px -1px rgba(0, 0, 0, 0.75);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .user-profile-container .user-profile-inner {
            width: 100%;
        }

        .user-profile-container .user-profile-inner .user-header {
            width: 60%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin: 0 auto;
        }

        .user-profile-container .user-profile-inner .user-header > img {
            width: 120px;
            height: auto;
            border-radius: 50%;
        }

        .user-profile-container .user-profile-inner form {
            width: 500px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            margin: 32px auto 0 auto;
        }

        .user-profile-container .user-profile-inner form input {
            margin-bottom: 16px;
            border: 1px solid rgba(0, 0, 0, 0.4);
            border-radius: 6px;
            padding: 8px 10px;
        }

        .user-profile-container .user-profile-inner form label {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
            width: max-content;
        }

        .user-profile-container .user-profile-inner form button {
            width: max-content;
        }

        .lost-user {
            width: 100%;
            margin: 0 auto;
            text-align: center;
            padding: 32px;
        }

        .lost-user h1 {
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <?php require_once './includes/nav.php'; ?>

    <?php if ($_GET): ?>
        <?php if ($_GET['user']): ?>
            <?php

            $username = $_GET['user'];
            $user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'")->fetch_assoc();

            ?>
            <?php if ($user): ?>
                <div class="user-profile-container">
                    <div class="user-profile-inner">
                        <div class="user-header">
                            <?php if ($user['profile_image'] != null): ?>
                                <img src="./public_images/<?php echo $user['profile_image']; ?>" />
                            <?php else: ?>
                                <img src="./public_images/default_profile_image.jpg" />
                            <?php endif; ?>

                            <div>
                                <h1>
                                    <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
                                </h1>
                                <span>
                                    <?php echo '@' . $user['username']; ?>
                                </span>
                            </div>
                        </div>

                        <?php if ($_SESSION): ?>
                            <?php if (isset($_SESSION['user'])): ?>
                                <?php if ($_SESSION['user']['id'] == $user['id']): ?>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <label for="user-profile-image-change">Profile resmi seç</label>
                                        <input type="file" name="user-profile-image-change" id="user-profile-image-change" accept="image/png, image/jpeg" />

                                        <label for="user-first-name">Ad</label>
                                        <input type="text" name="user-first-name" id="user-first-name" value="<?php echo $user['first_name'] ?>" />

                                        <label for="user-last-name">Soyad</label>
                                        <input type="text" name="user-last-name" id="user-last-name" value="<?php echo $user['last_name'] ?>" />

                                        <label for="user-email">E-Posta</label>
                                        <input type="email" name="user-email" id="user-email" required value="<?php echo $user['email'] ?>" />

                                        <label for="user-password">Parola</label>
                                        <input type="password" name="user-password" id="user-password" />

                                        <label for="user-password-confirm">Parolayı onayla</label>
                                        <input type="password" name="user-password-confirm" id="user-password-confirm" />

                                        <button type="submit" class="button button-primary">Kaydet</button>
                                    </form>
                                <?php else: ?>
                                    <form action="" method="POST" style="align-items: center;">
                                        <button type="submit" class="button button-primary">Sohbet</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="lost-user">
                    <h1 style="font-weight: normal;">Hımm... Burda <strong><?php echo $_GET['user']; ?></strong> diye birisi yok. Gel biz anasayfaya gidelim.</h1>
                    <a href="./index.php" class="button button-primary button-large">Tamam!</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="lost-user">
                <h1>Burada hiçbir şey yok. Acaba kayıp mı oldun?<br />Gel hadi, anasayfaya dönelim.</h1>
                <a href="./index.php" class="button button-primary button-large">Tamam!</a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="lost-user">
            <h1>Burada hiçbir şey yok. Acaba kayıp mı oldun?<br />Gel hadi, anasayfaya dönelim.</h1>
            <a href="./index.php" class="button button-primary button-large">Tamam!</a>
        </div>
    <?php endif; ?>
</body>

</html>
