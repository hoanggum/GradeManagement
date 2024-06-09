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

    public function getExamById($examId) {
        $sql = "SELECT * FROM examschedule WHERE Exam_ID = :examId";
        $params = array(':examId' => $examId);
        return $this->selectQuery($sql, $params);
    }
}
?>
