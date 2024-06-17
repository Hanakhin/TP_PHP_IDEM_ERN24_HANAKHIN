<?php

namespace App\Repository;

use App\App;
use App\AppRepoManager;
use App\Model\Logement;
use Core\Repository\Repository;

class LogementRepository extends Repository

{
    public function getTableName(): string
    {
        return 'logement';
    }

    public function getAllLogement(): ? array
    {
        $array_result = [];

        $q = sprintf('SELECT 
        *
        FROM %s 
        WHERE is_active = 1 ORDER BY price_per_night ASC',
        $this->getTableName()
    );

        $stmt = $this->pdo->prepare($q);
        if(!$stmt->execute()) return $array_result;
        while($row_data = $stmt->fetch()){
            $logement = new Logement($row_data);
            $logement->medias = AppRepoManager::getRm()->getMediaRepository()->getAllMedia($logement->id);
            $array_result[] = $logement;
        }
        return $array_result;
    }

    public function getLogementByid(int $id)
    {
        $q = sprintf('SELECT * FROM %s WHERE `id` = :id',
        $this->getTableName());

        $stmt = $this->pdo->prepare($q);

        if(!$stmt) return null;

        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();

        if (!$result) return null;
        $logement = new Logement($result);
        $logement->medias = AppRepoManager::getRm()->getMediaRepository()->getAllMedia($logement->id);
        return $logement;
    }

    public function getLogementByTypeId(int $type_id) : ?array
    {

        $array_result = [];

        $q = sprintf('SELECT * FROM %s 
        WHERE `type_id` = :type_id 
        AND `is_active` = 1 
        ORDER BY `price_per_night` ASC',
        $this->getTableName());

        $stmt =$this->pdo->prepare($q);

        if(!$stmt->execute(['type_id' => $type_id])) return $array_result ;
        
        while($row_data = $stmt->fetch()){
            $logement = new Logement($row_data);
            $logement->medias = AppRepoManager::getRm()->getMediaRepository()->getAllMedia($logement->id);
            $array_result[]=$logement;
        }

        return $array_result;
    }


}