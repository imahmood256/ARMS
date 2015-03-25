<?php

namespace My\Service;

use My\Dao\TaskDao;

class TaskService {
    
    public $leftTime;
    public $taskTime;
    public $taskId;
    public $dest;
    public $currentTask;

    public function __construct(TaskDao $taskDao) {
        $this->taskDao = $taskDao; 
        $this->currentTask = $this->getTask();
    }
  
    public function getTask() {
        date_default_timezone_set('Asia/Riyadh');
        $currentTime=date("Y-m-d H:i:s");
        $taskinfo = $this->taskDao->get($currentTime);
        if ($taskinfo) {
            $sTime=$taskinfo['startTime'];
            $eTime=$taskinfo['endTime'];
            $this->dest= $taskinfo['des'];
            $this->taskId= $taskinfo['taskID'];
            
            $this->taskTime =(int)round(abs(strtotime($eTime) - strtotime($sTime)) / 60,2);
            $this->leftTime = (int)round(abs(strtotime($eTime) - strtotime($currentTime)) / 60,2)+1;

            if($this->leftTime >0){
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function getTaskCreator($taskId){
        $creator = $this->taskDao->getCreator($taskId);
        
        if($creator){
            return $creator;
        }else{
            return false;
        }
    }
}

$taskService = new \My\Service\TaskService($taskDao);
?>
