<?php
// require_once '../../config.php';
// require_once BASE_PATH . '/Library/Db.class.php';
require_once BASE_PATH . '/Model/Exam.php';
require_once BASE_PATH . '/Model/Teacher.php';
require_once BASE_PATH . '/Model/ExamInvigilation.php';

// Khởi tạo các đối tượng và thực hiện các truy vấn cần thiết\
if (isset($_SESSION['TeacherID'])) {
    $teacherId = $_SESSION['TeacherID'];
}
$examObj = new Exam();
$examSchedules = $examObj->getAllExamsOfTeacher($teacherId); // Lấy danh sách các ca thi

// Chuẩn bị dữ liệu để trả về dưới dạng JSON
$response = array();
foreach ($examSchedules as $schedule) {
    $rowData = array(
        'Exam_ID' => $schedule['Exam_ID'],
        'ExamDate' => $schedule['ExamDate'],
        'ExamRound' => $schedule['ExamRound'],
        'ExamTime' => $schedule['ExamTime'],
        'Duration' => $schedule['Duration'],
        'SubjectName' => $schedule['SubjectName'],
        'room_id' => $schedule['room_id'],
        'room_name' => $schedule['room_name'],
        'Teacher_ID' => $teacherId,
        // Các thông tin khác nếu cần thiết
    );
    $response[] = $rowData;
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode($response);
?>
