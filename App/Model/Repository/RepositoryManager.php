<?php

namespace App\Model\Repository;
use PDO;
use LidemFramework\Database\DbConnect;
use LidemFramework\Exception\DatabaseConfigAlreadySetException;
use LidemFramework\Exception\DatabaseConfigNotSetException;
use LidemFramework\Exception\SingletonUnserializationException;
use App\App;

class RepositoryManager
{
	#region Propriétés Singleton
	private static ?self $instance = null;
	#endregion

	public readonly EquipementRepository $equipementRepository;
	public readonly LogementRepository $logementRepository;
	public readonly ReservationRepository $reservationRepository;
	public readonly Type_logementRepository $type_logementRepository;
	public readonly UserRepository $userRepository;

	private function __construct()
	{
		$pdo = $this->getPdo();

		$this->equipementRepository = new EquipementRepository( $pdo );
		$this->logementRepository = new LogementRepository( $pdo );
		$this->reservationRepository = new ReservationRepository( $pdo );
		$this->type_logementRepository = new Type_logementRepository( $pdo );
		$this->userRepository = new UserRepository( $pdo );
	}

	private function getPdo(): ?PDO
	{
		try {
			$pdo = DbConnect::instance()
							->setConfig( App::get()->getDbConfig() )
							->get();
		}
		catch( DatabaseConfigAlreadySetException $e ) {
			// var_dump( $e );
			$pdo = DbConnect::instance()->get();
		}
		catch( DatabaseConfigNotSetException $e ) {
			// var_dump( $e );
			return null;
		}

		return $pdo;
	}


	#region Méthodes Singleton
	public static function getRm(): self
	{
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @throws SingletonUnserializationException
	 */
	public function __wakeup(): void
	{
		throw new SingletonUnserializationException();
	}

	private function __clone(): void { }
	#endregion
}