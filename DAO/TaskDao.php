<?php

namespace My\Dao;

class TaskDao extends BaseDao {

    private $db = null;

    public function __construct() {
        $this->db = $this->getDb();
    }
    
    
    public function get($currTime) {
        $statement = $this->db->prepare("SELECT * FROM task WHERE endTime >:currentTime LIMIT 1");
        $statement->bindParam(':currentTime', $currTime);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $row = $statement->fetch();
            return $row;
        }
        return false;
    }
    
    public function getCreator($taskid)
    {
        $statement = $this->db->prepare("SELECT mUserID FROM managetask WHERE mTaskID= :taskId");
        $statement->bindParam(':taskId', $taskid);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $row = $statement->fetch();

            return $row;
        }
    }

    
    public function insert(array $values){}

    public function update($id, array $values){}

    public function delete($uniqueKey){}

}

$taskDao = new \My\Dao\TaskDao;
?>