<?php
require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';

if (isset($_GET['departmentId'])) {
    $departmentId = $_GET['departmentId'];

    $db = new Db();
    $classes = $db->selectQuery("SELECT * FROM class WHERE DepartmentID = ?", [$departmentId]);
    header('Content-Type: application/json');
    echo json_encode($classes);
} else {
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
