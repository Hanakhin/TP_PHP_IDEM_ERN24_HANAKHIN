

<?php foreach ($logements as $logement) : ?>
     <form class="card-container-carte" action="/profil/logement/delete/<?=$logement->id ?>">
          <div class="container custom-class-carte card">
               <div class="custom-card-carte">
                         <img class="image-card" src="/assets/image-logements/<?= $logement->medias[0]->image_path ?>" alt="">

                         <p class="text-capitalize"> <?= $logement->adress->city ?>, <?= $logement->adress->country?></p>
                         <p class="text-capitalize"> <?= $logement->adress->adress ?></p>
                         <p class="text-capitalize"> <span class="font-weight-bold"><?= $logement->price_per_night?></span> € par nuits</p>
                         <div class="d-flex gap-4">
                              <a href="/details/<?= $logement->id?>" class="d-flex align-self-center"><button class="btn btn-primary">details</button></a>
                              <a class="d-flex align-self-center"><button class="btn btn-primary" type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce logement ?')">Supprimer ce logement</button></a>
                         </div>
                         
               </div>
          </div>
     <?php endforeach; ?>
</form>