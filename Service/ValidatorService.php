<?php

namespace My\Service;

use My\Dao\UserDao;

class ValidatorService {

    private $values = array();
    private $errors = array();
    public $statusMsg = null;
    public $num_errors;

    public function __construct() {
        if (isset($_SESSION['value_array']) && isset($_SESSION['error_array'])) {
            $this->values = $_SESSION['value_array'];
            $this->errors = $_SESSION['error_array'];
            $this->num_errors = count($this->errors);
            unset($_SESSION['value_array']);
            unset($_SESSION['error_array']);
        } else {
            $this->num_errors = 0;
        }

        if (isset($_SESSION['statusMsg'])) {
            $this->statusMsg = $_SESSION['statusMsg'];
            unset($_SESSION['statusMsg']);
        }
    }

    public function setUserDao(UserDao $userDao) {
        $this->userDao = $userDao;
    }

    public function setValue($field, $value) {
        $this->values[$field] = $value;
    }

    public function getValue($field) {
        if (array_key_exists($field, $this->values)) {
            return htmlspecialchars(stripslashes($this->values[$field]));
        } else {
            return "";
        }
    }

    private function setError($field, $errmsg) {
        $this->errors[$field] = $errmsg;
        $this->num_errors = count($this->errors);
    }

    public function getError($field) {
        if (array_key_exists($field, $this->errors)) {
            return $this->errors[$field];
        } else {
            return "";
        }
    }

    public function getErrorArray() {
        return $this->errors;
    }

    public function validate($field, $value) {
        $valid = false;
        if (!$this->isEmpty($field, $value)) {
            $valid = true;
        }
        if ($valid == true) {
            $valid = $this->checkFormat($field, $value);
        }
        return $valid;
    }

    private function isEmpty($field, $value) {
        $value = trim($value);
        if (empty($value)) {
            $this->setError($field, "Field value not entered");
            return true;
        }
        return false;
    }

    private function checkFormat($field, $value) {
        switch ($field) {
            case 'name':
                $regex = "/^([a-z ])+$/i";
                $msg = "Name must be alphabetic";
                break;
            case 'jobTitle':
                $regex = "/^([a-z ])+$/i";
                $msg = "Job title must be alphabetic";
                break;
            case 'accID':
                $regex = "/^([0-9])+$/";
                $msg = "Id not numeric";
                break;
            case 'accPass':
                $regex = "/^([0-9a-z])+$/i";
                $msg = "Password not alphanumeric";
                break;
            default:
                $regex = "";
                break;
        }
        if (!preg_match($regex, ( $value = trim($value)))) {
            $this->setError($field, $msg);
            return false;
        }
        return true;
    }

    public function validateCredentials($userid, $password) {
        $result = $this->userDao->checkPassConfirmation($userid, md5($password));
        if ($result === false) {
            $this->setError("password", "Username or password is incorrect");
            return false;
        }

        return true;
    }

    public function idExists($username) {
        if ($this->userDao->userTaken($username)) {
            $this->setError('username', "Username already in use");
            return true;
        }
        return false;
    }

    public function checkPassword($username, $password) {
        $result = $this->userDao->checkPassConfirmation($username, md5($password));
        if ($result === false) {
            $this->setError("password", "Current password incorrect");
            return false;
        }
        return true;
    }

}

$validator = new \My\Service\ValidatorService;
$validator->setUserDao($userDao);
?>


