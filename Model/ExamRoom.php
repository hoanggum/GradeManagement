<?php
class ExamRoom extends Db {
    public function getAllRooms() {
        $sql = "SELECT room_id, room_name, capacity FROM examroom";
        return $this->selectQuery($sql);
    }

    public function getRoomById($roomId) {
        $sql = "SELECT room_id, room_name, capacity FROM examroom WHERE room_id = :roomId";
        $params = array(':roomId' => $roomId);
        return $this->selectQuery($sql, $params);
    }

    public function createRoom($roomName, $capacity) {
        $sql = "INSERT INTO examroom (room_name, capacity) VALUES (:roomName, :capacity)";
        $params = array(':roomName' => $roomName, ':capacity' => $capacity);
        return $this->updateQuery($sql, $params);
    }

    public function updateRoom($roomId, $roomName, $capacity) {
        $sql = "UPDATE examroom SET room_name = :roomName, capacity = :capacity WHERE room_id = :roomId";
        $params = array(':roomId' => $roomId, ':roomName' => $roomName, ':capacity' => $capacity);
        return $this->updateQuery($sql, $params);
    }

    public function deleteRoom($roomId) {
        $sql = "DELETE FROM examroom WHERE room_id = :roomId";
        $params = array(':roomId' => $roomId);
        return $this->updateQuery($sql, $params);
    }
    public function getExamRoomsByExamId($examId) {
        $sql = "SELECT * 
                FROM examroom er
                JOIN examscheduledetail es on es.room_id = er.room_id
                WHERE Exam_ID = :examId";
        $params = array(':examId' => $examId);
        return $this->selectQuery($sql, $params);
    }
}
?>
