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
    <link rel="stylesheet" href="./assets/blog.css" />

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

    <div class="posts-container">
        <?php if (mysqli_query($conn, "SELECT * FROM blog")) : ?>
            <?php $blog_posts = mysqli_query($conn, "SELECT * FROM blog ORDER BY post_id DESC"); ?>
            <?php if ($blog_posts->num_rows > 0) : ?>
                <?php while ($post = $blog_posts->fetch_assoc()) : ?>
                    <?php $users = mysqli_query($conn, "SELECT id, first_name, last_name, username, profile_image FROM users"); ?>
                    <?php if ($users->num_rows > 0) : ?>
                        <?php while ($user = $users->fetch_assoc()) : ?>
                            <?php if ($user['id'] == $post['author_id']) : ?>
                                <?php

                                $own_user = false;
                                if ($_SESSION) {
                                    if ($_SESSION['user']['id'] == $post['author_id']) {
                                        $own_user = true;
                                    }
                                }

                                ?>

                                <div class="post-box <?php echo ($own_user) ? 'own-post' : null; ?>">
                                    <header class="post-header">
                                        <a href="./post?id=<?php echo $post['post_id']; ?>" class="post-title">
                                            <h1 class="post-title">
                                                <?php echo $post['title']; ?>
                                            </h1>
                                        </a>
                                        <a href="./profile.php?user=<?php echo $user['username']; ?>" class="post-author">
                                            <?php if ($user['profile_image'] != null) : ?>
                                                <img src="./public_images/<?php echo $user['profile_image']; ?>" class="blog-user-profile-image">
                                            <?php else : ?>
                                                <img src="./public_images/default_profile_image.jpg" class="blog-user-profile-image">
                                            <?php endif; ?>

                                            <?php if ($_SESSION) : ?>
                                                <?php if ($_SESSION['user']['id'] == $user['id']) : ?>
                                                    <strong>
                                                        <?php echo '@' . $user['username'] . ' - ben'; ?>
                                                    </strong>
                                                <?php else : ?>
                                                    <?php echo '@' . $user['username']; ?>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <?php echo '@' . $user['username']; ?>
                                            <?php endif; ?>
                                        </a>
                                    </header>

                                    <p class="post-content">
                                        <?php echo $post['content']; ?>
                                    </p>

                                    <span class="post-date">
                                        <?php echo str_replace('-', '/', substr($post['post_date'], 0, 10)); ?>
                                    </span>

                                    <?php if ($_SESSION) : ?>
                                        <?php if ($_SESSION['user']['id'] == $user['id']) : ?>
                                            <div class="post-controlls">
                                                <form action="./edit_post.php" method="GET">
                                                    <input type="hidden" name="post-id" value="<?php echo $post['post_id']; ?>">
                                                    <!-- <button type="submit" class="button button-secondary" name="edit-button">Düzenle</button>
                                                    <button type="submit" class="button button-danger" name="delete-button">Sil</button> -->
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php break; ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <h1 class="no-one-posted-message">
                    Vay canına! Henüz hiç kimse gönderi paylaşmamış.<br />
                    Merhaba, orda mısın?<br />
                    <i class="fas fa-cat"></i>
                </h1>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>

</html>
