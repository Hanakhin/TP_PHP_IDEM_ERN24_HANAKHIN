<?php 


namespace App\Model;

use Core\Model\Model;

class Media extends Model
{   
    public int $id;
    public string $image_path;
    public int $logement_id;
}