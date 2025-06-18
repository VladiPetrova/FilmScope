<?php

namespace Controller;

use Model\User;

class UserController {

    public function login() {
        $error = "";
        $model = new User();

        if (isset($_POST["login"])) {

            $username = (htmlentities($_POST["username"]));
            $password = $_POST["password"];

            $result = $model->login($username, $password);

            if ($result['success']) {
                header('Location: ?target=base&action=index');
                die();
            } else {
                $error = $result['error'];
            }
        }

        require_once 'View/user/login.php';
    }

    public function registration() {
        $error = "";
        $model = new User();

        if (isset($_POST["register"])) {
            $result = $model->register($_POST);

            if ($result['success']) {
                header('Location: ?target=user&action=login');
                die();
            } else {
                // Ако има грешки при регистрацията,
                // ги обединява с <br> и ги записва в променливата $error за показване
                $error = implode('<br>', $result['errors']);
            }
        }

        require_once 'View/user/registration.php';
    }
}
