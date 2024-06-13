<?php

require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';
require_once BASE_PATH . '/Model/Exam.php';
require_once BASE_PATH . '/Model/Teacher.php';
require_once BASE_PATH . '/Model/ExamInvigilation.php';

$response = array('success' => false, 'message' => '');

// Kiểm tra xem phiên đăng nhập của giáo viên có tồn tại không
if (!isset($_POST['teacher_id'])) {
    $response['message'] = "Phiên đăng nhập của giáo viên không tồn tại hoặc đã hết hạn.";
    echo json_encode($response);
    exit();
}
// Xử lý yêu cầu hủy đăng ký gác thi khi nhận được exam_id từ yêu cầu POST
if (isset($_POST['exam_id']) && isset($_POST['room_id'])) {
    $examId = $_POST['exam_id'];
    $teacherId = $_POST['teacher_id']; // Lấy TeacherID từ phiên đăng nhập của giáo viên
    $roomId = $_POST['room_id'];
    
    // Khởi tạo đối tượng Teacher và ExamInvigilation để thực hiện xử lý
    $teacherObj = new Teacher();
    $examInvigilationObj = new ExamInvigilation();
    // Kiểm tra thông tin đăng ký ca thi của giáo viên
    $deleteSuccess = $teacherObj->unregisterExam($roomId, $teacherId, $examId);

    if ($deleteSuccess) {
        $response['success'] = true;
        $response['message'] = "Đã hủy đăng ký gác thi thành công.";
    } else {
        $response['message'] = "Không thể hủy đăng ký gác thi. Vui lòng thử lại.";
    }
    // $exam = $teacherObj->getRegisteredExamById($teacherId, $examId);
    
    // if ($exam) {
    //     $examDate = new DateTime($exam['ExamDate']);
    //     $currentDate = new DateTime();
    //     $interval = $currentDate->diff($examDate);
    //     $daysUntilExam = $interval->format('%a');
    //     $response['message'] = "Phiên đăng nhập 2 của giáo viên không tồn tại hoặc đã hết hạn.";
    //     echo json_encode($response);
    //     exit();
    //     if ($daysUntilExam >= 7) {
    //         // Nếu còn ít nhất 7 ngày trước ngày thi, tiến hành hủy đăng ký
    //         $deleteSuccess = $teacherObj->unregisterExam($roomId, $teacherId, $examId);

    //         if ($deleteSuccess) {
    //             $response['success'] = true;
    //             $response['message'] = "Đã hủy đăng ký gác thi thành công.";
    //         } else {
    //             $response['message'] = "Không thể hủy đăng ký gác thi. Vui lòng thử lại.";
    //         }
    //     } else {
    //         $response['message'] = "Không thể hủy đăng ký gác thi khi chỉ còn ít hơn 7 ngày.";
    //     }
    // } else {
    //     $response['message'] = "Lịch gác thi không tồn tại hoặc bạn không có quyền hủy.";
    // }
} else {
    $response['message'] = "Thông tin không hợp lệ.";
}

echo json_encode($response);
exit();

?>
