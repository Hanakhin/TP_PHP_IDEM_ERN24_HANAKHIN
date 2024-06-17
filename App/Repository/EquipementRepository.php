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

    public function getAllEquipement($id):?object
    {   
        $q = sprintf('SELECT * FROM %1$s',
        $this->getTableName());

        $stmt = $this->pdo->query($q);
        if(!$stmt) return null;
        $result = $stmt->fetch();
        return new Equipement($result);
        
    }

}