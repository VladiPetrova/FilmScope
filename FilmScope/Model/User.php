<?php

namespace Model;

use Model\Dao\UserDao;

class User {

    public function login($username, $password) {
        $error = "";
        $user = UserDao::getUserByUsername($username);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user["username"];

            if ($user["is_admin"] == 1) {
                $_SESSION["isAdmin"] = true;
            } else {
                $_SESSION["isAdmin"] = false;
            }

            return ['success' => true, 'error' => '', 'user' => $user];
        } else {
            $error = "Invalid credentials!";
            return ['success' => false, 'error' => $error];
        }
    }

    public function validateUserData($data, $isUpdate = false) {
        $errors = [];

        //Username
        if (!empty($data['username'])) {
            $username = htmlentities($data['username']);
            if (strlen($username) < 2 || strlen($username) > 20 || !preg_match("/^[a-zA-Zа-яА-Я]+$/u", $username)) {
                $errors[] = "The username must be between 2 and 20 letters long and consist only of letters.";
            }
        } elseif (!$isUpdate) {
            $errors[] = "First name is required.";
        }

        // Име
        if (!empty($data['first_name'])) {
            $firstName = htmlentities($data['first_name']);
            if (strlen($firstName) < 2 || strlen($firstName) > 20 || !preg_match("/^[a-zA-Zа-яА-Я]+$/u", $firstName)) {
                $errors[] = "The first name must be between 2 and 20 letters long and consist only of letters.";
            }
        } elseif (!$isUpdate) {
            $errors[] = "First name is required.";
        }

        // Фамилия
        if (!empty($data['last_name'])) {
            $lastName = htmlentities($data['last_name']);
            if (strlen($lastName) < 2 || strlen($lastName) > 20 || !preg_match("/^[a-zA-Zа-яА-Я]+$/u", $lastName)) {
                $errors[] = "The last name must be between 2 and 20 letters long and consist only of letters.";
            }
        } elseif (!$isUpdate) {
            $errors[] = "Last name is required.";
        }

        // Имейл
        if (!empty($data['email'])) {
            $email = htmlentities($data['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email address.";
            }
        } elseif (!$isUpdate) {
            $errors[] = "Email is required.";
        }

        if (!empty($data['email'])) {
            $email = htmlentities($data['email']);
            $existingUser = UserDao::getUserByEmail($email);
            if ($existingUser) {
                $errors[] = "This email is taken.";
            }
        }

        // Парола
        if (!empty($data['password']) && $data['password'] !== '') {
            $password = $data['password'];
            if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[\W_]/", $password)) {
                $errors[] = "The password must be at least 8 characters long, contain at least one capital letter and at least one special character.";
            }
        } elseif (!$isUpdate) {
            $errors[] = "Password is required.";
        }

        return $errors;
    }

    public function register($data) {
        $errors = $this->validateUserData($data);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $username = htmlentities(trim(($data['username'])));
        $password = $data['password'];
        $firstName = htmlentities($data['first_name']);
        $lastName = htmlentities($data['last_name']);
        $email = htmlentities($data['email']);

        // Първият потребител става админ
        $is_admin = UserDao::existsEmail() > 0 ? 0 : 1;

        // Проверка за съществуващ потребител/имейл
        $existingUser = UserDao::getUserByUsername($username);
        $userEmail = UserDao::getUserByEmail($email);

        if ($existingUser || $userEmail) {
            return ['success' => false, 'errors' => ["This username  or email already exists!"]];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        UserDao::addUser($username, $firstName, $lastName, $email, $is_admin, $hashedPassword);

        return ['success' => true];
    }
}
