<?php
if (!isset($_SESSION['TeacherID'])) {
    exit('Phiên làm việc không hợp lệ. Vui lòng đăng nhập lại.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacherId = $_SESSION['TeacherID'];
    
    if (!isset($_POST['sectionID']) || !isset($_POST['grades']) || !isset($_POST['semester'])) {
        echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
        exit;
    }

    $sectionID = $_POST['sectionID'];
    $semester = $_POST['semester'];
    $grades = $_POST['grades'];


    foreach ($grades as $gradeData) {
        if (!isset($gradeData['StudentID']) || !isset($gradeData['GradeInClass']) || !isset($gradeData['Grade'])) {
            echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }

        $studentID = $gradeData['StudentID'];
        $gradeInClass = $gradeData['GradeInClass'];
        $grade = $gradeData['Grade'];
        
        $teacherInfo = $teacherObj->saveGrade($studentID, $sectionID, $gradeInClass, $grade, $semester);
    }

    echo json_encode(['status' => 'success', 'message' => 'Cap nhat diem thanh cong']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
