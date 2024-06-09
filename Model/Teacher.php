<?php

class Teacher extends Db {
    // Get teacher's information by user ID
    public function getTeacherByUserId($userId) {
        $sql = "SELECT t.*, u.FullName
                FROM teachers t
                INNER JOIN users u ON t.UserID = u.UserID
                WHERE t.UserID = :userId";
        $params = array(':userId' => $userId);
        return $this->selectQuery($sql, $params);
    }

    // Get all sections taught by a teacher
    public function getSectionsByTeacherId($teacherId) {
        $sql = "SELECT ss.*, s.SubjectName 
                FROM subjects_section ss
                INNER JOIN subjects_section_detail ssd ON ss.SectionID = ssd.SectionID
                INNER JOIN subjects s ON ss.SubjectID = s.SubjectID
                WHERE ssd.TeacherID = :teacherId";
        $params = array(':teacherId' => $teacherId);
        return $this->selectQuery($sql, $params);
    }

    // Get all students in a specific section
    public function getStudentsBySectionId($sectionId) {
        $sql = "SELECT st.*, u.FullName,ss.*
                FROM student_semester ss
                INNER JOIN student st ON ss.StudentID = st.StudentID
                INNER JOIN users u ON st.UserID = u.UserID
                WHERE ss.SectionID = :sectionId";
        $params = array(':sectionId' => $sectionId);
        return $this->selectQuery($sql, $params);
    }

    // Save grades for students in a section
    public function saveGrade($studentId, $sectionId, $gradeInClass, $finalExamGrade) {
        $finalGrade = $this->calculateFinalGrade($gradeInClass, $finalExamGrade);
        $sql = "INSERT INTO `student_semester`(`SemesterID`, `SectionID`, `StudentID`, `Grade`, `semester`, `GradeInClass`) 
                VALUES (:studentId, :sectionId, :gradeInClass, :finalExamGrade, :finalGrade)
                ON DUPLICATE KEY UPDATE 
                    GradeInClass = VALUES(GradeInClass), 
                    FinalExamGrade = VALUES(FinalExamGrade), 
                    FinalGrade = VALUES(FinalGrade)";
        $params = array(
            ':studentId' => $studentId,
            ':sectionId' => $sectionId,
            ':gradeInClass' => $gradeInClass,
            ':finalExamGrade' => $finalExamGrade,
            ':finalGrade' => $finalGrade
        );
        return $this->updateQuery($sql, $params);
    }

    // Calculate final grade based on class and exam grades
    private function calculateFinalGrade($gradeInClass, $finalExamGrade) {
        return ($finalExamGrade * 0.7) + ($gradeInClass * 0.3);
    }
}

?>
