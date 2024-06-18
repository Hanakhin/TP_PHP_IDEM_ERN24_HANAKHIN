<?php 


namespace App\Model;

use Core\Model\Model;

class Adresse extends Model
{
    public string $adress;
    public string $zip_code;
    public string $city;
    public string $country;
    
}