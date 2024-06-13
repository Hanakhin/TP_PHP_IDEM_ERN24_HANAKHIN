<?php 

namespace App\Repository;

use App\Model\Reservation;
use Core\Repository\Repository;

class ReservationRepository extends Repository

{
    
    public function getTableName(): string
    {
        return 'reservation';
    }

    public function getAllReservation():array
    {   
        $q = sprintf('SELECT * FROM `%s`',
        $this->getTableName());

        $array_result = [];
        $stmt = $this->pdo->query($q);
        if(!$stmt) return $array_result;
        while($row_data = $stmt->fetch())
        {
            $array_result[] = new Reservation($row_data);
        }
        return $array_result;
    }
}