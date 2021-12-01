<?php

// Start session processes.
session_start();
ob_start();

// If a user already exists, redirect to the chat page.
if ($_SESSION) {
    if (isset($_SESSION['user'])) {
        header("Location: chat.php");
    }
}

// Start database operations.
define('database', true);
require_once './web/database.php';

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <!-- Page title -->
    <title>Chat App | Kayıt</title>

    <!-- Important meta tags -->
    <meta charset="utf-8" />
    <meta name="author" content="Nazımcan İslam" />
    <meta name="description" content="A simple chat app written in pure PHP and MySQL." />
    <meta name="keywords" content="chat, chat app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Includes Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />

    <!-- Include custom CSS -->
    <link rel="stylesheet" href="./assets/master.css" />
    <link rel="stylesheet" href="./assets/login_and_signup.css" />

    <!-- Include Font Awesome 5 from CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <!-- Load favicon files -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon_io/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon_io/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon_io/favicon-16x16.png" />
    <link rel="manifest" href="./assets/favicon_io/site.webmanifest" />
</head>

<body class="body-center">
    <div class="login-container">
        <a class="back-to-home-button" href="./index.php">
            <i class="fas fa-home"></i>
        </a>

        <img src="./assets/svg/undraw_Messaging_fun_re_vic9.svg" alt="" class="intro-svg-image" />
        <div class="form-container">
            <img src="./assets/svg/undraw_profile_pic_ic5t.svg" alt="" />
            <h1>Chat App</h1>
            <p>Konuşmanın hızlı ve güvenli yolu</p>
            <form method="POST" action="./web/user_sign.php">
                <!-- Fullname -->
                <div class="user-detail-field">
                    <label for="user-fullname">
                        <i class="fas fa-user"></i>
                        <span>Ad Soyad</span>
                    </label>
                    <input type="text" name="user-fullname" id="user-fullname" required>
                </div>

                <!-- Username -->
                <div class="user-detail-field">
                    <label for="user-username">
                        <i class="fas fa-user-tie"></i>
                        <span>Kullanıcı Adı</span>
                    </label>
                    <input type="text" name="user-username" id="user-username" required>
                </div>

                <!-- Email -->
                <div class="user-detail-field">
                    <label for="user-email">
                        <i class="fas fa-at"></i>
                        <span>E-Posta</span>
                    </label>
                    <input type="email" name="user-email" id="user-email" required>
                </div>

                <!-- Password -->
                <div class="user-detail-field">
                    <label for="user-password">
                        <i class="fas fa-lock"></i>
                        <span>Parola</span>
                    </label>
                    <input type="password" class="user-password" name="user-password" id="user-password" required>

                    <!-- Show password -->
                    <i class="fas fa-eye-slash show-password-eye"></i>
                </div>

                <!-- Re-password -->
                <div class="user-detail-field">
                    <label for="user-re-password">
                        <i class="fas fa-lock"></i>
                        <span>Parolayı doğrula</span>
                    </label>
                    <input type="password" class="user-password" name="user-re-password" id="user-re-password" required>

                    <!-- Show password -->
                    <i class="fas fa-eye-slash show-password-eye"></i>
                </div>

                <?php
                /**
                 * If there is an error, check what it is and write it on the screen.
                 */
                ?>
                <?php if ($_SESSION): ?>
                    <?php if ($_SESSION['error']): ?>
                        <p class="error-catch">
                            <?php
                            
                            switch ($_SESSION['error']) {
                                case 'empty-user-fullname':
                                    echo 'Lütfen adınızı soyadınızı boş bırakmayınız!';
                                    break;
                                case 'empty-user-username':
                                    echo 'Lütfen kullanıcı adınızı boş bırakmayınız!';
                                    break;
                                case 'empty-user-email':
                                    echo 'Lütfen E-Posta adresinizi boş bırakmayınız!';
                                    break;
                                case 'empty-user-password':
                                    echo 'Lütfen parolanızı boş bırakmayınız!';
                                    break;
                                case 'invalid-user-email':
                                    echo 'Lütfen uygun bir E-Posta adresi giriniz.';
                                    break;
                                case 'user-password-match':
                                    echo 'Lütfen parolalarınızın eşleştiğinden emin olunuz!';
                                case 'user-email-already-exists':
                                    echo 'Böyle bir E-Posta adresinde zaten bir kullanıcı var!';
                                    break;
                                case 'user-username-already-exists':
                                    echo "Bu kullanıcı adı zaten kullanımda!";
                                    break;
                                default:
                                    header("Location: ./login.php");
                                    break;
                            }

                            // Destroy the error sessions!
                            unset($_SESSION['error']);

                            ?>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>

                <a href="./login.php" class="account-question">Zaten hesabınız var mı?</a>
                <button type="submit">Kayıt Ol</button>
            </form>
        </div>
    </div>

    <!-- Include JavaScript files. -->
    <script
        src="https://code.jquery.com/jquery-3.6.0.slim.js"
        integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous">
    </script>
    <script src="./assets/login_and_signup.js"></script>
</body>

</html>
