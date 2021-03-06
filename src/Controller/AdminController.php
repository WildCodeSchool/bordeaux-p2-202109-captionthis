<?php

namespace App\Controller;

use App\Model\ItemManager;
use App\Model\LegendManager;
use App\Model\PictureManager;
use App\Model\UrlManager;
use App\Service\FormValidator;

class AdminController extends AbstractController
{
    public function showLegendForAdmin()
    {
        if (empty($_SESSION)) {
            header('HTTP/1.0 404 Not Found');
            echo '404 - Page not found';
            return ;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formValidator = new FormValidator($_POST);
            $formValidator->trimALL();
            $toCheckInputs = [
                'url'   => 'L\'url',
            ];
            $formValidator->checkEmptyInputs($toCheckInputs);
            $errors = $formValidator->getErrors();
            if (count($errors) === 0) {
                $urlManager = new UrlManager();
                $urlManager->addPictureForAdmin($_POST['url'], $_SESSION['user']['id']);
            }
        }

        $legendManager = new LegendManager();
        $legends = $legendManager->selectAllWithName();
        $urlManager = new UrlManager();
        $pictures = $urlManager->selectPictures();
        return $this->twig->render('admin/admin.html.twig', [
            'legend_manager' => $legends,
            'pictures'      => $pictures,
            'errors'           => $errors,
        ]);
    }

    public function deleteLegend()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $delete = $_POST['delete'];
            $legendManager = new legendManager();
            $legendManager->deleteLegend($delete);
            header('Location:/admin');
        }
    }

    public function updateLegend()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $legend = $_POST;
            $legendManager = new legendManager();
            $legendManager->update($legend);
            header('Location: /admin');
        }
    }
    public function setPictureToZero()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $picture = $_POST;
            $urlManager = new UrlManager();
            $urlManager-> setPictureToZero($picture);
            header('Location:/admin');
        }
    }
    public function updatePicture()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $picture = $_POST;
            $urlManager = new UrlManager();
            $urlManager->updatePicture($picture);
            header('Location: /admin');
        }
    }
    public function validatePicture()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $picture = $_POST;
            $urlManager = new UrlManager();
            $urlManager-> validatePicture($picture);
            header('location: /admin');
        }
    }
}
