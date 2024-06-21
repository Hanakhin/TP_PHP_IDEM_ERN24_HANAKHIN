<?php

namespace App\Controller;

use App\App;
use App\AppRepoManager;
use App\Model\Logement;
use Core\Controller\Controller;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Form\FormSuccess;
use Core\Session\Session;
use Core\View\View;
use Laminas\Diactoros\ServerRequest;

class LogementController extends Controller
{
    public function home()
    {
        $view = new View('home/home');
        $view->render();
    }

    public function validInput(string $data): string
    {
        $data = trim($data);
        $data = strip_tags($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function getLogementByType(int $id): void
    {
        $view_data = [
            'h1' => 'Maison disponibles',
            'logements' => AppRepoManager::getRm()->getLogementRepository()->getLogementByTypeId($id)
        ];
        $view = new View('logement/logements');
        $view->render($view_data);
    }

    public function getAllLogement(): void
    {
        $view_data = [
            'h1' => 'toutes les maisons',
            'logements' => AppRepoManager::getRm()->getLogementRepository()->getAllLogement()
        ];
        $view = new View('home/carte');
        $view->render($view_data);
    }

    public function getDetail(int $id): void
    {
        $view_data = [
            'h1' => 'details de la maison',
            'logements' => AppRepoManager::getRm()->getLogementRepository()->getLogementByid($id),
            'form_result' => Session::get(Session::FORM_RESULT),
            'form_success'=> Session::get(Session::FORM_SUCCESS)
            
        ];
        $view = new View('logement/details');

        $view->render($view_data);
    }
    public function getLogementByUser(int $id): void
    {
        $view_data = [
            'h1' => 'vos logements',
            'logements' => AppRepoManager::getRm()->getLogementRepository()->getLogementByUser($id),
            'reservations'=> AppRepoManager::getRm()->getReservationRepository()->getReservationPerLogement($id)
        ];
        $view = new View('logement/profilhote');
        $view->render($view_data);
    }

    public function addlogement(ServerRequest $request): void
    {
        $data_form = $request->getParsedBody();

        $file_data = $_FILES['image_path'];
        $form_result = new FormResult();
        $title = $data_form['title'];
        $description = $data_form['description'];
        $price = $data_form['price_per_night'];
        $nb_room = $data_form['nb_room'];
        $nb_bed = $data_form['nb_bed'];
        $nb_bath = $data_form['nb_bath'];
        $nb_traveler = $data_form['nb_traveler'];
        $is_active = 1;
        $type_id = $data_form['type_id'];
        $adresse = $data_form['adress'];
        $user_id = Session::get(Session::USER)->id;
        $city = $data_form['city'];
        $country = $data_form['country'];
        $zipCode = $data_form['zip_code'];


        $image_name = $file_data['name'] ?? '';
        $tmp_path = $file_data['tmp_name'] ?? '';
        $public_path = 'public/assets/image-logements/';








        if (!in_array($file_data['type'] ?? '', ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])) {
            $form_result->addError(new FormError('Le format de l\'image n\'est pas valide'));
        } elseif (
            empty($data_form['title']) ||
            empty($data_form['description']) ||
            empty($data_form['price_per_night']) ||
            empty($data_form['nb_room']) ||
            empty($data_form['nb_bed']) ||
            empty($data_form['nb_bath']) ||
            empty($data_form['nb_traveler']) ||
            empty($data_form['type_id'])
            ) {
            $form_result->addError(new FormError('veuillez remplir tout les champs'));
        } else {
            $filename = uniqid() . '_' . $image_name;
            $slug = explode('.', strtolower(str_replace(' ', '-', $filename)))[0];
            $imgPathPublic = PATH_ROOT . $public_path . $filename;
            $reservation_data_adress = [
                'adress' => $adresse,
                'city' => $city,
                'country' => $country,
                'zip_code' => $zipCode
            ];
            if (move_uploaded_file($tmp_path, $imgPathPublic)) {

                $adress_id = AppRepoManager::getRm()->getAdresseRepository()->insertAdress($reservation_data_adress);
                if (!$adress_id) {
                    $form_result->addError(new FormError('erreur insert adresse'));
                } else {
                    $logement_data = [
                        'title' => $title,
                        'description' => $description,
                        'price_per_night' => $price,
                        'nb_room' => $nb_room,
                        'nb_bed' => $nb_bed,
                        'nb_bath' => $nb_bath,
                        'nb_traveler' => $nb_traveler,
                        'is_active' => $is_active,
                        'type_id' => $type_id,
                        'adress_id' => $adress_id,
                        'user_id' => $user_id,
                    ];


                    $reservation_logement_id = AppRepoManager::getRm()->getLogementRepository()->addLogement($logement_data);
                    if (!$reservation_logement_id) {
                        $form_result->addError(new FormError('erreur insert logement'));
                    } else {
                        foreach ($data_form['equipements'] as $equipement) {
                            $reservation_equipement_data = [
                                'logement_id' => $reservation_logement_id,
                                'equipement_id' => $equipement
                            ];
                            $equipement_data = AppRepoManager::getRm()->getEquipementLogementRepository()->insertEquipement($reservation_equipement_data);
                            if (!$equipement_data) {
                                $form_result->addError(new FormError('erreur insert equipements'));
                            }
                        }
                        $media_data = [
                            'image_path' => htmlspecialchars(trim($filename)),
                            'logement_id' => $reservation_logement_id
                        ];
                        $media_data = AppRepoManager::getRm()->getMediaRepository()->insertMedia($media_data);
                        if (!$media_data) {
                            $form_result->addError(new FormError('erreur insert image'));
                        } else {
                            $form_result->addSuccess(new FormSuccess('ajout reussi'));
                        }
                    }
                    // gestion des erreurs
                    if ($form_result->hasErrors()) {
                        // stockage des erreurs dans la session
                        Session::set(Session::FORM_RESULT, $form_result);
                        // redirection vers la page d'ajout de pizza
                        self::redirect('/addlogment/<?= $user_id ?>');
                    }

                    // redirection vers la page admin
                    if ($form_result->hasSuccess()) {
                        Session::set(Session::FORM_SUCCESS, $form_result);
                        Session::remove(Session::FORM_RESULT);
                        self::redirect('/carte');
                    }
                }
            } else {
                $form_result->addError(new FormError('erreur deplacement image'));
            }
        }
    }
    public function addlogementForm()
    {
        $view = new View('user/addlogement');
        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT),
            'form_success'=> Session::get(Session::FORM_SUCCESS)
        ];
        $view->render($view_data);
    }

    public function deleteLogement(int $id): void
    {
        $form_result = new FormResult();
        $user_id = Session::get(Session::USER)->id;
        $deleteLogement = AppRepoManager::getRm()->getLogementRepository()->deleteLogement($id);

        if (!$deleteLogement) {
            $form_result->addError(new FormError('erreur lors de la suppression du logement'));
        } else {
            $form_result->addSuccess(new FormSuccess('hello'));
        }

        if ($form_result->hasErrors()) {
            Session::set(Session::FORM_RESULT, $form_result);
        }
        if ($form_result->getSuccessMessage()) {
            self::redirect('/profil/logements/'.$user_id);
        }
    }

    public function addReservationForm()
    {
        $view = new View('logement/details');
        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT),
            'form_success'=> Session::get(Session::FORM_SUCCESS)
        ];
        $view->render($view_data);
    }

    public function addReservation(ServerRequest $request):void
    {
        $data_form = $request->getParsedBody();
        $form_result = new FormResult();
        $date_debut = $data_form['date_debut'];
        $date_fin = $data_form['date_fin'];
        $nb_enfant = $data_form['nb_child'];
        $nb_adult = $data_form['nb_adult'];
        $price_total = $data_form['price_total'];
        $logement_id = $data_form['logement_id'];
        $user_id = Session::get(Session::USER)->id;

        if(
            empty($data_form['date_debut'])||
            empty($data_form['date_fin'])||
            empty($data_form['nb_child'])||
            empty($data_form['nb_adult'])||
            empty($data_form['price_total'])||
            empty($data_form['logement_id'])||
            empty($user_id)
        ){
            $form_result->addError(new FormError('veuillez remplir tout les champs'));
        }else{
            $reservation_data = [
                'date_debut'=>$date_debut,
                'date_fin'=>$date_fin,
                'nb_child'=>$nb_enfant,
                'nb_adult'=>$nb_adult,
                'price_total'=>$price_total,
                'logement_id'=>$logement_id,
                'user_id'=>$user_id
            ];

            $newReservation = AppRepoManager::getRm()->getReservationRepository()->addReservation($reservation_data);

            if(!$newReservation){
                $form_result->addError(new FormError('erreur'));
            }else{
                $form_result->addSuccess(new FormSuccess('bien joué'));
            }
        }

        if ($form_result->hasErrors()) {
            // stockage des erreurs dans la session
            Session::set(Session::FORM_RESULT, $form_result);
            // redirection vers la page d'ajout de pizza
            self::redirect('/details/'. $logement_id );
        }

        // redirection vers la page admin
        if ($form_result->hasSuccess()) {
            Session::set(Session::FORM_SUCCESS, $form_result);
            Session::remove(Session::FORM_RESULT);
            self::redirect('/carte');
        }      
    }
}
