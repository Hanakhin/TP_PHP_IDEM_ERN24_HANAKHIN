<div class="card custom-class ">
    <div>
        <?php foreach($logements->medias as $medias):?>
            <img class="image-card" src="/img/<?= $medias->image_path ?>" alt="">
        <?php endforeach?>
        <h1 class="card-title text-uppercase"> <?= $logements->title ?></h1>
        <p class="card-subtitle subtitle"><?= $logements->description ?> </p>
        <h3>Prix par nuits : <?= $logements->price_per_night ?>€</h3>
        <a href="/carte" class="btn btn-primary">Retour</a>
        <a href="/reservation/<?= $logements->id?>" class="btn btn-primary">Demander une reservation</a>
    </div>

</div>