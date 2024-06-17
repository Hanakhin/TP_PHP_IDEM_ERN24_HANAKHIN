<?php 

namespace App\Controller;

use App\AppRepoManager;
use Core\Controller\Controller;
use Core\Form\FormResult;
use Core\View\View;
use Laminas\Diactoros\ServerRequest;

class LogementController extends Controller
{
    public function home()
    {
        $view = new View('home/home');
        $view->render();
    }

    public function getLogementByType(int $id):void
    {
        $view_data = [
            'h1' => 'Maison disponibles',
            'logements' => AppRepoManager::getRm()->getLogementRepository()->getLogementByTypeId($id)
        ];
        $view = new View('home/logements');
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
        $view = new View('home/details');
        $view->render($view_data);
    }
    private function generateReservationNumber()
    {
      //je veux un numero de commande du type: FACT2406_00001 par exemple
      $reservation_number = 1;
      $reservation = AppRepoManager::getRm()->getReservationRepository()->getAllReservation();
      $year = date('y');
      $month = date('m');
  
      $final = "FACT{$year}{$month}_{$reservation_number}";
      return $final;
    }
    public function makeReservation(ServerRequest $request)
    {
       $form_data = $request->getParsedBody();
       $form_result = new FormResult();
       $reservation_number = $this->generateReservationNumber();
    }
}