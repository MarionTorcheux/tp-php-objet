<?php

namespace App\Controller;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class IngredientController
{
	public function index(): ResponseInterface
	{
		// TODO: code
		return new HtmlResponse( __METHOD__ );
	}
}