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
    if (empty($_POST['user-fullname'])) {
        $_SESSION['error'] = 'empty-user-fullname';
    } else if (empty($_POST['user-username'])) {
        $_SESSION['error'] = 'empty-user-username';
    } else if (empty($_POST['user-email'])) {
        $_SESSION['error'] = 'empty-user-email';
    } else if (empty($_POST['user-password']) || empty($_POST['user-re-password'])) {
        $_SESSION['error'] = 'empty-user-password';
    } else {
        // Get user fullname.
        $fullname = $_POST['user-fullname'];

        // If user fullname has first name and last name, split them to variables.
        // If user has only first name, then the last name variable will be null.
        if (count(explode(' ', $fullname)) > 1) {
            $name_pieces = explode(' ', $fullname);
            $last_name = $name_pieces[count($name_pieces) - 1];
            $first_name = str_replace(' ' . $last_name, '', $fullname);
        } else {
            $first_name = $fullname;
            $last_name = null;
        }

        // Get the other user things.
        $username = $_POST['user-username'];
        $email = $_POST['user-email'];
        $password = $_POST['user-password'];
        $re_password = $_POST['user-re-password'];

        // Check problems and create error message and hold it in session.
        // If no problem, do things.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'invalid-user-email';
        } else if ($password != $re_password) {
            $_SESSION['error'] = 'user-password-match';
        } else {
            // Set variables to check is user already exists.
            $user_email_exists = false;
            $user_username_exists = false;

            // Get email and username data from users with query.
            // And check is there a user from posted data.
            $result = mysqli_query($conn, "SELECT email, username FROM users");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($email == $row['email']) {
                        $user_email_exists = true;
                        break;
                    }

                    if ($username == $row['username']) {
                        $user_username_exists = true;
                        break;
                    }
                }
            }

            // Check problems and create error message and hold it in session.
            // If no problem, create new user data with user's details. Then redirect login view page.
            if ($user_email_exists) {
                $_SESSION['error'] = 'user-email-already-exists';
            } else if ($user_username_exists) {
                $_SESSION['error'] = 'user-username-already-exists';
            } else {
                $sql = "INSERT INTO users
                (
                    id,
                    first_name,
                    last_name,
                    username,
                    email,
                    password,
                    reg_date
                )
                VALUES (
                    NULL,
                    '" . $first_name . "',
                    '" . $last_name . "',
                    '" . $username . "',
                    '" . $email . "',
                    '" . $password . "',
                    NULL
            )";
                mysqli_query($conn, $sql);
            }
        }
    }
    header("Location: ../login.php");
} else {
    header("Location: ../index.php");
}
