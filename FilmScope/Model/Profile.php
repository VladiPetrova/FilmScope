<?php

namespace Model;

use Model\Dao\UserDao;
use Model\User;

class Profile {

    public function getUserByUsername($username) {
        return UserDao::getUserByUsername($username);
    }

    public function updateProfile($username, $data) {

        $user = UserDao::getUserByUsername($username);

        // Проверява дали има поне някаква промяна в данните (ако всички полета са празни - грешка)
        if (empty($data['first_name']) && empty($data['last_name']) && empty($data['email']) && empty($data['password'])) {
            return ['errors' => ["You didn't make any updates."]];
        }

        $userModel = new User;
        // Валидира подадените данни, true означава, че това е ъпдейт, защото има различна логика при регистриране.
        $validationErrors = $userModel->validateUserData($data, true);

        // Ако има грешки при валидация, връща ги
        if (!empty($validationErrors)) {
            return ['errors' => $validationErrors];
        }

        // Подготвя новите стойности, като пази старите, ако няма нова стойност 
        $new_first_name = $user['first_name'];
        if (!empty($data['first_name'])) {
            $new_first_name = htmlentities($data['first_name']);
        }

        $new_last_name = $user['last_name'];
        if (!empty($data['last_name'])) {
            $new_last_name = htmlentities($data['last_name']);
        }

        $new_email = $user['email'];
        if (!empty($data['email'])) {
            $new_email = htmlentities($data['email']);
        }

        $new_password = $user['password'];
        if (!empty($data['password'])) {
            // Проверка дали потребителят е въвел текущата парола
            if (empty($data['current_password']) || !password_verify($data['current_password'], $user['password'])) {
                return ['errors' => ["Incorrect current password."]];
            }
            $new_password = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        try {
            // Връща успех и обновената информация за потребителя
            UserDao::updateUserProfile($username, $new_first_name, $new_last_name, $new_email, $new_password);
            return ['success' => "Profile was successfully updated.", 'user' => UserDao::getUserByUsername($username)];
        } catch (\Exception $e) {
            return ['errors' => ["Error updating profile: " . $e->getMessage()]];
        }
    }
}
