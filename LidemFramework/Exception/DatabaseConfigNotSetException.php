<?php

namespace LidemFramework\Exception;

use Exception;

class DatabaseConfigNotSetException extends Exception
{
	public function __construct()
	{
		parent::__construct( 'The database connector configuration has not been set' );
	}
}