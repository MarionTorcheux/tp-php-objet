<?php

namespace App\Model\Repository;
use LidemFramework\Repository;
use App\Model\Type_logement;

class Type_logementRepository extends Repository
{
	protected function getTable(): string
	{
		return 'types_logement';
	}

	protected function getModel(): string
	{
		return Type_logement::class;
	}
}