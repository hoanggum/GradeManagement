<?php
require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';
require_once BASE_PATH . '/Model/Subject.php';

$subject = new Subject();
$subjects = $subject->getAllSubjects();

echo json_encode($subjects);
?>
