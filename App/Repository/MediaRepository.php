<?php 

namespace App\Repository;

use App\Model\Media;
use Core\Repository\Repository;

class MediaRepository extends Repository

{
    
    public function getTableName(): string
    {
        return 'media';
    }

    public function getAllMedia($id): ?object
    {   
        $q = sprintf('SELECT * FROM `%s` WHERE `id` = :logement_id',
        $this->getTableName());

        $stmt = $this->pdo->prepare($q);
        $stmt->execute(['logement_id' => $id]);
        if(!$stmt) return null;
        
        $result = $stmt->fetch();
        return new Media($result);
    }


}