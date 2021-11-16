<?php

namespace App\Model;

class VoteManager extends AbstractManager
{
    public const TABLE = 'user_legend';
    public function insertVote(int $userId, int $legendId)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO user_legend
            (user_id, legend_id)
            VALUES (:user_id, :legend_id)"
        );
        $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':legend_id', $legendId, \PDO::PARAM_INT);
        $statement->execute();
    }
}
