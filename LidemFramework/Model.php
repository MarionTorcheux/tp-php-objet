<?php

namespace LidemFramework;

use PDO;

use App\App;
use LidemFramework\Database\DbConnect;
use LidemFramework\Exception\DatabaseConfigAlreadySetException;
use LidemFramework\Exception\DatabaseConfigNotSetException;

abstract class Model
{
	public int $id;

	// Le constructeur utilise le pattern "Hydrator"
	public function __construct( array $raw_data )
	{
		$class = get_called_class();
		/*
		 * Exemple de données brutes
		 * [ 'id' => 5, 'name' => 'bilbocquet', 'price' => 25.00 ]
		 */
		foreach( $raw_data as $prop => $value ) {
			if( ! property_exists( $class, $prop ) ) {
				continue;
			}

			$this->$prop = $value;
		}
	}

}