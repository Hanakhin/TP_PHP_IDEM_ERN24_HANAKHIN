<?php

namespace App\Repository;

use App\Model\User;
use App\AppRepoManager;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Form\FormSuccess;
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

        $q = sprintf('SELECT `email`, `lastname`,`firstname`,`phone`
        FROM %s
        WHERE `is_active` = 1',
        $this->getTableName());

        $stmt = $this->pdo->query($q);
        if(!$stmt) return $array_result;
        while($row_data = $stmt->fetch())
        {
            $array_result[] = new User($row_data);
        }
        return $array_result;
    }

    public function findUserByEmail(string $email): ?User
    {
      //on crée notre requete SQL
      $q = sprintf('SELECT * FROM %s WHERE email = :email', $this->getTableName());
      //on prépare la requete
      $stmt = $this->pdo->prepare($q);
      //on vérifie que la requete est bien bien préparée
      if (!$stmt) return null;
      //si tout est bon, on bind les valeurs
      $stmt->execute(['email' => $email]);
      while ($result = $stmt->fetch()) {
        $user = new User($result);
      }
      return $user ?? null;
    }


    public function addUser(array $data): ?User
    {
        $data_more = [
            'is_admin' => 0,
            'is_active'=>1
          ];
          //on fusionne les 2 tableaux
          $data = array_merge($data, $data_more);
      
          //on crée la requete SQL
          $query = sprintf(
            'INSERT INTO %s (`email`, `password`, `firstname`, `lastname`, `phone`, `is_admin`,`is_active`) 
            VALUES (:email, :password, :firstname, :lastname, :phone, :is_admin,:is_active)',
            $this->getTableName()
          );
          //on prépare la requete
          $stmt = $this->pdo->prepare($query);
          //on vérifie que la requete est bien préparée
          if (!$stmt) return null;
          //on execute en passant les valeurs
          $stmt->execute($data);
      
          //on récupère l'id de l'utilisateur fraichement créée
          $id = $this->pdo->lastInsertId();
          //on peut retourner l'objet User grace à son id
          return $this->readById(User::class, $id);
    }

    public function getUserProfil(int $id)
    {
      $q = sprintf('SELECT * FROM %s WHERE `id` = :id',$this->getTableName());
      $stmt = $this->pdo->prepare($q);
      if(!$stmt) return null;
      $stmt->execute(['id' => $id]);
      while ($result = $stmt->fetch()) {
        $user = new User($result);
      }
      return $user ?? null;
    }

    public function deleteUser(int $id):bool
    {
      $q = sprintf('DELETE FROM `user` WHERE `id` = :id',
      $this->getTableName());

      $stmt = $this->pdo->prepare($q);
      if(!$stmt) return false;
      return $stmt->execute(['id'=>$id]);
    }
}