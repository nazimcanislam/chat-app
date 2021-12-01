<?php

// Start session so we can access them.
session_start();
ob_start();

// If there is a POST request, then do things.
// Else, redirect home page.
if ($_POST) {
    // Define database and import it.
    define('database', true);
    require_once './database.php';

    // If post title or post content is empty, then redirect new post view page and set error.
    // Else, get post details and author id and insert new blog post to database.
    // Lastly redirect blog view page.
    if (empty($_POST['post-title'])) {
        $_SESSION['error'] = 'empty-post-title';
        header("Location: ../new_post.php");
    } else if (empty($_POST['post-content'])) {
        $_SESSION['error'] = 'empty-post-content';
        header("Location: ../new_post.php");
    } else {
        $author = $_POST['post-author'];
        $title = $_POST['post-title'];
        $content = $_POST['post-content'];

        mysqli_query($conn, "INSERT INTO blog (post_id, author_id, title, content, post_date) VALUES (NULL, '$author', '$title', '$content', NULL)");
        header("Location: ../blog.php");
    }
} else {
    header("Location: ../index.php");
}
