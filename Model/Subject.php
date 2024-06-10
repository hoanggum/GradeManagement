<?php

class Subject extends Db {
    public function getAllSubjects() {
        $sql = "SELECT * FROM subjects";
        return $this->selectQuery($sql);
    }

    public function getSubjectById($subjectId) {
        $sql = "SELECT * FROM subjects WHERE SubjectID = :subjectId";
        $params = array(':subjectId' => $subjectId);
        return $this->selectQuery($sql, $params);
    }

    public function addSubject($subjectName, $subjectCode, $credits) {
        $sql = "INSERT INTO subjects (SubjectName, SubjectCode, Credits) VALUES (:subjectName, :subjectCode, :credits)";
        $params = array(
            ':subjectName' => $subjectName,
            ':subjectCode' => $subjectCode,
            ':credits' => $credits
        );
        return $this->updateQuery($sql, $params);
    }

    public function updateSubject($subjectId, $subjectName, $subjectCode, $credits) {
        $sql = "UPDATE subjects SET SubjectName = :subjectName, SubjectCode = :subjectCode, Credits = :credits WHERE SubjectID = :subjectId";
        $params = array(
            ':subjectId' => $subjectId,
            ':subjectName' => $subjectName,
            ':subjectCode' => $subjectCode,
            ':credits' => $credits
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
