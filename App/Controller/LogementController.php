<?php 

namespace App\Controller;

use App\App;
use App\AppRepoManager;
use App\Model\Logement;
use Core\Controller\Controller;
use Core\Form\FormError;
use Core\Form\FormResult;
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

    public function getLogementByType(int $id):void
    {
        $view_data = [
            'h1' => 'Maison disponibles',
            'logements' => AppRepoManager::getRm()->getLogementRepository()->getLogementByTypeId($id)
        ];
        $view = new View('logement/logements');
        $view->render($view_data);
    }

    public function getAllLogement():void
    {
        $view_data=[
            'h1' => 'toutes les maisons',
            'logements' => AppRepoManager::getRm()->getLogementRepository()->getAllLogement()
        ];
        $view = new View('home/carte');
        $view->render($view_data);
    }

    public function getDetail(int $id):void
    {
        $view_data = [
            'h1'=> 'details de la maison',
            'logements'=> AppRepoManager::getRm()->getLogementRepository()->getLogementByid($id)
        ];
        $view = new View('logement/details');
        $view->render($view_data);
    }
    public function getLogementByUser(int $id):void
    {
        $view_data=[
            'h1' => 'vos logements',
            'logements'=> AppRepoManager::getRm()->getLogementRepository()->getLogementByUser($id)
        ];
        $view = new View('logement/profilhote');
        $view->render($view_data);
    }

    public function addlogement(ServerRequest $request):void
    {
        $data_form = $request->getParsedBody();
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

        $image = $data_form['image'];
        
        $reservation_data_adress = [
            'adress'=>$adresse,
            'city'=>$city,
            'country'=>$country,
            'zip_code'=>$zipCode
        ];

        $adress_id = AppRepoManager::getRm()->getAdresseRepository()->insertAdress($reservation_data_adress);

        $logement_data = [
            'title' => $title,
            'description' => $description,
            'price_per_night' => $price,
            'nb_room' => $nb_room,
            'nb_bed' => $nb_bed,
            'nb_bath'=>$nb_bath,
            'nb_traveler' => $nb_traveler,
            'is_active' => $is_active,
            'type_id'=> $type_id ,
            'adress_id' => $adress_id,
            'user_id'=>$user_id,
        ];

        $reservation_logement_id = AppRepoManager::getRm()->getLogementRepository()->addLogement($logement_data);

        foreach($data_form['equipements'] as $equipement)
        {
            $reservation_equipement_data = [
                'logement_id' => $reservation_logement_id,
                'equipement_id' => $equipement
            ];
        $equipement_data = AppRepoManager::getRm()->getEquipementLogementRepository()->insertEquipement($reservation_equipement_data);

        }

        $media_data = [
            'image_path' => $image,
            'logement_id' => $reservation_logement_id
        ];

        $media_data = AppRepoManager::getRm()->getMediaRepository()->insertMedia($media_data);


        if (
            empty($data_form['title']) ||
            empty($data_form['description']) ||
            empty($data_form['price_per_night']) ||
            empty($data_form['nb_room']) ||
            empty($data_form['nb_bed']) ||
            empty($data_form['nb_bath'])||
            empty($data_form['nb_traveler']) ||
            empty($data_form['type']) 
          ){
            $form_result->addError(new FormError('veuillez remplir tout les champs'));
          }
          else{
            $data_logement = [
                'title' => strtolower($this->validInput($data_form['title'])),
                'description' => strtolower($this->validInput($data_form['description'])),
                'price_per_night' => strtolower($this->validInput($data_form['price_per_night'])),
                'nb_room' => strtolower($this->validInput($data_form['nb_room'])),
                'nb_bed' => strtolower($this->validInput($data_form['nb_bed'])),
                'nb_bath' => strtolower($this->validInput($data_form['nb_bath'])),
                'nb_traveler' => strtolower($this->validInput($data_form['nb_traveler'])),
                'type' => $type_id
            ];
            var_dump($data_logement);
            AppRepoManager::getRm()->getLogementRepository()->addLogement($data_logement);
            self::redirect('/carte');
          }
          
    }
    public function addlogementForm()
    {
        $view = new View('user/addlogement');
        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        $view->render($view_data);
    }
}