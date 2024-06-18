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

    public function getAlladresse($id): ?object
    {   
        $q = sprintf('SELECT * FROM `%s` WHERE `id` = :adress_id',
        $this->getTableName());

        $stmt = $this->pdo->prepare($q);
        $stmt->execute(['adress_id' => $id]);
        if(!$stmt) return null;
        
        $result = $stmt->fetch();
        return new Adresse($result);

    }

    public function insertAdress( array $data) 
    {
        $q = sprintf('INSERT INTO %s (`adress`,`city`,`country`,`zip_code`)
        VALUES (:adress,:city,:country,:zip_code)',
        $this->getTableName()
    );
    $stmt = $this->pdo->prepare($q);
    if(!$stmt) return null;
    $stmt->execute($data);

    

    return $this->pdo->lastInsertId();

    }

}
