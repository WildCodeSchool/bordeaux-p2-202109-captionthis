<?php

namespace App\Model;

class ProfileManager extends AbstractManager
{
    public const TABLE = 'legend';

    // Methode pour afficher sur la page de profil les légendes que l'utilisateur a postées
    public function selectAllLegendsByUser(int $id): array
    {
        $statement = $this->pdo->prepare('
        SELECT * FROM legend
        JOIN user ON legend.user_id = user.id
        JOIN picture ON legend.picture_id = picture.id
         WHERE user.id =:id
         ORDER BY ranking DESC');
        $statement->bindValue(':id', $id, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
