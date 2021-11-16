<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function create(array $userData): int
    {
        $statement = $this->pdo->prepare('
            INSERT INTO user (name, password, created_at, nickname_github, is_admin)
            VALUES(:name, :password, NOW(), :nickname_github, false)
            ');
        $statement->bindValue(':name', $userData['name'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $userData['password'], \PDO::PARAM_STR);
        $statement->bindValue(':nickname_github', $userData['nickname_github'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    public function selectOneByName(string $name): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . self::TABLE . ' WHERE name=:name');
        $statement->bindValue(':name', $name, \PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch();
        if (!$result) {
            $result = [];
        }
        return $result;
    }

    public function selectUserIdBylegendId(int $legendId)
    {
        $statement=$this->pdo->prepare("
        SELECT user_id
        FROM user_legend
        WHERE legend_id = :legend_id");
        $statement->bindValue('legend_id', $legendId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
}
