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

    public function getAllLogement(): ?array
    {
        $array_result = [];

        $q = sprintf('SELECT * from %s
        WHERE `is_active` = 1',
        $this->getTableName()
    );

        $stmt = $this->pdo->prepare($q);
        if(!$stmt->execute()) return $array_result;
        while($row_data = $stmt->fetch()){
            $logement = new Logement($row_data);

            $logement->medias = AppRepoManager::getRm()->getMediaRepository()->getAllMedia($logement->id);
            $logement->adress = AppRepoManager::getRm()->getAdresseRepository()->getAlladresse($logement->adress_id);
            $array_result[] = $logement;
        }
        return $array_result;
    }

    public function getLogementByid(int $id)
    {
        $q = sprintf('SELECT * 
        from %s
        WHERE id = :id 
        AND `is_active` = 1'
        ,
        $this->getTableName());

        $stmt = $this->pdo->prepare($q);

        if(!$stmt) return null;

        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();

        if (!$result) return null;
        $logement = new Logement($result);
        $logement->medias = AppRepoManager::getRm()->getMediaRepository()->getAllMedia($logement->id);
        $logement->adress = AppRepoManager::getRm()->getAdresseRepository()->getAlladresse($logement->adress_id);
        $logement->equipement = AppRepoManager::getRm()->getEquipementLogementRepository()->getEquipements($logement->id);
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
            $logement->adress = AppRepoManager::getRm()->getAdresseRepository()->getAlladresse($logement->adress_id);
            $array_result[]=$logement;
        }

        return $array_result;
    }

    public function getLogementByUser(int $user_id) : array
    {
      $q = sprintf('SELECT * from %s WHERE user_id = :id AND `is_active` = 1',
      $this->getTableName());
        $array_result = [];
        $stmt = $this->pdo->prepare($q);
        if(!$stmt->execute(['id'=>$user_id])) return $array_result;
        while($row_data = $stmt->fetch()){
            $logement = new Logement($row_data);
            $logement->medias = AppRepoManager::getRm()->getMediaRepository()->getAllMedia($logement->id);
            $logement->adress = AppRepoManager::getRm()->getAdresseRepository()->getAlladresse($logement->adress_id);
            $array_result[] = $logement;
        }
        return $array_result;
    }

    public function addLogement(array $data)
    {
          //on fusionne les 2 tableaux
    
          
        $q = sprintf('INSERT INTO %s 
        (title,description,price_per_night,nb_room,nb_bed,nb_bath,nb_traveler,type_id ,is_active,adress_id,user_id)
        VALUES
        (:title,:description,:price_per_night,:nb_room,:nb_bed,:nb_bath,:nb_traveler,:type_id,:is_active,:adress_id,:user_id)',
        $this->getTableName());

        $stmt = $this->pdo->prepare($q);
        if(!$stmt) return null;

        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function deleteLogement(int $id)
    {
        $q = sprintf('UPDATE %s SET `is_active` = 0 WHERE id = :id
        ',$this->getTableName());

        $stmt=$this->pdo->prepare($q);
        if(!$stmt) return false;
        return $stmt->execute(['id'=>$id]);
    }
}