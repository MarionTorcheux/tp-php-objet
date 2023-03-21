<?php

namespace LidemFramework\Database;

// Readonly permet de créer une class en lecture seule,
// c'est à dire que toutes ses propriétés, une fois hydratées par le constructeur,
// ne peuvent être que lues
readonly class DbConfig
{
	public function __construct(
		public string $host,
		public string $name,
		public string $user,
		public string $password
	) { }
}