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
    public function selectPictures()
    {
        $statement = $this->pdo->prepare("
        SELECT name, url, p.created_at, is_validate, p.id, l.picture_id, u.id FROM picture p
        JOIN legend l ON l.picture_id = p.id
        JOIN user u ON l.user_id = u.id
        WHERE is_validate = 0
        ORDER BY created_at DESC ;
        ");
        $statement->execute();
        return $statement->fetchAll();
    }
}
