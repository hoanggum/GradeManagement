<?php
require_once BASE_PATH . '/Library/Db.class.php';

class Department extends Db {
    public function getAllDepartments() {
        $sql = "SELECT * FROM department";
        return $this->selectQuery($sql);
    }
}
?>