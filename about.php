<?php

// Start session processes.
session_start();
ob_start();

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <!-- Page title -->
    <title>Chat App | Hakkında</title>

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
        .about-section-content {
            max-width: 100%;
            width: max-content;
            padding: 16px 18px;
            margin: 32px auto;
        }

        .about-section-content h1 {
            text-align: center;
            font-size: 48px;
            margin-bottom: 32px;
            font-weight: 600;
        }

        .about-section-content p {
            color: #000000;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <?php require_once './includes/nav.php'; ?>

    <section class="about-section-content">
        <h1>Chat App Hakkında</h1>
        <p>
            <strong>Chat App</strong>, açık kaynak kodlu, ücretsiz web tabanlı bir mesajlaşma uygulamasıdır.
        </p>
        <p>
            PHP ve MySQL ile yazılmıştır.
        </p>
        <p>
            Kaynak kodlarını görüntülemek için <a href="https://github.com/nazimcanislam/chat-app" target="_blank">buraya</a> tıklayın.
        </p>
    </section>
</body>

</html>
