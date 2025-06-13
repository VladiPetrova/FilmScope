<?php

namespace Controller;

use Model\Profile;

class ProfileController {

    public function changeProfile() {

        if (!isset($_SESSION['user'])) {
            header("Location: ?target=user&action=login");
            die();
        }

        $errors = [];
        $success = "";
        $username = $_SESSION['user'];

        $model = new Profile;

        // Вземаме данните за текущия потребител от базата
        $user = $model->getUserByUsername($username);

        // Ако е изпратена форма за записване на промените
        if (isset($_POST["save_changes"])) {
            $result = $model->updateProfile($username, $_POST);

            // Ако има грешки, ги записваме в масива errors
            if (!empty($result['errors'])) {
                $errors = $result['errors'];
            }

            // Ако има успешно съобщение, го записваме в success
            if (!empty($result['success'])) {
                $success = $result['success'];
            }

            // Ако е върнат обновен потребител, обновяваме $user с него
            if (!empty($result['user'])) {
                $user = $result['user'];
            }
        }

        require_once 'View/user/settings.php';
    }
}
