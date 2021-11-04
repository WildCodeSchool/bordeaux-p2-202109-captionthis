<?php

namespace App\Controller;

use App\Model\LegendManager;
use App\Model\PictureManager;

class HomeController extends AbstractController
{
// Methode pour afficher sur le carrousel de l'accueil les dernières photos ajoutées
    public function showLastPictures(string $date)
    {
        $pictureManager = new PictureManager();
        $date = $pictureManager->showPictureByDate($date);

        return $this->twig->render('Home/index.html.twig', [
            'date' => $date,
            //'randomPictures'=>$randomPictures
        ]);
    }
// Methode pour afficher sur le carrousel de l'accueil les photos ayant reçu le plus grand nb de votes
    public function showPictureById(int $id)
    {
        $legendManager = new LegendManager();
        $bestLegends = $legendManager->showPictureById($id);
        return $this->twig->render('Home/index.html.twig', [
            'bestLegends' => $bestLegends,
        ]);
    }


}
