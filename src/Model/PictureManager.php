<?php

namespace App\Model;

use http\QueryString;

class PictureManager extends AbstractManager
{
    public const TABLE = "picture";

// Methode pour afficher sur le carrousel de l'accueil les dernières photos ajoutées
    public function showPictureByDate(string $date): array
    {
        $statement = $this->pdo->prepare("
        SELECT * 
        FROM picture 
        ORDER BY created_at DESC
        LIMIT 12");
        $statement->bindValue('date', $date, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
