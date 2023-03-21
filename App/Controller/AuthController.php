<?php

namespace App\Controller;

use App\App;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;

class AuthController
{
	public function login(): ResponseInterface
	{
		return new HtmlResponse( __METHOD__ );
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