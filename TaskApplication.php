<?php

namespace My\Application;

use My\Service\TaskService;

require_once "Dao/BaseDao.php";
require_once "Dao/TaskDao.php";
require_once "Service/TaskService.php";

class TaskApplication {

    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
        
        //if is set 'stop button' then : stop()
    }
    
    //public function stop() {.....}
}

$taskApp = new \My\Application\TaskApplication($taskService);
?>

