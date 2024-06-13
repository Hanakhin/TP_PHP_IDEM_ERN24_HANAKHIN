<?php 

namespace App\Repository;

use App\Model\Type;
use Core\Repository\Repository;

class TypeRepository extends Repository

{
    
    public function getTableName(): string
    {
        return 'type';
    }

    public function getAllType():array
    {   
        $q = sprintf('SELECT * FROM `%s`',
        $this->getTableName());

        $array_result = [];
        $stmt = $this->pdo->query($q);
        if(!$stmt) return $array_result;
        while($row_data = $stmt->fetch())
        {
            $array_result[] = new Type($row_data);
        }
        return $array_result;
    }
}