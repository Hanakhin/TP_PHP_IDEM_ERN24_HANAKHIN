<?php 

namespace App\Controller;

use Core\View\View;
use App\AppRepoManager;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Form\FormSuccess;
use Core\Controller\Controller;
use Core\Session\Session;

class UserController extends Controller
{
    public function getUserProfil($id)
    {
        $view_data = [
            'h1' => 'users',
            'users' => AppRepoManager::getRm()->getUserRepository()->getUserProfil($id)
        ];
        $view = new View('user/profil');
        $view->render($view_data);
    }
    public function deleteUser(int $id):void
    {
      $form_result = new FormResult();

      $deleteUser = AppRepoManager::getRm()->getUserRepository()->deleteUser($id);

      if(!$deleteUser){
        $form_result->addError(new FormError('erreur lors de la suppression de l\'utilisateur'));
      }else{
        $form_result->addSuccess(new FormSuccess('L\'user a bien été supprimé'));
      }

      if($form_result->hasErrors()){
        Session::set(Session::FORM_RESULT, $form_result);
      }
      if ($form_result->getSuccessMessage()) {
        Session::remove(Session::FORM_RESULT);
        session_destroy();
        self::redirect('/carte');
      }
    }
}