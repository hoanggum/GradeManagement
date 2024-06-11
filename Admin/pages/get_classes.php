<?php
require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';

$departmentId = $_GET['departmentId'];

$db = new Db();
$classes = $db->selectQuery("SELECT * FROM class WHERE DepartmentID = ?", [$departmentId]);
echo json_encode($classes);
?>
