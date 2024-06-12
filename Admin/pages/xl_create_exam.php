<?php
require_once '../Model/Exam.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subjectId = $_POST['subjectId'];
    $examDate = $_POST['examDate'];
    $examTime = $_POST['examTime'];
    $duration = $_POST['duration'];

    $ExamObj = new Exam();
    $examId = $ExamObj->createExam($examDate, $examTime, $duration, $subjectId);
    
    if ($examId) {
        // Lấy số lượng sinh viên trong lớp học
        $totalStudents = $ExamObj->countTotalStudentsInSubject($subjectId);

        if ($totalStudents > 0) {
            $students = $ExamObj->getStudentIDsInSubject($subjectId);

            $studentsPerRoom = 60;
            $roomCount = ceil($totalStudents / $studentsPerRoom);

            for ($i = 0; $i < $roomCount; $i++) {
                $room_name = 'A10' . ($i + 1);
                $studentCount = min($studentsPerRoom, $totalStudents - ($i * $studentsPerRoom));

                // Tạo phòng thi
                $roomId = $ExamObj->createExamRoom($room_name, $studentCount);

                // Phân chia sinh viên vào phòng
                for ($j = 0; $j < $studentCount; $j++) {
                    $studentIndex = ($i * $studentsPerRoom) + $j;

                    if ($studentIndex < $totalStudents) {
                        $studentId = $students[$studentIndex];
                        $ExamObj->assignStudentToRoom($examId, $roomId, $studentId);
                    }
                }
            }

            echo json_encode(['success' => true, 'message' => 'Bạn đã tạo danh sách phòng thi thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không có sinh viên trong lớp học hoặc dữ liệu không hợp lệ.']);
        }
    } else {
        echo json_encode(['success' => false]);
    }
}
