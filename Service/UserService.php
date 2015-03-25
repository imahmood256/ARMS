<?php

namespace My\Service;

use My\Dao\UserDao;
use My\Service\ValidatorService;

class UserService {

    public $userid;
    public $password;
    public $name;
    public $job;
    public $admin;
    public $logged_in;

    public function __construct(UserDao $userDao, ValidatorService $validator) {
        $this->userDao = $userDao;
        $this->validator = $validator;
        $this->logged_in = $this->isLogin();
    }

    private function isLogin() {

        if (isset($_SESSION['uid'])) {
            $userinfo = $this->userDao->get($_SESSION['uid']);
            if (!$userinfo) {
                return false;
            }

            $this->userid = $userinfo['accID'];
            $this->name = $userinfo['name'];
            $this->job = $userinfo['jobTitle'];
            $this->admin = $userinfo['manager'];

            return true;
        }
        return false;
    }

    public function login($values) {
        $userid = $values['accID'];
        $password = $values['accPass'];

        $this->validator->validate("accID", $userid);
        $this->validator->validate("accPass", $password);

        if ($this->validator->num_errors > 0) {
            return false;
        }

        if (!$this->validator->validateCredentials($userid, $password)) {
            return false;
        }

        $userinfo = $this->userDao->get($userid);
        if (!$userinfo) {
            return false;
        }

        $this->userid = $userinfo['accID'];
        $this->name = $userinfo['name'];
        $this->job = $userinfo['jobTitle'];
        $this->admin = $userinfo['manager'];
        $_SESSION['uid'] = $userinfo['accID'];
        return true;
    }

    public function addUser($values) {

        $userid = $values['accID'];
        $password = $values['accPass'];
        $name = $values['name'];
        $job = $values['jobTitle'];

        $this->validator->validate("accID", $userid);
        $this->validator->validate("name", $name);
        $this->validator->validate("accPass", $password);
        $this->validator->validate("jobTitle", $job);

        if ($this->validator->num_errors > 0) {
            return false;
        }

        if ($this->validator->idExists($userid)) {
            return false;
        }

        return $this->userDao->insert(array('accID' => $userid, 'accPass' => md5($password),
                    'name' => $name, 'jobTitle' => $job, 'manager' => 0));
    }

    public function getUser($userid) {
        $this->validator->validate("accID", $userid);
        if ($this->validator->num_errors > 0) {
            return false;
        }

        if (!$this->validator->idExists($userid)) {
            return false;
        }

        $userinfo = $this->userDao->get($userid);
        if ($userinfo) {
            return $userinfo;
        }
        return false;
    }

    public function getAllUsers() {
        $usersinfo = $this->userDao->getAll();
        if ($usersinfo) {
            return $usersinfo;
        }
        return false;
    }

    public function update($values) {

        $userid = $values['accID'];
        $newPassword = $values['accPass'];
        $name = $values['name'];
        $job = $values['jobTitle'];
        $updates = array();

        if ($userid) {
            $this->validator->validate("accID", $userid);
            $updates['accID'] = $userid;
        }
        if ($name) {
            $this->validator->validate("name", $name);
            $updates['name'] = $name;
        }
        if ($job) {
            $this->validator->validate("jobTitle", $job);
            $updates['jobTitle'] = $job;
        }
        if ($newPassword) {
            $this->validator->validate("accPass", $newPassword);
            $updates['accPass'] = md5($newPassword);
        }

        if ($this->validator->num_errors > 0) {
            return false;
        }

        $this->userDao->update($userid, $updates);
        return true;
    }

    public function logout() {
        unset($_SESSION['uid']);
        $this->logged_in = false;
    }

    public function delete($userid) {
        $this->validator->validate("accID", $userid);
        if ($this->validator->num_errors > 0) {
            return false;
        }

        if (!$this->validator->idExists($userid)) {
            return false;
        }

        if ($this->userDao->delete($userid)) {
            return true;
        } else {
            return false;
        }
    }

}

$userService = new \My\Service\UserService($userDao, $validator);
?>