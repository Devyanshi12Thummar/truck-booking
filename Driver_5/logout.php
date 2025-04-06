<?php
session_start();
unset($_SESSION['UID']);
header('location:dashboard.php');
die();

?>