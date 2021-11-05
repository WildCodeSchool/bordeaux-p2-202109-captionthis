<?php

namespace App\Model;

use http\QueryString;

class PictureManager extends AbstractManager
{
    public const TABLE = "picture";

// Methode pour afficher sur le carrousel de l'accueil les dernières photos ajoutées
    public function showPictureByDate(): array
    {
        $statement = $this->pdo->query("
        SELECT * 
        FROM picture 
        ORDER BY created_at DESC
        LIMIT 12");
        return $statement->fetchAll();
    }
// Methode pour afficher sur le carrousel de l'accueil les photos en random
    public function showPictureRandom()
    {
        $statement = $this->pdo->query("
        SELECT *
        FROM picture
        ORDER BY rand()
        LIMIT 12;");
        $statement->execute();
        return $statement->fetchAll();
    }

// Methode pour afficher sur le carrousel de l'accueil les photos ayant reçu le plus grand nb de votes
    public function bestRankingPicture()
    {
        $statement = $this->pdo->prepare(" 
        SELECT SUM(l.ranking) 
        as rankingSum, l.id 
        as legendId, l.content, l.ranking, p.id
        as pictureId, p.url
        FROM legend l
        JOIN picture p 
        ON l.picture_id=p.id
        GROUP BY p.id
        ORDER BY rankingSum
        DESC
        LIMIT 12;");
        $statement->execute();
        return $statement->fetchAll();
    }
}
