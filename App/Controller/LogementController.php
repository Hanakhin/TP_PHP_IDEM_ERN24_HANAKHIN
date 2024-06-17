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
}