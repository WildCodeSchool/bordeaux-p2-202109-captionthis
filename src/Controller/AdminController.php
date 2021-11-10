<?php

namespace App\Controller;

use App\Model\ItemManager;
use App\Model\LegendManager;
use App\Model\PictureManager;

class AdminController extends AbstractController
{
    public function showLegendForAdmin()
    {
        $legendManager = new LegendManager();
        $legends = $legendManager->selectAllWithName();

        return $this->twig->render('admin/admin.html.twig', [
            'legendManager' => $legends,
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
}
