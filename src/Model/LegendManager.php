<?php

namespace App\Model;

class LegendManager extends AbstractManager
{
    public const TABLE = 'legend';

    public function selectAllByImageId(int $id): array
    {
        $statement = $this->pdo->prepare(" 
       SELECT *, l.id AS legend_id
       FROM legend l
       JOIN user u 
       ON l.user_id = u.id
       WHERE picture_id=:id
       ORDER BY ranking DESC");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

// Methode pour afficher sur le carrousel de l'accueil les photos ayant reçu le plus grand nb de votes
    public function showPictureById(int $id)
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
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
