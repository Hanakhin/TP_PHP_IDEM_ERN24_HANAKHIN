<?php 

namespace App\Repository;

use App\Model\Equipement;
use Core\Repository\Repository;

class EquipementRepository extends Repository

{
    
    public function getTableName(): string
    {
        return 'equipement';
    }

    public function getAllEquipement():array
    {   
        $q = sprintf('SELECT * FROM `%s`',
        $this->getTableName());

        $array_result = [];
        $stmt = $this->pdo->query($q);
        if(!$stmt) return $array_result;
        while($row_data = $stmt->fetch())
        {
            $array_result[] = new Equipement($row_data);
        }
        return $array_result;
    }
}