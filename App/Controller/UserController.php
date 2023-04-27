<?php

namespace App\Controller;

use App\Model\Repository\RepositoryManager;
use App\Model\User;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use LidemFramework\View;
use Psr\Http\Message\ResponseInterface;

class UserController extends Controller
{

	public function add(): ResponseInterface
	{
		$view_data =array_merge(
            self::getDefaultViewData(),
            [
			    'html_title' => 'S\'inscrire - AirBnB'
		    ]
        );

		$view = new View( 'user/add' );

		return new HtmlResponse( $view->render( $view_data ) );
	}

	public function create( ServerRequest $request ): RedirectResponse
	{
		$form_data = $request->getParsedBody();

		$user_data = [
			'nom' => $form_data[ 'nom' ],
			'prenom' => $form_data[ 'prenom' ],
            'email' => $form_data[ 'email' ],
            'password' => AuthController::hashPassword( $form_data[ 'password' ] ),
            'role_id' => $form_data[ 'role_id' ]
		];

		RepositoryManager::getRm()->userRepository->create( new User( $user_data ) );

		return new RedirectResponse( '/' );
	}
}