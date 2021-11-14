<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\ProfileManager;
use App\Model\UrlManager;
use App\Service\ConnectFormValidator;
use App\Service\FormValidator;
use App\Service\RegisterFormValidator;

class UserController extends AbstractController
{

    public function register(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formValidator = new RegisterFormValidator($_POST);
            $formValidator->trimALL();
            $toCheckInputs = [
                'name'            => 'Le nom',
                'nickname_github' => 'Le pseudo Github',
                'password'        => 'Le mot de passe',
            ];
            $formValidator->checkEmptyInputs($toCheckInputs);
            $formValidator->checkLength($_POST['name'], 'Le nom', 1, 45);
            $formValidator->checkLength($_POST['nickname_github'], 'Le pseudo Github', 1, 45);
            $formValidator->checkLength($_POST['password'], 'Le mot de passe', 6, 100);
            $formValidator->checkIfNameAlreadyExists($_POST['name']);
            $errors = $formValidator->getErrors();
            $posts = $formValidator->getPosts();

            if (count($errors) === 0) {
                $userManager = new UserManager();
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $userId = $userManager->create($_POST);
                $userData = $userManager->selectOneById($userId);
                $_SESSION['user'] = $userData;
                header('Location: /profil?id=' . $userId);
            }
        }
        return $this->twig->render('User/register.html.twig', [
            'register_success' => $_GET['register'] ?? null,
            'errors'           => $errors
        ]);
    }

    public function connect(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formValidator = new ConnectFormValidator($_POST);
            $toCheckInputs = [
                'name' => 'Le nom',
                'password' => 'Le mot de passe',
            ];
            $formValidator->checkEmptyInputs($toCheckInputs);
            $formValidator->checkPassword($_POST['name']);
            $errors = $formValidator->getErrors();
            $posts = $formValidator->getPosts();

            if (count($errors) === 0) {
                $userManager = new UserManager();
                $userData = $userManager->selectOneByName($_POST['name']);
                $_SESSION['user'] = $userData;
                header('Location:/');
            }
        }
        return $this->twig->render('User/connect.html.twig', [
        'session' => $_SESSION,
        'errors'  => $errors
        ]);
    }
    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
    public function profile(int $id): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($errors) === 0) {
                $urlManager = new UrlManager();
                $urlManager-> addPictureForUser($_POST['url']);
            }
        }
        $userManager = new UserManager();
        $userData = $userManager-> selectOneById($id);
        $profileManager = new ProfileManager();
        $userLegends = $profileManager->selectAllLegendsByUser($id);
        return $this->twig->render('User/profile.html.twig', [
            'user_data' => $userData,
            'user_legends' => $userLegends,
            ]);
    }
}
