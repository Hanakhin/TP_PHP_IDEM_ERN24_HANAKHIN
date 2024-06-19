<?php use App\AppRepoManager; ?>
<div class="card-container-detail-card ">

    <div class="container custom-detail-card">
        <div class="custom-card-carte">
            <img class="image-card" src="/assets/image-logements/<?= $logements->medias[0]->image_path ?>" alt="">
            <p class="text-capitalize"> <?= $logements->adress->city ?>, <?= $logements->adress->country ?></p>
            <p class="text-capitalize"> <?= $logements->adress->adress ?></p>
            <p class="text-capitalize"> <span class="font-weight-bold"><?= $logements->price_per_night ?></span> € par nuits</p>
            <h2>Equipement dispo: </h2>
            <?php foreach (AppRepoManager::getRm()->getEquipementRepository()->getEquipementById($logements->id) as $equipement) : ?>
                            <p><?php $equipement->label ?></p>
                        <?php endforeach; ?>
            </div>

            <?php if ($auth::isAuth()) : ?>
                <a href=""><button class="btn btn-primary">Demander une reservation</button></a>
            <?php else : ?>
            <?php endif; ?>
        </div>
        <?php if (!$auth::isAuth()) : ?>
            <p>Vous devez vous <a href="/connexion">connecter</a> pour demander une reservation.</p>
        <?php endif; ?>
        
        <a href="/carte" style="margin-top: 12px;">Retour</a>
    </div>

</div>