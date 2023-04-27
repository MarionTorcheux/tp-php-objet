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

    public function create( Reservation $new_reservation): void
    {

        $q = 'INSERT INTO ' . $this->getTable() . ' (logement_id, user_id, date_debut, date_fin) ';
        $q .= 'VALUES (:logement_id, :user_id, :date_debut, :date_fin)';

        $stmt = $this->pdo->prepare($q);

        $stmt->execute([
            'logement_id' => $new_reservation->logement_id,
            'user_id' => $new_reservation->user_id,
            'date_debut' => $new_reservation->date_debut,
            'date_fin' => $new_reservation->date_fin
        ]);
    }

    public function findReservationByIdUser($id)
    {
        $q = 'SELECT  reservations.id, reservations.logement_id, reservations.user_id, reservations.date_debut, reservations.date_fin, logements.titre, logements.photo, logements.description, logements.id  FROM reservations 
              INNER JOIN logements on reservations.logement_id = logements.id
              WHERE reservations.user_id = :id;';

        $stmt = $this->pdo->prepare( $q );

        $stmt->execute([
            'id' => $id
        ]);

        $model = call_user_func([$this,'getModel']);

        while( $data = $stmt->fetch())
        {
            $arr_reservation[] = new $model( $data );
        }

         if(isset($arr_reservation))
         {
            return $arr_reservation;
         } else {

            return[];
         }
    }

}