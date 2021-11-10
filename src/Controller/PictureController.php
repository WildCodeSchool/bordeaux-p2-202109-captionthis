<?php

namespace App\Controller;

use App\Model\ItemManager;
use  App\Model\LegendManager;
use  App\Model\PictureManager;
use App\Model\RankManager;
use http\Header;

class PictureController extends AbstractController
{
    public function show(int $pictureId)
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $legend = ($_POST['inputLegend']);

            if (empty($legend)) {
                $errors['legend'] = 'Merci de commenter ta légende avant de valider';
            }
            if (strlen($legend) > 80) {
                $errors['legend'] = 'Merci de faire une légende courte (80 caractères max)';
            }
            if (count($errors) === 0) {
                $legendManager = new LegendManager();
                $userId = $_SESSION['user']['id'];
                $legendManager->create($_POST, $pictureId, $userId);
            }
        }
        $pictureManager = new PictureManager();
        $picture = $pictureManager->selectOneById($pictureId);
        $legendManager = new LegendManager();
        $legends = $legendManager->selectAllByImageId($pictureId);
        $rankManager = new RankManager();
        $bestRankingLegend = $rankManager->selectLegendByRanking($pictureId);
        return $this->twig->render('Picture/show.html.twig', [
            'picture' => $picture,
            'legends' => $legends,
            'bestRankingLegend' => $bestRankingLegend,
            'errors' => $errors
        ]);
    }

    public function addRank($legendId, $pictureId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rankManager = new RankManager();
            $rankManager->updateRankLegend($legendId);
            header('Location:/image?id=' . $pictureId);
        }
    }
}
