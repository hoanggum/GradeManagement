<?php
require_once '../Model/Semester.php';

if (isset($_POST['sectionId']) && isset($_POST['studentId']) && isset($_POST['semester'])) {
    $sectionId = intval($_POST['sectionId']);
    $studentId = intval($_POST['studentId']);
    $semester = htmlspecialchars($_POST['semester']);
    $semesterObj = new Semester();
    $result = $semesterObj->register($sectionId, $studentId, $semester);
    if ($result) {
        echo 'Registration successful!';
    } else {
        echo 'Registration failed!';
    }
} else {
    echo 'Invalid request.';
}
?>
