<?php

namespace App;

use App\Model\Logement;
use App\Repository\LogementRepository;
use Core\Repository\RepositoryManagerTrait;

class AppRepoManager
{
  //on récupère le trait RepositoryManagerTrait
  use RepositoryManagerTrait;

  //on déclare une propriété privée qui va contenir une instance du repository
// exemple: private Repository $Repository;
  private LogementRepository $logementRepository;

  //on crée ensuite les getter pour accéder à la propriété privée
  //exemple: public function getRepository(): Repository
  //{
  //  return $this->Repository;
  //}
 public function getLogementRepository(): LogementRepository
  {
    return $this->logementRepository;
  }

  
  //enfin, on declare un construct qui va instancier les repositories
  protected function __construct()
  {
    $config = App::getApp();
    //on instancie le repository
    //exemple: $this->Repository = new Repository($config);
    $this->logementRepository = new LogementRepository($config);
  }
}
