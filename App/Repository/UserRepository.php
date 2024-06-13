<?php

namespace App\Repository;

use App\Model\User;
use Core\Repository\Repository;

class UserRepository extends Repository

{
    public function getTableName(): string
    {
        return 'user';
    }

    public function getAllUser():array
    {
        $array_result = [];

        $q = sprintf('SELECT u.`email`, u.`lastname`,u.`firstname`,u.`phone`
        FROM %1$s AS l',
        $this->getTableName());

        $stmt = $this->pdo->query($q);
        if(!$stmt) return $array_result;
        while($row_data = $stmt->fetch())
        {
            $array_result[] = new User($row_data);
        }
        return $array_result;
    }

}