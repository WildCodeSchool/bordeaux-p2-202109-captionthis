<?php

namespace App\Controller;

use App\Model\LegendManager;
use App\Model\PictureManager;

class AdminController extends AbstractController
{
    public function showLegendForAdmin()
    {
        $legendManager = new LegendManager();
        $legendManager = $legendManager->selectAllWithName();

        return $this->twig->render('admin/admin.html.twig', [
            'legendManager' => $legendManager,
        ]);
    }
}
