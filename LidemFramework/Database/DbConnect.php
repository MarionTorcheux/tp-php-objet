<?php

namespace LidemFramework\Database;

use PDO;

use LidemFramework\Exception\DatabaseConfigAlreadySetException;
use LidemFramework\Exception\DatabaseConfigNotSetException;
use LidemFramework\Exception\SingletonUnserializationException;

class DbConnect
{
	#region Propriétés Singleton
	private static ?self $instance = null;
	#endregion

	private ?PDO $pdo_instance = null;

	private ?DbConfig $config = null;

	/**
	 * @throws DatabaseConfigAlreadySetException
	 */
	public function setConfig( DbConfig $config ): self
	{
		if( ! is_null( $this->config ) ) {
			throw new DatabaseConfigAlreadySetException();
		}

		$this->config = $config;

		return $this;
	}

	/**
	 * @throws DatabaseConfigNotSetException
	 */
	public function get(): PDO
	{
		if( is_null( $this->config ) ) {
			throw new DatabaseConfigNotSetException();
		}

		if( is_null( $this->pdo_instance )) {
			$this->pdo_instance = new PDO(
				dsn: 'mysql:host='. $this->config->host .';dbname='. $this->config->name,
				username: $this->config->user,
				password: $this->config->password,
				options: [
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
				]
			);
		}

		return $this->pdo_instance;
	}

	#region Méthodes Singleton
	public static function instance(): self
	{
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() { }
	private function __clone() { }

	/**
	 * @throws SingletonUnserializationException
	 */
	public function __wakeup() {
		throw new SingletonUnserializationException();
	}
	#endregion
}