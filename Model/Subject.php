<?php

class Subject extends Db {
    public function getAllSubjects() {
        $sql = "SELECT * FROM subjects";
        return $this->selectQuery($sql);
    }
    
    public function getSubjectsByDepartmentAndSemester($departmentId, $semester) {
        $sql = "SELECT sj.SubjectID, sj.SubjectName
                FROM subjects sj
                INNER JOIN subjects_section ss ON sj.SubjectID = ss.SubjectID
                WHERE ss.DepartmentID = :departmentId AND ss.Semester = :semester";
        $params = array(
            ':departmentId' => $departmentId,
            ':semester' => $semester
        );
        return $this->selectQuery($sql, $params);
    }
    
    public function getSubjectById($subjectId) {
        $sql = "SELECT * FROM subjects WHERE SubjectID = :subjectId";
        $params = array(':subjectId' => $subjectId);
        return $this->selectQuery($sql, $params);
    }

    public function addSubject($subjectName, $numOfCredits) {
        $sql = "INSERT INTO subjects (SubjectName, NumOfCredits) VALUES (:subjectName, :numOfCredits)";
        $params = array(
            ':subjectName' => $subjectName,
            ':numOfCredits' => $numOfCredits
        );
        return $this->updateQuery($sql, $params);
    }

    public function updateSubject($subjectId, $subjectName, $numOfCredits) {
        $sql = "UPDATE subjects SET SubjectName = :subjectName, NumOfCredits = :numOfCredits WHERE SubjectID = :subjectId";
        $params = array(
            ':subjectId' => $subjectId,
            ':subjectName' => $subjectName,
            ':numOfCredits' => $numOfCredits
        );
        return $this->updateQuery($sql, $params);
    }

    public function deleteSubject($subjectId) {
        $sql = "DELETE FROM subjects WHERE SubjectID = :subjectId";
        $params = array(':subjectId' => $subjectId);
        return $this->updateQuery($sql, $params);
    }
}
?>
