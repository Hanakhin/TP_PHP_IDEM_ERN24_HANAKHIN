<?php

namespace App\Repository;

use App\AppRepoManager;
use App\Model\Reservation;
use Core\Repository\Repository;

class ReservationRepository extends Repository

{

    public function getTableName(): string
    {
        return 'reservation';
    }
    
    public function getAllReservation(): ?array
    {
        $q = sprintf(
            'SELECT * FROM `%s` ',
            $this->getTableName()
        );
        $array_result = [];

        $stmt = $this->pdo->prepare($q);
        if(!$stmt->execute()) return $array_result;
        while($row_data = $stmt->fetch()){
            $reservation = new Reservation($row_data);
            $array_result[] = $reservation;
        }
        return $array_result;
    }
    
    public function getReservationByUser(int $user_id): ?array
    {
        $q = sprintf(
            'SELECT * FROM `%s` WHERE user_id = :user_id',
            $this->getTableName()
        );

        $array_result = [];

        $stmt = $this->pdo->prepare($q);
        if(!$stmt->execute(['user_id' => $user_id])) return $array_result ;
        while($row_data = $stmt->fetch()){
            $reservations = new Reservation($row_data);
            $reservations->user = AppRepoManager::getRm()->getUserRepository()->getUserByReservationId($reservations->user_id);
            $reservations->logement = AppRepoManager::getRm()->getLogementRepository()->getLogementByid($reservations->logement_id);
            $array_result[]=$reservations ;
        }
        return $array_result;
    }

    public function addReservation(array $data): bool
    {
        $q = sprintf(
            'INSERT INTO `%s` (`date_debut`,`date_fin`,`nb_child`,`nb_adult`,`price_total`,`logement_id`,`user_id`)
            VALUES ( :date_debut, :date_fin, :nb_child, :nb_adult, :price_total, :logement_id, :user_id )
        ',
            $this->getTableName()
        );

        $stmt = $this->pdo->prepare($q);
        if (!$stmt) return false;

        $stmt->execute($data);
        return $stmt->rowCount()>0;
    }

    public function deleteReservation(int $id)
    {
        $q = sprintf('DELETE FROM `%s`  WHERE `id` = :id',
        $this->getTableName());
  
        $stmt = $this->pdo->prepare($q);
        if(!$stmt) return false;
        return $stmt->execute(['id'=>$id]);
    }

    public function getReservationPerLogement(int $id)
    {
        $q = sprintf('SELECT * 
        from %s
        WHERE id = :id '
        ,
        $this->getTableName());

        $stmt = $this->pdo->prepare($q);

        if(!$stmt) return null;

        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();

        if (!$result) return null;
        $reservation = new Reservation($result);
        $reservation->user = AppRepoManager::getRm()->getEquipementLogementRepository()->getEquipements($reservation->id);
        return $reservation;
        
    }
}
