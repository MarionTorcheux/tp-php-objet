<?php

namespace App\Controller;

use App\App;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use LidemFramework\View;
use Psr\Http\Message\ResponseInterface;

class AuthController
{
	public function login(): ResponseInterface
	{
        $view_data = [
            'html_title' => 'Connexion - AirBnB'
        ];

        $view = new View( 'user/login' );

        return new HtmlResponse( $view->render( $view_data ) );
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