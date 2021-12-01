<?php

// Start session processes.
session_start();
ob_start();

// If not signed in, redirect to the home page.
if (!$_SESSION) {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
}

// Start database operations.
define("database", true);
require_once './web/database.php';

// If a user's settings have been changed, reorder it to refresh each time the page is refreshed.
// Then delete unused variables from memory.
$result = mysqli_query($conn, "SELECT * FROM users");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['id'] == $_SESSION['user']['id']) {
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
        }
    }
}
unset($result);

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <!-- Page title -->
    <title>
        Chat App | <?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] ?>
    </title>

    <!-- Important meta tags -->
    <meta charset="utf-8" />
    <meta name="author" content="Nazımcan İslam" />
    <meta name="description" content="Hızlı, güvenli web tabanlı mesajlaşma uygulaması." />
    <meta name="keywords" content="chat, chat app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Includes Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />

    <!-- Include custom CSS -->
    <link rel="stylesheet" href="./assets/master.css" />
    <link rel="stylesheet" href="./assets/chat.css" />

    <!-- Include Font Awesome 5 from CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <!-- Load favicon files -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon_io/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon_io/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon_io/favicon-16x16.png" />
    <link rel="manifest" href="./assets/favicon_io/site.webmanifest" />
</head>

<body class="body-center">
    <a class="back-to-home-button" href="./index.php">
        <i class="fas fa-home"></i>
    </a>

    <!-- Main container -->
    <div class="main-container">
        <!-- User box -->
        <div class="user-box">
            <?php
            /**
             * Show if the user has a profile picture, otherwise show the default profile picture.
             * Write the user's full name right after that.
             */
            ?>
            <?php if ($_SESSION['user']['profile_image'] != null) : ?>
                <img src="<?php echo './public_images/' . $_SESSION['user']['profile_image'] ?>" />
            <?php else : ?>
                <img src="./public_images/default_profile_image.jpg" />
            <?php endif; ?>
            <span class="user-name">
                <?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']; ?>
            </span>

            <div class="user-settings-bar">
                <a href="./profile.php?user=<?php echo $_SESSION['user']['username'] ?>">
                    <i class="fas fa-user-cog"></i>
                </a>

                <a href="./web/logout.php" class="user-logout-button" title="Çıkış">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>

        <!-- Chats group -->
        <div class="chats-group">
            <?php
            // Capture all chats and keep the chats that only the logged in user is associated with in the variable.
            // Then delete unnecessary variables.
            $user_opponents = array();
            $chats = mysqli_query($conn, "SELECT * FROM chat");
            if ($chats->num_rows > 0) {
                while ($row = $chats->fetch_assoc()) {
                    if ($row['sender_id'] == $_SESSION['user']['id'] || $row['recipient_id'] == $_SESSION['user']['id']) {
                        array_push($user_opponents, $row);
                    }
                }
            }
            unset($chats);

            // Delete the same messages.
            $chateds = array();
            $chateds_id = array();
            foreach ($user_opponents as $c) {
                if (!in_array($c['msg_id'], $chateds_id)) {
                    array_push($chateds_id, $c['msg_id']);
                    array_push($chateds, $c);
                }
            }
            unset($chateds_id);
            unset($user_opponents);

            // Find the ID numbers of the people who have spoken through the ID number of the sender and receiver in the messages.
            // Then delete the same ID numbers (duplicated) so you only have one of them all.
            // And of course clear memory :)
            $chated_people = array();
            $users = mysqli_query($conn, "SELECT id, first_name, last_name, username, email, profile_image FROM users");
            if ($users->num_rows > 0) {
                $i = 0;
                while ($user = $users->fetch_assoc()) {
                    if ($i < count($chateds)) {
                        if ($chateds[$i]['sender_id'] != $chateds[$i]['recipient_id']) {
                            if ($_SESSION['user']['id'] == $chateds[$i]['sender_id']) {
                                array_push($chated_people, $chateds[$i]['recipient_id']);
                            } else if ($_SESSION['user']['id'] == $chateds[$i]['recipient_id']) {
                                array_push($chated_people, $chateds[$i]['sender_id']);
                            }
                        } else if ($chateds[$i]['sender_id'] == $chateds[$i]['recipient_id']) {
                            array_push($chated_people, $chateds[$i]['sender_id']);
                        }
                    }
                    $i++;
                }
            }
            $chated_people = array_unique($chated_people);
            unset($users);

            // Make it ready for use in querying the ID numbers of the people talking.
            $users_id_string = '';
            foreach ($chated_people as $key => $value) {
                $users_id_string .= $value . ', ';
            }

            // Question the information of the people who have been spoken to through the ID numbers found
            $users_id_string = substr($users_id_string, 0, strlen($users_id_string) - 2);
            $result = mysqli_query($conn, "SELECT * FROM users WHERE id IN ($users_id_string)");

            // Check to see if the user has ever texted.
            if (isset($result->num_rows)) {
                $user_has_chated = true;
            } else {
                $user_has_chated = false;
            }
            ?>

            <?php
            /**
             * If the user even has at least one message, put all the spoken people, profile pictures in a box on the screen.
             * If not, give a funny message.
             */
            ?>
            <?php if ($user_has_chated) : ?>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($user = $result->fetch_assoc()) : ?>
                        <a class="chats-group-item" href="?opponent=<?php echo $user['username']; ?>">
                            <?php if ($user['profile_image'] != null) : ?>
                                <img src="./public_images/<?php echo $user['profile_image']; ?>" alt="">
                            <?php else : ?>
                                <img src="./public_images/default_profile_image.jpg" alt="">
                            <?php endif; ?>
                            <span class="chats-group-item-name">
                                <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
                            </span>
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php else : ?>
                <h3 class="user-no-chated">
                    <span>Vay canına, henüz kimse ile konuşmamışsın.</span>
                    <i class="fas fa-cat"></i>
                </h3>
            <?php endif; ?>
            <?php unset($result); ?>

            <!-- Conversation start key. -->
            <div class="add-contact-container">
                <i class="fas fa-plus add-contact-button"></i>

                <form action="">
                    <input type="text" name="contact-to" />
                    <button type="submit" style="visibility: hidden;"></button>
                </form>
            </div>
        </div>

        <!-- Opponent container -->
        <div class="opponent-container">
            <?php
            /**
             * If there is someone who is chatting, show their profile picture and name on the screen.
             **/ 
            ?>
            <?php if ($_GET) : ?>
                <?php if (isset($_GET['opponent'])) : ?>
                    <?php $opponent_user = mysqli_query($conn, "SELECT * FROM users WHERE username='" . $_GET['opponent'] . "'")->fetch_assoc(); ?>
                    <a href="#">
                        <?php if ($opponent_user['profile_image'] != null) : ?>
                            <img src="./public_images/<?php echo $opponent_user['profile_image']; ?>" class="message-user-icon" />
                        <?php else : ?>
                            <img src="./public_images/default_profile_image.jpg" class="message-user-icon" />
                        <?php endif; ?>
                    </a>
                    <a href="#">
                        <span>
                            <?php echo $opponent_user['first_name'] . ' ' . $opponent_user['last_name']; ?>
                        </span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Messages container -->
        <div class="messages-container">
            <?php
            /**
             * If there is someone with the chat open, show his/her and the user's messages and dates.
             * And then you know what will happen!
             */
            ?>
            <?php if ($_GET) : ?>
                <?php if (isset($_GET['opponent'])) : ?>
                    <?php foreach ($chateds as $key => $value) : ?>
                        <?php if ($value['sender_id'] == $value['recipient_id'] && $opponent_user['username'] == $_GET['opponent']) : ?>
                            <div class="message own-message">
                                <div class="msg-content">
                                    <?php if ($_SESSION['user']['profile_image'] != null) : ?>
                                        <img src="./public_images/<?php echo $_SESSION['user']['profile_image']; ?>" class="message-user-icon" />
                                    <?php else : ?>
                                        <img src="./public_images/default_profile_image.jpg" class="message-user-icon" />
                                    <?php endif; ?>

                                    <span>
                                        <?php echo $value['msg']; ?>
                                    </span>
                                </div>

                                <div class="msg-date">
                                    <?php echo $value['msg_date']; ?>
                                </div>
                            </div>
                        <?php elseif ($value['sender_id'] == $_SESSION['user']['id'] && $value['recipient_id'] == $opponent_user['id']) : ?>
                            <div class="message own-message">
                                <div class="msg-content">
                                    <?php if ($_SESSION['user']['profile_image'] != null) : ?>
                                        <img src="./public_images/<?php echo $_SESSION['user']['profile_image']; ?>" class="message-user-icon" />
                                    <?php else : ?>
                                        <img src="./public_images/default_profile_image.jpg" class="message-user-icon" />
                                    <?php endif; ?>

                                    <span>
                                        <?php echo $value['msg']; ?>
                                    </span>
                                </div>

                                <div class="msg-date">
                                    <?php echo $value['msg_date']; ?>
                                </div>
                            </div>
                        <?php elseif ($value['sender_id'] == $opponent_user['id'] && $value['recipient_id'] == $_SESSION['user']['id']) : ?>
                            <div class="message opponent-message">
                                <div class="msg-content">
                                    <?php if ($opponent_user['profile_image'] != null) : ?>
                                        <img src="./public_images/<?php echo $opponent_user['profile_image']; ?>" class="message-user-icon" />
                                    <?php else : ?>
                                        <img src="./public_images/default_profile_image.jpg" class="message-user-icon" />
                                    <?php endif; ?>

                                    <span>
                                        <?php echo $value['msg']; ?>
                                    </span>
                                </div>

                                <div class="msg-date">
                                    <?php echo $value['msg_date']; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php unset($opponent_user); ?>
        </div>

        <!-- Write text container -->
        <?php
        /**
         * If there is someone with a chat open, show the message box.
         */
        ?>
        <div class="write-text-container">
            <form method="POST" action="./web/send_message.php">
                <input type="hidden" name="sender" value="<?php echo $_SESSION['user']['id']; ?>" />
                <?php if ($_GET) : ?>
                    <?php if (isset($_GET['opponent'])) : ?>
                        <input type="hidden" name="recipient" value="<?php echo $_GET['opponent']; ?>" />
                        <input type="text" placeholder="Mesaj gönderin..." name="message" autofocus autocomplete="off" />
                        <button type="submit" title="Mesajı gönder">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Include JavaScript files. -->
    <script
        src="https://code.jquery.com/jquery-3.6.0.slim.js"
        integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous">
    </script>
    <script src="./assets/chat.js"></script>
</body>

</html>
