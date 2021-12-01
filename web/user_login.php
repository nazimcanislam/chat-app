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

    // Check problems and create error message and hold it in session.
    // If there is no any problem do things.
    if (empty($_POST['user-email'])) {
        $_SESSION['error'] = 'empty-user-email';
    } else if (empty($_POST['user-password'])) {
        $_SESSION['error'] = 'empty-user-password';
    } else if (!filter_var($_POST['user-email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'invalid-user-email';
    } else {
        // Get user email and password to chech matches.
        $email = $_POST['user-email'];
        $password = $_POST['user-password'];

        // Set variables to check is user already exists.
        $user_exists = false;
        $password_correct = false;

        // Get all users with query and check is user exits.
        $result = mysqli_query($conn, "SELECT * FROM users");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($email == $row['email']) {
                    $user_exists = true;
                    if ($password == $row['password']) {
                        $password_correct = true;
                    }
                    break;
                }
            }
        }

        // Check problems and create error message and hold it in session.
        // If no problem, create session with user's details. Then redirect home page.
        if (!$user_exists) {
            $_SESSION['error'] = 'user-not-exists';
            header("Location: ../login.php");
        } else if (!$password_correct) {
            $_SESSION['error'] = 'user-password-not-correct';
            header("Location: ../login.php");
        } else if ($user_exists && $password_correct) {
            $_SESSION['user'] = array(
                'id' => $row['id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => $row['password'],
                'profile_image' => $row['profile_image'],
                'reg_date' => $row['reg_date']
            );
            header("Location: ../chat.php");
        }
    }
} else {
    header("Location: ../index.php");
}
