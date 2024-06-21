<?php

use App\AppRepoManager;
use Core\Session\Session;

Session::get(Session::USER)->id = $user_id;

?>

<div class="card-container-carte ">
    <?php foreach(AppRepoManager::getRm()->getReservationRepository()->getReservationByUser($user_id) as $reservation):?>
        <?php 
                $date_debut = new DateTime($reservation->date_debut);
                $date_fin = new DateTime($reservation->date_fin);
                $interval = $date_debut->diff($date_fin);
                $diff = $interval->days
        ?>


        <div class="custom-card-carte card">
               <p class="text-capitalize"> Date d'arrivée: <?= $reservation->date_debut ?></p>
               <p>Date de départ: <?= $reservation->date_fin?></p>
               <p class="text-capitalize"> Nombre d'enfants: <?= $reservation->nb_child ?> </p>
               <p>Nombre d'adultes: <?= $reservation->nb_adult ?> </p>
               <p>Prix total: <?= $reservation->logement->price_per_night * $diff ?>  </p>
               <div style="display: flex; flex-direction:column;gap:8px">
                   <a href="/details/<?= $reservation->logement_id ?>" class="d-flex align-self-center"><button class="btn btn-primary">details</button></a>
                   <a href="/mesreservations/delete/<?= $reservation->id?>" class="d-flex align-self-center"><button class="btn btn-primary">Annuler la reservation</button></a>
               </div>
        </div>
<?php endforeach; ?>
</div>




