<?php 


namespace App\Model;

use Core\Model\Model;

class Logement extends Model
{   
    public int $id;
    public string $title;
    public string $description;
    public float $price_per_night;
    public int $nb_room;
    public int $nb_bed;
    public int $nb_bath;
    public int $nb_traveler;
    public bool $is_active;
    public int $type_id;
    public int $adress_id;
    public int $user_id;
    public array $medias;
    public Adresse $adress;
    public array $reservation;
    public array $equipement;
}