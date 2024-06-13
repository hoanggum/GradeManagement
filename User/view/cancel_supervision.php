<?php
require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';
require_once BASE_PATH . '/Model/Exam.php';
require_once BASE_PATH . '/Model/Teacher.php';
require_once BASE_PATH . '/Model/ExamInvigilation.php';


$response = array('success' => false, 'message' => '');

if (!isset($_SESSION['TeacherID'])) {
    $response['message'] = "Không thể hủy đăng ký gác thi khi chỉ còn ít hơn 7 ngày hoặc bạn không có quyền hủy.";
    echo json_encode($response);
    exit();
}
if (isset($_POST['exam_id'])) {
    $examId = $_POST['exam_id'];
    $teacherId = $_SESSION['TeacherID'];

    $teacherObj = new Teacher();
    $examInvigilationObj = new ExamInvigilation();

    // Kiểm tra thời gian còn lại trước khi hủy
    $exam = $teacherObj->getRegisteredExamById($teacherId, $examId);

    if ($exam) {
        $examDate = new DateTime($exam['ExamDate']);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($examDate);
        $daysUntilExam = $interval->format('%a');

        if ($daysUntilExam >= 7) {
            // Xóa lịch gác thi
            $deleteSuccess = $teacherObj->unregisterExam($teacherId, $examId);

            if ($deleteSuccess) {
                $response['success'] = true;
                $response['message'] = "Đã hủy đăng ký gác thi thành công.";
            } else {
                $response['message'] = "Không thể hủy đăng ký gác thi. Vui lòng thử lại.";
            }
        } else {
            $response['message'] = "Không thể hủy đăng ký gác thi khi chỉ còn ít hơn 7 ngày.";
        }
    } else {
        $response['message'] = "Lịch gác thi không tồn tại hoặc bạn không có quyền hủy.";
    }
} else {
    $response['message'] = "Thông tin không hợp lệ.";
}

echo json_encode($response);
?>
