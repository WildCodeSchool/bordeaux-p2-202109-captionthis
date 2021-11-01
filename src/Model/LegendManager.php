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
}
