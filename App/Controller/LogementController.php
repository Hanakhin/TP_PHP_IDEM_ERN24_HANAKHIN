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
}