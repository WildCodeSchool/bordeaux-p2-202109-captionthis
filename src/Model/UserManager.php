<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function create(array $userData): string
    {
        // prepared request
        $statement = $this->pdo->prepare('
            INSERT INTO user (name, password, created_at, nickname_github, is_admin)
            VALUES(:name, :password, NOW(), :nickname_github, false)
            ');
        $statement->bindValue(':name', $userData['name'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $userData['password'], \PDO::PARAM_STR);
        $statement->bindValue(':nickname_github', $userData['nickname_github'], \PDO::PARAM_STR);
        $statement->execute();
        return $this->pdo->lastInsertId();
    }
    public function selectOneByName(string $name)
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . self::TABLE . ' WHERE name=:name');
        $statement->bindValue(':name', $name, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
