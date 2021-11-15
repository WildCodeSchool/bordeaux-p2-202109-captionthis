<?php

namespace App\Model;

class UrlManager extends AbstractManager
{
    public const TABLE = 'picture';

    public function addPictureForAdmin(string $url): void
    {
        $statement = $this->pdo->prepare('
    INSERT INTO picture (url, created_at, is_validate) VALUES(:url, NOW(), 1)
    ');
        $statement->bindValue(':url', $url, \PDO::PARAM_STR);
        $statement->execute();
    }
    public function addPictureForUser(string $url): void
    {
        $statement = $this->pdo->prepare('
    INSERT INTO picture (url, created_at, is_validate) VALUES(:url, NOW(), 0)
    ');
        $statement->bindValue(':url', $url, \PDO::PARAM_STR);
        $statement->execute();
    }
}
