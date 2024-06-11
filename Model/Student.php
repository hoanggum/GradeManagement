<?php
require_once BASE_PATH . '/Library/Db.class.php';

class Student extends Db {
    public function getStudentsBySection($sectionId) {
        $sql = "SELECT StudentID FROM student_semester WHERE SectionID = :sectionId";
        $params = array(':sectionId' => $sectionId);
        return $this->selectQuery($sql, $params);
    }
    public function getStudentsByRoomId($roomId) {
        $sql = "SELECT esd.*,u.*,i.Urls
                FROM student s
                JOIN examscheduledetail esd ON s.StudentID = esd.StudentID
                JOIN users u ON u.UserID = s.UserID
                JOIN images i ON i.UserID = u.UserID
                WHERE esd.room_id = :roomId";
        $params = array(':roomId' => $roomId);
        return $this->selectQuery($sql, $params);
    }
}
?>
