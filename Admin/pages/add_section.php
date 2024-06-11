<?php
require_once 'path_to/Db.class.php';
require_once 'path_to/SubjectSection.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $className = $_POST['className'];
    $semester = $_POST['semester'];
    $studentCount = $_POST['studentCount'];
    $subjectId = $_POST['subjectId'];

    $section = new SubjectSection();
    $result = $section->addSection($subjectId, $className);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Thêm lớp học phần thành công!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi thêm lớp học phần.']);
    }
}
?>
