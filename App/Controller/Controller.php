<?php

namespace App\Controller;
use App\App;
use Laminas\Diactoros\Response\RedirectResponse;
class Controller
{

    public static function redirect(
        string $uri,
        int $status = 302,
        array $header = [])
    {
        $response = new RedirectResponse($uri, $status, $header);
        App::get()->getRouter()->getPublisher()->publish($response);
        die();
    }

    public static  function getDefaultViewData()
    {
        return [
            'isAuth' => AuthController::isAuth(),
            'isAnnonceur' => AuthController::isAnnonceur(),
            'isLocataire' => AuthController::isLocataire()
        ];
    }
}