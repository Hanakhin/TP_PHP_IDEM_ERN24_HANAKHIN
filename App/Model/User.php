<?php 


namespace App\Model;

use Core\Model\Model;

class User extends Model
{   
    public string $email;
    public string $password;
    public string $firstname;
    public string $lastname;
    public string $phone;
    public bool $is_admin;
    public ?int $adress_id;

}