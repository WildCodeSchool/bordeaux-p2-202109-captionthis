<?php

namespace App\Controller;

use App\Model\LegendManager;
use App\Model\PictureManager;

class HomeController extends AbstractController
{
    public function index():string
    {
        $pictureManager      = new PictureManager();
        $orderByDatePictures = $pictureManager->showPictureByDate();
     //   var_dump($orderByDatePictures);die;
        $randomPictures      = $pictureManager->showPictureRandom();
        //TODO recuperer les images par ranking legends
        $bestRankingPictures = $pictureManager->showPictureRandom();

        return $this->twig->render('Home/index.html.twig', [
            'order_by_date_pictures' => $orderByDatePictures,
            'random_pictures'        => $randomPictures,
            'best_ranking_pictures'  => $bestRankingPictures,
        ]);
    }
}
