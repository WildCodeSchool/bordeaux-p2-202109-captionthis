<?php

namespace App\Controller;

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
    public function deleteOneLegend()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $delete = $_POST['delete'];
            $legendManager = new legendManager();
            $legendManager->deleteOneLegend($delete);
            header('Location:/admin');
        }
    }
}
