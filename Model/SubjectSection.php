<?php

class SubjectSection extends Db {
    public function getAllSections() {
        return $this->getTable('subjects_section');
    }
    public function getAllSection() {
        $sql = "SELECT ss.*, s.SubjectName 
                FROM subjects_section ss
                INNER JOIN subjects_section_detail ssd ON ss.SectionID = ssd.SectionID
                INNER JOIN subjects s ON ss.SubjectID = s.SubjectID";
        return $this->selectQuery($sql);
    }
    public function getSectionById($sectionId) {
        $sql = "SELECT * FROM subjects_section WHERE SectionID = :sectionId";
        $params = array(':sectionId' => $sectionId);
        return $this->selectQuery($sql, $params);
    }
    
    public function getSectionsBySubjectId($subjectId) {
        $sql = "SELECT * FROM subjects_section WHERE SubjectID = :subjectId";
        $params = array(':subjectId' => $subjectId);
        return $this->selectQuery($sql, $params);
    }

    public function addSection($subjectId, $sectionName) {
        $sql = "INSERT INTO subjects_section (SubjectID, SectionName) VALUES (:subjectId, :sectionName)";
        $params = array(
            ':subjectId' => $subjectId,
            ':sectionName' => $sectionName
        );
        return $this->updateQuery($sql, $params);
    }
    public function getStudentsBySectionId($sectionId) {
        $sql = "SELECT ss.*,u.* FROM student_semester ss
                JOIN student s ON s.StudentID = ss.StudentID
                JOIN users u ON u.UserID = s.UserID 
                WHERE SectionID = :sectionId";
        $params = array(':sectionId' => $sectionId);
        return $this->selectQuery($sql, $params);
    }
    public function updateSection($sectionId, $subjectId, $sectionName) {
        $sql = "UPDATE subjects_section SET SubjectID = :subjectId, SectionName = :sectionName WHERE SectionID = :sectionId";
        $params = array(
            ':sectionId' => $sectionId,
            ':subjectId' => $subjectId,
            ':sectionName' => $sectionName
        );
        return $this->updateQuery($sql, $params);
    }

    public function deleteSection($sectionId) {
        $sql = "DELETE FROM subjects_section WHERE SectionID = :sectionId";
        $params = array(':sectionId' => $sectionId);
        return $this->updateQuery($sql, $params);
    }
}

?>
