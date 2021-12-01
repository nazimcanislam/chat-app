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

    // If message is empty, then redirect chat view page.
    // Else, get sender and recipient ID's and of course the message data. Then send it.
    // Lastly redirect chat view page.
    if (empty($_POST['message'])) {
        header("Location: ../chat.php");
    } else {
        $sender = $_POST['sender'];
        $recipient = $_POST['recipient'];
        $message = $_POST['message'];
        
        $recipient_id = mysqli_query($conn, "SELECT id FROM users WHERE username='$recipient'")->fetch_assoc()['id'];

        mysqli_query($conn, "INSERT INTO chat (msg_id, sender_id, recipient_id, msg, msg_date) VALUES (NULL, '$sender', '$recipient_id', '$message', NULL)");
        header("Location: ../chat.php?opponent=$recipient");
    }
} else {
    header("Location: ../index.php");
}
