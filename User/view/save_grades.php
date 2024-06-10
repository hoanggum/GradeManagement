<?php
require_once '../Model/Teacher.php';
require_once '../Model/Semester.php';

session_start();
if (!isset($_SESSION['TeacherID'])) {
    // Redirect hoặc xử lý khi không có phiên làm việc
    exit('Phiên làm việc không hợp lệ. Vui lòng đăng nhập lại.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacherId = $_SESSION['TeacherID'];
    
    // Kiểm tra xem dữ liệu POST đã được gửi đến hay không
    if (!isset($_POST['sectionID']) || !isset($_POST['grades'])) {
        echo json_encode(['status' => 'error', 'message' => 'Du lieu khong hop le']);
        exit;
    }

    $sectionID = $_POST['sectionID'];
    $grades = $_POST['grades'];

    $teacherObj = new Teacher();

    foreach ($grades as $gradeData) {
        // Kiểm tra xem dữ liệu của mỗi sinh viên có đầy đủ không
        if (!isset($gradeData['StudentID']) || !isset($gradeData['GradeInClass']) || !isset($gradeData['Grade'])) {
            echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }

        $studentID = $gradeData['StudentID'];
        $gradeInClass = $gradeData['GradeInClass'];
        $grade = $gradeData['Grade'];
        
        // Cập nhật điểm cho sinh viên
        $teacherObj->saveGrade($sectionID, $studentID, $gradeInClass, $grade);
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
