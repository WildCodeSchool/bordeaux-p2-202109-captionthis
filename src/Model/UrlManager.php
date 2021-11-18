<?php

namespace App\Model;

use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;

class UrlManager extends AbstractManager
{
    public const TABLE = 'picture';

    public function addPictureForAdmin(string $url, int $userId)
    {
        $statement = $this->pdo->prepare('
    INSERT INTO picture (url, created_at, is_validate, user_id) VALUES(:url, NOW(), 1, :user_id)
    ');
        $statement->bindValue(':url', $url, \PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
    }
    public function addPictureForUser(string $url, int $userId)
    {
        $statement = $this->pdo->prepare('
    INSERT INTO picture (url, created_at, is_validate, user_id) VALUES(:url, NOW(), 0, :user_id)
    ');
        $statement->bindValue(':url', $url, \PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
    }
    public function selectPictures()
    {
        $statement = $this->pdo->prepare("
        SELECT p.url, p.created_at, p.is_validate, u.name, p.id FROM caption_this.picture p
        JOIN user u ON p.user_id = u.id
        ORDER BY created_at DESC
        ");
        $statement->execute();
        return $statement->fetchAll();
    }
    public function setPictureToZero(array $picture)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `is_validate` = 0  WHERE id=:id");
        $statement->bindValue('id', $picture ['id'], \PDO::PARAM_INT);
        $statement->execute();
    }
    public function updatePicture(array $picture)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `url` = :url WHERE id=:id");
        $statement->bindValue('id', $picture['id'], \PDO::PARAM_INT);
        $statement->bindValue('url', $picture['url'], \PDO::PARAM_STR);
        $statement->execute();
    }
    public function validatePicture(array $picture)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `is_validate` = 1 WHERE id=:id");
        $statement->bindValue('id', $picture['id'], \PDO::PARAM_INT);
        $statement->execute();
    }
}
