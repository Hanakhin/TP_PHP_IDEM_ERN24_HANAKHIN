<?php

namespace App\Repository;

use App\AppRepoManager;
use App\Model\Logement;
use Core\Repository\Repository;

class LogementRepository extends Repository

{
    public function getTableName(): string
    {
        return 'logement';
    }

    public function getAllLogement():array
    {
        $array_result = [];

        $q = sprintf('SELECT `title`,`description`,`price_per_night`,`nb_room`,`nb_bed`,`nb_bath`,`nb_traveler`,`type`,`is_active`
        FROM %1$s WHERE `is_active` = 1',
        $this->getTableName());

        $stmt = $this->pdo->query($q);
        if(!$stmt) return $array_result;
        while($row_data = $stmt->fetch())
        {
            $array_result[] = new Logement($row_data);
        }
        return $array_result;
    }

    public function getLogementByid(int $logement_id)
    {
        $q = sprintf('SELECT * FROM %s WHERE `id` = :id AND `is_active` = 1',
        $this->getTableName());

        $stmt = $this->pdo->prepare($q);

        if(!$stmt) return null;

        $stmt->execute(['id' => $logement_id]);

        $result = $stmt->fetch();

        $logement = new Logement($result);

        return $logement;
    }

    public function getLogementByTypeId(int $type_id) : ?array
    {

        $array_result = [];

        $q = sprintf('SELECT * FROM %s WHERE `type_id` = :type_id AND `is_active` = 1 ORDER BY `price_per_night` ASC',
        $this->getTableName());

        $stmt =$this->pdo->prepare($q);

        if(!$stmt->execute(['type_id' => $type_id])) return $array_result ;
        
        while($row_data = $stmt->fetch()){
            $logement = new Logement($row_data);
            $array_result[]=$logement;
        }

        return $array_result;
    }
}