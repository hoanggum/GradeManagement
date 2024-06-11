<?php
require_once BASE_PATH . '/Library/Db.class.php';
class Exam extends Db {
    public function getAllExams() {
        $sql = "SELECT es.Exam_ID, es.ExamDate, es.ExamRound, es.ExamTime, es.Duration, sj.SubjectName, er.room_name, era.room_id
                FROM examschedule es
                INNER JOIN subjects_section ss ON es.section_ID = ss.SectionID
                INNER JOIN subjects sj ON ss.SubjectID = sj.SubjectID
                INNER JOIN exam_room_assignments era ON es.Exam_ID = era.Exam_ID
                INNER JOIN examroom er ON era.room_id = er.room_id";
        return $this->selectQuery($sql);
    }
    public function createExamSchedule($subjectId, $examDate, $examTime, $duration, $examRound, $roomId) {
        $sql = "INSERT INTO examschedule (SubjectID, ExamDate, ExamTime, Duration, ExamRound, Room_ID)
                VALUES (:subjectId, :examDate, :examTime, :duration, :examRound, :roomId)";
        $params = array(
            ':subjectId' => $subjectId,
            ':examDate' => $examDate,
            ':examTime' => $examTime,
            ':duration' => $duration,
            ':examRound' => $examRound,
            ':roomId' => $roomId
        );
        return $this->updateQuery($sql, $params);
    }

    public function getExamById($examId) {
        $sql = "SELECT es.Exam_ID, ss.*
                FROM examschedule es
                INNER JOIN subjects_section ss ON es.section_ID = ss.SectionID
                WHERE es.Exam_ID = :examId";
        $params = array(':examId' => $examId);
        return $this->selectQuery($sql, $params);
    }
    
    public function getAllRooms() {
        $sql = "SELECT * FROM examroom";
        return $this->selectQuery($sql);
    }

    // Get students by section ID
    public function getStudentsBySectionId($sectionId) {
        $sql = "SELECT StudentID FROM students WHERE SectionID = :sectionId";
        $params = array(':sectionId' => $sectionId);
        return $this->selectQuery($sql, $params);
    }
    public function getStudentsBySubjectIdAndSemester($subjectId, $semester) {
        $sql = "SELECT s.StudentID
                FROM student s
                JOIN student_semester sm ON sm.StudentID = s.StudentID
                JOIN subjects_section ss ON sm.SectionID = ss.SectionID
                JOIN subjects ON ss.SubjectID = subjects.SubjectID
                WHERE subjects.SubjectID = :subjectId
                AND sm.Semester = :semester";
        $params = array(':subjectId' => $subjectId, ':semester' => $semester);
        return $this->selectQuery($sql, $params);
    }
    
    public function assignStudentToRoom($examId, $studentId, $roomId) {
        $sql = "INSERT INTO examscheduledetail (Exam_ID, StudentID, room_id)
                VALUES (:examId, :studentId, :roomId)";
        $params = array(
            ':examId' => $examId,
            ':studentId' => $studentId,
            ':roomId' => $roomId
        );
        return $this->updateQuery($sql, $params);
    }

    // Assign rooms to exam
    public function assignRoomsToExam($examId, $roomId) {
        $sql = "INSERT INTO exam_room_assignments (Exam_ID, room_id)
                VALUES (:examId, :roomId)";
        $params = array(
            ':examId' => $examId,
            ':roomId' => $roomId
        );
        return $this->updateQuery($sql, $params);
    }

    public function assignStudentsToRooms($examId) {
        $examInfo = $this->getExamById($examId);
        $subjectId = $examInfo[0]['SubjectID'];
        $semester = $examInfo[0]['Semester'];
    
        $students = $this->getStudentsBySubjectIdAndSemester($subjectId, $semester);
        $rooms = $this->getAllRooms();
    
        $currentRoomIndex = 0;
        $currentRoomCapacity = $rooms[$currentRoomIndex]['capacity'];
        $currentRoomId = $rooms[$currentRoomIndex]['room_id'];
    
        foreach ($students as $student) {
            if ($currentRoomCapacity == 0) {
                $currentRoomIndex++;
                if ($currentRoomIndex >= count($rooms)) {
                    return false; 
                }
                $currentRoomCapacity = $rooms[$currentRoomIndex]['capacity'];
                $currentRoomId = $rooms[$currentRoomIndex]['room_id'];
            }
    
            $this->assignStudentToRoom($examId, $student['StudentID'], $currentRoomId);
            $this->assignRoomsToExam($examId, $currentRoomId);
            $currentRoomCapacity--;
        }
    
        return true;
    }
    

    private function getSectionIdByExamId($examId) {
        $sql = "SELECT section_ID FROM examschedule WHERE Exam_ID = :examId";
        $params = array(':examId' => $examId);
        $result = $this->selectQuery($sql, $params);
        return $result[0]['section_ID'];
    }
}
?>
