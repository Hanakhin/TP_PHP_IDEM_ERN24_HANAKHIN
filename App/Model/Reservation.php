<?php 


namespace App\Model;

use Core\Model\Model;

class Reservation extends Model
{
    public string $date_debut;
    public string $date_fin;
    public int $nb_child;
    public int $nb_adult;
    public float $price_total;
    public int $logement_id;
    public int $user_id;
    public array $user;
    public Logement $logement;
}