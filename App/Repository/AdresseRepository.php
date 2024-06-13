<?php 

namespace App\Repository;

use App\Model\Adresse;
use Core\Repository\Repository;

class AdresseRepository extends Repository

{
    
    public function getTableName(): string
    {
        return 'adresse';
    }

    public function getAllAdresse():array
    {   
        $q = sprintf('SELECT * FROM `%s`',
        $this->getTableName());

        $array_result = [];
        $stmt = $this->pdo->query($q);
        if(!$stmt) return $array_result;
        while($row_data = $stmt->fetch())
        {
            $array_result[] = new Adresse($row_data);
        }
        return $array_result;
    }
}