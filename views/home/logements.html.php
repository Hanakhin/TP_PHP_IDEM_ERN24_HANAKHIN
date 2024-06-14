<?php
$uri = $_SERVER['REQUEST_URI'];
$title = '';
if ($uri == '/logements/1') $title = 'Les Maisons';
elseif ($uri == '/logements/2') $title = 'Les Appartements';
else $title = 'Les Villa';
?>


<h1>
    <?= $title ?>
</h1>


<?php foreach($logements as $logement):?>

    <div class="d-flex flex-column flex-wrap my-3 justify-content-center col-lg-10 container ">
        <h1 class="card-title title text-uppercase"><?= $logement->title?></h1>
        <p class="card-subtitle subtitle"> <?= $logement->description?></p>
    </div>

<?php endforeach; ?>