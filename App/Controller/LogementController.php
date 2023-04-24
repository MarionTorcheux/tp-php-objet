<?php

namespace App\Controller;

use App\Model\Repository\RepositoryManager;
use App\Model\Logement;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use LidemFramework\View;
use Psr\Http\Message\ResponseInterface;
use App\Session;

class LogementController extends Controller
{
	public function index(): ResponseInterface
	{
        $view_data = array_merge(
            self::getDefaultViewData(),
            [
            'html_title' => 'Tous les logements - AirBnB',
            'logements' => RepositoryManager::getRm()->logementRepository->findAll(),
            ]
        );

        $view = new View( 'logement/index' );

        return new HtmlResponse( $view->render( $view_data ) );
	}


    public function getAnnoncesById(): ResponseInterface
    {

        $view_data = array_merge(
            self::getDefaultViewData(), [
            'html_title' => 'Mes annonces - AirBnB',
            'logements' => RepositoryManager::getRm()->logementRepository->findAll()
        ]);

        $view = new View( 'page/mesannonces' );

        return new HtmlResponse( $view->render( $view_data ) );
    }




    public function show( int $id ): ResponseInterface
    {

        $equipement = RepositoryManager::getRm()->equipementRepository->findAllEquipementById($id);


        $obj_logement_pouet = RepositoryManager::getRm()->logementRepository->findByIdWithInfos($id);


        // Si le logement n'est pas dans la base ( sera null)
        // on renvoie une page 404
        if( is_null( $obj_logement_pouet ) ) {
            return View::ErrorResponse( 404, [
                'html_title' => 'Page non trouvée - Mon Super site'
            ]);
        }

        // Sinon on charge la vue de détail

        $view_data = array_merge(
            self::getDefaultViewData(),[
            'html_title' => $obj_logement_pouet->id .' - AirBnB',
            'logement' => $obj_logement_pouet,
            'equipements' => $equipement
        ]);

        $view = new View( 'logement/detail' );

        return new HtmlResponse( $view->render( $view_data ) );
    }

	public function add(): ResponseInterface
	{
		$view_data = array_merge(
            self::getDefaultViewData(),[
			'html_title' => 'Ajouter un logement - AirBnB',
            'type_logements' => RepositoryManager::getRm()->type_logementRepository->findAll()
		]);

		$view = new View( 'logement/add' );

		return new HtmlResponse( $view->render( $view_data ) );


	}

	public function createLogement( ServerRequest $request ): RedirectResponse
	{
		$form_data = $request->getParsedBody();

		$logement_data = [
			'pays' => $form_data[ 'pays' ],
			'adresse' => $form_data[ 'adresse' ],
            'ville' => $form_data[ 'ville' ],
            'prix' => intval($form_data[ 'prix' ]),
            'surface' => $form_data[ 'surface' ],
            'description' => $form_data[ 'description' ],
            'couchage' => $form_data[ 'couchage' ],
            'photo' => $form_data[ 'photo' ],
            'annonceur_id' => intval($form_data[ 'annonceur_id' ]),
            'type_logement_id' => intval($form_data[ 'type_logement_id' ]),
            'titre'=>$form_data['titre']

		];

		RepositoryManager::getRm()->logementRepository->create( new Logement( $logement_data ) );

        return new RedirectResponse( '/' );
	}


    public function mesReservations( ServerRequest $request ): ResponseInterface
    {
        $view_data = array_merge(
            self::getDefaultViewData(),[
            'html_title' => 'Mes reservations - AirBnB',
            'type_logements' => RepositoryManager::getRm()->type_logementRepository->findAll()
        ]);


        $view = new View( 'page/mesreservationsannonceur' );

        return new HtmlResponse( $view->render( $view_data ) );
    }

}