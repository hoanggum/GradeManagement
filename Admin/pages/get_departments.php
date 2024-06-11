<?php
require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';

$db = new Db();
$departments = $db->selectQuery("SELECT * FROM department");
echo json_encode($departments);
?>
