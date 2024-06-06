<?php
include 'config.php';
try {
    $conn = new PDO('mysql:host='.HOST_DB.';dbname='.DB, USER_DB, PASS_DB);
    $conn->query('set names utf8');
} catch(PDOException $e) {
    echo 'ERROR';
    exit;
}
