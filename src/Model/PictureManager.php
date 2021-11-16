<?php

namespace App\Model;

class PictureManager extends AbstractManager
{
    public const TABLE = "picture";

    public function showPictureByDate(): array
    {
        $statement = $this->pdo->query("
        SELECT * 
        FROM picture 
        ORDER BY created_at DESC
        LIMIT 12");
        return $statement->fetchAll();
    }
    public function showPictureRandom(): array
    {
        $statement = $this->pdo->query("
        SELECT *
        FROM picture
        ORDER BY rand();
        ");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function bestRankingPicture(): array
    {
        $this->pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $statement = $this->pdo->prepare(" 
        SELECT SUM(l.ranking) 
        as rankingSum, l.id
        as legendId, l.content, l.ranking, p.id, p.url
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
