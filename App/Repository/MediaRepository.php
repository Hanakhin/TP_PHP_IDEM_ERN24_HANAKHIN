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

    public function insertMedia(array $data)
    {
      $q = sprintf('INSERT INTO %s (image_path,logement_id)
      VALUES(:image_path,:logement_id)',
      $this->getTableName());

      $stmt = $this->pdo->prepare($q);
      if(!$stmt) return null ;

      $stmt->execute($data);
      return $this->pdo->lastInsertId();
    }

}