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
       JOIN user u 
       ON l.user_id = u.id
       WHERE picture_id=:id
       ORDER BY ranking DESC
       LIMIT 1");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public function insertRank(array $ranking): int
    {
        $statement = $this->pdo->prepare("
        INSERT INTO legend (ranking) 
        VALUES (:ranking)");
        $statement->bindValue('ranking', $ranking['ranking'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
