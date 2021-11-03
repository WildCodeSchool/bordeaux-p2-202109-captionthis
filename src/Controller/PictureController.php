<?php

namespace App\Controller;

use  App\Model\LegendManager;
use  App\Model\PictureManager;
use App\Model\RankManager;

class PictureController extends AbstractController
{
    public function show($id)
    {
        $pictureManager = new PictureManager();
        $picture = $pictureManager->selectOneById($id);
        $legendManager = new LegendManager();
        $legend = $legendManager->selectAllByImageId($id);
        $rankManager = new RankManager();
        $rank = $rankManager->selectLegendByRanking($id);
        return $this->twig->render('Picture/show.html.twig', [
            'picture' => $picture,
            'legends' => $legend,
            'ranks'   => $rank,
        ]);
    }
}
