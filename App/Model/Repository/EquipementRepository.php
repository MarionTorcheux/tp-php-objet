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

    public function findAllEquipementById(int $id) : ?array
    {
        $q = 'SELECT  equipements.libelle, equipements.id FROM logements 
                    INNER JOIN logement_equipement on logements.id = logement_equipement.logement_id
                    INNER JOIN equipements on logement_equipement.equipement_id = equipements.id
                    WHERE logements.id = :id;';

        $stmt = $this->pdo->prepare( $q );

        $stmt->execute([
            'id' => $id
        ]);



        $model = call_user_func( [ $this, 'getModel' ] );



        while( $data = $stmt->fetch() ) {
            $arr_equipement[] = new $model( $data );
        }
        if(isset($arr_equipement)){
            return $arr_equipement;
        } else {
            return[];
        }

    }
}