<?php

class Teacher extends Db {
    // Get teacher's information by user ID
    public function getTeacherByUserId($userId) {
        $sql = "SELECT t.*, u.FullName
                FROM teacher t
                INNER JOIN users u ON t.UserID = u.UserID
                WHERE t.UserID = :userId";
        $params = array(':userId' => $userId);
        return $this->selectQuery($sql, $params);
    }

    public function getRegisteredExams($teacherId) {
        // Thực hiện truy vấn để lấy danh sách các ca thi đã đăng ký gác thi của giáo viên
        $sql = "SELECT * FROM exam_invigilation WHERE teacher_id = :teacherId";
        $params = array(':teacherId' => $teacherId);
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
        $sql = "UPDATE student_semester SET  Grade = :grade, gradeInClass = :gradeInClass WHERE SectionID = :sectionId AND StudentID = :studentId";
        $params = array(
            ':studentId' => $studentId,
            ':sectionId' => $sectionId,
            ':gradeInClass' => $gradeInClass,
            ':grade' => $finalExamGrade,
        );
        return $this->updateQuery($sql, $params);
    }

}

?>
