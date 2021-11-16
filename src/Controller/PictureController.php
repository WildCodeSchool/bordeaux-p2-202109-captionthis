<?php

namespace App\Controller;

use  App\Model\LegendManager;
use  App\Model\PictureManager;
use App\Model\RankManager;
use App\Model\UserManager;
use App\Model\VoteManager;
use App\Service\FormValidator;

class PictureController extends AbstractController
{
    public function show(int $pictureId)
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formValidator = new FormValidator($_POST);
            $formValidator->trimALL();
            $toCheckInputs = [
                'inputLegend' => 'La légende ',
            ];
            $formValidator->checkEmptyInputs($toCheckInputs);
            $formValidator->checkLength($_POST['inputLegend'], 'La légende', 1, 80);
            $errors = $formValidator->getErrors();
            $posts = $formValidator->getPosts();
            if (count($errors) === 0) {
                $legendManager = new LegendManager();
                $userId = $_SESSION['user']['id'];
                $legendManager->create($posts, $pictureId, $userId);
            }
        }
        $pictureManager = new PictureManager();
        $picture = $pictureManager->selectOneById($pictureId);
        $legendManager = new LegendManager();
        $legends = $legendManager->selectAllByImageId($pictureId);
        $userManager = new UserManager();
        foreach ($legends as &$legend) {
            $votants = $userManager->selectUserIdByLegendId($legend['legend_id']);
            $legend['isAbleToVote'] = !in_array($_SESSION['user']['id'], $votants);
        }
        $rankManager = new RankManager();
        $bestRankingLegend = $rankManager->selectLegendByRanking($pictureId);
        return $this->twig->render('Picture/show.html.twig', [
            'picture' => $picture,
            'legends' => $legends,
            'best_ranking_legend' => $bestRankingLegend,
            'errors' => $errors,

        ]);
    }

    public function manageRanking($legendId, $pictureId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rankManager = new RankManager();
            $rankManager->updateRankLegend($legendId);
            $voteManager = new VoteManager();
            $voteManager->insertVote($_SESSION['user']['id'], $legendId);
            header('Location:/image?id=' . $pictureId);
        }
    }
}
