<?php

namespace App\Model;

class RankManager extends AbstractManager
{
    public const TABLE = 'legend';

    public function selectLegendByRanking(int $id): array
    {
        $statement = $this->pdo->prepare("
        SELECT *, l.id AS legend_id
       FROM legend l
       RIGHT JOIN user u 
       ON l.user_id = u.id
       WHERE picture_id=:id
       ORDER BY ranking DESC
       LIMIT 1");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();
        if (!$result) {
            $result = [];
        }
        return $result;
    }

    public function updateRankLegend($legendId)
    {
        $statement = $this->pdo->prepare("
        UPDATE legend
        SET ranking = ranking+1
        WHERE id=:id
        ");
        $statement->bindValue(':id', $legendId, \PDO::PARAM_INT);
        $statement->execute();
    }
}
