<?php

namespace App\Controller;

use App\Model\Repository\RepositoryManager;
use App\Model\Reservation;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use LidemFramework\View;
use Psr\Http\Message\ResponseInterface;

class ReservationController extends Controller
{

    public function reservation($id): ResponseInterface
    {
        $view_data = array_merge(
            self::getDefaultViewData(),
            [
                'html_title' => 'Reservation - AirBnB',
                'id_location' => $id
            ]
        );

        $view = new View( 'page/reserver' );

        return new HtmlResponse( $view->render( $view_data ) );
    }





	public function create(ServerRequest $request, $id):RedirectResponse
	{
		$form_data = $request->getParsedBody();

		$reservation_data = [
			'logement_id' =>$id,
			'user_id' => $_SESSION['USER']->id,
            'date_debut' => $form_data[ 'datearrivee' ],
            'date_fin' => $form_data[ 'datefin' ]
		];

		RepositoryManager::getRm()->reservationRepository->create( new Reservation( $reservation_data ) );

        return new RedirectResponse( '/' );
	}
}