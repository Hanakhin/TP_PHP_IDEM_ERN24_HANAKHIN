
<?php if($auth::isAuth()) $auth::redirect('/') ?>
<main class="container d-flex flex-column">
  <h1>Je me connecte</h1>
  <!-- affichage des erreurs s'il y en a -->
  <?php if ($form_result && $form_result->hasErrors()) : ?>
    <div class="alert alert-danger" role="alert">
      <?= $form_result->getErrors()[0]->getMessage() ?>
    </div>
  <?php endif ?>

  <form class="auth-form" action="/login" method="POST">
    <div class="box-auth-input">
      <label class="detail-description">Adresse Email</label>
      <input type="email" class="form-control" name="email">
    </div>
    <div class="box-auth-input">
      <label class="detail-description">Mot de passe</label>
      <input type="password" class="form-control" name="password">
    </div>
    
    <div style="margin: 22px 0; display:flex; gap: 12px; ">
      <button type="submit" class="call-action btn btn-primary">Je me connecte</button>
      <a href="/" >Retour</a>
    </div>
  </form>
  <p class="header-description">Je n'ai pas de compte, <a class="auth-link" href="/inscription">je m'inscris</a></p>
</main>