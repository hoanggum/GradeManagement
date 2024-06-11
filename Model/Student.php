<?php
require_once BASE_PATH . '/Library/Db.class.php';

class Student extends Db {
    public function getStudentsBySection($sectionId) {
        $sql = "SELECT StudentID FROM student_semester WHERE SectionID = :sectionId";
        $params = array(':sectionId' => $sectionId);
        return $this->selectQuery($sql, $params);
    }
}
?>
