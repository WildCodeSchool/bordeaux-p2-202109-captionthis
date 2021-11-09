<?php

namespace App\Model;

class UrlManager extends AbstractManager
{
    public const TABLE = 'picture';

    public function addPictureForAdmin(string $url): void
    {
        $statement = $this->pdo->prepare('
    INSERT INTO picture (url, created_at) VALUES(:url, NOW())
    ');
        $statement->bindValue(':url', $url, \PDO::PARAM_STR);
        $statement->execute();
    }
}
