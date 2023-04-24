<?php

namespace App\Controller;

use App\App;
use App\Model\Repository\RepositoryManager;
use App\Session;
use App\Model\User;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use LidemFramework\View;
use Psr\Http\Message\ResponseInterface;
use LidemFramework\Form\FormError;
use LidemFramework\Form\FormResult;


class AuthController extends Controller
{
	public function index(): ResponseInterface
	{
        $view_data = array_merge(
            self::getDefaultViewData(),
            [
            'html_title' => 'Connexion - AirBnB',
            'form_result' => Session::get(Session::FORM_RESULT)
        ]);

        $view = new View( 'user/login' );

        return new HtmlResponse( $view->render( $view_data ) );
	}

    public function login(ServerRequest $request):void
    {
        $post_data = $request->getParsedBody();
        $form_result = new FormResult();
        $user = null;

        //si un des champs n'est pas rempli on ajoute l'erreur
        if(empty($post_data['email']) || empty($post_data['password'])){
            $form_result->addError(new FormError('Veuillez remplir tous les champs'));
        }
        // sinon on compare les valeurs en BDD
        else{
            $email = $post_data['email'];

            // $password = self::hashPassword($post_data['password']);
            $password = $post_data['password'];

            //Appel au repository
            $user = RepositoryManager::getRm()->userRepository->checkAuth($email,$password);

            //Si on a un retour négatif, on ajoute l'erreur
            if(is_null($user)){
                $form_result->addError(new FormError('Email et/ou mot de passe invalide'));
            }
        }
        // si il y a des erreurs on renvoie vers la page de connexion
        if($form_result->hasError()){
            Session::set(Session::FORM_RESULT, $form_result );

            self::redirect('/utilisateur/connexion');

        } else {
            //Si tout est OK on enregistre la session
            // $user->password = '';
            Session::set(Session::USER, $user);

            //enfin, on redirige sur l'accueil
            self::redirect('/');
        }

    }





    public function logout():void
    {

        Session::remove(Session::USER);
        self::redirect('/');
    }

	public static function hashPassword( string $password ): string
	{
		$str_hash = App::get()->getSalt(). $password .App::get()->getPepper();

		return hash( 'sha512', $str_hash );
	}

//    public const AUTH_SALT = 'c56a7523d96942a834b9cdc249bd4e8c7aa9';
//    public const AUTH_PEPPER = '8d746680fd4d7cbac57fa9f033115fc52196';
//
//    public static function hash(string $str): string
//    {
//        $data = self::AUTH_SALT . $str . self::AUTH_PEPPER;
//        return hash('sha512', $data);
//    }

    public static function isAuth():bool
    {
        return !is_null(Session::get(Session::USER));
    }

    //Gestion des roles
    public static function hasRole(int $role): bool
    {
        $user = Session::get(Session::USER);
        if(!($user instanceof User)) return false;

        return $user->role_id === $role;
    }

    public static function isLocataire():bool
    {
        return self::hasRole(User::ROLE_LOCATAIRE);
    }

    public static function isAnnonceur():bool
    {
        return self::hasRole(User::ROLE_ANNONCEUR);
    }
}