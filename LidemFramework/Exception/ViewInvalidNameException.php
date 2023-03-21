<?php

namespace LidemFramework\Exception;

use Exception;

class ViewInvalidNameException extends Exception
{
	public function __construct()
	{
		parent::__construct( 'Invalid view name' );
	}
}