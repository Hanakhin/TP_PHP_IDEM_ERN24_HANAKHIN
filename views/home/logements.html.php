<?php
$uri = $_SERVER['REQUEST_URI'];
$title = '';
if ($uri == '/logements/1') $title = 'Les Maisons';
elseif ($uri == '/logements/2') $title = 'Les Appartements';
else $title = 'Les Villas';
?>

<h1>
    <?= $title ?>
</h1>


<div class="custom-class">
<?php foreach ($logements as $logement) : ?>
        <div class="card container custom-class-card">
            <div>
                <h1 class="card-title text-uppercase"><?= $logement->title ?></h1>
                <p class="card-subtitle subtitle"> <?= $logement->description ?></p>
            </div>
            <div>
                <p> Prix: <?= $logement->price_per_night ?> € par nuits</p>
                <?php foreach($logement->medias as $media): ?>
                    <img class="image-card" src="/img/<?= $media->image_path ?>" alt="">
                <?php endforeach ?>
            </div>
            <button class="btn btn-primary">Demander une reservation</button>
        </div>
    
    <?php endforeach; ?>
</div>