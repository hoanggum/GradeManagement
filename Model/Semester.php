<?php

class Semester extends Db {
    public function getAllSemesters() {
        return $this->getTable("student_semester");
    }

    public function getSemesterById($semesterId) {
        $sql = "SELECT s.*, u.FullName 
                FROM student_semester s 
                INNER JOIN student st ON s.StudentID = st.StudentID
                INNER JOIN users u ON st.UserID = u.UserID
                WHERE s.SemesterID = :semesterId";
        $params = array(':semesterId' => $semesterId);
        return $this->selectQuery($sql, $params);
    }

    public function countSemester($semester) {
        $sql = "SELECT COUNT(*) AS NumberSemester
                FROM student_semester s
                WHERE s.semester = :semester";
        $params = array(':semester' => $semester);
        return $this->selectQuery($sql, $params);
    }

    public function addSemester($sectionId, $studentId, $grade, $semester) {
        $sql = "INSERT INTO student_semester (SectionID, StudentID, Grade, semester) VALUES (:sectionId, :studentId, :grade, :semester)";
        $params = array(
            ':sectionId' => $sectionId,
            ':studentId' => $studentId,
            ':grade' => $grade,
            ':semester' => $semester
        );
        return $this->updateQuery($sql, $params);
    }

    public function updateSemester($semesterId, $sectionId, $studentId, $grade, $semester) {
        $sql = "UPDATE student_semester SET SectionID = :sectionId, StudentID = :studentId, Grade = :grade, semester = :semester WHERE SemesterID = :semesterId";
        $params = array(
            ':semesterId' => $semesterId,
            ':sectionId' => $sectionId,
            ':studentId' => $studentId,
            ':grade' => $grade,
            ':semester' => $semester
        );
        return $this->updateQuery($sql, $params);
    }
    

    public function getLastInsertedId() {
        return $this->lastInsertId();
    }

    public function deleteSemester($semesterId) {
        $sql = "DELETE FROM student_semester WHERE SemesterID = :semesterId";
        $params = array(':semesterId' => $semesterId);
        return $this->updateQuery($sql, $params);
    }

    public function getSemestersBySemester($semester) {
        $sql = "SELECT s.*, u.FullName 
                FROM student_semester s 
                INNER JOIN student st ON s.StudentID = st.StudentID
                INNER JOIN users u ON st.UserID = u.UserID
                WHERE s.semester = :semester";
        $params = array(':semester' => $semester);
        return $this->selectQuery($sql, $params);
    }
    public function getSemestersByUserId($userId) {
        $sql = "SELECT s.*, st.StudentID, u.FullName,ss.*,sj.*
                FROM student_semester s
                INNER JOIN student st ON s.StudentID = st.StudentID
                INNER JOIN users u ON st.UserID = u.UserID
                INNER JOIN subjects_section ss ON ss.SectionID = s.SectionID
                INNER JOIN subjects sj ON sj.SubjectID = ss.SubjectID
                WHERE u.UserID = :userId";
        $params = array(':userId' => $userId);
        return $this->selectQuery($sql, $params);
    }
    public function calculateFinalGrade($gradeInClass, $finalExamGrade) {

        $finalGrade = ($finalExamGrade * 0.7) + ($gradeInClass * 0.3);

        return $finalGrade;
    }
    public function convertToGradePoint4($finalGrade) {
        if ($finalGrade >= 8.5) {
            return 4.0;
        } elseif ($finalGrade >= 7.5) {
            return 3.5;
        } elseif ($finalGrade >= 6.5) {
            return 3.0;
        } elseif ($finalGrade >= 5.5) {
            return 2.5;
        } elseif ($finalGrade >= 4.5) {
            return 2.0;
        } elseif ($finalGrade >= 4.0) {
            return 1.5;
        } else {
            return 0.0;
        }
    }
    
    public function convertToLetterGrade($finalGrade) {
        if ($finalGrade >= 8.5) {
            return 'A';
        } elseif ($finalGrade >= 7.5) {
            return 'B+';
        } elseif ($finalGrade >= 6.5) {
            return 'B';
        } elseif ($finalGrade >= 5.5) {
            return 'C+';
        } elseif ($finalGrade >= 4.5) {
            return 'C';
        } elseif ($finalGrade >= 4.0) {
            return 'D';
        } else {
            return 'F';
        }
    }
    public function evaluateGrade($finalGrade) {
        if ($finalGrade >= 8.5) {
            return 'Giỏi';
        } elseif ($finalGrade >= 7.5) {
            return 'Khá';
        } elseif ($finalGrade >= 6.5) {
            return 'Trung bình khá';
        } elseif ($finalGrade >= 5.5) {
            return 'Trung bình';
        } elseif ($finalGrade >= 4.5) {
            return 'Yếu';
        } else {
            return 'Kém';
        }
    }
    
}

?>
