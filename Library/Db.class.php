<?php
class Db
{
    public  $conn = null;
    function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host=' . HOST_DB . ';dbname=' . DB, USER_DB, PASS_DB);
            $this->conn->query('set names utf8');
        } catch (PDOException $e) {
            echo 'ERROR';
            exit;
        }
    }


    function getTable($tableName)
    {
        $stm = $this->conn->prepare("select * from $tableName");
        $stm->execute();
        return $stm->fetchAll();
    }

    function selectQuery($sql, $arr = array())
    {
        $stm = $this->conn->prepare($sql);
        $stm->execute($arr);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateQuery($sql, $arr = array())
    {
        $stm = $this->conn->prepare($sql);
        $stm->execute($arr);


     
        return $stm->rowCount();
    }


    function insert_query($sql)
    {
        $stm = $this->conn->prepare($sql);
        $stm->execute();

        return $stm->rowCount();
    }
    function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    function commit()
    {
        $this->conn->commit();
    }

    function rollBack()
    {
        $this->conn->rollBack();
    }

    function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }
}
