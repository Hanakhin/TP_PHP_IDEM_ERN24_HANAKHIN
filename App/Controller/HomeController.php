<?php 

namespace App\Controller;

use Core\View\View;
use App\AppRepoManager;
use Core\Controller\Controller;

class HomeController extends Controller 
{
  public function home()
  {
    $view = new View('home/index');

    $view->render();
  }


  public function getAllLogement(): void
  {
      $view_data = [
          'h1' => 'tout les logements',
          'logements' => AppRepoManager::getRm()->getLogementRepository()->getAllLogement()
      ];
      $view = new View('home/index');
      $view->render($view_data);
  }
}