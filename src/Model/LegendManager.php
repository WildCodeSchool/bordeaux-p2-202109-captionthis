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
    public function create(array $legendData, $pictureId, $userId): void
    {
        $statement = $this->pdo->prepare("
        INSERT INTO legend (content, created_at, user_id, picture_id, ranking) 
        VALUES (:content, NOW(), :userId, :pictureId, 0 )");
        $statement->bindValue(':content', $legendData['inputLegend'], \PDO::PARAM_STR);
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':pictureId', $pictureId, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function selectAllWithName()
    {
        $statement = $this->pdo->prepare("
        SELECT l.id, l.content, u.name, u.nickname_github FROM legend l
        JOIN user u
        ON l.user_id = u.id
        ORDER BY l.created_at DESC
        ");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function deleteOneLegend(int $id)
    {
        $statement = $this->pdo->prepare("DELETE legend FROM caption_this.legend WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
