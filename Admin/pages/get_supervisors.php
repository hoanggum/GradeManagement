<?php
// Import các model cần thiết
require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';
require_once BASE_PATH . '/Model/Exam.php';
require_once BASE_PATH . '/Model/Teacher.php';
require_once BASE_PATH . '/Model/ExamInvigilation.php';

// Lấy ngày bắt đầu và ngày kết thúc từ yêu cầu AJAX
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : null;
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : null;
$searchKeyword = isset($_GET['searchKeyword']) ? $_GET['searchKeyword'] : null;

// Khởi tạo đối tượng Database
$db = new Db();

try {
    // Xây dựng câu truy vấn cơ sở dữ liệu để lấy danh sách giảng viên gác thi dựa trên khoảng thời gian từ fromDate đến toDate
    $query = "SELECT e.Exam_ID, e.ExamDate, e.ExamRound, e.ExamTime, e.Duration, s.SubjectName, er.room_name, t.TeacherID, u.FullName
              FROM examschedule e
              INNER JOIN subjects_section ss ON e.section_ID  = ss.SectionID
              INNER JOIN subjects s ON ss.SubjectID = s.SubjectID
              INNER JOIN exam_invigilation ei ON e.Exam_ID = ei.exam_id
              INNER JOIN examscheduledetail esd ON e.Exam_ID = esd.Exam_ID
              INNER JOIN examroom er ON esd.room_id = er.room_id
              INNER JOIN teacher t ON ei.teacher_id = t.TeacherID
              INNER JOIN users u ON t.UserID = u.UserID
              WHERE e.ExamDate BETWEEN ? AND ?";

    // Thêm điều kiện tìm kiếm theo tên hoặc mã giáo viên nếu có
    if ($searchKeyword) {
        $query .= " AND (u.FullName LIKE '%$searchKeyword%' OR ei.teacher_id LIKE '%$searchKeyword%')";
    }

    // Thực hiện truy vấn
    $results = $db->selectQuery($query, array($fromDate, $toDate));

    // Xây dựng dữ liệu response
    $supervisors = $results;

    $response = array(
        'supervisors' => $supervisors
    );

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    // Ghi log lỗi và trả về lỗi trong trường hợp có ngoại lệ xảy ra
    error_log($e->getMessage());
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => 'Internal Server Error']);
}
?>
