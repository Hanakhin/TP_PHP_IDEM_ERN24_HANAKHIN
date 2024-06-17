<?php

use Core\Session\Session;

if ($auth::isAuth()) $user_id = Session::get(Session::USER)->id;
?>

<nav>
  <a href="/">
    <img src="/assets/image/logo.svg" alt="logo">
  </a>
  <ul>
    <li class="m-1"><a href="/carte">Accueil</a></li>
    <li class="m-1"><a href="/logements/1">Les Maisons</a></li>
    <li class="m-1"><a href="/logements/2">Les appartements</a></li>
    <li class="m-1"><a href="/logements/3">Les Villas</a></li>
  </ul>
  <?php

  if ($auth::isAuth()) : ?>
    <div class="dropdown custom-link">
      <a class="dropdown-toggle" href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Bienvenue <?= Session::get(Session::USER)->firstname ?>
        <i class="bi bi-person custom-svg"></i>
      </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <li><a class="dropdown-item custom-link" href="/profil/<?= $user_id ?>">Profil</a></li>
        <li><a class="dropdown-item custom-link" href="/profil/logements/<?= $user_id ?>">Mes logements</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item custom-link" href="#">Mes Reservations</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item custom-link" href="/logout">déconnexion</a></li>
      </ul>
    </div>
  <?php else : ?>
    <a href="/connexion">Se connecter
      <i class="bi bi-person custom-svg"></i>
    </a>
  <?php endif ?>
</nav>
<!-- menu du profil -->