<?php

namespace App\Model;

class RankManager extends AbstractManager
{
    public const TABLE = 'legend';
    public function selectLegendByRanking(int $id)
    {
        $statement = $this->pdo->prepare("
        SELECT *, l.id AS legend_id
       FROM legend l
       JOIN user u 
       ON l.user_id = u.id
       WHERE picture_id=:id
       ORDER BY ranking DESC
       LIMIT 1");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }
}
