<?php
use Core\Session\Session;
$user = Session::get(Session::USER);
?>


    <div class="container card d-flex flex-column " style="padding:24px;">
        <form action="/profil/delete/<?=$user->id ?>">  
            <h1>Vos informations</h1>
            <p>Prénom : <?= $user->firstname?></p>
            <p>Nom : <?= $user->lastname?></p>
            <p>email : <?= $user->email?></p>
            <p>n° de téléphone : <?= $user->phone?></p>
            <button class="btn btn-danger">Desactiver mon compte</button>
        </form>
    </div>