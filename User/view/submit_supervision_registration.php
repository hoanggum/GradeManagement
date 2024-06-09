<?php
require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';
require_once BASE_PATH . '/Model/Exam.php';
require_once BASE_PATH . '/Model/Teacher.php';
require_once BASE_PATH . '/Model/ExamInvigilation.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_ids'])) {
    $teacherId = $_SESSION['TeacherID'];
    $examIds = $_POST['exam_ids'];
    $db = new Db();
    $examInvigilationObj = new ExamInvigilation();

    $conflicts = [];
    $validExams = [];

    foreach ($examIds as $examId) {
        if ($examInvigilationObj->checkConflicts($teacherId, $examId)) {
            $conflicts[] = $examId;
        } else {
            $validExams[] = $examId;
        }
    }

    if (!empty($conflicts)) {
        echo "Có xung đột với các ca thi sau: " . implode(", ", $conflicts) . ". Vui lòng chọn lại.";
        exit;
    }

    try {
        $db->beginTransaction();

        foreach ($validExams as $examId) {
            $sql = "SELECT room_id FROM exam_room_assignments WHERE Exam_ID = :examId";
            $rooms = $db->selectQuery($sql, [':examId' => $examId]);

            foreach ($rooms as $room) {
                $examInvigilationObj->assignTeacherToExam($examId, $teacherId, $room['room_id']);
            }
        }

        $db->commit();
        echo "Đăng ký gác thi thành công.";
    } catch (Exception $e) {
        $db->rollBack();
        echo "Có lỗi xảy ra khi đăng ký gác thi: " . $e->getMessage();
    }
} else {
    echo "Không có ca thi nào được chọn.";
}
?>
