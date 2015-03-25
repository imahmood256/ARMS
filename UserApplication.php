<?php

namespace My\Application;

use My\Service\UserService;
use My\Service\ValidatorService;

session_start();
require_once "Dao/BaseDao.php";
require_once "Dao/UserDao.php";
require_once "Service/ValidatorService.php";
require_once "Service/UserService.php";

class UserApplication {

    public function __construct(UserService $userService, ValidatorService $validator) {
        $this->userService = $userService;
        $this->validator = $validator;

        if (isset($_POST['login'])) {
            $this->login();
        } else if (isset($_POST['add'])) {
            $this->addUser();
        } else if (isset($_POST['update'])) {
            unset($_SESSION['statusMsg']);
            $this->update();
        } else if (isset($_GET['logout'])) {
            $this->logout();
        } else if (isset($_GET['delete'])) {
            $this->delete();
        }
    }

    public function login() {
        $success = $this->userService->login($_POST);

        if ($success) {
            $_SESSION['statusMsg'] = "Successful login!";
            header("Location: ArmsStatus.php");
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $this->validator->getErrorArray();
            header("Location: index.php");
        }
    }

    public function addUser() {
        $success = $this->userService->addUser($_POST);
        if ($success) {
            $_SESSION['statusMsg'] = "User added successfully!";
            header("Location: adminHome.php");
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $this->validator->getErrorArray();
            header("Location: addUser.php");
        }
    }

    public function update() {
        $updateId = $_GET['uID'];
        $success = $this->userService->update($_POST);
        if ($success) {
            $_SESSION['statusMsg'] = "User info successfully updated!";
            header("Location: adminHome.php");
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $this->validator->getErrorArray();
            header("Location: updateUser.php?uID=" . $updateId . "");
        }
    }

    public function logout() {
        $success = $this->userService->logout();
        header("Location:index.php");
    }

    public function delete() {
        $success = $this->userService->delete($_GET['delete']);
        if ($success) {
            $_SESSION['statusMsg'] = "User account has been deleted successfully!";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $this->validator->getErrorArray();
        }
        header("Location: adminHome.php");
    }

}

$userApp = new \My\Application\UserApplication($userService, $validator);
?>
