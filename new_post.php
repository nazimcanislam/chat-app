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
    <link rel="stylesheet" href="./assets/new_post.css" />

    <!-- Include Font Awesome 5 from CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <!-- Load favicon files -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon_io/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon_io/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon_io/favicon-16x16.png" />
    <link rel="manifest" href="./assets/favicon_io/site.webmanifest" />
</head>

<body>
    <?php require_once './includes/nav.php'; ?>

    <div class="new-post-form-container">
        <form action="./web/create_new_post.php" method="POST" class="new-post-container">
            <h1>Yeni Gönderi Oluşturun</h1>

            <input type="hidden" name="post-author" value="<?php echo $_SESSION['user']['id']; ?>">

            <label for="post-title">Başlık</label>
            <input type="text" name="post-title" id="post-title" />

            <label for="post-content">İçerik</label>
            <textarea name="post-content" id="post-content" cols="30" rows="10"></textarea>

            <?php if ($_SESSION) : ?>
                <?php if (isset($_SESSION['error'])) : ?>
                    <p class="error-message">
                        <?php
                        
                        switch ($_SESSION['error']) {
                            case 'empty-post-title':
                                echo 'Lütfen başlığı boş bırakmayınız!';
                                break;
                            case 'empty-post-content':
                                echo 'Lütfen içeriği boş bırakmayınız!';
                                break;
                            default:
                                break;
                        }

                        // Destroy the error sessions!
                        unset($_SESSION['error']);
                        ?>
                    </p>
                <?php endif; ?>
            <?php endif; ?>

            <div>
                <button type="submit" class="button button-primary button-large">Oluştur</button>
                <a href="./index.php" class="button button-danger button-large">Vazgeç</a>
            </div>
        </form>
    </div>
</body>

</html>
