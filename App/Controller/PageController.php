<?php

namespace App\Controller;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

use LidemFramework\View;

class PageController
{
	public function index(): ResponseInterface
	{
		$view = new View( 'page/home' );

		$data = [
			'html_title' => 'Accueil - AirBnb'
		];

		return new HtmlResponse( $view->render( $data ) );
	}

}