<?php

// This script file destroys all sessions and redirects home page.
session_start();
session_destroy();
header("Location: ../login.php");
