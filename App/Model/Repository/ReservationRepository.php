<?php

namespace App\Model\Repository;

use LidemFramework\Repository;

use App\Model\Reservation;

class ReservationRepository extends Repository
{
	protected function getTable(): string
	{
		return 'reservations';
	}

	protected function getModel(): string
	{
		return Reservation::class;
	}
}