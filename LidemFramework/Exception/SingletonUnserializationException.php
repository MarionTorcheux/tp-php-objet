<?php

namespace LidemFramework\Exception;

use Exception;

class SingletonUnserializationException extends Exception
{
	public function __construct()
	{
		parent::__construct( 'Singleton design pattern prevents the use of deserialization' );
	}
}