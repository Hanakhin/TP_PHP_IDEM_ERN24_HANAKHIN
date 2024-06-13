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

    public function getAllMedia():array
    {   
        $q = sprintf('SELECT * FROM `%s`',
        $this->getTableName());

        $array_result = [];
        $stmt = $this->pdo->query($q);
        if(!$stmt) return $array_result;
        while($row_data = $stmt->fetch())
        {
            $array_result[] = new Media($row_data);
        }
        return $array_result;
    }
}