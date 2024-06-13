<?php

namespace App\Repository;

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

        $q = sprintf('SELECT l.`title`, l.`description`,l.`price_per_night`,l.`nb_room`,l.`nb_bed`,l.`nb_bath`,l.`nb_traveler`l.`type`,l.`is_active`
        FROM %1$s AS l WHERE `is_active` = 1',
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

    }

    public function GetLogementByTypeId(int $type_id)
    {
        $q = sprintf('SELECT * FROM %s WHERE `type_id` = :type_id AND `is_active` = 1',
        $this->getTableName());

        $stmt =$this->pdo->prepare($q);

        if(!$stmt) return null;

        $stmt->execute(['type_id' => $type_id]);

        $result = $stmt->fetch();

        $logement = new Logement($result);
    }

}