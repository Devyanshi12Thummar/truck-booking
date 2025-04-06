<?php

session_start();

if (isset($_SESSION["UID"]) ) {
    $uid = $_SESSION["UID"];
    echo "User ID from session: " . $uid;
} else {
    echo "Session variable 'UID' is not set.";
}
?>
