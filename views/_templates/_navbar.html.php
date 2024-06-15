<?php

use Core\Session\Session;

 var_dump($auth::isAuth())?>
   <div class="d-flex justify-content-around">
      <!-- logo -->
      <div class="nav-logo">
        <a href="/">
          <!-- <img  src="/dir/vers/logo" alt="logo appli"> -->
          <img src="/assets/img/logo.svg" alt="logo">
        </a>
      </div>

      <!--  barre de navigation -->
      <div>
        <nav>
          <ul class="d-flex justify-content-center">
            <li class="m-1"><a href="/carte">Accueil</a></li>
            <li class="m-1"><a href="/logements/1">Les Maisons</a></li>
            <li class="m-1"><a href="/logements/2">Les appartements</a></li>
            <li class="m-1"><a href="/logements/3">Les Villas</a></li>
          </ul>
        </nav>
      </div>
      <!-- menu du profil -->
      <div >
      <?php

if ($auth::isAuth()) : ?>
  <div class="dropdown custom-link">
    <a class="dropdown-toggle" href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
      Bienvenue <?= Session::get(Session::USER)->firstname ?>
      <i class="bi bi-person custom-svg"></i>
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
      <li><a class="dropdown-item custom-link" href="#">Profil</a></li>
      <li><a class="dropdown-item custom-link" href="#">Mes logements</a></li>
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
      </div>
    </div>