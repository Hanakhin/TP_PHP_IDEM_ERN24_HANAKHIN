<?php

namespace   App\Repository;

use App\AppRepoManager;
use App\Model\Equipement;
use Core\Repository\Repository;

class LogementEquipementRepository extends Repository
{

    public function getTableName(): string
    {
        return 'logementEquipement';
    }

    public function getEquipements($id): array
    {
      //on declare un tableau vide
      $array_result = [];
      $q = sprintf(
        '  SELECT e.id, e.label, e.image_path FROM equipement as e
        INNER JOIN `logementEquipement`  as le ON e.id = le.equipement_id
        WHERE le.logement_id = :logement_id
  ',
        $this->getTableName(), //correspond au %1$s
        AppRepoManager::getRm()->getEquipementRepository()->getTableName() //correspond au %2$s
      );
      //on prepare la requete
      $stmt = $this->pdo->prepare($q);
   
      if (!$stmt) return $array_result;
   
      $stmt->execute(['logement_id' =>$id]);
   
      while ($data = $stmt->fetch()) {
          $array_result[] = $data;
      }
      //on retourne le tableau
      return $array_result ;
    }

    public function insertEquipement(array $data): bool
    {

      $q = sprintf('INSERT INTO %s (equipement_id,logement_id)
      VALUES(:equipement_id,:logement_id)',
      $this->getTableName());

      $stmt = $this->pdo->prepare($q);
      if(!$stmt) return false ;

      $stmt->execute($data);
      return $stmt->rowCount()>0;
    }

    
}