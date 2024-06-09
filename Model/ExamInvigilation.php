<?php

class ExamInvigilation extends Db {
    public function checkConflicts($teacherId, $examId) {
        $sql = "SELECT ei.exam_id, es.ExamDate, es.ExamTime
                FROM exam_invigilation ei
                INNER JOIN examschedule es ON ei.exam_id = es.Exam_ID
                WHERE ei.teacher_id = :teacherId";
        $params = array(':teacherId' => $teacherId);
        $invigilations = $this->selectQuery($sql, $params);

        $exam = $this->selectQuery("SELECT ExamDate, ExamTime FROM examschedule WHERE Exam_ID = :examId", array(':examId' => $examId))[0];

        foreach ($invigilations as $inv) {
            if ($inv['ExamDate'] === $exam['ExamDate'] && $inv['ExamTime'] === $exam['ExamTime']) {
                return true;
            }
        }

        return false;
    }

    public function assignTeacherToExam($examId, $teacherId, $roomId) {
        $sql = "INSERT INTO exam_invigilation (exam_id, teacher_id, room_id) VALUES (:examId, :teacherId, :roomId)";
        $params = array(
            ':examId' => $examId,
            ':teacherId' => $teacherId,
            ':roomId' => $roomId
        );
        return $this->updateQuery($sql, $params);
    }
    public function getNumberOfTeachers($examId, $roomId) {
        $sql = "SELECT COUNT(*) AS num_teachers FROM exam_invigilation WHERE exam_id = :examId AND room_id = :roomId";
        $params = array(
            ':examId' => $examId,
            ':roomId' => $roomId
        );
        $result = $this->selectQuery($sql, $params);
        return $result[0]['num_teachers'];
    }
}
?>
