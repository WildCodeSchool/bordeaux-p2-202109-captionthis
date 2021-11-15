<?php

namespace App\Service;

use App\Model\UserManager;

class RegisterFormValidator extends FormValidator
{
    public function checkIfNameAlreadyExists(string $name): void
    {
        $userManager = new UserManager();
        $userData = $userManager->selectOneByName($name);
        if ($userData) {
            $this->errors[] = 'Le nom ' . $name . ' est déjà utilisé';
        }
    }
}
