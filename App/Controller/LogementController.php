<?php

namespace App\Controller;

use App\Model\Repository\RepositoryManager;
use App\Model\Logement;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use LidemFramework\View;
use Psr\Http\Message\ResponseInterface;

class LogementController
{
	public function index(): ResponseInterface
	{
        $view_data = [
            'html_title' => 'Tous les logements - AirBnB',
            'logements' => RepositoryManager::getRm()->logementRepository->findAll()
        ];

        $view = new View( 'logement/index' );

        return new HtmlResponse( $view->render( $view_data ) );
	}



    public function show( int $id ): ResponseInterface
    {
        $obj_logement = RepositoryManager::getRm()->logementRepository->findById( $id );

        // Si le jouet n'est pas dans la base ($obj_toy sera null)
        // on renvoie une page 404
        if( is_null( $obj_logement ) ) {
            return View::ErrorResponse( 404, [
                'html_title' => 'Page non trouvée - Mon Super site'
            ]);
        }

        // Sinon on charge la vue de détail du jouet

        $view_data = [
            'html_title' => $obj_logement->id .' - AirBnB',
            'logement' => $obj_logement
        ];

        $view = new View( 'logement/detail' );

        return new HtmlResponse( $view->render( $view_data ) );
    }

	public function add(): ResponseInterface
	{
		$view_data = [
			'html_title' => 'Ajouter un logement - AirBnB'
		];

		$view = new View( 'logement/add' );

		return new HtmlResponse( $view->render( $view_data ) );
	}

	public function create( ServerRequest $request ): RedirectResponse
	{
		$form_data = $request->getParsedBody();

		$logement_data = [
			'pays' => $form_data[ 'pays' ],
			'adresse' => $form_data[ 'adresse' ],
            'ville' => $form_data[ 'ville' ],
            'prix' => [ 'prix' ],
            'surface' => $form_data[ 'surface' ],
            'description' => $form_data[ 'description' ],
            'couchage' => $form_data[ 'couchage' ],
            'photo' => $form_data[ 'photo' ],
            'annonceur_id' => $form_data[ 'annonceur_id' ],
            'type_logement_id' => $form_data[ 'type_logement_id' ],
            'titre'=>$form_data['titre']

		];

		RepositoryManager::getRm()->logementRepository->create( new Logement( $logement_data ) );

        return new RedirectResponse( '/' );
	}
}