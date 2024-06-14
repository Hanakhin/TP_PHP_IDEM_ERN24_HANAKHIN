<?php 

namespace App\Controller;

use App\AppRepoManager;
use Core\Controller\Controller;
use Core\View\View;

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
}