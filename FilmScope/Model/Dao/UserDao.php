<?php

namespace Model\Dao;

class UserDao extends DbConnection {

    public static function getUserByUsername($username) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public static function getUserByEmail($email) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function addUser($username, $firstName, $lastName, $email, $is_admin, $password) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("INSERT INTO users (username,first_name,last_name,email,is_admin,password,register_date) VALUES (?, ?, ?, ?,?,?,CURDATE())");
        return $stmt->execute([$username, $firstName, $lastName, $email, $is_admin, $password]);
    }

    //Проверяваме дали вече има поне един потребител в системата.
    public static function existsEmail() {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users");
        $stmt->execute();
        $result = $stmt->fetch();
        // Ако в таблицата има поне един ред връща true
        return $result['count'] > 0;
    }

    public static function isAdmin() {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE is_admin = 1");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    public static function updateUserProfile($username, $firstName, $lastName, $email, $password) {
        $pdo = self::getPdo();
        $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $password, $username]);
    }
}
