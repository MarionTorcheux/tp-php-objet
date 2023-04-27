<?php

namespace App;

use App\Controller\AuthController;
use App\Controller\LogementController;
use App\Controller\ReservationController;
use App\Controller\UserController;
use Exception;
use Throwable;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Routing\Attributes;
use LidemFramework\Database\DbConfig;
use LidemFramework\Exception\SingletonUnserializationException;
use LidemFramework\View;

class App
{
	#region Propriétés du Singleton
	private static ?self $instance = null;
	#endregion

	private const DB_HOST = 'database';
	private const DB_NAME = 'lamp';
	private const DB_USER = 'lamp';
	private const DB_PASS = 'lamp';

	private const AUTH_SALT = '63adb19ca8645514cea5edfb4007102bff2502607860dd42df0cc5ed00bdd90c448cbac8f3c4f8b7d7b835d113ce369bca2b1566df086e0e3948807dbf3dbc4e';
	private const AUTH_PEPPER = '9058fd1b29b795439de7bac81074beccc3315a4ef2328aba50143b869a9bc4a12fa609da1b7675c3053c2ab38a54f79c157fd5e672a4094a96b28611833c7214';
	private ?Router $router = null;

	/**
	 * Démarre l'application
	 *
	 * @return void
	 */
	public function start(): void
	{
        session_start();
		$this->router = Router::create();
		$this->declareRoutes();
		$this->startRouter();
	}

    public function getRouter(): Router
    {
        return $this->router;
    }

	public function getDbConfig(): DbConfig
	{
		return new DbConfig( self::DB_HOST, self::DB_NAME, self::DB_USER, self::DB_PASS );
	}

	public function getSalt(): string { return self::AUTH_SALT; }
	public function getPepper(): string { return self::AUTH_PEPPER; }

	private function declareRoutes(): void
	{
		// Format des paramètres de la route: valeurs int de 1 à 999999999999999999 (18 chiffres)
		$this->router->pattern( 'id', '[1-9]\d{0,18}' );

		// Accueil
		$this->router->get( '/', [LogementController::class, 'index' ]);

        // détail d'un logement
        $this->router->get('/logement/{id}', [LogementController::class, 'show']);

		// Login
		$this->router->group( [ ], function( Router $router ){

		});

        // Partie utilisateur commun
            $this->router->group([Attributes::PREFIX => '/utilisateur'], function( Router $router ){
            $router->get('/ajout', [UserController::class, 'add']);
            $router->post('/ajout', [UserController::class, 'create']);
            $router->get('/connexion', [AuthController::class, 'index']);
            $router->post('/connexion', [AuthController::class, 'login']);
            $router->get('/reserver/{id}', [ReservationController::class, 'reservation']);
            $router->post('/reserver/{id}', [ReservationController::class, 'create']);
            $router->get('/mesreservations', [LogementController::class, 'mesReservations']);

        });

		// Partie Annonceur
		    $this->router->group([Attributes::PREFIX =>'/annonceur'], function(Router $router){
            $router->get('/ajout',[LogementController::class,'add']);
            $router->post('/ajout',[LogementController::class,'createLogement']);
            $router->get('/mesannonces',[LogementController::class,'getAnnoncesById']);
		});
            $this->router->get('/deconnexion',[AuthController::class,'logout']);
	}

	private function startRouter(): void
	{
		try{
			$this->router->dispatch();
		}
		// Cas d'une erreur 404 (URL inexistante)
		catch (RouteNotFoundException $e) {
			$this->router->getPublisher()->publish( View::ErrorResponse( 404, [ 'html_title' => 'Page non trouvée - Ma Super app MVC' ] ) );
		}
		// Les autres cas d'erreur
		catch (Throwable $e) {
            var_dump($e);
			$this->router->getPublisher()->publish( View::ErrorResponse( 500 ) );
		}
	}

	#region Méthodes du Singleton
	/**
	 * Renvoie l'instance unique de App
	 *
	 * @return self
	 */
	public static function get(): self
	{
		if( is_null( self::$instance ) ){
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @throws Exception
	 */
	public function __wakeup() {
		throw new SingletonUnserializationException();
	}
	private function __construct() { }
	private function __clone() { }
	#endregion
}