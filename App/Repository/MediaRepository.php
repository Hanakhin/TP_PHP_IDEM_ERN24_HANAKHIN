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

    public function getAllMedia(int $id):array
    {   
        $array_result = [];
        $q = sprintf('SELECT * FROM %s WHERE logement_id = :id',
        $this->getTableName());

        $stmt = $this->pdo->prepare($q);
        $stmt->execute(['id'=>$id]);

        if(!$stmt) return $array_result;
        
        while($result = $stmt->fetch()){
            $array_result[]= new Media($result);
        }
        return $array_result;
        
    }

    public function insertMedia(array $data): bool
    {
      $q = sprintf('INSERT INTO %s (image_path,logement_id)
      VALUES(:image_path,:logement_id)',
      $this->getTableName());

      $stmt = $this->pdo->prepare($q);
      if(!$stmt) return false ;

      return $stmt->execute($data);
      
    }

}