<?php

namespace App\Controller;
use App\App;
use Laminas\Diactoros\Response\RedirectResponse;
use App\Model\Repository\RepositoryManager;
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
        //var_dump(RepositoryManager::getRm()->userRepository->findById($_SESSION['USER']->id));

        //var_dump($_SESSION['USER']->id);
         $userConnect = AuthController::isAuth() ? RepositoryManager::getRm()->userRepository->findById($_SESSION['USER']->id) : [];

        return [
            'isAuth' => AuthController::isAuth(),
            'isAnnonceur' => AuthController::isAnnonceur(),
            'isLocataire' => AuthController::isLocataire(),
            'user' => $userConnect
        ];
    }
}