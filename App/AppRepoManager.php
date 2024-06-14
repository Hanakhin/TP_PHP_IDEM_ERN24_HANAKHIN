<?php

namespace App;

use App\Model\Logement;
use App\Repository\LogementRepository;
use App\Repository\MediaRepository;
use Core\Repository\RepositoryManagerTrait;

class AppRepoManager
{
  //on récupère le trait RepositoryManagerTrait
  use RepositoryManagerTrait;

  //on déclare une propriété privée qui va contenir une instance du repository
// exemple: private Repository $Repository;
  private LogementRepository $logementRepository;
  private MediaRepository $mediaRepository;
  //on crée ensuite les getter pour accéder à la propriété privée
  //exemple: public function getRepository(): Repository
  //{
  //  return $this->Repository;
  //}
 public function getLogementRepository(): LogementRepository
  {
    return $this->logementRepository;
  }
  public function getMediaRepository(): MediaRepository
  {
    return $this->mediaRepository;
  }
  
  //enfin, on declare un construct qui va instancier les repositories
  protected function __construct()
  {
    $config = App::getApp();
    //on instancie le repository
    //exemple: $this->Repository = new Repository($config);
    $this->logementRepository = new LogementRepository($config);
    $this->mediaRepository = new MediaRepository($config);
  }
}
