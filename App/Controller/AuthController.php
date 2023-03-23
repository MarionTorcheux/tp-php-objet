<?php

namespace App\Controller;

use App\App;
use App\Session;
use App\Model\User;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use LidemFramework\View;
use Psr\Http\Message\ResponseInterface;
use LidemFramework\Form\FormError;
use LidemFramework\Form\FormResult;


class AuthController
{
	public function index(): ResponseInterface
	{
        $view_data = [
            'html_title' => 'Connexion - AirBnB',
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view = new View( 'user/login' );

        return new HtmlResponse( $view->render( $view_data ) );
	}

    public function login(ServerRequest $request):void
    {
        $post_data = $request->getParsedBody();
        $form_result = new FormResult();
        $user = new User();

        //si un des champs n'est pas rempli on ajoute l'erreur
        if(empty($post_data['email']) || empty($post_data['password'])){
            $form_result->addError(new FormError('Veuillez remplir tous les champs'));
        }
        // sinon on compare les valeurs en BDD
        else{
            $email = $post_data['email'];
            $password = self::hashPassword($post_data['password']);

            //Appel au repository
            $user = AuthController::hashPassword( $password);
            //Si on a un retour négatif, on ajoute l'erreur
            if(is_null($user)){
                $form_result->addError(new FormError('Email et/ou mot de passe invalide'));
            }
        }
        // si il y a des erreurs on renvoie vers la page de connexion
        if($form_result->hasError()){
            Session::set(Session::FORM_RESULT, $form_result );
            new RedirectResponse( '/connexion' );

        }

        //Si tout est OK on enregistre la session
        $user->password = '';
        Session::set(Session::USER, $user);

        //enfin, on redirige sur l'accueil
        new RedirectResponse( '/' );

    }






	public function auth(): RedirectResponse
	{
		return new RedirectResponse( '/connexion' );
	}

	public function logout(): RedirectResponse
	{
		return new RedirectResponse( '/connexion' );
	}

	public static function hashPassword( string $password ): string
	{
		$str_hash = App::get()->getSalt(). $password .App::get()->getPepper();

		return hash( 'sha512', $str_hash );
	}
}