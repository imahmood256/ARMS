<?php

namespace My\Dao;

class UserDao extends BaseDao {

    private $db = null;

    public function __construct() {
        $this->db = $this->getDb();
    }

    public function get($id) {
        $statement = $this->db->prepare("SELECT * FROM account WHERE accID = :accountId");
        $statement->bindParam(':accountId', $id);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $row = $statement->fetch();

            return $row;
        }
    }

    public function getAll() {
        $statement = $this->db->prepare("SELECT accID,name FROM account WHERE manager <>1");
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $row = $statement->fetchAll();
            return $row;
        }
    }

    public function insert(array $values) {
        $sql = "INSERT INTO account ";
        $fields = array_keys($values);
        $vals = array_values($values);
        $sql .= '(' . implode(',', $fields) . ') ';
        $arr = array();
        foreach ($fields as $f) {
            $arr[] = '?';
        }
        $sql .= 'VALUES (' . implode(',', $arr) . ') ';
        $statement = $this->db->prepare($sql);
        foreach ($vals as $i => $v) {
            $statement->bindValue($i + 1, $v);
        }
        return $statement->execute();
    }

    public function update($id, array $values) {
        $sql = "UPDATE account SET ";
        $fields = array_keys($values);
        $vals = array_values($values);
        foreach ($fields as $i => $f) {
            $fields[$i] .= ' = ? ';
        }
        $sql .= implode(',', $fields);
        $sql .= " WHERE accID = " . (int) $id . ";";

        $statement = $this->db->prepare($sql);
        foreach ($vals as $i => $v) {
            $statement->bindValue($i + 1, $v);
        }
        return $statement->execute();
    }

    public function delete($uniqueKey) {
        $sql = 'DELETE FROM account WHERE accID = ' . (int) $uniqueKey . '';
        $statement = $this->db->prepare($sql);
        echo "execute delete query";
        return $statement->execute();
    }

    public function userTaken($accId) {
        $statement = $this->db->prepare("SELECT accID FROM account WHERE accID = :id LIMIT 1 ");
        $statement->bindParam(':id', $accId);
        $statement->execute();
        return ($statement->rowCount() > 0 );
    }

    public function checkPassConfirmation($acId, $password) {
        $statement = $this->db->prepare("SELECT accPass FROM account WHERE accID ='10000'");
        // $statement->bindParam(':id', $acId);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $row = $statement->fetch();
            return ($password == $row['accPass']);
        }
        echo "      ...  user not exist .... | ";
        return false;
    }

}

$userDao = new \My\Dao\UserDao;
?>
