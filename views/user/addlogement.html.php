<div class="container ">
    <form class="add-logement-form" action="/newlogement" method="POST">

        <div class="form-container">

            <div class="box-auth-input">
                <label class="detail-description">Adresse</label>
                <input type="text" class="form-control" name="adress">
            </div>
            <div class="box-auth-input">
                <label class="detail-description">Ville</label>
                <input type="text" class="form-control" name="city">
            </div>
            <div class="box-auth-input">
                <label class="detail-description">Pays</label>
                <input type="text" class="form-control" name="country">
            </div>
            <div class="box-auth-input">
                <label class="detail-description">Code postal</label>
                <input type="text" class="form-control" name="zip_code">
            </div>
        </div>

        <div class="form-container">
            <div class="box-auth-input">
                <label class="detail-description">Nom du logement</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="box-auth-input">
                <label class="detail-description">Description</label>
                <input type="text" class="form-control" name="description">
            </div>
            <div class="box-auth-input">
                <label class="detail-description">Prix par nuits</label>
                <input type="number" min="1" class="form-control" name="price_per_night">
            </div>
            <div class="form-container">
                <div class="box-auth-input ">
                    <label class="detail-description">Type de logement</label>
                    <div style="display:flex;gap:10px;">
                        <?php

                        use App\AppRepoManager;

                        foreach (AppRepoManager::getRm()->getTypeRepository()->getAllType() as $types) : ?>
                            <input type="radio" name="type_id" value="<?= $types->id ?>">
                            <label for="type"><?= $types->label ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class=" box-auth-input">
            <label class="detail-description">Nombre de chambres</label>
            <input type="number" class="form-control" name="nb_room">
        </div>
        <div class=" box-auth-input">
            <label class="detail-description">Nombre de lits</label>
            <input type="number" class="form-control" name="nb_bed">
        </div>
        <div class="box-auth-input">
            <label class="detail-description">Nombre de salle de bain</label>
            <input type="number" class="form-control" name="nb_bath">
        </div>
        <div class="box-auth-input">
            <label class="detail-description">Nombre maximal de voyageurs</label>
            <input type="number" class="form-control" name="nb_traveler">
        </div>

        <div class="form-container">
            <label class="detail-description">Equipements disponible</label>
            <div class="box-auth-input">
            <?php foreach (AppRepoManager::getRm()->getEquipementRepository()->getAllEquipement() as $equipement) : ?>
                            <input type="checkbox" name="equipements[]" value="<?= $equipement->id ?>">
                            <label for="type"><?= $equipement->label ?></label>
                        <?php endforeach; ?>
            </div>

            <div>
                <label for="image">Photo de la maison</label>
                <input type="file" name="image">
            </div>

        </div>
        <button type="submit" class="call-action btn btn-primary mt-4">Ajouter logement</button>
        <a href="/carte" class="btn btn-primary mt-4">Annuler</a>
    </form>
</div>