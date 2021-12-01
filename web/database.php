<?php

// Do database works if it is defined.
// Else, redirect to home page.
if (defined("database")) {
    // Set database connection properties to variables.
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'chat_app';

    // Make database connect with mysqli.
    $conn = mysqli_connect($servername, $username, $password, $db_name);

    // If there is a problem with connect, then show it.
    if ($conn->connect_error) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // If there is no a table named users, create it.
    if (!mysqli_query($conn, "SELECT * FROM users")) {
        $sql = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(30) NOT NULL,
            last_name VARCHAR(20),
            username VARCHAR(30) NOT NULL,
            email VARCHAR(40) NOT NULL,
            password VARCHAR(32) NOT NULL,
            profile_image VARCHAR(30),
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        mysqli_query($conn, $sql);
    }

    // And if there is no a table named chat, create it.
    if (!mysqli_query($conn, "SELECT * FROM chat")) {
        $sql = "CREATE TABLE chat (
            msg_id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            sender_id INT(6) NOT NULL,
            recipient_id INT(6) NOT NULL,
            msg VARCHAR(300) NOT NULL,
            msg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        mysqli_query($conn, $sql);
    }

    // And if there is no a table named blog, create it.
    if (!mysqli_query($conn, "SELECT * FROM blog")) {
        $sql = "CREATE TABLE blog (
            post_id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            author_id INT(6) NOT NULL,
            title VARCHAR(80) NOT NULL,
            content VARCHAR(1000) NOT NULL,
            post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        mysqli_query($conn, $sql);
    }

    // Detele variable from memory.
    unset($sql);
} else {
    header("Location: ../index.php");
}
