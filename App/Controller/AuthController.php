<?php 

namespace App\Controller;

use App\Model\User;
use Core\Form\FormSuccess;
use Core\View\View;
use App\AppRepoManager;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use Laminas\Diactoros\ServerRequest;

class AuthController extends Controller
{
    public function loginForm()
    {
        $view = new View('auth/login');
        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        $view->render($view_data);
    }

    public function registerForm()
    {
        $view = new View('auth/inscription');
        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        $view->render($view_data);
    }

    public function register(ServerRequest $request)
    {
      //on receptionne les données du formulaire
      $data_form = $request->getParsedBody();
      //on instancie formResult pour stocker les messages d'erreurs
      $form_result = new FormResult();
      //on doit crée une instance de User
      $user = new User();
  
      //on s'occupe de toute les vérifications
      if (
        empty($data_form['email']) ||
        empty($data_form['password']) ||
        empty($data_form['password_confirm']) ||
        empty($data_form['lastname']) ||
        empty($data_form['firstname']) ||
        empty($data_form['phone'])
      ) {
        $form_result->addError(new FormError('Veuillez remplir tous les champs'));
      } elseif ($data_form['password'] !== $data_form['password_confirm']) {
        $form_result->addError(new FormError('Les mots de passe ne correspondent pas'));
      } elseif (!$this->validEmail($data_form['email'])) {
        $form_result->addError(new FormError('L\'email n\'est pas valide'));
      } elseif (!$this->validPassword($data_form['password'])) {
        $form_result->addError(new FormError('Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre'));
      } elseif ($this->userExist($data_form['email'])) {
        $form_result->addError(new FormError('Cet utilisateur existe déjà'));
      } else {
        $data_user = [
          'email' => strtolower($this->validInput($data_form['email'])),
          'password' => password_hash($this->validInput($data_form['password']), PASSWORD_BCRYPT),
          'lastname' => $this->validInput($data_form['lastname']),
          'firstname' => $this->validInput($data_form['firstname']),
          'phone' => $this->validInput($data_form['phone'])
        ];
  
        AppRepoManager::getRm()->getUserRepository()->addUser($data_user);
      }
  
      if ($form_result->hasErrors()) {
        Session::set(Session::FORM_RESULT, $form_result);
        self::redirect('/inscription');
      }
      $user->password = '';
      Session::remove(Session::FORM_RESULT);
      self::redirect('/');
    }

    public function login(ServerRequest $request)
    {
      //on receptionne les données du formulaire
      $data_form = $request->getParsedBody();
      //on instancie formResult pour stocker les messages d'erreurs
      $form_result = new FormResult();
      //on doit crée une instance de User
      $user = new User();
  
      //on s'occupe de toute les vérifications
      if (empty($data_form['email']) || empty($data_form['password'])) {
        $form_result->addError(new FormError('Veuillez remplir tous les champs'));
      } elseif (!$this->validEmail($data_form['email'])) {
        $form_result->addError(new FormError('L\'email n\'est pas valide'));
      } else {
        $email = strtolower($this->validInput($data_form['email']));
        //on vérifie qu'on a bien un utilisateur avec cet email
        $user = AppRepoManager::getRm()->getUserRepository()->findUserByEmail($email);
        if (is_null($user) || !password_verify($this->validInput($data_form['password']), $user->password)) {
          $form_result->addError(new FormError('Email ou mot de passe incorrect'));
        }
      }
      if ($form_result->hasErrors()) {
        Session::set(Session::FORM_RESULT, $form_result);
        self::redirect('/connexion');
      }
      $user->password = '';
      Session::set(Session::USER, $user);
      Session::remove(Session::FORM_RESULT);
      self::redirect('/');
    }


    public function validEmail(string $email): bool
    {
      return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validPassword(string $password): bool
    {
      return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password);
    }

    public function userExist(string $email): bool
    {
      $user = AppRepoManager::getRm()->getUserRepository()->findUserByEmail($email);
      return !is_null($user);
    }

    public function validInput(string $data): string
    {
      $data = trim($data);
      $data = strip_tags($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    public static function isAuth():bool
    {
      return !is_null(Session::get(Session::USER));
    }

    public function logout():void
    {
      //on va détruire la session
      Session::remove(Session::USER);
      //on redirige sur la page d'accueil
      self::redirect('/');
    }

    public function IsActivated(int $id , bool $isActive):bool
    { 
      $isActivated = AppRepoManager::getRm()->getUserRepository()->isUserActive($id,$isActive);
      return !is_null($isActivated);
    }

}