<?php

class ExamSchedule extends Db {
    
    // Method to get exam schedule details by ID
    public function getExamScheduleById($examId) {
        $sql = "SELECT * FROM examschedule WHERE Exam_ID = :examId";
        $params = array(':examId' => $examId);
        return $this->selectQuery($sql, $params);
    }

    // Method to get all exam schedules
    public function getAllExamSchedules() {
        $sql = "SELECT * FROM examschedule";
        return $this->selectQuery($sql);
    }

    // Method to add a new exam schedule
    public function addExamSchedule($examDate, $examRound, $examTime, $duration, $sectionId) {
        $sql = "INSERT INTO examschedule (ExamDate, ExamRound, ExamTime, Duration, section_ID) VALUES (:examDate, :examRound, :examTime, :duration, :sectionId)";
        $params = array(
            ':examDate' => $examDate,
            ':examRound' => $examRound,
            ':examTime' => $examTime,
            ':duration' => $duration,
            ':sectionId' => $sectionId
        );
        return $this->updateQuery($sql, $params);
    }

    // Method to update an existing exam schedule
    public function updateExamSchedule($examId, $examDate, $examRound, $examTime, $duration, $sectionId) {
        $sql = "UPDATE examschedule SET ExamDate = :examDate, ExamRound = :examRound, ExamTime = :examTime, Duration = :duration, section_ID = :sectionId WHERE Exam_ID = :examId";
        $params = array(
            ':examId' => $examId,
            ':examDate' => $examDate,
            ':examRound' => $examRound,
            ':examTime' => $examTime,
            ':duration' => $duration,
            ':sectionId' => $sectionId
        );
        return $this->updateQuery($sql, $params);
    }

    // Method to delete an exam schedule
    public function deleteExamSchedule($examId) {
        $sql = "DELETE FROM examschedule WHERE Exam_ID = :examId";
        $params = array(':examId' => $examId);
        return $this->updateQuery($sql, $params);
    }

    // Method to get exam rooms by schedule ID
    public function getExamRoomsByScheduleId($scheduleId) {
        $sql = "SELECT * FROM exam_rooms WHERE ScheduleID = :scheduleId";
        $params = array(':scheduleId' => $scheduleId);
        return $this->selectQuery($sql, $params);
    }

    // Method to get exam rooms by exam ID
    public function getExamRoomsByExamId($examId) {
        $sql = "SELECT * 
                FROM examroom er
                JOIN examscheduledetail es on es.room_id = er.room_id
                WHERE Exam_ID = :examId";
        $params = array(':examId' => $examId);
        return $this->selectQuery($sql, $params);
    }

    // Add other methods as needed for ExamSchedule class
    public function getStudentExamSchedule($studentId) {
        $sql = "SELECT 
                    es.Exam_ID,
                    es.ExamDate,
                    es.ExamRound,
                    es.ExamTime,
                    es.Duration,
                    s.SubjectName,
                    er.room_name
                FROM 
                    examscheduledetail esd
                JOIN 
                    examschedule es ON esd.Exam_ID = es.Exam_ID
                JOIN 
                    examroom er ON esd.room_id = er.room_id
                JOIN 
                    subjects_section ss ON ss.SectionID = es.section_ID
                JOIN 
                    subjects s ON s.SubjectID = ss.SubjectID
                WHERE 
                    esd.StudentID = :studentId";
        $params = array(':studentId' => $studentId);
        return $this->selectQuery($sql, $params);
    }
}

?>
