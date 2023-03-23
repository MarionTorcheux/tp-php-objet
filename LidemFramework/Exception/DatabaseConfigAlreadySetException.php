<?php

namespace LidemFramework\Exception;

use Exception;

class DatabaseConfigAlreadySetException extends Exception
{
	public function __construct()
	{
		parent::__construct( 'The database connector configuration has already been set' );
	}
}