<?php

use Core\Session\Session;

if ($auth::isAuth()) $user_id = Session::get(Session::USER)->id;

use App\AppRepoManager; ?>
<div class="card-container-detail-card ">
    <div class="container custom-detail-card">
        <div class="custom-card-carte">
            <img class="image-card" src="/assets/image-logements/<?= $logements->medias[0]->image_path ?>" alt="">
            <p class="text-capitalize"> <?= $logements->adress->city ?>, <?= $logements->adress->country ?></p>
            <p class="text-capitalize"> <?= $logements->adress->adress ?></p>
            <p class="text-capitalize"> <span class="font-weight-bold"><?= $logements->price_per_night ?></span> € par nuits</p>
            <div class="equipement-dispo-detail">
                <div class="equipement-container">
                    <p>- equipements disponibles -</p>
                    <?php foreach (AppRepoManager::getRm()->getEquipementLogementRepository()->getEquipements($logements->id) as $equipement) : ?>
                        <p class="equipement-btn"><?= $equipement->label ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if (!$auth::isAuth()) : ?>
        <p>Vous devez vous <a href="/connexion">connecter</a> pour demander une reservation.</p>
    <?php endif; ?>

</div>
<?php if ($auth::isAuth()) : ?>

    <div class="container ">
        <?php
        Session::get(Session::USER)->id = $user_id;

        ?>
        <form class="add-logement-form" action="/addReservation" method="POST" enctype="multipart/form-data">
            
            <?php include(PATH_ROOT . 'views/_templates/_message.html.php'); ?>

            <input type="hidden" name="logement_id" value="<?= $logements->id ?>">
            <input type="hidden" name="price_total" value="<?= $logements->price_per_night ?>">

            <div class=" box-auth-input">
                <label class="detail-description">Date de debut</label>
                <input type="date" class="form-control" name="date_debut">
            </div>
            <div class=" box-auth-input">
                <label class="detail-description">Date de fin</label>
                <input type="date" class="form-control" name="date_fin">
            </div>
            <div class="box-auth-input">
                <label class="detail-description">Nombre d'enfants</label>
                <input type="number" min="0" class="form-control" name="nb_child">
            </div>
            <div class="box-auth-input">
                <label class="detail-description">Nombre d'adulte</label>
                <input type="number" min="0" class="form-control" name="nb_adult">
            </div>

            <button type="submit" class="call-action btn btn-primary mt-4">Demander une reservation</button>
            <a href="/carte" class="btn btn-primary mt-4">Annuler</a>
        </form>
    </div>
    </div>
<?php endif; ?>