<?php

class Teacher extends Db
{
    // Get teacher's information by user ID
    public function getTeacherByUserId($userId)
    {
        $sql = "SELECT t.*, u.FullName
                FROM teacher t
                INNER JOIN users u ON t.UserID = u.UserID
                WHERE t.UserID = :userId";
        $params = array(':userId' => $userId);
        return $this->selectQuery($sql, $params);
    }

    // Get all sections taught by a teacher
    public function getSectionsByTeacherId($teacherId)
    {
        $sql = "SELECT ss.*, s.SubjectName 
                FROM subjects_section ss
                INNER JOIN subjects_section_detail ssd ON ss.SectionID = ssd.SectionID
                INNER JOIN subjects s ON ss.SubjectID = s.SubjectID
                WHERE ssd.TeacherID = :teacherId";
        $params = array(':teacherId' => $teacherId);
        return $this->selectQuery($sql, $params);
    }

    // Get all students in a specific section
    public function getStudentsBySectionId($sectionId)
    {
        $sql = "SELECT st.*, u.FullName,ss.*
                FROM student_semester ss
                INNER JOIN student st ON ss.StudentID = st.StudentID
                INNER JOIN users u ON st.UserID = u.UserID
                WHERE ss.SectionID = :sectionId";
        $params = array(':sectionId' => $sectionId);
        return $this->selectQuery($sql, $params);
    }

    // Save grades for students in a section
    public function saveGrade($studentId, $sectionId, $gradeInClass, $finalExamGrade)
    {

        $sql = "UPDATE `student_semester` SET  `Grade` = :grade, `gradeInClass` = :gradeInClass WHERE `SectionID` = :sectionId AND `StudentID` = :studentId";
        $params = array(
            ':studentId' => $studentId,
            ':sectionId' => $sectionId,
            ':gradeInClass' => $gradeInClass,
            ':grade' => $finalExamGrade

        );
        return $this->updateQuery($sql, $params);
    }
    public function getSudent_by_Id($student_name)
    {
        $sql_select = "SELECT student.StudentID FROM student LEFT JOIN users ON student.UserID = users.UserID WHERE `FullName`=:students";
        $parames = array(
            ':students' => $student_name
        );
        return $this->selectQuery($sql_select, $parames);
    }
    public function import_file_excel_point($sectionID, $studentId, $grade, $semester, $gradeInClass)
    {
        $sql = "INSERT INTO `student_semester`(`SectionID`, `StudentID`, `Grade`, `semester`, `GradeInClass`) 
                VALUES (:sectionID, :studentId, :grade, :semester, :gradeInClass)";
    
        $params = array(
            ':sectionID' => $sectionID,
            ':studentId' => $studentId,
            ':grade' => $grade,
            ':semester' => $semester,
            ':gradeInClass' => $gradeInClass
        );
    
        return $this->updateQuery($sql, $params);
    }
    

    // Calculate final grade based on class and exam grades
    private function calculateFinalGrade($gradeInClass, $finalExamGrade)
    {
        return ($finalExamGrade * 0.7) + ($gradeInClass * 0.3);
    }
}
