<?php
if(!isset($_SESSION)) session_start();
unset($_SESSION['UserID']);
header('location:index.html');
?>