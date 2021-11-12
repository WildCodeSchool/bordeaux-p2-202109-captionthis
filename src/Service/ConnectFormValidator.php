<?php

namespace App\Service;

use App\Model\UserManager;

class ConnectFormValidator extends FormValidator
{
    public function checkPassword(string $name): void
    {
        $userManager = new UserManager();
        $userData = $userManager->selectOnebyName($name);
        if ($_POST['name'] === '' || !password_verify($_POST['password'], $userData['password'])) {
            $this->errors[] = 'échec de la connexion';
        }
    }
}
