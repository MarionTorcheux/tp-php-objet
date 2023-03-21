<?php

namespace App\Model\Repository;

use LidemFramework\Repository;

use App\Model\Equipement;

class EquipementRepository extends Repository
{
	protected function getTable(): string
	{
		return 'equipements';
	}

	protected function getModel(): string
	{
		return Equipement::class;
	}
}