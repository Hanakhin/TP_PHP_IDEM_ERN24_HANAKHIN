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
        $array_result = [];
        $q = sprintf('SELECT * FROM %s',
        $this->getTableName());

        $stmt = $this->pdo->query($q);
        
        if(!$stmt) return $array_result;
        while($result = $stmt->fetch()){
            $array_result[]= new Equipement($result);
        }
        return $array_result;
        
    }

    public function getEquipementById(int $id): ?array
    {   
        $q = sprintf('SELECT * FROM `%s` WHERE `id` = :id',
        $this->getTableName());

        $array_result = [];
        $stmt =$this->pdo->prepare($q);

        if(!$stmt->execute(['id' => $id])) return $array_result ;
    
        while($row_data = $stmt->fetch()){
            $array_result[]= new Equipement($row_data);
        }

        return $array_result;
    }

}