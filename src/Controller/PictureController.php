<?php

namespace App\Controller;

use  App\Model\LegendManager;
use  App\Model\PictureManager;

class PictureController extends AbstractController
{
    public function show($id)
    {
        $pictureManager = new PictureManager();
        $picture = $pictureManager -> selectOneById($id);
        $legendManager = new LegendManager();
        $legend = $legendManager-> selectAllByImageId($id);
        return $this->twig->render('Picture/show.html.twig', [
            'picture' => $picture,
            'legends' => $legend,
        ]);
    }
}
