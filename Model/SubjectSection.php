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
    
    public function getSectionsBySubjectId($subjectId, $semester = null) {
        $sql = "SELECT * FROM subjects_section WHERE SubjectID = :subjectId";
        $params = array(':subjectId' => $subjectId);
    
        // Nếu giá trị của semester được cung cấp, thêm điều kiện vào truy vấn SQL
        if ($semester !== null && $semester !== 0) {
            $sql .= " AND Semester = :semester";
            $params[':semester'] = $semester;
        }
    
        return $this->selectQuery($sql, $params);
    }
    

    public function addSection($subjectID, $startDate, $endDate, $schedule, $semester) {
        $sql = "INSERT INTO `subjects_section`(`StartDate`, `EndDate`, `Schedule`, `SubjectID`, `Semester`) VALUES (:startDate, :endDate, :schedule, :subjectId, :semester)";
        $params = array(
            ':startDate' => $startDate,
            ':endDate' => $endDate,
            ':schedule' => $schedule,
            ':subjectId' => $subjectID,
            ':semester' => $semester
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
