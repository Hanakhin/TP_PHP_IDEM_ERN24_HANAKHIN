<div class="d-flex flex-column card-container">


     <?php foreach ($logements as $logement) : ?>
          <div class="card custom-class ">
               <div>
                    <?php foreach ($logement->medias as $media) : ?>
                         <img class="image-card" src="/img/<?= $media->image_path ?>" alt="">
                    <?php endforeach ?>
               </div>
               <div>
                    <form action="/details/<?= $logement->id ?>">
                         <h1 class="card-title text-uppercase"><?= $logement->title ?></h1>
                         <p class="card-subtitle subtitle"> <?= $logement->description ?></p>
                         <p> Prix: <?= $logement->price_per_night ?>€ par nuits</p>
                         <button class="btn btn-primary">Details</button>
                    </form>
               </div>
          </div>

     <?php endforeach; ?>
</div>