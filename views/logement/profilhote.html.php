<?php
$uri = $_SERVER['REQUEST_URI'];
$title = '';
if ($uri == '/logements/1') $title = 'Les Maisons';
elseif ($uri == '/logements/2') $title = 'Les Appartements';
else $title = 'Les Villas';
?>

<div class="card-container-carte">
     <?php foreach ($logements as $logement) : ?>
          <div class="container custom-class-carte">
               <div class="custom-card-carte">
                         <img class="image-card" src="/assets/image-logements/<?= $logement->medias->image_path ?>" alt="">

                         <p class="text-capitalize"> <?= $logement->adress->city ?>, <?= $logement->adress->country?></p>
                         <p class="text-capitalize"> <?= $logement->adress->adress ?></p>
                         <p class="text-capitalize"> <span class="font-weight-bold"><?= $logement->price_per_night?></span> € par nuits</p>
                         <a href="/details/<?= $logement->id?>" class="d-flex align-self-center"><button class="btn btn-primary">details</button></a>
                         
               </div>
          </div>
     <?php endforeach; ?>
</div>