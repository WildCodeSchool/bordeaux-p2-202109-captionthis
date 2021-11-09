<?php

namespace App\Controller;

use App\Model\LegendManager;
use App\Model\PictureManager;
use App\Model\UrlManager;

class AdminController extends AbstractController
{
    public function showLegendForAdmin()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($errors) === 0) {
                $urlManager = new UrlManager();
                $urlManager->addPictureForAdmin($_POST['url']);
            }
        }
        $legendManager = new LegendManager();
        $legendManager = $legendManager->selectAllWithName();

        return $this->twig->render('admin/admin.html.twig', [
        'legendManager' => $legendManager,
        ]);
    }
}
